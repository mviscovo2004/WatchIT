<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

// Importa il file di bootstrap per ottenere l'EntityManager
$bootstrap = require_once __DIR__ . '/../foundation/bootstrap.php';
$entityManager = $bootstrap['entityManager'];

// Avvia la console di Doctrine
ConsoleRunner::run(
    new SingleManagerProvider($entityManager)
);
