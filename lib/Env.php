<?php

class Env
{
  private $default;
  private $checked;

  public function addDefault($key, $value)
  {
    $this->default[$key] = $value;
  }

  public function addChecked($key, $value)
  {
    $this->checked[$key] = $value;
  }

  public function setDefault(array $vars)
  {
    $this->default = $vars;
  }

  public function setChecked(array $vars)
  {
    $this->checked = $vars;
  }

  public function getChecked()
  {
    return $this->checked;
  }

  public function getDefault()
  {
    return $this->default;
  }

  public function getVars()
  {
    return [
      'checked' => $this->getChecked(),
      'default' => $this->getDefault()
    ];
  }
}



 ?>
