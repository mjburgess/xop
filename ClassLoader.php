<?php
/** X - xphp.org Application Framework **
* 
* Autoloading & Include Path Setting
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Application
*/

namespace X;

class ClassLoader {
    private $displayMap;
        /**
        * @param bool $Map , display file Map when require-ing
        * @returns \X\ClassLoader
        */
        public function setDisplayMap($Map) {
            $this->displayMap = $Map;
            return $this;
        }
        /**
        * @returns bool
        */ 
        public function getDisplayMap() {
            return $this->displayMap;
        }
    
    private $extension = 'php';
        public function setExtension($ext) {
            $this->extension = $ext;
            return $this;
        }
        public function getExtension($prepend = '.') {
            return $prepend . $this->extension;
        }
        
    private $projectNamespace;
        public function setProjectNamespace($ns) {
            $this->projectNamespace = $ns;
            return $this;
        }
        public function getProjectNamespace() {
            return $this->projectNamespace;
        }
        
    private $libDir;
        public function setLibDir($ld) {
            $this->libDir = $ld;
            return $this;
        }
        public function getLibDir() {
            return $this->libDir;
        }
 
    public function __construct($ns, $libDir, $displayMap = false) {
        $this->setProjectNamespace($ns);
        $this->setLibDir($libDir);
        $this->setDisplayMap($displayMap);
    } 

    /**
     * Registers loader with the SPL autoload stack.
     */
    public function register() {
        spl_autoload_register(array($this, 'loadClass'));
    }
 
    /**
     * Unregisters from SPL autoloader stack.
     */
    public function unregister() {
        spl_autoload_unregister(array($this, 'loadClass'));
    }
 
    /**
     * Loads given class or interface.
     *
     * @param string $className
     */
    public function loadClass($className) {
        $nsSep = '\\';
        $proNs = $this->getProjectNamespace();
        $fileName = '';
        if(substr($className, 0, strlen($proNs)) == $proNs) {
            $className = substr($className, strlen($proNs) + 1);
        }
        
        if ($lastNsPos = strpos($className, $nsSep)) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace($nsSep, DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className);
        $fileName  = $this->getLibDir() . $fileName . $this->getExtension();

        if(file_exists($fileName)) {
            require $fileName;
            return true;
        } else {
            throw new \X\Exception\FileNotFound("File $fileName not found!");
        }
    }
}
