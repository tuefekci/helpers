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

    public static function Log($level, $message, $timestamp = null) {
      $_this = self::getInstance();

      if (is_null($timestamp)) {
        $timestamp = date('Y-m-d H:i:s');
      }

      $backgroundColor = "Black";

      switch ($level) {
        case "DEBUG":
          $color = "LightBlue";
          break;
        case "INFO":
          $color = "LightCyan";
          break;
        case "NOTICE":
          $color = "LightYellow";
          break;
        case "WARNING":
          $color = "Yellow";
          break;
        case "ERROR":
          $color = "White";
          $backgroundColor = "Red";
          break;
        case "CRITICAL":
          $color = "White";
          $backgroundColor = "Red";
          break;
        case "ALERT":
          $color = "White";
          $backgroundColor = "Red";
          break;
        case "EMERGENCY":
          $color = "White";
          $backgroundColor = "Red";
          break;
        default:
          $color = "White";
          break;
      }

      $background = "background".$backgroundColor;

      $_this->climate->$background()->$color()->out('[' . $timestamp . '] ' . strtoupper($level) . ': ' . $message);

      return $_this;
    }


}
