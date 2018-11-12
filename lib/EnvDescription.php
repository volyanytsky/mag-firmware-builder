<?php

class EnvDescription
{
  static public function getInputs()
  {
    return [
      [
        'name' => 'bg_color',
        'label' => 'Bootloader backgroung color'
      ],
      [
        'name' => 'fg_color',
        'label' => 'Bootloader font color'
      ],
      [
        'name' => 'ntpurl',
        'label' => 'Time server'
      ],
      [
        'name' => 'audio_initial_volume',
        'label' => 'Initial volume level'
      ],
      [
        'name' => 'input_buffer_size',
        'label' => 'Stream buffering value (ms)'
      ],
      [
        'name' => 'portal1',
        'label' => 'First Portal URL'
      ],
      [
        'name' => 'portal2',
        'label' => 'Second Portal URL'
      ],
      [
        'name' => 'update_url',
        'label' => 'Update URL'
      ],
      [
        'name' => 'autoupdateURL',
        'label' => 'Autoupdate URL'
      ],
    ];
  }

  static public function getSelects()
  {
    return [
      [
        'name' => 'language',
        'label' => 'Inner Portal Language',
        'values' => [
            'en' => 'English',
            'de' => 'German',
            'ru' => 'Russian',
            'uk' => 'Ukrainian',
            'tr' => 'Turkish'
        ]
      ],
      [
        'name' => 'timezone_conf',
        'label' => 'Timezone',
        'values' => array_combine(timezone_identifiers_list(), timezone_identifiers_list())
      ],
      [
        'name' => 'bootTVsystem',
        'label' => 'Bootloader video output mode',
        'values' => array_combine(['PAL', "NTSC"], ['PAL', "NTSC"])
      ],
      [
        'name' => 'tvsystem',
        'label' => 'Video output mode',
        'values' => array_combine(
          [
            'PAL', '576p-50', '720p-50', '1080i-50', '1080p-50', 'NTSC', '576p-60', '720p-60', '1080i-60', '1080p-60'
          ],
          [
            'PAL', '576p-50', '720p-50', '1080i-50', '1080p-50', 'NTSC', '576p-60', '720p-60', '1080i-60', '1080p-60'
          ]
        )
      ],
      [
        'name' => 'graphicres',
        'label' => 'Graphics resolution',
        'values' => array_combine(['tvsystem_res', '720', '1280', '1920'], ['TV System', '720', '1280', '1920'])
      ],
      [
        'name' => 'autoupdate_cond',
        'label' => 'Autoupdate condition',
        'values' => [
          0 => 'Enabled',
          1 => 'With confirmation',
          2 => 'Disabled'
        ]
      ],
    ];
  }

  static public function getRadios()
  {
    return [
      [
        'name' => 'custom_url_hider',
        'label' => 'Portals\' input fields',
        'values' => [
          0 => 'Enable',
          1 => 'Hide',
        ]
      ],
      [
        'name' => 'betaupdate_cond',
        'label' => 'Autoupdate on beta factory firmware',
        'values' => [
          0 => 'Disable',
          1 => 'Enable',
        ]
      ],
      [
        'name' => 'force_dvi',
        'label' => 'DVI mode via HDMI',
        'values' => [
          0 => 'Disable',
          1 => 'Enable',
        ]
      ],
    ];
  }
}



 ?>
