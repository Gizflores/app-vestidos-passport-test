<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request){
        $validatedData = $request->validate([
            'name'=>'required|max:55',
            'email'=>'email|required',
            'password'=>'required|confirmed',

        ]);
        $validatedData['password']= bcrypt($request->password);
        
        $user = User::create($validatedData);
        $accessToken= $user->createToken('authToken')->accessToken;
        return response(['user' => $user,'accessToken' => $accessToken,'Registro satisfactiorio']);
    }

    public function login(Request $request){
        $loginData = $request -> validate([
            'email'     => 'email|required',
            'password'  => 'required'
        ]);
        if(!auth()->attempt($loginData)){
            return response(['message'=>'invalid credentials']);
        }
        // $user = User::create($validatedData);
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response(['user'=>auth()->user(), 'access_token' => $accessToken]);
        
    }
}
