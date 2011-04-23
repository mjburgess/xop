<?php
/** X - xphp.org Application Framework **
* 
* Default URL Route for an Action Request
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Application\Routes
*/

namespace X\Application\Routes;

class MvcDefaultRoute implements IMvcRoute {
    private static $defaultController = 'Default';
        /**
        * @param string Controller Name
        */
        public static function setDefaultController($cName) {
            self::$defaultController = $cName;
        }
        /**
        * @returns string Controller Name
        */ 
        public static function getDefaultController() {
            return self::$defaultController;
        }
    
    private static $defaultAction = 'index';
        /**
        * @param string Action (method) Name
        */
        public static function setDefaultAction($aName) {
            self::$defaultAction = $aName;
        }
        /**
        * @returns string Action (method) name
        */ 
        public static function getDefaultAction() {
            return self::$defaultAction;
        }
    
    
    private $request;
        /**
        * @param \X\Request $r
        * @returns \X\Request
        */
        public function setRequest(\X\Request $r) {
            $this->request = $r;
            return $this;
        }
        /**
        * @returns \X\Request
        */ 
        public function getRequest() {
            return $this->request;
        }
    
    public function __construct(\X\Request $r = null) {
        if($r) { 
            $this->setRequest($r);
        }
    }
    
    public function asMvcRequest() {
        return new \X\Application\MvcRequest($this->getController(), $this->getAction());
    }
    
    public function getController() {
        if($this->request->queryHas('controller')) {
            return $this->request->getQuery('controller');
        } else {
            return self::$defaultController;
        }
    }
    
    public function getAction() {
        if($this->request->queryHas('action')) {
            return $this->request->getQuery('action');
        } else {
            return self::$defaultAction;
        }
    }
}