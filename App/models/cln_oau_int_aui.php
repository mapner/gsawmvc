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
class MODEL_CLN_OAU_INT_AUI extends MODEL_MP {
	
	var $table = 'cln_oau_aui';
	
	function GetAll()
	{
		try{
			$oau_id = Request::get('oau_id',Request::POST);
			$cmd = ORM::for_table('CLN_OAU_AUI');
			$cmd->left_outer_join('CLN_SVI', array('cln_oau_aui.svin_id', '=', 'cln_svi.svin_id'));
			$cmd->left_outer_join('CLN_ICA', array('cln_oau_aui.icam_id', '=', 'cln_ica.icam_id'));
			$cmd->where('oau_id',$oau_id);
			echo $this->JSON_ALL($cmd);
		}
		catch(Exception $e)
		{
			echo json_encode(array('msg'=>$e->getMessage()));
		}
	}
	
	function GetOne()
	{
		$aui_id = Request::get('aui_id',Request::GET);	
		$cmd = ORM::for_table('CLN_OAU_AUI')->where('aui_id',$aui_id);
		echo $this->JSON_ONE($cmd);
	}
	
	function Save()
	{
		$aui_id = Request::get('aui_id',Request::GET);		
		$oau_id = Request::get('oau_id',Request::GET);		
		$fac = ORM::for_table($this->table);
		ORM::configure('id_column_overrides', array('cln_oau_aui' => 'AUI_ID'));
		if($aui_id){
			$aui = $fac->where('aui_id',$aui_id)->find_one();
		}
		else{	
			$aui = $fac->create();				
			$aui->AUI_ID = $this->getID('AUI');			
			$aui->OAU_ID = $oau_id;	
		}
		$aui->AUI_FECHA = Request::get('AUI_FECHA',Request::POST);
		$aui->AUI_FECHA =str_replace("/", ".", $aui->AUI_FECHA);
		$aui->AUI_FECHA =str_replace("-", ".", $aui->AUI_FECHA);
		
		$f = $aui->AUI_FECHA;
		
		$aui->SVIN_ID = Request::get('SVIN_ID',Request::POST);
		$aui->ICAM_ID = Request::get('ICAM_ID',Request::POST);
		$aui->AUI_OBSERVACION = Request::get('AUI_OBSERVACION',Request::POST);
		if ($aui->save()){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured.'));
		}		
	}
}
?>