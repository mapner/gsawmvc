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
class controller_cln_eos extends MODEL_MP {
	var $os = null;
	
	function __construct()
	{
		$this->os = $this->CreaModelo('CLN_EOS');
	}
		
	function ConsultaGrilla()
	{
		$this->os->GetAll();
	}
}
?>