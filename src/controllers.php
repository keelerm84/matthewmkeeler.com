<?php

$app->get('/', function() use ($app) {
    return $app['twig']->render('home.twig', array());
})->bind('home');

$app->get('/about', function() use ($app) {
    $minMax = $app['db']->fetchAssoc("SELECT MAX(months) as max, MIN(months) as min FROM skills");
    $range = max(0.01, $minMax['max'] - $minMax['min']) * 1.001;

    $skills = $app['db']->fetchAll("SELECT skill, months, rating FROM skills ORDER BY skill");
    foreach($skills as &$skill) {
        $skill['weight'] = 1 + floor(100 * ($skill['months'] - $minMax['min']) / $range );
    }

    $skills = array_filter($skills, function($skill) { return $skill['weight'] > 35; });

    return $app['twig']->render('about.twig', array('skills' => $skills));
})->bind('about');

$app->get('/portfolio', function() use ($app) {
    $templates = glob(__DIR__ . '/../resources/views/portfolio/*');
    $templates = array_map(function($template) { return 'portfolio/' . basename($template); }, $templates);

    return $app['twig']->render('portfolio.twig', array('templates' => $templates));
})->bind('portfolio');
