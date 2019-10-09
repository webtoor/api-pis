<?php

namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Factory as Auth;

use Closure;

class Admin
{

    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Pre-Middleware Action

       /*  $response = $next($request);

        // Post-Middleware Action

        return $response; */
        if($this->auth->user()->role->role_id != 1){
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized']);
        }

        return $next($request);
    }
}
