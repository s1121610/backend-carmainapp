<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use Laravel\Sanctum\HasApiTokens;
use Hash;

class LoginController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);
     
        $user = User::where('email', $request->email)->first();
     
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
     
        //return $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'user' => $request->user(),
            'token' => $user->createToken($request->device_name)->plainTextToken
        ]);
    }

    public function logout(Request $request){
        return $request->user()->currentAccessToken()->delete();
    }

    public function user (Request $request) {
        return $request->user();
    }

    public function userID (Request $request) {
        return $request->user()->id;
    }
}