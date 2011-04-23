<?php
/** X - xphp.org Application Framework **
* 
* View template not set exception
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage ?
*/

namespace X\View\Exception;

class TemplateNotRegistered extends \Exception {
    private $templateName; 
        /**
        * @param string
        */
        public function setTemplateName($tpl) {
            $this->templateName = $tpl;
        }
        /**
        * @returns string
        */ 
        public function getTemplateName() {
            return $this->templateName;
        }
    
    /**
    * Template not registered with view
    * 
    * @param string $tpl
    * @return TemplateNotRegistered
    */
    public function __construct($tpl) {
        $this->setTemplateName($tpl);
        parent::__construct("Template $tpl has not been registered!");
    }
}