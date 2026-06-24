<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

/**
 * Classe Bootstrap
 * 
 * Classe che gestisce l'avvio dell'applicazione
 * Fornisce metodi per l'interazione con l'entity manager, smarty e sessione
 * 
 * @return array Array contenente l'entity manager, smarty e sessione
 * @package Foundation
 * @author Marco Viscovo
 */
global $bootstrap_config;
if (isset($bootstrap_config)) {
    return $bootstrap_config;
}

/**
 * Array contenente i percorsi delle classi del modello
 * 
 * @var array
 */
$paths = [__DIR__ . '/../model'];

/**
 * Flag per indicare se l'applicazione è in modalità sviluppo
 * 
 * @var bool
 */
$isDevMode = true;

/**
 * Configurazione dell'Entity Manager
 * 
 * @var \Doctrine\ORM\Configuration
 */
$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);


$hostName = Session::getServer('HTTP_HOST', 'localhost');
$isAltervista = (strpos($hostName, 'altervista.org') !== false);

/**
 * Parametri di connessione al database
 * 
 * @var array
 */
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

/**
 * Connessione al database
 * 
 * @var \Doctrine\DBAL\Connection
 */
$connection = DriverManager::getConnection($connectionParams, $config);

/**
 * Entity Manager
 * 
 * @var \Doctrine\ORM\EntityManager
 */
$entityManager = new EntityManager($connection, $config);

/**
 * Smarty
 * 
 * @var Smarty\Smarty
 */
$smarty = new Smarty\Smarty();
$smarty->setTemplateDir(__DIR__ . '/../view/templates');
$smarty->setCompileDir(__DIR__ . '/../view/templates_c');
$smarty->setCacheDir(__DIR__ . '/../view/templates_c');
$smarty->setConfigDir(__DIR__ . '/../view/configs');

/**
 * Array contenente la configurazione bootstrap
 * 
 * @var array
 */
$bootstrap_config = [
    'entityManager' => $entityManager,
    'smarty' => $smarty,
];

return $bootstrap_config;
