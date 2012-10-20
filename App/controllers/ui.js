/*
* *******************************************************************************************************************************
* Plugin ui - Vers?o 1.0.1
* Desenvolvido por Everton Sena - 18/07/2011
* -------------------------------------------------------------------------------------------------------------------------------
* Monta uma estrutura completa no DOM com os componentes do EASY-UI(http://jeasyui.com/)
	* -------------------------------------------------------------------------------------------------------------------------------
* *******************************************************************************************************************************
* @param objeto aDados      ->
*                             @param array componentes ->
*                             [
*                                 @param objeto panel -> Caso informado ser? criado um elemento panel no elemento do DOM informado,
*                                                        o elemento panel ser? o novo elemento pai.
*                                                        Todos os atributos vinculados ao elementos poder? ser inseridos conforme a
*                                                        documenta??o do EASY-UI(http://jeasyui.com/documentation/panel.php)
	*                             ]
*                             @param objeto tag     -> atributos adicionados ao elemento.
*                                                      NOTA: talvez os atributos n?o sejam acionados
*                                                      devido o elemento ter sido startando atraves de um
*                                                      componente.
*                             @param objeto eventos -> eventos adicionados ao elemento.
*                                                      NOTA: talvez os eventos n?o sejam acionados
*                                                      devido o elemento ter sido startando atraves de um
*                                                      componente.
*/
/*
* UPGRADE
* ***Os parametros novos adicionados através do plugin deve ser adicionados nas CONSTANTES de cada componente***
*/
(function($){
	$.fn.ui = function(aDados)
	{
		return this.each
		(
		function(){
			
			// Start na cria??o dos componentes
			var oElemento = aFuncoes.componente.start($(this),aDados);
			// conteudo - campos
			if(aDados.conteudo)
			{
				$.each
				(
				aDados.conteudo,
				function()
				{
					if(this)
					{
						oElemento.append('<div class="'+$.fn.ui.config.classes.item_div+'"></div>');                                
						//
						$.each
						(
						this,
						function(iIndice)
						{
							// titulo
							if(this.titulo) // se existir...
							{
								oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').append('<label class="'+$.fn.ui.config.classes.item_label_titulo+'">'+this.titulo+'</label>');    
								/*
								* MUDOU
								* * adicionado um parametros para inserir um css no titulo
								*/
								if(this.titulo_css)
									oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last label:last').css(this.titulo_css);
							}
							//
							// caso exista html puro
							if(this.html)
								oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').append(this.html);                                        
							//
							if(this.tipo) // caso exista o tipo...
							{
								/*
								* e possivel tamb?m informa o tipo e passar os parametros, 
								* nesse caso somente aceita um elemento por vez
								*/
								if(aFuncoes.conteudo[this.tipo]) // somente se existir
								aFuncoes.conteudo[this.tipo](oElemento,aDados,this) // starta o elemento do tipo informado
								}else{ // n?o possui tipo, entao starta a cria??o do elemento(s)
									$.each
								(
								this,
								function(sIndice)
								{
									if(aFuncoes.conteudo[sIndice])
									{
										oElemento = aFuncoes.conteudo[sIndice](oElemento,aDados,this)
										}
								}
								)                                            
							}
						}
						)
						}
				}
				)
					/*
				* Caso o componente form tenha sindo acionado entao verifica se vai carregar os dados no form.
				* --- Resolver caso o form n?o seja o oElemento selecionado ---
				*/
				// preenche o formulario
				if(aDados.componentes) // se existe componentes...
				{
					$.each
					(
					aDados.componentes,
					function()
					{
						$.map
						(
						this,
						function(aValor,sIndice)
							{ 
							if(sIndice == 'form')
							{
								// preenche o form
								if(aValor.load)
									oElemento.form('load',aValor.load);                                            
							}
						}
						)
						}
					)
					}
			}
			return oElemento;
			});
		};
	})(jQuery);
