<?php

namespace App\Helper;

class Utils
{

    public static function bytesToHuman($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return number_format($bytes, 2, ",", "." ) . ' ' . $units[$i];
    }


}