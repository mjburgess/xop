<?php
/** X - xphp.org Application Framework **
* 
* Access Control List Manager.
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Acl
*/
namespace X;
use \X\Acl\Role, \X\Acl\Resource;

class Acl {
    private $roles;
        public function addRole(Role $r, $parentID = null) {
            if($parentID) {
                if(empty($this->roles[$parentID])) {
                    throw new Exception("Role $parentID not registered!");
                }
                $r->setParent($this->roles[$parentID]);
            }
            $this->roles[$r->getID()] = $r;
            return $this;
        }
        public function getRole($rID) {
            return $this->roles[$rID];
        }
        
    private $resources;
        public function addResource(Resource $r, $parentID = null) {
            if($parentID) {
                if(empty($this->resources[$parentID])) {
                    throw new Exception("Parent $parentID not registered!");
                }
                $r->setParent($this->resources[$parentID]);
            }
            $this->resources[$r->getID()] = $r;
            return $this;
        }
        public function getResource($rID) {
            return $this->resources[$rID];
        }
    
    public function allowed($currentRoleID, $resourceID, $credentialID) {
        if(empty($this->roles[$currentRoleID])) {
            throw new Exception("Role $currentRoleID not registered!");
        }
        $minRoleID = $this->resources[$resourceID]->credentialRole($credentialID);
        if($minRoleID) { 
            return $this->roles[$currentRoleID]->isDescendantOf($minRoleID);
        } else {
            return false;
        }
    }
    
    public function agentAllowed(IAgent $a, $resourceID, $credentialID) {
        return $this->allowed($a->getRole(), $resourceID, $credentialID);
    }
}


?>
