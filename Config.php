<?php
/** X - xphp.org Application Framework **
* 
* Configuration Manager.
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Config
*/
namespace X;

class Config {
    private $config;
        public function setConfig(array $config) {
            $this->config = $config;
        }
        public function getConfig() {
            return $this->config;
        }
           
    
    public function __construct(array $config = array()) {
        $this->setConfig($config);
    }
    
    public function get($nsName, $name, $quiet = false) {
        if($quiet) {
            return isset($this->config[$nsName], $this->config[$nsName][$name]) ?
                    $this->config[$nsName][$name] : null;
        } else {
            return $this->config[$nsName][$name];
        }
    }
    
    public function getNamespace($nsName) {
        return $this->config[$nsName];
    }
    
    public function add($nsName, $name, $value) {
        $this->config[$nsName][$name] = $value;
    }
    
    public function addNamesapce($nsName, array $values) {
        $this->config[$nsName] = $values;
    }
    
    public function remove($nsName, $name = null) {
        unset($this->config[$nsName][$name]);   
    }
    
    public function removeNamesapce($nsName) {
        unset($this->config[$nsName]);
    }
}
?>
