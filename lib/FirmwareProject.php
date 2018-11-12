<?php

use Archive_Tar as Archive;

class FirmwareProject
{
  private $companyName;
  private $firmwareImage;
  private $needRebuildInnerPortal;
  private $utils;
  private $portal;
  private $rootfs;
  private $dir;

  public function __construct(FirmwareImage $image, $companyName)
  {
    $this->firmwareImage = $image;
    $this->setCompanyName($companyName);
    $this->needRebuildInnerPortal = false;

    $this->dir = PROJECTS . $this->companyName . '/' . $this->firmwareImage->getMagModelNumber() . '/' . $this->firmwareImage->getRootfsVersion();
  }

  public function setCompanyName($name)
  {
    $filtered = preg_replace('~[^0-9a-zA-Z_-]~', '', $name);
    if(!$filtered)
    {
      throw new Exception("Incorrect company name", 1);
    }

    $this->companyName = $filtered;
  }

  public function init()
  {
    $source = SOURCES . $this->firmwareImage->getMagModelNumber() . '/' . $this->firmwareImage->getRootfsVersion();

    if(mkdir($this->dir, 0777, true))
    {
      if(is_readable("$source/portal.tgz") && is_readable("$source/rootfs.tgz") && is_readable("$source/utils.tgz"))
      {
        $utils = new Archive("$source/utils.tgz", true);
        $utils->extract($this->dir);

        $portal = new Archive("$source/portal.tgz");
        $portal->extract("$this->dir/portal");

        $rootfs = new Archive("$source/rootfs.tgz");
        $rootfs->extract($this->dir);
        foreach(scandir($this->dir) as $dir)
        {
          if(strpos($dir, 'rootfs') === 0)
          {
            rename("$this->dir/$dir", "$this->dir/rootfs");
          }
        }
        if(!is_dir("$this->dir/rootfs"))
        {
          throw new Exception("$this->dir/rootfs directory not exist", 1);
        }

        $this->portal = "$this->dir/portal";
        $this->rootfs = "$this->dir/rootfs";
        $this->utils = "$this->dir/utils";
      }
    }
  }

  public function setEnv()
  {
    $this->setDefaultVars();
    $this->setCheckedVars();
  }

  private function setDefaultVars()
  {
    $filepath = "$this->utils/images/env_mag".$this->firmwareImage->getMagModelNumber().".txt";
    $this->writeVarsToFile($filepath, $this->firmwareImage->getDefaultVars());
  }

  private function setCheckedVars()
  {
    $vars = $this->firmwareImage->getCheckedVars();
    if(!empty($vars))
    {
      $varspath = "$this->portal/system/variables";
      foreach(['check.js', 'check.sh'] as $file)
      {
        file_put_contents("$varspath/$file", file_get_contents("$varspath/on/$file"));
      }

      $filepath = "$varspath/vars.ini";
      $this->writeVarsToFile($filepath, $vars);
      $testsh = "$this->rootfs/test.sh";
      if(is_writable($testsh))
      {
        $contents = file_get_contents($testsh);
        $newContents = str_replace('#. "${PORTAL_PATH}system/variables/check.sh"', '. "${PORTAL_PATH}system/variables/check.sh"', $contents);
        file_put_contents($testsh, $newContents);
        $this->needRebuildInnerPortal = true;
      }
    }
  }

  private function writeVarsToFile($filepath, array $vars)
  {
    if(is_writable($filepath))
    {
      file_put_contents($filepath, '', LOCK_EX); //empty the file before setting the vars

      foreach ($vars as $key => $value)
      {
        file_put_contents($filepath, "$key=$value\n", FILE_APPEND | LOCK_EX);
      }
    }
  }

  private function rebuildInnerPortal()
  {
    $tools = "$this->portal/tools/";
    if(!is_dir($tools))
    {
      throw new Exception("$tools not exist or unreachable", 1);
    }

    chdir($tools);
    exec("sudo ./phpbuild.sh");
    $innerPortal = "$this->rootfs".$this->firmwareImage->getInnerPortalPath();
    exec("rm -r $innerPortal");
    exec("cp -r $this->portal/mini/ $innerPortal");
  }

  public function buildPublicImage()
  {
    if($this->needRebuildInnerPortal)
    {
      $this->rebuildInnerPortal();
    }

    chdir($this->utils);
    $mag = $this->firmwareImage->getMagModelNumber();
    $number = $this->firmwareImage->getVersionNumber();
    $desc = $this->firmwareImage->getDescription();
    $profile = $this->makeProfile();
    $execstr = "sudo ./phpbuild.sh $mag $number $this->rootfs $desc $profile";
    exec($execstr);
    return $this->moveCreatedFile($number);
  }

  private function makeProfile()
  {
    $defaultProfilePath = "$this->utils/img_make.profile.mag".$this->firmwareImage->getMagModelNumber();
    if(!is_readable($defaultProfilePath))
    {
      throw new Exception("Can't read $defaultProfilePath", 1);
    }

    $profile = '';
    foreach (file($defaultProfilePath) as $line)
    {
      if(file_exists("$this->dir/logo.bmp.gz") && strpos($line, 'LOGOTYPE_PATH') !== false)
      {
        $profile .= "export LOGOTYPE_PATH=$this->dir/logo.bmp.gz\n";
      }
      else
      {
        $profile .= "$line";
      }
    }

    if(file_put_contents("$this->dir/profile", $profile) !== false)
    {
      return "$this->dir/profile";
    }

    throw new Exception("Unable to write $this->dir/profile file", 1);
  }

  private function moveCreatedFile($number)
  {
    $target = "$this->utils/imageupdate";
    if(file_exists($target))
    {
      $linkUri = '/images/' . "$this->companyName-".$this->firmwareImage->getMagModelNumber()."-$number-imageupdate";
      $link = $_SERVER['DOCUMENT_ROOT'] . $linkUri;
      $result = symlink($target, $link);
      if($result)
      {
        return $linkUri;
      }
      return null;
    }
    throw new Exception("$target was not created", 1);
  }
}

 ?>
