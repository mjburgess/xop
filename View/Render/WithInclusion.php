<?php
/** X - xphp.org Application Framework **
* 
* Default (file inclusion) rendering system
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage View
*/

namespace X\View\Render;
use \X\View\Exception;

class WithInclusion implements IRender  {
    public function render(\X\View\Template $tpl) {
        $path = $tpl->getPath();
        if(file_exists($path)) {
            $vars = $tpl->getVariables();
            extract($vars, EXTR_SKIP);
            ob_start();
                include $path;
                $rtn = ob_get_contents();    
            ob_end_clean();    
            return $rtn;
        } else {
            throw new Exception\TemplateNotFound($tpl);
        }
    }
}