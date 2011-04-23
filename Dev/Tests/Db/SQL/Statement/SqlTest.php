<?php
class SqlTest extends PHPUnit_Framework_Testcase {
    public function testSelect() {
        $fields = array('id', 'name');
        $table  = 'users';
        $data   = array('id' => 2, 'email' => 'test@localhost');
        $limit  = 1;
        $readFrom = 0;
        
        $sql = \X\Db\SQL\Statement::select()->fields($fields)->from($table)
                   ->where($data)->limit($readFrom, $limit);
        $this->assertEquals('SELECTid,nameFROMusersWHEREid=:idANDemail=:emailLIMIT0,1',
                            str_replace(' ', '', $sql));
    }
    
    public function testInsert() {
        $table  = 'users';
        $data   = array('id' => 2, 'email' => 'test@localhost');
        
        $sql = \X\Db\SQL\Statement::insert()->into($table)->values($data);
        $this->assertEquals('INSERTINTOusers(id,email)VALUES(:id,:email)',
                            str_replace(' ', '', $sql));
        
    }
    public function testUpdate() {
        $table  = 'users';
        $data   = array('id' => 2, 'email' => 'test@localhost');
        
        $sql = \X\Db\SQL\Statement::update()->table($table)->set($data);
        $this->assertEquals('UPDATEusersSETid=:id,email=:email', 
                            str_replace(' ', '', $sql));
        
    }
    public function testDelete() {
        $table  = 'users';
        $data   = array('id' => 2, 'email' => 'test@localhost');
        
        $sql = \X\Db\SQL\Statement::delete()->from($table)->where($data);
        
        $this->assertEquals('DELETEFROMusersWHEREid=:idANDemail=:email', 
                            str_replace(' ', '', $sql));
    }
}