<?php
namespace Milia\Framework\Configuration;
use Milia\FrameWork\Exception\UndefinedConfigException as Exc;
class Config{
/**
 * 
 * 
 */
public static function get($config = ''){
    $_config = explode('.',$config);
    $config = (isset($GLOBALS{'config'})) ? $GLOBALS{'config'} : [] ;

    if (count($_config) > 1) {
        $config_file = CONFIG_DIR.DS.$_config[0].'.php';
        if(file_exists($config_file)){
            require $config_file;
            $config = $GLOBALS{'config'}{$_config[0]};
        }else{
            throw new Exc("Error When get config file :".$config[0], 1);
        }
    }
    unset($_config[0]);
    foreach ($_config as $value) {
        if (isset($config[$value])) {
            $config = $config[$value];
        }
    }
    return $config;
}
}