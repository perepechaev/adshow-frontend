<?php

if (Auth::isAdmin() === false){
    throw new AuthException('Forbidden', 403);
}

function file_search($path){
    $files = array();

    foreach ( glob( $path . '/*') as $file){
        if (is_dir($file) === true){
            $files = array_merge($files, file_search($file));
            continue;
        }
        if ( substr($file, -4) === '.php' ){
            $files[] = $file;
        }
    }
    return $files;
}


$files = file_search('view');
foreach ($files as &$file){
    $file = substr($file, 4, -4) . '.html';
}

return array('files' => $files);
