<?php

namespace App\Http\Controllers\PertanyaanScreening;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\JawabPertanyaanScreeningModel;
use Exception;

class JawabPertanyaanScreeningController extends Controller
{
    public function tampilSemuaJawabanByIdPertanyaan($id){
        $jawaban = DB::table('detail_pertanyaan_screening')->where('id', $id)->value('id');
        if (is_null($jawaban)){
            return response()->json([
                "success" => false,
                "message" => "data not $id found"
            ], 404);
        }
        $db = DB::table('jawab_pertanyaan_screening')
        ->join('detail_pertanyaan_screening', 'detail_pertanyaan_screening.id', 'detail_pertanyaan_screening.id')
        ->select('jawab_pertanyaan_screening.id', 'jawab_pertanyaan_screening.jawaban')
        ->get();
        return response()->json([
            "success" => true,
            "data" => $db
        ], 200);
    }

    public function tampilSemuaJawabanByIdUser($id){
        $jawaban = DB::table('detail_pertanyaan_screening')->where('id', $id)->value('id');
        if (is_null($jawaban)){
            return response()->json([
                "success" => false,
                "message" => "data not $id found"
            ], 404);
        }
        $db = DB::table('jawab_pertanyaan_screening')
        ->join('users', 'users.id', 'users.id')
        ->select('jawab_pertanyaan_screening.id', 'jawab_pertanyaan_screening.jawaban')
        ->get();
        return response()->json([
            "success" => true,
            "data" => $db
        ], 200);
    }


    public function postJawaban(Request $request, $id){
        $pertanyaan = DB::table('detail_pertanyaan_screening')->where('id', $id)->value('id');
        try {
            if ($id != $pertanyaan){
                return response()->json([
                    "success" => false,
                    "message" => "data not found"
                ], 404);
            }
            $jawab = JawabPertanyaanScreeningModel::create($request->all());
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
        $jawaban = JawabPertanyaanScreeningModel::find($id);
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
