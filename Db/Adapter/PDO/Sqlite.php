<?php
/** X - xphp.org Application Framework **
* 
* Adapter Abstract
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Db
*/

namespace X\Db\Adapter\PDO;

class Sqlite extends \X\Db\AAdapter {
    public function __construct(array $conOpts) {
        $dsn = sprintf('%s:%s', $conOpts['driver'], $conOpts['name']);
        $this->pdo = new \PDO($dsn, $conOpts['username'], $conOpts['password']);
    }   
    
    public function createTable($table, $fields) {
        $f = array();
        foreach($fields as $field => $type) {
            $f[] = "$field $type";
        }
        $this->pdo->query('CREATE TABLE ' . $table . '(' . implode(',', $f) . ');');
    }
}