<?php
/** X - xphp.org Application Framework **
* 
* Update statement
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Db\SQL\Statement
*/

namespace X\Db\SQL\Statement;

class Update extends \X\Db\SQL\AStatement {
    /**
    * @returns \X\Db\SQL\Statement\Update
    */
    public function table($table) {
        $this->setSql("UPDATE $table SET ");
        return $this;
    }
    
    /**
    * @returns \X\Db\SQL\Statement\Update
    */
    public function set(array $data) {
        $bound = array();
        foreach($data as $f => $v){
            $bound[] = "$f = :$f";
        }
        $this->sqlAppend(implode(', ', $bound));
        return $this;
    }
}