<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Response;

class Authenticate
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $guard = 'api')
    {
        if ($this->auth->guard($guard)->guest()) {
            return new Response('Unauthorized.', 401);
        }
        return $next($request);
    }
}
