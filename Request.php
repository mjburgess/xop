<?php 
/** X - xphp.org Application Framework **
* 
* External Request Information (GET/POST).
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage -
*/

namespace X;

class Request {
    private $queryData;
        /** 
        * @param array $getData
        */
        public function setQueryData(array &$qData) {
            $this->queryData = $qData;
        }
        /**
        * @returns array
        */
        public function getQueryData() {
            return $this->queryData;
        }
        
    private $postData;
        /**
        * @param array $postData    
        */
        public function setPostData(array &$postData) {
            $this->postData = $postData;
        }
        /**
        * @returns array
        */
        public function getPostData() {
            return $this->postData;
        }
        
    private $serverData;
        public function setServerData(array &$data) {
            $this->serverData = $data;
        }
        public function getServerData() {
            return $this->serverData;
        }
        
    private $cookieData;    
        /**
        * @param array $cookieData
        */
        public function setCookieData(array &$cookieData) {
            $this->cookieData = $cookieData;
        }
        /** 
        * @returns array
        */
        public function getCookieData() {
            return $this->cookieData;
        }
        
    public function __construct() {
        $this->setQueryData($_GET);
        $this->setPostData($_POST);
        $this->setServerData($_SERVER);
        $this->setCookieData($_COOKIE);
    } 
    
    public function postSent() {
        return $this->serverData['REQUEST_METHOD'] == 'POST';
    }
    
    public function querySent() {
        return $this->serverData['REQUEST_METHOD'] == 'GET';
    }
    public function postHas($key) {
        return isset($this->postData[$key]);
    }  
    
    public function queryHas($key) {
        return isset($this->queryData[$key]);
    }
    
    /** 
    * @param string $key 
    * @param [int] $filter = FILTER_DEFAULT
    * @param [mixed] $options
    * @returns mixed (typically string)
    */
    public function getServer($key, $filter = FILTER_DEFAULT, $options = array()) {
        return filter_var($this->serverData[$key], $filter, $options);
    }
        
    /**
    * @param mixed (basic|array) $key
    * @param mixed $value
    * @returns X\Request
    */
    public function setServer($key, $value) {
        if(is_array($key)) {
            $this->serverData(array_merge($this->serverData, $value));
        } else {
            $this->serverData[$key] = $value;
        }
        
        return $this;
    }
    /** 
    * @param string $key 
    * @param [int] $filter = FILTER_DEFAULT
    * @param [mixed] $options
    * @returns mixed (typically string)
    */
    public function getQuery($key, $filter = FILTER_DEFAULT, $options = array()) {
        return filter_var($this->queryData[$key], $filter, $options);
    }
    /**
    * @param mixed (basic|array) $key
    * @param mixed $value
    * @returns X\Request
    */
    public function setQuery($key, $value) {
        if(is_array($key)) {
            $this->queryData(array_merge($this->queryData, $value));
        } else {
            $this->queryData[$key] = $value;
        }
        
        return $this;
    }
    
    /** 
    * @param string $key 
    * @param [int] $filter = FILTER_DEFAULT
    * @param [mixed] $options
    * @returns mixed (typically string)
    */
    public function getPost($key, $filter = FILTER_DEFAULT, $options = null) {
        return filter_var($this->postData[$key], $filter, $options);
    }
    
    /**
    * @param mixed (basic|array) $key
    * @param mixed $value
    * @returns X\Request
    */
    public function setPost($key, $value) {
        if(is_array($key)) {
            $this->postData(array_merge($this->getData, $value));
        } else {
            $this->postData[$key] = $value;
        }
        
        return $this;
    }
    
    public function setCookie($name, $value = null, $expireTime = null,  
                                array $options = array(), $asCookie = true) {
        extract($options + 
                array('path' => null, 'domain' => null, 'secure' => null, 'httpOnly' => null));
                
        if($asCookie) { 
            setcookie($name, $value, $expireTime, $path, $domain, $secure, $httpOnly);
        } else {
            $this->cookieData[$name] = $value;
        }
        
        
    }
    
    /** 
    * @param string $key 
    * @param [int] $filter = FILTER_DEFAULT
    * @param [mixed] $options
    * @returns mixed (typically string)
    */
    public function getCookie($key, $filter = FILTER_DEFAULT, $options = null) {
        return filter_var($this->cookieData[$key], $filter, $options);
    }
    
    public function deleteCookie($name) {
        setcookie($name, time() - 1E5);
    }
}
