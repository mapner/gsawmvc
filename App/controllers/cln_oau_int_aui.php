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
class controller_cln_oau_int_aui extends CONTROLLER_MP {
	var $aui = null;
	
	function __construct()
	{
		$this->aui = $this->CreaModelo('CLN_OAU_INT_AUI');
	}
	
	function ConsultaGrilla()
	{
		$this->aui->GetAll();
	}
	
	function ConsultaForm()
	{
		$this->aui->GetOne();
	}
	
	function Grabar()
	{
		$this->aui->Save();
	}
}
?>