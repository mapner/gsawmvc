<?php

/*

**************************************************************
* (c) 2012 - Mauricio Pistiner
* 
* CRUD 
* CLN_OAU_INT
*
************************************************************

*/

class controller_Main {
   
	function Main(){		
				
		if (!isset($_SESSION["usr_id"])) {	
			include(_APP_DIR_.'views/login.php');
		} 
		else{
			include(_APP_DIR_."views/main.php");		
		}

	}

	function MenuJson () {

$result = <<<MSG
	[{
	"id":1,
	"text":"Auditor�a M�dica",
	"iconCls":"icon-ok",
	"children":[{
		"id":1,
		"text":"Internaciones",
		"attributes":{
			"type":"tab",	
			"url":"index.php/cln_oau_int/MuestraGrilla"}}	
		]},
{
"id":2,
	"text":"Administraci�n",
	"iconCls":"icon-ok",
	"children":[{			
		"id":1,
		"text":"Padr�n Afilidos",
		"attributes":{
			"type":"tab",	
			"url":"index.php/cln_pac/MuestraGrilla"}}]					
}]

MSG;
	
	echo utf8_encode ($result);
	
	}

}
?>