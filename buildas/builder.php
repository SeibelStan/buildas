<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require('extras.php');

if(!checkModify('../', '')) {
	die();
}

$dir = '../';
$cfg = getBuildasConfig('');

$result = (object) ['js' => '', 'css' => ''];
foreach($cfg->source as $sect => $files) {
	foreach($files as $file) {
		$content = file_get_contents($dir . $file);
		$result->$sect .= $content;
	}
}

if(isset($cfg->min) && $cfg->min) {
	$result->js = minify('js', $result->js);
	$result->css = minify('css', $result->css);
}

foreach($cfg->output as $sect => $file) {
	file_put_contents($dir . $file, $result->$sect);
	chmod($dir . $file, 0777);
}
$cfg->builded = time();
file_put_contents('cfg.json', json_encode($cfg, 386));