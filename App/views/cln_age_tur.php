
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

function VerDia(rowIndex){  
  $('#g-da').datagrid('loadData', {"total":0,"rows":[]});
  $('#g-da').datagrid({ url: "test_da.php" } );        
  $('#g-da').datagrid('load',{ fila: rowIndex });            
  $('#g-da').datagrid('load',{ fila: rowIndex });            
}

$('#g-pac').datagrid({    
    //onLoadError:function(){ alert('Error en carga'); }        
  });    

$(function(){  
  $('#g-dd').datagrid({    
    onSelect:function(rowIndex,rowData){

      $('#g-da').datagrid('loadData', {"total":0,"rows":[]});
      $('#g-da').datagrid({ url: "test_da.php" } );        
      $('#g-da').datagrid('load',{ fila: rowIndex });            
      $('#g-da').datagrid('load',{ fila: rowIndex });            
    }    

  });    


  $('#g-dd').datagrid('getPanel').panel('panel').attr('tabindex',1).bind('keydown',function(e){    
    switch(e.keyCode){
    case 38:  // up
    var selected = $('#g-dd').datagrid('getSelected');
    if (selected){
      var index = $('#g-dd').datagrid('getRowIndex', selected);
      $('#g-dd').datagrid('selectRow', index-1);
    } else {
      $('#g-dd').datagrid('selectRow', 0);
    }
    break;
    case 40:  // down
    var selected = $('#g-dd').datagrid('getSelected');
    if (selected){
      var index = $('#g-dd').datagrid('getRowIndex', selected);
      $('#g-dd').datagrid('selectRow', index+1);
    } else {
      $('#g-dd').datagrid('selectRow', 0);
    }
    break;
  }
});


});    


</script>

</head>
<body class="easyui-layout">
  <div region="north" border="false" style="height:85px;background:#A4A4A4;padding:10px">  
  </div>
  <div region="west" title="Días disponibles" style="width:530px;padding:10px;">

    <table id="g-dd" class="easyui-datagrid" style="width:500px;height:300px;"
    url="diasdisponibles_data.json" 
    pagination="true"
    fitColumns="true" singleSelect="true">
    <thead>
      <tr>
        <th field="AGE_FECHA" width="30" sortable="true">Fecha</th>
        <th field="AGE_DIA" width="20" sortable="true">Día</th>    
        <th field="ITEM" width="120" sortable="true">Profesional</th>
        <th field="CEA_ID" width="20" sortable="true">Centro</th>    
        <th field="AGE_PORCOCU" width="30" sortable="true">% Ocu.</th>            
        <!--   <th field="action" width="20" align="center" formatter="formatAction">...</th> -->

        <script type="text/javascript">
        function formatAction(value,row,index){
          var s = '<a href="#" onclick="VerDia('+index+')">Ver</a> ';       
          return s;                      
        }
        </script>
      </tr>
    </thead>
  </table>

</div>

<div region="center" style="width:0px;"></div>   

<div region="east" id="zc"  title="Agenda" style="width:1150px;padding:10px;">

  <table id="g-da" class="easyui-datagrid" style="width:800px;height:300px;"
  url="test_da.php" 
  pagination="true"
  fitColumns="true" singleSelect="true">
  <thead>
    <tr>
      <th field="AGE_HORA" width="7" sortable="true">Hora</th>
      <th field="AGE_TIPORESREVA" width="5" sortable="true">...</th>    
      <th field="AGE_APEYNOMPAC" width="40" sortable="true">Paciente</th>
      <th field="AGE_IDAFIL" width="20" sortable="true">Nº Afiliado</th>    
      <th field="AGE_TELEFONO" width="30" sortable="true">Telefono</th>            
      <th field="AGE_MOTIVO" width="30" sortable="true">Motivo</th>            
    </tr>
  </thead>
</table>

</div>  
</body>
</html>

