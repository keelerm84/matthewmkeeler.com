<?php

namespace Keelerm;

use Silex\Provider\TwigServiceProvider as TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider as UrlGeneratorServiceProvider;

class Application extends \Silex\Application
{
    protected $path;

    public function __construct($root)
    {
        parent::__construct();
        $this->path = realpath($root);

        $this->register(new TwigServiceProvider(), array(
            'twig.path' => $this->getViewPath()
        ));

        $this->register(new UrlGeneratorServiceProvider());

        $app = $this;
        $this->get('/', function() use ($app) {
            return $app['twig']->render('home.twig', array());
        });
    }

    protected function getViewPath()
    {
        return $this->path . DIRECTORY_SEPARATOR . '../views' . DIRECTORY_SEPARATOR;
    }
}
