<?php
/** X - xphp.org Application Framework **
* 
* Executable SQL Statement
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage ?
*/

namespace X\Db\SQL;

abstract class AStatement {
    private $sql;
            /**
            * @param
            * @returns
            */
            public function setSql($sql) {
                $this->sql = $sql;
                return $this;
            }
            /**
            * @returns string
            */ 
            public function getSql() {
                return $this->sql;
            }
                
    
    public function __toString() {
        return $this->getSql();
    }
    
    public function sqlAppend($append) {
        $this->sql .= $append;
        return $this;
    }

    /**
    * @param array | string
    * @returns \X\Db\Statement\Select
    */
    public function where($condition) {
        if(empty($condition)) {
            return $this;
        }
        
        $this->sqlAppend(' WHERE ');
        
        if(is_array($condition)) {
            $conds = array();
            foreach($condition as $field => $value) {
                $conds[] = " $field = :" . str_replace('.', '_', $field);
            }
            $this->sqlAppend(implode(' AND ', $conds));
        } else {
            $this->sqlAppend($condition);
        }
        
        return $this;
    }
    
    /**
    * @param array | string
    * @returns \X\Db\Statement\Select
    */
    public function andWhere($condition) {
        $this->sqlAppend(' AND ');
        if(is_array($condition)) {
            $conds = array();
            foreach($condition as $field => $value) {
                $conds[] = " $field = :" . str_replace('.', '_', $field);
            }
            $this->sqlAppend(implode(' AND ', $conds));
        } else {
            $this->sqlAppend($condition);
        }
        
        return $this;
    }
    
    /**
    * @param array | string
    * @returns \X\Db\Statement\Select
    */
    public function orWhere($condition) {
        $this->sqlAppend(' OR ');
        if(is_array($condition)) {
            $conds = array();
            foreach($condition as $field => $value) {
                $conds[] = " $field = :" . str_replace('.', '_', $field);
            }
            $this->sqlAppend(implode(' OR ', $conds));
        } else {
            $this->sqlAppend($condition);
        }
        
        return $this;
    }
}