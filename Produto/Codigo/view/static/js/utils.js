/*****************************************************************
    CTRL utilidades functions 1.0

    Funções diversas utilizadas no sistema
    . Chamada para validação do formulário
    . Aguarde
    . Cookie do div - ajuda, pesquisa, etc
    . Criação de elementos de formulário
*****************************************************************/
var Utils = new Object;
var div_aguarde     = 'div_aguarde'; // id do elemento html para a função aguarde
var div_pesquisa    = 'div_pesquisa'; // id do elemento html para pesquisa
var div_ajuda       = 'div_ajuda'; // id do elemento html para ajuda
var div_erro_header = 'div_erro_header'; //
var div_erro        = 'div_erro'; // id do elemento html para erro
var div_prompt      = 'div_prompt'; // id do elemento html para prompt
var cookie_pesquisa = 'cookie_pesquisa'; // id do cookie da pesquisa
var cookie_ajuda    = 'cookie_ajuda'; // id do cookie da ajuda
var elAguarde       = new Array('input', 'select', 'div'); // elementos que irão ter as funções do div aguarde e que o browser não suporta HTMLElement.prototype

/**
* Chamada para validar os campos dos formulários contidos na página.
* Forma de utilizar: no window.onload da página inserir: "Utils.validaForm();"
by Samuel
*/
Utils.validaForm = function()
{
    if (window.validateForm)
    {
        for (var oForm=0; oForm<document.forms.length; validateForm( document.forms[oForm++] ));

    } else throw "Utils.validaForm() - Para validar o formulário é necessário os módulos \'js.validation.validateElement\', \'js.validation.validateForm\' e os demais includes se necessários.";
};


/**
* converte os atributos de um objeto para parametros GET de uma url
* @param obj(Object): objeto com atributos
*/
Utils.objectToUrlget = function(obj)
{
    var args = "";
    for (var i in obj)
    {
        if (typeof(obj[i]) == 'object')
        {
            for (el in obj[i])
                args += (i + "=" + obj[i][el] + "&");
        } else args += (i + "=" + obj[i] + "&");
    };
    return args;
};


/**
* Busca xml via http
* @param url(String): url do xml
* @param parametros(String): parametros tipo GET ('va1=1&var2=2') para postagem
* @param resposta(Function): Função de retorno do xml
* @param erro(Function): Função de erro do xml (500)
* @param async(Boolean): parametro que indica se a busca pelo xml é sincronizada ou não
*/
Utils.httpGetXml = function(url, parametros, resposta, erro, async, xml)
{
    if (xml == null) xml = true;
    if (async == null) async = true;

    this.xml = xml;
    this.resposta = resposta;
    this.error    = erro;
    this.erro     = "Seu browser não possui recursos suficientes para esta operação.";
    if (! Browser) throw "Utils.httpGetXml - não foi encontrado \'js.utils.Browser\'";
    //if (Browser.isOpera || Browser.isKonqueror){
      //(window.msg ? window.msg:window.alert)(this.erro);
    //}
    //else
     if (window.XMLHttpRequest || window.ActiveXObject) {
        this.xmlhttp =  (window.XMLHttpRequest) ? new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP");
        var self = this;
        this.xmlhttp.onreadystatechange = function() { Utils.httpChangeXml(self); };
        this.xmlhttp.open("POST", url, async); // async=true indica que não vou esperar a resposta do GET
        this.xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        //window.prompt('Get This', url + '?' + Utils.objectToUrlget(parametros));
        try {
          this.xmlhttp.send(Utils.objectToUrlget(parametros));

        } catch(e){

        }

        if (async == false) return (xml ? this.xmlhttp.responseXML : this.xmlhttp.responseText);

    } else (window.msg ? window.msg:window.alert)(this.erro);
};


