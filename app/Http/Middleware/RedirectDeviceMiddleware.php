<?php

namespace App\Http\Middleware;

use App\Handlers\DeviceTypeHandlers;
use App\Services\ConfigService;
use Closure;

class RedirectDeviceMiddleware
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

        $is_mobile = DeviceTypeHandlers::isMobile();
        if($is_mobile){
            $url = config('app.m_url');
        }else{
            $url = config('app.url');
        }

        if($url){
            $parse_url = parse_url($url);
            if($parse_url['host'] != $request->getHost()){
                $n_u = $url.'/'.trim($request->path(),'/');
                return redirect($n_u);
            }
        }


        return $next($request);
    }
}
