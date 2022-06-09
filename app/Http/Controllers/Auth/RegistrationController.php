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

class RegistrationController extends Controller{
    public function register(Request $request){
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'device_name' => ['required']
        ]);

        $user = User::create([
            'name' => $request->name,
            'license_plate' => $request->licenceplate,
            'email' =>  $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->save();
        
        return $user->createToken($request->device_name)->plainTextToken;
    }
}
