<?php
/** X - xphp.org Application Framework **
* 
* Controller Interface, for use with MVC Servers
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Controller
*/

namespace X\Controller;

interface IController { 
    public function setApplication(\X\Application $a);
}
