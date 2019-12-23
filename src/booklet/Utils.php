<?php

namespace Booklet\WFirma;

class Utils
{
    public static function stringToCamelCase($string)
    {
        $string = str_replace('-', ' ', $string);
        $string = str_replace('_', ' ', $string);

        return str_replace(' ', '', ucwords($string));
    }

    public static function stringAreStartsWith($haystack, $needle)
    {
        $length = strlen($needle);

        return substr($haystack, 0, $length) === $needle;
    }
}
