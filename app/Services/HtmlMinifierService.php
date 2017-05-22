<?php

namespace App\Services;

class HtmlMinifierService
{
    public $htmlFilters = [
        //Remove HTML comments except IE conditions
        '/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s' => '',
        // Remove comments in the form /* */
        '/(?<!\S)\/\/\s*[^\r\n]*/' => '',
        // Shorten multiple white spaces
        '/\s{2,}/' => ' ',
        // Remove whitespaces between HTML tags
        '/>\s+</' => '><',
        // Collapse new lines
        '/(\r?\n)/' => '',
    ];

    /**
     * @param string $html
     *
     * @return string
     */
    public function minify(string $html): string
    {
        $output = preg_replace(array_keys($this->htmlFilters), array_values($this->htmlFilters), $html);

        return $output;
    }
}
