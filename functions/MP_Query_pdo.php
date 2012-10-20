<?PHP

/*

**************************************************************
* (c) 2012 - Mauricio Pistiner
* Funciones de usao general 
*
************************************************************

*/
require_once('log.php');
require_once('sqlparser.php');

// $r['OAU_ID'] = '16431';
// $r['OAU_IDAFIL'] = '11223344';
// echo Update_Row("M","cln_oau","OAU_ID",$r);

//echo Consulta_Grilla("select * from cln_oau",1,10);
//echo Consulta_Form("select * from cln_oau where oau_id = 9829");

class MP_DBQUERY_PDO {
	
	public static $conn = null;
		
	public static Function DBOpen() {
		
		$db_host = config::$db_host ;
		$db_dbname = config::$db_dbname ;
		
		$conn = new PDO ("firebird:dbname=$db_host:$db_dbname", config::$db_user, config::$db_password);
		$conn->setAttribute(PDO::FB_ATTR_DATE_FORMAT,"%d-%m-%Y");
		
		return $conn;
		
	}
	
	public static function Consulta_Grilla($sql,$page,$rows){
		
		try{
			self::$conn = self::DbOpen();
			
			$sql = trim($sql);
			
			// $posSELECT = 6;
			// $posFROM = strpos($sql, " from ") or strpos($sql, " FROM ") or die("ERROR en Consulta_Grilla SQL incorrecto"); 	
			// $sqlCount = substr($sql, 0,6) . " count(*) as CNT ". substr($sql,$posFROM);	
			
			$sqlCount = SqlParser::ParseString( $sql ) -> getCountQuery('CNT');
			
			$rs = self::$conn->query($sqlCount) or die("ERROR en SQL ".$sql." ".self::$conn->errorInfo());
			$row = $rs->fetch(PDO::FETCH_ASSOC);
			$result["total"] = $row['CNT'];
			
			$page = isset($page) ? $page : 1;
			$rows = isset($rows) ? $rows : 5000;
			
			$offset = ($page-1)*$rows;
			
			$sqlPaging = substr($sql, 0,6) . " first $rows skip $offset " .  substr($sql, 7);	
			
			$rs = self::$conn->query($sqlPaging); //or die("ERROR en SQL ".$sql." ".self::$conn->errorInfo());
			
			$items = $rs->fetchall(PDO::FETCH_ASSOC);	
			
			$result["rows"]=$items;
		}
		catch(Exception $e){    
			$result["total"] = 0;
			$result["rows"]=array();;
			$result["errormsj"]= $e->getMessage();		
			}	
		return json_encode($result);
		
	}
	
	public static function Consulta_Form($sql){
		
		self::$conn = self::DbOpen();
		
		$rs = self::$conn->query($sql);
		$row = $rs->fetch(PDO::FETCH_ASSOC);	
		
		return json_encode($row);
		
	}
	
	public static function Update_Row($action,$table,$keys,$r){
		
		if ($action =='A'){
			
			$sql = $this->make_insert_cmd($table,$r);		
		}
		elseif ($action =='M')
		{
			$sql = $this->make_update_cmd($table,$keys,$r);	
			writelog($sql);						
		}
		elseif ($action =='D')
		{
			$sql = $this->make_delete_cmd($table,$keys,$r);	
		}
		
		self::$conn = DbOpen_pdo();	
		$rs = self::$conn->exec($sql); //or die(writelog((self::$conn->errorInfo(), true)));
		if ($rs){
			writelog(json_encode(array('success'=>true)));
			return json_encode(array('success'=>true));
			} else {
			writelog(print_r(self::$conn->errorInfo(),true));
			return json_encode(array('msg'=>'Some errors occured.'));
		}
		
	}
	
	private function make_insert_cmd($table,$r){
		
		$fls = $this->GetFieldListFB($table);
		$fs="";
		$vl="";
		$us="";
		foreach ($r as $key => $value) {
			if (array_search($key, $fls)!== FALSE) {
				$fs = $fs . $key .',';
				$vl = $vl . "'".chr(36)."r[$key]"."',";		
				$us = $us . $key .'=' . "'".chr(36).'r['.$key.']'."',";		
			}
		}
		$fs = '('.substr($fs,0,strlen($fs)-1).')';
		$vl = '('.substr($vl,0,strlen($vl)-1).')';
		$us = substr($us,0,strlen($us)-1);
		
		$sql = 'insert into '.$table.' '.$fs."'" . trim($value) . "'".$vl;
		return $sql;
		
	}
	
