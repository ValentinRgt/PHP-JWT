<?php

namespace Mrvalentin\JWT\Generator;

use Exception;

class Passphrase {

    public static function randomPassphrase(int $length = 25) {
        if($length != 0 && $length <= 512){
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890~!@#$%^&*()-_=+[]{};:,.<>/?|';
            $pass = "";
            for ($i = 0; $i < $length; $i++) {
                $n = rand(0, strlen($alphabet) - 1);
                $pass .= $alphabet[$n];
            }
            return $pass;
        }else{
            throw new Exception("Please choose a number of characters between 1 and 512.");
        }
    }

}