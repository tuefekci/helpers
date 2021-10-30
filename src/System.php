<?php

namespace tuefekci\helpers;

class System
{

    /**
     *
     * @var Singleton
     */
    private static $instance;
    private static $state = array();

    public static function isWin()
    {
        return stristr(PHP_OS, 'win');
    }

    public static function isDocker(): bool
    {
        if(empty(self::$state['isDocker'])) {

            if(!empty($_SERVER['DOCKER_HOST'])) {
                return self::$state['isDocker'] = true;
            }

            if(!empty(getenv('IS_DOCKER'))) {
                return self::$state['isDocker'] = true;
            }

            // last way of checking
            $processStack = explode(PHP_EOL, shell_exec('cat /proc/self/cgroup'));
            $processStack = array_filter($processStack); // remove empty item made by EOL
        
            foreach ($processStack as $process) {
                if (strpos($process, 'docker') === false) {
                    return false;
                }
            }
        
            return true;
           
        } else {
            return self::$state['isDocker'];
        }

    }

	private function windowsWmic(string $type, string $value) 
	{
		return trim(shell_exec("wmic ".$type." get ".$value." | more +1"));
	}

    private function getOperatingSystemData($value)
    {
    }

    private function getCpuSystemData($value)
    {
		if($this->isWin()) {
			return $this->windowsWmic("cpu", "LoadPercentage");
		}
    }

    private function getMemorySystemData($value)
    {
		if($this->isWin()) {
			return $this->windowsWmic("memphysical", $value);
		}
    }

    private function getBoardSystemData($value)
    {
        //baseboard
    }

    private function getMemory() 
	{
        if($this->isWin()) {
			return $this->getMemorySystemData("maxcapacity");
        }
    }

    public function getLoad()
	{
        if($this->isWin()) {
			return $this->getMemorySystemData("LoadPercentage");
        } else {
            $sys_load = sys_getloadavg();
            return $sys_load[0];
        }
    }

    public function getMemoryUsage() 
	{
        return round(memory_get_usage(true)/1000);
    }


}
