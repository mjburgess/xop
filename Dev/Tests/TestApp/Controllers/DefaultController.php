<?php
/** X - xphp.org Application Framework **
* 
* Default Controller
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Controller
*/

namespace X\Dev\Tests\TestApp\Controllers;

class DefaultController extends \X\Controller\AController {
    public function index() {
        if($this->template) {
            $this->template->addVariable('name', $this->template->getName());
        } else { //we're using the basic mvc server
            return 'BasicIndex';
        }
    }
}