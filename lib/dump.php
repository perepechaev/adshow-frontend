<?php

$autostart =  '/home/' . trim(`whoami`) . '/php-bin/autostart.php';
if (file_exists($autostart)){
	include $autostart; 
}

$_REQUEST['dump'] = 1;
$_REQUEST['force_cli'] = isset($_REQUEST['force_cli']) ? $_REQUEST['force_cli'] : 0;
$_REQUEST['force_error_log'] = 0;
$_REQUEST['force_nocolor'] = isset($_REQUEST['force_nocolor']) ? $_REQUEST['force_nocolor'] : 0;

function dd(){
    if (empty($_REQUEST['dump'])){
        return;
    }

	$args = func_get_args();
    call_user_func_array('dump', $args);
    die;
}

// Dump with htmlspecialchars
function dh(){
	$args = func_get_args();
	foreach ($args as &$arg){
		if ( is_string($arg) === true) {
			$arg = htmlspecialchars($arg);
		}
	}
	call_user_func_array('dd', $args);
}

function dm(){
    if (empty($_REQUEST['dump'])){
        return;
    }

    $force_cli = $_REQUEST['force_cli'];
    $force_nocolor = $_REQUEST['force_nocolor'];

    $_REQUEST['force_cli'] = 1;
    $_REQUEST['force_nocolor'] = 1;


    $args = func_get_args();
    ob_start();
    call_user_func_array('dump', $args);
    $content = ob_get_clean();

    $trace = debug_backtrace();
    foreach ($trace as $item){
        if (empty($item['file']) || $item['file'] === __FILE__){
            continue;
        }
        $subj  = $item['file'] . ":" . $item['line'];
        break;
    }
 
    $_REQUEST['force_cli'] = $force_cli;
    $_REQUEST['force_nocolor'] = $force_nocolor;

	ob_start();
    debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
	$content .= "\n" . "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$content .= "\n" . ob_get_contents();
	ob_end_clean();

    mail('dm', $subj, $content); 
}

function _dump_display($string){
    if ($_REQUEST['force_error_log']){
        $fp = fopen('php://stderr', 'a');
        fputs($fp, $string);
    }
    else {
        echo $string;
    }
}

function dm_old(){
    if (empty($_REQUEST['dump'])){
        return;
    }

    $force_cli = $_REQUEST['force_cli'];
    $force_nocolor = $_REQUEST['force_nocolor'];

    $_REQUST['force_cli'] = 0;
    $_REQUEST['force_nocolor'] = 0;


    ob_start();
	$args = func_get_args();
    call_user_func_array('dump', $args);
    $content = ob_get_contents();
    ob_end_clean();

    mail('dm@mail.ru', 'dump', $content);
	die;
}

function dfl(){
    $trace = debug_backtrace();
    foreach ($trace as $item){
        if (empty($item['file']) || $item['file'] === __FILE__){
            continue;
        }
        if (((php_sapi_name() === 'cli' || !empty($_REQUEST['force_cli']))) && empty($_REQUEST['force_nocolor'])) {
            $txt = sprintf("\033[0;32mDUMP: %s:%d\033[0m\n", $item['file'], $item['line']);
        }
        if (php_sapi_name() === 'cli' || !empty($_REQUEST['force_cli'])){
            $txt = sprintf("DUMP: %s:%d\n", $item['file'], $item['line']);
        }
        else {
            $txt = sprintf('<h3 style="color: green">DUMP: %s:%d</h3>', $item['file'], $item['line']); 
        } 
        _dump_display($txt);
        break;
    }
}

function dc($object){
    if (empty($_REQUEST['dump'])){
        return;
    }

    dfl();
	debug_color_dump(get_class($object));
	die;
}

function db(){
    echo "<pre>";
    debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
    echo "</pre>";
}

function dump(){
    if (empty($_REQUEST['dump'])){
        return;
    }

    dfl();

    $args = func_get_args();
    foreach ($args as $variable){
        debug_variable($variable);
    }
}

