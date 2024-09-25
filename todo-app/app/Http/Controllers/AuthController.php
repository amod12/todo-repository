<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\VerificationCode;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

    public function showchangePasswordForm1()
    {
        return view('auth.sendEmail'); // Create this view
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


    
    public function changePassword1(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $email = $request->input('email');
        $code = mt_rand(100000, 999999); // Generate a random 6-digit code

        $user = User::where('email', $email)->first();
        if(!isset($user)){
            Session::flash('error', 'No such email exists.');
            return redirect()->back();
        }
        // Store the verification code in the database
        VerificationCode::create([
            'email' => $email,
            'user_id' => $user->id, // Assuming you have user authentication
            'code' => $code,
        ]);
        session(['user_id' => $user->id]);
        // Send the email
        Mail::to($email)->send(new VerificationCodeMail($code, $email));
    
        return view('auth.forgotPassword');
    
    }
    public function changePassword(Request $request)
    {
        $userId = session('user_id');
        $user = User::where('id', $userId)->first();

        if(!isset($user)){
            Session::flash('error', 'No such email exists.');
            return redirect()->back();
        }
        $code = VerificationCode::where('user_id', $userId)->latest()->first();
        
        
        $all = $request->all();
        if ($code->code !== $all['code']) {
            Session::flash('error', 'Code does not match.');
            return redirect()->to(url()->current());
        }
        $user->password = Hash::make($all["new-password"]);
        $user->save();
        Session::flash('success', 'Password Changed.');
        return redirect()->route('login');
    }
}
