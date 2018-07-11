<?php
/**
 * Created by PhpStorm.
 * User: ewerson
 * Date: 11/07/18
 * Time: 13:37
 */

namespace Ewersonfc\Linhadigitavel\Helpers;

/**
 * Class Helper
 * @package Ewersonfc\Linhadigitavel\Helpers
 */
class Helper
{
    /**
     * @param $text
     * @return null|string|string[]
     */
    public static function prepair($text)
    {
        return preg_replace("/[^0-9\.]/", "", $text);
    }

    /**
     * @param $text
     * @return null|string|string[]
     */
    public static function prepairIMG($text)
    {
        $data = preg_replace("/[^0-9\-]/", "", $text);
        return explode('-', $data);
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function extract($string)
    {
        preg_match('[\d{5}\.\d{10}\.\d{11}\.\d{21}]', $string, $match);
        return $match;
    }

    /**
     * @param array $select
     * @return mixed
     */
    public static function extractIMG(array $select)
    {
        $keys = [];
        array_map(function($item) use (&$keys) {
            if(strlen($item) == 3)
                $keys[] = $item;
        }, $select);

        $matches = [];
        foreach ($select as $data) {
            if(strlen($data) > 43) {
                foreach($keys as $key) {
                    preg_match("/{$key}9\d{43}/", $data, $match);
                    if (count($match) == 0)
                        continue;

                    $matches[] = $match[0];
                }
            }
        }
        return $matches;
    }
}