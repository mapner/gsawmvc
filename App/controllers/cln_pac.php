<?php

/*

**************************************************************
* (c) 2012 - Mauricio Pistiner
* 
* 
* 
*
************************************************************

*/

class controller_cln_pac extends CONTROLLER_MP {

var $pac = null;

function __construct(){
	
	// crea el modelo Pac	
	$this->pac = $this->CreaModelo('CLN_PAC');
}

	function MuestraGrilla(){
		
		$this->MuestraVista('cln_pac');
				
	}

	function ConsultaGrilla(){				
		
		$this->pac->GetAll();        		
	}

}

?>