  var reverse   = false; 
  var base_img = '/static/img/';
  var img_blank = 'blank_listagem.gif';   
  var img_down  = 'listagem_down.gif';    
  var img_up    = 'listagem_up.gif';        
  var regDia = /(\d{2,2})(?:\/)/;
  var regMes = /(?:\/)(\d{2,2})(?:\/)/;
  var regAno = /(?:\/)(\d{4,4})/;
  var omitformtags = ["input", "textarea", "select"];
  omitformtags     = omitformtags.join("|");
  defaultCor = 'red';
  dodbclick  = null;   tableFocus = null; 
  if (window.addEventListener) window.addEventListener("keydown", geckoEvtTable, false);   else if (window.attachEvent) window.attachEvent("onkeydown", geckoEvtTable);
  if( window.addEventListener ) window.addEventListener( 'load', initTabela, false );
  else if( window.attachEvent ) window.attachEvent( 'onload', initTabela );

  function initTabela(){
      tables = document.getElementsByTagName('table');
      for (var t=0; t<tables.length; t++)
      {
        var ignoretabelajs = tables[t].getAttribute('ignoretabelajs');
        if(!(ignoretabelajs)){
          tables[t].setAttribute('reverse', false);
          tables[t].setAttribute('lastclick', -1);
          tables[t].getselect = function(){
            var trselect = new Array();
            var trs = this.getElementsByTagName('tr')
            for (var i=0; i < trs.length; i++)
            {
              var sel = trs[i].getAttribute('selected');
              if (sel == 'selected') trselect[trselect.length] = trs[i]
            }
            return trselect;
          }
          var sort    = tables[t].getAttribute('sort');
          var select  = tables[t].getAttribute('select');
          var multi   = tables[t].getAttribute('multiselect');
          var dbclick = tables[t].getAttribute('dbclick');
          var key     = tables[t].getAttribute('key');
          var tbody   = tables[t].getElementsByTagName('tbody')[0];
          var vcookie = tables[t].getAttribute('cookie');
          var class1  = tables[t].getAttribute('class1');
          var class2  = tables[t].getAttribute('class2');

          if (sort == 'sort'){
            thead = tables[t].getElementsByTagName('thead')[0];
            if (thead){
              theadrow = thead.getElementsByTagName('tr')[0]; 
              if (theadrow.tagName.toLowerCase() == 'tr'){
                var l, clickCell, colCount;
                clickCell = theadrow.getElementsByTagName('th');
                colCount = clickCell.length;
                for (var i=0; i<colCount; i++){
                  img        = document.createElement('img');
                  img.src    = base_img + img_blank;
                  clickCell[i].setAttribute('selectIndex', i);
                  clickCell[i].appendChild(img);
                  clickCell[i].style.cursor = 'pointer';
                  if(window.attachEvent) clickCell[i].attachEvent("onclick", doClick);
                  else if (window.addEventListener) clickCell[i].addEventListener("click", doClick, false);
                }
                if (vcookie){
                  var link = window.location.pathname;
                  link = link.split('/');
                  var cookie_name = link[link.length-1] +'_'+ tables[t].id;
                  tables[t].setAttribute('cookie_name', cookie_name);
                  var cookies = document.cookie;
                  if (cookies.indexOf(cookie_name) != -1){
                    cookies = cookies.split(';');
                    var index = -1;
                    reverse = false;
                    for (var c=0; c<cookies.length; c++){
                      if (cookies[c].indexOf(cookie_name) != -1) index = parseInt( cookies[c].split('=')[1] );
                      if (cookies[c].indexOf('reverse') != -1) reverse = eval(cookies[c].split('=')[1]);
                    }
                    tables[t].setAttribute('reverse', reverse);
                    tables[t].setAttribute('lastclick', index);
                    doClick(clickCell[index])
                  }
                }
              }
            }
          }
          var tclass = class1;
          if (tbody){
            trs = tbody.getElementsByTagName('tr')
            for (i=0; i<trs.length; i++){
              var ignoretabelajs = trs[i].getAttribute('ignoretabelajs');
              var ignoredbclick = trs[i].getAttribute('ignoredbclick');
              if(!(ignoretabelajs)){
                if (select == 'select'){
                  if(window.attachEvent)  trs[i].attachEvent("onclick", doSelect);
                  else if (window.addEventListener) trs[i].addEventListener("click", doSelect, false);
                }
                if(!(ignoredbclick)){
                  if (dbclick == 'dbclick'){
                    if(window.attachEvent)  trs[i].attachEvent("ondblclick", doDbClick);
                    else if (window.addEventListener) trs[i].addEventListener("dblclick", doDbClick, false);
                  }
                }
                if (key == 'key'){
                  if(window.attachEvent) trs[i].attachEvent("onkeydown", geckoEvtTable);
                  trs[i].focus = function() {
                    var table = this
                    while (table.tagName.toLowerCase() != 'table') table = table.parentNode;
                    tableFocus = table.id; 
                    window.focus();
                  }
                }
                trs[i].className = tclass;
                trs[i].setAttribute('oldTRclass', tclass);
                tclass = (tclass == class1) ? class2:class1;
              }
            }
          }
        }
      }
  }

  function geckoEvtTable(e)
  {
      var keyCode  = e.which ? e.which:window.event.keyCode;
      var tag      = null; 

      if (e.srcElement)  tag = e.srcElement.tagName.toLowerCase();
      else if (e.target) tag = e.target.tagName.toLowerCase();

      tag = ((omitformtags.indexOf(tag) == -1) ? false:true);
      
 
      if (e.srcElement)
      {
          var table = e.srcElement;
          while (table.tagName.toLowerCase() != 'table') table = table.parentNode;
      }
      

      if (keyCode == 38 || keyCode == 40) 
      {
         if (tableFocus) teclasSetas(document.getElementById(tableFocus), (keyCode == 38) ? true:false);
         else if (table) teclasSetas(table, (keyCode == 38) ? true:false);

      } else if (keyCode == 13 && !tag) enter();
      else if (keyCode == 46 && !tag) del();
  }

  
  function teclasSetas(table, got)
  {
      if (document.body) document.body.scroll = 'no';
      var table = table.getselect();
      if (table.length >= 1)
      {

          var currnode = table[0];
          if (got)
          {
              if (currnode.previousSibling)
              {
                  currnode = currnode.previousSibling;
                  while (currnode.nodeType != 1) 
                  {    
                      if (currnode.previousSibling) currnode = currnode.previousSibling;
                      else return;
                  } 
              }
          } else {
              if (currnode.nextSibling)
              {
                  currnode = currnode.nextSibling;
                  while (currnode.nodeType != 1) 
                  {
                      if (currnode.nextSibling) currnode = currnode.nextSibling;
                      else return;
                  }
              }
          }

          if (currnode && currnode.tagName && currnode.tagName.toLowerCase() == 'tr') doSelect(currnode);
      }
      if (document.body) document.body.scroll = 'auto';
  }

  
  function enter(e)
  {
      if (typeof(doEnter) == 'function') doEnter();
  }

  
  function del(e)
  {
      if (typeof(doDel) == 'function') doDel();
  }

  
  function doDbClick(e)
  {
      if (dodbclick) dodbclick();
  }

  
  function doClick(e){
    if (!e) return;
    var clickObject = false;
    if (e.srcElement) clickObject = e.srcElement;
    else if (e.target) clickObject = e.target;
    else if (e.tagName) clickObject = e;
    if (!clickObject) return;
    var th = clickObject;
      while (clickObject.tagName.toLowerCase() != 'table') clickObject = clickObject.parentNode;
      while (th.tagName.toLowerCase() != 'th') th = th.parentNode;

      var tipo = th.getAttribute('tipo');
      tipo = tipo ? tipo:'string';

      var thIndex  = restoreImg(clickObject, th);       tbody        = clickObject.getElementsByTagName('tbody')[0];

      var sortedTr = new Array();       var sortTr   = new Array();       var resultTr = new Array();       var copyTr   = new Array();

      trs = tbody.getElementsByTagName('tr')     
      for (var i=0; i < trs.length; i++)
      {
          copyTr[copyTr.length] = trs[i]       }

      var totalTr  = copyTr.length;
      var text;

      for (var i=0; i < totalTr; i++)       {
          text = copyTr[i].getElementsByTagName('td')[thIndex].innerHTML;
          sortedTr[i] = text;
          sortTr[i]   = text;
      }


      if (tipo == 'date') sortedTr.sort(dateOrder);       else if (tipo == 'number') sortedTr.sort(numberOrder);
      else sortedTr.sort(textOrder);
 
      for (var i=0; i < totalTr; i++)
      {
          for (var e=0; e < totalTr; e++)
          {
              if (sortedTr[i] == sortTr[e])
              {
                  resultTr[i] = e;
                  sortTr[e]   = null;
                  break;
              }
          }
      }

      var trs = tbody.getElementsByTagName('tr');
      var cor = new Array();

      for (var i=0; i < resultTr.length; i++) cor[cor.length] = trs[i].getAttribute('oldTRclass');

      for (var i=0; i < resultTr.length; i++)
      {
          tr = copyTr[ resultTr[i] ];
          tr.setAttribute('oldTRclass', cor[i]);
          td = tr.getElementsByTagName('td');

          corbg = tbody.parentNode.getAttribute('classSelect');
          corbg = (tr.getAttribute('selected') == 'selected') ? (corbg ? corbg:defaultCor ):cor[i];
                    tr.className = corbg;
                    tbody.appendChild( tr );
      }
  }

  
  function restoreImg(table, th)
  {
      var lastclick = table.getAttribute('lastclick');
      var reverse_  = eval(table.getAttribute('reverse'));
      var imgcol    = table.getElementsByTagName('thead')[0].getElementsByTagName('img');       for(var i=0; i < imgcol.length; i++) imgcol[i].src = base_img + img_blank;
      var index = th.getAttribute('selectIndex');
      if(lastclick == index) 
      {
          if(reverse_ == false) 
          {
              th.getElementsByTagName('img')[0].setAttribute('src', base_img + img_down);
	      table.setAttribute('reverse', true);
              reverse = true;
          } else {
              th.getElementsByTagName('img')[0].setAttribute('src', base_img + img_up);
	      table.setAttribute('reverse', false);
              reverse = false;
	  }
      } else {
          table.setAttribute('reverse', false);
          reverse = false;
          table.setAttribute('lastclick', index);
          th.getElementsByTagName('img')[0].setAttribute('src', base_img + img_up);
      }
      var cookie_name = table.getAttribute('cookie_name');
      if (cookie_name)
      {
         var date = new Date();
         date.setTime(date.getTime()+(2*24*60*60*1000));
         var expira = "; expires="+date.toGMTString();
         document.cookie = cookie_name +"="+ index +expira+"''; path=/;";
         var t = reverse ? 'false':'true'
         document.cookie = "reverse="+ t +expira+"''; path=/;";
      }

      return index;
  }

  
  function numberOrder(a,b)
  {
      reverse ? rVal = b - a : rVal = a - b;
      return rVal;
  }

  
  function dateOrder(a,b)
  {
      dia = a.match(regDia)[1];
      mes = a.match(regMes)[1];
      ano = a.match(regAno)[1];
      a = parseFloat(ano+mes+dia);

      dia = b.match(regDia)[1];
      mes = b.match(regMes)[1];
      ano = b.match(regAno)[1];
      b = parseFloat(ano+mes+dia);

      reverse ? rVal = a - b : rVal = b - a;
      
      return rVal;
  }

  
  function textOrder(a,b)
  {
            a = a.toString().replace( /<.+?>/gi, '' ).toLowerCase();
      b = b.toString().replace( /<.+?>/gi, '' ).toLowerCase();
      var rVal = -1; 

      try {
          if (a < b) reverse ? rVal = -1 : rVal = 1;
          else reverse ? rVal = 1 : rVal = -1;
      } catch (e) {}

      return rVal;
  }

  
  function doSelect(e)
  {
      if (!e) return;
      var clickObject = false; 
      if (e.srcElement)  clickObject = e.srcElement;       else if (e.target) clickObject = e.target;
      else if (typeof(e) == 'object' ) clickObject = e;


      var table = clickObject
      while (table.tagName.toLowerCase() != 'table') table = table.parentNode;
      tableFocus = table.id;
      multiselect   = table.getAttribute('multiselect');
      classSelected = table.getAttribute('classSelect');
      classSelected = classSelected ? classSelected : defaultCor;

            if (!e.ctrlKey || multiselect != 'multiselect')
      {
          var tr = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr')
          for (var i=0; i < tr.length; i++)
          {
              var td = tr[i].getElementsByTagName('td');
              var oldTRclass = tr[i].getAttribute('oldTRclass');
              tr[i].setAttribute('selected', 'not_selected');
                            tr[i].className = oldTRclass;
                        }
      }

      while (clickObject.tagName.toLowerCase() != 'tr') clickObject = clickObject.parentNode;

      var sel = clickObject.getAttribute('selected')
      sel     = sel ? ((sel == 'selected') ? 'not_selected':'selected') : 'selected';

      clickObject.setAttribute('selected', sel);
      var td = clickObject.getElementsByTagName('td');
      classSelected = (sel == 'selected') ? classSelected : clickObject.getAttribute('oldTRclass');
            clickObject.className = classSelected;
            if (clickObject.focus) clickObject.focus();
  }


  

  function disableselect(e)
  {
      if (omitformtags.indexOf(e.target.tagName.toLowerCase())==-1) return false;
      return true;
  }

  function reEnable()
  {
    return true;
  }

/*  if (typeof document.onselectstart!="undefined") document.onselectstart = new Function ("return false")
  else{
    document.onmousedown = disableselect;
    document.onmouseup   = reEnable;
  }*/
