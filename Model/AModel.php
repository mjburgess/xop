<?php
/** X - xphp.org Application Framework **
* 
* Model Abstract
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Model
*/

namespace X\Model;
use \X\Db\SQL\Statement;
use \X\Db\AAdapter;

abstract class AModel {
    const INSERT = 1;
    const UPDATE = 2;    
    
    private static $transform = 'strtolower';
        public static function setTransform($t) {
            self::$transform = $t;
        }
        public static function getTransform() {
            return self::$transform;
        }
    protected static $adapter;
        public static function setAdapter(AAdapter $apt) {
            self::$adapter = $apt;
        }
        public static function getAdapter() {
            return self::$adapter;
        }
    /* Factories */
    public static function __callStatic($method, $arguments) {
        if(strpos($method, 'readby_') === 0) {
            $searchTerm = str_replace('readby_', '', $method);
            
            $fields   = (isset($arguments[1])) ? $arguments[1] : '*';
            $limit    = (isset($arguments[2])) ? $arguments[2] : false;
            $readFrom = (isset($arguments[3])) ? $arguments[3] : 0;
            
            return self::read(array($searchTerm => $arguments[0]), $fields, $limit, $readFrom);
        } elseif(strpos($method, 'deleteby_') === 0) {
            $searchTerm = str_replace('deleteby_', '', $method);
            return self::delete(array($searchTerm => $arguments[0]));
        } 
    }
    public static function create(array $data = array(), $andSave = true) {
        $This = get_called_class(); $T = self::$transform;
        $model = new static($T($This), $data);
        if(!empty($data) && $andSave) {
            $model->save();
        } else {
            $model->setFetched(true);
        }
        return $model;
    }
    public static function createAll(array $records) {
        $This = get_called_class(); $T = self::$transform;
        $rtn = true;
        
        foreach($records as $record) {
            
            
            $sql = Statement::insert()->into($T($This))->values($record);
            $rtn = $rtn && (static::getAdapter()->execute($sql, $record));
        }
        
        return $rtn;
    }
    public static function read(array $where = array(), $fields = '*', $limit = false, $readFrom = 0) {
        $This = get_called_class(); $T = self::$transform;
        
        if(is_array($fields)) {
            $fields = array_keys($fields);
        }
                
        $model = new static($T($This), $where, self::UPDATE);
        $sql = Statement::select()->fields($fields)->from($model->getTable())->where($where);
        
        if(is_int($limit)) {
            $sql->limit($readFrom, $limit); 
        }
        
        $model->setCurrentStatement($model->getAdapter()->execute($sql, $where));
        
        return $model;
    }
    public static function readAll(array $where = array()) {
        self::read($where, '*', false);
    }
    
    public static function readGeneric($sql, array $where = array(), $raw = false) {
        $stmt = self::getAdapter()->execute($sql, $where);
        if($raw) {
            return $stmt;
        } else {
            return $stmt->fetch(\PDO::FETCH_OBJ);
        }
    }
    
    /**
    * @param array|string $fields must be '*' or an array of qualified field names, eg. User.name
    */
    public static function readWith(array $with, array $fields, array $where = array(), $limit = false, $readFrom = 0) {
        $This = get_called_class(); $T = self::$transform; $ThisTable = $T($This);
        
        $tables = array($ThisTable); $links = array();
        foreach($with as $relation) {
            $r = $relation::defineRelations();
            foreach($r as $x) { 
                if($x->left == $ThisTable) { 
                    $tables[] = $x->right;
                    $links[] = $x->rlLink() . '=' . $x->lrLink();
                }
            }
        }
        
        foreach($fields as $k => $field) {
            if(strpos($field, $ThisTable) !== 0) {
                $fields[$k] = $field . ' AS ' . str_replace('.', '_', $field);
            }
        }
        
        $sql = Statement::select()->fields($fields)->from($tables)->where($where)
                                    ->andWhere(implode(' AND ', $links));
        if(is_int($limit)) {
            $sql->limit($readFrom, $limit); 
        }
        
        foreach($where as $k=>$v) {
            $where[str_replace('.', '_', $k)] = $v;
            unset($where[$k]);
        }
        $model = new static($ThisTable, array(), self::UPDATE);
        $model->setCurrentStatement(self::getAdapter()->execute($sql, $where));
        
        return $model;
    }
    public static function getAll(array $data = array(), $fields = '*') {
        return self::read($data, $fields, '*');
    }
    public static function delete(array $data) {
        $This = get_called_class(); $T = self::$transform;
        $model = new static($T($This), $data);
        $sql = Statement::delete()->from($model->getTable())->where($data);
        return $model->getAdapter()->execute($sql, $data);
    }
    
