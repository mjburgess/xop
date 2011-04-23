<?php
/** X - xphp.org Application Framework **
* 
* Select Statement
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Db\SQL\Statement
*/

namespace X\Db\SQL\Statement;

/**
* @todo Binding params...
*/
class Select extends \X\Db\SQL\AStatement {
    
    const ASC = 'ASC';
    const DSC = 'DSC';
    
    /**
    * @para string | array
    */
    public function fields($fields, $table = null) {
        if(is_array($fields)) {
            if($table) {
                foreach($fields as $k=>$v) {
                    $fields[$k] = "$table.$v";
                }
            }
            $fields = implode(', ', $fields);
        } elseif($table) {
            $fields = "$table.$fields";
        }
        
        $this->setSql("SELECT $fields ");
        
        return $this;
    }
    
    /**
    * @param string 
    * @returns \X\Db\Statement\Select
    */
    public function from($table) {
        if(is_array($table)) {
            $table = implode(', ', $table);
        }
        $this->sqlAppend("FROM $table ");
        
        return $this;
    }
    
    
    /**
    * @param string column
    * @param string Select::ASC | Select::DSC
    * @returns \X\Db\Statement\Select
    */
    public function orderBy($col, $order = self::DSC) {
        $this->sqlAppend("$col $order ");
        
        return $this;
    }
    
    /**
    * @param int start 
    * @param int num. records to fetch
    * @returns \X\Db\Statement\Select
    */
    public function limit($start, $number) {
        $this->sqlAppend(" LIMIT $start, $number ");
        
        return $this;
    }
    
    /**
    * @param string col/statement to group by
    * @returns \X\Db\Statement\Select
    */
    public function groupBy($statement) {
        $this->sqlAppend("GROUP BY $statement");
        
        return $this;
    }
    //...
}
