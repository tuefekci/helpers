<?php

namespace tuefekci\helpers;

/**
* Store Class
*
* This is a basic array store useful for storing app state data.
*
* @author Giacomo Tüfekci
* @package tuefekci\helpers
*/
class Store
{
	/**
	* @var array
	*/
	private $data = [];
    private static $instance;

    public function __construct()
    {
      if (is_null(self::$instance)) {
        self::$instance = $this;
      }

      return $this;
    }

    private static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

	/**
	* @param string $key
	* @return mixed
	*/
	public static function get($key)
	{
		$_this = self::getInstance();
		return $_this->data[$key];
	}

	/**
	* @param string $key
	* @param mixed $value
	*/
	public static function set($key, $value)
	{
		$_this = self::getInstance();
		$_this->data[$key] = $value;
	}

	/**
	* @param string $key
	* @return bool
	*/
	public static function has($key)
	{
		$_this = self::getInstance();
		return isset($_this->data[$key]);
	}

	/**
	* @param string $key
	*/
	public static function remove($key)
	{
		$_this = self::getInstance();
		unset($_this->data[$key]);
	}

	/**
	* @return array
	*/
	public static function all()
	{
		$_this = self::getInstance();
		return $_this->data;
	}

	/**
	* @return array
	*/
	public static function list()
	{
		$_this = self::getInstance();
		return $_this->all();
	}

	/**
	 * @return array
	*/
	public static function keys()
	{
		$_this = self::getInstance();
		return array_keys($_this->data);
	}

	/**
	 * @return int
	*/
	public static function count()
	{
		$_this = self::getInstance();
		return count($_this->data);
	}

	/**
	* @return void
	*/
	public static function clear()
	{
		$_this = self::getInstance();
		$_this->data = [];
	}

	// TODO: Switch to internal filesystem
	public static function load($path)
	{
		$_this = self::getInstance();
		$_this->data = json_decode(file_get_contents($path), true);
	}

	// TODO: Switch to internal filesystem
	public static function save($path)
	{
		$_this = self::getInstance();
		file_put_contents($path, json_encode($_this->data));
	}

}