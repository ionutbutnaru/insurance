<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = session('expire_token');
        if(! $token ) {
            return redirect()->route('login');
        }

        $lastToken = auth()->user()->tokens->last();

        if(!$lastToken) {
            return redirect()->route('login');
        }

        $token = $lastToken->token;
        $expiresAt = $lastToken->expires_at;

        if($token !==  $token) {
            return response()->json(['message' => 'Tokens are not matching'], 401);
        }

        if($expiresAt < Carbon::now()) {
            auth()->user()->tokens()->delete();
            return redirect()->route('login');
        }

        return $next($request);
    }
}
