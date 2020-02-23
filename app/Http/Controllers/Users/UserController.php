<?php

namespace App\Http\Controllers\Users;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 
use Validator;
use Exception;

class Usercontroller extends Controller
{
    
    public function tampilUsers(){
        $user = UserModel::get();
        return response()->json([
            "success" => true,
            "data" => $user
        ], 200);
    }

    public function register(Request $request){ 
        try{
            $validator = Validator::make($request->all(), [ 
                'name' => 'required', 
                'email' => 'required|email', 
                'password' => 'required'
            ]);
            if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
            }
            $input = $request->all(); 
            $input['password'] = bcrypt($input['password']); 
            $user = User::create($input); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['name'] =  $user->name;
            return response()->json([
                'success'=> true,
                'data' => $success
            ], 200); 
        }catch(Exception $e){
            return response()->json([
                "success" => false,
                "message" => $e
            ], 400);
        }
    }

    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            return response()->json([
                'success' => $success
            ], 200); 
        } 
        else{ 
            return response()->json([
                'error'=>'Unauthorised'
            ], 401); 
        } 
    }

    public function findUserById($id){
        $user = User::find($id);
        if (is_null($user)){
            return response()->json([
                "success" => false,
                "meesage" => "data not found"
            ], 404);
        }
        return response()->json([
            "success" => true,
            "data" => $user
        ], 200);
    }

    public function editUser(Request $request, $id){
        $user = User::find($id);
        if (is_null($user)){
            return response()->json([
                "success" => false,
                "meesage" => "data not found"
            ], 404);
        }
        $user->update($request->all());
        return response()->json([
            "success" => true,
            "data" => $user
        ], 201);
    }

    public function deleteUser($id){
        $user = UserModel::find($id);
        if (is_null($user)){
            return response()->json([
                "success" => false,
                "meesage" => "data not found"
            ], 404);
        }
        $user->delete();
        return response()->json([
            "success" => true,
            "data" => "deletd successfully"
        ], 200);
    }



}