/**
* Quando o status da consulta de um xml alterar é chamada esta função por padrão defido em Utils.httpGetXml
* @param self(Object): instancia de Utils.httpGetXml
*/
Utils.httpChangeXml = function(self)
{
    if (self.xmlhttp.readyState == 4) // se xmlhttp retorna "loaded"
    {
        if (self.xmlhttp.status == 200)  // status ok
        {
            var xml = self.xmlhttp.responseXML; // retorna um objeto xml
            if (xml && String(xml.firstChild.tagName) != 'parsererror')
            {
                if (self.resposta) new self.resposta(xml); // método para interpretar a resposta do xml.
                else throw "Xml carregado com sucesso, mas sem método para interpretar.";

            } else {
                if (self.error) self.error.doError();
                else throw "A resposta do xmlhttp não é um arquivo xml válido.";
            };

        } else if (self.xmlhttp.status == 500 && self.error && self.error.doError) self.error.doError();
        else throw "Não foi possível carregar o arquivo xml - " + self.xmlhttp.status;
    };
};


/**
* Construtor da funcionalidade aguarde.
* Adiciona aos elementos html a função aguarde que mostra um div no contorno do elemento ou desaparece.
* No ie os elementos que terão a funcionalidade serão adicionado na variável "elAguarde".
*/
Utils.campoAguarde = function()
{
    var mydiv = document.getElementById(div_aguarde);
    window.onbeforeunload = function(){}
    if (window.HTMLElement) HTMLElement.prototype.aguarde = Utils.aguarde; // Gecko
    else { // ie sucks

        for (var el=0; el < elAguarde.length; el++)
        {
            var elS = document.getElementsByTagName(elAguarde[el]);
            for (var i=0; i < elS.length; elS[i++].aguarde = Utils.aguarde);
        };
    };
};


/**
* Função que os elementos html terão para mostrar div em seu contorno, utilizado para actions que demandam mais tempo.
* @param estado(boolean): True para aparecer o div e False para não mostrar.
* @param width(String): Tamanho do div que aparece em cima do elemento.
*/
Utils.aguarde = function(estado, width)
{
    if (estado) {
      var v_d = Utils.aguardeMostraDiv(this, div_aguarde, width);
      Utils.setStyle(v_d,'position','absolute');
      Utils.setStyle(v_d,'border','1px solid #26577A');
      Utils.setDisplay(v_d,'block');
    }
    else {
      document.getElementById(div_aguarde).style.display = 'none';
    }
};


/**
* Modifica a posição do div que irá ficar em cima do elemento.
* @param obj(Object): Elemento que fez a chamada do aguarde.
* @param id(String): Id do elemento html que ficará em cima do elemento que fez a chamada do aguarde.
* @param width(String): Tamanho do div aguarde.
* @return: Elemento html do aguarde.
*/
Utils.aguardeMostraDiv  = function(obj, id, width)
{
    var X = Utils.aguardeFindPosX(obj);
    var Y = Utils.aguardeFindPosY(obj);
    var elShow = document.getElementById(id);
    if (!elShow) throw "Não existe elemento html para mostrar.";
    elShow.style.top = Y + 'px';
    elShow.style.left = X + 'px';
    if (width) elShow.style.width = width+"px";

    return elShow;
};


/**
* Calcula a posição horizontal para o objeto do elemento que faz a chamada do aguarde.
* @param obj(object): Elemento html que faz a chamada do aguarde.
*/
Utils.aguardeFindPosX = function(obj)
{
    var curleft = 0;
    if (obj.offsetParent)
    {
        while (obj.offsetParent)
	{
            curleft += obj.offsetLeft
            obj = obj.offsetParent;
        }
    } else if (obj.x) curleft += obj.x;

    return curleft;
};


/**
* Calcula a posição vertical para o objeto do elemento que faz a chamada do aguarde.
* @param obj(object): Elemento html que faz a chamada do aguarde.
*/
Utils.aguardeFindPosY = function(obj)
{
    var curtop = 0;
    var printstring = '';
    if (obj.offsetParent)
    {
        while (obj.offsetParent)
        {
            curtop += obj.offsetTop
            obj = obj.offsetParent;
        }
    } else if (obj.y) curtop += obj.y;

    return curtop;
};


/**
* Faz busca em um nodo pelos elementos de tagname igual a passada sem recursividade
* @param xml(Object): xml de consulta
* @param name(String): nome da tagname a ser procurada
* ELEMENT_NODE = 1 ie does not have this
*/
Utils.elementGetElementByTagName = function(xml, name)
{
    var ELEMENT_NODE = 1;
    var elem = new Array();
    var els = xml.childNodes;
    for (var i=0; i < els.length; i++)
    {
        if (els[i].nodeType == ELEMENT_NODE && els[i].tagName.toLowerCase() == name.toLowerCase()) elem[elem.length] = els[i];
    };
    return elem;
};


