<?php

namespace App\Http\Controllers\Paket;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\RegistrasiPaketModel;
use Exception;

use Veritrans_Config;
use Veritrans_Snap;
use Veritrans_Notification;

class RegistrasiPaketController extends Controller
{

        /**
     * Make request global.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Class constructor.
     *
     * @param \Illuminate\Http\Request $request User Request
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        // Set midtrans configuration
        Veritrans_Config::$serverKey = config('services.midtrans.serverKey');
        Veritrans_Config::$isProduction = config('services.midtrans.isProduction');
        Veritrans_Config::$isSanitized = config('services.midtrans.isSanitized');
        Veritrans_Config::$is3ds = config('services.midtrans.is3ds');
    }

    /**
     * Show index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('registrasi');
    }

    /**
     * Submit donation.
     *
     * @return array
     */
    public function submitRegist()
    {
        try{
            DB::transaction(function(){
                // Save donasi ke database
                // $donation = RegistrasiPaketModel::create([
                //     'name' => $this->request->name,
                //     'email' => $this->request->email,
                //     'user_id' => $this->request->user_id,
                //     'paket_id' => $this->request->paket_id,
                //     'jumlah_responden' => $this->request->jumlah_responden,
                //     'amount' => floatval($this->request->amount),
                // ]);
    
                $donation = RegistrasiPaketModel::create($this->request->all());
    
                // Buat transaksi ke midtrans kemudian save snap tokennya.
                $payload = [
                    'transaction_details' => [
                        'order_id'      => $donation->id,
                        'gross_amount'  => $donation->amount,
                    ],
                    'customer_details' => [
                        'first_name'    => $donation->name,
                        'email'         => $donation->email,
                    ],
                    'item_details' => [
                        [
                            'id'       => $donation->id,
                            'price'    => $donation->amount,
                            'quantity' => 1,
                            // 'name'     => ucwords(str_replace('_', ' ', $donation->name))
                            'name'     => $donation->name
                        ]
                    ]
                ];
                $snapToken = Veritrans_Snap::getSnapToken($payload);
                $donation->snap_token = $snapToken;
                $donation->save();
    
                // Beri response snap token
                $this->response['snap_token'] = $snapToken;
            });
            return response()->json(
                $this->response
            );
        } catch(Exception $e){
            return response()->json([
                "success" => false,
                "error" => $e
            ]);
        }
        
    }

    /**
     * Midtrans notification handler.
     *
     * @param Request $request
     * 
     * @return void
     */
    public function notificationHandler(Request $request)
    {
        $notif = new Veritrans_Notification();
        DB::transaction(function() use($notif) {

            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $orderId = $notif->order_id;
            $fraud = $notif->fraud_status;
            $donation = RegistrasiPaketModel::findOrFail($id);

            if ($transaction == 'capture') {

            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {

                if($fraud == 'challenge') {
                // TODO set payment status in merchant's database to 'Challenge by FDS'
                // TODO merchant should decide whether this transaction is authorized or not in MAP
                // $donation->addUpdate("Transaction order_id: " . $orderId ." is challenged by FDS");
                $donation->setPending();
                } else {
                // TODO set payment status in merchant's database to 'Success'
                // $donation->addUpdate("Transaction order_id: " . $orderId ." successfully captured using " . $type);
                $donation->setSuccess();
                }

            }

            } elseif ($transaction == 'settlement') {

            // TODO set payment status in merchant's database to 'Settlement'
            // $donation->addUpdate("Transaction order_id: " . $orderId ." successfully transfered using " . $type);
            $donation->setSuccess();

            } elseif($transaction == 'pending'){

            // TODO set payment status in merchant's database to 'Pending'
            // $donation->addUpdate("Waiting customer to finish transaction order_id: " . $orderId . " using " . $type);
            $donation->setPending();

            } elseif ($transaction == 'deny') {

            // TODO set payment status in merchant's database to 'Failed'
            // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is Failed.");
            $donation->setFailed();

            } elseif ($transaction == 'expire') {

            // TODO set payment status in merchant's database to 'expire'
            // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is expired.");
            $donation->setExpired();

            } elseif ($transaction == 'cancel') {

            // TODO set payment status in merchant's database to 'Failed'
            // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is canceled.");
            $donation->setFailed();

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

    public function addRegistPaket(Request $request, $id){
        $usersId = DB::table('users')->where('id', $id)->value('id');
        try{
            if($id != $usersId){
                return response()->json([
                    "success" => false,
                    "message" => "user not found"
                ], 404);
            } else {
                $paket = RegistrasiPaketModel::create($request->all());
                return response()->json([
                    "success" => true,
                    "data" => $paket
                ], 201);
            }
        }catch(Exception $e){
            return response()->json([
                "success" => false,
                "message" => $e
            ], 400);
        }
    }

    




}
