<?php


namespace App\Http\Middleware;


use App\Services\ConfigService;


class GooglebotChecked
{
    public function handle($request, \Closure $next){


        if($request->path() == '/'){
            $user_agent  = $request->userAgent();
            if(strpos(strtolower($user_agent),'googlebot') !== false){
                $close_googlebot = ConfigService::get('close_googlebot');

                if($close_googlebot){
                    return response('','500');
                }else{
                    /*$host_addr = gethostbyaddr($request->header('cf-connecting-ip',$request->ip()));
                    if(strpos(strtolower($host_addr),'googlebot') !== false){
                        $cache_response =  $this->cacheControl();
                        if($cache_response){
                            return $cache_response;
                        }
                    }*/

                    $host_addr = gethostbyaddr($request->header('cf-connecting-ip',$request->ip()));
                    if(strpos(strtolower($host_addr),'googlebot') !== false){
                        $googlebot_index_page = ConfigService::get('googlebot_index_page');
                        if($googlebot_index_page){
                            echo str_replace('window.location.href = current_host;','',$googlebot_index_page);exit;
                        }
                    }

                }

            }

        }

        return $next($request);

    }

    public function validateTime($start,$end){
        $start = str_replace(':','',$start);
        $end = str_replace(':','',$end);
        $current = date('Hi');

        if($start <= $end){
            if($current>= $start && $current<=$end){
                return true;
            }
        }else{
            //结束时间在第二天
            if($start <= $current || $end >= $current){
                return true;
            }

        }

        return false;
    }

    protected function cacheControl(){
        $is_enable_302 = ConfigService::get('is_enable_302');
        $is_open_cache = ConfigService::get('is_open_cache');
        $is_not_modified = ConfigService::get('is_not_modified');
        $cache_control_max_age = ConfigService::get('cache_control_max_age');

        if($is_enable_302){
            $host = request()->getHost();
            $is_302_host = ConfigService::get('302_host');
            if($is_302_host && $host != $is_302_host){
                header('HTTP/1.1 302 Moved Permanently');
                header('Location: https://'.$is_302_host);
                exit;
            }
        }

        if($is_not_modified){
            /*header("Expires: " . $cache_control_max_age);
            header("Etag: 5d8c72a5edda8d6a");
            header("HTTP/1.1 304 Not Modified");*/

            $header = [
                'Expires'=>gmdate("D, d M Y H:i:s",time()+$cache_control_max_age)." GMT",
                'Cache-Control'=>'public, max-age='.$cache_control_max_age,
            ];
            return response('',304,$header);

        }

        if($is_open_cache){
            $user_agent  = request()->userAgent();
            if(strpos(strtolower($user_agent),'googlebot') !== false){
                $cache_content = ConfigService::get('cache_content_m');
            }else{
                $cache_content = ConfigService::get('cache_content');
            }

            if($cache_content){
                $header = [
                    'Expires'=>gmdate("D, d M Y H:i:s",time()+$cache_control_max_age)." GMT",
                    'Cache-Control'=>'public, max-age='.$cache_control_max_age,
                ];
                return response($cache_content,200,$header);
            }

        }

        return false;

    }
}
