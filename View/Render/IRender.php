<?php
/** X - xphp.org Application Framework **
* 
* Interface for Template Renderers
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage View\Render
*/

namespace X\View\Render;

interface IRender {
    public function render(\X\View\Template $tpl);
}
