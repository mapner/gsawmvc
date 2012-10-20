<?php
function adj_tree(&$tree, $item) {
	$i = $item['id'];
	$p = $item['parentid'];
	$tree[$i] = isset($tree[$i]) ? $item + $tree[$i] : $item;
	$tree[$p]['_children'][] = &$tree[$i];
}

$tree = array();
$rows = ORM::for_table('TREE')->find_many();
foreach($rows as $row)
{
	//$array[] =   $row->as_array();
	adj_tree($tree, $row);
}

echo json_encode($tree[0]);

?>
