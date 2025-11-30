<?php

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

class Autoload extends AutoloadConfig
{
    public $psr4 = [
        APP_NAMESPACE => APPPATH,
    ];

    // Add libraries here (correct place)
    public $libraries = ['session'];

    public $classmap = [];

    public $files = [];

    public $helpers = [];
}
