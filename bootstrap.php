<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Doctrine\UuidType;

require __DIR__.'/vendor/autoload.php';

// Dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Doctrine
$paths = [__DIR__."/src/Entity"];
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

$dbParams = [
    'driver'   => "pdo_mysql",
    'host' => getenv('HOST'),
    'user'     => getenv('USER'),
    'password' => getenv('PASSWORD'),
    'dbname'   => getenv('DB_NAME'),
];
$entityManager = EntityManager::create($dbParams, $config);

\Doctrine\DBAL\Types\Type::addType('uuid', UuidType::class);


// Container
$builder = new DI\ContainerBuilder();
$builder->addDefinitions([
    EntityManager::class => $entityManager
]);
$container = $builder->build();