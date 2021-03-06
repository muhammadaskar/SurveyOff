<?php

namespace App\Http\Controllers\Pertanyaan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PertanyaanModel;
use App\Model\DetailPertanyaanModel;
use Illuminate\Support\Facades\DB;
use Exception;

class PertanyaanController extends Controller
{

    public function tampilPertanyaan(){
        $pertanyaan = DB::select('select id, pertanyaan_id, pertanyaan from detail_pertanyaan');
        return response()->json([
            "success" => true,
            "data" => $pertanyaan
        ], 200);
    }

    public function tampilById($id){
        $pertanyaan = DetailPertanyaanModel::find($id);
        if (is_null($pertanyaan)){
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        return response()->json([
            "success" => true,
            "data" => $pertanyaan
        ], 200);
    }

    public function tampilPertanyaanByRegistrasiId($id){
        $pertanyaan = DB::table('registrasi_paket')->where('id', $id)->value('id');
        if (is_null($pertanyaan)){
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        $db = DB::table('detail_pertanyaan')
        ->join('registrasi_paket', 'registrasi_paket.id', 'registrasi_paket.id')
        ->select('detail_pertanyaan.id', 'detail_pertanyaan.pertanyaan')
        ->get();
        return response()->json([
            "success" => true,
            "data" => $db
        ], 200);
    }

    public function editPertanyaan(Request $request, $id){
        $pertanyaan = DetailPertanyaanModel::find($id);
        if (is_null($pertanyaan)){
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        $pertanyaan->update($request->all());
        return response()->json([
            "success" => true,
            "data" => $pertanyaan
        ], 201);
    }

    public function postPertanyaan(Request $request, $id){
        $paketId = DB::table('registrasi_paket')->where('id', $id)->value('id');
        try {
            if ($id != $paketId){
                return response()->json([
                    "success" => false,
                    "message" => "data not found"
                ], 404);
            }
            $pertanyaan = DetailPertanyaanModel::create($request->all());
            return response()->json([
                "success" => true,
                "data" => $pertanyaan
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e
            ], 400);
        }
    }

    public function deletePertanyaan($id){
        $pertanyaan = DetailPertanyaanModel::find($id);
        if (is_null($pertanyaan)){
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        $pertanyaan->delete();
        return response()->json([
            "success" => true,
            "message" => "deleted successfully"
        ], 200);
    }


}

// TOOO : TAMPILKAN JAWABAN SEMUA RESPONDEN