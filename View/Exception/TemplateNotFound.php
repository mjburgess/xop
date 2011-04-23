<?php
/** X - xphp.org Application Framework **
* 
* View File Not Found
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage ?
*/

namespace X\View\Exception;

class TemplateNotFound extends \Exception {
    private $template;
        public function setTemplate(\X\View\Template $tpl) {
            $this->template = $tpl;
        }
        /**
        * @returns \X\View\Template
        */
        public function getTemplate() {
            return $this->template;
        }
        
    public function __construct(\X\View\Template $tpl) {
        $this->setTemplate($tpl);
        parent::__construct('Template (View File) ' . $tpl . ' Not Found');
    }    
}