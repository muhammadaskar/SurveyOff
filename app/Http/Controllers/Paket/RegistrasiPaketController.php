<?php

namespace App\Http\Controllers\Paket;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Veritrans_Config;
use Veritrans_Snap;
use Veritrans_Notification;
use App\Model\RegistrasiPaketModel;
use Exception;


class RegistrasiPaketController extends Controller
{
    protected $request;

    
    public function __construct(Request $request)
    {
        $this->request = $request;

        // Set midtrans configuration
        Veritrans_Config::$serverKey = config('services.midtrans.serverKey');
        Veritrans_Config::$isProduction = config('services.midtrans.isProduction');
        Veritrans_Config::$isSanitized = config('services.midtrans.isSanitized');
        Veritrans_Config::$is3ds = config('services.midtrans.is3ds');
    }

    public function index()
    {
        return view('registrasi');
    }

    public function submitRegist()
    {
        DB::transaction(function(){

            $regist = RegistrasiPaketModel::create($this->request->all());

            // Buat transaksi ke midtrans kemudian save snap tokennya.
            $payload = [
                'transaction_details' => [
                    'order_id'      => $regist->id,
                    'gross_amount'  => $regist->amount,
                ],
                'customer_details' => [
                    'first_name'    => $regist->name,
                    'email'         => $regist->email,
                ],
                'item_details' => [
                    [
                        'id'       => $regist->id,
                        'price'    => $regist->amount,
                        'quantity' => 1,
                        'name'     => $regist->judul
                    ]
                ]
            ];
            $snapToken = Veritrans_Snap::getSnapToken($payload);
            $regist->snap_token = $snapToken;
            $regist->save();

            // Beri response snap token
            $this->response['snap_token'] = $snapToken;
        });

        return response()->json($this->response);
        
    }
    public function notificationHandler(Request $request)
    {
        $notif = new Veritrans_Notification();
        DB::transaction(function() use($notif) {

            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $orderId = $notif->order_id;
            $fraud = $notif->fraud_status;
            $regist = RegistrasiPaketModel::findOrFail($orderId);

            if ($transaction == 'capture') {

            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {

                if($fraud == 'challenge') {
                // TODO set payment status in merchant's database to 'Challenge by FDS'
                // TODO merchant should decide whether this transaction is authorized or not in MAP
                // $donation->addUpdate("Transaction order_id: " . $orderId ." is challenged by FDS");
                $regist->setPending();
                } else {
                
                $regist->setSuccess();
                }

            }

            } elseif ($transaction == 'settlement') {

            // TODO set payment status in merchant's database to 'Settlement'
            // $donation->addUpdate("Transaction order_id: " . $orderId ." successfully transfered using " . $type);
            $regist->setSuccess();

            } elseif($transaction == 'pending'){

            // TODO set payment status in merchant's database to 'Pending'
            // $donation->addUpdate("Waiting customer to finish transaction order_id: " . $orderId . " using " . $type);
            $regist->setPending();

            } elseif ($transaction == 'deny') {

            // TODO set payment status in merchant's database to 'Failed'
            // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is Failed.");
            $regist->setFailed();

            } elseif ($transaction == 'expire') {

            // TODO set payment status in merchant's database to 'expire'
            // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is expired.");
            $regist->setExpired();

            } elseif ($transaction == 'cancel') {

            // TODO set payment status in merchant's database to 'Failed'
            // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is canceled.");
            $regist->setFailed();

            }

        });

        return;
    }

    public function tampil(){
        $list = DB::select('select * from registrasi_paket');
        // $list = DB::select('select id from registrasi_paket');
        return response()->json([
            "success" => true,
            "data" => $list
        ], 200);
    }

    // public function addRegistPaket(Request $request, $id){
    //     $usersId = DB::table('users')->where('id', $id)->value('id');
    //     try{
    //         if($id != $usersId){
    //             return response()->json([
    //                 "success" => false,
    //                 "message" => "user not found"
    //             ], 404);
    //         } else {
    //             $paket = RegistrasiPaketModel::create($request->all());
    //             return response()->json([
    //                 "success" => true,
    //                 "data" => $paket
    //             ], 201);
    //         }
    //     }catch(Exception $e){
    //         return response()->json([
    //             "success" => false,
    //             "message" => $e
    //         ], 400);
    //     }
    // }

}
