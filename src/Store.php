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
		if(self::getInstance()->has($key)) {
			return self::getInstance()->data[$key]['value'];
		} else {
			return false;
		}
	}

	/**
	* @param string $key
	* @param mixed $value
	*/
	public static function set($key, $value, $ttl = null)
	{
		if(!empty($ttl)) {
			$ttl = time() + $ttl;
		}

		$_this = self::getInstance();
		$_this->data[$key] = array('value' => $value, 'ttl'=> $ttl);
	}

	/**
	* @param string $key
	* @return bool
	*/
	public static function has($key)
	{
		if(isset(self::getInstance()->data[$key])) {

			if(!empty(self::getInstance()->data[$key]['ttl'])) {
				if(self::getInstance()->data[$key]['ttl'] < time()) {
					unset(self::getInstance()->data[$key]);
					return false;
				}
			}

			return true;
		}
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

		$data = array();

		foreach(self::getInstance()->data as $key => $value) {
			if(self::getInstance()->has($key)) {
				$data[$key] = $value['value'];
			}
		}

		return $data;
	}

	/**
	* @return array
	*/
	public static function list()
	{
		return self::getInstance()->all();
	}

	/**
	 * @return array
	*/
	public static function keys()
	{
		return array_keys(self::getInstance()->all());
	}

	/**
	 * @return int
	*/
	public static function count()
	{
		return count(self::getInstance()->all());
	}

	/**
	* @return void
	*/
	public static function clear()
	{
		self::getInstance()->datadata = [];
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