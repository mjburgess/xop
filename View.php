<?php
/** X - xphp.org Application Framework **
* 
* View System
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
*/

namespace X;

class View {
    private $helpers;
        /**
        * @param array $helpers
        * @returns \X\View
        */
        public function setHelpers(array $helpers) {
            foreach($helpers as $helper) {
                $this->registerHelper($helper);
            }
            return $this;
        }
        /**
        * @returns array
        */ 
        public function getHelpers() {
            return $this->helpers;
        }
    
    private $templates;
        /**
        * @param array $tpls
        * @returns \X\View
        */
        public function setTemplates(array $tpls) {
            $this->templates = $tpls;
            return $this;
        }
        /**
        * @returns array
        */ 
        public function getTemplates() {
            return $this->templates;
        }
    
    private $renderCascade;
        /**
        * @param array $rc
        * @returns \X\View
        */
        public function setRenderCascade(array $rc) {
            $this->renderCascade = $rc;
            return $this;
        }
        /**
        * @returns array
        */ 
        public function getRenderCascade() {
            return $this->renderCascade;
        }
        
    const CASCADE_EARLY = -1;
    const CASCADE_LATE  = -2;
        
    public function __construct() {
        $this->renderCascade = array();
    }    
    
    public function render(\X\View\Render\IRender $r = null) {
        $content = '';
        foreach($this->renderCascade as $tpl) {
            $content = $this->getTemplate($tpl)
                            ->addVariable('view', $this)
                            ->addVariable('content', $content)
                            ->addVariable('helpers', $this->helpers)
                            ->render($r);
        }
        return $content;
    }
    
    public function registerHelper(\X\View\IHelper $h) {
        $h->setView($this);
        $this->helpers->{$h->getName()} = $h;
    }
    public function setLayout(\X\View\Template $tpl) {
        $this->registerCascadingTemplate($tpl, self::CASCADE_LATE);
    }
    
    public function registerCascadingTemplate(\X\View\Template $tpl, $position = self::CASCADE_EARLY) {
        $this->registerTemplate($tpl);
        $this->registerWithCascade($tpl, $position);
    }
    /**
    * @returns \X\View
    */
    public function registerTemplate(\X\View\Template $tpl) {
        $this->templates[$tpl->getName()] = $tpl;
        return $this;
    }
    
    /**
    * @param \X\View\Template | string (name of template, ie., tpl->getName())
    * @param int - position in cascade
    * View::CASECADE_EARLY for pushing on top, View::CASECADE_LATE for pushing on bottom
    * Default: FIFO 
    */
    public function registerWithCascade($tpl, $position = self::CASCADE_EARLY) {
        $name = $tpl instanceof \X\View\Template ? $tpl->getName() : $tpl;
        
        if($position == self::CASCADE_EARLY) { 
            array_unshift($this->renderCascade, $name);
        } elseif ($position == self::CASCADE_LATE) {
            array_push($this->renderCascade, $name);
        } else {
            $this->renderCascade[$position] = $name;
        }
    }
    
    /**
    * @return \X\View\Template
    */
    public function getTemplate($name) {
        if(empty($this->templates[$name])) {
            throw new View\Exception\TemplateNotRegistered($name);
        }
        
        return $this->templates[$name];
    }
}
