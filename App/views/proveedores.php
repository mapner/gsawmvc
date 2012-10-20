
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
  
  <script type="text/javascript" src="../jquery-1.8.0.min.js"></script>
  <script type="text/javascript" src="../jquery.easyui.min.js"></script>

  <link rel="stylesheet" type="text/css" href="../themes/default/easyui.css">
  <link rel="stylesheet" type="text/css" href="../themes/icon.css">
  <link rel="stylesheet" type="text/css" href="demo.css">

  <style type="text/css">
  #fm{
    margin:0;
    padding:10px 30px;
  }
  .ftitle{
    font-size:14px;
    font-weight:bold;
    color:#666;
    padding:5px 0;
    margin-bottom:10px;
    border-bottom:1px solid #ccc;
  }
  .fitem{
    margin-bottom:5px;
  }
  .fitem label{
    display:inline-block;
    text-align: right;
    width:90px;
  }
  </style>
  <script type="text/javascript">
  var url;

  function newUser(){  
    url = 'save_user.php'; 
    $('#fm').form('clear');  
    $('#w').dialog('open').dialog('setTitle','Nuevo Proveedor');  
    
  } 

  function editUser(){          
    $('#fm').form('clear');  
    var row = $('#dgxx').datagrid('getSelected');      
    $('#fm').form('load','../php/proveedores.php?action=F&codigo='+row.codigo);
    $('#w').dialog('open').dialog('setTitle','Editar Proveedor');  
    
  } 

  function SelProveedor(){
    var row = $('#tbsp').datagrid('getSelected');  
    if (row){ 
      //$('#txt_codigo').val(row.lastname+" "+row.codigo);  
      $('#txt_nombre').val(row.lastname+" "+row.firstname);  
      $('#wsp').dialog('close');
    }  
  }


  $(function(){    
    $('#dgxx').datagrid({
      onLoadError:function(){ alert('Error en carga'); }        
    });
  });


  </script>

</head>
<body >

<!-- 
************************
*** GRILLA GENERAL  ***
************************ 
-->
<table id="dgxx" title="My Users" class="easyui-datagrid" style="width:auto;height:250px"
url="../php/proveedores.php?action=G" 
toolbar="#toolbar1" pagination="true"
fitColumns="true" singleSelect="true">
<thead>
  <tr>
    <th field="codigo" width="10">Código</th>
    <th field="firstname" width="50">Razón Social</th>
    <th field="lastname" width="50">Nombre</th>
    <th field="phone" width="50">CUIT</th>
    <th field="email" width="50">Email</th>
  </tr>
</thead>
</table>
<div id="toolbar1">
  <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">New User</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Edit User</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeUser()">Remove User</a>
</div>


<!-- 
************************
*** LOOKUP PROVEEDOR ***
************************ 
-->
<div id="wsp" class="easyui-dialog" modal="true" closed="true" title="Buscar Proveedores" iconCls="icon-search" style="width:500px;height:500px;padding:5px;" >  
  <div class="easyui-layout" fit="true">
    <div region="center" border="false" style="padding:10px;background:#fff;border:1px solid #ccc;">
      <table id="tbsp" title="My Users" class="easyui-datagrid" style="width:auto;height:250px" url="../app/php/proveedores.php?action=G" pagination="true" fitColumns="true" singleSelect="true" toolbar="#tbx"  >
        <thead>
          <tr>
            <th field="firstname" width="50">Razón Social</th>
            <th field="lastname" width="50">Nombre</th>
            <th field="phone" width="50">CUIT</th>
            <th field="email" width="50">Email</th>
          </tr>
        </thead>
      </table>
    </div>
    <div id="tbx" style="padding:3px">  
      <span>Item ID:</span>  
      <input id="itemid" style="line-height:26px;border:1px solid #ccc">  
      <span>Product ID:</span>  
      <input id="productid" style="line-height:26px;border:1px solid #ccc">  
      <a href="#" class="easyui-linkbutton" plain="true" onclick="doSearch()">Search</a>  
    </div>  
    <div region="south" border="false" style="text-align:right;padding:5px 0;">
      <a class="easyui-linkbutton" iconCls="icon-ok" href="javascript:void(0)" onclick="SelProveedor()">Ok</a>
      <a class="easyui-linkbutton" iconCls="icon-cancel" href="javascript:void(0)" onclick="javascript:$('#wsp').dialog('close')">Cancel</a>
    </div>
  </div>
</div>

