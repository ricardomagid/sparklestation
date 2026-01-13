<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle user registration
     */
    public function register(Request $request) 
    {
        // Validate the request
        $request->validate([
            'username' => 'required|string|min:3|max:20|regex:/^[a-zA-Z0-9_]+$/|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed'
        ]);

        // Create the User
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        // Redirect to home page
        return redirect()->route('home')->with('success', 'Account created successfully!');
    }

    /**
     * Shows the register form
     */
    public function showRegisterForm() 
    {
        return view('auth.register');
    }

    /**
     * Handle the login logic
     */
    public function login(Request $request) 
    {
        // Validate the login credentials
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->intended(route('home'))->with('success', 'Login Successful!');
        }

        // Authetication failed
        return back()->withErrors(['email' => 'Incorrect email or password.']);
    }

    /**
     * Shows the login form
     */
    public function showLoginForm() 
    {
        return view('auth.login');
    }

    /**
     * Handle the logout logic
     */
    public function logout(Request $request)
    {
        auth()->logout();

        //Redirect to the previous page or to the login page if not available
        return redirect()->back()->with('success', 'Logout successful') ?? redirect('/login')->with('success', 'Logout successful');
    }      

    /**
     * Handles the change password logic
     */
    public function changePassword(Request $request) 
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'new_password' => 'required|string|min:8|confirmed',
            'verification_code' => 'required|numeric|min:6'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user->verification_code) {
            return back()->withErrors(['code' => 'No verification code found.']);
        }

        if ($request->verification_code != $user->verification_code) {
            return back()->withErrors(['code' => 'Invalid verification code.']);
        }

        if (now()->isAfter($user->verification_code_expires_at)) {
            return back()->withErrors(['code' => 'Verification code has expired.']);
        }

        // Clear verification code and update password
        $user->verification_code = null;
        $user->verification_code_expires_at = null;
        $user->email_verified_at = now();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('home')->with('success', 'Your password has been changed successfully.');
    }
}
