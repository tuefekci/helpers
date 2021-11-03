<?php

namespace tuefekci\helpers;

/**
* Cli Class
*
* This class offers function and helpers for working with the cli.
*
* @author Giacomo Tüfekci
* @package tuefekci\helpers
*/
class Cli
{

    private static $instance;
    private \League\CLImate\CLImate $climate;

    public function __construct()
    {
      if (is_null(self::$instance)) {
        self::$instance = $this;

        $this->climate = new \League\CLImate\CLImate;
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


    public static function banner(string $name=null, string $url=null) {
      $_this = self::getInstance();

      $_this->climate->clear();
      $_this->climate->break();
      $_this->climate->lightGreen()->border("/");


      $_this->climate->lightGreen()->inline('//');
      if($name) {
        $_this->climate->lightGreen()->inline(' '.$name.'');
      }
    
      $_this->climate->lightGreen()->inline(' (c) 2020-'.date("Y").' Giacomo Tüfekci');
      $_this->climate->lightGreen()->break();

      if($url) {
        $_this->climate->lightGreen()->out('// '.$url);
      }

      $_this->climate->lightGreen()->border("/");
      $_this->climate->lightGreen()->break();

    }

    public static function Log(string $level, string $message, int $timestamp = null) {
      $_this = self::getInstance();

      if (is_null($timestamp)) {
        $timestamp = date('Y-m-d H:i:s');
      }

      $backgroundColor = "Black";

      switch ($level) {
        case "debug":
          $color = "LightBlue";
          break;
        case "info":
          $color = "LightCyan";
          break;
        case "notice":
          $color = "LightYellow";
          break;
        case "warning":
          $color = "Yellow";
          break;
        case "error":
          $color = "White";
          $backgroundColor = "Red";
          break;
        case "critical":
          $color = "White";
          $backgroundColor = "Red";
          break;
        case "alert":
          $color = "White";
          $backgroundColor = "Red";
          break;
        case "emergency":
          $color = "White";
          $backgroundColor = "Red";
          break;
        default:
          $color = "White";
          break;
      }

      $background = "background".$backgroundColor;

      $_this->climate->$background()->$color()->out('// [' . $timestamp . '] ' . strtoupper($level) . ': ' . $message);

      return $_this;
    }


}
