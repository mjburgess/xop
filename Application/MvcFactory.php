<?php
/** X - xphp.org Application Framework **
* 
* Mvc App Factory, provides an Application point function (from Configuration, etc.)
* Boostrapping without the factory is perhaps the best solution: config example should not be prefered.
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Application
*/
namespace X\Application;

use \X\Application\Server;
use \X\Map\ApplicationMap;
use \X\Map\FileMap;
use \X\Request;

class MvcFactory {
    public static function fromConfig(\X\Config $config) {
        $app = new \X\Application();
                
        $fileMap = new FileMap($config->get('Application', 'root'));
        $fileMap->setDirs($config->getNamespace('DirMap'));
                
        $map = new ApplicationMap();
        $map->setNamespace('project',    $config->get('Namespaces', 'project'))
            ->setNamespace('controller', $config->get('Namespaces', 'controller'))
            ->setNamespace('model',      $config->get('Namespaces', 'model'));
        
        $route = $config->get('Application', 'routingClass');
        $route = new $route;
        
        $app->setApplicationMap($map)
            ->setFileMap($fileMap)
            ->setApplicationRequest($route->setRequest(new Request())->asMvcRequest());

        $mvc = new Server\MvcServer($app);
        $mvc->setUpView($config->get('View', 'layout', true), 
                        $config->get('View', 'tplExtension', true));
                        
        if($a = $config->get('Database', 'adapter', true)) {
            $mvc->setUpModels($a, $config->getNamespace('Database'));
        }
        
        return $app;
    }
    
    public static function basicServer($projectNamespace, $controllerNamespace = 'Controllers') {
        $map = new ApplicationMap();
        $map->setNamespace('project',    $projectNamespace)
            ->setNamespace('controller', $controllerNamespace);
            
        $route = new \X\Application\Routes\MvcDefaultRoute();
        
        $app = new \X\Application();
        $app->setApplicationMap($map);
        $app->setApplicationRequest($route->setRequest(new Request($_GET, $_POST))->asMvcRequest());
        
        $mvc = new Server\MvcServer($app);
        
        return $app;
    }
}