<?php
/** X - xphp.org Application Framework **
* 
* Server Interface
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage ?
*/
namespace X\Application\Server;

interface IServer {
    public function setApplication(\X\Application $app);
    public function registerServer();
    public function serve();
}
