<?php


namespace App\Http\Middleware;

use Closure;

class JwtAdmin
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

        if ($request->path() != "api/consultation/chatupdate") {
            try {
                $token = $request->header('Authorization');
                if (!$token)
                    return response()->json(['message' => 'Token not found'], 400);

                $token = str_replace('Bearer ', '', $token);

                $decoded = $this->jwt->decode($token);

                $userType = $decoded->userType ?? $decoded->user_type;
                if ($userType !== 'admin') {
                    return response()->json(['message' => 'User not authorize'], 400);
                }

                $request->request->add(['admin_user_id' => $decoded->id ?? $decoded->ID]);
                $request->request->add(['user_jwt_email' => $decoded->email ?? $decoded->user_email]);
                $request->request->add(['user_jwt_name' => $decoded->displayName ?? $decoded->display_name]);
                $request->request->add(['user_jwt_type' => $decoded->userType ?? $decoded->user_type]);
            } catch (\Throwable $e) {
                return response()->json(['message' => $e->getMessage()], 403);
            }
            if (!isset($token)) {

                return response()->json(['message' => 'asd'],);
            }
        }

        return $next($request);
    }
}
