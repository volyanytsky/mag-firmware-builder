<?php

namespace Models;

use \MagModelInterface;

class Mag270 implements MagModelInterface
{
  public function getModelNumber()
  {
    return 270;
  }

  public function getInnerPortalPath()
  {
    return '/home/web/';
  }

  public function getChipsetType()
  {
    return 'stm';
  }

  public function getKernelFilename()
  {
    return 'vmlinux.bin.mag' . $this->getModelNumber();
  }
}



 ?>
