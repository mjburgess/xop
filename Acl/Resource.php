<?php
/** X - xphp.org Application Framework **
* 
* An ACL Resource.
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Acl  
*/
namespace X\Acl;

class Resource {
    private $credentials;
        public function assign($cID, $minRole) {
            $this->credentials[$cID] = new Credential($cID, $minRole);
            return $this;
        }      
        public function getCredential($cID) {
            return $this->credentials[$cID];
        }              
        public function hasCredential($cID) {
            return isset($this->credentials[$cID]);
        }
    private $parent;
        public function setParent(Resource $p) {
            $this->parent = $p;
        }
        public function getParent() {
            return $this->parent;
        }
    private $resourceID;
        public function setID($id) {
            $this->resourceID = $id;
        }
        public function getID() {
            return $this->resourceID;
        }
    public function __construct($id, array $credentials = null, Resource $parent = null) {
        $this->resourceID = $id;
        $this->parent = $parent;
        $this->credentials = array();
        
        if($credentials) {
            foreach($credentials as $c) {
                $this->assign($c[0], $c[1]);
            }
        }
    }
    
    public function credentialRole($cID) {
        $current = $this;
        while($current != null) {
            if($current->hasCredential($cID)) {
                return $current->getCredential($cID)->getRoleID();
            }
            
            $current = $current->getParent();
        }
        
        return false;
    }
}