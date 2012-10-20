<?php

/*

**************************************************************
* (c) 2012 - Mauricio Pistiner
* 
* 
* Controller base class
*
************************************************************

*/

class CONTROLLER_MP {

function __construct(){

}

	function MuestraVista($view){
		
		include(_APP_DIR_.'views/'.$view.'.php');
		
	}
	
	function CreaModelo($model){
		
		include(_APP_DIR_.'models/'.$model.'.php');
		$class = 'MODEL_'.$model;	
		$omodel = new $class;
		return $omodel;
		
	}
}


?>