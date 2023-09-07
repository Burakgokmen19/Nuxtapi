<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Nette\Schema\ValidationException;

class AuthController extends Controller
{

    /**
     * @throws AuthenticationException
     */
    public function login(Request $request): void
    {

        if (auth()->attempt($request->only('email','password'))) {
            throw new AuthenticationException();
        }

//        $request->validate([
//            'email' => 'required|email',
//            'password' => 'required',
//        ]);
//
//        $userData = $request->only('email', 'password');
//
//        if (Auth::attempt($userData)) {
//            $user = Auth::user();
//            return response()->json([
//                'data' => $request->user(),
//            ]);
//        }
//        return response()->json(['message' => 'kullanıcı yok'], 401);
    }

    public function register(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $user = new User;
        $user->name = 'aynı';
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();


        return response()->json(['message' => 'Kayıt başarılı'], 201);
    }
}
