<?php

class FirmwareController extends Controller
{
  public function actionNew()
  {
    $data = [
      'models' => [250, 254, 256, 275, 322, 324, 351],
      'versions' => [
        '0.2.18-r22',
        '2.20.03',
        '2.20.04',
        '2.20.05',
        '2.20.06',
        '2.20.07',
        '2.20.07r2'
      ],
      'env' => [
        'inputs' => EnvDescription::getInputs(),
        'selects' => EnvDescription::getSelects(),
        'radios' => EnvDescription::getRadios()
      ],
    ];

    $this->view->generate('new', $data);
  }

  public function actionBuild()
  {
    //print_r($_POST);
    $mag = MagFactory::create($_POST['model']);
    $env = new Env();

    foreach($_POST as $key => $value)
    {
      if($value !== '')
      {
        if(strrpos($key, 'env_') === 0)
        {
          $envName = str_replace('env_', '', $key);
          $env->addDefault($envName, $value);
          if(isset($_POST["checked_$key"]) && $_POST["checked_$key"] == true)
          {
            $env->addChecked($envName, $value);
          }
        }
      }
    }

    $firmware = new FirmwareImage($mag, $_POST['image_desc'], $_POST['image_number'], $_POST['rootfs_version']);
    $firmware->setEnv($env);

    $project = new FirmwareProject($firmware, $_POST['company']);
    $project->init();

    $project->setEnv();
    $link = $project->buildPublicImage();
    if($link)
    {
      header("Location: $link");
    }
  }
}

 ?>
