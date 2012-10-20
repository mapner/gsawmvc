<?php


class MODEL_SYS_USERS extends MODEL_MP {
	
	var $errormsg = '';
	
	var $usr_id;
	var $usr_nombre;
	
	
	function Login(){
		
		try{
			$this->errormsg = '';		
			
			$q_usr_id = Request::get('q_usr_id',Request::POST);
			$q_usr_clave = Request::get('q_usr_clave',Request::POST);
			
			$row = ORM::for_table('sys_users')->where('usr_id',$q_usr_id)->where('usr_clave_web',$q_usr_clave)->find_one();
			
			if ($row){		
				$this->usr_id = $row->USR_ID;	   
				$this->usr_nombre = $row->USR_NOMBRE;	   
				$ret = true;				
				}			
		}
		catch(Exception $e){   			
			$this->errormsg = $e->getMessage();		
			$ret = false;
		}
		
		return $ret;		
		
		}		
	
}
?>