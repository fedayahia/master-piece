<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!$request->user()) {
            return abort(403, 'Unauthorized');
        }

      if ($request->user()->role !== $role) {
            return abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
