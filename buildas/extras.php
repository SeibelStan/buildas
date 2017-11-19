<?php

function includeAssets($type) {
    $cfgFile = file_get_contents('buildas/cfg.json');
    $cfg = json_decode($cfgFile);

    if(defined('DEBUG') && DEBUG) {
        $assets = $cfg->source->$type;
    }
    else {
        $assets = [
            $cfg->output->$type
        ];        
    }

    $result = '';
    foreach($assets as $file) {
        if($type == 'js') {
            $result .= '<script src="' . $file . '"></script>';
        }
        elseif($type == 'css') {
            $result .= '<link rel="stylesheet" href="' . $file . '">';
        }
    }
    return $result;
}