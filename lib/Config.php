<?php

class Config
{
  static private $instance = null;

  private $ini;

  private function __construct()
  {
    $this->ini = __DIR__ . '/../config/config.ini';
    if(!is_readable($this->ini))
    {
      throw new Exception("Can't read $this->ini", 1);
    }
  }

  static public function getInstance()
  {
    if(self::$instance === null)
    {
      return new self();
    }
    return self::$instance;
  }

  public function get()
  {
    return parse_ini_file($this->ini, true);
  }

  public function getSection($section)
  {
    $config = $this->get();
    if(isset($config[$section]))
    {
      return $config[$section];
    }
    return null;
  }

  public function getParam($param)
  {
    $config = parse_ini_file($this->ini);
    if(isset($config[$param]))
    {
      return $config[$param];
    }
    return null;
  }
}


 ?>
