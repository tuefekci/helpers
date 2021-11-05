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



        /**
    * Convert a string to camel case
    *
    * @param string $string The string to convert
    * @param bool $capitalizeFirstCharacter If true, capitalize the first character in the string
    * @return string The converted string
    */
    public static function toCamelCase($string, $capitalizeFirstCharacter = false)
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }

    /**
    * Convert a string to snake case
    *
    * @param string $string The string to convert
    * @param string $delimiter The delimiter
    * @return string The converted string
    */
    public static function toSnakeCase($string, $delimiter = '_')
    {
        $snake = preg_replace('/\s+/u', '', $string);
        $snake = preg_replace('/([A-Z])/u', '$1'.$delimiter, $snake);

        return strtolower($snake);
    }

    /**
    * Convert a string to kebab case
    *
    * @param string $string The string to convert
    * @param string $delimiter The delimiter
    * @return string The converted string
    */
    public static function toKebabCase($string, $delimiter = '-')
    {
        return static::toSnakeCase($string, $delimiter);
    }

    /**
    * Convert a string to sentence case
    *
    * @param string $string The string to convert
    * @return string The converted string
    */
    public static function toSentenceCase($string)
    {
        return ucfirst(strtolower($string));
    }


    /**
    * Returns a string with the first letter capitalized.
    *
    * @param string $str The string to capitalize.
    * @param string $encoding The encoding of the string.
    * @return string The capitalized string.
    */
    public static function capitalize($str, $encoding = 'UTF-8')
    {
        return mb_convert_case($str, MB_CASE_TITLE, $encoding);
    }


    /**
     * Convert a string to a slug.
     *
     * @param string $string
     * @return string
     */
    public static function slug(string $string): string
    {
        $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower($string));

        return trim($slug, '-');
    }

    /**
     * Truncate a string to a certain length.
     *
     * @param  string  $string
     * @param  int  $limit
     * @param  string  $end
     * @return string
     */
    public static function truncate($string, $limit, $end = '...')
    {
        if (strlen($string) <= $limit) {
            return $string;
        }

        return rtrim(substr($string, 0, $limit)) . $end;
    }

    /**
    * Count the number of words in a string.
    *
    * @param string $string The string to count the words for.
    * @return int The number of words in the string.
    */
    public static function countWords($string)
    {
        return count(preg_split('/\s+/', $string));
    }

    /**
    * Get the string length.
    *
    * @param string $string The string to count the characters for.
    * @return int The number of characters in the string.
    */
    public static function length($string)
    {
        return mb_strlen($string);
    }

    /**
     * Get the string length.
    *
    * @param string $string
    * @return int
    */
    public static function count($string)
    {
        return mb_strlen($string);
    }

    /**
     * Get the string length.
    *
    * @param string $string
    * @return int
    */
    public static function size($string)
    {
        return mb_strlen($string);
    }

    /**
    * Count the number of lines in a string.
    *
    * @param string $string The string to count the lines for.
    * @return int The number of lines in the string.
    */
    public static function countLines($string)
    {
        return substr_count($string, "\n") + 1;
    }

	/**
	* Generates a random string of specified length.
	*
	* @param int $length
	* @param string $characters
	* @return string
	*/
	public static function random($length = 8, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

    /**
     * Returns a random string of a given length.
     *
     * @param int $length The length of the string
     * @param string $chars The characters to use for the string
     * @return string
     */
    public static function random_alpha($length = 8, $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        return static::random($length, self::removeNonAlphanumeric($chars));
    }

    /**
     * Returns a random number of a given length.
     *
     * @param int $length The length of the string
     * @param string $chars The characters to use for the string
     * @return string
     */
    public static function random_int($length = 8, $chars = '0123456789')
    {
        return static::random($length, self::removeNonNumeric($chars));
    }


	/**
	* Removes all non-ASCII characters from a string.
	*
	* @param string $string
	* @return string
	*/
	public static function removeNonASCII($string)
	{
		$string = preg_replace('/[^\x20-\x7f]/', '', $string);
		return $string;
	}

	/**
	* Removes all non-alphanumeric characters from a string.
	*
	* @param string $string
	* @return string
	*/
	public static function removeNonAlphanumeric($string)
	{
		$string = preg_replace('/[^a-z0-9]/i', '', $string);
		return $string;
	}

	/**
	* Removes all non-numeric characters from a string.
	*
	* @param string $string
	* @return string
	*/
	public static function removeNonNumeric($string)
	{
		$string = preg_replace('/[^0-9]/', '', $string);
		return $string;
	}

    /**
     * Checks if the given string is a valid email.
     *
     * @param string $string The string to check.
     * @return bool
     */
    public static function isEmail(string $string) : bool
    {
        return filter_var($string, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Checks if the given string is a valid url.
     *
     * @param string $string The string to check.
     * @return bool
     */
    public static function isUrl(string $string) : bool
    {
        return filter_var($string, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Checks if the given string is a valid IP address.
     *
     * @param string $string The string to check.
     * @return bool
     */
    public static function isIp(string $string) : bool
    {
        return filter_var($string, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6) !== false;
    }

    /**
     * Checks if the given string contains needle.
     *
     * @param string $string The string to check.
     * @return bool
     */
    public static function contains($string, $needle)
    {
        return strpos($string, $needle) !== false;
    }

	/**
	* get content between to strings in string
	*
	* @param string $string
	* @return string
	*/
    public static function getBetween(string $content, string $start, string $end)
    {
        $r = explode($start, $content);
        if (isset($r[1])) {
            $r = explode($end, $r[1]);
            return $r[0];
        }
        return false;
    }

    /**
	* formats byte size to human readable string
	*
	* @param string $string
	* @return string
	*/
    public static function filesizeFormatted($size)
    {
        $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    public static function sanitizeFilename($filename)
    {
        $filename = preg_replace('/[^a-z0-9_\-\.]/i', '', $filename);
        return $filename;
    }

    public static function sanitizePath($path)
    {
        $path = preg_replace('/[^a-z0-9_\-\/]/i', '', $path);
        return $path;
    }

    public static function sanitizeUrl($url)
    {
        $url = preg_replace('/[^a-z0-9_\-\/]/i', '', $url);
        return $url;
    }


}
