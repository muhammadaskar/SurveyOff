<?php

namespace App\Http\Controllers\Pertanyaan;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\JawabPertanyaanModel;
use Exceptioon;

class JawabPertanyaanController extends Controller
{
    
    public function tampilSemuaJawabanByIdPertanyaan($id){
        $jawaban = DB::table('detail_pertanyaan')->where('id', $id)->value('id');
        if (is_null($jawaban)){
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        $db = DB::table('jawab_pertanyaan')
        ->join('detail_pertanyaan', 'detail_pertanyaan.id', 'detail_pertanyaan.id')
        ->select('jawab_pertanyaan.id', 'jawab_pertanyaan.jawaban')
        ->get();
        return response()->json([
            "success" => true,
            "data" => $db
        ], 200);
    }

    public function postJawaban(Request $request, $id){
        $pertanyaan = DB::table('detail_pertanyaan')->where('id', $id)->value('id');
        try {
            if ($id != $pertanyaan){
                return response()->json([
                    "success" => false,
                    "message" => "data not found"
                ], 404);
            }
            $jawab = JawabPertanyaanModel::create($request->all());
            return response()->json([
                "success" => true,
                "data" => $jawab
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Terjadi Kesalahan Pada $e"
            ], 500);
        }
    }

    public function getJawabanById($id){
        $jawaban = JawabPertanyaanModel::find($id);
        if (is_null($jawaban)){
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        return response()->json([
            "success" => true,
            "data" => $jawaban
        ], 200);
    }
}
