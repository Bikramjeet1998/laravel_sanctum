<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class CustomAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('sanctum')->check()) {
            return response()->json(['message' => 'Unauthorised User'], 403);
        }
        return $next($request);
    }
}
