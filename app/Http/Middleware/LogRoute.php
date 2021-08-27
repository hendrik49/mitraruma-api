<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $log = [
            'URI' => $request->getUri(),
            'METHOD' => $request->getMethod(),
            'REQUEST_BODY' => $request->all(),
            'RESPONSE' => json_encode($response->getContent())
        ];
        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201 || $response->getStatusCode() == 202)
            Log::info('success-' . $response->getStatusCode() . ':' . $request->path(), ["data" => $log]);
        else
            Log::error('error-' . $response->getStatusCode() . ':'  . $request->path(), ["data" => $log]);

        return $response;
    }
}
