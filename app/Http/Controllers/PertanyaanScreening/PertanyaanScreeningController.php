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

    public function tampilSemuaPertanyaanByRegistrasiId($id){
        $pertanyaan = DB::table('registrasi_paket')->where('id', $id)->value('id');
        if (is_null($pertanyaan)){
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        $db = DB::table('detail_pertanyaan_screening')
        ->join('registrasi_paket', 'registrasi_paket.id', '=', "$id")
        ->select('detail_pertanyaan_screening.id', 'detail_pertanyaan_screening.pertanyaan')
        ->get();
        return response()->json([
            "success" => true,
            "data" => $db
        ], 200);
    }

    public function postPertanyaanScreening(Request $request, $id){
        $paketId = DB::table('registrasi_paket')->where('id', $id)->value('id');
        try {
            if ($id != $paketId){
                return response()->json([
                    "success" => false,
                    "message" => "paket not found"
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
        $pertanyaan = DetailPertanyaanScreeningModel::find($id);
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
        $pertanyaan = DetailPertanyaanScreeningModel::find($id);
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
