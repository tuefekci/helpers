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



    // =========================================================================
    // isOS functions

    public static function isDocker(): bool
    {

        // TODO: This does not work reliable at the moment

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


    public static function isMac()
    {
        return stristr(PHP_OS, 'darwin');
    }

    public static function isLinux()
    {
        return stristr(PHP_OS, 'linux');
    }

    public static function isUnix()
    {
        return stristr(PHP_OS, 'unix');
    }

    public static function isWin()
    {
        return self::isWindows();
    }

    public static function isWindows()
    {
        return stristr(PHP_OS, 'win');
    }

    public static function isCLI()
    {
        return (php_sapi_name() === 'cli');
    }

    public static function isCLI_PHP()
    {
        return (php_sapi_name() === 'cli-server');
    }

    public static function isCLI_CGI()
    {
        return (php_sapi_name() === 'cgi');
    }

    public static function isCLI_CGI_PHP()
    {
        return (php_sapi_name() === 'cgi-fcgi');
    }

    public static function isCLI_CGI_FAST_CGI()
    {
        return (php_sapi_name() === 'fastcgi');
    }

    // =========================================================================

    // =========================================================================
    // get Hardware Info functions

    public static function getOS()
    {
        return PHP_OS;
    }

    public static function getMemory() 
	{
        if(self::isWin()) {

        } else {
            return trim(shell_exec("free -b | awk '/Mem/ {print $2}'"));
        }
    }

    public static function getMemoryUsage() 
	{
        if(self::isWin()) {

        } else {
            return trim(shell_exec("free -b | awk '/Mem/ {print $3}'"));
        }
    }

    public static function getMemoryFree()
    {
        if(self::isWin()) {

        } else {
            return trim(shell_exec("free -b | awk '/Mem/ {print $4}'"));
        }
    }

    public static function getMemoryAvailable()
    {
        if(self::isWin()) {

        } else {
            return trim(shell_exec("free -b | awk '/Mem/ {print $7}'"));
        }
    }

    public static function getCpuUsage()
    {
        if(self::isWin()) {

        } else {
            $sys_load = sys_getloadavg();
            return $sys_load[0];
        }
    }

    /**
     * Determine the total number of CPU cores on the system.
     *
     * @return int
     */
    public static function countCpuCores(): int
    {
        static $cores;

        if ($cores !== null) {
            return $cores;
        }

        $os = (\stripos(\PHP_OS, "WIN") === 0) ? "win" : \strtolower(\PHP_OS);

        switch ($os) {
            case "win":
                $cmd = "wmic cpu get NumberOfCores";
                break;
            case "linux":
            case "darwin":
                $cmd = "getconf _NPROCESSORS_ONLN";
                break;
            case "netbsd":
            case "openbsd":
            case "freebsd":
                $cmd = "sysctl hw.ncpu | cut -d ':' -f2";
                break;
            default:
                $cmd = null;
                break;
        }

        $execResult = $cmd ? \shell_exec($cmd) : 1;

        if ($os === 'win') {
            $execResult = \explode("\n", $execResult)[1];
        }

        $cores = (int) \trim($execResult);

        return $cores;
    }

    /*

    function randomSysInfo() {
	//cpu stat
	$cpu = shell_exec('cat /proc/cpuinfo');
	$cpu = explode("\n", $cpu);
	$cpu = array_filter($cpu, function ($item) {
		return strpos($item, ':') !== false;
	});
	$cpu = array_map(function ($item) {
		return explode(':', $item);
	}, $cpu);
	$cpu = array_combine(array_column($cpu, 0), array_column($cpu, 1));


	//$cpu_result = shell_exec("cat /proc/cpuinfo | grep model\ name");
	//$stat['cpu_model'] = trim(str_replace(array('model name',' : '),'',$cpu_result));
	$stat['cpu_cores'] = shell_exec("cat /proc/cpuinfo | grep 'cpu cores' | uniq | awk '{print $4}'");
	$stat['cpu_freq'] = shell_exec("cat /proc/cpuinfo | grep 'cpu MHz' | uniq | awk '{print $4}'");
	$stat['cpu_temp'] = shell_exec("cat /sys/class/thermal/thermal_zone0/temp");
	$stat['cpu_temp'] = round($stat['cpu_temp'] / 1000, 1);
	$stat['cpu_temp_unit'] = '°C';



	//memory stat
	$stat['mem_percent'] = round(shell_exec("free | grep Mem | awk '{print $3/$2 * 100.0}'"), 2);
	$mem_result = shell_exec("cat /proc/meminfo | grep MemTotal");
	$stat['mem_total'] = round(preg_replace("#[^0-9]+(?:\.[0-9]*)?#", "", $mem_result) / 1024 / 1024, 3);
	$mem_result = shell_exec("cat /proc/meminfo | grep MemFree");
	$stat['mem_free'] = round(preg_replace("#[^0-9]+(?:\.[0-9]*)?#", "", $mem_result) / 1024 / 1024, 3);
	$stat['mem_used'] = $stat['mem_total'] - $stat['mem_free'];
	//hdd stat
	$stat['hdd_free'] = round(disk_free_space("/") / 1024 / 1024 / 1024, 2);
	$stat['hdd_total'] = round(disk_total_space("/") / 1024 / 1024/ 1024, 2);
	$stat['hdd_used'] = $stat['hdd_total'] - $stat['hdd_free'];
	$stat['hdd_percent'] = round(sprintf('%.2f',($stat['hdd_used'] / $stat['hdd_total']) * 100), 2);
	
	return $stat;
}

    */

    public static function getStorage()
    {
        if(self::isWin()) {

        } else {

            $df = shell_exec('df -h');
            $df = array_filter(explode(PHP_EOL, $df));
            $df = array_slice($df, 1);

            $df = array_map(function($item) {
                $item = array_filter(explode(' ', $item), 'strlen');
                $item = array_values($item);

                return [
                    'filesystem' => $item[0],
                    'size' => $item[1],
                    'used' => $item[2],
                    'available' => $item[3],
                    'percentage' => $item[4],
                    'mount' => $item[5]
                ];
            }, $df);

            return $df;

        }
    }

    // =========================================================================

}
