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
class controller_cln_svi extends CONTROLLER_MP {
	var $svi = null;
	
	function __construct()
	{
		$this->svi = $this->CreaModelo('CLN_SVI');
	}
		
	function ConsultaGrilla()
	{
		$this->svi->GetAll();
	}
}
?>