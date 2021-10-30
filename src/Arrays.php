<?php

namespace tuefekci\helpers;

/**
* Arrays Class
*
* This class offers function and helpers for working with arrays.
*
* @author Giacomo Tüfekci
* @package tuefekci\helpers
*/
class Arrays
{
    public function __construct()
    {
        return $this;
    }

    /**
    * Get the first element of an array.
    *
    * @param array $array The array to get the first element from.
    * @return mixed The first element of the array.
    */
    public static function first(array $array)
    {
        return $array[self::firstKey($array)];
    }

    /**
    * Get the last element of an array.
    *
    * @param array $array The array to get the last element from.
    * @return mixed The last element of the array.
    */
    public static function last(array $array)
    {
        return $array[self::lastKey($array)];
    }


    /**
    * Get the first key of an array.
    *
    * @param array $array The array to get the first key from.
    * @return mixed The first key of the array.
    */
    public static function firstKey(array $array)
    {
        return array_key_first($array);
    }

    /**
    * Get the last key of an array.
    *
    * @param array $array The array to get the last key from.
    * @return mixed The last key of the array.
    */
    public static function lastKey(array $array)
    {
        return array_key_last($array);
    }

    /**
     * Get previous array element.
     *
     * @param array $array
     * @param $currentKey
     * @return void element
     */
    public static function prev(array $array, $currentKey)
    {
        $result = self::neighbors($array, $currentKey);

        if ($result && isset($result['prev'])) {
            return $result['prev'];
        }

        return false;
    }

    /**
     * Get next array element.
     *
     * @param array $array
     * @param $currentKey
     * @return void element
     */
    public static function next(array $array, $currentKey)
    {
        $result = self::neighbors($array, $currentKey);

        if ($result && isset($result['next'])) {
            return $result['next'];
        }

        return false;
    }
    
    /**
     * Get keys of the neighboring array elements.
     *
     * @param array $array
     * @param $currentKey
     * @return array keys
     */
    public static function neighborKeys(array $array, $currentKey)
    {
        if (!isset($array[$currentKey])) {
            return false;
        }

        krsort($array);
        $keys = array_keys($array);
        $keyIndexes = array_flip($keys);

        $return = array();
        if (isset($keys[$keyIndexes[$currentKey]-1])) {
            $return['next'] = $keys[$keyIndexes[$currentKey]-1];
        }
        if (isset($keys[$keyIndexes[$currentKey]+1])) {
            $return['prev'] = $keys[$keyIndexes[$currentKey]+1];
        }
    
        return $return;
    }
    /**
     * Get neighboring array elements.
     *
     * @param array $array
     * @param $currentKey
     * @return array values
     */
    public static function neighbors(array $array, $currentKey)
    {
        if (!isset($array[$currentKey])) {
            return false;
        }

        $result = self::neighborKeys($array, $currentKey);

        $return = array();
        if ($result && isset($result['next'])) {
            $return['next'] = $result['next'];
        }
        if ($result && isset($result['prev'])) {
            $return['prev'] = $result['prev'];
        }

        return $return;
    }
}
