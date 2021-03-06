<?php
namespace Engine;

use Engine\Soap\Account\Http as AccountHttp;
use Engine\Soap\Sportsbook\Http as SportsbookHttp;
use App\Model\Redis\LiveEvent;
use Engine\Soap\ArrayToXml;
use Engine\Soap\RequestXml;
use ExHelp\Skin;

class Main {

    const log_channel=null;

    const endpoint ="https://apistaging.altechlab.com/";

    const accountEndpoint = self::endpoint."xml/service/accounting-online/invoke";

    const sportsbookEndpoint = self::endpoint."xml/service/betting/invoke";

    // may need to override
    public static function getLang(){
        return Skin::getLang();
    }

    // may need to override
    public static function getSkinId(){
        return Skin::getId();
    }

    // may need to override
    public static function getToken(){
        return session('token');
    }

    // may need to override
    public static function getAttributes(){
        return [
            'idEntityStaff'=>session('idEntityStaff'),
            'username'=> session('username'),
        ];
    }

    public static function accountHttp(){
        return new AccountHttp( 
            static::accountEndpoint, 
            static::arrayToXml(),
            static::requestXml(),
            static::getToken(),
            static::log_channel, 
            static::getAttributes(),
        );
    }

    public static function sportsbookHttp(){
        return new SportsbookHttp( 
            static::sportsbookEndpoint, 
            static::arrayToXml(), 
            static::requestXml(), 
            static::getToken(),
            static::log_channel,
            static::getAttributes(),
            LiveEvent::class 
        );
    }

    public static function arrayToXml(){
        return new ArrayToXml( static::getLang(), static::getSkinId() );
    }
    
    public static function requestXml(){
        return new RequestXml( static::getLang(), static::getSkinId() );
    }

}