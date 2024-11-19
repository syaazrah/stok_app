<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){

        return view(
            'Auth.login'
        );
    }

    public function login_proses(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8'
        ], [
            'email.required' => 'Email wajib diisi!!!',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak sesuai',

            'password.required' => 'Password Wajib diisi',
            'password.min' => 'password minimal 8 karakter',
        ]);

        $user = User::where('email', $request->email)->first();

        $infoLogin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infoLogin)) {
            return redirect('/dashboard');
        } else {
            return redirect()->back()->withErrors([
                'email' => 'Email tidak sesuai',
                'password' => 'Password Salah'
            ]);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
