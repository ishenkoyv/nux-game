<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Model\Link;

class LinkIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $link = $request->route('link');

        if ($link && ($link->isExpired() || !$link->is_active)) {
            $message = 'Link is expired.';
            return new Response(view('dashboard.errorMessage', ['message' => $message]), 401);
        }

        return $next($request);
    }
}
