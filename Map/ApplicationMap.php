<?php
/** X - xphp.org Application Framework **
* 
* Namespace Maps of Client Application to MVC/etc.
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Map
*/

namespace X\Map;

class ApplicationMap {
    private $namespaceMap;
        public function setNamespaceMap(array $nsMap) {
            $this->namespaceMap = $nsMap;
            return $this;
        }
        public function getNamespaceMap() {
            return $this->namespaceMap;
        }
    
    public function __construct(array $nsMap = array()) {
        $this->setNamespaceMap($nsMap);
    }
    
    /**
    * @param string $nsKey 
    * @param string $nsName
    * @returns X\Map\ApplicationMap
    */
    public function setNamespace($nsKey, $nsName) {
        $this->namespaceMap[$nsKey] = $nsName;
        return $this;
    }
    
    public function getNamespace($nsKey, $fromProjectRoot = true) {
        $prefix = $fromProjectRoot ? $this->namespaceMap['project'] . '\\': '';
        return $prefix . $this->namespaceMap[$nsKey];
    }
    
    public function getClass($nsKey, $clsName, $fromProjectRoot = true) {
        return $this->getNamespace($nsKey, $fromProjectRoot) . '\\' . $clsName;
    }
}