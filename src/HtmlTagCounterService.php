<?php

namespace App;

use App\HtmlParser\HtmlParser;
use App\HtmlParser\TagCounter;

class HtmlTagCounterService
{
    public function __construct(
        protected readonly HttpClient $httpClient,
        protected readonly HtmlParser $htmlParser,
        protected readonly TagCounter $tagCounter,
    ) {}

    public function countTags(string $url): array
    {
        $html = $this->httpClient->get($url);
        $tree = $this->htmlParser->parse($html);
        return $this->tagCounter->countTags($tree);
    }
}