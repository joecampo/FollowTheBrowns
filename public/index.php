<?php
session_cache_limiter(false);
session_start();
ini_set("max_execution_time", "120");

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
    '/'                     => 'Controller:index',
    '/authenticate/:action' => 'Controller:authenticate',
    '/callback/:action'     => 'Controller:callback',
    '/follow'               => 'Controller:follow',
    '/unfollow'             => 'Controller:unfollow'
));

$app->run();
