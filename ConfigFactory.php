<?php
/** X - xphp.org Application Framework **
* 
* Config Factory
* 
* @author mjburgess
* @copyright xphp.org, 2010. All Rights Reserved.
* @package X
* @subpackage Config
*/
namespace X;

class ConfigFactory {
    public static function loadFromFile($iniFile) {
        return new Config(parse_ini_file($iniFile));
    }
    
    public static function loadFromString($iniString) {
        return new Config(parse_ini_string($iniString));
    }
    
    public static function loadFromArray(array $iniArray) {
        return new Config($iniArray);
    }
}

