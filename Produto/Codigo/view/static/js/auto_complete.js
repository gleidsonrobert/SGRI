//<![CDATA[
//******************************************************************************
// @name:         auto_complete.js
// @purpose:     scripts que fazem uma busca por string dentro de um array, exibindo um auto complete.
// @params:      campo: id do campo que irá enviar o valor.
//		      lista: lista de busca.
//		      evento: tecla digitada.
//		      div_id: id da div com "<li>" que exibirá os resultados da busca.
//		      cor: cor da fonte. Formato: #002200
//		      cor_selec: cor da fonte quando selecionado.
//		      cor_fundo: cor de fundo.
// @depends:     binarysearch.js, autocomplete.css
// @author:       Matheus Ramos - matheus.rfernandes@gmail.com
// @created:     27/08/2008
//******************************************************************************
//]]>
var objAutoComp = function(campo, lista, div, cor, cor_select, cor_fundo) {
	this.campo = campo;
	this.lista = lista;
	this.div_result = div;
	this.cor = cor;
	this.cor_select = cor_select;
	this.cor_fundo = cor_fundo;
	this.IE = document.all;
};


objAutoComp.prototype.capturaEvento = function (e) {
	/* var e = this.evento; */
	var campo = document.getElementById(this.campo);
	
	var KeyCode = e.which ? e.which : e.keyCode;
	
	if ((KeyCode == 40) || (KeyCode == 38) || (KeyCode == 13)){
		this.navegaDiv(KeyCode);
	}else{
		this.montaDiv(campo.value);
	}
	if (KeyCode==27 || KeyCode==9) document.getElementById(this.div_result).style.display = 'none';	
};


objAutoComp.prototype.navegaDiv = function(key) {
		var div = document.getElementById(this.div_result);
		obj_li = div.getElementsByTagName('li');

		if (this.IE)
			/*color = '#666666'; */
			color = this.cor /*cor*/
		else
			/* color = 'rgb(102, 102, 102)'; */
			color = this.HexToRGB(this.cor); /*cor*/
		
		if (key == 40){
			for (i=0;i<obj_li.length;i++){
					var primeiro=true;
					/** Se encontrar algum ja colorido, colore o proximo **/
					if (obj_li[i].style.backgroundColor == color){
						primeiro=false;
						obj_li[i].style.backgroundColor = this.cor_fundo; /*cor de fundo*/
						obj_li[i].style.color = this.cor; /*cor*/
						
						if (i < obj_li.length-1){
							obj_li[i+1].style.backgroundColor = this.cor; /*cor*/
							obj_li[i+1].style.color = this.cor_select; /*cor selecionada*/
						}
						break;
					}
			}
			if (primeiro) {
			 document.getElementById('res_0').style.color = this.cor_select; /*cor selecionada*/
			 document.getElementById('res_0').style.backgroundColor = this.cor; /*cor*/
			}
		}else if (key == 38){
			for (i=0;i<obj_li.length;i++){
					var primeiro=true;
					/** Se encontrar algum ja colorido, colore o anterior **/
					if (obj_li[i].style.backgroundColor == color){
						primeiro=false;
						obj_li[i].style.backgroundColor = this.cor_fundo; /*cor de fundo*/
						obj_li[i].style.color = this.cor; /*cor*/
						
						if (i != 0){
						    obj_li[i-1].style.backgroundColor = this.cor; /*cor*/
						    obj_li[i-1].style.color = this.cor_select; /*cor selecionada*/
						}
						break;
					}
			}
			var num = obj_li.length-1;
			var res_id = 'res_' + num.toString();
			if (primeiro) {
				document.getElementById(res_id).style.backgroundColor = this.cor; /*cor*/
				document.getElementById(res_id).style.color = this.cor_select; /*cor selecionada*/
			}
			
		}else if (key == 13){
			for (i=0;i<obj_li.length;i++){
					if (obj_li[i].style.backgroundColor == color){
						set_value(obj_li[i]);
						break;
					}
			}
		}
};


objAutoComp.prototype.montaDiv = function (v) {
	var div = document.getElementById(this.div_result);
	
	v = v.split(';')[v.split(';').length-1];
	if (v.length > 1) {
		res = multiBinaryMatch(this.lista, v, 1, 1);
		if (res) {
			div.style.display = 'block';
			var e_ul = document.createElement('ul');
			for (i=0;i<res.length;i++){
				var e_li = document.createElement('li');
				with(e_li) {
					var id = i;
					setAttribute('id', 'res_' + id);
					setAttribute('onClick', 'set_value(this)');
					onclick = new Function('set_value(this)');
					var l = this.lista[res[i]].split('|');
					var texto = '"' + l[0] + '" &lt;' + l[1] + '&gt;';
					innerHTML = texto;
				}
				e_ul.appendChild(e_li);
			}
			
			/*O binary search coloca na lista de resultados o 1º elemento como o ultimo elemento da lista, foi necessário fazer isso para manter a lista ordenada
			var e_li = document.createElement('li');
			with(e_li) {
				var id = res.length-1;
				setAttribute('id', 'res_' + id);
				setAttribute('onClick', 'set_value(this)');
				onclick = new Function('set_value(this)');
				var l = this.lista[res[0]].split('|');
				var texto = '"' + l[0] + '" &lt;' + l[1] + '&gt;';
				innerHTML = texto;
			}
			e_ul.appendChild(e_li);
			*/
			div.innerHTML = '';
			div.appendChild(e_ul);
		}else
			div.style.display = 'none';
	}else
		div.style.display = 'none';
};


objAutoComp.prototype.setarValor = function (obj) {
	field = document.getElementById(this.campo);
	frag = field.value.split(';');
	val = obj.innerHTML.split('"')[1];
	
	if (frag.length>1){
		txt='';
		if (field.value[field.value.length-1] != ';')
			for (i=0;i<frag.length-1;i++) txt+= frag[i]+';'
		else
			for (i=0;i<frag.length;i++) txt+= frag[i]+';';
		field.value = txt + val + ';';
	}else
		field.value = val + ';';
	document.getElementById(this.div_result).style.display = 'none';
	field.focus();
};


objAutoComp.prototype.setarFinal = function (TB) {
	/** IE*
	Toda vez que jogar o foco para o campo, o cursor vai pro final do texto. **/
	if (TB.createTextRange){
		var FieldRange = TB.createTextRange();
		FieldRange.moveStart('character', TB.value.length);
		FieldRange.collapse();
		FieldRange.select();
	}
};


objAutoComp.prototype.HexToRGB = function (h) {
	r = parseInt((this.cutHex(h)).substring(0,2),16);
	g = parseInt((this.cutHex(h)).substring(2,4),16);
	b = parseInt((this.cutHex(h)).substring(4,6),16);
    rgb = 'rgb('+r+', '+g+', '+b+')';
	return rgb;
};

objAutoComp.prototype.cutHex = function (h) {
	return (h.charAt(0)=="#") ? h.substring(1,7):h;
};