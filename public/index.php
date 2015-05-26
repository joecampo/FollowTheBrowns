<?php
session_cache_limiter(false);
session_start();
ini_set("max_execution_time", "60");

require '../vendor/autoload.php';
require '../config/config.php';

$app = new \SlimController\Slim(array(
    'templates.path'             => '../templates/',
    'controller.class_prefix'    => '\\Campo\\Browns\\Controller',
    'controller.method_suffix'   => '',
    'controller.template_suffix' => 'php',
    'debug'                      => false
));

$app->addRoutes(array(
    '/'              => 'Controller:index',
    '/authenticate/' => 'Controller:authenticate',
    '/callback/'     => 'Controller:callback',
    '/follow/'       => 'Controller:follow'
));

$app->run();
