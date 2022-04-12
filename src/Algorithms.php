<?php

namespace Mrvalentin\JWT;

class Algorithms {
    private static $algorithms = [
        "HS256" => ["hmac", "SHA256"],
        "HS384" => ["hmac", "SHA384"],
        "HS512" => ["hmac", "SHA512"],
        "RS256" => ["openssl", "SHA256"],
        "RS384" => ["openssl", "SHA384"],
        "RS512" => ["openssl", "SHA512"],
        "ES256" => ["openssl", "SHA256"],
        "ES384" => ["openssl", "SHA384"],
        "ES512" => ["openssl", "SHA512"],
        "PS256" => ["openssl", "RSA-SHA256"],
        "PS384" => ["openssl", "RSA-SHA384"],
        "PS512" => ["openssl", "RSA-SHA512"],
    ];

    public static function get($algorithm) { return static::$algorithms[$algorithm]; }
}