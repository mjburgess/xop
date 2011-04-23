<?php
/** X - xphp.org Application Framework **
* 
* File System Access via Map
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Map
*/

namespace X\Map;

class FileMap {    
    private $root;
        public function setRoot($root) {
            $this->root = $root;
            return $this;
        }
        public function getRoot() {
            return $this->root;
        }
    private $dirs;    
        public function setDirs(array $dirs) {
            $this->dirs = $dirs;
            return $this;
        }
        public function getDirs() {
            return $this->dirs;
        }
    
    public function __construct($root) {
        $this->setRoot($root);
    }    
    
    public function setDir($key, $Map) {
        $this->dirs[$key] = $Map;
    }
    
    public function getDir($key) {
        return $this->dirs[$key];
    }
    
    public function dirFromRoot($key, $withDirs = array()) {
        return implode(DIRECTORY_SEPARATOR, 
                    array_merge(array($this->root, $this->getDir($key)), (array) $withDirs));
    }
    
    public static function path() {
        return implode(DIRECTORY_SEPARATOR, func_get_args());
    }
}
