<?php
	
	session_start();
	
	$PrjDir = 'GSAW_MVC/';
	$AppDir = 'App/'; // define el App

	
	define('_APP_DIR_', $AppDir);
	define('_URL_', 'http://'.$_SERVER["HTTP_HOST"].'/'.$PrjDir);	
	
		//define('_URL_CORP_', 'http://www.cpisalud.com.ar');	
	define('_URL_CORP_', 'http://www.bristolpark.com.ar/home/');	
	define('_TITLE_', 'Intranet C.P.I.');	
	
	
	require_once('functions/MP_Query_pdo.php');
	require_once('functions/log.php');	
	require_once('functions/request.php');
	
	require_once(_APP_DIR_.'/config/config.php');	
		
	require_once('core/model.php');
	require_once('core/controller.php');
	include('core/router.php');
		
?>