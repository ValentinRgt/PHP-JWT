<?php

namespace Mrvalentin\JWT\Token;

use Exception;

class Verify {

    public static function Verify(string $JWTHeader, string $JWTPayload, string $JWTSignature, array $algorithm, $key)
    {
        switch ($algorithm[0]) {
            case "hmac":
                if (!is_string($key)) { throw new Exception('key must be a string when using hmac'); }
                $hash = hash_hmac($algorithm[1], "$JWTHeader.$JWTPayload", $key, true);
                return hash_equals($hash, $JWTSignature);
                break;
            case "openssl":
                if(!extension_loaded('openssl')){ throw new Exception("OpenSSL library is not loaded on your PHP server. Go to https://www.php.net/manual/fr/book.openssl.php to install it."); }
                return openssl_verify("$JWTHeader.$JWTPayload", $JWTSignature, $key, $algorithm[1]);
                break;
        }
    }

}