<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForceLogoutIfSessionDeleted
{

    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (Auth::check()) {
            $session_exists = DB::table('sessions')->where('user_id', Auth::id())->where('id', session()->getId())->exists();

            if (!$session_exists) {
                // TODO: Add the code for Remove the remeber token when the user logged in by rememeber token's
                // if (Auth::viaRemember()) {
                //     $cookieName = 'remember_web_' . Auth::user()->getRememberToken();
                //     Cookie::forget($cookieName);
                // }
                Auth::logout();
                session()->flush();

                return redirect('/login')->withErrors(['message' => "You have Been Logged Out"]);
            }
        }
        return $next($request);
    }
}
