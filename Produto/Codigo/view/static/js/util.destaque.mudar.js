/*<![CDATA[*/
//******************************************************************************
// @name:        util.destaque.mudar.js
// @purpose:     script utilizado para fazer a mudanca de destaque do site.
//
//
// @author:      Ruhan Bidart - ruhan@2xt.com.br
// @created:     13/02/2008
// @example:     new MudaDestaque('id_do_meu_elemento', {'timeout' : 5000, 
//              'efeito': 50, 'auto-iniciar' : true})
// @obs.:        1) use apenas 1 por p?na, caso queira usar 2 na mesma p?na, 
//                  contate o autor. =)
//               2) imagens inseridas no div em questao nao devem conter o 
//                  atributo src, o mesmo deve ser inserido em outro, chamado 
//                  imagem.  
//******************************************************************************
var MudaDestaque = function(e_pai, propriedades) {
    MudaDestaque.instance = this;
    MudaDestaque._imagem_atual = null;
    // apanhando o pai dos elementos
    if(typeof e_pai == 'string') this._pai = document.getElementById(e_pai);
    else this._pai = e_pai;
    // ** imagem que sera mostrada no carregamento das imagens 
    // (coloque a mesma imagem no html display: none;)
   	this.img_tmp = '/static/img/destaque_aguarde.gif'
    this._timeout = propriedades['timeout'];
    this._efeito = propriedades['efeito'];    
    this.length = this._pai.childNodes.length; // quantidade de objetos  
	//se nao existir imagens
	if (this.length < 2)
			return false;
    this.atual = -1; // objeto atual
    // objeto de timeout
    this._o_timeout = null;
    this._o_efeito_timeout = null;
    // corrige bugs iniciais dos navegadores
    this._fix();
    this._extend_methods();    
    if(propriedades['auto-iniciar']) {
        this.iniciar();
    }
    MudaDestaque.instance = this;
}

MudaDestaque.imagens = {};

// funcao de inicializacao
MudaDestaque.prototype.iniciar = function() {
    MudaDestaque._temporizar();
}

// muda o destaque 
MudaDestaque.prototype.mudar = function(index) {
    this._esconder_todos();
    this._pai.childNodes[index].mostrar();
}


MudaDestaque.prototype._esconder_todos = function() {
    for(var i=0; i<this.length; i++) {
        this._pai.childNodes[i].style.display = 'none';
    }
}

// para a mudanca automatica
MudaDestaque.prototype.parar = function() {
    if(this._o_timeout) clearTimeout(this._o_timeout);
    else return;
    this._o_timeout = null;
}

// extende aos objetos filhos os metodos get/set opacity
MudaDestaque.prototype._extend_methods = function() {
    for(var i=0; i<this.length; i++) {
        with(this._pai) {
            childNodes[i]['setOpacity'] = MudaDestaque._set_opacity;
            childNodes[i]['getOpacity'] = MudaDestaque._get_opacity; 
            childNodes[i]['mostrar'] = MudaDestaque.mostrar;
            childNodes[i]['carregarImagens'] = MudaDestaque.carregar_imagens;        
            childNodes[i]['efeito'] = MudaDestaque.efeito;                    
        }
    }
}

MudaDestaque.prototype._fix = function() {
    // IE
    if(document.all) return;
    // FF
    var el = document.createElement('span');
    // corrige bug relacionado ?riacao de TextNode's pelo FF
    for(var i=0; i<this.length; i++) {   
        if(this._pai.childNodes[i] && this._pai.childNodes[i].tagName) el.appendChild(this._pai.childNodes[i]);
    }
    this._pai.innerHTML = el.innerHTML;
    this.length = this._pai.childNodes.length;
}

// vai para o item anterior
MudaDestaque.anterior = function() {
    var instance = MudaDestaque.instance;
    var index = null;
    
    if(instance.atual == 0) {
        index = instance.length-1; 
        instance.atual = instance.length-1; 
    } else index = --instance.atual;        

    instance.parar();
    instance.mudar(index);   
}

// vai para o proximo item
MudaDestaque.proximo = function() {
    var instance = MudaDestaque.instance;
    var index = null;
    
    if(instance.atual == instance.length-1) { 
        index = 0;
        instance.atual = 0;
    } else index = ++instance.atual;
    instance.parar();
    instance.mudar(index);
}

//vai para o item escolhido
MudaDestaque.mudar = function(posicao) {
    var instance = MudaDestaque.instance;
	
    instance.parar();
    instance.mudar(posicao);   
}

// funcao recursiva para fazer o timeout
MudaDestaque._temporizar = function() { 
    var instance = MudaDestaque.instance;
    var index = null;

    if(instance.atual == instance.length-1) { 
        index = 0;
        instance.atual = 0;
    } else index = ++instance.atual;    
    instance.mudar(index);
    instance._o_timeout = setTimeout('MudaDestaque._temporizar()', instance._timeout);    
}

