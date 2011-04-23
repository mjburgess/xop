<?php
/** X - xphp.org Application Framework **
* 
* Action not found exception
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage ?
*/

namespace X\Application\Exception;

class MvcActionNotFound extends \Exception {
    private $mvcRequest;
        public function setMvcRequest(\X\Application\MvcRequest $request) {
            $this->mvcRequest = $r;
        }
        
        public function getMvcRequestt() {
            return $this->mvcRequest;
        }
    
    public function __construct(\X\Application\MvcRequest $request) {
        $this->setMvcRequest($request);
        parent::__construct('Action ' . $request. ' Not Found');
    }
}