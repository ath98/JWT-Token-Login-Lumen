<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use  App\Auths;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller{
    public function register(Request $request){
        $this->validate($request,[
            'name'=>'required|string',
            'password'=>'required|string',
        ]);

        try{
            $auth = new Auths;
            $auth->name = $request->input('name');
            $pass = $request->input('password');
            $auth->password = app('hash')->make($pass);
            $auth->save();

            return response()->json('User created');
        }catch(Exception $e){
            return response()->json('Not created');
        }
    }

    public function login(Request $request){
        $this->validate($request,[
            'name'=>'required|string',
            'password'=>'required|string',
        ]);

        $credentials = $request->only(['name','password']);

        if(Auth::attempt($credentials)){
            return response()->json('Authorized');
        }
        return $this->respondWithToken('failed');
    }
}