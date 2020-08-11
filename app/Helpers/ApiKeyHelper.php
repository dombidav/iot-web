<?php


namespace App\Helpers;


class ApiKeyHelper
{
    public static function generate(){
        $keyPart = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));
        return $keyPart . '-' . self::getSum($keyPart) ;
    }

    private static function getSum(string $keyPart){
        $sum = '';
        foreach (explode('-', $keyPart) as $section){
            $sectionSum = 0;

            foreach (str_split($section) as $char)
                $sectionSum += intval($char, 16);

            $sum .= substr((string)$sectionSum, -1);
        }
        return $sum;
    }

    public static function isValid(string $key){
        if(!preg_match('/^(?:[0-9a-f]{6}-){5}(?:[0-9a-f]{5})$/', $key)) return false;
        $keyPart = substr($key, 0, 34);
        $keySum = substr($key, 35);
        return $keySum == self::getSum($keyPart);
    }
}
