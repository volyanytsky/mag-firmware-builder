<?php

namespace Models;

use \MagModelInterface;

class Mag250 implements MagModelInterface
{
  public function getModelNumber()
  {
    return 250;
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
