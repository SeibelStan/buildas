<?php

function getBuildasConfig($dir = 'buildas/') {
    $cfgFile = file_get_contents($dir . 'cfg.json');
    return json_decode($cfgFile);
}

function isDebug() {
    return defined('DEBUG') && DEBUG;
}

function includeAssets($type) {
    $cfg = getBuildasConfig();
    $assets = isDebug() ? $cfg->source->$type : [$cfg->output->$type];

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

function checkModify($assetsDir = '', $builderDir = 'buildas/') {
    $cfg = getBuildasConfig($builderDir);
    $builded = @$cfg->builded;
    $cfg->source->cfg = ['buildas/cfg.json'];

    $modify = false;
    foreach($cfg->source as $sect => $files) {
        foreach($files as $file) {
            if($builded < filemtime($assetsDir . $file)) {
                $modify = true;
            }
        }
    }
    return $modify;
}