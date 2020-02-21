<?php

namespace App\Http\Controllers\Paket;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\JenisPaketModel;


class JenisPaketController extends Controller
{
    
    public function tampilJenisPaket(){
        $paket = DB::select('select id, jumlah_pertanyaan, jumlah_hari, pendapatan from jenis_paket');
        return response()->json([
            "success" => true,
            "data" => $paket
        ], 200);   
    }

    public function tambahPaket(Request $request){
        $paket = JenisPaketModel::create($request->all());
        return response()->json([
            "success" => true,
            "data" => $paket
        ], 201);
    }

    public function editPaket(Request $request, $id){
        $paket = JenisPaketModel::find($id);
        if (is_null($paket)){
            return response()->json([
                "success" => true,
                "message" => "data not found"
            ], 404);
        }
        $paket->update($request->all());
        return response()->json([
            "success" => true,
            "data" => $paket
        ], 201);
    }

}
