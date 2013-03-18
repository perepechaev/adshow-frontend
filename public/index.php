<?php

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_QUIET_EVAL, 1);

// Create a handler function
function my_assert_handler($file, $line, $code, $msg = '')
{
    throw new Exception($msg, (int) $code);
}
function my_error_handler($errno, $errstr, $errfile, $errline)
{
    throw new Exception("<h3>$errstr</h3>$errfile:$errline", (int) $errno);
}
// Set up the callback
assert_options(ASSERT_CALLBACK, 'my_assert_handler');
set_error_handler("my_error_handler", E_ALL | E_STRICT);


ob_start();

try {
    date_default_timezone_set('Europe/Moscow');

    chdir('..');

    require_once 'lib/core.php';
    require_once 'lib/dump.php';

    Auth::autostart();
    Auth::login();

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'main';

    if ($action === 'logout'){
        Auth::logout();
    }

    $action = new Action($action);

    $template = $action->run();
    include "view/layout.php";

}
catch (AuthException $e){
    $template = new Template('auth');
    include "view/layout.php";
}
catch (RedirectException $e){
    $e->run();
}
catch (Exception $e){
    echo "<h1>Runtime error</h1>";
    echo "{$e->getMessage()}";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

ob_end_flush();
