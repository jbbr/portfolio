<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidProxies
{
    protected $headers = Request::HEADER_X_FORWARDED_ALL;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Proxies
        $request->setTrustedProxies([$request->getClientIp()], $this->headers);
        return $next($request);
    }
}
