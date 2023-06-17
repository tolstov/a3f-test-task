<?php

namespace App\HtmlParser;

class HtmlParser
{
    private string $html;
    private int $position = 0;

    public function parse(string $html): Node
    {
        $this->html = $html;
        $root = new Node();
        $this->parseElements($root);
        return $root;
    }

    private function parseElements(Node $parent): void
    {
        while ($this->position < strlen($this->html)) {
            if ($this->html[$this->position] === '<') {
                $this->position++;
                if ($this->html[$this->position] === '/') {
                    $this->position = strpos($this->html, '>', $this->position) + 1;
                    return;
                }

                $endTagPos = strpos($this->html, '>', $this->position);
                $tagString = substr($this->html, $this->position, $endTagPos - $this->position);
                $this->position = $endTagPos + 1;

                $spacePos = strpos($tagString, ' ');
                if ($spacePos !== false) {
                    $tagName = substr($tagString, 0, $spacePos);
                    $attributesString = substr($tagString, $spacePos + 1);
                    $attributes = $this->parseAttributes($attributesString);
                } else {
                    $tagName = $tagString;
                    $attributes = [];
                }

                $child = new Node($tagName, $attributes);
                $this->parseElements($child);
                $parent->children[] = $child;
            } else {
                $endPos = strpos($this->html, '<', $this->position);
                $parent->content .= substr($this->html, $this->position, $endPos - $this->position);
                $this->position = $endPos;
            }
        }
    }

    private function parseAttributes(string $attributesString): array
    {
        $attributes = [];
        $parts = explode(' ', $attributesString);
        foreach ($parts as $part) {
            if (str_contains($part, '=')) {
                [$name, $value] = explode('=', $part, 2);
            } else {
                $name = $value = $part;
            }
            $attributes[$name] = trim($value, "\"'");
        }

        return $attributes;
    }

}