// retorna a opacidade do elemento
MudaDestaque._get_opacity = function() {
    var opacity;
    if (opacity = this.style.opacity) return parseFloat(opacity);
    if ( opacity = (this.style.filter || '').match(/alpha\(opacity=(.*)\)/) )
        if (opacity[1]) return parseFloat(opacity[1]) / 100;
    return 1.0;
}

// seta a opacidade do elemento
MudaDestaque._set_opacity = function(value) {
    if (value == 1) {
        this.style.opacity = (/Gecko/.test(navigator.userAgent) && !/Konqueror|Safari|KHTML/.test(navigator.userAgent) ? 0.999999 : null);
        if (/MSIE/.test(navigator.userAgent))
            this.style.filter = this.style.filter.replace(/alpha\([^\)]*\)/gi,'');
    } else {
        if (value < 0.00001) value = 0;
        this.style.opacity =  value;
        if (/MSIE/.test(navigator.userAgent))
            this.style.filter = this.style.filter.replace(/alpha\([^\)]*\)/gi,'') + 'alpha(opacity='+value*100+')';
    }
}

// mostra o objeto
MudaDestaque.mostrar = function() {
    this.carregarImagens();
    this.style.display = 'block';
    if(MudaDestaque.instance._efeito) {
        this.setOpacity(0);
        this.efeito(this, true);
    }
}

// efeito com opacidade
MudaDestaque.efeito = function(aparecer) {
    MudaDestaque.o_para_efeito = this;
    // ao aparecer
    if(aparecer) {
        op = this.getOpacity();
        op += document.all ? 0.1 : 0.04;
        this.setOpacity(op);            

        // verificando se ira continuar com o efeito
        if(op >= 1) clearTimeout(MudaDestaque.instance._o_efeito_timeout);
        else MudaDestaque.instance._o_efeito_timeout = setTimeout('MudaDestaque.o_para_efeito.efeito(true)', MudaDestaque.instance._efeito);
    // ao desaparecer
    } else {
        op = this.getOpacity();
        op -= 0.1;
        this.setOpacity(op);            

        // verificando se ira continuar com o efeito
        if(op <= 0) clearTimeout(MudaDestaque.instance._o_efeito_timeout);
        else MudaDestaque.instance._o_efeito_timeout = setTimeout('MudaDestaque.o_para_efeito.efeito(false)', MudaDestaque.instance._efeito);
    }
}

// carrega as imagens de um objeto destaque
MudaDestaque.carregar_imagens = function() {
    // apanhando os elementos
    var instance = MudaDestaque.instance;
    var l_e_img = this.getElementsByTagName('img');
    var l_o_img = [];
    MudaDestaque.imagens[instance.atual] = [];

    // variando nas imagens
    for(var i=0; i<l_e_img.length; i++) {
        var new_img = new Image();
        var img = l_e_img[i];
        // caso nao seja uma imagem a ser carregada
        if(!img.getAttribute('imagem')) continue;
        // executa o codigo apenas se imagem nao estiver carregada
        if(!img.getAttribute('carregada')) {
            img.src = MudaDestaque.instance.img_tmp;

            MudaDestaque.imagens[instance.atual].push(img);   
            // para o amado Firefox, que segue os padroes W3C corretamente =)
            if(!document.all) new_img.onload = MudaDestaque.mostrar_imagem;
            // carregando a imagem em outro objeto
            new_img.src = img.getAttribute('imagem');
            new_img.setAttribute('index', instance.atual);        
            new_img.setAttribute('ordem', i);
             // devido ao IE 6 nao tratar o onload corretamente
            if(document.all) {
                new_img.simulate_onload = MudaDestaque.simulate_onload;
                new_img.simulate_onload();
            }
            new_img.onload = MudaDestaque.mostrar_imagem;

            // armazenando nas imagens de load
            
            l_o_img.push(new_img);
        }  
    }
}

// callback da funcao onload da imagem, para trocar seu src
MudaDestaque.mostrar_imagem = function(sender){
    if(!sender || sender.initEvent) sender = this;
    var index = parseInt(sender.getAttribute('index'));
    var ordem = parseInt(sender.getAttribute('ordem'));

    // atributos da imagem 'original'
    var img = MudaDestaque.imagens[index][ordem];
    img.src = sender.src;
    img.setAttribute('carregada', 'carregada');
}

// simula o onload para o IE 7, onde o onload nao e tratado corretamente
MudaDestaque.simulate_onload = function() {
    MudaDestaque._imagem_atual = this;
    if(this.complete) {
        MudaDestaque.mostrar_imagem(this)
    } else {
        setTimeout("MudaDestaque._imagem_atual.simulate_onload()", 250);
    }    
}

/*]]>*/
