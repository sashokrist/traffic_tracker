<?php

namespace App\Contracts;

interface GeoLocatorInterface
{
    public function locate(string $ip): array;
}
