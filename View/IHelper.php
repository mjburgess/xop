<?php
/** X - xphp.org Application Framework **
* 
* View Helper interface
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage View
*/

namespace X\View;

interface IHelper {
    public function setView(\X\View $v);
    public function getName();
}