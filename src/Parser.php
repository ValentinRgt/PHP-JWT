<?php

namespace Mrvalentin\JWT;

class Parser {

    public static function jsonEncode($data): string { return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); }

    public static function jsonDecode(string $data) { return json_decode($data, true, 512); }

    public static function base64UrlEncode(string $data): string { return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); }

    public static function base64UrlDecode(string $data) { return base64_decode(strtr($data, '-_', '+/'), true); }

}