<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Knp\Provider\ConsoleServiceProvider;
use Knp\Provider\MigrationServiceProvider;
use DerAlex\Silex\YamlConfigServiceProvider;

$app = new Silex\Application();

$app->register(new ConsoleServiceProvider(), array(
    'console.name'              => 'MMK Personal Application',
    'console.version'           => '0.0.1',
    'console.project_directory' => __DIR__.'/..'
));

$app->register(new YamlConfigServiceProvider(__DIR__ . '/../resources/config/prod.yml'));

$app->register(new DoctrineServiceProvider(), array(
    'db.options' => $app['config']['database']
));

$app->register(new \Knp\Provider\MigrationServiceProvider(), array(
    'migration.path' => __DIR__.'/../resources/migrations'
));

$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../resources/views'
));

$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    $twig->addExtension(new \Twig_Extension_Markdown($app));

    return $twig;
}));

$app->register(new UrlGeneratorServiceProvider());

return $app;
