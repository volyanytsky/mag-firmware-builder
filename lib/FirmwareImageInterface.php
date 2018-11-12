<?php

interface FirmwareImageInterface
{
  public function getMagModelNumber();
  public function getDescription();
  public function getRootfsVersion();
  public function getVersionNumber();
  public function getCheckedVars();
  public function getDefaultVars();
  public function getInnerPortalPath();
  public function getUtilsFolderName();
}


 ?>
