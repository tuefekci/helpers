<?php

class Cli
{

    /**
     *
     * @var Singleton
     */
    private static $instance;

    private function __construct()
    {
      // Your "heavy" initialization stuff here
    }
  
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
  
    public static function someStaticMethod()
    {
      $_this = self::getInstance();
    }

    public function someMethod1()
    {
      // whatever
    }
  
    public function someMethod2()
    {
      // whatever
    }


    private function out($color, $message, $header=false) {

      $this->cli->$color()->inline("[".date("Y-m-d H:i:s")."] ");

      if($header && is_string($header)) {
          $this->cli->$color()->inline("(".$header.") ");
      }

      if(is_string($message)) {
          $this->cli->inline($message);
          $this->cli->break();
      } elseif(is_array($message)) {
          var_dump($message);
      } else {
          $this->cli->break();
      }
    }

    public function log($message, $header=false) {
      $this->out("Yellow", $message, $header);
    }

    public function info($message, $header=false) {
      $this->out("Cyan", $message, $header);
    }

    public function warn($message, $header=false) {
      $this->out("Orange", $message, $header);
    }

    public function error($message, $header=false) {
      $this->out("Red", $message, $header);
    }


}
