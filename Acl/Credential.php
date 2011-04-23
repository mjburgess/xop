<?php
namespace X\Acl;

class Credential {
    private $roleID;
        public function setRoleID($rID) {
            $this->roleID = $rID;
        }
        public function getRoleID() {
            return $this->roleID;
        }
    private $credentialID;
        public function setID($id) {
            $this->credentialID = $id;
        }
        public function getID() {
            return $this->credentialID;
        }
    public function __construct($id, $rID) {
        $this->credentialID = $id;
        $this->roleID = $rID;
    }    
}