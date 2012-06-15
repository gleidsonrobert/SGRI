//<![CDATA[
//******************************************************************************
// @name:        da.imagem.metadados.js
// @purpose:     scripts que fazem a atualizacao/edicao de iptc dos diversos
//               arquivos adicionados.
//
// @author:      Ruhan Bidart - ruhan@2xt.com.br
// @created:     17/10/2007
//******************************************************************************
//]]>
var objIPTCMetadata = function(idBox, obrigatorios) {
    // ** Propriedades
    // objetos relacionados
    this.urlToSend = url_salvar_iptc;
	this.urlToSendEdit = url_salvar_iptc_edit;
    this.urlToGetThumbnail = url_get_thumb;
	this.urlToGetThumbnailEdit = url_get_thumb_edit;
    this.urlImagemTodos = url_estatica + '/img/iptc_todos.jpg'
	this.urlAjuda = url_ajuda_iptc;
    this.idBox = idBox;
    this.objBox = document.getElementById(this.idBox);
    this.objBoxBotaoFechar = document.getElementById(this.idBoxBotaoFechar);
    this.objBoxBotaoEnviar = document.getElementById(this.idBoxBotaoEnviar);
	try{
		this.id_midias = id_midias;
	}catch(e){
		this.id_midias = [];
	}
    // classes de CSS
    this.classItemOk = ''
    this.classItemErro = '_erro'
    // marca os campos que sao obrigatorios pelo seu id NO BANCO
	
    if(obrigatorios) {
         
        this.obrigatorios = obrigatorios;
    } else {
        this.obrigatorios = {'id_midia': false,
		                     'nomearquivo': true,
		                     'informacoesarquivo': false,
							 'credito': true,
                             'dataentrada': false,
							 'dataproducao': false,
							 'dataexpira': false,
                             'descricao': true,
							 'categoria': false,
                             'subcategoria': false,
							 'catalogo': false,
                             'publicacoes': false,
							 'restricao': false,
							 'localfisico': false,
                             'observacao': false,
							 'keywords': false,
							 'conceito': false,
							 'id_org': false,
							 'status': false,
							 'cromia': false,
							 'posicionamento':false,
		                     'vender': false,
		                     'compartilhar': false,
							 'compermissao': true,
							 'sempermissao':false}


		this.label = {'nomearquivo': 'Nome do Arquivo',
		              'informacoesarquivo': 'Informações Arq.',
					  'credito': 'Autor',
                      'dataentrada': 'Data de entrada',
  					  'dataproducao': 'Data de criação',
					  'dataexpira': 'Data de Expiração',
                      'descricao': 'Descrição',
					  'categoria': 'Categoria',
                      'subcategoria': 'Subcategoria',
					  'compermissao': 'Grupos com permissão'}
	}

	this.select_inputs = {'categoria': true,
	                      'subcategoria': true,
						  'catalogo': true,
						  'sempermissao':true,
						  'compermissao':true,
						  'status':true,
	                      'vender':true,
                          'cromia': true,
						  'posicionamento':true,
	                      'compartilhar':true}

	this.select_multiple = {'compermissao': true}
	this.errs = [];
	this.temp_grupos = new Array();
    this.imagens = {};
    this.__metadados = {};
	this.id_midia = {};
	this.id_mid = 0; // utilizado para funcionalidades de edição de imagem
    this.tmp_metadados = {};
	this.temp_metadados = {}; // utilizado para guardar os valores dos campos na edição das imagens (IPTC)
    this.showed = false;
    this.numAbas = 2;
    // imagem ativa
    this.nameImagemAtiva = null;
    this.sizeImagemAtiva = null;
    this.keyImagemAtiva = null; // armazena o nome e size da imagem concatenados
    // armazenador dos objetos (inputs, textareas) que receberao os metadados IPTC
    this.objetosIPTC = {};
	this.objetosIPTC_ant = {};
    // ** Funções
    // carregando os objetos de formulario
    this.loadObjetosIPTC();
}

// ** Funcoes Base
objIPTCMetadata.prototype.newImagemIPTC = function (name, size, todos) {
    this.todos = todos;
	if (!todos)
		document.getElementById('rotate_links').style.display = 'block';
	this.getCatalogos(null, null);
    this.getThumbnail(name, size);
    var key = this.getKeyIPTC(name, size);

    this.preencherFormuIPTC(name, size);
	this.getGrupos(this.id_mid);
    this.showAbaIPTC(1);
    this.name = name;
    this.size = size;
    this.keyImagemAtiva = key;
    //this.limparErrosIPTC();
    this.showIPTC();
	//this.scrollIPTC();
	//this.criarLinksAjudaIPTC(this._ajuda);
};

objIPTCMetadata.prototype.clearSelectInputs = function() {
    /** seta os selects para o primeiro index **/
	for (sel in this.select_inputs)
	{
	    if (this.select_inputs[sel] == true)
		{
		   var n_campo = this.idBox + '.' + sel;
		   var inp_sel = document.getElementById(n_campo);

		   try{
			   var opts = inp_sel.getElementsByTagName('option');
			   opts[0].selected = true;
			   //inp_sel.selectedIndex = 0;
		   }catch(e){}

		}
	}
};

objIPTCMetadata.prototype.getSubGroups = function(cat_id, sca_id) {
    /** esconde os options que não fazem parte da categoria **/
	var selectSub = document.getElementById(this.idBox + '.' + 'subcategoria');
	var handler = new XMLHandler();
	  /** função python **/
	  var xmlreq = new XMLClient(url_get_subcategories);
	  /** parametros da função **/
	  xmlreq.addParam('dp_cat_id', cat_id);

	  /** eventos do handler **/
	  handler.onError = function(e) { showBox(e, 'erro'); }
	  handler.onProgress = function() {}
	  handler.onInit = function() {}
	  handler.onLoad = function(xmlStr)
	  {
		  res = eval(xmlStr);
		  var objSel = document.getElementById('box_iptc.subcategoria');
		  objSel.innerHTML = '';
		  var optIn = document.createElement('option');
		  optIn.setAttribute('value', '-1');
		  optIn.innerHTML = 'Selecione a Subcategoria';
		  objSel.appendChild(optIn);

		  for (var i=0; i<res.length; i++)
		  {
		      var objDin = document.createElement('option');
			  objDin.setAttribute('value', res[i]['dp_sca_id']);
			  if (sca_id == res[i]['dp_sca_id']) {
			      objDin.selected = true;
			  }
			  objDin.innerHTML =  res[i]['dp_sca_digito']+' - '+res[i]['dp_sca_nome'];
			  objSel.appendChild(objDin);
		  }
	  };
	  xmlreq.query(handler);
};