function debug_variable($var){
    if (is_object($var) && is_a($var, 'Varien_Object')) {
        dobject($var);
        $var = $var->getData();
    }
    elseif (is_object($var) && is_a($var, 'Zend_Db_Table_Row')){
        dobject($var);
        $var = $var->toArray();
    }

    debug_color_dump($var);
    return;
    if (is_object($var) || is_array($var)){
        _dump_display(print_r($var, true));
    }
    else {
        debug_color_dump($var);
    }
}

function debug_color_dump($var){
    if (!empty($_REQUEST['force_cli']) || (php_sapi_name() === 'cli')){
        if (is_object($var) || is_array($var)){
            $result = print_r($var, true);
        }
        else {
            $result = var_export($var, true);
        }

        if (empty($_REQUEST['force_nocolor'])){
            $txt = sprintf("\033[0;31m(%s): \033[0;33m%s\033[0m\n", gettype($var), $result);
        }
        else {
            $txt = sprintf("(%20s): %s\n", gettype($var), $result);
        }
    }
    elseif (!empty($_REQUEST['force_cli'])){
        ob_start();
        (is_object($var) || is_array($var)) ? print_r($var) : var_dump($var);
        $txt = ob_get_clean();
    }
    else{
        ob_start();
        echo "<pre>";
        if (is_array($var)){
            array_walk_recursive($var, function(&$item){
                if (is_string($item)){
                    $item = htmlspecialchars($item);
                }
            });
        }
		elseif (is_string($var)){
			$var = htmlspecialchars($var);
		}
        (is_object($var) || is_array($var)) ? print_r($var) : var_dump($var);
        echo "</pre>";
        $txt = ob_get_clean();
    }

    _dump_display($txt);
}

function cl($object){
    if (empty($_REQUEST['dump'])){
        return;
    }

    debug_color_dump(get_class($object));
}

function dumpf($pattern){
    if (empty($_REQUEST['dump'])){
        return;
    }

    $args = func_get_args();
    debug_color_dump( call_user_func_array('sprintf', $args));
}

function php2js($a=false)
 {
   if (is_null($a)) return 'null';
   if ($a === false) return 'false';
   if ($a === true) return 'true';
   if (is_scalar($a))
   {
     if (is_float($a))
     {
       // Always use "." for floats.
       $a = str_replace(",", ".", strval($a));
     }

     // All scalars are converted to strings to avoid indeterminism.
     // PHP's "1" and 1 are equal for all PHP operators, but
     // JS's "1" and 1 are not. So if we pass "1" or 1 from the PHP backend,
     // we should get the same result in the JS frontend (string).
     // Character replacements for JSON.
     static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'),
     array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
     return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
   }
   $isList = true;
   for ($i = 0, reset($a); $i < count($a); $i++, next($a))
   {
     if (key($a) !== $i)
     {
       $isList = false;
       break;
     }
   }
   $result = array();
   if ($isList)
   {
     foreach ($a as $v) $result[] = php2js($v);
     return '[ ' . join(', ', $result) . ' ]';
   }
   else
   {
     foreach ($a as $k => $v) $result[] = php2js($k).': '.php2js($v);
     return '{ ' . join(', ', $result) . ' }';
   }
 }

function dobject($object){


    $classname = get_class($object); 
    if (php_sapi_name() === 'cli' || !empty($_REQUEST['force_cli']) && empty($_REQUEST['force_nocolor'])) {
        $txt = sprintf("\033[1;34mObject: \033[0;37m%s\033[0m\n", $classname);
    }
    elseif (!empty($_REQUEST['force_nocolor']) || !empty($_REQUEST['force_cli'])){
        $txt = 'Object: ' . $classname . "\n";
    }
    else {
        $txt = '<h3>Object: <span style="color:blue">' . $classname . '</h3>';
    }

    _dump_display($txt);
    return;
    ob_start();
    debug_zval_dump($object);
    $content = ob_get_clean();
    print_r( substr($content, 0, strpos($content, '{')) . "\n" );
}

