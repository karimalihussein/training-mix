<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CasheResponeMiddleware
{
    private int $cache_time = 0;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $cache_time)
    {
        
        $this->cache_time = $cache_time;
       if (Cache::has($this->cacheKey($request))) {
            return response(Cache::get($this->cacheKey($request)));
       }
       return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function terminate($request, $response)
    {
      
        if(Cache::has($this->cacheKey($request))) {
            return;
        }
        Cache::put($this->cacheKey($request), $response->getContent(), $this->cache_time);
    }

    private function cacheKey($request): string
    {
        return md5($request->fullUrl() . '-' . auth()->id());
    }
}
