<?php

namespace App\Http\Controllers\Hasil;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\JawabPertanyaanModel;
use App\Model\JawabPertanyaanScreeningModel;
use Exceptioon;

class HasilController extends Controller
{
    
    public function tampilJawabanDanPertanyaanByIdPertanyaan($id){
        $jawaban = DB::table('detail_pertanyaan')->where('id', $id)->value('id');
        if (is_null($jawaban)){
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        $db = DB::table('jawab_pertanyaan')
        ->join('detail_pertanyaan', 'detail_pertanyaan.id', 'detail_pertanyaan.id')
        ->select('detail_pertanyaan.pertanyaan', 'jawab_pertanyaan.jawaban')
        ->get();
        return response()->json([
            "success" => true,
            "data" => $db
        ], 200);
    }

    public function tampilJawabanDanPertanyaanByIdUser($id){
        $jawaban = DB::table('users')->where('id', $id)->value('id');
        if (is_null($jawaban)){
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        $db = DB::table('jawab_pertanyaan')
        ->join('users', 'users.id', 'users.id')
        ->select('users.id', 'jawab_pertanyaan.jawaban')
        ->get();
        return response()->json([
            "success" => true,
            "data" => $db
        ], 200);
    }

    public function deleteJawabanById($id){
        $jawaban = JawabPertanyaanModel::find($id);
        if (is_null($jawaban)){
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        $jawaban->delete();
        return response()->json([
            "success" => true,
            "message" => "deleted successfully"
        ], 200);
    }



}
