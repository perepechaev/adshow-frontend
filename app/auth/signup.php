<?php

if (empty($_POST['signup'])){
    return array();
}

$result = array(
    'error' => array()
);


$users = App::map()->user()->find($_POST['name'], $_POST['email'], $_POST['phone']);

if ($users !== false){
    $result['error'][] = "Пользователь с такими данными уже зарегестрирован";
}

if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password'])){
    $result['error'][] = "Все поля обязательны для заполнения";
}

if (empty($result['error']) === false){
    return $result;
}

$user = new User();
$user->name = $_POST['name'];
$user->email = $_POST['email'];
$user->phone = $_POST['phone'];
$user->password = md5($_POST['password']);
$user->save();

Auth::authorize($user);

redirect('/profile.html');