objIPTCMetadata.prototype.getCatalogos = function(adm_id, cal_id) {
    /** esconde os options que não fazem parte da categoria **/
	var selectCat = document.getElementById(this.idBox + '.' + 'catalogo');
	var handler = new XMLHandler();
	  /** função python **/
	  var xmlreq = new XMLClient(url_get_catalogos);
	  /** parametros da função **/
	  if (adm_id != null) xmlreq.addParam('dp_adm_id', adm_id);

	  /** eventos do handler **/
	  handler.onError = function(e) { showBox(e, 'erro'); }
	  handler.onProgress = function() {}
	  handler.onInit = function() {}

	  handler.onLoad = function(xmlStr)
	  {
		  res = eval(xmlStr);
		  var objSel = document.getElementById('box_iptc.catalogo');
		  objSel.innerHTML = '';
		  var optIn = document.createElement('option');
		  optIn.setAttribute('value', '-1');
		  optIn.innerHTML = 'Selecione o Catálogo';
		  objSel.appendChild(optIn);

		  for (var i=0; i<res.length; i++)
		  {
		      var objDin = document.createElement('option');
			  objDin.setAttribute('value', res[i]['dp_cal_id']);
			  if (cal_id == res[i]['dp_cal_id']) {
			      objDin.selected = true;
			  }
			  objDin.innerHTML = res[i]['dp_cal_nome'];
			  objSel.appendChild(objDin);
		  }
	  };
	  xmlreq.query(handler);
};


objIPTCMetadata.prototype.getGrupos = function(mid_id) {
      /** esconde os options que não fazem parte da categoria **/
	  var handler = new XMLHandler();
	  /** função python **/
	  var xmlreq = new XMLClient(url_get_grupos);
	  /** parametros da função **/
	  if (mid_id != null) {
	      xmlreq.addParam('dp_mid_id', mid_id);
	  }
	  /** eventos do handler **/
      handler.onError = function(e) { showBox(e, 'erro'); }
	  handler.onProgress = function() {}
	  handler.onInit = function() {}

	  handler.onLoad = function(xmlStr)
	  {
          var lista = eval(xmlStr);
		  lista_grupo = lista[0];
		  lista_grupomid = lista[1];

		  var selSP = document.getElementById('box_iptc.sempermissao');
		  selSP.innerHTML = '';
		  var selCP = document.getElementById('box_iptc.compermissao');
		  selCP.innerHTML = '';

		  for (var i=0; i<lista_grupo.length; i++)
		  {			  
			  var optG = document.createElement('option');
			  optG.setAttribute('value', lista_grupo[i]['dp_gad_id']);
			  if (i%2 == 1) optG.style.backgroundColor = '#DCDCDC';
			  optG.innerHTML = lista_grupo[i]['dp_gad_nome'];
			  // Caso estiver editando todos IPTC e o nome do grupo igual a este
			  if (IPTCMetadata.todos && lista_grupo[i]['dp_gad_nome'].toLowerCase()=='todos os usuários do sistema'){
				selCP.appendChild(optG);
			  }else{
				selSP.appendChild(optG);
			  }
		  };

		  for (var j=0; j<lista_grupomid.length; j++)
		  {
			  var optGM = document.createElement('option');
			  optGM.setAttribute('value', lista_grupomid[j]['dp_gad_id']);
			  if (j%2 == 1) optGM.style.backgroundColor = '#DCDCDC';
			  optGM.innerHTML = lista_grupomid[j]['dp_gad_nome'];
			  selCP.appendChild(optGM);
		  };		  
			  

		  
	  };
	  xmlreq.query(handler);
};

objIPTCMetadata.prototype.hideShowSelects = function(tipo) {
    /** busca todos os selects da página para esconder no IE6.0 **/

    var objSelects = document.getElementsByTagName('select');
	for (var i=0; i<objSelects.length; i++)
	{
	    objSelects[i].style.visibility = tipo;
	}

	/** busca todos os selects do formulário de edição de IPTC e mostra-os novamente **/
	for (sel in this.select_inputs)
	{
	    var n_inp = this.idBox + '.' + sel;
		var obj = document.getElementById(n_inp);
		obj.style.visibility = 'visible';
	}
};

objIPTCMetadata.prototype.editImagemIPTC = function(dicionario, dictObjetos) {
	document.getElementById('rotate_links').style.display = 'block';
    var IE = document.all;
	var navVers = navigator.appVersion;
	
	if (IE && navVers.indexOf('MSIE 6.0') != -1) {
	    this.hideShowSelects('hidden');
	}
    this.clearSelectInputs();
	this.getCatalogos(dicionario['dp_adm_id'], dicionario['dp_cal_id']);
	//if (dicionario['dp_org_id'] == 3)
		this.getSubGroups(dicionario['dp_cat_id'], dicionario['dp_sca_id']);
    this.id_mid = 0;
	this.id_mid = dicionario['dp_mid_id'];
	var name = dicionario['dp_mid_nomearquivo'] ? dicionario['dp_mid_nomearquivo'] : '';
	var size = dicionario['dp_mid_size'] ? dicionario['dp_mid_size'] : 0;
	this.getThumbnailEdit(this.id_mid);
	this.getGrupos(this.id_mid);
	this.objetosIPTC = dictObjetos;
	var key = this.getKeyIPTC(name, size);
	this.preencherFormuIPTCEdit(name, size);
    this.showAbaIPTC(1);
	this.name = name;
	this.size = size;
	this.keyImagemAtiva = key;
	//this.limparErrosIPTC();
	this.showIPTC();
    //this.scrollIPTC();
	//this.criarLinksAjudaIPTCEdit();

};

