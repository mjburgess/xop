<?php
/** X - xphp.org Application Framework **
* 
* 
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage ?
*/

namespace X\Application\Server;

class MvcServer implements IServer {    
    private $application;
        /**
        * @param \X\Application
        * @returns \X\Application\Server\MvcServer
        */
        public function setApplication(\X\Application $app) {
            $this->application = $app;
            return $this;
        }
        /**
        * @returns \X\Application
        */ 
        public function getApplication() {
            return $this->application;
        }

    /**
    * @var \X\Controller\AController
    */
    private $controller;
        /**
        * @param \X\Controller\AController | string (class name)
        * @returns \X\Application\MvcServer
        */
        public function setController(\X\Controller\IController $controllerClass) {
            $this->controller = $controllerClass;
            return $this;
        }
        /**
        * @returns \X\Controller\AController
        */ 
        public function getController() {
            return $this->controller;
        }
        
        
    public function __construct(\X\Application $app) {
        $this->setApplication($app);
        $this->registerServer();
        $this->loadController();
    }
    
    public function registerServer() {
        $this->application->setServer($this);
    }
    
    public function loadController() {
        $mvcReq = $this->application->getApplicationRequest();
        $appMap = $this->application->getApplicationMap();                                                                
        $clName = $appMap->getClass('controller', $mvcReq->getController());
       
        $this->controller = new $clName();
        $this->controller->setApplication($this->application);
    }
    
    public function setUpView($layout = null, $tplExt = null){
        if($tplExt) {
            \X\View\Template::setExtension($tplExt);
        }
        $this->controller->setUpView($layout);
    }
    
    public function setUpModels($adapter, array $config) {
        \X\Model\AModel::setDefaultAdapter(new $adapter($config));
    }
    
    public function serve() {
        $mvcRequest = $this->application->getApplicationRequest();
        if(method_exists($this->controller, $method = $mvcRequest->getAction())) {
            if($c = $this->controller->$method()) {
                return $c;
            } else {
                return $this->controller->getView()->render();
            }
        } else {
            throw new Exception\ActionNotFound($mvcRequest);
        }
    }
}
