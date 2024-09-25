<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Create this view
    }

    public function showRegisterForm()
    {
        return view('auth.register'); // Create this view
    }
    public function showchangePasswordForm()
    {
        return view('auth.forgotPassword'); // Create this view
    }

    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        Auth::login($user);
        return redirect()->intended('/todos');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->intended('/todos'); // Redirect to your desired route after login
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login'); // Redirect to login after logout
    }

    public function changePassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!isset($user)){
            Session::flash('error', 'No such email exists.');
            return redirect()->back();
        }
        $all = $request->all();
        $user->password = Hash::make($all["new-password"]);
        $user->save();
        Session::flash('success', 'Password Changed.');
        return redirect()->back();
    }
}
