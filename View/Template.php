<?php
/** X - xphp.org Application Framework **
* 
* Template Value Object
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage View
*/
namespace X\View;

class Template {
    private $name;
        /**
        * @param string $name
        * @returns \X\View\Template
        */
        public function setName($name) {
            $this->name = $name;
            return $this;
        }
        /**
        * @returns string
        */ 
        public function getName() {
            return $this->name;
        }    
        
    private static $extension = '.phtml';
        /**
        * @param string $ext (eg.: .php, .pthml)
        */
        public static function setExtension($ext) {
            self::$extension = $ext;
        }
        /**
        * @returns string 
        */ 
        public static function getExtension() {
            return empty(self::$extension) ? '' : self::$extension;
        }
        
    private $path;
        /**
        * @param string $path
        * @returns \X\View\Template
        */
        public function setPath($path) {
            $this->path = $path;
            return $this;
        }
        /**
        * @returns string
        */ 
        public function getPath() {
            return $this->path;
        }
    
    private $variables;
        /**
        * @param object $variables
        * @returns \X\View\Template
        */
        public function setVariables(array $variables) {
            $this->variables = $variables;
            return $this;
        }
        /**
        * @returns object 
        */ 
        public function getVariables() {
            return $this->variables;
        }
        
    /**
    * @var \X\View\Render\RenderInterface
    */
    private $renderer;    
        /**
        * @param
        * @returns
        */
        public function setRenderer(\X\View\Render\IRender $r) {
            $this->renderer = $r;
            return $this;
        }
        /**
        * @returns \X\View\Render\RenderInterface 
        */ 
        public function getRenderer() {
            return $this->renderer;
        }
    
        
    public function __toString() {
        return $this->getPath();
    }    
    
    /**
    * @param \X\Map\FileMap
    * @param string $dir directory underneath FileMap.views (specified views folder)
    * @param string $name template name
    * @param [array] $varaibles
    */
    public function __construct(\X\Map\FileMap $fileMap, $dir, $name, array $variables = array()) {
        $this->setName($name)->setVariables($variables);
        $this->setPath($fileMap->path($fileMap->dirFromRoot('views', $dir), $name . $this->getExtension()));
    }    
    
    /**
    * @returns \X\View\Template
    */
    public function addVariable($name, $value) {
        $this->variables[$name] = $value;
        return $this;
    }
    
    public function getVariable($name) {
        return $this->variables->$name;
    }
    
    public function render(Render\IRender $r = null) {
        if($r) {
            return $r->render($this);
        }
        
        if(empty($this->renderer)) {
            $this->renderer = new Render\WithInclusion();
        }
        
        return $this->renderer->render($this);
    }
}