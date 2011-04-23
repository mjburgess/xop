<?php
class MvcFactoryTest extends PHPUnit_Framework_Testcase {
    public function setUp() {
        $_GET['controller'] = 'Default';
        $_GET['action'] = 'index';
    }
    
    public function testFromConfig() {
        $config = new \X\Config();
        $config->add('Application', 'root', dirname(__DIR__) . '\TestApp');
        $config->add('Application', 'routingClass', 'X\Application\Routes\MvcDefaultRoute');

        $config->add('DirMap', 'views', 'Views');
        $config->add('DirMap', 'layoutDir', 'Layouts');

        $config->add('Namespaces', 'project', 'X\Dev\Tests\TestApp');
        $config->add('Namespaces', 'controller', 'Controllers');
        $config->add('Namespaces', 'model', 'Models');

        $config->add('View', 'layout', 'default');
        $config->add('View', 'tplExtension', '.phtml');
        
        $config->add('Database', 'adapter', 'X\Db\Adapter\PDO\Sqlite');
        $config->add('Database', 'driver', 'sqlite');
        $config->add('Database', 'name', ':memory:');

        $app = \X\Application\MvcFactory::fromConfig($config);
        $this->assertEquals('(index)', $app());

    }
    
    public function testBasicServer() {
        $app = \X\Application\MvcFactory::basicServer('X\Dev\Tests\TestApp');
        $this->assertEquals('BasicIndex', $app());
    }
}