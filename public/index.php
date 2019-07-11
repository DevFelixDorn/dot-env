<?php

require '../vendor/autoload.php';

use Felix\DotEnv;

DotEnv::register(__DIR__ . '/../tests/.env.test');

dd($_ENV);