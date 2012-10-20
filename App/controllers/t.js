
<html>
<head>
<title>PLUGIN UI</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
<link rel="stylesheet" type="text/css" href="../themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="../themes/icon.css">
<script type="text/javascript" src="../jquery-1.6.min.js"></script>
<script type="text/javascript" src="../jquery.easyui.min.js"></script>
<script type="text/javascript" src="../ui.js"></script>
<script>
$(function()
{
	// *****
	$('#alvo').ui
	(
	{
		componentes: // COMPONENTES INSTACIA O PLUGIN NOVAMENTE
		[
		{
			layout:
			[
			{
				style: 'padding: 10px',
				iconCls: 'icon-edit',
				title: 'Centro',
				region: 'center',
				split: 'true'
				},
			{
				style: 'padding: 10px; width: 200px;',
				iconCls: 'icon-search',
				title: 'Direito',
				region: 'east'
				},
			{
				style: 'padding: 5px; height: 100px;',
				title: 'Topo',
				region: 'north',
				split: 'true',
				componentes:
				[
				{
					tabs:
					[
					{
						title: 'Cadastrar',
						tag:
						{
							style: 'padding: 5px'
						}
						},
					{
						title: 'Listar'
					}
					]
				}
				]
			}
			]
			},
		{
			panel:
			{
				tag:
				{
					style: 'padding: 5px'
					},
				title: 'Meu Painel',
				width: 1024,
				tools:
				[
				{
					iconCls:'icon-edit',
					handler:function()
					{
					alert('new')}
					},'-',{
					iconCls:'icon-save',
					handler:function()
					{
					alert('save')}
				}
				]
			}
			},
		{
			tabs:
			[
			{
				title: 'Cadastrar',
				tag:
				{
					style: 'padding: 5px'
				}
				},
			{
				title: 'Listar'
			}
			]
			},
		{
			panel:
			{
				tag:
				{
					style: 'padding: 5px'
					},
				title: 'Painel com tabs'
			}
			},
		{
			tabs:
			[
			{
				title: 'TAB 1',
				tag:
				{
					style: 'padding: 5px'
				}
				},
			{
				title: 'TAB 2',
				tag:
				{
					style: 'padding: 5px;'
					},
				componentes:
				[
				{
					panel:
					{
						fit: true,
						tag:
						{
							style: 'padding: 5px;'
							},
						title: 'Painel com o Form'
					}
				}
				],
				conteudo:
				[
				[
				{
					html: 'testando'
				}
				]
				]
			}
			]
			},
		{
			panel:
			{
				tag:
				{
					style: 'padding: 5px'
					},
				title: 'Painel com o Form'
			}
			},
		{
			form:
			{
				titulo: 'EVERTON SENA',
				url: 'teste.php',
				load:
				{
					nome: 'nome_teste'
					},
				success:function(data)
				{
					alert(data)
						},
				onSubmit: function()
				{
					alert('vai submeter');
				}
				,
				tag:
				{
					name: 'nemsei'
					},
				eventos:
				{
					keypress: function(event)
					{
						if ( event.which == 13 )
						{
							alert('apertou o ENTER')
							}
					}
				}
			}
		}
		],
		conteudo:
		[
		[
		{
			tag:
			{
				name: 'nome',
				style: 'width: 200px;'
				},
			eventos:
			{
				focus: function()
				{
					$(this).css('color','#0000FF');
				}
				,
				focusout: function()
				{
					$(this).css('color','');
				}
				},
			focus: true,
			titulo: 'Nome',
			tipo: 'validatebox',
			required: true,
			missingMessage: 'Preencha o campo'
			},
		{
			titulo: 'Telefone',
			tipo: 'validatebox',
			required: true,
			missingMessage: 'Preencha o campo'
		}
		],
		[
		{
			titulo: 'Endereço',
			tipo: 'validatebox',
			eventos:
			{
				mouseenter: function()
				{
					$(this).css('width',200);
				}
				,
				mouseleave: function()
				{
					$(this).css('width','');
				}
			}
			},
		{
			titulo: 'Estado:',
			tipo: 'combo',
			conteudo:
			{
				html: // html que ser? atribuido dentro do combo
				'<div style="color:#99BBE8;background:#fafafa;padding:5px;">Selecione uma Estado</div>'+
				'<input type="radio" name="lang" value="01"><span>Rio de Janeiro</span><br/>'+
				'<input type="radio" name="lang" value="02"><span>São Paulo</span><br/>'+
				'<input type="radio" name="lang" value="03"><span>Minas Gerais</span><br/>'+
				'<input type="radio" name="lang" value="04"><span>Bahia</span><br/>'+
				'<input type="radio" name="lang" value="05"><span>Manaus</span>'
				},
			// os valores abaixo sao ja padrao - quando add no documenta??o, RETIRAR.
			config:
			{
				elemento: 'input', // elemento contido no html que servira como value no combo --- esse parametro e o padrao
				elemento_proximo: 'span' // elemento contido no html que servira como text no combo  --- esse parametro e o padrao
			}
			},
		{
			titulo: 'Cidade:',
			tipo: 'combo',
			conteudo:
			{
				html: // html que ser? atribuido dentro do combo
				'<div style="color:#99BBE8;background:#fafafa;padding:5px;">Selecione uma Cidade</div>'+
				'<input type="radio" name="lang" value="01"><span>São João de Meriti</span><br/>'+
				'<input type="radio" name="lang" value="02"><span>Caxias</span><br/>'+
				'<input type="radio" name="lang" value="03"><span>Rio de Janeiro</span><br/>'+
				'<input type="radio" name="lang" value="04"><span>Niteroi</span><br/>'
			}
			},
		{
			html: '<span style="color: #FF0000; padding-left: 15px;">APENAS TESTANDO</span>'
		}
		],
		[ // tipo hidden
		{
			tipo: 'hidden'
		}
		],
		[
		{
			tipo: 'datebox',
			titulo: 'Data:'
			},
		{
			titulo: 'Formato:',
			tipo: 'radio',
			name: 'opcao',
			conteudo:
			[
			{
				tag:
				{
					value: '0',
					checked: true
					},
				text: 'TEXT'
				},
			{
				tag:
				{
					value: '1'
					},
				text: 'XML'
				},
			{
				tag:
				{
					value: '2'
					},
				text: 'JSON'
			}
			]
			},
		{
			tipo: 'combobox',
			titulo: 'Linguagem:',
			load:
			[
			{
				value: '1',
				text: 'PHP'
				},
			{
				value: '2',
				text: 'JAVASCRIPT'
				},
			{
				value: '3',
				text: 'JAVA'
			}
			]
		}
		],
		[
		{
			tipo: 'textarea',
			tag:
			{
				style: 'width: 400px'
				},
			titulo: 'Texto: '
		}
		],
		[
		{
			html: '<hr>'
		}
		],
		[
		{
			titulo: 'Telefone 1',
			tipo: 'validatebox'
			},
		{
			titulo: 'Telefone 2',
			tipo: 'validatebox'
			},
		{
			titulo: 'Telefone 3',
			tipo: 'validatebox'
		}
		],
		[
		{
			iconCls: 'icon-save',
			text: 'Botão',
			tipo: 'button',
			eventos:
			{
				click: function()
				{
					alert($(this));
				}
			}
			},
		{
			iconCls: 'icon-save',
			text: 'Botão',
			tipo: 'button',
			eventos:
			{
				click: function()
				{
					alert($(this));
				}
			}
		}
		],
		[
		{
			tipo: 'datagrid',
			load:
			{
				"total":10,
				"rows":[
				{"cod":"001","nome":"nome 1"},
				{"cod":"002","nome":"nome 2"},
				{"cod":"003","nome":"nome 3"},
				{"cod":"004","nome":"nome 4"},
				{"cod":"005","nome":"nome 5"},
				{"cod":"006","nome":"nome 6"},
				{"cod":"007","nome":"nome 7"},
				{"cod":"008","nome":"nome 8"},
				{"cod":"009","nome":"nome 9"},
			{"cod":"010","nome":"nome 10"}
				]
				},
			title:'GRID 1',
			columns:
			[[
			{title:'CODIGO',field:'cod', width: 100},
		{title:'NOME',field:'nome', width: 100}
			]]
		}
		],
		[
		{
			tipo: 'panel',
			tag:
			{
				style: 'padding: 50px'
				},
			title: 'Meu Painel',
			content: 'TESTANDO',
			tools:
			[
			{
				iconCls:'icon-edit',
				handler:function()
				{
				alert('new')}
				},'-',{
				iconCls:'icon-save',
				handler:function()
				{
				alert('save')}
			}
			]
		}
		]
		]
	}
	);
}
)
	</script>
<style type="text/css">
.Form_Titulo{
	font-size:14px;
	font-weight:bold;
	color:#666;
	padding:5px 0;
	margin-bottom:10px;
	border-bottom:1px solid #ccc;
}
.Form_Item{
	margin-bottom:5px;
}
.Form_Item .Form_Item_Label_Titulo{
	padding-left: 15px;
	font-weight: bold;
	display:inline-block;
	width:100px;
	vertical-align: top;
}
.Form_Item .Form_Item_Label_Button
{
	padding-left: 15px;
	font-weight: bold;
	display:inline-block;
}
</style>
</head>
<body>
<div id="alvo"></div>
</body>
</html>