/**
 * FancyUpload - Flash meets Ajax for beauty uploads
 * 
 * Based on Swiff.Base and Swiff.Uploader.
 * 
 * Its intended that you edit this class to add your
 * own queue layout/text/effects. This is NO include
 * and forget class. If you want custom effects or
 * more output, use Swiff.Uploader as interface
 * for your new class or change this class.
 * 
 * USAGE:
 *  var inputElement = $E('input[type="file"]');
 * 	new FancyUpload(inputElement, {
 * 		swf: '../swf/Swiff.Uploader.swf'
 * 		// more options
 * 	})
 * 
 * 	The target element has to be in an form, the upload starts onsubmit
 * 	by default.
 * 
 * OPTIONS:
 * 
 * 	url: Upload target URL, default is form-action if given, otherwise current page
 *  swf: Path & filename of the swf file, default: Swiff.Uploader.swf
 *  multiple: Multiple files selection, default: true
 *  queued: Queued upload, default: true
 *  types: Object with (description: extension) pairs, default: Images (*.jpg; *.jpeg; *.gif; *.png)
 *  limitSize: Maximum size for one added file, bigger files are ignored, default: false
 *  limitFiles: Maximum files in the queue, default: false
 *  createReplacement: Function that creates the replacement for the input-file, default: false, so a button with "Browse Files" is created
 *  instantStart: Upload starts instantly after selecting a file, default: false
 *  allowDuplicates: Allow duplicate filenames in the queue, default: true
 *  container: Container element for the swf, default: document.body, used only for the first FancyUpload instance, see QUIRKS
 *  optionFxDuration: Fx duration for highlight, default: 250
 *  queueList: The Element or ID for the queue list
 *  onComplete: Event fired when one file is completed
 *  onAllComplete: Event fired when all files uploaded
 * 
 * NOTE:
 * 
 * 	Flash FileReference is stupid, the request will have no cookies
 * 	or additional post data. Only the file is send in $_FILES['Filedata'],
 * 	with a wrong content-type (application/octet-stream).
 * 	When u have sessions, append them as get-data to the the url.
 * @version		1.0rc1
 * @license		MIT License
 * @author		Harald Kirschner <mail [at] digitarald [dot] de>
 * @copyright	Authors
 */
