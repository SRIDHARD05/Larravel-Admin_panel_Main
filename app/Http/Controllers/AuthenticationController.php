<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function register()
    {
        return view('register');
    }

    public function register_store(Request $request)
    {
        $agree = $request->has('agree');
        if ($agree) {
            $cred = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:5|confirmed',
            ]);

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            $cred['password'] = bcrypt($cred['password']);

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        } else {
            return back()->withErrors([
                'agree' => 'You must agree to the terms and conditions to proceed.',
            ]);
        }
    }
    public function login_store(Request $request)
    {
        $credentials =  $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $email = $request->input('email');

        if (Auth::attempt($credentials, $request->input('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        } else {
            return back()->withErrors(['email' => 'Invalid credentials provided.']);
        }
    }
    public function logout(Request $request)
    {
        $user = Auth::user();

        if (Auth::viaRemember()) {
            Cookie::queue(Cookie::forget(Auth::getRecallerName()));

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('dashboard');
        } else {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('dashboard');
        }
    }

    public function logout_all_devices(Request $request)
    {
        // TODO: Add the code for Remove the remeber token when the user logged in by rememeber token's
        $user = Auth::user();

        DB::table('sessions')->where('user_id', $user->id)->where('id', '!=', session()->getId())->delete();

        if (Auth::viaRemember()) {
            $remeber_token = Auth::user()->getRememberToken();
            DB::table('users')->where('id', $user->id)->update(['remember_token' => $remeber_token]);
        } else {
            DB::table('users')->where('id', $user->id)->update(['remember_token' => null]);
        }
        return redirect()->intended(route('profile.index'))->with('message', 'Logout from all devices was successful!');
    }
}
