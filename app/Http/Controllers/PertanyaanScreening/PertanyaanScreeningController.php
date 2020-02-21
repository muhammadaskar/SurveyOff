<?php

namespace App\Http\Controllers\PertanyaanScreening;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DetailPertanyaanScreeningModel;
use Illuminate\Support\Facades\DB;
use Exception;

class PertanyaanScreeningController extends Controller
{
    
    public function tampilPertanyaanScreening(){
        $pScreening = DB::select('select id, pertanyaan_id, pertanyaan from detail_pertanyaan_screening');
        return response()->json([
            "success" => true,
            "data" => $pScreening
        ], 200);
    }

    public function postPertanyaanScreening(Request $request, $id){
        $paketId = DB::table('pertanyaan')->where('id', $id)->value('id');
        try {
            if ($id != $paketId){
                return response()->json([
                    "success" => false,
                    "message" => "data not found"
                ], 404);
            }
            $pertanyaan = DetailPertanyaanScreeningModel::create($request->all());
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

    public function editPertanyaanScreening(Request $request, $id){
        $pertanyaan = PertanyaanScreeningModel::find($id);
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

    public function hapusPertanyaanScreening($id){
        $pertanyaan = PertanyaanScreeningModel::find($id);
        if (is_null($pertanyaan)){
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        $pertanyaan->delete();
        return response()->json([
            "success" => false,
            "message" => "deleted successfully"
        ], 200);

    }

}