var FancyUpload = new Class({

	options: {
		url: false,		
		swf: 'Swiff.Uploader.swf', 
		//<** parametros somente passados quando a existencia do arquivo e verificada anteriormente
		urlToUploadComplete: false, // url para completar a transferencia do arquivo apos a verificacao		
		urlToFileExist: false,	// url para a verificacao de existencia do arquivo
		urlToGetDadosSessao: false, // url para se apanhar os dados do exif da imagem que foram para a session
		urlToCleanSessao: false, // url para limpar os dados das imagens que estão na sessão;
		urlToRemoveFile: false, // url para deletar as imagens que estão na sessão
		doVerification: false, // indica se havera verificacao de existencia
		minSizeToVerification: 40000, // quantidade de bytes que serao enviados para a verificacao de pre-existencia (DEVE-SE MODIFICAR NO Swiff.Uploader.fla)		
	  //**>
		multiple: true,  // indica se poderao ser feitos multiplos uploads
		queued: true,
		types: {'Images (*.jpg, *.jpeg, *.gif, *.png)': '*.jpg; *.jpeg; *.gif; *.png'},
		limitSize: false, // limite de tamanho do arquivo
		limitFiles: false, // limite de arquivos
		createReplacement: null,
		instantStart: false, // indica se iniciara automaticamente
		allowDuplicates: false, // poderao haver arquivos duplicados
		optionFxDuration: 250,
		container: null,
		queueList: 'photoupload-queue', // id do objeto em que esta a lista dos arquivos
		onComplete: Class.empty, 
		onError: Class.empty,
		onCancel: Class.empty,
		onAllComplete: Class.empty,	
        onCompleteVerification: Class.empty		
	},

	initialize: function(el, options){
		this.element = $(el);
		this.setOptions(options);
		this.options.url = this.options.url || this.element.form.action || location.href;
		this.fileList = [];

		this.uploader = new Swiff.Uploader({
			onOpen: this.onOpen.bind(this),
			onProgress: this.onProgress.bind(this),
			onComplete: this.onComplete.bind(this),
			onError: this.onError.bind(this),
			onSelect: this.onSelect.bind(this),
		  onCompleteVerification: this.onCompleteVerification.bind(this)
		}, this.initializeFlash.bind(this), {
			swf: this.options.swf,
			types: this.options.types,
			multiple: this.options.multiple,
			queued: this.options.queued,
			container: this.options.container
		});
	},

	initializeFlash: function() {
		this.queue = $(this.options.queueList);
		$(this.element.form).addEvent('submit', this.upload.bindWithEvent(this));
		if (this.options.createReplacement) this.options.createReplacement(this.element);
		else {
			var elem = new Element('input', {
				type: 'button',
				value: 'Localizar',
				className: 'formbotao',
                id: 'search_button',
				events: {
					click: this.browse.bind(this)
				}
			})
      // for FF
			if(!document.all) elem.setAttribute('class', 'formbotao');
			elem.style.cssText = 'position: absolute'
            elem.injectBefore(this.element);
			this.element.remove();
		}
		
	},
	
	browse: function() {
        this.uploader.browse();
	},

	upload: function(name, size) {	
       
	    if(this.options.doVerification) {	

    	    if (name) {
				this.uploader.send('', this.options.url + "|" + this.options.urlToUploadComplete, name, size);
		    }else{
				this.uploader.send('', this.options.url + "|" + this.options.urlToUploadComplete);
			}
		} else {	

            if(name) this.uploader.send(this.options.urlToUploadComplete, '', name, size);
			else this.uploader.send(this.options.urlToUploadComplete, '');
	    }  
	},

	onSelect: function(name, size) {	
//	    name = encodeURIComponent(name);	
    	var key = name + size;
    	IPTCMetadata.tmp_metadados[key] = {};
    	// show controls
    	document.getElementById('controles').style.visibility = 'visible';
		if (this.uploadTimer) this.uploadTimer = $clear(this.uploadTimer);
		if ((this.options.limitSize && (size > this.options.limitSize))
			|| (this.options.limitFiles && (this.fileList.length >= this.options.limitFiles))
			|| (!this.options.allowDuplicates && this.findFile(name, size) != -1)) return false;
		this.addFile(name, size);	
		// comecando automaticamente
		if (this.options.instantStart) this.uploadTimer = this.upload.delay(250, this);
		return true;		
	},

	onOpen: function(name, size) {
		var index = this.findFile(name, size);
    	elem = this.fileList[index].element;    
		this.fileList[index].status = 1;
		if (this.fileList[index].fx) return;
		var key = name + size;
		this.fileList[index].fx = elem.getElementById('div_flash' + key);
		this.fileList[index].txt_perc = elem.getElementById('porcentagem' + key);				
	},

	onProgress: function(name, bytes, total, percentage) {
		this.uploadStatus(name, total, percentage);
	},

	onComplete: function(name, size, hasData) {		

	    var key = name + size;		

        if(!hasData) {

	        var dados = this.getDadosSessao(name, size);	
			IPTCMetadata.tmp_metadados[key] = dados;

		}

		var index = this.uploadStatus(name, size, 100);
		this.fileList[index].txt_perc.innerHTML = 'Completado';
		this.fileList[index].status = 2;
		this.highlight(index, 'e1ff80');
		this.checkComplete(name, size, 'onComplete');
	},

  // chamada quando se completa a verificacao do file header
  onCompleteVerification: function(name, size, teste, teste2) {    
/*
  if(teste && isNaN(teste)) {
  alert('TESTE -> ' + teste);
  return;
  }
  */
      //var key = name + size;
      //var dataFile = this.fileExist(name, size);
	  
	  //----------------------------------------------------fase 3.
	  this.fileExist(name, size);
	  
	 //----------------------------------------------------fase 1:
	  /*var _bd_id = document.getElementById('org_id').value;
	  
	  //atualmente só verifica ao inserir no banco Produção
	  if (_bd_id == '3'){
		   this.fileExist(name, size);
	  }else{
		   this.continuar(name, size);
	  }
	  */
	 //----------------------------------------------------fase 1.
	 
	 
     /* if(dataFile) { 
          // colocando os dados de iptc
          //if(!IPTCMetadata.tmp_metadados[key]) { IPTCMetadata.tmp_metadados[key] = dataFile; }
          IPTCMetadata.tmp_metadados[key] = dataFile;           		            
          // remove o arquivo ja enviado
          this.uploader.remove(name, size);
          //this.onComplete(name, size, true);
          // fazendo upload do proximo          
          var next = this.nextFile();
          var file = this.fileList[next];
		  if(file) this.upload(file.name, file.size);		              
      } else {      
          //this.continuar(name, size);
      }*/
  },
  
  onCompleteInsert: function(name, size, inserir){
		if(inserir){
			this.continuar(name, size);
		}else{
		  var key = name + size;
		  // colocando os dados de iptc
          //if(!IPTCMetadata.tmp_metadados[key]) { IPTCMetadata.tmp_metadados[key] = dataFile; }
          //IPTCMetadata.tmp_metadados[key] = ''
          // remove o arquivo ja enviado
		  //this.uploader.remove(name, size);
		  //uplooad.onComplete(name, size, true);
		  uplooad.remove(name, size);
          //uplooad.onComplete(name, size, true);
          // fazendo upload do proximo          
          var next = this.nextFile();
          var file = this.fileList[next];
		  if(file) this.upload(file.name, file.size);
	    }
    
  },
  
  fileExist: function(name, size) {
      var handler = new XMLHandler();
      var xmlreq = new XMLClient(this.options.urlToFileExist);
      xmlreq.setAsync(false); 
      handler.bdoAsync = false;

      xmlreq.addParam('name', name);
      xmlreq.addParam('size', size);           
      handler.onLoad = function(retorno) {
		  
		  if (JSON.decode(retorno)){
		    var _name = name;
			if (name.length > 20){
			   _name = name.substr(0,18)+'... ';
			}
			
			var msg = "O arquivo <b>"+_name+"</b> já existe no sistema. Deseja inserí-lo novamente?<br><br>";    
			msg += "<input type=\"button\" class=\"button_box_confirma\" onclick=\"javascript: uplooad.onCompleteInsert('"+name+"','"+size+"', true);hideBox();\" />";
			msg += "<input type=\"button\" class=\"button_box_confirma button_box_confirma_nao\" style=\"margin-left:5px;clear:none\"  onclick=\"javascript: uplooad.onCompleteInsert('"+name+"','"+size+"', false);hideBox();\"/>";
			showBox(msg, 'help','false',true);
			
		  }else{
			uplooad.continuar(name, size);
		  }
		  
          //return JSON.decode(retorno)
      } 
      // executa a query construída acima
      xmlreq.query(handler); 

      //return JSON.decode(xmlreq.oXMLRequest.responseText)
  },
  
  getDadosSessao: function(name, size) {
      var handler = new XMLHandler();
      var xmlreq = new XMLClient(this.options.urlToGetDadosSessao);
      xmlreq.setAsync(false); 
      handler.bdoAsync = false;

      xmlreq.addParam('name', name);
      xmlreq.addParam('size', size);           
      handler.onLoad = function(retorno) {

		  return JSON.decode(retorno);
		  
      } 
      // executa a query construída acima
      xmlreq.query(handler);      
      return JSON.decode(xmlreq.oXMLRequest.responseText)
  },
	/**
	 * Error codes are just examples, customize them according to your server-errorhandling
	 * 
	 */
	onError: function(name, size, error) {
		var msg = "Falha de Upload (" + error + ")";
		switch(error.toInt()) {
			case 500: msg = "Ocorreu um erro no servidor. Por favor, tente novamente!"; break;
			case 400: msg = "O upload falhou. Por favor, cheque o tamanho do arquivo."; break;
			case 409: msg = "O sistema não pode processar este tipo de imagem. Por favor, escolha outra."; break;
			case 415: msg = "Tipo de imagem não suportado, insira um arquivo JPEG!"; break;
			case 412: msg = "Página inválida, por favor, recarregue a página e tente novamente!"; break;
			case 417: msg = "Imagem muito pequena, por favor, escolha outra imagem!"; break;
		}
		var index = this.uploadStatus(name, size, 100);
		this.fileList[index].fx.element.setStyle('background-color', '#ffd780').setHTML(msg);
		this.fileList[index].status = 2;
		this.highlight(index, 'ffd780');
		this.checkComplete(name, size, 'onError');
	},

	checkComplete: function(name, size, fire) {
		this.fireEvent(fire, [name, size]);	
		if (this.nextFile() == -1) this.fireEvent('onAllComplete');
	
	},

	addFile: function(name, size) {	
		if (!this.options.multiple && this.fileList.length) this.remove(this.fileList[0].name, this.fileList[0].size);
		this.fileList.push({
			name: name,
			size: size,
			status: 0,
			percentage: 0,
			element: 

      new Element('li').setHTML(     
      '<div class="bloco01">' +
        '<div class="engloba_edicao_upload" style="*padding-left:169px; *width:235px">' +
     		  //'<span><a href="javascript: void(0);"  onclick="IPTCMetadata.newImagemIPTC(\'' + name + '\', \'' + size + '\')">' + name + '</a></span>' + 
          '<img  src="'+ url_estatica + '/img/linha.png" /><a href="javascript: void(0)" onClick="uplooad.remove(\'' + name + '\', \'' + size + '\')" style="_width:55px;"><img  src="' + url_estatica + '/img/excluir2.gif" />Excluir</a>' +
    		  '<span id="adiciona_iptc' + name + size + '" style="visibility: hidden; margin:0px; *width:160px;"><img  src="'+ url_estatica + '/img/linha.png" /><a href="javascript: void(0);"  style="*width:149px;" onclick="IPTCMetadata.newImagemIPTC(\'' + name + '\', \'' + size + '\')"> <img   src="' + url_estatica + '/img/editar2.gif"> Editar info. da imagem</a></span>' +
    		  '<img src="' + url_estatica + '/img/spacer.png" /> <br class="clear"/>' +
        '</div>' +
//        '<p>' + Math.ceil(size/1000) + 'KB </p>' +
        '<div class="div_flash_fundo">' +
          '<div id="porcentagem' + name + size + '" class="porcentagem">0%</div>' + 
    	    '<div class="div_flash" id="div_flash' + name + size + '" style="width:0%">&nbsp;</div>' +
		'</div>' +
      '</div>' +
 
      '<div class="bloco02" style="visibility: hidden; height:72px; width:96px;" id="div_thumb' + name + size +'">' +
        '<a href="javascript: void(0);" onclick="IPTCMetadata.newImagemIPTC(\'' + name + '\', \'' + size + '\')">' +
          '<img id="thumb' + name + size +'" src="" style="max-width:96px; max-height:70px;" />' +
        '</a>' +
      '</div>' +
  	  '<br class="clear" />' 
     ).injectInside(this.queue)    
		});
		new Element('a', {
			href: 'javascript:void(0)',
			'class': 'input-delete',
			title: 'Remover da lista',
			events: {
				click: this.cancelFile.bindWithEvent(this, [name, size])
			}
		}).injectBefore(this.fileList.getLast().element.getFirst());
		this.highlight(this.fileList.length - 1, 'e1ff80');	
	},

	uploadStatus: function(name, size, percentage) {

		var index = this.findFile(name, size);

		this.fileList[index].txt_perc.innerHTML = percentage + '%';
    if(!document.all) {
   	    this.fileList[index].fx.style.width = percentage+ '%'
   	} else {
   	    this.fileList[index].fx.style.setAttribute('width', percentage+ '%')   	
   	}
		this.fileList[index].percentage = percentage;
		return index;
	},

	uploadOverview: function() {
		var l = this.fileList.length, i = -1, percentage = 0;
		while (++i < l) percentage += this.fileList[i].percentage;
		return Math.ceil(percentage / l);		
	},

	highlight: function(index, color) {
		return this.fileList[index].element.effect('background-color', {duration: this.options.optionFxDuration}).start(color, 'fff');		
	},

	cancelFile: function(e, name, size) {
		e.stop();
		this.remove(name, size);
	},

	remove: function(name, size, index) {
		this.removeFile(name, size);
	    this.clearDadosSessao(name, size);
		if (name) index = this.findFile(name, size);
		if (index == -1) return;
		if (this.fileList[index].status < 2) {
			this.uploader.remove(name, size);
			this.checkComplete(name, size, 'onCancel');
		}
		this.fileList[index].element.effect('opacity', {duration: this.options.optionFxDuration}).start(1, 0).chain(Element.remove.pass([this.fileList[index].element], Element));
		this.fileList.splice(index, 1);
   	    if(this.fileList.length < 1) document.getElementById('controles').style.visibility = 'hidden';	
		return;
	},

    continuar: function(name, size) { 
      this.uploader.continuar(name, size, this.options.urlToUploadComplete);    
      return;
    },	

	findFile: function(name, size) {
		var l = this.fileList.length, i = -1;
		while (++i < l) if (this.fileList[i].name == name && this.fileList[i].size == size) return i;
		return -1;
	},

	nextFile: function() {
		var l = this.fileList.length, i = -1;
		while (++i < l) if (this.fileList[i].status != 2) return i;
		return -1;
	},
	
	removeFile: function(name, size) {
      var handler = new XMLHandler();
      var xmlreq = new XMLClient(this.options.urlToRemoveFile);
	  if (name != null && size != null) {
	     xmlreq.addParam('name', name);
		 xmlreq.addParam('size', size);
	  }
	  handler.onInit = function() {};
	  handler.onError = function(e) { showBox(e, 'erro'); }
	  handler.onProgress = function() {};
      handler.onLoad = function(retorno) {
		  try{
			lista = JSON.decode(retorno)
		  }catch(e){
			lista = retorno
		  }
		  
		  dict = lista[0];
		  if (dict['tipo'] == 'erro') {
	    	  var msg  = dict['msg'];
              var tipo = "erro";
		      showBox(msg, tipo);
		  }
	      //return;
      }
      xmlreq.query(handler);
	},
	
	clearDadosSessao: function(name, size) {
      var handler = new XMLHandler();
      var xmlreq = new XMLClient(this.options.urlToCleanSessao);
	  if (name != null && size != null) {
	     xmlreq.addParam('name', name);
		 xmlreq.addParam('size', size);
	  }
	  handler.onInit = function() {};
	  handler.onError = function(e) { showBox(e, 'erro'); }
	  handler.onProgress = function() {};
      handler.onLoad = function(retorno) {
	      return;
      }
      xmlreq.query(handler);
	},

	clearList: function(complete) {
		this.removeFile(null, null);
	    this.clearDadosSessao(null, null);
		var i = -1;
		while (++i < this.fileList.length) if (complete || this.fileList[i].status == 2) this.remove(0, 0, 0, i--);
	},
	
	reposition: function() {
		// Fix FLASH 10
		if(Swiff.getVersion() >= 10) {
		    // Reposicionando o botao devido ao fato que o browse da classe 
			// FileReference (Action Script) só pode ser chamado via evento 
			// do usuário à partir da versão 10 do Flash
			var btn = document.getElementById('search_button');

			with(Swiff.Uploader.object) {
				style.top = btn.offsetTop + 'px';
				style.left = btn.offsetLeft + 2 + 'px';
			}
		}			
	}
});

FancyUpload.implement(new Events, new Options);
