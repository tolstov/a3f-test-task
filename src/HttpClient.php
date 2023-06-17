<?php

namespace App;

class HttpClient
{
    public function __construct() {}

    public function get(string $url): string
    {
        return file_get_contents($url);
    }
}