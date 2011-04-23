<?php
namespace X\User;

class User implements \X\Acl\IAgent {
    private $level;  
        public function setLevel($lvl) {
            $this->level = $lvl;
        }
        public function getLevel() {
            return $this->level;
        }
        
    private $credentials; 
        public function setCredentials(array $cred) {
            $this->credentials = $cred;
        }
        public function getCredentials() {
            return $this->credentials;
        }
}

