<?php

namespace App\HtmlParser;

class Node
{
    public array $children = [];
    public ?string $content = null;

    public function __construct(public ?string $tagName = null, public array $attributes = [])
    {
    }
}