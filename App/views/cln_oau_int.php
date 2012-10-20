
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
<link rel="stylesheet" type="text/css" href="<?PHP echo _URL_ ?>js/themes/icon.css">
<link rel="stylesheet" type="text/css" href="<?PHP echo _URL_ ?>js/themes/mp/easyui.css">
<script type="text/javascript" src="<?PHP echo _URL_ ?>js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="<?PHP echo _URL_ ?>js/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?PHP echo _URL_ ?>js/locale/easyui-lang-es.js"></script>		
<script type="text/javascript" src="<?PHP echo _URL_ ?>js/mpjs.js"></script>    
<script type="text/javascript">
var url;
var urlAUI;

function newOAU()
{
	url = '../controllers/cln_oau_int.php?action=A';      
	$('#f-oau').form('clear');  
	$('#w-oau').dialog('open').dialog('setTitle','Nueva Orden');
}

function editOAU()
{
	url = '../controllers/cln_oau_int.php?action=M';      
	$('#f-oau').form('clear');  
	var row = $('#g-oau').datagrid('getSelected');   
	if(row===null)
	{
		alert('Debe seleccionar una fila'); 
		return ;
	}
	;
	$('#f-oau').form('load','<?PHP echo _URL_ ?>cln_oau_int/ConsultaForm/oau_id='+row.OAU_ID);			
	//$('#w-oau').find('input, textarea, button, select ').attr('disabled','false');
	//$('#w-oau').find('input.easyui-datebox').datebox({'disabled':false});
	//$('#w-oau').find('a.easyui-linkbutton ').linkbutton({'disabled':false});
	$('#w-oau').dialog('open').dialog('setTitle','Editar Orden');  
	//$('input[readonly="true"]').attr('readonly','true');	 
	doSearchAUI(row.OAU_ID);
}

function doSearch()
{
	$('#g-oau').datagrid('load',{  
		q_oau_id: $('#q_oau_id').val() ,   
		q_fecha_dde: $('#q_fecha_dde').val() ,   
		q_fecha_hta: $('#q_fecha_hta').val() ,   
		q_apellido: $('#q_apellido').val(),        
		q_afiliado: $('#q_afiliado').val(),    
		q_os_id: $('#cg-os').combogrid('getValue'),
		q_efe_id: $('#cg-prf').combogrid('getValue')
			});
	
	doSearchAUI(-99);
}

function doSearchAUI(oau_id)
{
	$('#g-aui').datagrid('load',{ oau_id: oau_id });
}

function doReset()
{
	$('#f-g').each (function()
	{
		this.reset();
	}
	);
	$('#cg-os').combogrid('setValue','');
	$('#cg-prf').combogrid('setValue','');       
	$('#g-oau').datagrid('loadData', {"total":0,"rows":[]});
	$('#g-aui1').datagrid('loadData', {"total":0,"rows":[]});	
}

function newAUI()
{
	var rowOAU = $('#g-oau').datagrid('getSelected');   
	if(rowOAU===null)
	{
		alert('Debe seleccionar una Orden'); 
		return ;
	}
	
	urlAUI="<?PHP echo _URL_ ?>cln_oau_int_aui/Grabar/aui_id=0/oau_id="+rowOAU.OAU_ID	
	$('#f-aui').form('clear');  
	$('#w-aui').dialog('open').dialog('setTitle','Nueva Auditoría');
}

function editAUI()
{
	var rowOAU = $('#g-oau').datagrid('getSelected');   
	if(rowOAU===null)
	{
		alert('Debe seleccionar una Orden'); 
		return ;
	}
	
	if($('#g-aui').lenght){ 
		var rowAUI = $('#g-aui').datagrid('getSelected'); 
		}  	
	else{	
		var rowAUI = $('#g-aui1').datagrid('getSelected');   
	}
	
	
	urlAUI="<?PHP echo _URL_ ?>cln_oau_int_aui/Grabar/aui_id="+rowAUI.AUI_ID;		
	$('#f-aui').form('clear');  
	$('#f-aui').form('load','<?PHP echo _URL_ ?>cln_oau_int_aui/ConsultaForm/aui_id='+rowAUI.AUI_ID);			
	$('#w-aui').dialog('open').dialog('setTitle','Editar Auditoría');
}