objIPTCMetadata.prototype.preencherFormuIPTCEdit = function(name, size) {
    // verificando se os dados sao os que ja estao no formulario IPTC
    var key = this.getKeyIPTC(name, size);
    // preenchendo o titulo geral
    if(!name) name = this.nameImagemAtiva;
    for(var i=1; i<=this.numAbas; i++) {
        var id_titulo_geral = this.idBox + "." + "titulo_geral" + i;
		if(name.length > 26) name = name.substr(0, 23) + '...'
        document.getElementById(id_titulo_geral).innerHTML = name;
    }
    // preenchendo o formulario com os dados caso nao haja dados, esvazia o form
    var valor = "";

	for (dado in this.objetosIPTC)
	{
	    var id_inp = this.idBox + '.' + dado
		if (dado != 'categoria' || this.objetosIPTC[dado] != '') {
			if (dado != 'dp_cat_nome' && dado != 'dp_sca_nome' && dado != 'dp_sca_status' && dado != 'dp_cat_status')
				document.getElementById(id_inp).value = this.objetosIPTC[dado];
		}
    }
	
	
	//buscando o status da imagem
/*	if (this.objetosIPTC['status']){
	   document.getElementById('status_ativo').selected = 'selected';
	}else{	
	   document.getElementById('status_inativo').selected = 'selected';
	}
	*/

	if((this.objetosIPTC['id_org'] == 2 || this.objetosIPTC['id_org'] == 1) && (this.objetosIPTC['categoria'] && this.objetosIPTC['subcategoria'] && this.objetosIPTC['dp_cat_status'])){

		if (this.objetosIPTC['dp_cat_status'] == 0){

			var objCat = document.getElementById('box_iptc.categoria');
			var optInc = document.createElement('option');
			optInc.setAttribute('value', this.objetosIPTC['categoria']);
			optInc.innerHTML = this.objetosIPTC['dp_cat_nome'];
			optInc.selected = true;
			objCat.appendChild(optInc);
		}
		if (this.objetosIPTC['dp_sca_status'] == 0){
			var objSca = document.getElementById('box_iptc.subcategoria');
			var optIns = document.createElement('option');
			optIns.setAttribute('value', this.objetosIPTC['subcategoria']);
			optIns.innerHTML = this.objetosIPTC['dp_sca_nome'];
			optIns.selected = true;
			objSca.appendChild(optIns);
		}
		
		
		var obj = document.createElement('input');
		obj.setAttribute('id','cat_old');
		obj.setAttribute('value',this.objetosIPTC['categoria']+'/'+this.objetosIPTC['dp_cat_nome']);
		obj.setAttribute('type','hidden');
		document.getElementById('box_iptc.aba_1').appendChild(obj);

		var obj = document.createElement('input');
		obj.setAttribute('id','sca_old');
		obj.setAttribute('value',this.objetosIPTC['subcategoria']+'/'+this.objetosIPTC['dp_sca_nome']);
		obj.setAttribute('type','hidden');
		document.getElementById('box_iptc.aba_1').appendChild(obj);		
	}
	//this.objetosIPTC = {}
	this.loadObjetosIPTC();
}

objIPTCMetadata.prototype.sendIPTCEdit = function() {
     /********
	 função utilizada para edit_imagem, validando todos os campos obrigatórios e setando na
	 variável this.temp_metadados um dicionario com os valores do formulário que será encodado utilizando o JSON.
	 ******/
	var todos =this.todos;


	 this.errs = []
     if (!this.validaFormularioEdit()) { this.mostrarErros(); return; }
	 else {
         var handler = new XMLHandler();
	     var xmlreq =  new XMLClient(this.urlToSendEdit);
		 if (todos) {      
			 if(this.id_midias == '')
				this.id_midias=id_midias;

			 if (this.id_midias.length > 0) xmlreq.addParam('id_midias', JSON.encode(this.id_midias));
		     xmlreq.addParam('todos', this.todos);
		 }
		 if (!this.temp_metadados['id_org']){
			/* armazena o org_id ao inserir nova imagem. */
			this.temp_metadados['id_org'] = document.getElementById('box_iptc.id_org').value;
		 }

		 xmlreq.addParam('metadados', JSON.encode(this.temp_metadados));
		 xmlreq.addParam('grupos', this.temp_grupos);

		 handler.onError = function(e) { showBox(e, 'erro'); }
		 handler.onProgress = function() {};
		 handler.onInit = function() {};
		 handler.onLoad = function (xmlStr)
		 {
		     var res = eval(xmlStr);

			 if (res[0]['resultado'] == 'ok'){

			 if(todos)
			 IPTCMetadata.preencherTodosIPTCNotCampos();
			 /*
				if(todos)
				for (key in IPTCMetadata.tmp_metadados){
						for(dado in IPTCMetadata.temp_metadados) {

							if (IPTCMetadata.temp_metadados[dado]){
								IPTCMetadata.tmp_metadados[key][dado]=IPTCMetadata.temp_metadados[dado];
							}
						}
					}
				*/
				
				var msg = res[0]['msg'];
				msg += "<a href=\"#\" onclick=\"setarImagemIndexando();hideBox();\" class=\"fechar2\" /> FECHAR [X]</a>";
				var tipo = "ok";
				var fechar = true;
				showBox(msg, tipo,'false',fechar);
			}else showBox(res[0]['msg'], 'erro');
			this.temp_metadados = {};
		 }
    	 xmlreq.query(handler);
     }
}

objIPTCMetadata.prototype.mostrarErros = function() {
     /********
	 função para mostrar o showBox com os erros para o usuário.
	 ******/
	 var html = "";
	 var tipo = "erro";
	 html += "Os campos abaixo estão incorretos:<br /><br />"
	 for (var i=0; i<this.errs.length; i++) {
	     html += this.errs[i] + '<br />';
	 }
	 showBox(html, tipo);
}

