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
class controller_cln_prf extends CONTROLLER_MP {
	var $prf = null;
	
	function __construct()
	{
		$this->prf = $this->CreaModelo('CLN_PRF');
	}
	
	function ConsultaGrilla()
	{
		$this->prf->GetAll();
	}
}
?>