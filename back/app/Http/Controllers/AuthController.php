<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){
        $token = auth('api')->attempt($request->all(['email','password']));
        if ($token){
            return response()->json(['token' => $token]);
        }else{
            return response()->json(['message' => 'Usuário ou senha inválido!']);
        }
    }

    public function logout(){
        $token = auth('api')->logout();
        return response()->json(['message' => 'Você foi desconectado!']);
    }

    public function refresh(){
        $token = auth('api')->refresh();
        return response()->json(['token' => $token]);
    }

    public function me(){
        return response()->json(auth()->user());
    }
}
