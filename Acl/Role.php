<?php

namespace X\Acl;
class Role {
    private $parent;
        public function setParent(Role $p) {
            $this->parent = $p;
        }
        public function getParent() {
            return $this->parent;
        }
    private $roleID;
        public function setID($id) {
            $this->roleID = $id;
        }
        public function getID() {
            return $this->roleID;
        }
    public function __construct($id, Role $parent = null) {
        $this->roleID = $id;
        $this->parent = $parent;
    }
    
    public function isDescendantOf($rID) {
        $current = $this;
        
        while($current != null) {
            if($current->getID() == $rID){
                return true;
            }
            
            $current = $current->getParent();
        }
        
        return false;
    }
}