<?php

namespace Inpin\Foundation\Utils;


class Settings
{
    const PAGE_SIZE = 25;

    /**
     * Append given prefix to given array's keys.
     *
     * @param array $array
     * @param $prefix
     * @return array
     */
    public static function appendPrefixToArrayKeys(array $array, $prefix)
    {
        foreach ($array as $key => $value) {
            $array[$prefix . $key] = $value;
            unset($array[$key]);
        }

        return $array;
    }

    /**
     * Append given parent name to the the given array.
     *
     * @param array $array
     * @param $parent
     * @return array
     */
    public static function appendParentToArrayKeys(array $array, $parent)
    {
        if ($parent == '') {
            return $array;
        }

        return self::appendPrefixToArrayKeys($array, $parent . '.');
    }
}