objIPTCMetadata.prototype.validaFormularioEdit = function() {
     /********
	 função para validar os campos do formulario com base no atributo obrigatorio, que define os campos do formulário
	 que deverão ser preenchidos ou nao.
	 ******/
    this.temp_metadados = {};
	cat_disabled = document.getElementById('box_iptc.categoria').disabled;

    for (campos in this.obrigatorios) {
	    var n_campo = this.idBox + '.' + campos;
		var objInp = document.getElementById(n_campo);
		/*if(campos=='dataproducao'){ alert('Campo:'+campos+'-'+this.obrigatorios[campos])}*/

		if (this.todos != true) {

			if (this.obrigatorios[campos] && campos == 'compermissao'){
				if (objInp.length <1){
					//verifica se há grupo selecionado
					this.errs.push("- '" + this.label[campos] + "'");
				}else if(objInp.length >1){
				    //verifica se o grupo "todos usuários do sistema" (id = 1) esta selecionado junto com outros grupos
					for (var j=0; j<objInp.length; j++){
						if (objInp[j].value == 1){
							var msg_grupo = "O grupo <b>Todos usuários do sistema</b> não pode ser selecionado com outros grupos.";
							this.errs.push("- '" + msg_grupo + "'");
						}
					}
				}
			}
			
		    if (this.obrigatorios[campos] && campos.indexOf('data') == -1 && (campos == 'descricao' || campos == 'credito')) {
				if (isEmpty(objInp.value)) this.errs.push("- '" + this.label[campos] + "'");
		    }
		    if (this.obrigatorios[campos] && campos.indexOf('data') != -1 && campos!='dataproducao') {

				if (!isDate(objInp.value)) this.errs.push("- '" + this.label[campos] + "'");
		    }

			if (campos.indexOf('data') != -1 && !isEmpty(objInp.value) && campos!='dataentrada') {

			if(campos=='dataproducao'){
				if (objInp.value.length == '11') objInp.value = objInp.value.replace(" ","");
				
				if (objInp.value.length == '10'){

					if (!isDate(objInp.value,'d/M/yyyy')) {

						this.errs.push("- '" + this.label[campos] + "'");
					}
				}else{

					if (!isDate(objInp.value,'d/M/yyyy HH:mm:ss')) this.errs.push("- '" + this.label[campos] + "'");
				}
			}
			else{

				if (!isDate(objInp.value)) this.errs.push("- '" + this.label[campos] + "'");
				}
			}

			if(per.indexOf('dapress.adm.arquivos.indexador')!=-1 && !cat_disabled){
				/*Verifica se as categorias e subcategorias foi selecionada */
				/*if (campos == 'categoria' || campos == 'subcategoria')  {
					if (objInp.value == -1 || isEmpty(objInp.value)) this.errs.push("- '" + this.label[campos] + "'");
				}*/
			}
		}
		else {
			// else novo identico ao if----------------------
			
			var classificar_todas = false
			try {
			    //verifica se esta na pagina de classificar pra nao exigir autor e descrição
				classificar_todas = document.getElementById('classificar_todas');
			}catch (e) {}
	
			if (!classificar_todas){  
			
			if (this.obrigatorios[campos] && campos == 'compermissao'){
				if (objInp.length <1){
					//verifica se há grupo selecionado
					this.errs.push("- '" + this.label[campos] + "'");
				}else if(objInp.length >1){
				    //verifica se o grupo "todos usuários do sistema" (id = 1) esta selecionado junto com outros grupos
					for (var j=0; j<objInp.length; j++){
						if (objInp[j].value == 1){ 
							var msg_grupo = "O grupo <b>Todos usuários do sistema</b> não pode ser selecionado com outros grupos.";
							this.errs.push("- '" + msg_grupo + "'"); 
						}
					}
				}
			}
				
				if (this.obrigatorios[campos] && campos.indexOf('data') == -1 && (campos == 'descricao' || campos == 'credito') ){
					
						if (isEmpty(objInp.value)) this.errs.push("- '" + this.label[campos] + "'");
			    }
			}
			
		    if (this.obrigatorios[campos] && campos.indexOf('data') != -1  && campos == 'dataproducao') {

				if (!isDate(objInp.value)) this.errs.push("- '" + this.label[campos] + "'");
		    }

			if (campos.indexOf('data') != -1 && !isEmpty(objInp.value) && campos!='dataentrada') {

				if(campos=='dataproducao'){
					if (objInp.value.length == '11') objInp.value = objInp.value.replace(" ","");
					if (objInp.value.length == '10'){
						if (!isDate(objInp.value,'d/M/yyyy')) this.errs.push("- '" + this.label[campos] + "'");
					}else{
						if (!isDate(objInp.value,'d/M/yyyy HH:mm:ss')) this.errs.push("- '" + this.label[campos] + "'");
					}
				}
				else{

					if (!isDate(objInp.value)) this.errs.push("- '" + this.label[campos] + "'");
				}
			}
		
			/*else antigo-----------------------
			
			// Verifica se as categorias e subcategorias foi selecionada 
			if(per.indexOf('dapress.adm.arquivos.indexador')!=-1 && !cat_disabled){
				if (campos == 'categoria' || campos == 'subcategoria')  {
					if (objInp.value == -1 || isEmpty(objInp.value)) this.errs.push("- '" + this.label[campos] + "'");
				}
			}
		    if (campos.indexOf('data') != -1 && !isEmpty(objInp.value)) {
					if(campos=='dataentrada' || campos=='dataproducao'){
						if (!isDate(objInp.value,'d/M/yyyy HH:mm')) this.errs.push("- '" + this.label[campos] + "'");
					}
					else{
						if (!isDate(objInp.value)) this.errs.push("- '" + this.label[campos] + "'");
					}
			} */
		}
		this.temp_metadados[campos] = objInp.value;
	};

	for (options in this.select_multiple) {
	    var grupos = new Array();
	    var n_opt = this.idBox + '.' + options;
		var objSel = document.getElementById(n_opt);
		var oOpts = objSel.getElementsByTagName('option');

		for (var j=0; j<oOpts.length; j++)
		{
		    grupos.push(oOpts[j].value);
		}
		this.temp_grupos = grupos;
	};


	if (this.errs.length > 0) {
	    return false;
	} else {
	    return true;
	}
}

