<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require('lib.php');

if(!checkModify(BUILDAS_ASDIR, './')) {
	die();
}

$cfg = getBuildasConfig('./');

$result = (object)['js' => '', 'css' => ''];
foreach($cfg->source as $sect => $files) {
	foreach($files as $file) {
		$outer = isOuter($file);
		$content = file_get_contents(($outer ? '' : BUILDAS_ASDIR) . $file);
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
	file_put_contents(BUILDAS_ASDIR . $file, $result->$sect);	
	chmod(BUILDAS_ASDIR . $file, 0777);	
	echo md5(file_get_contents(BUILDAS_ASDIR . $file)) . "<br>";	
}
echo $cfg->builded = $builded;
file_put_contents('cfg.json', json_encode($cfg, 386));