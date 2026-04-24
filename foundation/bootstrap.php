<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$paths = [__DIR__ . '/../model'];
$isDevMode = false;

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);

$connectionParams = [
    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'watchit',
    'user' => 'root',
    'password' => '',
];

$connection = DriverManager::getConnection($connectionParams, $config);
$entityManager = new EntityManager($connection, $config);

$smarty = new Smarty\Smarty();
$smarty->setTemplateDir(__DIR__ . '/../view/templates');
$smarty->setCompileDir(__DIR__ . '/../view/templates_c');
$smarty->setCacheDir(__DIR__ . '/../view/templates_c'); // Puoi creare una cartella cache separata se vuoi
$smarty->setConfigDir(__DIR__ . '/../view/configs');    // Se hai configs

// Oppure restituire un array per includere
return [
    'entityManager' => $entityManager,
    'smarty' => $smarty,
];
