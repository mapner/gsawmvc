<?php
/*
**************************************************************
* (c) 2012 - Mauricio Pistiner
* 
* 
*
************************************************************

*/

require_once(_APP_DIR_.'models/sys_users.php');

class controller_Sys_Users {

	function Login(){
		
		$usr = new MODEL_SYS_USERS;
		if($usr->Login()) {

			$_SESSION["usr_id"] = $usr->usr_id;
			$_SESSION["usr_nombre"] = $usr->usr_nombre;
			echo json_encode(array('success'=>true));		
			
		}
		else
		{
			if($usr->errormsg>' '){
				echo json_encode(array('msg'=>$usr->errormsg));	
			}
			else{
				echo json_encode(array('msg'=>'El usuario o clave son incorrectos'));	
			}
	}
}
	function Logout(){

	session_unset();
	session_destroy();		
	include(_APP_DIR_."views/login.php");
	
	}

}


?>