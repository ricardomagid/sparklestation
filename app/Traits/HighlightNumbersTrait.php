<?php
namespace App\Traits;

trait HighlightNumbersTrait
{
    /**
     * Highlight numbers in the given text with a span tag.
     *
     * @param  string  $value
     * @return string
     */
    public function highlightNumbers(string $value): string
    {
        return preg_replace(
            '/\d+(\.\d+)?/',
            '<span class="ability-number" style="color: yellow;">$0</span>',
            $value
        );
    }
}