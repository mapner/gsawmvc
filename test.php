<?php


require_once('functions/log.php');
require_once("functions/idiorm.php");
require_once("functions/paris.php");

$db_host = '127.0.0.1' ;
$db_dbname = 'm:\ibase\gsaw_bp_unf.fdb' ;
ORM::configure("firebird:dbname=$db_host:$db_dbname" );	
ORM::configure('username', 'SYSDBA');
ORM::configure('password', 'masterkey');
ORM::configure('caching', false);
ORM::configure('logging', true);
ORM::configure('driver_options', array(PDO::FB_ATTR_DATE_FORMAT => "%d-%m-%Y"));


class sys_users extends Model {
 public static $_id_column = 'USR_ID';
}

//$gen = ORM::for_table('RDB$DATABASE')->raw_query('SELECT GEN_ID( MPG_AUI,1 ) as id FROM RDB$DATABASE',array())->find_one(1);

$gen = ORM::for_table('RDB$DATABASE')->raw_query('SELECT GEN_ID( MPG_AUI,1 ) as id FROM RDB$DATABASE',array())->find_one(1);
print_r($gen->ID);


return ;
$user = Model::factory('sys_users')->find_one('ADMIN');
$user->USR_NOMBRE = 'ADMIN --!';
$user->save();
$users = Model::factory('sys_users')->find_many();



foreach($users as $usr){
	echo $usr->USR_NOMBRE."<br>";
}
//echo $users->USR_NOMBRE;
//echo ORM::get_last_query()
?>