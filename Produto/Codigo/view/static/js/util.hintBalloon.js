//<![CDATA[
//******************************************************************************
// @name:        util.hintBalloon.js
// @purpose:     implementa uma maneira de se usar hint sem ter que usar 
//               bibliotecas pesadas como scriptaculous + prototype 
//
// @example:     <span onClick="new JSHint(this, 
//                 {
//                  'shortcut': ['onMouseMove', 'onClick'], // cria um botao antes do objeto para se acessar as informacoes (passa-se qualquer tipo de envento de mouse em uma lista) 
//                  'pointer-position' : 'left', // para qual lado o pointer "< ou >" vai apontar
//                  'width': 400, // width estatico do hint
//		   		    'height': 400, // height estatico do hint
//				    #TODO'auto-hide': true, // caso queira que o hint se esconda automaticamente
//				    'hide-time': 3000, // caso queira que o hint se esconda automaticamente depois de 3 segundos
//                  'button-close': 'image' // tipo do botao ('image' - para imagem, 'normal' - para link simples, false - para nao haver botao [padrao])
//                  'type': 'help', // tipo da imagem que aparecera 'help', 'alert', 'stop', '' [padrao nenhum] 
//                  }, 
//				 'Titulo', 'Conteudo')"/>
// @author:      Ruhan Bidart - ruhan@2xt.com.br
// @created:     13/11/2007
//******************************************************************************
var prop = null;
var JSHint = function(sender, properties, title, content) {
    this._sender = sender;
	this._properties = properties || prop;
	this.title = title || "";
	this.content = content || "";
	this.create();
}
 
 JSHint.prototype.create = function() {
     this._id_reference = 'hint' + Math.random();
     id_sender = this._sender.getAttribute('id'); 
	 if(!id_sender) {
	     id_sender = 'sender' + Math.random();
		 this._sender.setAttribute('id', id_sender);
	 } 
     this._id_sender = id_sender;
	 // verificando se o hint ja foi chamado
	 var old_hint = this._sender.getAttribute('hint');
	 // destruindo o antigo hint para nao conflitar
	 if(old_hint) this._sender.parentNode.removeChild(document.getElementById(old_hint));
	 this._sender.removeAttribute('hint');
	 this._sender.setAttribute('hint', this._id_reference)      
	 this.createHTML(); 	 	
	 // removendo o atalho antigo  
	 var shortcut = this._sender.getAttribute('shortcut');
	 if(shortcut) { 
          this._sender.removeAttribute('shortcut');
	      this._sender.parentNode.removeChild(document.getElementById(shortcut));
	 }	 
     // criando o "atalho"	 
	 if(this._properties['shortcut']) this.createShortcut();	 
 }

 JSHint.prototype.createHTML = function() {
 	 var v_class = document.all ? 'className' : 'class';
     var hint = document.createElement('span');
	 hint.style.display = 'none';
     hint.setAttribute(v_class, 'hint') 
	 var pointer_position = this._properties['pointer-position'] || 'left';
	 // criando o botao fechar 
	 var button_close = this._properties['button-close'];
	 if(button_close) {
	 	 var b_close = document.createElement('span');
	     b_close.setAttribute(v_class, 'hint-close-' + button_close);		 
         b_close_dif = 0;
	     if(button_close == 'image') { 
		     b_close.setAttribute('title', 'Fechar');
		     b_close.setAttribute('alt', 'Fechar');			 
		 } else if(button_close == 'normal') {
		 	 b_close_dif = -28;
			 b_close.innerHTML = 'Fechar';
		 }
         b_close.onmousedown = new Function("document.getElementById('" + this._id_reference + "').style.display = 'none'"); 
	     hint.appendChild(b_close);
	 }	
	 // colocando a imagem do tipo
	 var type = this._properties['type'];
	 if(type) {
	 	var i_type = document.createElement('span');
	    i_type.setAttribute(v_class, 'hint-type-' + type)
		hint.appendChild(i_type);	
	 }
	 // criando o titulo
     if(this.title) {
         var title = document.createElement('span');
	     title.innerHTML = this.title;
		 title.setAttribute(v_class, 'hint-title');	 
		 hint.appendChild(title);
		 var br = document.createElement('br');
		 hint.appendChild(br);
	 }
	 // criando o conteudo
	 if(this.content) {
         var content = document.createElement('span');		 
	     content.innerHTML = this.content;
		 content.setAttribute(v_class, 'hint-content');
		 hint.appendChild(content);	 	
	 }
	 // colocando o pointer
	 var pointer = document.createElement('span');
	 pointer.innerHTML = '&nbsp;';	 
	 hint.appendChild(pointer);    
	 
	 // ** definindo as propriedades do hint
     // com relacao ao tamanho
	 var width = this._properties['width'] || ""; 
	 var height = this._properties['height'] || "";
     // arrumando a posicao do pointer
	 if(width && pointer_position == 'right') pointer.style.left = width + 24 + 'px';
     hint.style.width = width + 'px';
	 hint.style.height = height + 'px';
     
     // com relacao a posicao	 
	 var left = this._properties['left'] || "";
	 var top = this._properties['top'] || "";
     // faz a posicao relativa ao objeto chamador
	 var w = width;
 	 if(!(left && top)) {
         if(parseInt(window.screen.availWidth / (this._sender.offsetLeft + this._sender.offsetWidth)) > 1) {
		     // pointer para a esquerda
	         pointer.setAttribute(v_class, 'hint-pointer-left');
			 left = left || (this._sender.offsetLeft + this._sender.offsetWidth + 20);
			 top = top || this._sender.offsetTop;	  
		 } else {
		 	 // pointer para a direita		 
	         pointer.setAttribute(v_class, 'hint-pointer-right');
             w = hint.clientWidth || width || 0;
			 // arrumando a posicao do pointer
	         pointer.style.left = w + 24 + 'px';			 
			 left = left || (this._sender.offsetLeft - w - 40);
			 top = top || (this._sender.offsetTop);  			 
		 }  	                     	 	
	 } else {
	 	 // posicao customizada
	     pointer.setAttribute(v_class, 'hint-pointer-' + pointer_position);	 	 	
	 }	   	 
	 // posicionando o botao de fechar	 
	 b_close.style.left = w + b_close_dif + 5 + 'px';
	 // setando a posicao do hint
     hint.style.left = left + 'px';
	 hint.style.top = top + 'px';		 
	 hint.setAttribute('id', this._id_reference);	 
	 this._left = left;
	 this._top = top;
     /* TODO fazendo o hint ser auto-hide
	 if(!this._properties['hide-time'] && this._properties['auto-hide']) {
	 	 var mouseout = "setTimeout(\"document.getElementById('" + this._id_reference + "').style.display = 'none'\", 900)";		  
         hint.onmouseout = new Function("alert('maria')");
	 } 
	 */
	 this._sender.parentNode.appendChild(hint);	 
     this._reference = hint;	
	 if(this._properties['auto-show']) this.show();	 
 }
 
 JSHint.prototype.createShortcut = function() {
    var v_class = document.all ? 'className' : 'class';
	var id_shortcut = 'shortcut' + Math.random();
 	var shortcut = document.createElement('span');
	shortcut.setAttribute('id', id_shortcut);
	shortcut.setAttribute(v_class, 'hint-bt-info');
	var evts = this._properties['shortcut'];
	if(typeof evts == 'object'){
		for(var i=0; i<evts.length; i++) {
			var evt = evts[i];			
            prop = this._properties;
			prop['auto-show'] = true;
            var evt_to_exec = "new JSHint(document.getElementById('" + this._id_sender + "')," + null + ", '" + this.title + "', '" + this.content + "')";
			eval("shortcut." + evt + " = new Function(\"" + evt_to_exec + "\");")				
		}
	} else {
		  prop = this._properties;
		  prop['auto-show'] = true;		  
          var evt_to_exec = "new JSHint(document.getElementById('" + this._id_sender + "')," + null + ", '" + this.title + "', '" + this.content + "')";
 	      eval("shortcut." + evts + " = new Function(\"" + evt_to_exec + "\");")		
	}
	this._sender.setAttribute('shortcut', id_shortcut);
	shortcut.style.left = this._left + 'px';
	shortcut.style.top = this._top + 'px';	 
	this._sender.parentNode.appendChild(shortcut);
 }
 
 JSHint.prototype.hide = function() {
    this._referente.style.display = 'none';    
 }
 
 JSHint.prototype.show = function(time) {
    var time = time || this._properties['hide-time'] || false;
    this._reference.style.display = 'block';
	if(time) {
		if(this._timeout) clearTimeout(this._timeout); 
	    this._timeout = setTimeout("document.getElementById('" + this._id_reference + "').style.display = 'none'", time); 
	}
 }
//]]>