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
class MODEL_CLN_ICA extends MODEL_MP {
	
	public  function GetAll()
	{
		$cmd = ORM::for_table('CLN_ICA');
		echo $this->JSON_ALL($cmd);
	}
}
?>