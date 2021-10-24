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
     * first
     *
     * Get first array element.
     *
     * @param array $array
     * @return void element
     */
    public static function first(array $array)
    {
        return $array[array_key_first($array)];
    }

    /**
     * last
     *
     * Get last array element.
     *
     * @param array $array
     * @return void element
     */
    public static function last(array $array)
    {
        return $array[array_key_last($array)];
    }

    /**
     * prev
     *
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
     * next
     *
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
     * neighbor keys
     *
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
     * neighbors
     *
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
