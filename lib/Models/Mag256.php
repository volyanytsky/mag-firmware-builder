<?php

namespace Models;

use \MagModelInterface;

class Mag256 implements MagModelInterface
{
  public function getModelNumber()
  {
    return 256;
  }

  public function getInnerPortalPath()
  {
    return '/usr/local/share/app/web/';
  }

  public function getChipsetType()
  {
    return 'stm';
  }

  public function getKernelFilename()
  {
    return 'uImage_mag'.$this->getModelNumber().'.clean';
  }
}



 ?>