/**
* Verifica o número de caracteres dentro de um textarea.
* @param idField: id do campo textarea.
* @type idField: string
* @param tamanho: Inteiro correspondente ao tamanho dos caracteres.
* @type tamanho: Integer
*/
Utils.elementLenghtTextarea = function(idField, tamanho)
{
    var textarea = document.getElementById(idField);
    if (textarea.value.length > tamanho) textarea.value = textarea.value.substring(0, tamanho);
};


/**
* Cria um objeto input tipo text
* @param type(String): tipo do objeto (text, checkbox, radio)
* @param name(String): atributo name do input
* @param value(String): valor padrão do input
* @param width(String): tamanho do input
* @param float(boolean): se o input somente aceitar valores numéricos ser float. É validado pela validateForm.js
* @param filter(String): se existe algum tipo de filtro para o input ex.: 0-9 aceita somente números. É validado pela validateForm.js
* @param disabled(boolean): se o input será disabled ou nao
* @param onblur(boolean): True para chamada do evento onblur do input
* @param class: Classe do estilo do botao
* @return: elemento html
*/
Utils.elementCreateInput = function(type, name, value, width, numeric, filter, disabled, onblur, Class, id)
{
    var input = document.createElement('input');
    input.setAttribute('type', type);
    input.setAttribute('name', name);

    if (value) input.setAttribute('value', value);
    if (width) input.style.width = width+'px';
    if (disabled) input.setAttribute('disabled', 'disabled');
    if (numeric) input.setAttribute('float', 'float');
    if (filter) input.setAttribute('filter', filter);
    if (numeric || filter) validateElement(input);
    if (Class) input.className = Class;
    if (id) input.setAttribute('id', id);
    if (onblur)
    {
        if (!input.onblur) input.onblur = onblur;
        input.onblur();
    };
    return input;
};


/**
* TODO
*/
Utils.elementCreateSelect = function()
{

};


/**
* Popula o select com dados. Para utilizar a função deve ser inicializada Ex: Utils.elementAtualizaSelect();, depois o elemento select terá a função herdada,
* assim é só chamar a função: [select].atualizaSelect([valores])
* @param valores(Array): da função (atualizaSelect) do elemento select é um array [[value, descricao]].
* @param default: primeiro item do select
* @note: Cuidado ao utilizar com o CTRL_modal.js, para ie ao fechar a janela o valor se perde.
* É necessário criar o Array da janela que chamou o popup. Ex. window.opener.Array ...
*/
Utils.elementAtualizaSelect = function()
{
    var select = function(valores, param, novos, chrTipo)
    {
       this.options.length = 0;
       if (param)
           this.options[this.options.length] = new Option(param[1], param[0]);
       else {
           if (chrTipo=="T") {
               strInicioText  = "Todos";
               strInicioValue = "-1";
           } else {
               strInicioText  = "Selecione";
               strInicioValue = "";
           }

           this.options[this.options.length] = new Option(strInicioText, strInicioValue);
       }

       for (var i=0; i<valores.length; i++)
       {
           this.options[this.options.length] = new Option(valores[i][1], valores[i][0]);
       };

       this.focus();
    };

    if (window.HTMLElement) HTMLElement.prototype.atualizaSelect = select; // Gecko
    else { // ie sucks

        var elS = document.getElementsByTagName('select');
        for (var el=0; el < elS.length; elS[el++].atualizaSelect = select);
    };
};








/**
* Cria elemento html para imagem
* @param src(String): Caminho(url) da imagem.
* @param onclick(function): Função para evento onclick do elemento.
* @return: Elemento html da imagem
*/
Utils.elementCreateImage = function(src, onclick, klass)
{
    var img = document.createElement('img');
    img.src = src;
    if (onclick)
    {
        img.style.cursor = 'pointer';
        img.onclick = onclick;
    };
    if (klass)
    {
        img.className = klass;
        img.setAttribute('class', klass);
    };

    return img;
};


