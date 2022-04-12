<?php

namespace Mrvalentin\JWT\DateTime;

use DateTime;
use Exception;
use Mrvalentin\JWT\Algorithms;
use Mrvalentin\JWT\Parser;
use Mrvalentin\JWT\Token\Sign;
use Mrvalentin\JWT\Token\Verify;

class JWT {

    public static function sign(array $payload, string $algorithm, $key, $privateKey = null)
    {
        if(empty($algorithm)) { throw new Exception("You must select an algorithm to secure your token."); }
        if(!Algorithms::get($algorithm) || Algorithms::get($algorithm)[0] == "unsupported"){ 
            throw new Exception("The requested algorithm does not exist or is unfortunately not supported at the moment."); 
        }
        if(empty($key)) { throw new Exception("You must pass a passphrase or the private key of your certification to obfuscate the JWT."); }

        if(isset($payload["iat"])){ throw new Exception("The creation date of the token is implemented by default, you can not duplicate or modify it"); }

        $JWTHeader = ["alg" => $algorithm, "typ" => "JWT"];
        $payload["iat"] = (new DateTime())->format("Y-m-d H:i:s");

        $segments = [];
        $segments[] = Parser::base64UrlEncode(Parser::jsonEncode($JWTHeader));
        $segments[] = Parser::base64UrlEncode(Parser::jsonEncode($payload));
        $signing_input = implode('.', $segments);
        $segments[] = Parser::base64UrlEncode(Sign::sign($signing_input, Algorithms::get($algorithm), $key, $privateKey));

        return implode('.', $segments);
    }

    public static function verify(string $token, $key)
    {
        if(empty($token)) { throw new Exception("Please pass your token as a parameter."); }
        if(empty($key)) { throw new Exception("You must pass a passphrase or the public key of your certification to unblock the JWT."); }
    
        $token_output = explode('.', $token);
        if (count($token_output) != 3) {
            throw new Exception('Wrong number of segments');
        }

        $JWTHeader = Parser::jsonDecode(Parser::base64UrlDecode($token_output[0]));
        if (null === $JWTHeader) { throw new Exception('Invalid header encoding'); } 

        $JWTPayload = Parser::jsonDecode(Parser::base64UrlDecode($token_output[1]));
        if (null === $JWTPayload) { throw new Exception('Invalid claims encoding'); }

        if (isset($JWTHeader["alg"]) && empty($JWTHeader["alg"])) { throw new Exception('The algorithm is not indicated in the header or does not exist.'); }
        if(!Algorithms::get($JWTHeader["alg"]) || Algorithms::get($JWTHeader["alg"])[0] == "unsupported") { throw new Exception("The requested algorithm does not exist or is unfortunately not supported at the moment.");  }

        // Verify Token
        if(!Verify::verify($token_output[0], $token_output[1], Parser::base64UrlDecode($token_output[2]), Algorithms::get($JWTHeader["alg"]), $key)){
            throw new Exception('Signature verification failed');
        }

        if (isset($JWTPayload["exp"]) && (new DateTime())->format("Y-m-d H:i:s") >= $JWTPayload["exp"]) { throw new Exception('Expired token.'); }

        return $JWTPayload;
    }

}