objIPTCMetadata.prototype.sendIPTC = function(name, size) {

    // preenchendo todos
    if(this.todos) {
        this.preencherTodosIPTCNotCampos();
        this.hideIPTC();
        return;
    }
    var key = this.getKeyIPTC(name, size);
    // validando
    if(!this.validarIPTC(name, size)) return;
	// comparando a igualdade com os dados anteriores
	if(this.compararDadosIPTC(this.getDadosIPTC(), this.tmp_metadados[key])) {
		showBox('Os dados já foram enviados!', 'alert');
	    return;
	}
	this.saveIPTC();
	if(!name) {
		name = this.nameImagemAtiva;
		size = this.sizeImagemAtiva;
	}
	this.mostrarAguardeIPTC(true);
    this.desabilitarObjetosIPTC(true);
    // enviando por ajax
    var handler = new XMLHandler();
    var xmlreq = new XMLClient(this.urlToSend);
    // setando para ser sincrono
    xmlreq.setAsync(false);
    handler.bdoAsync = false;
    // parametros
    xmlreq.addParam('name', name);
    xmlreq.addParam('size', size);
	xmlreq.addParam('id_session', id_session)
    xmlreq.addParam('metadados', JSON.encode(this.tmp_metadados[key]));

    handler.onLoad = function(retorno) {
		retorno = JSON.encode(retorno);
		// lancando as mensagem de erro/sucesso
		if(retorno) showBox('Dados enviados com sucesso!');
		else showBox('Ocorreu um erro ao enviar os dados. Tente novamente.');
        return retorno;
    }
    // executa a query construída acima
    xmlreq.query(handler);
    this.desabilitarObjetosIPTC(false);
    this.mostrarAguardeIPTC(false);
    // atualizando o metadado enviado
    this.__metadados[key] = this.tmp_metadados[key];
    return xmlreq.oXMLRequest.responseText;
}

objIPTCMetadata.prototype.saveIPTC = function() {
    var key = this.getKeyIPTC();
    this.tmp_metadados[key] = this.getDadosIPTC();
}

objIPTCMetadata.prototype.showIPTC = function() {
    // apanhando os objetos
    var id_sombra = this.idBox + "." + "sombra";
    //var objSombra = document.getElementById(id_sombra);
    var id_corpo_sobreposto = this.idBox + "." + "corpo_sobreposto";
    var objCorpoSobreposto = document.getElementById(id_corpo_sobreposto);
    // mostrando o formulario
    //document.getElementById("conteudo").style.display = "none";
    this.objBox.style.display = "block";
    objCorpoSobreposto.style.display = "block";
    // trabalhando a sombra
/*
    with(objSombra.style) {
        height = this.objBox.offsetHeight - 50 + "px";
        top = this.objBox.offsetTop + 59 +"px";
        left = this.objBox.offsetLeft + 20 + "px";
        display = "block";
    }
*/
    this.showed = true;
}

objIPTCMetadata.prototype.hideIPTC = function() {
    var IE = document.all;
	var navVers = navigator.appVersion;

	if (IE && navVers.indexOf('MSIE 6.0') != -1) {
	    this.hideShowSelects('visible');
	}

    this.saveIPTC();
    var id_sombra = this.idBox + "." + "sombra";
    //var objSombra = document.getElementById(id_sombra);
    var id_corpo_sobreposto = this.idBox + "." + "corpo_sobreposto";
    var objCorpoSobreposto = document.getElementById(id_corpo_sobreposto);
    // escondendo o formulario
    this.objBox.style.display = "none";
    objCorpoSobreposto.style.display = "none";
    //objSombra.style.display = "none";
    this.showed = false;
	this.todos=false;
	this.keyImagemAtiva = null;
}

objIPTCMetadata.prototype.scrollIPTC = function(posicoes) {
//    var xscroll = posicoes[0], yscroll = posicoes[1];
    // getando os objetos
/*
    var id_sombra = this.idBox + "." + "sombra";
    var objSombra = document.getElementById(id_sombra);
    var id_corpo_sobreposto = this.idBox + "." + "corpo_sobreposto";
    var objCorpoSobreposto = document.getElementById(id_corpo_sobreposto);
*/
	var tam_pag = get_page_xy();
	var div_msg = document.getElementById(this.idBox);
	var div_fora = document.getElementById(this.idBox + ".corpo_sobreposto");

      if (div_fora != null)	{
	  	  div_fora.style.height = ((tam_pag.y - 5) + 'px');
		  div_fora.style.width  = ((tam_pag.x - 5) + 'px');
	  }

	  if (div_msg != null) {
		    var top  = ((tam_pag.h - 2390 - 26) / 2);
		    var left = ((tam_pag.w - 300 - 40) / 2);
		  	div_msg.style.top  = (top < 0) ? "0px" : top + "px";
		    div_msg.style.left = (left < 0) ? "0px" : left + "px";
	  }
	  if(navigator.appVersion.search('MSIE 6.0') != -1) redimensionar_mensagem_fix_ie();
}

// redimensiona a mensagem de acordo com o tamanho da pagina
function redimensionar_mensagem_fix_ie() {
	var div_msg = document.getElementById('div_msg');
    if (div_msg != null) {
	    var top = document.documentElement.scrollTop + 300;
		div_msg.style.cssText = 'top:' + top + 'px';
	}
}

// retorna o tamanho da pagina
function get_page_xy() {
	var x, y, w, h, x_scroll;

  // tamanho da pagina
	if (window.innerHeight && window.scrollMaxY) {
      x = window.innerWidth + window.scrollMaxX;
	    y = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight) {
	    x = document.body.scrollWidth;
	    y = document.body.scrollHeight;
	} else {
	    x = document.body.offsetWidth;
	    y = document.body.offsetHeight;
	}
	if (self.innerHeight) {
      w = self.innerWidth;
		  h = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) {
		  w = document.documentElement.clientWidth;
		  h = document.documentElement.clientHeight;
	} else if (document.body) {
		  w = document.body.clientWidth;
		  h = document.body.clientHeight;
	}

  // posicao da scroll
	if (self.pageYOffset)
      x_scroll = self.pageYOffset;
	else if (document.documentElement && document.documentElement.scrollTop)
	    x_scroll = document.documentElement.scrollTop;
	else if (document.body)
	    x_scroll = document.body.scrollTop;
	if (y < h) y = h;
	if (x < w) x = w;

	return { x:x, y:y, w:w, h:h, x_scroll: x_scroll };
}

