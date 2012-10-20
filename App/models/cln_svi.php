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
class MODEL_CLN_SVI extends MODEL_MP {
	
	public  function GetAll()
	{
		$cmd = ORM::for_table('CLN_SVI');
		echo $this->JSON_ALL($cmd);
	}
}
?>