/**
* Cria um elemento html qualquer
* @param name(String): namespace do elemento html
* @param klass(String): string que representa a classe do elemento
* @param atributes(Object): objeto com atributos que serão adicionados ao elemento
*/
Utils.elementCreateElement = function(name, klass, atributes, style)
{
    var el = document.createElement(name);
    if (klass)
    {
        el.className = klass;
        el.setAttribute('class', klass);
    };
    if (atributes)
    {
        for (i in atributes) el.setAttribute(i, atributes[i]);
    };
    if (style)
    {
        for (i in style)
        {
            el.style[i] = style[i];
        };
    };

    return el;
};


/**
* Guarda a posição do cursor no textarea
* @param ftext: object textarea
*/
Utils.elementStoreCaret = function(ftext)
{
    if (ftext.createTextRange) ftext.caretPos = document.selection.createRange().duplicate();
    else if (ftext.selectionStart) ftext.caretPos = ftext.selectionStart;
};


/**
* Insere o valor(key) na posição em que o cursor está.
* param key: valor que será inserido no valor do textarea.
*/
Utils.elementInsereKey = function(key, id)
{
    var obj = document.getElementById(id);
    if (typeof(obj.caretPos) == 'undefined')
         obj.caretPos = 0;

    var caretPos = obj.caretPos;
    if (obj.createTextRange && caretPos.text) caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? key + ' ' : key;
    else obj.value = obj.value.substring(0, caretPos) + key + obj.value.substring(caretPos, obj.value.length);

    document.getElementById('tags').selectedIndex = -1;
    obj.focus();
};


/**
* Arredonda valores
* @param valor(Float): número a ser arredondado
* @param casas(Int): numéro de casas decimais
*/
Utils.elementArredonda = function(valor, casas)
{
    return Math.round(valor*casas)/casas;
};



/**
* Chamada que verifica o display dos div de ajuda e pesquisa na página. A função deve ser chamada no evento onload da página "Utils.cookieDiv()"
*/
Utils.cookieDiv = function(pesquisa, ajuda)
{
if(! (pesquisa == false))
    Utils.cookieShow(div_pesquisa, cookie_pesquisa, Utils.cookieVerifica(cookie_pesquisa));
if(! (ajuda == false))
    Utils.cookieShow(div_ajuda, cookie_ajuda, Utils.cookieVerifica(cookie_ajuda));
};


/**
* Mostra ou esconde um div de acordo com a variável display e cria um cookie com o valor do display
* @param div(String): Id do elemento html que será verificado se existe e o seu display.
* @param Cookie(String): Id do cookie que será criado com o valor do display.
* @param display(String): 'block' ou 'none' - visível ou invisível
*/
Utils.cookieShow = function(div, Cookie, display)
{
    var div = document.getElementById(div);
    if (div)
    {
        var display = ((display) ? display:((div.style.display == 'block') ? 'none':'block'));
        Utils.cookieCriar(Cookie, display);
        div.style.display = display;

    };
};


/**
* Verifica se um cookie existe e retorna seu valor
* @param nome(String): Valor do cookie procurado
* @return: Valor do cookie ou valor padrão
*/
Utils.cookieVerifica = function(nome)
{
    var cookies = document.cookie.split(';');
    for(var i=0; i < cookies.length; i++)
    {
        var Cookie = cookies[i];
        while (Cookie.charAt(0)==' ') Cookie = Cookie.substring(1, Cookie.length);
        if (Cookie.indexOf(nome) == 0) return Cookie.substring(nome.length+1, Cookie.length);
    };
    return 'none';
};


/**
* Cria um cookie
* @param nome(String): Nome do cookie que será criado.
* @param valor(String): Valor do cookie que será criado.
*/
Utils.cookieCriar = function(nome, valor)
{
    var date = new Date();
    date.setTime(date.getTime()+(2*24*60*60*1000));
    var expira = "; expires=" + date.toGMTString();
    document.cookie = nome +"="+ valor + expira +"''; path=/;";
};


