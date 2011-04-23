<?php
class TemplateFactoryTest extends PHPUnit_Framework_TestCase {
    private $fileMap;
    
    protected function setUp() {
        $this->fileMap = new \X\Map\FileMap(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'TestApp');
        $this->fileMap->setDir('views', 'Views');
    }
    
    public function testFromMvcRequest() {
        $ar  = new \X\Application\MvcRequest('Default', 'index');
        $tpl = \X\View\Template\Factory::fromMvcRequest($this->fileMap, $ar);
        $this->assertEquals('index', $tpl->render());
    }
}