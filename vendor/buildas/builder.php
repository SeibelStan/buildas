<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require('lib.php');

if(!checkModify(ASSETS_DIR, './')) {
	die();
}

$cfg = getBuildasConfig('./');

$result = (object) ['js' => '', 'css' => ''];
foreach($cfg->source as $sect => $files) {
	foreach($files as $file) {
		$outer = isOuter($file);
		$content = file_get_contents(($outer ? '' : ASSETS_DIR) . $file);
		$result->$sect .= $content;
	}
}

if(isset($cfg->min) && $cfg->min) {
	$result->js = minify('js', $result->js);
	$result->css = minify('css', $result->css);
}

$builded = time();
foreach($cfg->output as $sect => $file) {
	if(!$result->$sect) {
		$builded = 0;
		continue;
	}
	file_put_contents(ASSETS_DIR . $file, $result->$sect);		
	chmod(ASSETS_DIR . $file, 0777);		
}
$cfg->builded = $builded;
file_put_contents('cfg.json', json_encode($cfg, 386));