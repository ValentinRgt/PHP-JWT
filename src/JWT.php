<?php

namespace Mrvalentin\JWT;

use DateTime;
use Exception;
use Mrvalentin\JWT\Algorithms;

class JWT {

    public static function getAllVersions()
    {
        $openssl = extension_loaded('openssl') ? 'true' : 'false';

        $data = "<pre>";
        if(extension_loaded('openssl') == false){
            $data .= "OpenSSL library is not loaded on your PHP server. Go to https://www.php.net/manual/fr/book.openssl.php to install it.\n\n";
        }
        $data .= "PHP_VERSION => ".phpversion()."\n\n";
        $data .= "OPENSSL_LOADED => " . $openssl . "\n";
        $data .= "OPENSSL_VERSION => " . OPENSSL_VERSION_TEXT . "\n\n";
        $data .= "</pre>";
        
        return $data;
    }

}