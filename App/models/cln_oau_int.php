<?php
/*
**************************************************************
* (c) 2012 - Mauricio Pistiner
* 
* CRUD 
* CLN_OAU_INT
*
************************************************************
*/
//require('session.php');
class MODEL_CLN_OAU_INT extends MODEL_MP {
	
	public  function GetAll()
	{
		
		$this->page = Request::get('page',Request::POST);
		$this->rows = Request::get('rows',Request::POST);
		
		$q_oau_id = Request::get('q_oau_id',Request::POST);
		
		$q_apellido = Request::get('q_apellido',Request::POST);
		$q_afiliado = Request::get('q_afiliado',Request::POST);
		$q_os_id = Request::get('q_os_id',Request::POST);
		$q_efe_id = Request::get('q_efe_id',Request::POST);
		
		$cmd = ORM::for_table('cln_oau');
		$cmd = $cmd->join('cln_pac', array('cln_oau.pac_id', '=', 'cln_pac.pac_id'));
		$cmd = $cmd->join('cln_eos', array('cln_oau.os_id', '=', 'cln_eos.os_id'));
		$cmd = $cmd->join('cln_prf', array('cln_oau.prf_id_efector', '=', 'cln_prf.prf_id'));
		
		$cmd = !empty($q_oau_id) ? $cmd->where('oau_id',$q_oau_id) : $cmd;
		if (!$q_oau_id){
			$an = explode(",", $q_apellido);	
			$cmd = isset($an[0]) && !empty($an[0]) ? $cmd->where('cln_pac.pac_apellido',strtoupper($an[0])) : $cmd;
			$cmd = isset($an[1]) && !empty($an[1]) ? $cmd->where('cln_pac.pac_nombre',strtoupper($an[1])) : $cmd;
			
			$cmd = !empty($q_afiliado) ? $cmd->where('pac_idafil',$q_afiliado) : $cmd;
			$cmd = !empty($q_os_id) ? $cmd->where('os_id',$q_os_id) : $cmd;
			$cmd = !empty($q_efe_id) ? $cmd->where('prf_id_efector',$q_efe_id) : $cmd;
		}	
		echo $this->JSON_PAGE($cmd,true);	
		
	}
	
	public  function GetOne()
	{
		
		$oau_id = Request::get('oau_id',Request::GET);
		
		$cmd = ORM::for_table('cln_oau');
		$cmd = $cmd->join('cln_pac', array('cln_oau.pac_id', '=', 'cln_pac.pac_id'));
		$cmd = $cmd->join('cln_eos', array('cln_oau.os_id', '=', 'cln_eos.os_id'));
		$cmd = $cmd->join('cln_prf', array('cln_oau.prf_id_efector', '=', 'cln_prf.prf_id'));
		
		if (!$oau_id)
		{
			echo json_encode(array('msg'=>'Debe indicar OAU_ID'));		
			return false;
		}
		
		$cmd = $cmd->where('oau_id',$oau_id);
		echo $this->JSON_ONE($cmd);
	}
	
	public  function Valid()
	{
		$msg = "";
		/*if($this->r['oau_id']!=5)
		{
			$msg = 'oau_id debe ser 5';
		}
		*/
		if($msg>' ')
		{
			echo json_encode(array('msg'=> $msg));
			return false;
		}
		else
		{
			return true;
		}
	}
}
?>