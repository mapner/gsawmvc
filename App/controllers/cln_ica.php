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
class controller_cln_ica extends CONTROLLER_MP {
	var $ica = null;
	
	function __construct()
	{
		$this->ica = $this->CreaModelo('CLN_ICA');
	}
		
	function ConsultaGrilla()
	{
		$this->ica->GetAll();
	}
}
?>