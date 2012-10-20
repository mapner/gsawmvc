<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 	
	
	
	<title><?PHP echo _TITLE_ ?></title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
	
	<link rel="stylesheet" type="text/css" href="js/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="js/themes/mp/easyui.css">
	
	<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="js/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="js/locale/easyui-lang-es.js"></script>		
	
	<script>
	var index = 0;
	$(function(){
		var p = $('body').layout('panel','west').panel({
			onCollapse:function(){
				//alert('collapse');
			}
		});
	});
	$(function(){
		
		//alert('<?PHP echo _URL_ ?>/views/tree_data.json'			);
		
		addTab("Principal","<?PHP echo _URL_CORP_ ?>");		
		$('#tt1').tree({
			//checkbox: true,			
			url: "<?PHP echo _URL_ ?>Main/MenuJson",			
			onClick:function(node){
				$(this).tree('toggle', node.target);
				// if(node.attributes) { alert('you click '+node.text+" "+node.attributes.url); };
				switch(node.attributes.type){
					case 'xtab':	
					addXTab(node.text,node.attributes.id);											
					break;
					case 'tab':	
					addTab(node.text,node.attributes.url,true,true);					
					break;
					case 'window':	
					addWindow(node.text,node.attributes.url);				
					break;
				}
			},
			onContextMenu: function(e, node){
				e.preventDefault();
				$('#tt2').tree('select', node.target);
				$('#mm').menu('show', {
					left: e.pageX,
					top: e.pageY
				});
			}
		});
	});
	
		function addTab(title, url,local,closable){  
		closabe = (typeof closable == 'undefined' ? false : closable);
		url = (typeof local == 'undefined' ? url : '<?PHP echo _URL_ ?>'+url);
		if ($('#tt').tabs('exists', title)){  
			$('#tt').tabs('select', title);  
		} else {  
			var h=$('#zc').height();						
			$('#tt').tabs('add',{  
				title:title,  
				content: '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:'+h+'px;"></iframe>',  
				closable:closable
			});  			
		}  
	}  

	function logout(){
		window.location=("<?PHP echo _URL_ ?>Sys_users/Logout");		
	}

	
	</script>

</head>

<body class="easyui-layout">
	<div region="north" border="false" style="height=auto;background:#FFFFFF;padding:10px">	
		<table width="100%">			
		<tr>
		 <td width="50%">
		 <img src="<?PHP echo _URL_ ?>img/layout1bristol.jpg" style="height:50px"/>  				 
		 </td>
		 <td align="top">
		<div style="text-align: right;"><?PHP echo $_SESSION["usr_nombre"] ?></div><br>
		<div style="text-align: right;"><a href="#" class="easyui-linkbutton"  iconCls="icon-cancel" onClick='logout()'>Salir</a></div>  		
		</td>
		</tr>
		</table>
	</div>
	<div region="west" split="true" title="Opciones" style="width:180px;padding:10px;">
		<div id="tt1" class="easyui-tree" animate="true" dnd="true" animate="true">
		</div>
	</div>
	<!-- <div region="east" split="true" collapsed="true" title="East" style="width:100px;padding:10px;">east region</div> -->
	<!-- <div region="south" border="false" style="height:50px;background:#A9FACD;padding:10px;">south region</div> -->
	<div region="center" id="zc">
		<div id="tt" class="easyui-tabs" tools="#tab-tools" >			
		</div>
	</div>	
</body>
</html>