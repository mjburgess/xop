<?php 
/** X - xphp.org Application Framework **
* 
* Application Request Information ($controller, $action).
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Application
*/

namespace X\Application;

class MvcRequest implements IRequest {
    private $controller;
        /**
        * @param string $controller
        * @returns X\Application\MvcRequest
        */
        public function setController($controller) {
            $this->controller = $controller;
            return $this;
        }
        /**
        * @returns string
        */
        public function getController($clsName = true) {
            return $this->controller . ($clsName ? 'Controller' : '');
        }
        
    private $action; 
        /**
        * @param string $action    
        * @returns X\Application\MvcRequest
        */
        public function setAction($action){
            $this->action = $action;
            return $this;
        }
        /**
        * @returns string
        */
        public function getAction() {
            return $this->action;
        }
    
    /** 
    * @returns string $controller.$action
    */
    public function __toString() {
        return $this->getController() . '::' . $this->getAction();
    }
    
    /** 
    * @param [X\Application\Routes\IUrlRoute] $route
    */
    public function __construct($controller, $action) {
        $this->setController($controller)->setAction($action);
    }
}