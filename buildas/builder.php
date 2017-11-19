<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$dir = '../';
$cfgFile = file_get_contents('cfg.json');
$cfg = json_decode($cfgFile);

$result = (object) ['js' => '', 'css' => ''];
foreach($cfg->source as $sect => $files) {
	foreach($files as $file) {
		$content = file_get_contents($dir . $file);
		$result->$sect .= $content;
	}
}

if($cfg->min) {
	require('minifer.php');
	$result->js = minify('js', $result->js);
	$result->css = minify('css', $result->css);
}

foreach($cfg->output as $sect => $file) {
	file_put_contents($dir . $file, $result->$sect);
	chmod($dir . $file, 0777);
}