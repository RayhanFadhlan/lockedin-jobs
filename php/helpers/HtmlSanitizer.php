<?php
namespace helpers;
use DOMDocument;
use DOMXPath;

class HTMLSanitizer {
    private $allowedTags = ['h1', 'h2', 'h3', 'p', 'br', 'strong', 'em', 'u', 'a', 'span', 'ol', 'li', 'ul'];

    public function sanitize($html) {
        $pattern = '/<\/?([a-zA-Z0-9]+)(?:\s+[^>]*)?>/i';

        return preg_replace_callback($pattern, function($matches) {
            $tag = strtolower($matches[1]);
            if (in_array($tag, $this->allowedTags)) {
                return $matches[0];
            }
            return '';
        }, $html);
    }
}

    

// 
// '<p>This is <strong>bold</strong> and <script>alert("XSS");</script> should be removed</p>';
