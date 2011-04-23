<?php
/** X - xphp.org Application Framework **
* 
* Application 
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Application
*/
namespace X;

use \X\Map\FileMap, \X\Map\ApplicationMap;

class Application {
    
    private $applicationRequest;
        /**
        * @param object (typically MvcRequest)
        * @returns \X\Application
        */
        public function setApplicationRequest($appReq) {
            $this->applicationRequest = $appReq;
            return $this;
        }
        /**
        * @returns IRequest
        */ 
        public function getApplicationRequest() {
            return $this->applicationRequest;
        }
    /**
    * @var \X\Map\ApplicationMap
    */
    private $applicationMap;
        /**
        * @param \X\Map\ApplicationMapp $map 
        * @returns X\Application
        */
        public function setApplicationMap(ApplicationMap $m) {
            $this->applicationMap = $m;
            return $this;
        }
        /**
        * @returns \X\Map\ApplicationMap
        */
        public function getApplicationMap() {
            return $this->applicationMap;
        }
    
    /**
    * @var \X\Map\FileMap
    */
    private $fileMap;
        /**
        * @param \X\Map\FileMap
        * @returns \X\Application
        */
        public function setFileMap(FileMap $fs) {
            $this->FileMap = $fs;
            return $this;
        }
        /**
        * @returns \X\Map\FileMap
        */ 
        public function getFileMap() {
            return $this->FileMap;
        }    
     
    private $server;
        /**
        * @param \X\Application\Server\IServer
        * @returns \X\Application
        */
        public function setServer(Application\Server\IServer $server) {
            $this->server = $server;
            return $this;
        }
        /**
        * @returns \X\Application\Server\IServer
        */ 
        public function getServer() {
            return $this->server;
        }
    
    public function __invoke() {
        return $this->run();
    }   
    
    public function run() {
        return $this->getServer()->serve($this->applicationRequest);
    }
}
