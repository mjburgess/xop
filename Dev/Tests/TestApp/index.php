<?php
namespace X\Dev\Tests\TestApp;

define('LIBROOT', dirname(dirname(dirname(__DIR__))));
set_include_path(get_include_path() . PATH_SEPARATOR . LIBROOT);

require 'ClassLoader.php';

$cl = new \X\ClassLoader('X', LIBROOT . DIRECTORY_SEPARATOR);
$cl->register();

$config = new \X\Config();
$config->add('Application', 'root', __DIR__);
$config->add('Application', 'routingClass', 'X\Application\Routes\MvcDefaultRoute');

$config->add('DirMap', 'views', 'Views');
$config->add('DirMap', 'layoutDir', 'Layouts');

$config->add('Namespaces', 'project', __NAMESPACE__);
$config->add('Namespaces', 'controller', 'Controllers');
$config->add('Namespaces', 'model', 'Models');

$config->add('View', 'layout', 'default');
$config->add('View', 'tplExtension', '.phtml');

$app = \X\Application\MvcFactory::fromConfig($config);
echo $app();