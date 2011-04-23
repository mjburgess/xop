<?php
/** X - xphp.org Application Framework **
* 
* Database Adapter Interface
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Db\Adapter
*/

namespace X\Db;

abstract class AAdapter {
    protected $pdo;  
    
    public function __construct(array $conOpts) {
        $dsn = sprintf('%s:dbname=%s;host=%s', $conOpts['driver'], $conOpts['name'], $conOpts['host']);
        $this->pdo = new \PDO($dsn, $conOpts['username'], $conOpts['password']);
    }   
    
    public function execute($s, array $data) {
        $stmt = $this->pdo->prepare((string) $s);
        if($stmt->execute($data)) {
            return $stmt;
        } else {
            return false;
        }
    } 
    
    public function query($s) {
        return $this->pdo->query((string) $s);
    }
} 