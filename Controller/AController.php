<?php
/** X - xphp.org Application Framework **
* 
* Controller Abstract
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Controller
*/
namespace X\Controller;
use X\View\Template, \X\Model;

abstract class AController implements IController {
    
    protected $application;
        /**
        * @param \X\Application $app
        * @returns \X\Controller\AController (inherited)
        */
        public function setApplication(\X\Application $app) {
            $this->application = $app;
            return $this;
        }
        /**
        * @returns \X\Application\MvcRequest
        */ 
        public function getApplication() {
            return $this->application;
        }
    
    /**
    * View
    * 
    * @var \X\View
    */
    protected $view;
        /**
        * @param \X\View $v
        * @returns \X\Controller\AController (inherited)
        */
        public function setView(\X\View $v) {
            $this->view = $v;
            return $this;
        }
        /**
        * @returns \X\View
        */ 
        public function getView() {
            return $this->view;
        }
            

    protected $template;
        /**
        * @param \X\View\Template
        * @returns \X\Controller\AController (inherited)
        */
        public function setTemplate(\X\View\Template $tpl) {
            $this->template = $tpl;
            return $this;
        }
        /**
        * @returns \X\View\Template 
        */ 
        public function getTemplate() {
            return $this->template;
        }
    
    public function setUpView($layout = null) {
        $fMap   = $this->application->getFileMap();
        $mvcReq = $this->application->getApplicationRequest();
        
        $this->template = Template\Factory::fromMvcRequest($fMap, $mvcReq);
        
        $this->view = new \X\View();        
        $this->view->registerCascadingTemplate($this->template);
        
        if($layout) {
            $layout = new Template($fMap, $fMap->getDir('layoutDir'), $layout);
            $this->view->setLayout($layout);
        }
    }
}