function saveAUI()
{
	$('#f-aui').form('submit',{
		url: urlAUI,
		onSubmit: function()
		{
			return $(this).form('validate');
		}
		,
		success: function(jsresult)
		{
			var result = eval('('+jsresult+')');
			var index = $('#g-aui').datagrid('getRowIndex');  
			if (result.success)
			{
				$('#w-aui').dialog('close');    // close the dialog
				$('#g-aui').datagrid('reload');  // reload the data
				} else {
				$.messager.show({
					title: 'Error',
					msg: result.msg
					});
			}
		}
		});
}

$(function(){  
	
	$('#g-oau').datagrid({    
		onSelect:function(rowIndex,rowData){				
			$('#g-aui1').datagrid('loadData', {"total":0,"rows":[]});		
			$('#g-aui1').datagrid('load',{ oau_id: rowData.OAU_ID });				
			}    			
		});    		
	
	$('#cg-os').combogrid({
		panelWidth:450,
		idField:'OS_ID',
		textField: 'OS_NOMBRE',
		url: '<?PHP echo _URL_ ?>cln_eos/ConsultaGrilla',	  
		mode:'remote', 
		columns:[[          
		{field:'OS_NOMBRE',title:'Obra Social',width:320}          
		]]
		});    
	$('#cg-prf').combogrid({
		panelWidth:450,
		idField:'PRF_ID',
		textField:'PRF_NOMBRE',
		url: '<?PHP echo _URL_ ?>cln_prf/ConsultaGrilla',	  
		mode:'remote', 
		columns:[[          
		{field:'PRF_NOMBRE',title:'Efector',width:320}          
		]]
		});
	$('#g-oau').datagrid({
		onLoadSuccess:function(data)
		{
			if (data.errormsj)
			{
				alert(data.errormsj) };
		}
		,
		onLoadError:function()
		{
			alert('error');
		}
		});
}
);


function formatAction(value,row,index)
{
	var e = '<a href="#" class="easyui-linkbutton" iconCls="icon-add" onclick="editOAU()"><img src="<?PHP echo _URL_ ?>js/themes/icons/pencil.png"/></a> ';
	var d = '<a href="#" class="easyui-linkbutton" iconCls="icon-add" onclick="editOAU()"><img src="<?PHP echo _URL_ ?>js/themes/icons/edit_remove.png"/></a> ';
	return e+d;
	//var e = '<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editOAU()"></a>';
}
</script>
</head>
<body id="body">
<!-- 
************************
*** GRILLA GENERAL  ***
************************ 
-->
<table id="g-oau" title="Ordenes" class="easyui-datagrid" style="width:auto;height:auto" 
url="<?PHP echo _URL_ ?>cln_oau_int/ConsultaGrilla"			
toolbar="#tb1" pagination="true"
fitColumns="true" singleSelect="true">
<thead>
<tr>
<!--<th field="action" width="20" align="center" formatter="formatAction">Acción</th>-->    
<th field="OAU_ID" width="17" align="center" sortable="true" >Nro.Orden</th>
<th field="OAU_FECHAVIG" width="20" align="center" sortable="true">Fecha</th>    
<th field="OAU_APEYNOMPAC" width="60" align="center" sortable="true">Apellido y Nombre</th>    
<th field="OS_NOMBRE" width="60" align="center" sortable="true">Obra Social</th>
<th field="OAU_IDAFIL" width="30" align="center" sortable="true">Nro.Afiliado</th>
<th field="OAU_DIAGNOSTICO" width="80" align="center" sortable="true">Diagnóstico</th>
<th field="PRF_NOMBRE" width="60" align="center" sortable="true">Efector</th>
<!--   <th field="prf_nombre" width="70">Prestador</th> -->
<th field="OAU_FECHA_INTING" width="30" align="center" sortable="true">Ingreso</th>
<th field="OAU_FECHA_INTEGR" width="30" align="center" sortable="true">Egreso</th>    
</tr>
</thead>
</table>

