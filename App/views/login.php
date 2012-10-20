<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 

	<link rel="stylesheet" type="text/css" href="<?PHP echo _URL_ ?>js/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="<?PHP echo _URL_ ?>js/themes/mp/easyui.css">
	
	<script type="text/javascript" src="<?PHP echo _URL_ ?>js/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="<?PHP echo _URL_ ?>js/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="<?PHP echo _URL_ ?>js/locale/easyui-lang-es.js"></script>		
	<script type="text/javascript" src="<?PHP echo _URL_ ?>js/mpjs.js"></script>    

<style type="text/css">
BODY{
    font-family: arial;
}
</style>

<style type="text/css">
#fm_login{
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
  font-family:Arial;
  display:inline-block;
  text-align: right;
  width:90px;
}

body {


  background: #1e5799; /* Old browsers */

  background-image: url(<?PHP echo _URL_ ?>img/estetoscopio-grande.jpg);
  background-position: center;
  background-repeat: no-repeat;
  background-attachment: fixed; 

}

</style>
<script type="text/javascript">

function loginSubmit(){  
  $('#fm_login').form('submit',{
    url: "<?PHP echo _URL_ ?>Sys_users/Login",
    onSubmit: function(){
      return $(this).form('validate');
    },
    success: function(result){	
      var result = eval('('+result+')');        
      if (result.success){                   
		window.location = "<?PHP echo _URL_ ?>";              		
      } else {
        $.messager.alert('No se pudo ingresar',result.msg,'info');
      }               
    }
  });
}

$(function(){

$('#fm_login').window('center');
}
);

</script>
</head>
<body>
<!-- 
*****************************
*** FORMULARIO LOGIN  ***
***************************** 
-->
<div id="#fm_login" class="easyui-window" title="Ingreso" iconCls="icon-login"  collapsible="false" minimizable="false" maximizable="false" closable="false" shadow="true" style="width:350px;<?PHP echo preg_match('/Firefox/',$_SERVER['HTTP_USER_AGENT']) ? 'top:350%;': '' ; ?>height:auto;padding:5px;background:#D8D8D8">
    
  <form id="fm_login" method="POST"  ACTION="Sys_users/Login">      
    <br>
    <div class="fitem">  
      <label>Usuario:</label>  
      <input name="q_usr_id" >  
    </div>          
    <div class="fitem">  
      <label>Clave:</label>  
      <input name="q_usr_clave" TYPE=PASSWORD>  
    </div>          
    <div id="dlg-buttons"  align="center">  
      <br>	  
      <a href="#" class="easyui-linkbutton" iconCls="icon-ok" style="text-align:center;" onclick="loginSubmit()">Ingresar</a>        
    </div>     
  </form>
</div>  
</body>    