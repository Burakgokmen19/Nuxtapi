<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Nette\Schema\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $user = \App\Models\User::where('email',$request->email)->first();
        if (!$user) {
            throw  ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            'token'=>$token
        ]);
    }
    public function register(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $user = new User;
        $user->name = 'aynı'; // Burada kullanıcı adını istediğiniz bir değerle değiştirin
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();



        return response()->json(['message' => 'Kayıt başarılı'], 201);
    }
}
