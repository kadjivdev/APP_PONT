<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->username, // ou adaptez selon votre logique d'authentification
            'password' => $request->password
        ];

        if (Auth::attempt($credentials) && Auth::user()->is_active) {
            return redirect()->route('ventes.index');
        }
        return back()->withErrors(['username' => 'Identifiants incorrectes.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
