<?php

/**
 * File di bootstrap per la Command Line Interface (CLI) di Doctrine.
 * 
 * Inizializza il ConsoleRunner del framework ORM collegandolo all'istanza
 * dell'EntityManager configurata nel bootstrap dell'applicazione.
 * Consente l'esecuzione di comandi da terminale (es. `php bin/doctrine.php orm:schema-tool:create`).
 * 
 * @package Bin
 * @author Marco Viscovo
 */
require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;


/**
 * Avvia l'applicazione bootstrap e recupera l'EntityManager.
 * 
 * @return array L'array contenente l'EntityManager configurato
 */
$bootstrap = require __DIR__ . '/../foundation/bootstrap.php';
$entityManager = $bootstrap['entityManager'];

/**
 * Esegue il ConsoleRunner del framework ORM collegandolo all'istanza
 * dell'EntityManager configurata nel bootstrap dell'applicazione.
 * Consente l'esecuzione di comandi da terminale (es. `php bin/doctrine.php orm:schema-tool:create`).
 * 
 * @param SingleManagerProvider $entityManager
 * @return void
 */
ConsoleRunner::run(
    new SingleManagerProvider($entityManager)
);
