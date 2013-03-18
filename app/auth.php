<?php

if (empty($_POST['auth'])){
    return array();
}

$result = array(
    'error' => array()
);


$user = App::map()->user()->getByName($_POST['name']);
if ($user === false || $user->password !== md5($_POST['pwd'])){
    $result['error'][] = 'Имя пользователя или пароль введены не верно';
}

if (empty($result['error']) === false){
    return $result;
}

Auth::authorize($user);

redirect('/profile.html');
