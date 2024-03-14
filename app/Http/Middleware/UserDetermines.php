<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserDetermines
{

    public function handle(Request $request, Closure $next): Response
    {   
        $userId = $request->route('user'); 
        if ($userId->id != auth()->id()) {
            abort(403, 'Unauthorized action');
        }
        return $next($request);
    }
}
