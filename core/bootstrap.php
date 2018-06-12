<?php
//index chama primeiro o bootstrap e depois essa classe. Por isso a classe Core pode ser instanciada sem problemas.
//pega toda a requisição feita no browser

$routes = require_once __DIR__.'/../app/routes.php';
$rout = new \Core\Route($routes);