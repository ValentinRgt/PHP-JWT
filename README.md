[![GitHub release (latest by date)](https://img.shields.io/github/v/release/ValentinRgt/php-jwt?style=for-the-badge)](https://packagist.org/packages/mrvalentin/phpjwt)
[![Packagist Downloads](https://img.shields.io/packagist/dt/mrvalentin/phpjwt?label=PACKAGIST%20DOWNLOADS&style=for-the-badge)](https://packagist.org/packages/mrvalentin/phpjwt)
[![GitHub License](https://img.shields.io/github/license/ValentinRgt/php-jwt?style=for-the-badge)](https://packagist.org/packages/mrvalentin/phpjwt)

PHP-JWT
=======
A simple library to work with JSON Web Token and JSON Web Signature with your choice of Timestamp and DateTime in PHP, conforming to [RFC 7519](https://tools.ietf.org/html/rfc7519).

Installation
------------

Use composer to manage your dependencies and download PHP-JWT:

```bash
composer require mrvalentin/phpjwt
```

Introduction
-------

See [Example](#example)
See [Example with OpenSSL without Passphrase](#example-with-openssl-without-passphrase)
See [Example with OpenSSL with Passphrase](#example-with-openssl-with-passphrase)


```php

/* JWT IN DATETIME WITHOUT OPENSSL WITHOUT PASSPHRASE */ 
\Mrvalentin\JWT\DateTime\JWT::sign("YOUR_PAYLOAD_IN_DATETIME", "HS256", "YOUR_PASSPHRASE");
\Mrvalentin\JWT\DateTime\JWT::verify("YOUR_TOKEN_IN_DATETIME", "YOUR_PASSPHRASE");

/* JWT IN TIMESTAMP WITHOUT OPENSSL WITHOUT PASSPHRASE */ 
\Mrvalentin\JWT\Time\JWT::sign("YOUR_PAYLOAD_IN_TIME", "HS256", "YOUR_PASSPHRASE");
\Mrvalentin\JWT\Time\JWT::verify("YOUR_TOKEN_IN_TIME", "YOUR_PASSPHRASE");

/* JWT IN DATETIME WITH OPENSSL WITHOUT PASSPHRASE */ 
\Mrvalentin\JWT\DateTime\JWT::sign("YOUR_PAYLOAD_IN_DATETIME", "HS256", "", "YOUR_OPENSSL_PRIVATEKEY");
\Mrvalentin\JWT\DateTime\JWT::verify("YOUR_TOKEN_IN_DATETIME", "YOUR_OPENSSL_PUBLICKEY");

/* JWT IN TIMESTAMP WITH OPENSSL WITHOUT PASSPHRASE */ 
\Mrvalentin\JWT\Time\JWT::sign("YOUR_PAYLOAD_IN_TIME", "HS256", "", "YOUR_OPENSSL_PRIVATEKEY");
\Mrvalentin\JWT\Time\JWT::verify("YOUR_TOKEN_IN_TIME", "YOUR_OPENSSL_PUBLICKEY");

/* JWT IN DATETIME WITH OPENSSL WITH PASSPHRASE */ 
\Mrvalentin\JWT\DateTime\JWT::sign("YOUR_PAYLOAD_IN_DATETIME", "HS256", "YOUR_OPENSSL_PASSPHRASE", "YOUR_OPENSSL_PRIVATEKEY");
\Mrvalentin\JWT\DateTime\JWT::verify("YOUR_TOKEN_IN_DATETIME", "YOUR_OPENSSL_PUBLICKEY");

/* JWT IN TIMESTAMP WITH OPENSSL WITH PASSPHRASE */ 
\Mrvalentin\JWT\Time\JWT::sign("YOUR_PAYLOAD_IN_TIME", "HS256", "YOUR_OPENSSL_PASSPHRASE", "YOUR_OPENSSL_PRIVATEKEY");
\Mrvalentin\JWT\Time\JWT::verify("YOUR_TOKEN_IN_TIME", "YOUR_OPENSSL_PUBLICKEY");

```

Example
-------
```php
/*
* JWT in DateTime format
*/

$payloadDateTime = array(
    "exp" => (new DateTime())->modify("+50seconds")->format("Y-m-d H:i:s"),
    "hello" => "Hello World"
);

try {
    $encodedDateTime = \Mrvalentin\JWT\DateTime\JWT::sign($payloadDateTime, "HS256", "example_key");
    $decodedDateTime = \Mrvalentin\JWT\DateTime\JWT::verify($encodedDateTime, "example_key");
    var_dump($decodedDateTime);
} catch (Exception $e) {
    print_r($e->getMessage());
}

/*
* JWT in Timestamp format
*/

$payloadTime = array(
    "exp" => time() + 50,
    "hello" => "Hello World"
);

try {
    $encodedTime = \Mrvalentin\JWT\Time\JWT::sign($payloadTime, "HS256", "example_key");
    $decodedTime = \Mrvalentin\JWT\Time\JWT::verify($encodedTime, "example_key");
    var_dump($decodedTime);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```

Example with OpenSSL without Passphrase
-------
```php

$privateKey = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
-----END RSA PRIVATE KEY-----
EOD;

$publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC8kGa1pSjbSYZVebtTRBLxBz5H
4i2p/llLCrEeQhta5kaQu/RnvuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t
0tyazyZ8JXw+KgXTxldMPEL95+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4
ehde/zUxo6UvS7UrBQIDAQAB
-----END PUBLIC KEY-----
EOD;

/*
* JWT in DateTime format
*/

$payloadDateTime = array(
    "exp" => (new DateTime())->modify("+50seconds")->format("Y-m-d H:i:s"),
    "hello" => "Hello World"
);

try {
    $encodedDateTime = \Mrvalentin\JWT\DateTime\JWT::sign($payloadDateTime, "RS256", "", $privateKey);
    $decodedDateTime = \Mrvalentin\JWT\DateTime\JWT::verify($encodedDateTime, $publicKey);
    var_dump($decodedDateTime);
} catch (Exception $e) {
    print_r($e->getMessage());
}

/*
* JWT in Timestamp format
*/

$payloadTime = array(
    "exp" => time() + 50,
    "hello" => "Hello World"
);

try {
    $encodedTime = \Mrvalentin\JWT\Time\JWT::sign($payloadTime, "RS256", "", $privateKey);
    $decodedTime = \Mrvalentin\JWT\Time\JWT::verify($encodedTime, $publicKey);
    var_dump($decodedTime);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```

Example with OpenSSL with Passphrase
-------
```php

$privateKey = <<<EOD
-----BEGIN ENCRYPTED PRIVATE KEY-----
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
-----END ENCRYPTED PRIVATE KEY-----
EOD;

$publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEA14na+hnVL1iS1vGE40Fi
iKyegr8ZiyJu8ZqSAhZnhmufOGGa1SUvdVZQTHJFMxzV6IbxRtRUi48wU7kzkJtE
L0KO7A4a/x+T3Q0OT/nMh+dWNvE0qyuxA9xeRRnJkllRoIoVJ5ZHFZSb7awnBjCs
2HBfvLjliQyLoT113eWNT7agMsRgMgwsXT/OBBh1fZew6r5JQ1+dea/n5ZVHaLC3
UnyEay58AH1zwutwQR5s9HvRd/Uag/0WnjDDyWiMEpmRilABfXrnuqcrVdHevlzZ
EvV/xdPwMaOnKDsMu9+T6brbOXbM+OebJUWjtQzqmk6VaPE+USa6lyTDkeOlVQIb
+LmAIKZ3jjZ3Cr5tZv9QhiHjza75pOP53LSK4uJRZcSagNux1IBVIkvOSRYUOuCC
6GIzvqOuBTBy42I4AIYqiQJtjlXF4l1Ns7awo8LO5c3H0oEtyyMAlFWUhA8w3fbC
aaVPTyA2YQUttZuK8GKlVlN9Ko7cbP5C+YIAQF/LviR1lQ+CVw0qJmtN3lsSI5CD
lGGGDB/jh9AI+ssQEOF4TbM6aZYAIoXr3jw4hd4moZBB+bY/s4FLEk2DTGmf7f1h
clgqDH1gFtWSkBhCg23qM0VibfqWwGgrkKcflMq6asVoSmLidddQSUSyRwj00hDs
oMPsF/a105RQcjEvTqYa4ykCAwEAAQ==
-----END PUBLIC KEY-----
EOD;

/*
* JWT in DateTime format
*/

$payloadDateTime = array(
    "exp" => (new DateTime())->modify("+50seconds")->format("Y-m-d H:i:s"),
    "hello" => "Hello World"
);

try {
    $encodedDateTime = \Mrvalentin\JWT\DateTime\JWT::sign($payloadDateTime, "RS256", "azerty", $privateKey);
    $decodedDateTime = \Mrvalentin\JWT\DateTime\JWT::verify($encodedDateTime, $publicKey);
    var_dump($decodedDateTime);
} catch (Exception $e) {
    print_r($e->getMessage());
}

/*
* JWT in Timestamp format
*/

$payloadTime = array(
    "exp" => time() + 50,
    "hello" => "Hello World"
);

try {
    $encodedTime = \Mrvalentin\JWT\Time\JWT::sign($payloadTime, "RS256", "azerty", $privateKey);
    $decodedTime = \Mrvalentin\JWT\Time\JWT::verify($encodedTime, $publicKey);
    var_dump($decodedTime);
} catch (Exception $e) {
    print_r($e->getMessage());
}

```

License
-------
[3-Clause BSD](http://opensource.org/licenses/BSD-3-Clause).