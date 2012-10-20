<?php

$requestURI = explode('/', $_SERVER['REQUEST_URI']);
$scriptName = explode('/',$_SERVER['SCRIPT_NAME']);
for($i= 0;$i < sizeof($scriptName);$i++)
{
	if ($requestURI[$i]     == $scriptName[$i])
	{
		unset($requestURI[$i]);
	}
}
$command = array_values($requestURI);
if (sizeof($command) <2 or empty($command[1]) or (!isset($_SESSION["usr_id"]) and $command[1]<> 'Login' and $command[1]<> 'test'))
{
	$command = array('main','Main');
}
$file = 	_APP_DIR_.'controllers/'.$command[0].'.php';
$class = 'controller_'.$command[0];
$method = $command[1];

if (!file_exists($file)){
	echo "Error en Archivo";
	return;
}

include_once($file);
for($i= 2;$i < sizeof($command);$i++)
{
	$parameters = explode('=', $command[$i]);							
	if (sizeof($parameters)==2)
	{
		$_GET[$parameters[0]] = $parameters[1];
	}
}
if (!method_exists($class,$method)) {
	echo "Error en Clase o Metodo";
	return;
}
$cls = new $class;
call_user_func_array(array(&$cls, $method),array());


?>