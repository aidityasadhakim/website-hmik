<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title' => 'Login',
            'active' => 'login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        // dd($credentials);

        $user = User::where('email', $credentials['email'])
                  ->where('password',md5($credentials['password']))
                  ->first();
        // dd($user);
        if($user){
            Auth::login($user);
            return redirect()->intended('/dashboard');
        }

        // if(Auth::attempt($credentials)) {
        //     $request->session()->regenerate();
        //     return redirect()->intended('/dashboard');
        // }

        return back()->with('loginError', 'Login failed!');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/');
    }
}