/**
* Cria uma interface de exclusão de itens
* @param tabela(String): Id do elemento html referente a tabela
* @param action(String): Atributo do formulário
* @param id_registro(String): Id do registro se não quiser a procura na tabela
* @param msg(String): Texto do div
* @param hidden(Array): Lista de elementos que serão adicionados no form
* @paarm msgbox: Mensagem do box
*/
Utils.formCreateDelInterface = function(tabela, action, id_registro, msg, hidden, msgbox, tipolista)
{
    if (tabela)
        var trs = document.getElementById(tabela).getselect();
    var div_e = document.getElementById(div_erro);
    var div_p = document.getElementById(div_prompt);

    if (trs && trs.length == 0)
    {
        div_e.innerHTML = ((typeof(msgbox) == 'string') ? msgbox:"Selecione algum item na tabela.");
        div_e.style.display = "block";

    } else {

        var form = document.createElement('form');
        form.setAttribute('method', 'post');
        form.setAttribute('action', action);
        form.setAttribute('onsubmit', "Utils.aguardeMostraDiv(document.getElementById(\'bto_cancelar\'), \'"+div_aguarde+"\', \'100\').style.display = \'block\'");
        if (hidden)
            for (var i=0; i<hidden.length; i++) {
                var ipt = Utils.elementCreateElement('input', null, hidden[i]);
                form.appendChild(ipt);
            }
        //Elemento em banco
        //form.appendChild( Utils.elementCreateElement('input', null, {NAME:'id_registro_lista', name:'id_registro_lista', value:(''), type:'hidden'}) );
        if (id_registro)
        {
            if (tipolista == false)
                form.appendChild( Utils.elementCreateElement('input', null, {NAME:'id_registro_lista', name:'id_registro_lista', value:id_registro, type:'hidden'}) );
            else
                form.appendChild( Utils.elementCreateElement('input', null, {NAME:'id_registro_lista', name:'id_registro_lista', value:id_registro, type:'hidden'}) );

        } else for (var i=0; i<trs.length; i++) form.appendChild( Utils.elementCreateElement('input', null, {NAME:'id_registro_lista', name:'id_registro_lista', value:(tabela ? trs[i].id:id_registro), type:'hidden'}) );

        var strong  = document.createElement('strong');
        var br      = document.createElement('br');
        var div     = document.createElement('div');
        var input_c = Utils.elementCreateElement('input', 'botao', {value:'Cancelar', type:'button', id:'bto_cancelar'});   // Utils.elementCreateInput('button', '', ' Cancelar ', null, null, null, null, null, 'botao', 'bto_cancelar');
        var input_s = Utils.elementCreateElement('input', 'botao', {value:'OK', type:'submit'}); // Utils.elementCreateInput('submit', '', '  OK  ', null, null, null, null, 'botao', 'botao');
        input_s.setAttribute('value', 'OK');
        input_c.setAttribute('onclick', "document.getElementById(div_prompt).style.display = \'none\';");

        var msgTmp = "Deseja realmente excluir "+ (tabela ? trs.length:'1') +" item(ns)?";
        var msg = (msg ? msg : msgTmp);

        strong.appendChild(document.createTextNode(msg));
        div.setAttribute('align', 'right');

        form.appendChild(strong);
        form.appendChild(br);

        div.appendChild(input_c);
        div.appendChild(document.createTextNode('  '));

        div.appendChild(input_s);
        form.appendChild(div);

        el = document.createElement('el');
        el.appendChild(form);

        div_p.innerHTML = "";
        div_p.innerHTML = el.innerHTML;
        div_e.style.display = "none";
        div_p.style.display = 'block';
        window.scrollTo(0, 0);

        return form;
    };
};


/**
* Insere uma mensagem no div de erro da página. As mensagems podem ser passadas sem concatenar que a função já trata.
*/
Utils.formErrorInterface = function()
{
    args = Utils.formErrorInterface.arguments;
    div = document.getElementById(div_erro);

    if (args.length != 0)
    {
        var txt = "";
        for (var i=0; i<args.length; txt += (args[i++]));
        div.innerHTML = txt;
        div.style.display = "block";
        window.scrollTo(0, 0);
    };

};


