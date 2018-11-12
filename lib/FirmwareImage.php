<?php

class FirmwareImage implements FirmwareImageInterface
{
  private $model;
  private $description;
  private $number;
  private $rootfsVersion;
  private $env;

  public function __construct(MagModelInterface $mag, $description, $number, $rootfsVersion)
  {
    $this->model = $mag;
    $this->setDescription($description);
    $this->setImageNumber($number);
    $this->setRootfsVersion($rootfsVersion);
  }

  public function setDescription($description)
  {
    $filtered = preg_replace('~[^0-9a-zA-Z_-]~', '', $description);
    if($filtered)
    {
      $this->description = $filtered;
    }
    else
    {
      throw new Exception("Incorrect firmware image description", 1);
    }
  }

  public function setImageNumber($number)
  {
    if(!preg_match('~^([0-9]){3}$~', $number))
    {
      throw new Exception("Incorrect firmware image number. It must be 3 digits", 1);
    }
    $this->number = $number;
  }

  public function setRootfsVersion($version)
  {
    $allPossibleVersions = Config::getInstance()->getSection('firmware_versions');
    $modelPossibleVersions = $allPossibleVersions[$this->getMagModelNumber()];
    if(!in_array($version, $modelPossibleVersions))
    {
      throw new Exception("can't build $version for MAG" . $this->getModelNumber(), 1);
    }
    $this->rootfsVersion = $version;
  }

  public function setEnv(Env $env)
  {
    $this->env = $env;
  }

  public function getCheckedVars()
  {
    if($this->env)
    {
      return $this->env->getChecked();
    }
  }

  public function getDefaultVars()
  {
    if($this->env)
    {
      return $this->env->getDefault();
    }
  }

  public function getMagModelNumber()
  {
    return $this->model->getModelNumber();
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function getRootfsVersion()
  {
    return $this->rootfsVersion;
  }

  public function getVersionNumber()
  {
    return $this->number;
  }

  public function getInnerPortalPath()
  {
    return $this->model->getInnerPortalPath();
  }

  public function getUtilsFolderName()
  {
    return $this->model->getChipsetType();
  }

}

 ?>
