<?php
use \X\View\Template;

class ViewTest extends PHPUnit_Framework_TestCase {
    private $fileMap;
    
    protected function setUp() {
        $this->FileMap = new \X\Map\FileMap(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'TestApp');
        $this->FileMap->setDir('views', 'Views');
        $this->FileMap->setDir('layoutDir', 'Layouts');
    }
    
    public function testCascade() {
        $view = new \X\View();
        $view->registerCascadingTemplate(new Template($this->FileMap, $this->FileMap->getDir('layoutDir'), 'default'));
        $view->registerCascadingTemplate(new Template($this->FileMap, 'Default', 'container'));
        $view->registerCascadingTemplate(new Template($this->FileMap, 'Default', 'index'));        
        
        $this->assertEquals('(#index#)', $view->render());
    }
    
    public function testTemplateRegistration() {
        $view = new \X\View();
        $view->registerCascadingTemplate(new Template($this->FileMap, $this->FileMap->getDir('layoutDir'), 'master'));
        $view->registerTemplate(new Template($this->FileMap, 'Default', 'menu'));
        $this->assertEquals('%menu%', $view->render());
    }
}