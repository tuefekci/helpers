<?php

namespace tuefekci\helpers;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

abstract class LogType extends BasicEnum {
    const CLI 	= 0;
    const FILE 	= 1;
    const ECHO 	= 2;
    const ARRAY = 3;
}

/**
 * Log Class
 *
 * This class offers implementing of a \Psr\Log\LoggerInterface (PSR-3) and some adjustments
 *
 * @author Giacomo Tüfekci
 * @package tuefekci\helpers
 */

class Log extends AbstractLogger
{

	protected $min_level = LogLevel::DEBUG;
	protected $levels = [
		LogLevel::DEBUG,
		LogLevel::INFO,
		LogLevel::NOTICE,
		LogLevel::WARNING,
		LogLevel::ERROR,
		LogLevel::CRITICAL,
		LogLevel::ALERT,
		LogLevel::EMERGENCY
	];
	protected $types = [
		LogType::CLI,
		LogType::FILE,
	];

	public function __construct($min_level = LogLevel::DEBUG, $type = LogType::CLI)
	{
		$this->min_level = $min_level;
		$this->type = $type;
	}

    public function __call($name, $arguments) {
        if (in_array($name, $this->levels)) {

        }
    }

    public static function __callStatic($name, $arguments) {
    }


	/**
	 * @param string $level
	 * @return boolean
	 */
	protected function min_level_reached($level)
	{
		return \array_search($level, $this->levels) >= \array_search($this->min_level, $this->levels);
	}

	/**
	 * Interpolates context values into the message placeholders.
	 *
	 * @author PHP Framework Interoperability Group
	 *
	 * @param string $message
	 * @param array $context
	 * @return string
	 */
	protected function interpolate($message, array $context)
	{
		if (false === strpos($message, '{')) {
			return $message;
		}

		$replacements = array();
		foreach ($context as $key => $val) {
			if (null === $val || is_scalar($val) || (\is_object($val) && method_exists($val, '__toString'))) {
				$replacements["{{$key}}"] = $val;
			} elseif ($val instanceof \DateTimeInterface) {
				$replacements["{{$key}}"] = $val->format(\DateTime::RFC3339);
			} elseif (\is_object($val)) {
				$replacements["{{$key}}"] = '[object ' . \get_class($val) . ']';
			} else {
				$replacements["{{$key}}"] = '[' . \gettype($val) . ']';
			}
		}

		return strtr($message, $replacements);
	}

	/**
	 * @param string $level
	 * @param string $message
	 * @param array $context
	 * @return string
	 */
	protected function format($level, $message, $context)
	{
		return '[' . date('Y-m-d H:i:s'). '] ' . strtoupper($level) . ': ' . $this->interpolate($message, $context) . "\n";
	}

	public function log($level, $message, array $context = array())
	{
		if (!$this->min_level_reached($level)) {
			return;
		}

		if($this->type == LogType::CLI) {
			\tuefekci\helpers\Cli::log($level, $this->interpolate($message, $context));
		} elseif($this->type == LogType::FILE) {
			// TODO: Implement File logging
		} elseif($this->type == LogType::ECHO) {
			echo $this->format($level, $message, $context);	
		} elseif($this->type == LogType::ARRAY) {
			// TODO: Implement Array logging
		}

	}



	

}
