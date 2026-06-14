<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;


$bootstrap = require __DIR__ . '/../foundation/bootstrap.php';
$entityManager = $bootstrap['entityManager'];


ConsoleRunner::run(
    new SingleManagerProvider($entityManager)
);