<!-- 
*****************************
*** FORMULARIO PROVEEDOR  ***
***************************** 
-->
<div id="w" class="easyui-window" closed="true" title="Proveedores" iconCls="icon-save" style="width:auto;height:auto;padding:5px;">
  <form id="fm" method="POST">  
    <table>
      <!-- 
      ******************
      *** ENCABEZADO ***
      ****************** 
    -->
    <tr>
      <td colspan="2">
        <div class="fitem">  
          <label>Código:</label>  
          <input id="txt_codigo" name="codigo" class="easyui-validatebox" required="true" style="width:50px">  
        </div>          
        <div class="fitem">  
          <label>Razón Social:</label>  
          <input id="txt_nombre" name="lastname" style="width:200px" readonly="true">  
          <a href="#" class="easyui-linkbutton" plain="true" iconCls="icon-search" onclick="$('#wsp').dialog('open').dialog('setTitle','Buscar Proveedor');"></a>
          <a href="#" class="easyui-linkbutton" plain="true" iconCls="icon-no"></a>            
          <br>  
          <INPUT TYPE=CHECKBOX NAME="maillist">Activo<P>              
          </div>  
        </td>
      </tr>
      <tr>
        <td>
          <div id="tt" class="easyui-tabs" tools="#tab-tools" style="width:650px;height:320px;">
            <div title="Datos Principales" tools="#p-tools" style="padding:20px;">
              <table><tr>                  
                <td>
                  <div id="w" class="easyui-panel" style="width:300px;height:auto;padding:5px;">  
                    <div class="fitem">  
                      <label>Nombre:</label>  
                      <input name="firstname" class="easyui-validatebox" required="true">  
                    </div>  
                    <div class="fitem">  
                      <label>Contacto:</label>  
                      <input name="lastname" class="easyui-validatebox" required="true">  
                    </div>  
                    <div class="fitem">  
                      <label>Domicilio:</label>  
                      <input name="phone">  
                    </div>  
                    <div class="fitem">  
                      <label>Barrio:</label>  
                      <input name="email" class="easyui-validatebox" validType="email">  
                    </div>  
                    <div class="fitem">  
                      <label>Localidad:</label>  
                      <input name="email" class="easyui-validatebox" validType="email">  
                    </div>  
                    <div class="fitem">  
                      <label>Provincia:</label>  
                      <input name="email" class="easyui-validatebox" validType="email">  
                    </div>  
                    <div class="fitem">  
                      <label>País:</label>  
                      <input name="email" class="easyui-validatebox" validType="email">  
                    </div>  
                    <div class="fitem">  
                      <label>Cod.Postal:</label>  
                      <input name="email" class="easyui-validatebox" validType="email">  
                    </div>  
                  </td>
                  <td>

                    <div id="p2" class="easyui-panel" style="width:300px;height:auto;padding:5px;">  

                     <div class="fitem">  
                      <label>Teléfono1:</label>  
                      <input name="firstname" class="easyui-validatebox" required="true">  
                    </div>  
                    <div class="fitem">  
                      <label>Teléfono2:</label>  
                      <input name="lastname" class="easyui-validatebox" required="true">  
                    </div>  
                    <div class="fitem">  
                      <label>Phone:</label>  
                      <input name="phone">  
                    </div>  
                    <div class="fitem">  
                      <label>FAX:</label>  
                      <input name="email" class="easyui-validatebox" validType="email">  
                    </div>  
                    <div class="fitem">  
                      <label>Celular:</label>  
                      <input name="email" class="easyui-validatebox" validType="email">  
                    </div>  
                    <div class="fitem">  
                      <label>Email</label>  
                      <input name="email" class="easyui-validatebox" validType="email">  
                    </div>  
                    <div class="fitem">  
                      <label>WEB</label>  
                      <input name="email" class="easyui-validatebox" validType="email">  
                    </div>  
                    <div class="fitem">  
                      <label>Horario</label>  
                      <input name="email" class="easyui-validatebox" validType="email">  
                    </div>  
                  </div>  
                </td>
              </tr>
            </table>
          </div>
          <div title="Datos Comerciales" closable="true" style="padding:20px;" cache="false" >
            <div class="fitem">  
              <label>Rubro:</label>  
              <input name="firstname" class="easyui-validatebox" required="true">  
            </div>  
            <div class="fitem">  
              <label>Cond.Pago:</label>  
              <input name="lastname" class="easyui-validatebox" required="true">  
            </div>  
            <div class="fitem">  
              <label>Cheques a la Orden:</label>  
              <input name="lastname" class="easyui-validatebox" required="true">  
            </div>  
          </div>

          <div title="Datos Fiscales" closable="true" style="padding:20px;" cache="false" >
            <div class="fitem">  
              <label>CUIT:</label>  
              <input name="firstname" class="easyui-validatebox" required="true">  
            </div>  
            <div class="fitem">  
              <label>Categoría IVA:</label>  
              <input name="lastname" class="easyui-validatebox" required="true">  
            </div>  
            <div class="fitem">  
              <label>Cat.Ganancias:</label>  
              <input name="lastname" class="easyui-validatebox" required="true">  
            </div>                                     
            <div class="fitem">  
              <label>Cat.II.BB.:</label>  
              <input name="lastname" class="easyui-validatebox" required="true">  
            </div>                                     
            <div class="fitem">  
              <label>C.P:S.M.:</label>  
              <input name="lastname" class="easyui-validatebox" required="true">  
            </div>                
            <div class="fitem">  
              <label>Limpeiza/Seguridad:</label>  
              <input name="lastname" class="easyui-validatebox" required="true">  
            </div>                                     
          </div>                    

          <div title="Datos Contables" closable="true" style="padding:20px;" cache="false" >
            <div class="fitem">  
              <label>Cuenta:</label>  
              <input name="firstname" class="easyui-validatebox" required="true">  
            </div>  
            <div class="fitem">  
              <label>Contracuenta:</label>  
              <input name="lastname" class="easyui-validatebox" required="true">  
            </div>  
          </div>

          <div title="Contactos" closable="true" style="padding:20px;" cache="false" >

            <table id="dg" class="easyui-datagrid" style="width:550px;height:150px"  
            url="../php/proveedores.php?action=G"  
            toolbar="#toolbar"  
            rownumbers="true" fitColumns="true" singleSelect="true">  
            <thead>  
              <tr>  
                <th field="firstname" width="50">First Name</th>  
                <th field="lastname" width="50">Last Name</th>  
                <th field="phone" width="50">Phone</th>  
                <th field="email" width="50">Email</th>  
              </tr>  
            </thead>  
          </table>  
        </div>

      </div>
    </td>
  </tr>
  <td>
    <div id="dlg-buttons">  
      <a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveUser()">Save</a>  
      <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancel</a> </td>
    </div>  
  </table>
</div>
</form>
</div>  
</body>    