function dump_interface($class_name, $function_body_callback = null){
    $reflection = new ReflectionClass($class_name);
    $class = $reflection->isAbstract() ? 'abstract ' : '';
    $class .= 'class ' . $reflection->getName();
    $class .= $reflection->getParentClass() ? ' extends ' . $reflection->getParentClass()->getName() : '';
    $class .= $reflection->getInterfaceNames() ? ' implements ' . implode(', ', $reflection->getInterfaceNames()) : '';
    
    $body = '';
    foreach ($reflection->getConstants() as $key => $constant) {
        $body .= "    const " . $key . " = " . var_export($constant, true) . ";\n";
    }
    
    $body .= "\n";
    
    foreach ($reflection->getProperties() as $name => $property){
        /* @var ReflectionProperty $property */
        $property instanceof ReflectionProperty;
        if ($property->getDeclaringClass()->getName() !== $reflection->getName()){
            continue;
        }
        $body_property = '';
        if ($property->getDocComment()){
            $body_property .= $property->getDocComment();
        }
        
        $body .= $body_property;
        $body .= '    ';
        if ($property->isStatic()){
            $body .= 'static ';
        }
        
        if ($property->isPrivate()){
            $body .= 'private ';
        }
        elseif ($property->isProtected()){
            $body .= 'protected ';
        }
        elseif ($property->isPublic()){
            $body .= 'public ';
        }
        
        $body .= '$' . $property->getName();
        //$body .= $property->getValue() ? ' = ' . var_export($property->getValue(), true) : '';
        $body .= ";\n";
    }
    
    $body .= "\n";
    
    foreach ($reflection->getMethods() as $method){
        /* @var ReflectionMethod $method */
        $method instanceof ReflectionMethod;
        
        if ($method->getDeclaringClass()->getName() !== $reflection->getName()){
            continue;
        }
        
        $body .= '    ';
        
        if ($method->isAbstract()){
            $body .= 'abstract ';
        }
        
        if ($method->isStatic()){
            $body .= 'static ';
        }
        
        if ($method->isPrivate()){
            $body .= 'private ';
        }
        elseif ($method->isProtected()){
            $body .= 'protected ';
        }
        elseif ($method->isPublic()){
            $body .= 'public ';
        }
        
        $body .= 'function ' . $method->getName();
        
        $parameters = array();
        foreach ($method->getParameters() as $parameter){
            /* @var ReflectionParameter $parameter */
            $parameter instanceof ReflectionParameter;
            $value = $parameter->isOptional() ? ' = ' . 'null' : '';
            $class_name = $parameter->getClass() ? $parameter->getClass()->getName() . ' ' : '';
            $parameters[] = $class_name . '$' . $parameter->getName() . $value;
        }
        $body .= sprintf("(%s)", implode(', ', $parameters));
        $body .= sprintf("{\n%s\n    }\n\n", $function_body_callback ? $function_body_callback($method) : null);
    }
    
    $body = sprintf("%s\n{\n%s\n}\n", $class, $body);
    //$body = str_replace("\n\n", "\n", $body);
    _dump_display(highlight_string("<?php \n\n" . $body . '<pre>', true));
    dd((string) $reflection);
}

function dump_interface_parent_method(ReflectionMethod $method){
    $parameters = array();
    foreach ($method->getParameters() as $param) {
        $parameters[] = '$' . $param->getName();
    }
    return '        parent::' . $method->getName() . '(' . implode(', ', $parameters) . ");";
}

function print_dep($data, $max_dep = 4, $dep = 0){
    if ($max_dep < $dep){
        return;
    }
    foreach ($data as $key => $value){
        if (is_array($value)){
            echo str_pad(' ', 8*$dep). "[$key] => array(";
            if (!empty($value)){
                echo "\n";
                print_dep($value, $max_dep, $dep + 1);
                echo str_pad(' ', 8*$dep) . ");\n";
            }
            else {
                echo ");\n";
            }
        } 
        elseif (is_object($value)){
            echo str_pad(' ', 8*$dep). "[$key] => object " . get_class($value) . "\n";
        }
        elseif (is_resource($value)){
            dd("RESOURCE");
        }
        else {
            echo str_pad(' ', 8*$dep). "[$key] => $value\n";
        }

        if (is_object($value)){
            print_dep((array) $value->toArray(), $max_dep, $dep + 1);
        }
    }
}