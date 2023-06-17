<?php

use App\HtmlParser\HtmlParser;
use App\HtmlParser\TagCounter;
use App\HtmlTagCounterService;
use App\HttpClient;

spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

$url = "http://yandex.ru";
// better to use DI but this is enough for test task
$htmlTagCounter = new HtmlTagCounterService(new HttpClient(), new HtmlParser(), new TagCounter());
print_r($htmlTagCounter->countTags($url));