<?php
use \X\Application\Routes\MvcDefaultRoute;

class MvcDefaultRouteTest extends PHPUnit_Framework_TestCase {
    public function testDefault() {        
        $emptyQuery = array();
        $er = new \X\Request($emptyQuery, $emptyQuery);
        $r = new MvcDefaultRoute($er);
        
        $this->assertEquals('Default', $r->getController());
        $this->assertEquals('index', $r->getAction());
        
        MvcDefaultRoute::setDefaultController('c');
        MvcDefaultRoute::setDefaultAction('a');
        
        $this->assertEquals('c', $r->getController());
        $this->assertEquals('a', $r->getAction());
    }
}
