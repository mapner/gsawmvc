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
class MODEL_CLN_EOS extends MODEL_MP {
	
	public  function GetAll()
	{
		$q = Request::get('q',Request::POST);
		$cmd = ORM::for_table('CLN_EOS')->where_like('os_nombre','%'.$q.'%');
		echo $this->JSON_PAGE($cmd);
	}
}
?>