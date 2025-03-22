<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpFoundation\Response;

class VerifyCsrfTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (TokenMismatchException $exception) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Sessão expirada. Faça login novamente.'], Response::HTTP_UNAUTHORIZED);
            }
            return redirect()->route('filament.admin.auth.login')->withErrors([
                'email' => 'Sua sessão expirou. Faça login novamente.',
            ]);
        }
    }
}
