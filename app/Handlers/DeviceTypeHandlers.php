<?php

namespace App\Handlers;

class DeviceTypeHandlers
{
    public static function isMobile()
    {
        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        if (isset($_SERVER['HTTP_VIA'])) {
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array(
                'nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg',
                'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo',
                'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront',
                'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi',
                'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile'
            );
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) &&
                (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false ||
                    (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }

    public static function getDevice($agent = null)
    {
        if (!$agent) {
            $agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
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

    public static function getBrowser($agent = null)
    {
        if (!$agent) {
            $agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        }
        $agent = strtolower($agent);
        
        if (strpos($agent, 'edg/') !== false || strpos($agent, 'edge/') !== false) {
            return 'Edge';
        }
        if (strpos($agent, 'opr/') !== false || strpos($agent, 'opera/') !== false) {
            return 'Opera';
        }
        if (strpos($agent, 'chrome/') !== false && strpos($agent, 'chromium') === false) {
            if (strpos($agent, 'samsung') !== false) {
                return 'Samsung Internet';
            }
            return 'Chrome';
        }
        if (strpos($agent, 'firefox/') !== false) {
            return 'Firefox';
        }
        if ((strpos($agent, 'safari/') !== false || strpos($agent, 'safari,')) && strpos($agent, 'chrome') === false) {
            return 'Safari';
        }
        return null;
    }

    public static function getCrawler($agent = null)
    {
        if ($agent) {
            $agent = strtolower($agent);
        } else {
            $agent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
        }
        if (!empty($agent)) {
            $spiderSite = array(
                "TencentTraveler", "Baiduspider+", "BaiduGame", "Googlebot",
                "msnbot", "Sosospider+", "Sogou web spider", "ia_archiver",
                "Yahoo! Slurp", "YoudaoBot", "Yahoo Slurp", "MSNBot",
                "Java (Often spam bot)", "BaiDuSpider", "Voila", "Yandex bot",
                "BSpider", "twiceler", "Sogou Spider", "Speedy Spider",
                "Google AdSense", "Heritrix", "Python-urllib",
                "Alexa (IA Archiver)", "Ask", "Exabot", "Custo",
                "OutfoxBot/YodaoBot", "yacy", "SurveyBot", "legs",
                "lwp-trivial", "Nutch", "StackRambler",
                "The web archive (IA Archiver)", "Perl tool", "MJ12bot",
                "Netcraft", "MSIECrawler", "WGet tools", "larbin", "Fish search",
            );
            foreach ($spiderSite as $val) {
                $str = strtolower($val);
                if (strpos($agent, $str) !== false) {
                    return $str;
                }
            }
            return null;
        }
        return null;
    }
}
