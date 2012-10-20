<?php


class MODEL_CLN_PAC extends MODEL_MP {


function GetAll(){

	
	$cmd = ORM::for_table('CLN_PAC');
	
	$q_apellido = Request::get('q_apellido');
	$q_afiliado = Request::get('q_afiliado');		
	$q_os_id = Request::get('q_os_id');
	
	$an = explode(",", $q_apellido);	
	$cmd = isset($an[0]) && !empty($an[0]) ? $cmd->where('pac_apellido',strtoupper($an[0])) : $cmd;
	$cmd = isset($an[1]) && !empty($an[1]) ? $cmd->where('pac_nombre',strtoupper($an[1])) : $cmd;
	
	$cmd = !empty($q_afiliado) ? $cmd->where('pac_idafil',$q_afiliado) : $cmd;
	$cmd = !empty($q_os_id) ? $cmd->where('os_id',$q_os_id) : $cmd;
		
	echo $this->JSON_PAGE($cmd);	
		
}

}

?>