    public static function from(AModel $from, array $where = array()) {
        $This = get_called_class(); $T = self::$transform; $ThisTable = $T($This);
        $r = $from::defineRelations();
        foreach($r as $x) { if($x->left == $ThisTable) { $r = $x; break;}}
        $sql = $r->getSql($where, $from);
        $model = new static($ThisTable);
        $model->setCurrentStatement($model->getAdapter()->execute($sql, $where));
        
        return $model;
    }
    
    
    /* Instance Vars */
    private $table;
        public function setTable($table) {
            $this->table = $table;
        }
        public function getTable() {
            return $this->table;
        }       
    private $data;
        public function setField($name, $value) {
            $this->data[$name] = $value;
        }
        public function getField($name) {
            return $this->data[$name];
        }
    private $relations;
        public function setRelation(AModel $m) {
            $this->relations[$m->getTable()] = $m;
        }
        public function getRelation($tbl) {
            return $this->relations[$tbl];
        }
        public function getRelations() {
            return $this->relations;
        }
    private $currentStatement;
        protected function setCurrentStatement(\PDOStatement $s) {
            $this->currentStatement = $s;
        }
        protected function getCurrentStatement() {
            return $this->currentStatement;
        }
    private $onSave;
        public function setSaveState($state) {
            $this->onSave = $state;
        }
        public function getSaveState() {
            return $this->onSave;
        } 
    
    private $fetched = false;
        protected function setFetched($state) {
            $this->fetched = $state;
        }
    
    /* Instance Methods */
    protected function __construct($table, array $data = array(), $saveState = self::INSERT) {
        $this->setTable($table);
        foreach($data as $key => $value) {
            $this->setField($key, $value);
        }
        $this->setSaveState($saveState);
    }
    
    public function __get($name) {
        if(!$this->fetched) {
            $this->next();
        }
        return $this->getField($name);
    }
    public function __set($name, $value) {
        if(!$this->fetched) {
            $this->next();
        }
        $this->setField($name, $value);
    }
    public function __call($method, $arguments) {
        if(strpos($method, 'saveby_') === 0) {
            $clause = str_replace('saveby_', '', $method);
            
            if(is_array($arguments[0])) {
                $where = $arguments[0];
            } else {
                $where = array();
            }
            
            return self::save($where, $clause);
        }
    }
    
    public function getModel($modelName) {
        $T = self::$transform;
        $table = $T($modelName);
        
        if(!$this->fetched) {
            $this->next();
        }
        $data = array();
        foreach($this->data as $k=>$datum) {
            if(strpos($k, $table) === 0) {
                $data[str_replace($table . '_', '', $k)] = $this->data[$k];
            }
        }
        $mdl = new $table($table, $data, self::UPDATE);
        $mdl->setFetched(true);
        return $mdl;
    }
    public function fetchAll($as = \PDO::FETCH_ASSOC) {
        return $this->currentStatement->fetchAll($as);
    }
    public function next() {
        $this->fetched = true;
        $this->data = $this->currentStatement->fetch(\PDO::FETCH_ASSOC);
        return $this;
    }
    public function save(array $conditions = array(), $clause = 'id') {
        if($this->onSave == self::INSERT) {   
            $sql = Statement::insert()->into($this->table)->values($this->data);
        } else {
            $conditions = " $clause = :$clause ";
            $sql = Statement::update()->table($this->table)->set($this->data)->where($conditions);
        }
        return $this->getAdapter()->execute($sql, $this->data);
    }
}
