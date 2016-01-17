<?php

namespace ViKon\Wiki;

use Illuminate\Html\HtmlBuilder;

/**
 * Class WikiHtmlBuilder
 *
 * @author  Kovács Vince <vincekovacs@hotmail.com>
 *
 * @package ViKon\Wiki
 */
class WikiHtmlBuilder extends HtmlBuilder
{
    /**
     * Generate an un-ordered list of items.
     *
     * @param  array $list
     * @param  array $attributes
     *
     * @return string
     */
    public function toc($list, array $attributes = [])
    {
        return $this->tocListing('ul', $list, $attributes);
    }

    /**
     * Create a listing HTML element.
     *
     * @param  string  $type
     * @param  array   $list
     * @param  mixed[] $attributes
     *
     * @return string
     */
    protected function tocListing($type, array $list, array $attributes = [])
    {
        $html = '';

        if (count($list) === 0) {
            return $html;
        }

        // Essentially we will just spin through the list and build the list of the HTML
        // elements from the array. We will also handled nested lists in case that is
        // present in the array. Then we will build out the final listing elements.
        foreach ($list as $key => $value) {
            $html .= $this->tocListingElement($key, $type, $value);
        }

        $attributes = $this->attributes($attributes);

        return "<{$type}{$attributes}>{$html}</{$type}>";
    }

    /**
     * Create the HTML for a listing element.
     *
     * @param  mixed           $key
     * @param  string          $type
     * @param  string|string[] $value
     *
     * @return string
     */
    protected function tocListingElement($key, $type, $value)
    {
        if (is_array($value)) {
            return $this->tocNestedListing($key, $type, $value);
        } else {
            return '<li>' . $value . '</li>';
        }
    }

    /**
     * Create the HTML for a nested listing attribute.
     *
     * @param  mixed  $key
     * @param  string $type
     * @param  string $value
     *
     * @return string
     */
    protected function tocNestedListing($key, $type, $value)
    {
        if (is_int($key)) {
            return $this->tocListing($type, $value, ['class' => 'nav']);
        } else {
            return '<li>' . $key . $this->tocListing($type, $value, ['class' => 'nav']) . '</li>';
        }
    }
}