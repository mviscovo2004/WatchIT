<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

global $bootstrap_config;
if (isset($bootstrap_config)) {
    return $bootstrap_config;
}

$paths = [__DIR__ . '/../model'];
$isDevMode = true;

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);


$hostName = Session::getServer('HTTP_HOST', 'localhost');
$isAltervista = (strpos($hostName, 'altervista.org') !== false);

if ($isAltervista) {

    $parts = explode('.', $hostName);
    $altervistaUser = $parts[0];

    $connectionParams = [
        'driver'   => 'pdo_mysql',
        'host'     => 'localhost',
        'port'     => 3306,
        'dbname'   => 'my_' . $altervistaUser,
        'user'     => $altervistaUser,
        'password' => '',
    ];
} else {

    $connectionParams = [
        'driver'   => 'pdo_mysql',
        'host'     => 'localhost',
        'port'     => 3306,
        'dbname'   => 'watchit',
        'user'     => 'root',
        'password' => '',
    ];
}


$connection = DriverManager::getConnection($connectionParams, $config);
$entityManager = new EntityManager($connection, $config);

$smarty = new Smarty\Smarty();
$smarty->setTemplateDir(__DIR__ . '/../view/templates');
$smarty->setCompileDir(__DIR__ . '/../view/templates_c');
$smarty->setCacheDir(__DIR__ . '/../view/templates_c');
$smarty->setConfigDir(__DIR__ . '/../view/configs');

$bootstrap_config = [
    'entityManager' => $entityManager,
    'smarty' => $smarty,
];

return $bootstrap_config;
