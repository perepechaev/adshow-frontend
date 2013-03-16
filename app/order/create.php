<?php


Auth::start();

$_SESSION['flash'] = "Спасибо, с Вами свяжется наш менеджер в ближайшее время";

mail("perepechaev@inbox.ru", "Order from " . $_SERVER['HTTP_HOST'], implode("\n", $_POST));

header('Location: /?action=order/success', true, 302);
exit;
