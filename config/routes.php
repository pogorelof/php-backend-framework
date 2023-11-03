<?php

use watch\Router;

// default admin routes
Router::add('^admin$', ['controller' => 'Main', 'action' => 'index', 'prefix' => 'admin']);//главная страница
Router::add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'admin']);

// default routes
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);//главная страница
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');
