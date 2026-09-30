<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class RoleMiddleware {
    public function handle(Request $request, Closure $next, string ...$roles) {
        $user = $request->user();
        abort_unless($user && ($user->role === 'admin' || in_array($user->role, $roles)), 403, 'Accès non autorisé.');
        return $next($request);
    }
}