<table id="g-aui1" title="Auditoría" class="easyui-datagrid" style="width:auto;height:auto"   
url="<?PHP echo _URL_ ?>cln_oau_int_aui/ConsultaGrilla"
toolbar="#tb3"  
fitColumns="true" singleSelect="true">  
<thead>  
<tr>  
<th field="AUI_FECHA" width="25">Fecha</th>  
<th field="SVIN_DESCRIP" width="50">Servicio</th>  
<th field="ICAM_DESCRIP" width="50">Auditoría</th>  
<th field="AUI_OBSERVACION" width="50">Observación</th>  
</tr>  
</thead>  
</table>  

<div id="tb3" style="padding:5px;height:auto">  
<div style="margin-bottom:5px">  
<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newAUI()"></a>
<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editAUI()"></a>
<!--<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" ></a>-->
</div>   
</div>
</td>

<div id="tb1" style="padding:5px;height:auto">  
<div style="margin-bottom:5px">  
<!--<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editOAU()"></a>    
<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeOAU()"></a>-->
<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="doSearch()"></a>
<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-no" plain="true" onclick="doReset()"></a>
<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editOAU()"></a>    
<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add"  onclick="newOAU()">Nueva Orden</a>
</div>   
<form id="f-g">
<div div class="fitem" >  
<label>Orden Nº:</label>  
<input id="q_oau_id" style="width:70px;border:1px solid #ccc"> 
<label>Rango Fechas:</label>  
<input id="q_fecha_dde" class="easyui-datebox" style="width:85px">  
<input id="q_fecha_hta" class="easyui-datebox" style="width:85px">           
</div>  
<div div class="fitem" >        
<label>Apellido, Nombre:</label>  
<input id="q_apellido"  style="width:220px;border:1px solid #ccc">             
</div>  
<div div class="fitem" >                  
<label>Obra Social:</label>  
<select id="cg-os" style="width:200px;"></select>    
</div>    
<div div class="fitem" >          
<label>Efector:</label>  
<select id="cg-prf" style="width:200px;"></select>
</form>
</div> 
<div id="w-oau" class="easyui-window" modal="true" closed="true" title="Orden" style="width:auto;height:auto;padding:5px;">
<form id="f-oau" method="POST">  
<table>
<div>  
<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="saveOAU()"></a>  
<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="javascript:$('#w-oau').dialog('close')"></a>         
</div>          
<!-- 
******************
*** ENCABEZADO ***
****************** 
-->
<tr>
<td colspan="2">
<div class="fitem">  
<label>Nro.Orden:</label>  
<input id="OAU_ID" name="OAU_ID"  style="width:50px">  
</div>                  
<div class="fitem">  
<label>Paciente:</label>  
<input name="OAU_APEYNOMPAC" style="width:400px" readonly="true">            
<a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-search" onclick="$('#wsp').dialog('open').dialog('setTitle','Buscar Proveedor');"></a>
<a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-no"></a>                      
</div>  
<div class="fitem">  
<label>Obra Social:</label>  
<input name="OS_NOMBRE"  style="width:200px" readonly="true">  
<label>Nro.Afiliado:</label>  
<input id="OAU_IDAFIL" name="OAU_IDAFIL"  style="width:100px">  
</div>          
<div class="fitem">  
<label>Sexo:</label>  
<input name="OAU_SEXO"  style="width:34px">  
<label>Fecha Nac.:</label>  
<input name="OAU_FECHANAC"  style="width:70px">            
<label>Edad:</label>  
<input name="OAU_EDAD"  style="width:70px">            
</div>          
</div>                  
</td>
</tr>
<tr>
<td>
<div id="t-ppal" class="easyui-tabs" tools="#tab-tools" style="width:650px;height:220px;">         
<!-- 
*********************************
*** TAB  DATOS ORDEN ***
****************** ***************
-->
<div title="Datos Orden" style="padding:20px;" cache="false" >
<div class="fitem">  
<label>Efector:</label>  
<input name="PRF_NOMBRE_EFE" style="width:400px" readonly="true">            
<a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-search" onclick="$('#wsp').dialog('open').dialog('setTitle','Buscar Efector');"></a>
<a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-no"></a>                      
</div>          
<div class="fitem">  
<label>Fecha Orden:</label>  
<input  id="oau_fechaord" name="OAU_FECHAORD"  class="easyui-datebox">  
<label>Fecha Vigencia:</label>  
<input  id="oau_fechavig" name="OAU_FECHAVIG"  class="easyui-datebox" >            
</div>          
<div class="fitem">  
<label>Diagnóstico:</label>  
<input  name="OAU_DIAGNOSTICO"  style="width:400px">            
</div>          
<div class="fitem">  
<label>Fecha Ingreso:</label>  
<input  id="oau_fechaint_ing" name="OAU_FECHA_INTING" class="easyui-datebox">  
<label>Fecha Egreso:</label>  
<input  id="oau_fechaint_egr" name="OAU_FECHA_INTEGR" class="easyui-datebox">  
</div>          
<div class="fitem">  
<label>Auditor:</label>  
<input  name="os_nombre"  style="width:200px">            
</div>          			
</div>
<!-- 
*********************************************************
*** TAB  GRILLA DETALLE AUDITORIA MEDICA ***
*********************************************************
-->
<div title="Auditoría" style="padding:20px;" cache="false" >
<table id="g-aui" class="easyui-datagrid" style="width:610px;height:160px"   
url="<?PHP echo _URL_ ?>cln_oau_int_aui/ConsultaGrilla"
toolbar="#tb2"  
fitColumns="true" singleSelect="true">  
<thead>  
<tr>  
<th field="AUI_FECHA" width="25">Fecha</th>  
<th field="SVIN_DESCRIP" width="50">Servicio</th>  
<th field="ICAM_DESCRIP" width="50">Auditoría</th>  
<th field="AUI_OBSERVACION" width="50">Observación</th>  
</tr>  
</thead>  
</table>  
</div>
<div id="tb2" style="padding:5px;height:auto">  
<div style="margin-bottom:5px">  
<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newAUI()"></a>
<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editAUI()"></a>
<!--<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" ></a>-->
</div>   
</div>
</td>
</tr>
</table>
</div>
</form>
</div>  
<!-- 
******************************************
*** FORMULARIO DETALLE AUI ***
******************************************
-->
<div id="w-aui" class="easyui-window" modal="true" closed="true" title="Auditoría" style=" width:auto;height:auto;padding:5px;"
buttons="#dlg-buttons">  
<form id="f-aui" method="POST">  
<table>      
<tr>       
<div>  
<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="saveAUI()"></a>  
<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="javascript:$('#w-aui').dialog('close')"></a>         
</div>          
</tr>
<tr>     
<div class="fitem">  
<label>Fecha:</label>  
<input id="AUI_FECHA" name="AUI_FECHA"  class="easyui-datebox">  
</div>                  
<div class="fitem">  
<label>Servicio:</label>  
<input id="cc1" name="SVIN_ID" class="easyui-combobox" data-options="valueField:'SVIN_ID', textField: 'SVIN_DESCRIP', 
url:'<?PHP echo _URL_ ?>cln_svi/ConsultaGrilla' , width:200, editable: false" />  
</div>  
<div class="fitem">  
<label>Auditoría:</label>  
<input id="cc2" name="ICAM_ID" class="easyui-combobox" data-options="valueField: 'ICAM_ID', textField: 'ICAM_DESCRIP', 
url:'<?PHP echo _URL_ ?>cln_ica/ConsultaGrilla' , width:350, editable: false" />  
</div>  
<div >  
<div class="fitem">  
<label style=" vertical-align:top;">Observación:</label>      
<textarea name="AUI_OBSERVACION"  rows="3" cols"5" style="width:400px;">            
</div>        	   
</tr>
</table>			
</form>
</div>
</body>    