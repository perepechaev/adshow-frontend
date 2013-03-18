<?php

$file = $_GET['file'];
$file = str_replace('..', '', $file);

$file = 'view' . substr($file, 0, -5) . '.php';

if (file_exists($file) === false){
    header('HTTP/1.0 404 File not found');
    die;

}


if (isset($_POST['save-page'])){
    file_put_contents($file, $_POST['content']);
}

$content = isset($_POST['preview']) ? $_POST['content'] : file_get_contents($file);

return array('content' => $content, 'file' => $_GET['file']);
