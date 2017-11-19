<?php

function includeAssets($type) {
    $dir = 'buildas/';
    $cfgFile = file_get_contents($dir . 'cfg.json');
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