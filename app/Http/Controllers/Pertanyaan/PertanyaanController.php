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
    
    public function tampilJudulDeskripsi($id){
        $pertanyaan = PertanyaanModel::find($id);
        if (is_null($pertanyaan)){
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        return response()->json([
            "success" => false,
            "data" => $pertanyaan
        ], 200);
    }

    public function addJudulDeskripsi(Request $request, $id){
        $paketId = DB::table('registrasi_paket')->where('id', $id)->value('id');
        try {
            if ($id != $paketId){
                return response()->json([
                    "success" => false,
                    "message" => "data not found"
                ], 404);
            }
            $pertanyaan = PertanyaanModel::create($request->all());
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

    public function editJudulDeskripsi(Request $request, $id){
        $pertanyaan = PertanyaanModel::find($id);
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

    public function tampilPertanyaan(){
        $pertanyaan = DB::select('select id, pertanyaan_id, pertanyaan from detail_pertanyaan');
        return response()->json([
            "success" => true,
            "data" => $pertanyaan
        ], 200);
    }

    public function postPertanyaan(Request $request, $id){
        $paketId = DB::table('pertanyaan')->where('id', $id)->value('id');
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
