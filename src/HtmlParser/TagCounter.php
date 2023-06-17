<?php

namespace App\HtmlParser;

class TagCounter
{
    public function countTags(Node $node): array
    {
        $tagCounts = [];
        if ($node->tagName !== null) {
            $tagCounts[$node->tagName] = ($tagCounts[$node->tagName] ?? 0) + 1;
        }

        foreach ($node->children as $child) {
            $childCounts = $this->countTags($child);
            foreach ($childCounts as $tag => $count) {
                $tagCounts[$tag] = ($tagCounts[$tag] ?? 0) + $count;
            }
        }

        return $tagCounts;
    }
}