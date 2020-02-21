<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MahasiswaModel;

use Validator;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::select('select nim, nama, jurusan from mahasiswa');
        // $mhs = MahasiswaModel::get();
        if (is_null($users)) {
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        return response()->json([
            "success" => true,
            "data" => $users
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nim' => 'required|min:15|max:15',
            'nama' => 'required|min:3',
            'jurusan' => 'required|min:5',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ], 400);
        }
        $mhs = MahasiswaModel::create($request->all());
        return response()->json([
            "success" => true,
            "data" => $mhs
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mhs = MahasiswaModel::find($id);
        if (is_null($mhs)){
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        return response()->json([
            "success" => true,
            "data" => $mhs
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mhs = MahasiswaModel::find($id);
        if(is_null($mhs)){
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        $mhs->update($request->all());
        return response()->json([
            "success" => true,
            "data" => $mhs
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mhs = MahasiswaModel::find($id);
        if(is_null($mhs)){
            return response()->json([
                "success" => false,
                "message" => "data not found"
            ], 404);
        }
        $mhs->delete();
        return response()->json([
            "success" => true,
            "message" => "deleted successfully"
        ], 200);
    }
}
