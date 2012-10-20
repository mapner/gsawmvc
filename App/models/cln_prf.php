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
class MODEL_CLN_PRF extends MODEL_MP {	
	public  function GetAll()
	{
		$q = Request::get('q',Request::POST);		
		$cmd = ORM::for_table('CLN_PRF')->where_like('prf_nombre','%$q%');
		echo $this->JSON_ALL($cmd);
	}
}
?>