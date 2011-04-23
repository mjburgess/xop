<?php

class RequestTest extends PHPUnit_Framework_Testcase {

    public function testDefaults() {
        $_POST = $_GET = $_SERVER = $_COOKIE = array('a' => 'b');
        $req = new \X\Request();
        $this->assertEquals('b', $req->getQuery('a'));
        $this->assertEquals('b', $req->getPost('a'));
        $this->assertEquals('b', $req->getCookie('a'));
        $this->assertEquals('b', $req->getServer('a'));
    }
    
    public function testCookie() {
        $req = new \X\Request();
        $req->setCookie('test', 'x', time() + 3600, array(), false);
        $this->assertEquals('x', $req->getCookie('test'));
//        $this->assertEquals('x', $_COOKIE['test']);
    }
    
    public function testPost() {
        $req = new \X\Request();
        $req->setPost('test', 'x');
        $this->assertEquals('x', $req->getPost('test'));
        $this->assertEquals('x', $_POST['test']);
    }
    
    public function testQuery() {
        $req = new \X\Request();
        $req->setQuery('test', 'x');
        $this->assertEquals('x', $req->getQuery('test'));
        $this->assertEquals('x', $_GET['test']);
    }
}