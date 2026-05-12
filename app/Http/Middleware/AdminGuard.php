<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class AdminGuard {
    public function handle(Request $request, Closure $next) {
        if (!session('admin_auth')) {
            if ($request->expectsJson() || $request->ajax() ||
                str_contains($request->header('Accept', ''), 'application/json')) {
                return response()->json(['message' => 'Session expired. Please refresh the page.'], 401);
            }
            return redirect()->route('admin.login');
        }
        return $next($request);
    }
}
