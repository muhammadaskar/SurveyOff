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
                return response()->json([
                    'error'=> $validator->errors()
                ], 401);            
            }
            
            $input = $request->all(); 

            $fileName = $input['ktm'] .".jpg";
            $path = $request->file('ktm')->move(public_path('/ktm'), $fileName);
            $photoURL = url('/'.$fileName);

            $input['password'] = bcrypt($input['password']); 
            $user = User::create($input); 
            $success['name'] =  $user->name;
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            return response()->json([
                'success'=> true,
                'ktm' => $photoURL,
                'data' => $success
            ], 200); 
        }catch(Exception $e){
            return response()->json([
                "success" => false,
                "message" => "Terjadi kesalahan pada $e"
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
                'success' => false,
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

    public function uploadFoto(Request $request){
        $fileName = "userImage.jpg";
        $path = $request->file('photo')->move(public_path('/'), $fileName);
        $photoURL = url('/'.$fileName);
        return response()->json([
            "success" => true,
            "url" => $fileName
        ], 201);
        
    }



}