objIPTCMetadata.prototype.showAbaIPTC = function(numAba) {
    for(i=1; i<=this.numAbas; i++) {
        var id_aba = this.idBox + ".aba_" + i;
        document.getElementById(id_aba).style.display = "none";
  	}
    var id_aba = this.idBox + ".aba_" + numAba;
  	document.getElementById(id_aba).style.display = "block";
    document.getElementById(this.idBox + ".bloco_aba").style.backgroundImage="url(" + url_estatica + "/img/back_abas" + numAba + ".png)";
    // para recarregar a sombra
    this.showIPTC();
    //this.criarLinksAjudaIPTC(this._ajuda);
}

// carrega os objetos (inputs, textareas) que abrigam IPTC em this
objIPTCMetadata.prototype.loadObjetosIPTC = function() {
    for(dado in this.obrigatorios) {
        var id_iptc = this.idBox + '.' + dado;
        this.objetosIPTC[dado] = document.getElementById(id_iptc);
    }
}

objIPTCMetadata.prototype.getKeyIPTC = function(name, size) {
    if(name) {
	    this.nameImagemAtiva = name;
	    this.sizeImagemAtiva = size;
        key = name + size;
    } else {
        key = this.keyImagemAtiva;
    }
    return key;
}

// constroi o dicionario de iptc dos dados que estao no formulario no momento
objIPTCMetadata.prototype.getDadosIPTC = function() {
    var dic = {};
    // variando nos inputs

    for(var item in this.objetosIPTC) {
        var objIPTC = this.objetosIPTC[item];
        var valor = objIPTC.value ? objIPTC.value : objIPTC.innerHTML;
        dic[item] = valor;
    }
    return dic;
}

/** Funcoes Adicionais
objIPTCMetadata.prototype.validarIPTC = function(name, size) {
    var key = this.getKeyIPTC(name, size);
    var metadados = null;
    if(name) metadados = this.tmp_metadados[key];
    if(!metadados) {
        // caso seja da imagem ativa
        if(key == this.keyImagemAtiva) {
            metadados = this.getDadosIPTC();
        } else {
            throw("A chave " + key + " nao foi cadastrada ou nao existe.");
        }
    }
    var retorno = true;
    // validando efetivamente
    for(dado in this.obrigatorios) {
        if(this.obrigatorios[dado]) {
            var objItemFormu = this.objetosIPTC[dado];
            // caso o objeto nao exista
            if(!objItemFormu) {
                throw("O item de formulario " + dado + " nao existe.");
                continue;
            }
            var tipo_class = document.all ? 'className' : 'class';
            var txt_class = objItemFormu.getAttribute(tipo_class);
            if(!metadados[dado]) {
                // fazendo o campo ficar vermelho
                if(txt_class.search(this.classItemErro) == -1)  objItemFormu.setAttribute(tipo_class, txt_class + this.classItemErro);
                retorno = false;
            } else {
                // fazendo o campo voltar ao normal
                objItemFormu.setAttribute(tipo_class, txt_class.replace(this.classItemErro, ''));
            }
        }
    }
    if(!retorno) {
        // tornando ativa a aba onde ocorrem erros
        this.showAbaIPTC(1);
        showBox("Os campos marcados em vermelho são obrigatórios", "erro");
    }
    return retorno;
}
*/
objIPTCMetadata.prototype.preencherFormuIPTC = function(name, size) {
    // verificando se os dados sao os que ja estao no formulario IPTC
//IPTCMetadata.tmp_metadados["GOL.jpg97281"]["id_midia"]
    var key = this.getKeyIPTC(name, size);


    // preenchendo o titulo geral
	/*
    if(!name) name = this.nameImagemAtiva;
    for(var i=1; i<=this.numAbas; i++) {
        var id_titulo_geral = this.idBox + "." + "titulo_geral" + i;
		if(name.length > 26) name = name.substr(0, 23) + '...'
        document.getElementById(id_titulo_geral).innerHTML = name;
    }
	*/
    // preenchendo o formulario com os dados caso nao haja dados, esvazia o form
    var valor = "";

		if (key=="Todas as Imagens"){ this.id_mid=0}       
		
/*		
		if (this.objetosIPTC['status'])
			document.getElementById('status_ativo').selected = 'selected';
		else		
			document.getElementById('status_inativo').selected = 'selected';
		
		
		if (this.objetosIPTC['vender'])
			document.getElementById('vender_ativo').selected = 'selected';
		else			
			document.getElementById('vender_inativo').selected = 'selected';
				
		if (this.objetosIPTC['compartilhar']){
				document.getElementById('compartilhar_ativo').selected = 'selected';
		}else{
			document.getElementById('compartilhar_inativo').selected = 'selected';
		}
	*/	
		for(dado in this.objetosIPTC) {

			if(dado=="id_midia" && key!="Todas as Imagens"){
				this.id_mid=this.tmp_metadados[key][dado];
		
			}
			if(dado=="nomearquivo" && key!="Todas as Imagens"){
				var id_titulo_geral = this.idBox + "." + "titulo_geral" + '1';
				document.getElementById(id_titulo_geral).innerHTML = this.tmp_metadados[key][dado];
			}
			else if(key=="Todas as Imagens" && dado=="nomearquivo"){
				var id_titulo_geral = this.idBox + "." + "titulo_geral" + '1';
				document.getElementById(id_titulo_geral).innerHTML = 'Todas as Imagens';
			}
			
	        if(this.tmp_metadados[key]){
			    
				var valor = this.tmp_metadados[key][dado] ? this.tmp_metadados[key][dado] : "";
				
			}
			
			if(dado == "informacoesarquivo" && key!="Todas as Imagens"){
				if (valor){
				    //pega a primeira linha das informacoes =)
					valor = valor.split("\n")[0];
				}	
			}
			
			if (this.objetosIPTC[dado].tagName.toLowerCase() == 'textarea') {
				this.objetosIPTC[dado].value = "";
			}
			if(this.objetosIPTC[dado].tagName.toLowerCase() == 'select'){
				this.objetosIPTC[dado].selectedIndex = 0;
			}
            //alert(valor); 
			if (key!="Todas as Imagens")
				this.objetosIPTC[dado].value = valor;

		}
		

		
		//Adciona a subcategoria e categoria quando tiver
		if (!this.todos){
			if (this.tmp_metadados[key]['categoria'] && this.tmp_metadados[key]['subcategoria']){
				var objCat = document.getElementById('box_iptc.categoria');
				var optInc = document.createElement('option');
				optInc.setAttribute('value', this.tmp_metadados[key]['categoria']);
				optInc.innerHTML = this.tmp_metadados[key]['categoria'];
				optInc.selected = true;
				objCat.appendChild(optInc);
				document.getElementById('box_iptc.categoria').disabled = true;
				
				var objSca = document.getElementById('box_iptc.subcategoria');
				var optIns = document.createElement('option');
				optIns.setAttribute('value', this.tmp_metadados[key]['subcategoria']);
				optIns.innerHTML = this.tmp_metadados[key]['subcategoria'];
				optIns.selected = true;
				objSca.appendChild(optIns);
				document.getElementById('box_iptc.subcategoria').disabled = true;
				
				/*
				var obj = document.createElement('input');
				obj.setAttribute('id','cat_old');
				obj.setAttribute('value',this.objetosIPTC['categoria']+'/'+this.objetosIPTC['dp_cat_nome']);
				obj.setAttribute('type','hidden');
				document.getElementById('box_iptc.aba_1').appendChild(obj);

				var obj = document.createElement('input');
				obj.setAttribute('id','sca_old');
				obj.setAttribute('value',this.objetosIPTC['subcategoria']+'/'+this.objetosIPTC['dp_sca_nome']);
				obj.setAttribute('type','hidden');
				document.getElementById('box_iptc.aba_1').appendChild(obj);
				*/
			}
		}


}