/* *************************
* FUNCOES
* *************************/
var aFuncoes =
{
	/*
	* Conjuntos de componentes a qual podem ser repetidos dentro ou fora do conteudo.
	*/
	componente:
	{
		start: function(oElemento,aDados)
		{
			//
			if(aDados.componentes)
			{
				$.each
				(
				aDados.componentes,
				function(iIndice)
				{
					/*
					* DEVIDO O $.map() NAO FUNCIONA CORRETAMENTE NA VERS?O 1.4.4 DO Jquery
					*/
					$.each
					(
					this,
					function(iIndiceTemp)
					{
						oElemento = aFuncoes.componente[iIndiceTemp](oElemento,aDados,iIndice);
					}
					)
					}
				);
			}
			return oElemento;
			},
		div: function(oElemento,aDados,iIndice)
		{
			if(aDados.componentes[iIndice]['div'])
			{
				aFuncoes.trata(oElemento,aDados,'<div></div>','div',aDados.componentes[iIndice]['div'],true);
				return oElemento.find('div:last').ui(aDados.componentes[iIndice]['div']);
			}
			},
		/*
		* MUDOU
		* * novo componente
		*/
		fieldset: function(oElemento,aDados,iIndice)
		{
			if(aDados.componentes[iIndice]['fieldset'])
			{
				var sLegend = aDados.componentes[iIndice]['fieldset']['legend'] ? '<legend>'+aDados.componentes[iIndice]['fieldset']['legend']+'</legend>' : '';
				aFuncoes.trata(oElemento,aDados,'<fieldset>'+sLegend+'</fieldset>','fieldset',aDados.componentes[iIndice]['fieldset'],true);
				return oElemento.find('fieldset:last').ui(aDados.componentes[iIndice]['fieldset']);
			}
			},        
		panel: function(oElemento,aDados,iIndice)
		{
			if(aDados.componentes[iIndice]['panel'])
			{
				aFuncoes.trata(oElemento,aDados,'<div></div>','div',aDados.componentes[iIndice]['panel'],true);
				// starta o componente
				return oElemento.find('div:last').panel(aDados.componentes[iIndice]['panel']).ui(aDados.componentes[iIndice]['panel']);
			}
			},
		window: function(oElemento,aDados,iIndice)
		{
			if(aDados.componentes[iIndice]['window'])
			{
				aFuncoes.trata(oElemento,aDados,'<div></div>','div',aDados.componentes[iIndice]['window'],true);
				// starta o componente
				return oElemento.find('div:last').window(aDados.componentes[iIndice]['window']).ui(aDados.componentes[iIndice]['window']);
			}
			},        
		tabs: function(oElemento,aDados,iIndice)
		{
			// componente tabs
			if(aDados.componentes[iIndice]['tabs'])
			{
				$.each
				(
				aDados.componentes[iIndice]['tabs'],
				function()
				{
					aFuncoes.trata(oElemento,aDados,'<div></div>','div',this,true);
					// o title da aba tem que ser informado
					oElemento.find('div:last').attr('title',this.title);
					/*
					* MUDOU
					* Adicionado ao opções do panel tab
					*/
					if(this.closable)
						oElemento.find('div:last').attr('closable',this.closable);
					if(this.selected)
						oElemento.find('div:last').attr('selected',this.selected);
					if(this.iconCls)
						oElemento.find('div:last').attr('iconCls',this.iconCls);
					
				}
				//
				);
				// starta o componente
				oElemento.tabs();
				// recupera os panels
				var aPanels = oElemento.tabs('tabs');
				//
				$.each
				(
				aDados.componentes[iIndice]['tabs'],
				function(iIndice)
				{
					/*
					* a partir dos panels starta o componente panel e instacia novamente o plugin
					*/
					$(aPanels[iIndice]).panel(this).ui(this);
				}
				)
					//
				return oElemento.tabs('getTab',aDados.componentes[iIndice]['tabs'][0]['title']);
			}
			},
		/* PROBLEMAS
		* # componente nao esta se ajustando corretamente ao elemento alvo
		*/
		accordion: function(oElemento,aDados,iIndice)
		{
			// componente tabs
			if(aDados.componentes[iIndice]['accordion'])
			{
				$.each
				(
				aDados.componentes[iIndice]['accordion'],
				function()
				{
					aFuncoes.trata(oElemento,aDados,'<div></div>','div',this,true);
				}
				//
				);
				// starta o componente
				oElemento.accordion();
				/*
				* E setado um setTimeout() para que o accordion se ajuste no elemento alvo
				* -- ajustar o tempo! Para script longo pode dar problema. --
				* -- não está funcionando o metodo 'select' do componente 'accordion' com essa estrutura usada. O problema está ao instanciar o panel e jogar no plugin novamente
				*/
				setTimeout(function(){oElemento.accordion({fit: true})},500);
				// recupera os panels
				var aPanels = oElemento.accordion('panels');
				//
				$.each
				(
				aDados.componentes[iIndice]['accordion'],
				function(iIndice2)
				{
					$(aPanels[iIndice2]).panel(this).ui(this);
				}
				)
					//
				return oElemento.accordion('getPanel',aDados.componentes[iIndice]['accordion'][0]['title']);
			}
			},        
		layout: function(oElemento,aDados,iIndice)
		{
			// componente layout
			if(aDados.componentes[iIndice]['layout'])
			{
				$.each
				(
				aDados.componentes[iIndice]['layout'],
				function()
				{
					aFuncoes.trata(oElemento,aDados,'<div></div>','div',this,true);
					aFuncoes.attr(oElemento.find('div:last'),this);
				}
				//
				);
				/****
				* o layout tem que conter um width e o height
				* --- mudar para que somente add as propriedades css se o elemento nao contenha width / height ---
				*****/
				oElemento.css({width: '100%', height: '100%'}).layout();
				// instacia os outros elementos para o plugin
				$.each
				(
				aDados.componentes[iIndice]['layout'],
				function(iIndice)
				{
					oElemento.layout('panel',this.region).panel(this).ui(this);
				}
				)
					return oElemento.layout('panel',aDados.componentes[iIndice]['layout'][0]['region']);
			}
			},
		form: function(oElemento,aDados,iIndice)
		{
			if(aDados.componentes[iIndice]['form'])
			{
				aFuncoes.trata(oElemento,aDados,'<form></form>','form',aDados.componentes[iIndice]['form'],true);
				//
				if(aDados.componentes[iIndice]['form']['titulo']) // caso exista...
				oElemento.find('form:last').append('<div class="'+$.fn.ui.config.classes.titulo+'">'+aDados.componentes[iIndice]['form']['titulo']+'</div>')
					//
				// starta o componente
				return oElemento.find('form:last').form(aDados.componentes[iIndice]['form']).ui(aDados.componentes[iIndice]['form']);
			}
		}
		},
	/* 
	* Conjunto de funcoes para elementos que entrar?o dentro da posicao conteudo
	*/
	conteudo:
	{
		datebox: function(oElemento,aDados,aParam)// data padrao brasileira
		{
			aFuncoes.trata(oElemento,aDados,'<input type="text">','input:text',aParam);
			oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('input:text:last').datebox(aParam);
			if(this.focus)
				oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('input:text:last').focus();            
			//
			return oElemento;
			},
		validatebox: function(oElemento,aDados,aParam)
		{
			/* MUDOU
			* componente validatebox da suporte para input de diversos tipos... o padrão e text, variaçoes poderá ser: password
			*/
			aParam = $.extend(true,{ type: 'text' },aParam);
			aFuncoes.trata(oElemento,aDados,'<input type="'+aParam.type+'">','input:'+aParam.type,aParam);
			oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('input:'+aParam.type+':last').validatebox(aParam);
			if(aParam.focus)
				oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('input:'+aParam.type+':last').focus();            
			//
			return oElemento;
			},
		/*
		* --- focus no campo não esta funcionando ---
		*/
		numberbox: function(oElemento,aDados,aParam)
		{
			aFuncoes.trata(oElemento,aDados,'<input type="text">','input:text',aParam);
			oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('input:text:last').numberbox(aParam);
			if(aParam.focus)
				oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('input:text:last').focus();
			//
			return oElemento;
			},
		/* MUDOU
		* NOVO COMPONENTE
		*
		*/
		numberspinner: function(oElemento,aDados,aParam)
		{
			aFuncoes.trata(oElemento,aDados,'<input type="text">','input',aParam);
			oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('input:last').numberspinner(aParam);
			if(aParam.focus)
				oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('input:last').focus();
			//
			return oElemento;
			},       
		/* MUDOU
		* NOVO COMPONENTE
		*
		*/
		checkbox: function(oElemento,aDados,aParam)
		{
			aFuncoes.trata(oElemento,aDados,'<input type="checkbox"></input>','input',aParam);
			if(this.focus)
				oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('input:last').focus();
			//
			return oElemento;
			}, 
		/* MUDOU
		* NOVO COMPONENTE
		*
		*/        
		file: function(oElemento,aDados,aParam)
		{
			aFuncoes.trata(oElemento,aDados,'<input type="file">','input',aParam);
			if(this.focus)
				oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('input:last').focus();
			//
			return oElemento;
			},        
		textarea: function(oElemento,aDados,aParam)
		{
			aFuncoes.trata(oElemento,aDados,'<textarea></textarea>','textarea',aParam);
			if(this.focus)
				oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('textarea:last').focus();
			//
			return oElemento;
			},
		hidden: function(oElemento,aDados,aParam)
		{
			aFuncoes.trata(oElemento,aDados,'<input type="hidden">','input:hidden',aParam);
			//
			return oElemento;
			},
		radio: function(oElemento,aDados,aParam)
		{
			var oThis = aParam;
			if(aParam.conteudo && oThis.name)
			{
				$.each
				(
				aParam.conteudo,
				function()
				{
					aFuncoes.trata(oElemento,aDados,'<input type="radio" name="'+oThis.name+'"><span>'+this.text+'</span>','input:radio',this);
				}
				)
					aFuncoes.eventos(oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('input:radio'), oThis.eventos);
			}
			//
			return oElemento;
			},
		combo: function(oElemento,aDados,aParam)
		{
			aFuncoes.trata(oElemento,aDados,'<select></select>','select',aParam);
			oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('select:last').combo(aParam);
			// parametros de sele??o do elemento
			var aConteudo =
			$.extend
			(
			{
				elemento: 'input',
				elemento_proximo: 'span'
				},
			aParam.config
			);
			//
			var oElementoSelect = oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('select:last');
			$('<div>'+aParam.conteudo.html+'</div>').
			appendTo(oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('select:last').combo('panel')).
			find(aConteudo.elemento).bind
			(
			'click',
			function()
			{
				oElementoSelect.combo
				(
				'setValue',
				$(this).val()
					).combo
				(
				'setText',
				$(this).next(aConteudo.elemento_proximo).text()
					).combo('hidePanel');
			}
			);
			//
			return oElemento;
			},
		combobox: function(oElemento,aDados,aParam)
		{
			aFuncoes.trata(oElemento,aDados,'<select></select>','select',aParam);
			oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('select:last').combobox(aParam)
				// carrega os dados localmente
			if(aParam.load)
				oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('select:last').combobox('loadData',aParam.load);
			//
			return oElemento;
			},
		datagrid: function(oElemento,aDados,aParam)
		{
			/*
			* /Busca no resultado do grid
			*/
			//
			aFuncoes.trata(oElemento,aDados,'<table></table>','table',aParam);
			//
			var oElementoGrid = oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('table:last').datagrid(aParam);
			// carrega os dados localmente
			if(aParam.load)
				oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('table:last').datagrid('loadData',aParam.load);
			// pesquisar no grid
			if($(oElementoGrid).datagrid('options').searchBox)
				aFuncoes.controller.Grid.Dados.Pesquisar(oElementoGrid);
			//
			return oElemento;
			},
		/*
		* MUDOU
		* NOVO COMPONENTE
		*/
		tree: function(oElemento,aDados,aParam)
		{
			//
			aFuncoes.trata(oElemento,aDados,'<ul></ul>','ul',aParam);
			//
			oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('ul:last').tree(aParam);
			// carrega os dados localmente
			if(aParam.load)
				oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('table:last').tree('loadData',aParam.load);
			//
			return oElemento;
			},        
		combogrid: function(oElemento,aDados,aParam)
		{
			aFuncoes.trata(oElemento,aDados,'<select></select>','select',aParam);
			oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('select:last').combogrid(aParam);
			// carrega os dados localmente
			if(aParam.load)
				oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('select:last').combogrid('grid').datagrid('loadData',aParam.load);
			//
			return oElemento;
			},        
		button: function(oElemento,aDados,aParam)
		{
			aFuncoes.trata(oElemento,aDados,'<label class="'+$.fn.ui.config.classes.item_label_button+'"><a></a></label>','a',aParam);
			oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('a:last').linkbutton(aParam);
			//
			return oElemento;
			},
		panel: function(oElemento,aDados,aParam)
		{
			aFuncoes.trata(oElemento,aDados,'<div></div>','div',aParam);
			oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find('div:last').panel(aParam)
				//
			return oElemento;
		}
		
		
		},
	/* Injenta css no elemento
	* @param objeto oElemento -> elemento do DOM
	* @param array aCss       -> array com css
	*/
	css: function(oElemento,aCss)
	{
		if(aCss)
			return oElemento.css(aCss);
		},    
	/* Injenta as tag no elemento
	* @param objeto oElemento -> elemento do DOM
	* @param array aAttr      -> array com tags
	*/
	attr: function(oElemento,aAttr)
	{
		/*
		* MUDOU
		* fun??o agora remove valores que s?o objetos ou array
		* tamb?m esta fazendo o tratamento, para que tags que recebe valores em booleano seja automaticamente convertido para string
		* -- verificar se poder? futuramente dar problema a conver??o para string de valores booleanos -- 
		*/
		if(aAttr)
		{
			var aAttrTemp = {};
			// remove valores que s?o objetos ou array
			$.each
			(
			aAttr,
			function(iIndice)
				{ 
				if(!$.isArray(this) && this.constructor != Object)
				{
					aAttrTemp[iIndice] = aAttr[iIndice];
					if(aAttrTemp[iIndice] === true)
						aAttrTemp[iIndice] = 'true'
					if(aAttrTemp[iIndice] === false)
						aAttrTemp[iIndice] = 'false'                        
				}
			}
			);
			//
			return oElemento.attr(aAttrTemp);            
		}
		},
	/* Vincula eventos ao elemento
	* @param objeto oElemento -> elemento do DOM
	* @param array aAttr      -> array com os eventos
	*/
	eventos: function(oElemento,aEventos)
	{
		if(aEventos)
			return oElemento.bind(aEventos);
		},
	/* Tratamento nos elementos que ser?o vinculados ao manipulador
	* @param objeto oElemento  -> elemento do DOM
	* @param array aDados      -> dados passados pelo o parametros da function pai
	* @param string shtml      -> html a qual ser? injentado no DOM
	* @param string sFind      -> tipo de elemento injentado no DOM
	* @param objeto oThis      -> objeto com as manipula??es que ser?o atribuida ao novo elemento
	* @param bool bnaoConteudo -> true para sinalizar que nao esta contido dentro de um array com conteudo
	*/
	trata: function(oElemento,aDados,sHtml,sFind,oThis,bNaoConteudo)
	{
		if(bNaoConteudo)
		{
			oElemento.append(sHtml);
			aFuncoes.attr(oElemento.find(sFind+':last'),oThis.tag);
			//manipulador de css
			aFuncoes.css(oElemento.find(sFind+':last'),oThis.css);
			// manipula??es de eventos no objeto
			aFuncoes.eventos(oElemento,oThis.eventos);
			}else{
			oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').append(sHtml);
			aFuncoes.attr(oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find(sFind+':last'),oThis.tag);
			//manipulador de css
			aFuncoes.css(oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find(sFind+':last'),oThis.css);            
			// manipula??es de eventos no objeto
			aFuncoes.eventos(oElemento.find('div.'+$.fn.ui.config.classes.item_div+':last').find(sFind+':last'),oThis.eventos);
		}
		return oElemento.find(sFind+':last');
		},
	/* Conjuntos de function para controllers */
	controller:
	{
		/* function para todo o tipo de grid */
		Grid:
		{
			/* function que utilizam os dados do grid */
			Dados:
			{
				/* Cria uma opção no toolbar do grid para pesquisar os dados carregados
				** UPGRADE
				** --apenas os dados local esta sendo consultado, melhor para que seja feito remotamente--
				** --permitir que com um parametro isso seja desativado--
				** --caso o parametro de 'toolbar já exista, mesclar com o campo de pesquisa'--
				** --permitir que seja alterado o icone e o texto contido no toolbar do grid
				**
				* @param elemento oElemento -> elemento a qual o componente foi startado
				* @param string sComponente -> tipo de componente startado no elemento (padrao = 'datagrid')
					*/
				Pesquisar: function(oElemento,sComponente)
					{    
					/* #####################################
					* FUNCTION
					* #####################################
					*/
					// function de Pesquisar no grid
					/* Realiza a busca dentro do grid
					* @param string sValPesq -> valor para buscar
					* @param string sColuna  -> Coluna que deseja aplicar o filtro
					*/
					var fPesquisar = function(sValPesq,sColuna)
					{
						if(sValPesq != '')
							{   
							var bPesqAll = sColuna == 'todas_as_colunas' ? true : false ;
							// limpa valores marcados
							if(!aParamGrid.singleSelect)
								oElemento[sComponente]('unselectAll');
							// recupera as linhas carregado no grid
							var aLinhasGrid = oElemento[sComponente]('getData').rows;
							//
							var aEncontrou = [];
							if(aParamGrid.singleSelect)
							{
								if(oElemento.find('input:hidden#grid_pesquisar_encontrados').length == 0)
									oElemento.append('<input type="hidden" id="grid_pesquisar_encontrados">');
								else
								aEncontrou = oElemento.find('input:hidden#grid_pesquisar_encontrados').val().split(',')                                            
							}
							//
							var bEncontrou = false;
							$.each
							(
							aLinhasGrid,
							function(iIndice,aValor)
							{
								if(!bEncontrou && (aEncontrou.toString().indexOf(iIndice) == -1))
								{
									$.each
									(
									aValor,
									function(sIndice,mVal)
									{
										// recupera os parametros da coluna
										var aOpColuna = oElemento[sComponente]('getColumnOption',sIndice);
										// se existe a coluna
										if(aOpColuna && (bPesqAll || (sIndice == sColuna) ) )
										{
											// e pesquisado somente em colunas visiveis
											if(!aOpColuna.hidden)
											{
												// caso exista uma formatação nos dados
												if(aOpColuna.formatter)
													mVal = aOpColuna.formatter(mVal,aValor,iIndice);
												// se existe
												if(mVal)
												{
													// transforma em string o valor passado
													mVal = new String(mVal);
													// se contem...
													if(mVal.toLowerCase().indexOf(sValPesq.toLowerCase()) > -1 )
													{
														if(aParamGrid.singleSelect)
														{
															bEncontrou = true;
															oElemento.find('input:hidden#grid_pesquisar_encontrados').val
															(oElemento.find('input:hidden#grid_pesquisar_encontrados').val()+','+iIndice);
														}
														oElemento[sComponente]('selectRow',iIndice);
													}
													}                                                            
												}                                                            
										}
									}
									)                                                    
								}
							}
							);
							if(!bEncontrou && aParamGrid.singleSelect)
							{
								oElemento[sComponente]('unselectAll');
								if(oElemento.find('input:hidden#grid_pesquisar_encontrados').length == 1)
									oElemento.find('input:hidden#grid_pesquisar_encontrados').val('');
							}
							}else{
							oElemento[sComponente]('unselectAll');
						}
					}
					/* #####################################
					* /FUNCTION
					* #####################################
					*/                    
					//parametros padrao
					sComponente = sComponente ? sComponente : 'datagrid' ;
					//
					var sIDElem = new Date().getTime()+Math.floor(Math.random() * 999);
					// recupera os parametros do grid
					var aParamGrid = oElemento[sComponente]('options');
					// recupera todas as colunas do grid (columns + frozenColumns)
						var aColunasAll = aParamGrid.columns.concat(aParamGrid.frozenColumns);
					var aColunas = []; //colunas
					var aTotColunas = {visivel: 0, invisivel: 0};
					// recupera as colunas visiveis
					$.each
					(
					aColunasAll,
					function()
					{
						$.each
						(
						this,
						function()
						{
							aColunas.push(this);
							//contator de colunas visiveis e invisiveis
							if(this.hidden)
								aTotColunas.invisivel++;
							else
							aTotColunas.visivel++;
							if(this.checkbox && !this.hidden)
								aTotColunas.visivel--; // se existe colunas checkbox, essa nao conta
						}
						)
						}
					);                    
					//
					var sColunas = '<div name="todas_as_colunas">Todas as colunas</div>';
					$.each
					(
					sort(aColunas),
					function()
					{
						if(this.title)
						{
							sColunas += '<div name="'+this.field+'">'+this.title+'</div>';
						}
					}
					);
					//
					oElemento.append
					(
					'<div id="'+sIDElem+'">'+
					'<input></input>'+
					'<div  id="menu_'+sIDElem+'" style="width:120px">'+
					sColunas+
					'</div>'+
					'</div>'
					);
					//
					oElemento[sComponente]({toolbar: '#'+sIDElem});
					//
					$('div#'+sIDElem+' input').searchbox({  
						width: $.fn.datagrid.defaults.searchBox.width,  
						searcher:function(sValor,sColuna)
							{                              
							fPesquisar(sValor,sColuna);
							},  
						menu:'#menu_'+sIDElem,  
						prompt: $.fn.datagrid.defaults.searchBox.propmt,
						value: $.fn.datagrid.defaults.searchBox.value
						});
					$('div#'+sIDElem+' input').searchbox('textbox').bind
					({
						change: function()
						{
							if(oElemento.find('input:hidden#grid_pesquisar_encontrados').length == 1)
							{
								oElemento.find('input:hidden#grid_pesquisar_encontrados').val('');
							}
							},
						keypress: function(event)
						{
							if ( event.which == 13 )
							{
								event.stopImmediatePropagation();
							}
							}                           
						});
					}                    
			}
			},
		VerificaData: function(digData)
		{
			var bissexto = 0;
			var data = digData;
			var tam = data.length;
			if (tam == 10)
			{
				var dia = data.substr(0,2)
					var mes = data.substr(3,2)
					var ano = data.substr(6,4)
					if ((ano > 1900)||(ano < 2100))
				{
					switch (mes)
					{
						case '01':
						case '03':
						case '05':
						case '07':
						case '08':
						case '10':
						case '12':
						if  (dia <= 31)
						{
							return true;
						}
						break
						
						case '04':
						case '06':
						case '09':
						case '11':
						if  (dia <= 30)
						{
							return true;
						}
						break
						case '02':
						/* Validando ano Bissexto / fevereiro / dia */
						if ((ano % 4 == 0) || (ano % 100 == 0) || (ano % 400 == 0))
						{
							bissexto = 1;
						}
						if ((bissexto == 1) && (dia <= 29))
						{
							return true;
						}
						if ((bissexto != 1) && (dia <= 28))
						{
							return true;
						}
						break
					}
				}
			}
			return false;
		}
	}
}
/* *********************************
* PARAMETROS PADRÕES NO FRAMEWORK e no PLUGIN
* *********************************
*/
$(function(){
	$.fn.ui.config = {};
	/* parametros de configurações - padrão */
	$.fn.ui.config.classes =
	$.extend
	(
	{
		titulo: 'Form_Titulo',
		item_div: 'Form_Item',
		item_label_titulo: 'Form_Item_Label_Titulo',
		item_label_button: 'Form_Item_Label_Button'
		},
	$.fn.ui.config.classes
	);    
	$.fn.ui.resolucao =
	{
		width: $(window).width(),
		height: $(window).height()
		}
	// TRADUÇÃO
	if ($.fn.pagination){
		$.fn.pagination.defaults.beforePageText = 'Página';
		$.fn.pagination.defaults.afterPageText = 'de {pages}';
		$.fn.pagination.defaults.displayMsg = 'Mostrando {from} - {to} . Total de {total} registros';
	}
	if ($.fn.tabs)
	{
		//Opção de recarregar
		$.fn.tabs.defaults.tools =
		[{
			iconCls:'icon-reload',
			handler:function()
				{   
				// recupera o elemento pai com as tabs
				var oElementoTabs = $(this).closest('.tabs-container');
				//
				$.messager.confirm
				(
				'Confirmação',
				'Recarregar a Aba Selecionada?',
				function(bOp)
				{
					if(bOp)
						oElementoTabs.tabs('getSelected').panel('refresh');                              
				}
				)                
			}
			}];
		// confirmação para fechar a janela
		$.fn.tabs.defaults.onBeforeClose =
		function()
		{
			if(confirm('Deseja fechar?'))
				return true;
			else
			return false;
			}            
	}
	if ($.fn.datagrid){
		$.fn.datagrid.defaults.loadMsg = 'Carregando, Aguarde...';
		/*
		* Ordenaçao nas colunas dos grid que carrega dados locais 
		*/
		$.fn.datagrid.defaults.striped = true;
		$.fn.datagrid.defaults.onSortColumn = 
		function(sCol,sOrder)
		{
			if(!$(this).datagrid('options').url)
			{
				// declaraçao de variaveis
				var sColuna;
				var aOpColuna;
				var aObj = {};
				var aDadosO = [];                    
				var oElemento = $(this);
				// recupera os dados carregados
				var aDados = oElemento.datagrid('getData');
				//
				$.each
				(
				aDados.rows,
				function(iIndice)
				{
					// recupera os parametros da coluna
					aOpColuna = oElemento.datagrid('getColumnOption',sCol);
					//
					if(aOpColuna.formatter)
						sColuna = aOpColuna.formatter(sColuna,this,sCol);                            
					else
					sColuna = this[sCol];
					//
					var sIndiceObj = this[sCol] ? this[sCol] : ' '; // tratamento nos valores vazio
					if(aObj[sIndiceObj]) // valores repetidos
					sIndiceObj += ' ';
					//
					aObj[sIndiceObj] = iIndice;
					aDadosO.push(sIndiceObj);
				}
				)
					//
				var aDadosTemp = [];
				$.each
				(
				sOrder == 'asc' ? sort(aDadosO) : rsort(aDadosO),
				function()
				{
					aDadosTemp.push(aDados.rows[aObj[this]]);
				}
				)
					aDados.rows = aDadosTemp;
				oElemento.datagrid('loadData',aDados);
			}
			}                
		/* 
		* Valores default para o componente datagrid, esse parametros e para exibir uma opção de pesquisa no grid
		*/
		$.fn.datagrid.defaults.searchBox = 
		{ 
			width: 300,
			propmt: 'Pesquisar...',
			value: ''
			};
		/*
		* Adicionado a opção de ocultar/exibir colunas
		*/
		$.fn.datagrid.defaults.onHeaderContextMenu = 
		function(e, field)
		{
			e.preventDefault();
			var oElementoGrid = $(this);
			// recupera todas as colunas do grid (columns + frozenColumns)
				var aColunasAll = oElementoGrid.datagrid('options').columns.concat(oElementoGrid.datagrid('options').frozenColumns);
			var aColunas = []; //colunas
			var aTotColunas = {visivel: 0, invisivel: 0};
			// recupera as colunas visiveis
			$.each
			(
			aColunasAll,
			function()
			{
				$.each
				(
				this,
				function()
				{
					aColunas.push(this);
					//contator de colunas visiveis e invisiveis
					if(this.hidden)
						aTotColunas.invisivel++;
					else
					aTotColunas.visivel++;
					if(this.checkbox && !this.hidden)
						aTotColunas.visivel--; // se existe colunas checkbox, essa nao conta
				}
				)
				}
			);
			//
			var oElementoMenu = $('<div style="width:100px;"></div>').appendTo('body');
			//
			$.each
			(
			aColunas,
			function()
			{
				var sIcon = this.hidden ? 'empty' : 'ok' ;
				if(this.title && !this.checkbox && !this.colspan)
					$('<div iconCls="icon-'+sIcon+'" id="'+this.field+'" />').html(this.title).appendTo(oElementoMenu);
			}
			);
			//
			oElementoMenu.menu
			({
				onClick: function(item)
				{
					if (item.iconCls=='icon-ok')
					{
						if(aTotColunas.visivel > 1) // tenha pelo menos mais de uma coluna visivel
						{
							oElementoGrid.datagrid('hideColumn', item.id);
							oElementoMenu.menu
							(
							'setIcon', 
							{
								target: item.target,
								iconCls: 'icon-empty'
							}
							);                                    
						}
						} else {
						oElementoGrid.datagrid('showColumn', item.id);
						oElementoMenu.menu('setIcon', {
							target: item.target,
							iconCls: 'icon-ok'
							});
					}
					oElementoMenu.remove();
				}
				});    
			oElementoMenu.menu
			(
			'show', 
			{
				left:e.pageX,
				top:e.pageY
			}
			);
		}
	}
	if ($.fn.treegrid && $.fn.datagrid){
		$.fn.treegrid.defaults.loadMsg = $.fn.datagrid.defaults.loadMsg;
	}
	if ($.fn.window){
		//$.fn.window.defaults.width = ($.fn.ui.resolucao.width-100);
		//$.fn.window.defaults.height = ($.fn.ui.resolucao.height-50);
		$.fn.window.defaults.modal = true;
	}
	if ($.messager){
		$.messager.defaults.ok = 'Ok';
		$.messager.defaults.cancel = 'Cancelar';
	}
	if ($.fn.validatebox){
		$.fn.validatebox.defaults.missingMessage = 'Campo de preenchimento obrigátorio.';
		$.fn.validatebox.defaults.rules.email.message = 'Informe um email válido.';
		$.fn.validatebox.defaults.rules.url.message = 'Informe um URL válida.';
		$.fn.validatebox.defaults.rules.length.message = 'Informe um valor entre {0} à {1}.';
		$.fn.validatebox.defaults.rules.remote.message = 'Corrija este campo.';
		$.fn.validatebox.defaults.rules.data = // Validação de data SIMPLES
		{
			validator: function(value, param)
			{
				if(value.indexOf('/') > -1)
				{
					var aDMA = value.split('/');
					aDMA[0] = (parseInt(aDMA['0'],10) > 9) ? aDMA['0'] : '0'+parseInt(aDMA['0'],10);
					aDMA[1] = (parseInt(aDMA['1'],10) > 9) ? aDMA['1'] : '0'+parseInt(aDMA['1'],10);
					if(aFuncoes.controller.VerificaData(aDMA['0']+'/'+aDMA['1']+'/'+aDMA['2']))
						return value;
					}                    
				},
			message: 'Formato de data inválida'
		}
	}
	if ($.fn.numberbox){
		$.fn.numberbox.defaults.missingMessage = $.fn.validatebox.defaults.missingMessage;
	}
	if ($.fn.combobox){
		$.fn.combobox.defaults.missingMessage = $.fn.validatebox.defaults.missingMessage;
	}
	if ($.fn.combotree){
		$.fn.combotree.defaults.missingMessage = $.fn.validatebox.defaults.missingMessage;
	}
	if ($.fn.combogrid){
		$.fn.combogrid.defaults.missingMessage = $.fn.validatebox.defaults.missingMessage;
		$.fn.combogrid.defaults.onHeaderContextMenu = $.fn.datagrid.defaults.onHeaderContextMenu;
		$.fn.combogrid.defaults.onSortColumn = $.fn.datagrid.defaults.onSortColumn;
		$.fn.combogrid.defaults.striped = $.fn.datagrid.defaults.striped;
	}
	if ($.fn.calendar){
		$.fn.calendar.defaults.weeks = ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'];
		$.fn.calendar.defaults.months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
	}
	if ($.fn.datebox){
		$.fn.datebox.defaults.validType = 'data';
		$.fn.datebox.defaults.currentText = 'Hoje';
		$.fn.datebox.defaults.closeText = 'Fechar';
		$.fn.datebox.defaults.okText = 'Ok';
		$.fn.datebox.defaults.missingMessage = $.fn.validatebox.defaults.missingMessage;
		$.fn.datebox.defaults.formatter = function(data)
		{
			return data.getDate()+'/'+(parseInt(data.getMonth())+1)+'/'+data.getFullYear();
			};
		/*
		* MUD0U 
		* correção no parse de data, antes estava dando erro ao digitar um data
		*/
		$.fn.datebox.defaults.parser = function(data)
		{
			if(data.length)
			{
				if(data.search(/^([1-9]|0[1-9]|[12][0-9]|3[01])\/([1-9]|0[1-9]|1[012])\/(19[0-9][0-9]|20[0-9][0-9])$/) > -1)
				{
					var aData = data.split('/');
					return new Date(aData[2],(parseInt(aData[1])-1),aData[0]);                        
					}else{
					return new Date();    
				}
				}else{
				return new Date();
			}
		}
	}
	if ($.fn.datetimebox && $.fn.datebox){
		$.extend($.fn.datetimebox.defaults,{
			currentText: $.fn.datebox.defaults.currentText,
			closeText: $.fn.datebox.defaults.closeText,
			okText: $.fn.datebox.defaults.okText,
			missingMessage: $.fn.datebox.defaults.missingMessage
			});
	}
	});
