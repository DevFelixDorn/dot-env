<?php

require '../vendor/autoload.php';

use Felix\DotEnv;
DotEnv::register('../tests/.env.test');
dd($_SERVER);
#$content = (new DotEnv)->setFilename('../tests/.env.test')->parseOnly();
#dd($content);