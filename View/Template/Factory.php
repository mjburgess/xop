<?php
/** X - xphp.org Application Framework **
* 
* Template factory, produces View\Templates from IApplicationRequests/MvcRequests, etc.
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage View
*/

namespace X\View\Template;
use \X\Application\MvcRequest;
use \X\Map\FileMap;

class Factory {
    public static function fromMvcRequest(FileMap $fm, MvcRequest $ar, $vars = array()) {
        return new  \X\View\Template($fm, $ar->getController(false), $ar->getAction(), $vars);
    }
}