/*
* FUNCÕES DE AUXILIO DO SITE phpjs.org 
* # function's:
* # # rsort();
* # # sort();
*/
function rsort(b,h){var c=[],d="",a=0,a=!1,i=this,f=!1,e=[];switch(h){case "SORT_STRING":a=function(a,g){return i.strnatcmp(g,a)};break;case "SORT_LOCALE_STRING":a=this.php_js.i18nLocales[this.i18n_loc_get_default()].sorting;break;case "SORT_NUMERIC":a=function(a,g){return g-a};break;default:a=function(a,g){var b=parseFloat(g),c=parseFloat(a),d=b+""===g,e=c+""===a;if(d&&e)return b>c?1:b<c?-1:0;else if(d&&!e)return 1;else if(!d&&e)return-1;return g>a?1:g<a?-1:0}}this.php_js=this.php_js||{};this.php_js.ini=
this.php_js.ini||{};e=(f=this.php_js.ini["phpjs.strictForIn"]&&this.php_js.ini["phpjs.strictForIn"].local_value&&this.php_js.ini["phpjs.strictForIn"].local_value!=="off")?b:e;for(d in b)b.hasOwnProperty(d)&&(c.push(b[d]),f&&delete b[d]);c.sort(a);for(a=0;a<c.length;a++)e[a]=c[a];return f||e}
function sort(b,h){var c=[],d="",a=0,a=!1,i=this,f=!1,e=[];switch(h){case "SORT_STRING":a=function(a,b){return i.strnatcmp(a,b)};break;case "SORT_LOCALE_STRING":a=this.php_js.i18nLocales[this.i18n_loc_get_default()].sorting;break;case "SORT_NUMERIC":a=function(a,b){return a-b};break;default:a=function(a,b){var c=parseFloat(a),d=parseFloat(b),e=c+""===a,f=d+""===b;if(e&&f)return c>d?1:c<d?-1:0;else if(e&&!f)return 1;else if(!e&&f)return-1;return a>b?1:a<b?-1:0}}this.php_js=this.php_js||{};this.php_js.ini=
this.php_js.ini||{};e=(f=this.php_js.ini["phpjs.strictForIn"]&&this.php_js.ini["phpjs.strictForIn"].local_value&&this.php_js.ini["phpjs.strictForIn"].local_value!=="off")?b:e;for(d in b)b.hasOwnProperty(d)&&(c.push(b[d]),f&&delete b[d]);c.sort(a);for(a=0;a<c.length;a++)e[a]=c[a];return f||e}function i18n_loc_get_default(){this.php_js=this.php_js||{};return this.php_js.i18nLocale||(i18n_loc_set_default("en_US_POSIX"),"en_US_POSIX")}
function i18n_loc_set_default(b){this.php_js=this.php_js||{};this.php_js.i18nLocales={en_US_POSIX:{sorting:function(b,c){return b==c?0:b>c?1:-1}}};this.php_js.i18nLocale=b;return!0};
