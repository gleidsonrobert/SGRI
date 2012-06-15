//<![CDATA[
//******************************************************************************
// @name:        util.pesquisaKey.py
// @purpose:     Scripts que fazem a atualizacao/edicao de iptc dos diversos 
//               arquivos adicionados.
//
// @example:     new FieldPesquisaKey(document.getElementById('field_nome'), ['onKeyUp'], 'http://teste'); 
// @author:      Ruhan Bidart - ruhan@2xt.com.br
// @created:     16/11/2007
// @depends:     json.js
//******************************************************************************
var FieldPesquisaKey = function(field, evt, url, namevar) {
    // ** Propriedades
    this._field = field;
	this._id_field = null;
	this._evt = evt;		
	this._list = null;
	this._id_list = null;
	this._namevar = namevar;
	this.class_list = 'pesquisaKey';
	this.url = url;
	// inicializando o objeto
	this._setIdField();
	this._createList();		
}

// seta o id do campo (caso nao tenha) e faz sua referencia em this._id_field
FieldPesquisaKey.prototype._setIdField = function() {
    // setando o id do campo
    var id_field = this._field.getAttribute('id');
	if(!id_field) {
		id_field = 'field' + Math.random();
		this._field.setAttribute('id', id_field);
	}
	this._id_field = id_field;			
}

// cria o objeto da lista
FieldPesquisaKey.prototype._createList = function() {
	// Estrutura formada:
	// <div>
	//   <ul>
	//     <li>Item de lista 1</li>
	//     <li>Item de lista 2</li>
	//   </ul>  
	// </div>
	var v_class = document.all ? 'className' : 'class';
	var div = document.createElement('div');
	var ul = document.createElement('ul');
	div.setAttribute(v_class, this.class_list);
	var id_list = 'list' + Math.random();
	div.setAttribute('id', id_list);
	div.appendChild(ul);
	this._list = div;
	this._id_list = id_list;
	// colocando a lista no html
	this._field.parentNode.appendChild(this._list);
	// adicionando os eventos no field	
	for(var i=0; i<this._evt.length; i++)  {		
	    var obj_evt = "document.getElementById('" + this._id_field + "')." + this._evt[i];
		var obj_evt_to_exec = "new Function('" + this._namevar + ".search()');"; 
	    eval(obj_evt + "=" + obj_evt_to_exec);		
	}
}

// efetua a pesquisa
FieldPesquisaKey.prototype.getData = function(param) {
	// @return: [{'valor': 'valor1', 'cor': 'cor1'}, {'valor': 'valor2', 'cor': 'cor2'}]
	
    // enviando por ajax
    var handler = new XMLHandler();    
    var xmlreq = new XMLClient(this.url);
    // setando para ser sincrono
    xmlreq.setAsync(false); 
    handler.bdoAsync = false;   
    // parametros 
    xmlreq.addParam('key', param);           

    handler.onLoad = function(retorno) {
		retorno = JSON.decode(retorno);	
        return retorno;
    } 
    // executa a query construída acima
    xmlreq.query(handler);            
    return JSON.decode(xmlreq.oXMLRequest.responseText);    	
}

// efetua a pesquisa e cria a lista com os dados
FieldPesquisaKey.prototype.search = function() {
	var dados = this.getData(this._field.value);
	if(!dados.length) { 
	    this.hideList();
		return;
	}	 
	this.clearList();
	this.fillList(dados);
	this.setListPosition();
	this.showList();
}

// preenche a lista com os dados
FieldPesquisaKey.prototype.fillList = function(dados) {
	var ul = this._list.childNodes[0];
	for(var i=0; i<dados.length; i++) {
        this._field.removeAttribute('color');
        // tratando a questao de o input sempre ter as configuracoes da primeira palavra na lista
		if(i == 0) {
			var cor = 'black';
			if(trim(dados[0]['valor']) == trim(this._field.value)) cor = this.getColor(dados[0]['cor']);
            this._field.setAttribute('color', cor);			
		}
		var li = document.createElement('li');
        // criando o span que ira entrar no li
		var s = document.createElement('span');		
		s.innerHTML = dados[i]['valor'];
		s.style.color = this.getColor(dados[i]['cor']);
		// adicionando o span ao li
		li.appendChild(s);	
        // acao de setar a cor
        var action1 = "document.getElementById('" + this._id_field + "').setAttribute('color', this.childNodes[0].style.color);";		
		// acao de mudar o value do field
        var action2 = "document.getElementById('" + this._id_field + "').value = this.childNodes[0].innerHTML;";
		// acao de esconder o div da lista
		var action3 = "document.getElementById('" + this._id_list + "').style.display = 'none';"; 
		li.onmousedown = new Function(action1 + action2 + action3);
		ul.appendChild(li);
	}	
}

// limpa os dados da lista
FieldPesquisaKey.prototype.clearList = function() {
	var ul = this._list.childNodes[0];
	ul.innerHTML = '';	
}

// seta a posicao da lista
FieldPesquisaKey.prototype.setListPosition = function(left, top) {
	var left = left || this._field.offsetLeft;
	var top = top || this._field.offsetTop + this._field.offsetHeight;
    this._list.style.width = this._field.offsetWidth + 'px';	
	this._list.style.left = left + 'px';
	this._list.style.top = top + 'px';	
}

// retorna a cor dependendo do id informado
FieldPesquisaKey.prototype.getColor = function(id_color) {
	if(!id_color) return 'black';
	switch(id_color) {
		case 31: 
		    return 'green';
		case 32:
		    return 'red';
		case 33:
		    return 'blue';
		default:
		    return 'black';
	}
}

// mostra a lista
FieldPesquisaKey.prototype.showList = function() {
	this._list.style.display = 'block';	
}

// esconde a lista
FieldPesquisaKey.prototype.hideList = function() {
	this._list.style.display = 'none';	
}

function trim(s) {
	var l = 0; 
	var r = s.length -1;
	while(l < s.length && s[l] == ' ') l++;
	while(r > l && s[r] == ' ') r -= 1;
	return s.substring(l, r+1);
}
//]]>