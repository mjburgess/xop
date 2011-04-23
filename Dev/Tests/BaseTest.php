<?php
define('LIBROOT', dirname(dirname(__DIR__)));
set_include_path(get_include_path() . PATH_SEPARATOR . LIBROOT);

require 'ClassLoader.php';

        $cl = new \X\ClassLoader('X', LIBROOT . DIRECTORY_SEPARATOR);
        $cl->register();

class BaseTest extends PHPUnit_Framework_Testcase {
    public function testClassLoader() {        
        global $cl;
        $this->assertEquals($cl->getProjectNamespace(), 'X');
        $this->assertEquals($cl->getLibDir(), LIBROOT . DIRECTORY_SEPARATOR);       
    }
}