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
 * Logger Class
 *
 * This class offers implementing of a \Psr\Log\LoggerInterface (PSR-3) and some adjustments
 *
 * @author Giacomo Tüfekci
 * @package tuefekci\helpers
 */

class Logger extends AbstractLogger
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

	/**
     * @var int How much call stack information (file name and line number) should be logged for each log message.
     *
     * If it is greater than 0, at most that number of call stacks will be logged.
     * Note that only application call stacks are counted.
     */
    private int $traceLevel = 0;

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
	protected function format($level, $message, array $context)
	{
		return '[' . date('Y-m-d H:i:s'). '] ' . strtoupper($level) . ': ' . $this->interpolate($message, $context) . "\n";
	}

	public function log($level, $message, array $context = array())
	{
		if (!$this->min_level_reached($level)) {
			return;
		}

		if (($message instanceof Throwable) && !isset($context['exception'])) {
            // exceptions are string-convertible, thus should be passed as it is to the logger
            // if exception instance is given to produce a stack trace, it MUST be in a key named "exception".
            $context['exception'] = $message;
        }

		$context['time'] ??= microtime(true);
        $context['trace'] ??= $this->collectTrace(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
        $context['memory'] ??= memory_get_usage();

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

	    /**
     * Collects a trace when tracing is enabled with {@see Logger::setTraceLevel()}.
     *
     * @param array $backtrace The list of call stack information.
     *
     * @return array Collected a list of call stack information.
     */
    private function collectTrace(array $backtrace): array
    {
        $traces = [];

        if ($this->traceLevel > 0) {
            $count = 0;

            foreach ($backtrace as $trace) {
                if (isset($trace['file'], $trace['line'])) {
                    $excludedMatch = array_filter($this->excludedTracePaths, static function ($path) use ($trace) {
                        return strpos($trace['file'], $path) !== false;
                    });

                    if (empty($excludedMatch)) {
                        unset($trace['object'], $trace['args']);
                        $traces[] = $trace;
                        if (++$count >= $this->traceLevel) {
                            break;
                        }
                    }
                }
            }
        }

        return $traces;
    }



	

}