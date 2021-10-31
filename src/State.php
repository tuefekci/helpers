<?php

namespace tuefekci\helpers;

/**
* State Class
*
* This class offers function and helpers for working with the app state.
*
* @author Giacomo Tüfekci
* @package tuefekci\helpers
*/
class State
{
	    /**
     * Returns the current state of the application.
     *
     * @return string
     */
    public static function getState()
    {
        $state = 'development';

        if (isset($_SERVER['APP_ENV'])) {
            $state = $_SERVER['APP_ENV'];
        }

		if(getenv('APP_ENV')) {
			$state = getenv('APP_ENV');
		}

        return $state;
    }

    /**
     * Returns true if the current state is 'production'
     *
     * @return boolean
     */
    public static function isProduction()
    {
        return self::getState() === 'production';
    }

    /**
     * Returns true if the current state is 'development'
     *
     * @return boolean
     */
    public static function isDevelopment()
    {
        return self::getState() === 'development';
    }
}