<?php

class controller_test extends MODEL_MP {
	
	function test(){	
		
		$tree = array();
		$rows = ORM::for_table('SYS_TREE')->find_many();
		//echo ORM::get_last_query();
		foreach($rows as $row)
		{
			
			$this->adj_tree($tree, $row->as_array());
		}
		
		echo json_encode($tree["0"]);				
		
	}
	
	function adj_tree(&$tree, $item) {
		
		$i = trim($item["ID"]);
		$p = trim($item["PARENTID"]);		
		unset($item["PARENTID"]);
		
		$tree[$i] = isset($tree[$i]) ? $item + $tree[$i] : $item;
		if($p<>"0"){
		$tree[$p]['children'][] = &$tree[$i];
		}
		else
		{
		$tree[$p][] = &$tree[$i];			
		}
	}
}
?>