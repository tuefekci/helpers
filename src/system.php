<?php

class System
{

    /**
     *
     * @var Singleton
     */
    private static $instance;

    public function isWin()
    {
        return stristr(PHP_OS, 'win');
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