/**
 **
*/
Utils.Confirmacao = function(AFunctionOK, APrompt)
{
    Utils.esconderSelects(true)

	window.scrollTo(0, 0);
	var div_e = document.getElementById(div_erro);
	var div_p = document.getElementById(div_prompt);
	var form = document.createElement('form');
	var strong  = document.createElement('strong');
	var br      = document.createElement('br');
	var div     = document.createElement('div');
	var input_s = Utils.elementCreateElement('input', 'btn_sim', {value:'', type:'button', id:'bto_confirmar'});
	var input_c = Utils.elementCreateElement('input', 'btn_nao', {value:'', type:'button', id:'bto_cancelar'});

	input_s.setAttribute('value', '');
	input_c.setAttribute('onclick', "document.getElementById(div_prompt).style.display = 'none';if (document.getElementById('div_fora') != null) document.body.removeChild(document.getElementById('div_fora'));Utils.esconderSelects(false);");
	input_s.setAttribute('onclick', AFunctionOK);
    //input_s.onmousedown = new Function(AFunctionOK);
	input_s.setAttribute('onmouseup', "document.getElementById(div_prompt).style.display = 'none';if (document.getElementById('div_fora') != null) document.body.removeChild(document.getElementById('div_fora'));Utils.esconderSelects(false);" + AFunctionOK)

	var msgTmp = "Confirmação?";
	var msg = (APrompt ? APrompt : msgTmp);

	strong.appendChild(document.createTextNode(msg));
	div.setAttribute('class', 'div_confirma_nova');
	form.appendChild(strong);
	form.appendChild(br);

	div.appendChild(document.createElement('br'));
	div.appendChild(input_s);
	div.appendChild(document.createTextNode('  '));
	div.appendChild(input_c);

	form.appendChild(div);

	el = document.createElement('el');
	el.appendChild(form);

	div_p.innerHTML = "";
	div_p.innerHTML = el.innerHTML;

	Utils.displayNone(div_e);
	Utils.displayBlock(div_p);

	//Utils.displayBlock(document.getElementById(div_erro_header));
	//div_e.style.display = "none";
	//div_p.style.display = 'block';

	var tam_pag = tamPage();

	var top  = tam_pag.xScrool + ((tam_pag.h - 90 - 26) / 2);
	var left = ((tam_pag.x - 300 - 40) / 2);

	div_p.style.top  = (top < 0) ? "0px" : top + "px";
	div_p.style.left = (left < 0) ? "0px" : left + "px";

	var div_fora = document.createElement('div');

	div_fora.className    = 'fora';
	div_fora.id           = 'div_fora';
	div_fora.style.height = (tam_pag.y + 'px');
	div_fora.style.zIndex = '50000';

	div_p.style.zIndex = '50001';

	document.body.appendChild(div_fora);

//	window.scrollTo(0, 0);

	return form;
};

Utils.esconderSelects = function(esconder) {
    var esconder = esconder ? 'hidden' : 'visible';
	// "escondendo" os selects
    if(document.all) {
	    var selects = document.getElementsByTagName('select');
	    for(var i=0; i<selects.length; i++) {
    		selects[i].style.visibility = esconder;
	    }
	}
}

Utils.displayNone = function(el){
  if(el!=null){
    if(el.style.setProperty){ // If DOM level 2 supported, the NS 6 way
      el.style.setProperty("display","None","");
    }
    if(el.style.setAttribute){		// If DOM level 2 supported, the IE 6 way
      el.style.setAttribute("display", "None");//!important
    }
    // Else this browser has very limited DOM support. Try setting the attribute directly.
    el.style.display = "None"; // Works on Opera 6 //!important
  }
}


Utils.displayBlock = function(el){
  if(el!=null){
    if(el.style.setProperty){ // If DOM level 2 supported, the NS 6 way
      el.style.setProperty("display","Block","");
    }
    if(el.style.setAttribute){		// If DOM level 2 supported, the IE 6 way
      el.style.setAttribute("display", "Block");//!important
    }
    el.style.display = "Block"; // Works on Opera 6 //!important
  }
}

Utils.setDisabled = function(el,disabled){
  if(disabled){ var s_disabled = 'disabled';}
  else { var s_enabled = '';}
  if(el!=null){
    if(el.setProperty){ // If DOM level 2 supported, the NS 6 way
      el.setProperty("disabled",s_enabled);
    }
    if(el.setAttribute){		// If DOM level 2 supported, the IE 6 way
      el.setAttribute("disabled", s_enabled);
    }
    el.disabled = s_enabled; // Works on Opera 6 //!important
  }
}

