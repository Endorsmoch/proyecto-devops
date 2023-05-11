<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illiuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogMethodCalls
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $method = $request->route()->getActionMethod();
        $parameters = $request->route()->parameters();

        Log::debug("Method Call: $method(". json_encode($parameters) .")");
        return $next($request);
    }
}
