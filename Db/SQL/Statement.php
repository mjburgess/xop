<?php
/** X - xphp.org Application Framework **
* 
* Statement Factory
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Db\SQL
*/

namespace X\Db\SQL;
use \X\Db\SQl\Statement;

class Statement {
    /**
    * @returns \X\Db\SQL\Statement\Select
    */
    public static function select() {
        return new Statement\Select();
    }
    
    /**
    * @returns \X\Db\SQL\Statement\Insert
    */
    public static function insert() {
        return new Statement\Insert();
    }
    
    /**
    * @returns \X\Db\SQL\Statement\Update
    */
    public static function update() {
        return new Statement\Update();
    }
    
    /**
    * @returns \X\Db\SQL\Statement\Delete
    */
    public static function delete() {
        return new Statement\Delete();
    }
}