objIPTCMetadata.prototype.preencherTodosIPTC = function() {
    // preenche os dados de todas as imagens com os dados atuais
    var dados = this.getDadosIPTC();
    for(var item in this.tmp_metadados) {
        for(var i in this.objetosIPTC) {
            if(!this.tmp_metadados[item][i]) this.tmp_metadados[item][i] = dados[i];
        }
    }
}
objIPTCMetadata.prototype.preencherTodosIPTCNotCampos = function() {

	for (key in this.tmp_metadados){
			for(dado in this.temp_metadados) {
				if (this.temp_metadados[dado]){
					this.tmp_metadados[key][dado]=this.temp_metadados[dado];
				}
			}
		}
}
// retira os eventuais erros dos inputs de IPTC
objIPTCMetadata.prototype.limparErrosIPTC = function() {
    for(var item in this.objetosIPTC) {
        var objItemFormu = this.objetosIPTC[item];
        var tipo_class = document.all ? 'className' : 'class';
        var txt_class = objItemFormu.getAttribute(tipo_class);
        // fazendo o campo voltar ao normal
        objItemFormu.setAttribute(tipo_class, txt_class.replace(this.classItemErro, ''));
    }
}

// coloca o thumbnail no local devido
objIPTCMetadata.prototype.getThumbnail = function(name, size) {
    // adiciona os thumbs nas imagens
    for(var i=1; i<=this.numAbas; i++) {
        var id_imagem_thumb = this.idBox + ".thumbnail" + i;
        var url = this.todos ? this.urlImagemTodos : this.urlToGetThumbnail + "?name=" + name + "&size=" + size + "&id_session=" + id_session;
        document.getElementById(id_imagem_thumb).src = url;
    };
};

objIPTCMetadata.prototype.getThumbnailEdit = function(id_mid) {
    for (var i=1; i<=this.numAbas;i++) {
	    var id_imagem_thumb = this.idBox + ".thumbnail" + i;
		var url = this.urlToGetThumbnailEdit + "?id_mid=" + id_mid;
		document.getElementById(id_imagem_thumb).src = url;
	};

	/*
	var id_imagem_thumb = this.idBox + ".thumbnail1";
	var url = this.urlToGetThumbnailEdit + "?id_mid=" + id_mid;
	document.getElementById(id_imagem_thumb).src = url;	
	*/
};

objIPTCMetadata.prototype.rotateImg = function(side) {
	//var id_imagem_thumb = this.idBox + ".thumbnail" + i;
	//var url = this.urlToGetThumbnailEdit + "?id_mid=" + id_mid;
	//document.getElementById(id_imagem_thumb).src = url;
	//alert(this.id_mid);
	var handler = new XMLHandler();
	var xmlreq =  new XMLClient(url_rotate_img);
	xmlreq.addParam('id_img', this.id_mid);
	xmlreq.addParam('side', side);

	handler.onError = function(e) { showBox(e, 'erro'); }
	handler.onProgress = function() {};
	handler.onInit = function() {};
	handler.onLoad = function (xmlStr)
	{
		res = eval(xmlStr);
		if (res[0]['tipo'] == 'ok'){
			var url = IPTCMetadata.urlToGetThumbnailEdit + "?id_mid=" + IPTCMetadata.id_mid;
			document.getElementById('box_iptc.thumbnail1').src = url+'&'+Math.random();			
		}else
			showBox(res[0]['msg'], 'erro');
	}
	xmlreq.query(handler);
};

// retorna verdadeiro ou falso na comparacao dos dados de IPTC
objIPTCMetadata.prototype.compararDadosIPTC = function (dados1, dados2) {
	for(var item in this.obrigatorios) {
	    if(this.obrigatorios[item] && !(dados1[item] && dados2[item])) {
			return false;
		};
		if(dados1[item] != dados2[item]) return false;
	};
	return true;
};

// habilita/desabilita objetos do formulario
objIPTCMetadata.prototype.desabilidarObjetosIPTC = function (desabilitar) {
	for(var item in this.objetosIPTC) {
		this.objetosIPTC[item].disabled = desabilitar;
	};
};

objIPTCMetadata.prototype.mostrarAguardeIPTC = function (mostrar) {
	var mostrar = mostrar ? 'block' : 'none';
    //document.getElementById('aguarde1').style.display = mostrar;
    //document.getElementById('aguarde2').style.display = mostrar;
	document.getElementById('loader').style.display = mostrar;
};

