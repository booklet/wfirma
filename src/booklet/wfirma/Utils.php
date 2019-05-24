<?php
namespace Booklet\WFirma;

class Utils
{
    public static function stringToCamelCase($string)
    {
        // dashes
        $string = str_replace('-', ' ', $string);
        // undescore
        $string = str_replace('_', ' ', $string);

        return str_replace(' ', '', ucwords($string));
    }
}
