<?php

namespace App\Http\Controllers\Paket;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\RegistrasiPaketModel;
use Exception;

class RegistrasiPaketController extends Controller
{
    

    public function tampil(){
        $list = DB::select('select id, user_id, paket_id, jumlah_responden, bukti_bayar from registrasi_paket');
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