objIPTCMetadata.prototype.criarLinksAjudaIPTC = function (dados) {
    // caso ja existam os dados, nao pesquisa novamente
    if(!dados) {
	    // pesquisando pelo ajax
	    var handler = new XMLHandler();
	    var xmlreq = new XMLClient(this.urlAjuda);
		var dados = null;
	    // setando para ser sincrono
	    xmlreq.setAsync(false);
	    handler.bdoAsync = false;

	    handler.onLoad = function(retorno) {
			dados = JSON.decode(retorno);
	    }
	    // executa a query construída acima
	    xmlreq.query(handler);
	    dados = JSON.decode(xmlreq.oXMLRequest.responseText);
	}
	// inserindo as ajudas
	for(var item in this.objetosIPTC) {
         new JSHint(this.objetosIPTC[item],
		            {'width': 300,
                     'button-close': 'normal',
					 'type': 'help',
					 'shortcut': ['onmousedown']},
					 'Ajuda',
					 dados[item]);
	}
    this._ajuda = dados;
}


objIPTCMetadata.prototype.criarLinksAjudaIPTCEdit = function () {
    // pesquisando pelo ajax
	var handler = new XMLHandler();
	var xmlreq = new XMLClient(this.urlAjuda);
	var dados = null;
	// setando para ser sincrono
	xmlreq.setAsync(false);
	handler.bdoAsync = false;
	handler.onLoad = function(retorno) {
	dados = JSON.decode(retorno);
	}
	// executa a query construída acima
	xmlreq.query(handler);
	dados = JSON.decode(xmlreq.oXMLRequest.responseText);
	// inserindo as ajudas
	for(var item in dados) {
	     var elementoInput = document.getElementById(this.idBox + '.' + item);
         new JSHint(elementoInput,
		            {'width': 300,
                     'button-close': 'normal',
					 'type': 'help',
					 'shortcut': ['onmousedown']},
					 'Ajuda',
					 dados[item]);
	}
}


/*
objIPTCMetadata.prototype.showAdicionarKeywordIPTC = function (sender) {
     //trabalhando a questao das keywords serem um div para aparecer formatacao
     var v_class = document.all ? 'class' : 'className';
     var objKeys = this.objetosIPTC['keywords'];
	 var divKeys = document.getElementById(objKeys.getAttribute('id') + '_div');
     divKeys.style.marginLeft = '119px';
     divKeys.style.display = 'block';
     // ajuda para o usuario
     new JSHint(sender,
	            {'width': 400,
                 'button-close': 'normal',
				 'type': 'help',
				 'hide-time': 8000,
				 'auto-show': true,
				 'shortcut': ['onmousedown']},
				 'Como adicionar uma keyword',
				 'Para adicionar uma keyword você deve ir ao formulário abaixo, escrever a keyword e clicar em adicionar.');
	document.getElementById('box_iptc.adicionar_keywords').style.display = 'block';
	objKeys.style.display = 'none';

	// ajuda com relacao as cores
    var html_legenda = '<table class="legenda">' +
                          '<tr><td><div style="background-color: #3D963D;"></div></td><td><span style="color: #3D963D;">Keyword Aprovada.</span></td></tr>' +
  				          '<tr><td><div style="background-color: #EF3D3D;"></div></td><td><span style="color: #EF3D3D;">Keyword Reprovada.</span></td></tr>' +
     					  '<tr><td><div style="background-color: #3D3DEF;"></div></td><td><span style="color: #3D3DEF;">Keyword Em Aprovação.</span></td></tr>' +
                          '<tr><td><div style="background-color: #000000;"></div></td><td><span style="color: #000000;">Keyword Recém Adicionada.</span></td></tr>' +
					   '</table>';
    new JSHint(document.getElementById('box_iptc.adicionar_keywords'),
	           {'width': 200,
			    'top' : 600,
                'button-close': 'normal',
			    'type': 'help',
				'top' : 413,
			    'auto-show': true},
			    'Legenda:',
				html_legenda);
}

objIPTCMetadata.prototype.hideAdicionarKeywordIPTC = function () {
    var objBox = document.getElementById('box_iptc.adicionar_keywords');
    objBox.style.display = 'none';
	// removendo o hint relacionado a legenda
	var id_hint = objBox.getAttribute('hint');
	var objHint = document.getElementById(id_hint);
	objHint.parentNode.removeChild(objHint);
}

objIPTCMetadata.prototype.adicionarKeywordIPTC = function (sender) {
    var valor = sender.value;
    //verificando se o key ja foi adicionado
    var keys_old = this.tmp_metadados[this.getKeyIPTC()]['keywords'] || " ";
	if(keys_old.search(valor + ';') != -1) {
	    showBox('A keyword "' + valor +  '" já fora adicionada.', 'alert');
		return;
	}
	this.tmp_metadados[this.getKeyIPTC()]['keywords'] = keys_old + valor + ";";
     construindo o span que contera o texto
	var s = document.createElement('li');
	s.setAttribute('title', 'Excluir Keyword');
	s.setAttribute('alt', 'Excluir Keyword');
	s.style.color = sender.getAttribute('color');
	s.onmousedown = new Function("IPTCMetadata.removerKeywordIPTC(this);");
	s.innerHTML = valor;
		wrap.appendChild(img);
    var objDiv = document.getElementById(this.objetosIPTC['keywords'].getAttribute('id') + '_div');
	objDiv.appendChild(s);
	// para recarregar a sombra
	this.showIPTC();
}

objIPTCMetadata.prototype.removerKeywordIPTC = function (sender) {
     removendo a key dos metadados
	var key = sender.innerHTML;
  	var keys_old = this.tmp_metadados[this.getKeyIPTC()]['keywords'];
	var keys_new = keys_old.replace(key + ';', '');
   this.tmp_metadados[this.getKeyIPTC()]['keywords'] = keys_new;
	removendo a key da tela
	sender.parentNode.removeChild(sender);
	// para recarregar a sombra
	this.showIPTC();
}
*/
/*************************************************************
 *************************************************************
 *************************************************************
 *************************************************************
 *************************************************************
 *************************************************************
 *************************************************************
 *************************************************************
 *************************************************************
 *************************************************************
 * PAREI AQUI. QUANDO ADICIONAR OU REMOVER UMA KEY, DEVE-SE
 * MUDAR A POSICAO DA PARTE DE OPCOES DE KEYWORDS DADAS PELO
 * JS PESQUISAKEY
 *************************************************************
 *************************************************************
 *************************************************************
 *************************************************************
 *************************************************************
 *************************************************************
 *************************************************************
 *************************************************************
 *************************************************************
 *************************************************************
 *************************************************************
 *************************************************************
 *************************************************************


 */

