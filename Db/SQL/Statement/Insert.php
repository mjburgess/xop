<?php
/** X - xphp.org Application Framework **
* 
* Insert Statement
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Db\SQL\Statement
*/

namespace X\Db\SQL\Statement;

class Insert extends \X\Db\SQL\AStatement {
    /**
    * @returns \X\Db\SQL\Statement\Insert
    */
    public function into($table) {
        $this->setSql("INSERT INTO $table");
        return $this;
    }
    
    /**
    * @returns \X\Db\SQL\Statement\Insert
    * @param array $fields
    */
    public function values(array $data) {
        $bound = array();
        foreach($data as $f => $v) {
            $bound[] = ":$f";
        }
        
        $this->sqlAppend(sprintf(' (%s) VALUES(%s)', implode(', ', array_keys($data)),
                                                     implode(', ', $bound)));
        return $this;                                             
    }
}