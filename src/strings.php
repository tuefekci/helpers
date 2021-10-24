<?php

namespace tuefekci\helpers;

/**
* Strings Class
*
* This class offers function and helpers for working with strings.
*
* @author Giacomo Tüfekci
* @package tuefekci\helpers
*/
class Strings
{
    public static function getBetween(string $content, string $start, string $end)
    {
        $r = explode($start, $content);
        if (isset($r[1])) {
            $r = explode($end, $r[1]);
            return $r[0];
        }
        return false;
    }

    public static function filesizeFormatted($size)
    {
        $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

}