Utils.setDisplay = function(el,display){
  if(el!=null){
    if(el.style.setProperty){ // If DOM level 2 supported, the NS 6 way
      el.style.setProperty("display",display,"");
    }
    if(el.style.setAttribute){		// If DOM level 2 supported, the IE 6 way
      el.style.setAttribute("display", display);//!important
    }
    // Else this browser has very limited DOM support. Try setting the attribute directly.
    el.style.display = display; // Works on Opera 6 //!important
  }
}

Utils.setStyle = function(el,style,value){
  if(el!=null){
    if(el.style.setProperty){ // If DOM level 2 supported, the NS 6 way
      el.style.setProperty(style,value,"");
    }
    if(el.style.setAttribute){		// If DOM level 2 supported, the IE 6 way
      el.style.setAttribute(style, value);//!important
    }
    // Else this browser has very limited DOM support. Try setting the attribute directly.
    eval('el.style.'+style+' = value;'); // Works on Opera 6 //!important
  }
}

Utils.setStyleBorder = function(el,border){
  if(el!=null){
    if(el.style.setProperty){ // If DOM level 2 supported, the NS 6 way
      el.style.setProperty("border",border,"");
    }
    if(el.style.setAttribute){		// If DOM level 2 supported, the IE 6 way
      el.style.setAttribute("border", border);//!important
    }
    // Else this browser has very limited DOM support. Try setting the attribute directly.
    el.style.border = border; // Works on Opera 6 //!important
  }
}

Utils.setStyleMarginLeft = function(el,MarginLeft){
  if(el!=null){
    if(el.style.setProperty){ // If DOM level 2 supported, the NS 6 way
      el.style.setProperty("margin-left",MarginLeft,"");
    }
    if(el.style.setAttribute){		// If DOM level 2 supported, the IE 6 way
      el.style.setAttribute("margin-left", MarginLeft);//!important
    }
    // Else this browser has very limited DOM support. Try setting the attribute directly.
    el.style.marginLeft = MarginLeft; // Works on Opera 6 //!important
  }
}


Utils.setInnerHTML = function(el,innerHTML){
  if(el!=null){
    el.innerHTML = innerHTML;
    Utils.displayBlock(el);
  }
}

Utils.counterUpdate = function(opt_countedTextBox, opt_countBody, opt_maxSize) {
  var countedTextBox = opt_countedTextBox ?
    opt_countedTextBox : "countedTextBox";
  var countBody = opt_countBody ? opt_countBody : "countBody";
  var maxSize = opt_maxSize ? opt_maxSize : 1024;

  var field = document.getElementById(countedTextBox);
  if (field && field.value.length >= maxSize) {
    field.value = field.value.substring(0, maxSize);
  }
  var txtField = document.getElementById(countBody);
  if (txtField) {
    txtField.innerHTML = field.value.length;
  }
}

function tamPage()
{
	var x, y, w, h, xScrool;

	if (window.innerHeight && window.scrollMaxY)
	{
		x = document.body.scrollWidth;
		y = window.innerHeight + window.scrollMaxY;
	}
	else if (document.body.scrollHeight > document.body.offsetHeight)
	{
		x = document.body.scrollWidth;
		y = document.body.scrollHeight;
	}
	else
	{
		x = document.body.offsetWidth;
		y = document.body.offsetHeight;
	}

	if (self.innerHeight)
	{
		w = self.innerWidth;
		h = self.innerHeight;
	}
	else if (document.documentElement && document.documentElement.clientHeight)
	{
		w = document.documentElement.clientWidth;
		h = document.documentElement.clientHeight;
	}
	else if (document.body)
	{
		w = document.body.clientWidth;
		h = document.body.clientHeight;
	}

	if (self.pageYOffset)
		xScrool = self.pageYOffset;
	else if (document.documentElement && document.documentElement.scrollTop)
		xScrool = document.documentElement.scrollTop;
	else if (document.body)
		xScrool = document.body.scrollTop;

	if (y < h)
		y = h;

	if (x < w)
		x = w;

	return { x:x, y:y, w:w, h:h, xScrool:xScrool };
}

document.write("<style>div.fora{background: #000000; width: 100%; left: 0; top: 0; position: absolute; z-index: 40000; filter: alpha(opacity=40); -moz-opacity: 0.4; opacity: 0.4; }</style>");
