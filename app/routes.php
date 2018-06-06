<?php

//classe router vai consumir todas as rotas cadastradas aqui.
$rout[] = ['/', 'HomeController@index'];
$rout[] = ['/posts', 'PostsController@index'];
$rout[] = ['/post/{id}/show', 'PostsController@show'];
$rout[] = ['/post/create', 'PostsController@create'];
$rout[] = ['/post/store', 'PostsController@store'];
$rout[] = ['/post/{id}/edit', 'PostsController@edit'];
$rout[] = ['/post/{id}/update', 'PostsController@update'];


return $rout;

