<?php

use Models\Mag250;
use Models\Mag254;
use Models\Mag256;
use Models\Mag270;
use Models\Mag324;
use Models\Mag349;
use Models\Mag351;

class MagFactory
{
  static public function create($modelNumber)
  {
    switch($modelNumber)
    {
      case (preg_match('~^(250|254|256|349|351)$~', $modelNumber) ? true : false):
        $mag = "Models\Mag$modelNumber";
        return new $mag();

      case (preg_match('~^(270|275)$~', $modelNumber) ? true : false):
        return new Mag270();

      case (preg_match('~^(322|324)$~', $modelNumber) ? true : false):
        return new Mag324();

      default:
        throw new Exception("$modelNumber: unsupported MAG model", 1);
    }

  }
}


 ?>
