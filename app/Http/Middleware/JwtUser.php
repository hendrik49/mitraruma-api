<?php


namespace App\Http\Middleware;

use Closure;

class JwtUser
{

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\JwtService  $jwt
     * @return void
     */
    public function __construct(
        \App\Services\JwtService $jwt
    ) {
        $this->jwt = $jwt;
    }
    /**
     * Handle jwt token for valid user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        try {
            $token = $request->header('Authorization');
            if(!$token)
                return response()->json(['message' =>'Token not found'], 400);

            $token = str_replace('Bearer ', '', $token);

            $decoded = $this->jwt->decode($token);

            $request->request->add(['user_id' => $decoded->id ?? $decoded->ID]);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
        if(!isset($token)) {

            return response()->json(['message' => 'asd'], );
        }

        return $next($request);
    }

}