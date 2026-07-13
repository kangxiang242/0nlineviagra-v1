<?php
if (! function_exists('template')) {
    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string|null  $view
     * @param  \Illuminate\Contracts\Support\Arrayable|array  $data
     * @param  array  $mergeData
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    function template($view = null, $data = [], $mergeData = []){
        $device = is_mobile() ? "mobile" : "web";
        return view($device.'.'.$view,$data,$mergeData);
    }
}

if (! function_exists('is_mobile')) {
    /**
     * 判断是不是手机端
     *
     * @param $user_agent
     * @return bool
     */
    function is_mobile($user_agent = null){

        $user_agent = $user_agent ? : request()->header('User-Agent');

        if (isset ($user_agent))
        {
            $clientkeywords = array (
                'iphone',
                'ipad',
                'android',
            );

            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($user_agent)))
            {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('assetv')) {
    /**
     * 前端静态文件引入含版本
     *
     * @param $path
     * @return string
     */
    function assetv($path)
    {
        $fullPath = public_path($path);
        $version = file_exists($fullPath) ? filemtime($fullPath) : time();
        return asset($path) . '?v=' . $version;
    }
}


if (!function_exists('get_setting')) {
    /**
     * 获取站点配置
     *
     * @param $key
     * @param $default
     * @return mixed|object
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function get_setting($key, $default = null)
    {
        return app('site.setting')->get($key,$default);
    }
}


if (!function_exists('array_get')) {
    /**
     * 获取数组
     *
     * @param $array
     * @param $key
     * @param $default
     * @return array|ArrayAccess|mixed
     */
    function array_get($array, $key,$default = null)
    {
        return \Illuminate\Support\Arr::get($array,$key,$default);
    }
}

if (!function_exists('storage_url')) {
    /**
     * 获取上传的完整url
     *
     * @param $path
     * @return array|ArrayAccess|mixed
     */
    function storage_url($path)
    {
        return \Illuminate\Support\Facades\Storage::url($path);
    }
}

if (!function_exists('ip')) {
    /**
     * 获取上传的完整url
     *
     * @return array|ArrayAccess|mixed
     */
    function ip()
    {
        return request()->header('cf-connecting-ip',request()->ip());
    }
}

if (!function_exists('user_agent')) {
    /**
     * 获取上传的完整url
     *
     * @return array|ArrayAccess|mixed
     */
    function user_agent()
    {
        return request()->userAgent();
    }
}

if (!function_exists('get_device')) {
    /**
     * 获取上传的完整url
     *
     * @return array|ArrayAccess|mixed
     */
    function get_device($agent = null)
    {
        if(!$agent){
            $agent  = $_SERVER['HTTP_USER_AGENT'];
        }
        $agent = strtolower($agent);

        $device_type = 'unknown';

        $device_type = (strpos($agent, 'windows')) ? 'windows' : $device_type;

        $device_type = (strpos($agent, 'mac')) ? 'mac' : $device_type;

        $device_type = (strpos($agent, 'iphone')) ? 'iphone' : $device_type;

        $device_type = (strpos($agent, 'ipad')) ? 'ipad' : $device_type;

        $device_type = (strpos($agent, 'linux')) ? 'linux' : $device_type;

        $device_type = (strpos($agent, 'android')) ? 'android' : $device_type;

        return $device_type;

    }
}
