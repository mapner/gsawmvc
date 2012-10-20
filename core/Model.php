<?php
require_once('functions/log.php');
require_once("functions/idiorm.php");
require_once("functions/paris.php");

class MODEL_MP {
	
	var $page = null;
	var $rows =  null;
	var $table = '';
	
	public function __construct()
	{
		$db_host = config::$db_host ;
		$db_dbname = config::$db_dbname ;
		ORM::configure("firebird:dbname=$db_host:$db_dbname" );	
		ORM::configure('username', config::$db_user);
		ORM::configure('password', config::$db_password);
		ORM::configure('caching', false);
		ORM::configure('logging', true);
		ORM::configure('driver_options', array(PDO::FB_ATTR_DATE_FORMAT => "%d/%m/%Y"));
		
	}
	
	function JSON_PAGE($cmd,$withWhere=false)
	{
		if(!$cmd->existWhere() && $withWhere){
			$result["total"] = 0;
			$result["rows"]=array();
		}
		else{
			try{
				$cmdcnt = clone $cmd;	
				$this->page = (int)Request::get('page',Request::POST);
				$this->rows = (int)Request::get('rows',Request::POST);				
				$result["total"] = $cmdcnt->count();
				$rows = $cmd->limit($this->calc_limit())->offset($this->calc_offset())->find_many();
				writelog( ORM::get_last_query() );
				$array = array();
				foreach($rows as $row)
				{
					$array[] =   $row->as_array();
				}
				$result["rows"]=$array;
			}
			catch(Exception $e)
			{
				$result["total"] = 0;
				$result["rows"]=array();
				$result["errormsj"]= $e->getMessage();
			}
		}
		return json_encode($result) ;
	}
	
	function JSON_ALL($cmd)
	{
		try{
			$rows = $cmd->find_many();
			$array = array();
			foreach($rows as $row)
			{
				$array[] =   $row->as_array();
			}
			$result=$array;			
		}
		catch(Exception $e)
			{			
			$result["errormsj"]= $e->getMessage();
		}
		return json_encode($result) ;
	}
	
	function JSON_ONE($cmd)
	{
		try{
			$row = $cmd->find_one();
			$result = $row->as_array();			
		}
		catch(Exception $e)
			{			
			$result["errormsj"]= $e->getMessage();
		}
		return json_encode($result) ;
	}
	
	function calc_limit()
	{
		$limit = isset($this->rows) ? $this->rows : 5000;
		return $limit;
	}
	
	function calc_offset()
	{
		$page = $this->page ? $this->page : 1;
		$limit = $this->calc_limit();
		$offset = ($page-1)*$limit;
		return $offset;
	}
	
	function getID($gen){
		
		if(!$gen){
			return -1;
		}
		try{
			$conn = $this->DBOpen();
			$sql = 'SELECT GEN_ID( MPG_'.$gen.',1 ) as id FROM RDB$DATABASE';
			$rs = $conn->query($sql);		
			$row = $rs->fetch(PDO::FETCH_ASSOC);			
		}
		catch(PDOException $e){
			echo $e->getMessage();			
		}
		return $row["ID"];
	}
			
	public function DBOpen() {
		
		$db_host = config::$db_host ;
		$db_dbname = config::$db_dbname ;
		
		$conn = new PDO ("firebird:dbname=$db_host:$db_dbname", config::$db_user, config::$db_password);
		$conn->setAttribute(PDO::FB_ATTR_DATE_FORMAT,"%d-%m-%Y");
		
		return $conn;
		
	}
}
?>