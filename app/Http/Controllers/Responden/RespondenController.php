<?php

namespace App\Http\Controllers\Responden;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\RespondenModel;
use Illuminate\Support\Facades\DB;
use Exception;

class RespondenController extends Controller
{
    public function tampilSemuaResponden(){
        $responden = DB::select('select user_id, no_rek, type_rek from responden');
        return response()->json([
            "success" => true,
            "data" => $responden
        ], 200);
    }

    public function postResponden(Request $request, $id){
        $user = DB::table('users')->where('id', $id)->value('id');
        try {
            if ($id != $user){
                return response()->json([
                    "success" => false,
                    "message" => "data not found"
                ], 404);
            }
            $responden = RespondenModel::create($request->all());
            return response()->json([
                "success" => true,
                "data" => $responden
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Terjadi Kesalahan Pada $e"
            ], 500);
        }
    }

    public function getRespondenById($id){
        $responden = RespondenModel::find($id);
        if (is_null($responden)){
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        return response()->json([
            "success" => true,
            "data" => $responden
        ], 200);
    }

    public function editRespondenBydId(Request $request, $id){
        $responden = RespondenModel::find($id);
        if (is_null($responden)){
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        $responden->update($request->all());
        return response()->json([
            "success" => true,
            "data" => $responden
        ], 200);
    }

    public function deleteResponden($id){
        $responden = RespondenModel::find($id);
        if (is_null($responden)){
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        $responden->delete();
        return response()->json([
            "success" => true,
            "message" => "deleted successfully"
        ], 200);
    }
}
