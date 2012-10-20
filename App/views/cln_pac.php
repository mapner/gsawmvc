
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 

<link rel="stylesheet" type="text/css" href="<?PHP echo _URL_ ?>js/themes/icon.css">
<link rel="stylesheet" type="text/css" href="<?PHP echo _URL_ ?>js/themes/mp/easyui.css">

<script type="text/javascript" src="<?PHP echo _URL_ ?>js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="<?PHP echo _URL_ ?>js/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?PHP echo _URL_ ?>js/locale/easyui-lang-es.js"></script>		
<script type="text/javascript" src="<?PHP echo _URL_ ?>js/mpjs.js"></script>    


<script type="text/javascript">
var url;

 function doSearch(){    
    $('#g-pac').datagrid('load',{  
      q_apellido: $('#q_apellido').val(),        
      q_afiliado: $('#q_afiliado').val(),    
      q_os_id: $('#cg-os').combogrid('getValue')      
    });  
  }  
 
 function doReset(){  
    $('#f-g').each (function(){ this.reset(); });
    $('#cg-os').combogrid('setValue','');    
    doSearch();
  }
  
  $(function(){  
    $('#cg-os').combogrid({
      panelWidth:450,
      idField:'OS_ID',
      textField:'OS_NOMBRE',
	  url: '<?PHP echo _URL_ ?>cln_eos/ConsultaGrilla',	        
      mode:'remote', 
      columns:[[          
      {field:'OS_ID',title:'Código',hidden: true, width:30} ,        
      {field:'OS_NOMBRE',title:'Obra Social',width:320}          
      ]]
    });    


  $('#g-pac').datagrid({    
    onLoadError:function(){ alert('Error en carga'); }        
  });    

$('#tb1').live('keyup', function(e){
  if (e.keyCode == 13) {
    doSearch();
  }
});

});  
$(function()
{
$('#g-pac').datagrid({
		onLoadSuccess:function(data){ 
		if (data.errormsj) {	alert(data.errormsj) }; 
		},
		onLoadError:function(){ alert('error'); }		
			});
});
</script>

</head>
<body id="body">

  <!-- 
  ************************
  *** GRILLA GENERAL  ***
  ************************ 
-->
<table id="g-pac" title="Afiliados" class="easyui-datagrid" style="width:auto;height:auto;"
url="<?PHP echo _URL_ ?>cln_pac/ConsultaGrilla",			
toolbar="#tb1" pagination="true"
fitColumns="true" singleSelect="true">
<thead>
  <tr>
    <th field="PAC_APELLIDO" width="60"  sortable="true">Apellido</th>
    <th field="PAC_NOMBRE" width="60"  sortable="true">Nombre</th>    
    <th field="OS_NOMBRE" width="60"  sortable="true">Obra Social</th>
    <th field="PAC_IDAFIL" width="30"  sortable="true">Nro.Afiliado</th>    
    <th field="PAC_FECHANAC" width="30"  sortable="true">Fecha Nac.</th>    
    <th field="PAC_ULTPER" width="30"  sortable="true">Ultimo Período</th>    
  </tr>
</thead>
</table>

<div id="tb1" style="padding:5px;height:auto">  
		<div>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="doSearch()"></a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-no" plain="true" onclick="doReset()"></a>
	</div>
  <div>  
  <form id="f-g">
    Apellido, Nombre: 
    <input id="q_apellido" style="width:170px;border:1px solid #ccc">             
    O.S.:                
    <select id="cg-os" style="width:200px;"></select>
    Nro.Afiliado: 
    <input id="q_afiliado" style="width:90px;border:1px solid #ccc">          
	</form>
  </div>    
</div>  

</body>    