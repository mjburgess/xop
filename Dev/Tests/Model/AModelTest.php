<?php
use \X\Model\Relation;

class User extends \X\Model\AModel {
    public static function defineRelations() {
        return array(
        new Relation('article.username', Relation::HasOne, 'user.name'),
        new Relation('post.username', Relation::HasMany, 'user.name')                                    
        );
    }
}

class Article extends \X\Model\AModel {
    public static function defineRelations() {
        return array(
        new Relation('user.name', Relation::HasManyThru, 'article.pk', 
                    'authors.username.artpk')
        );
    }
}

class Authors extends \X\Model\AModel {}
class Post extends \X\Model\AModel {}

class AModelTest extends PHPUnit_Framework_Testcase {
    private $pdo;
    public function setUp() {
        $con = array('driver' => 'sqlite',
                     'name' => ':memory:');
                     
        $this->pdo = new \X\Db\Adapter\PDO\Sqlite($con);
        \X\Model\AModel::setAdapter($this->pdo);
        $this->createTables();
        $this->createRecords();
    }
    
    private function createTables() {
        $this->pdo->createTable('user',    array('name' => 'string', 'age' => 'int'));
        $this->pdo->createTable('article', array('name' => 'string', 'username' => 'string', 'pk' => 'int'));
        $this->pdo->createTable('post',    array('name' => 'string', 'username' => 'string'));
        $this->pdo->createTable('authors', array('username' => 'string', 'artpk' => 'int'));
    }
    
    private function createRecords() {
        $users = array();
        $users[] = array('name' => 'mjburgess', 'age'  => 20);
        $users[] = array('name' => 'dan',       'age'  => 22);
        $users[] = array('name' => 'ben',       'age'  => 27);
        

        User::createAll($users);
        Article::create(array('name' => 'article1', 'username' => 'mjburgess', 'pk' => 1));
                                                            
        Authors::create(array('artpk' => 1, 'username' => 'mjburgess'));
        Authors::create(array('artpk' => 1, 'username' => 'dan'));
        
        Post::create(array('username' => 'mjburgess', 'name' => 'posta'));
        Post::create(array('username' => 'mjburgess', 'name' => 'postb'));
    }
    
    public function testCreate() {
        $u = User::create();
        $u->name = 'mj';
        $u->age = 21;
        $u->save();
        $this->assertEquals(21, User::readby_name('mj')->age);
    }
    
    public function testRead() {
        $this->assertEquals('ben', User::read(array('age' => 27))->name);
    }
    
    public function testReadWith() {
        $with   = array('user');
        $fields = array('article.name', 'user.name');
        $where  = array('article.name' => 'article1');
        
        $a = Article::readWith($with, $fields, $where);
        $this->assertEquals('article1', $a->name);
        $this->assertEquals('mjburgess', $a->getModel('User')->name);
    }
    public function testUpdate() {
        $m = User::readby_age(20);
        $m->age = 21;
        $m->saveby_name();
        $this->assertEquals('21', User::readby_name($m->name)->age);
    }
       
    public function testDynamicRead() {
        $this->assertEquals(20, User::readby_name('mjburgess')->age);
    }
    
    public function testHasManyThruRelation() {
        $possible = array('dan' => 'dan', 'mjburgess' => 'mjburgess');
        
        $u = User::from(Article::read());
        $this->assertContains($u->name, array_values($possible));
        
        unset($possible[$u->name]); 
        $this->assertContains($u->next()->name, array_values($possible));
    }
    
    public function testHasOneRelation() {
        $this->assertEquals('article1', Article::from(User::read())->name);
    }
    
    public function testHasManyRelation() {
        $possible = array('posta' => 'posta', 'postb' => 'postb');
        
        $p = Post::from(User::readby_name('mjburgess'));
        $p = Post::readby_username('mjburgess');
        $this->assertContains($p->name, array_values($possible));
        
        unset($possible[$p->name]);
        $this->assertContains($p->next()->name, array_values($possible));
    }
    
    
    public function testDelete() {
        $this->assertEquals('mjburgess', User::readby_name('mjburgess')->name);
        $this->assertNotEquals(false, User::delete(array('name' => 'mjburgess')));
        $this->assertNotEquals(false, User::deleteby_name('dan'));
        $this->assertNotEquals(false, User::deleteby_name('ben'));
        $this->assertNotEquals(false, Article::deleteby_pk(1));
        $this->assertNotEquals(false, Authors::deleteby_artpk(1));
        $this->assertNotEquals(false, Post::deleteby_username('mjburgess'));
        $sql = 'SELECT * FROM User, Article, Authors, Post';
        $this->assertEquals(array(), User::readGeneric($sql, array(), true)->fetchAll());
    }
    
    public function testReadGeneric() {
        $sql = 'SELECT * FROM User WHERE name = "dan"';
        $this->assertEquals(22, User::readGeneric($sql, array(), true)->fetch(PDO::FETCH_OBJ)->age);
    }
}