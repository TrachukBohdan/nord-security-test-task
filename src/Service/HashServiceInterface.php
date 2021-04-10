<?php

namespace App\Service;

interface HashServiceInterface
{
    public function encode(string $data): string;
    public function decode(string $data): string;
}