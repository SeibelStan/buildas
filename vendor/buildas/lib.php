<?php

define('BUILDAS_DIR', 'vendor/buildas/');
define('ASSETS_DIR', '../../');

function minify($type, $input) {
    if(!$input) {
        return false;
    }
    if($type == 'js') {
        $url = 'https://javascript-minifier.com/raw';        
    }
    else {
        $url = 'https://cssminifier.com/raw';
    }
    $data = ['input' => $input];
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => 1,
        CURLOPT_RETURNTRANSFER => 1,        
        CURLOPT_POSTFIELDS => http_build_query($data)
    ]);
    $minified = curl_exec($ch);
    curl_close($ch);
    if(preg_match('/502 Bad Gateway/', $minified)) {
        $minified = '';
    }
    return $minified;
}

function getBuildasConfig($dir = '') {
    $dir = $dir ?: BUILDAS_DIR;
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

function checkModify($assetsDir = '', $builderDir = '') {
    $builderDir = $builderDir ?: BUILDAS_DIR;
    $cfg = getBuildasConfig($builderDir);
    $builded = @$cfg->builded;
    $cfg->source->cfg = [BUILDAS_DIR . 'cfg.json'];

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