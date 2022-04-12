<?php

namespace Mrvalentin\JWT\Token;

use DateTime;
use Exception;
use Mrvalentin\JWT\Algorithms;

class Sign {

    public static function sign(string $token, array $algorithm, $key, $privateKey)
    {
        switch ($algorithm[0]) {
            case "hmac":
                if (!is_string($key)) { throw new Exception('key must be a string when using hmac'); }
                return hash_hmac($algorithm[1], $token, $key, true);
                break;

            case "openssl":
                if(!extension_loaded('openssl')){ throw new Exception("OpenSSL library is not loaded on your PHP server. Go to https://www.php.net/manual/fr/book.openssl.php to install it."); }
                $signature = "";
                openssl_sign($token, $signature, openssl_get_privatekey($privateKey, $key), $algorithm[1]);
                return $signature;
                break;
            
        }
    }

}