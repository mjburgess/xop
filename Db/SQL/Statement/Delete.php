<?php
/** X - xphp.org Application Framework **
* 
* Delete Statement
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Db\SQL\Statement
*/

namespace X\Db\SQL\Statement;

class Delete extends \X\Db\SQL\AStatement {
    /**
    * @returns \X\Db\SQL\Statement\Delete
    */
    public function from($table) {
        $this->setSql("DELETE FROM $table");
        
        return $this;
    }
}
