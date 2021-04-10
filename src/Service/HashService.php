<?php

namespace App\Service;

class HashService implements HashServiceInterface
{
    /**
     * @var string
     */
    private $hashKey;

    /**
     * @var string
     */
    private $iv;

    public function __construct(string $hashKey, string $iv)
    {
        $this->iv = $iv;
        $this->hashKey = $hashKey;
    }

    public function encode(string $data): string
    {
        return openssl_encrypt($data, 'aes-128-cbc', $this->hashKey, 0, $this->iv);
    }

    public function decode(string $data): string
    {
        return openssl_decrypt($data, 'aes-128-cbc', $this->hashKey, 0, $this->iv);
    }
}