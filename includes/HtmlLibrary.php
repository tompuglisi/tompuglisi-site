<?php

class HtmlLibrary
{

    public static function openElement($name, $attributes = NULL)
    {
        echo '<', $name;
        if (! is_null($attributes)) {
            foreach ($attributes as $attribute => $value) {
                echo ' ', $attribute, '="', $value, '"';
            }
        }
        echo '>';
    }

    public static function closeElement($name)
    {
        echo '</', $name, '>';
    }

    public static function openCloseElement($name, $attributes = array(), $value)
    {
        HtmlLibrary::openElement($name, $attributes);
        echo $value;
        HtmlLibrary::closeElement($name);
    }
}
?>
