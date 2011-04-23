<?php
/** X - xphp.org Application Framework **
* 
* JSON Rendering
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage ?
*/

namespace X\View\Render;

class AsJson implements RenderInterface {
    public function render(\X\View\Template $tpl) {
        return json_encode($tpl->getVariables());
    }
}