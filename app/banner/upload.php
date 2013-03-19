<?php

require_once 'lib/file/FileUpload.class.php';
require_once 'lib/image/Thumbnail.class.php';

$user = Auth::getUser();

$uploader = new FileUpload();
$uploader->setFile($_FILES, 'banner');
$uploader->addAllowedType(array('image/jpeg', 'image/png', 'image/gif'));
$uploader->upload('data/upload/' . $user->id . '/');
//static public function imageCreateFromFile($filename)

$file = $uploader->getFile();


$thumbnail = new Thumbnail();

$thumbnail->output($file, 'data/banners/' . $user->id . '/' . $file->getFileName(), array(
    'width'   => 800,
    'height'  => 600,
));

$thumbnail->output($file, 'data/banners/' . $user->id . '/thumb/' . $file->getFileName(), array(
    'width'   => 200,
    'height'  => 150,
));

/*
            'width'   => 150,
            'height'  => 150,
            'method'  => THUMBNAIL_METHOD_SCALE_MAX,
            'percent' => 0,
            'halign'  => THUMBNAIL_ALIGN_CENTER,
            'valign'  => THUMBNAIL_ALIGN_CENTER,
*/

header('Content-type: image/png');
echo file_get_contents('data/banners/' . $user->id . '/' . $file->getFileName());
//echo file_get_contents('data/banners/' . $user->id . '/thumb/' . $file->getFileName());
die;

return array();
