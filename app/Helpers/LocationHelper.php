<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class LocationHelper
{
    public static function getClientCity()
    {
        $client = new Client();
        $ip = request()->ip();
        try {
            $response = $client->get("http://www.geoplugin.net/php.gp?ip={$ip}");
        } catch (\Throwable ) {
            $ip = '170.80.143.255';
            $response = $client->get("http://www.geoplugin.net/php.gp?ip={$ip}");
        }
        $locationData = unserialize($response->getBody());
        
        return $locationData;
    }
}
