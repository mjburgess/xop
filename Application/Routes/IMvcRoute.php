<?php
/** X - xphp.org Application Framework **
* 
* Routing interface.
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Application\Routes
*/
namespace X\Application\Routes;

interface IMvcRoute {
    public function getController();
    public function getAction();
    public function asMvcRequest();
}