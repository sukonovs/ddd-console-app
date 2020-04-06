<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbParams = [
    'driver'   => "pdo_mysql",
    'host' => getenv('HOST'),
    'user'     => getenv('USER'),
    'password' => getenv('PASSWORD'),
    'dbname'   => getenv('DB_NAME'),
];

$builder = new DI\ContainerBuilder();
$container = $builder->build();

$paths = [__DIR__."/src/Entity"];
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
$entityManager = EntityManager::create($dbParams, $config);