	private function make_update_cmd($table,$keys,$r){
		
		$fls = GetFieldListFB($table);
		
		$us="";
		$ky="";
		foreach ($r as $key => $value) {
			writelog($key);
			if (array_search($key, $fls)!== FALSE) {
				if (strpos($keys, $key)!== FALSE) {
					$ky = $ky . $key ."='" . trim($value) ."',";	
				}
				else
				{
					$us = $us . $key ."='" . trim($value) . "',";	
				}
			}
		}
		$ky = substr($ky,0,strlen($ky)-1);
		$us = substr($us,0,strlen($us)-1);
		
		$sql = 'update '.$table.' set '.$us.' where '.$ky;
		return $sql;
		
	}
	
	private function make_delete_cmd($table,$keys,$r){
		
		$ky="";
		foreach ($r as $key => $value) {
			if (strpos($keys, $key)!== FALSE) {
				$ky = $ky . $key ."='" . trim($value) ."',";	
				}	
		}
		
		$ky = substr($ky,0,strlen($ky)-1);	
		
		$sql = 'delete from '.$table.' where '.$ky;
		
		return $sql;
		
	}
	
	public static function procesar_entrada(){
		$r = array();
		for($i = 0; $i < func_num_args(); $i ++) {				
			
			$r[func_get_arg($i)] = isset($_REQUEST[func_get_arg($i)]) ? $_REQUEST[func_get_arg($i)] : null ;
			
		}
		
		return $r;
	}
	
	
	private function GetFieldListFB($table){
		
		// $sql = <<< EOT
		// SELECT r.RDB\$FIELD_NAME AS field_name,
		//         r.RDB\$DESCRIPTION AS field_description,
		//         r.RDB\$DEFAULT_VALUE AS field_default_value,
		//         r.RDB\$NULL_FLAG AS field_not_null_constraint,
		//         f.RDB\$FIELD_LENGTH AS field_length,
		//         f.RDB\$FIELD_PRECISION AS field_precision,
		//         f.RDB\$FIELD_SCALE AS field_scale,
		//         CASE f.RDB\$FIELD_TYPE
		//           WHEN 261 THEN 'BLOB'
		//           WHEN 14 THEN 'CHAR'
		//           WHEN 40 THEN 'CSTRING'
		//           WHEN 11 THEN 'D_FLOAT'
		//           WHEN 27 THEN 'DOUBLE'
		//           WHEN 10 THEN 'FLOAT'
		//           WHEN 16 THEN 'INT64'
		//           WHEN 8 THEN 'INTEGER'
		//           WHEN 9 THEN 'QUAD'
		//           WHEN 7 THEN 'SMALLINT'
		//           WHEN 12 THEN 'DATE'
		//           WHEN 13 THEN 'TIME'
		//           WHEN 35 THEN 'TIMESTAMP'
		//           WHEN 37 THEN 'VARCHAR'
		//           ELSE 'UNKNOWN'
		//         END AS field_type,
		//         f.RDB\$FIELD_SUB_TYPE AS field_subtype,
		//         coll.RDB\$COLLATION_NAME AS field_collation,
		//         cset.RDB\$CHARACTER_SET_NAME AS field_charset
		//    FROM RDB\$RELATION_FIELDS r
		//    LEFT JOIN RDB\$FIELDS f ON r.RDB\$FIELD_SOURCE = f.RDB\$FIELD_NAME
		//    LEFT JOIN RDB\$COLLATIONS coll ON f.RDB\$COLLATION_ID = coll.RDB\$COLLATION_ID
		//    LEFT JOIN RDB\$CHARACTER_SETS cset ON f.RDB\$CHARACTER_SET_ID = cset.RDB\$CHARACTER_SET_ID
		//   WHERE r.RDB\$RELATION_NAME= '$table'
		// ORDER BY r.RDB\$FIELD_POSITION;
		// EOT;
		
$sql = <<< EOT
SELECT r.RDB\$FIELD_NAME AS field_name
FROM RDB\$RELATION_FIELDS r
LEFT JOIN RDB\$FIELDS f ON r.RDB\$FIELD_SOURCE = f.RDB\$FIELD_NAME
LEFT JOIN RDB\$COLLATIONS coll ON f.RDB\$COLLATION_ID = coll.RDB\$COLLATION_ID
LEFT JOIN RDB\$CHARACTER_SETS cset ON f.RDB\$CHARACTER_SET_ID = cset.RDB\$CHARACTER_SET_ID
WHERE r.RDB\$RELATION_NAME= '$table'
ORDER BY r.RDB\$FIELD_POSITION;
EOT;
		
		self::$conn = DbOpen_pdo();
		$rs = self::$conn->query($sql);
		
		
		$rows = $rs->fetchall(PDO::FETCH_ASSOC); 
		
		foreach ($rows as $key => $value) {
			$fls[] = trim($value['FIELD_NAME']);
		}
		
		writelog(json_encode($fls));
		
		
		self::$conn = null;
		
		return $fls;
		
	}
	
}

?>
