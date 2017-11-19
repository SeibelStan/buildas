<?php

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
    return $minified;
}