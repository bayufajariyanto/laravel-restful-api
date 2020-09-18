<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;
use Auth;
class UserController extends Controller
{
    public function users(User $user){
        $users = $user->all();
        // return response()->json($users);
        return fractal()
            ->collection($users)
            ->transformWith(new UserTransformer)
            ->toArray();
    }

    public function profile(User $user){
        $user = $user->find(Auth::user()->id);
        // dd($user);
        return response()->json([
            'message' => 'success',
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'token' => $user->api_token,
                'registered' => $user->created_at->diffForHumans()
            ]
        ]);
    }
}
