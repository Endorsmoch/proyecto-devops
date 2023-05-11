<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminatte\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogApiCalls
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $verb = $request->method();
        $apiName = $request->route()->getName();
        $queryParams = $request->query();
        $headers = $request->headers->all();

        Log::info("API Call: Verb:$verb, API:$apiName, QueryParams: ".json_encode($queryParams).", Headers:".json_encode($headers));

        return $next($request);
    }
}
