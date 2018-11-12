<?php

namespace Models;

use \MagModelInterface;

class Mag349 implements MagModelInterface
{
  public function getModelNumber()
  {
    return 349;
  }

  public function getInnerPortalPath()
  {
    return '/usr/local/share/app/web/';
  }

  public function getChipsetType()
  {
    return 'broadcom';
  }

  public function getKernelFilename()
  {
    return 'uImage_mag'.$this->getModelNumber().'.clean';
  }
}



 ?>
