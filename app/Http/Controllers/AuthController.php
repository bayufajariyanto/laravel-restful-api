<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transformers\UserTransformer;
use Auth;

class AuthController extends Controller
{
    public function register(Request $request, User $user){
        $this->validate($request, [
            'nama' => 'required|string',
            'username' => 'required|unique:users',
            'password' => 'required|same:konfirmasi_password',
            'konfirmasi_password' => 'required',
            'email' => 'required|email|unique:users',
            'no_hp' => 'required|unique:users',
            'alamat' => 'required'
        ]);

        $token = bcrypt($request->email);
        $user->create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'desc' => $request->desc,
            'api_token' => $token
        ]);

        return response()->json([
            'message' => 'success',
        ], 201);
        // return fractal()
        //     ->item($user)
        //     ->transformWith(new UserTransformer)
        //     ->toArray();
    }

    public function login(Request $request, User $user){
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return response()->json(['error' => 'Your credential is wrong'], 401);
        }

        $user = $user->find(Auth::user()->id);
        return response()->json([
            'message' => $user->name. ' has successfully logged in',
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'token' => $user->api_token,
                'registered' => $user->created_at->diffForHumans()
            ]
        ]);
    }
}
