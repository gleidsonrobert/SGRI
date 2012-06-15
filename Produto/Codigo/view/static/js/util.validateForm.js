/****
*   METODOS PERTECENTES
*   Browser, addMsgErro, addDivErro, validateForm
*/

//alert('novo95');

function Browser(){
  var u = window.navigator.userAgent
  this.isGecko=u.toLowerCase().indexOf('gecko')!=-1;
  this.isIe=u.toLowerCase().indexOf('msie')!=-1;
  this.isOpera=u.toLowerCase().indexOf('opera')!=-1;
  this.isKonqueror=u.toLowerCase().indexOf('khtml')!=-1;
}
var browser=new Browser();

function addMsgErro(elem,elemRequire,msg,div){
  if(div){
    //var v_strong = document.getElementById('v_strong');
    //if(v_strong==null){
    v_strong = document.createElement('strong');
    v_strong.setAttribute('id','v_strong');
    if(div){
      div.appendChild(v_strong);
    }
    //}
    v_a = document.createElement('a');
    rmsg = "";
    if(elem){
      var elemId = elem.getAttribute('id');
      rmsg = "document.getElementById('"+elemId+"').focus();"
      if(elem.select){
        rmsg += "document.getElementById('"+elemId+"').select();";
      }
      fonclick=rmsg;
      v_a.setAttribute('href','javascript:'+fonclick);
    }
    v_a.innerHTML = elemRequire;
    v_strong.appendChild(v_a);
    v_strong.appendChild(document.createElement('br'));
    return '';
  } else{
      return (msg + elemRequire + '<br />');
  }
}

function addDivErro(msg,e){
  var o_div_erro = null;
  var sDivErro = e.getAttribute('diverro');
  var v_div_erro = document.getElementById(div_erro);
  if(sDivErro){
    o_div_erro=document.getElementById(sDivErro);
  }
  if(o_div_erro){
    var ierro = o_div_erro;
  } else {
    var ierro = v_div_erro;
  }
  Utils.displayBlock(document.getElementById(div_erro_header));
  Utils.displayBlock(ierro);
  if(e){
    Utils.setStyleBorder(e,'1px solid #CC0000');
  }
  var msg = addMsgErro(e,msg,'',ierro);
  if(msg==''){
    if(e){if(e.focus){e.focus();}}
    window.scrollTo(0,0);
  } else {
    alert(msg);
  }
}

function validateForm(oForm){
  var _elem=oForm.elements;
  for(i=0;i<_elem.length;i++){validateElement(_elem[i]);}
  oForm.oldOnSubmit=oForm.onsubmit;
  oForm.onsubmit=function(){
    var _elem = this.elements;
    var _msg = '';
    var bor = null;
    var div = null;
    var msg_ok=document.getElementById('msg_ok');
    if(msg_ok){Utils.displayNone(msg_ok);}
    var msg_erro=document.getElementById('msg_erro');
    if(msg_erro){Utils.displayNone(msg_erro);}

    var v_strong = document.getElementById('v_strong');
    if(v_strong!=null){
      v_strong.parentNode.removeChild(v_strong);
      v_strong = null;
    }

    s=this.getAttribute('requires');
    if(s!=null && s!='undefined'){_msg=s+'<br>'+_msg;}
    var div = this.getAttribute('div');
    var div_header = this.getAttribute('div_header');
    if(div){
        div=document.getElementById(div);
        div_header=document.getElementById(div_header);
        if(div==null)throw 'Não há div com este id';
        if(div.length>1)throw 'Há ids duplicados na página';
    }
    for(var i=0;i<_elem.length;i++){
      var sDivErro=_elem[i].getAttribute('diverro');
      if(sDivErro){
        var oDivErro=document.getElementById(sDivErro);
        if(oDivErro){
          oDivErro.innerHTML = '';
          Utils.displayNone(oDivErro);
        }
      }
    }
    var elementUmErro = null;
    for(var i=0;i<_elem.length;i++){
      var sRequire=_elem[i].getAttribute('require');
      var sId=_elem[i].getAttribute('id');
      var oDivErro=_elem[i].getAttribute('diverro');
      var sDivErro=null;
      if(oDivErro){
        sDivErro=document.getElementById(oDivErro);
      }
      if(sRequire){
        sValor=(_elem[i].tagName.toLowerCase()=='select')?_elem[i][_elem[i].selectedIndex].value:_elem[i].value;
        if(_elem[i].type.toLowerCase()=='checkbox'){
          if(!_elem[i].checked){
            sValor='';
          }
        }
        var sFunc=null;
        if(_elem[i].getAttribute('data')=='data'){
          _elem[i].setAttribute('function','v_isDate');
        }
        try{var sFunc=eval(_elem[i].getAttribute('function'));}catch(err){}
        var temErro = false;
        if(typeof(sFunc)!='function'){
          sFunc= function(){return true;}
          temErro = isEmpty(sValor)
        } else {
          temErro = !sFunc(sValor,_elem[i])
        }
        //var sFunc=(typeof(sFunc)=='function') ? sFunc : function(){return true;}
        //var notBorderErro = _elem[i].getAttribute('notBorderErro')
        //if(!sFunc(sValor,_elem[i])||isEmpty(sValor)){
        var bor = _elem[i];
        if(temErro){
          bor.style.border='1px solid #CC0000';
          if(sDivErro){
            var idiv = sDivErro
            if(!(elementUmErro)){
              elementUmErro = _elem[i];
            }
          }
          else{
            var idiv = div
          }
          _msg = addMsgErro(_elem[i], sRequire, _msg, idiv);
          if(sDivErro){
            Utils.displayBlock(sDivErro);
          }
          /*
            if(_elem[i].id!=''){
                fonclick="document.getElementById('"+_elem[i].id+"').focus();document.getElementById('"+_elem[i].id+"').select();";
                v_a = document.createElement('a');
                v_a.setAttribute('href','javascript:'+fonclick);
                //v_a.setAttribute('href','#');
                v_a.innerHTML = sRequire;
                //v_a.setAttribute('onclick',''+fonclick+'');
                if(v_strong==null){
                  v_strong = document.createElement('strong');
                  v_strong.setAttribute('id','v_strong');
                }
                v_strong.appendChild(v_a);
                v_strong.appendChild(document.createElement('br'));
              }
              else{_msg=_msg+sRequire+'<br>';}
          */
        } else
        {
          bor.style.border='1px solid #ddd';
        }
      }
    }
    if(elementUmErro){
      if(elementUmErro.select){
        elementUmErro.select();
      }
      if(elementUmErro.focus){
        elementUmErro.focus();
      }
    }
    else{
      var v_strong = document.getElementById('v_strong');
      if((_msg.length>0) || (v_strong!=null)){
        var s = this.getAttribute('requires');
        if(s!=null && s!='undefined'){ _msg = s + '<br>' + _msg;}
        var div = this.getAttribute('div');
        var div_header = this.getAttribute('div_header');
        if(div){
          div = document.getElementById(div);
          div_header = document.getElementById(div_header);
          if(div_header){ div_header.style.display='block'; }
          if(div==null)throw 'Não há div com este id';
          if(div.length>1)throw 'Há ids duplicados na página';
          if(v_strong != null){
            div.appendChild(v_strong);
          }
          Utils.displayBlock(div);
          window.scrollTo(0,0);
        }
        _msg='';
        return false;
      } else {
        div = this.getAttribute('div');
        div=document.getElementById(div);
        if(div){
          Utils.displayNone(div);
        }
        return true;
      }
    }
    try{return this.oldOnSubmit();}catch(err){}
  }
}
function validateElement(oElement){
  if(!oElement.bProcessed){
    oElement.bProcessed=false;
    var sFmtFloatBrasil=oElement.getAttribute("float")=="float";    
    var sInt=oElement.getAttribute("int")=="int";
    var sDate=oElement.getAttribute("date")=="date";
    if((sFmtFloatBrasil)||(sInt)){
      if(oElement.style.setProperty){ // If DOM level 2 supported, the NS 6 way
        oElement.style.setProperty("text-align","right","important");
      }
      if(oElement.style.setAttribute){		// If DOM level 2 supported, the IE 6 way
        oElement.style.setAttribute("textAlign", "right");//!important
      }
      // Else this browser has very limited DOM support. Try setting the attribute directly.
      oElement.style.textAlign = "right"; // Works on Opera 6 //!important
    }
    if(sDate){
    /*
      if(oElement.style.setProperty){ // If DOM level 2 supported, the NS 6 way
        oElement.style.setProperty("text-align","center","important");
      }
      if(oElement.style.setAttribute){		// If DOM level 2 supported, the IE 6 way
        oElement.style.setAttribute("textAlign", "center");//!important
      }
      // Else this browser has very limited DOM support. Try setting the attribute directly.
      oElement.style.textAlign = "center"; // Works on Opera 6 //!important
      */
    }
    //if(browser.isGecko)window.captureEvents(Event.BLUR);
    oElement.oldOnBlur=oElement.onblur;
    oElement.onblur=function(event){
      var sFmtFloatBrasil=oElement.getAttribute("float")=="float";
      var sInt=oElement.getAttribute("int")=="int";
      var sDate=oElement.getAttribute("date")=="date";
      var sFmtUpperCase=this.getAttribute("upper")=="upper";
      if(sFmtUpperCase){this.value=this.value.toUpperCase();}
      var sFmtLowerCase=this.getAttribute("lower")=="lower";
      if(sFmtLowerCase){this.value=this.value.toLowerCase();}
      if(sDate){
        this.setAttribute("filter","\\d");
      }
      var sFmtfilter=this.getAttribute("filter");
      if(sFmtfilter){
        var re=new RegExp('[^'+sFmtfilter+']');
        var sFrmFormat=oElement.getAttribute("format");
        if(sFrmFormat){
          rex=sFrmFormat;
          while(rex.indexOf('*')!=-1)rex=rex.replace('*','['+sFmtfilter+']');
          rex='^'+rex+'$';
          rex=new RegExp(rex);
          if(!rex.test(this.value)){oElement.value='';}
          }else{
          if(re.test(this.value)){oElement.value='';}
          if(browser.isGecko){event.preventDefault();}
          else{window.event.returnValue=false;}
        }
      }
      if(sFmtFloatBrasil){
        //this.value=floatBr(this.value);
        this.value=floatBrComSeparador(this.value);
      }
      //var sFmtDate=this.getAttribute("fmtdata");
      if(sDate){
        if(!isDate(this.value)){
          this.value='';
        }
        //this.value=fmtDateBr(this.value);
      }
      try{this.oldOnBlur();}catch(err){}
    }
    //if(browser.isGecko)window.captureEvents(Event.FOCUS);
    oElement.oldOnFocus=oElement.onfocus;
    oElement.onfocus=function(event){
      var sFmtFloatBrasil=oElement.getAttribute("float")=="float";
      var sInt=oElement.getAttribute("int")=="int";
      var sDate=oElement.getAttribute("date")=="date";
      if(sFmtFloatBrasil){
        //this.value=floatBr(this.value);
        this.value=floatBr(this.value);
        this.select();
      }
      if(sInt){
        this.value=int(this.value);
        this.select();
      }
      if(sDate){
        this.select();
      }
      try{this.oldOnFocus();}catch(err){}
    }
    //if(browser.isGecko)window.captureEvents(Event.KEYPRESS);
    oElement.oldOnKeypress=oElement.onkeypress;
    oElement.onkeypress=function(event){
      var sFmtFloatBrasil=oElement.getAttribute("float")=="float";
      var sInt=oElement.getAttribute("int")=="int";
      var sDate=oElement.getAttribute("date")=="date";
      var keyCode=(!window.event)? event.which:window.event.keyCode;
      pressedKey=String.fromCharCode(keyCode);
      if(pressedKey.charCodeAt(0)==9 || pressedKey=='\r' || parseInt(pressedKey.charCodeAt(0))==0 || parseInt(pressedKey.charCodeAt(0))==8 || pressedKey==''){
        return true;
      }
      if(this.selectionEnd>this.selectionStart)
      {
        this.value = this.value.substr(0,this.selectionStart) + this.value.substr(this.selectionEnd,this.value.length);
      }
      var sFmtUpperCase=this.getAttribute("upper")=="upper";
      if(sFmtUpperCase){
        this.value=this.value.toUpperCase();
        this.style.textTransform='uppercase';
      }
      var sFmtLowerCase=this.getAttribute("lower")=="lower";
      if(sFmtLowerCase){this.style.textTransform='lowercase';}
      if(sDate){
        this.setAttribute("filter","\\d");
      }
      var sFmtfilter=this.getAttribute("filter");
      if(sFmtfilter){
        var sKey=String.fromCharCode(keyCode);
        var re=new RegExp('[^'+sFmtfilter+']');
        if(re.test(sKey)){
          try{event.preventDefault();}catch(err){window.event.returnValue=false;}
          return false
        }
      }
      var sformat = this.getAttribute("format");
      var tForm = this.form;
      var elementobj = null;
      
      
        try{
          if(sDate){
            this.setAttribute("format","**/**/****");
          }
          var sFrmFormat=this.getAttribute("format");
          if(sFrmFormat){
            var stext=this.value;
            var sKey=String.fromCharCode(keyCode);
            var strSelection=(document.selection)? document.selection.createRange().text:this.value.substr(this.selectionStart,this.selectionEnd);
            if(strSelection!=''){
              this.value='';
              try{
                event.preventDefault();
                }catch(err){
                window.event.returnValue=false;
              }
              }else{
              if(sFrmFormat.substr(stext.length,1)=='*'){
                if((sFrmFormat.substr(stext.length+1,1)!='*')&&(sFrmFormat.substr(stext.length+1,1)!='')){
                  this.value=this.value+sKey+sFrmFormat.substr(stext.length+1,1);
                  try{
                    event.preventDefault();
                  }catch(err){
                    window.event.returnValue=false;
                  }
                  this.setSelectionRange(this.value.length,this.value.length);
                 }else{
                    this.value = this.value+sKey;
                    try{
                      event.preventDefault();
                    }catch(err){
                      window.event.returnValue=false;
                    }
                    this.setSelectionRange(this.value.length,this.value.length);
                    //this.value = s.substr(0,this.selectionStart) + s.substr(this.selectionEnd,s.length);
                    //window.event.returnValue=false;
                    //return true;
                 }
                }else{
                if(stext.length+1<=sFrmFormat.length){
                  this.value=this.value+sFrmFormat.substr(stext.length,1)+sKey;
                  this.setSelectionRange(this.value.length,this.value.length);
                }
                try{
                  event.preventDefault();
                  }catch(err){
                  window.event.returnValue=false;
                }
              }
            }
          }
          var sFmtFloatBrasil=this.getAttribute("float")=="float";
          if(sFmtFloatBrasil){
            var sKey=String.fromCharCode(keyCode);
            var re=new RegExp('[^0-9,]|(,[0-9]*,)');
            var atestar=this.value+sKey
            if(re.test(atestar)){
              if(browser.isGecko){
                event.preventDefault();
                }else{
                window.event.returnValue=false;
              }
            }
          }
          var sInt=this.getAttribute("int")=="int";
          if(sInt){
            var sKey=String.fromCharCode(keyCode);
            var re=new RegExp('[^0-9]');
            var atestar=this.value+sKey
            if(re.test(atestar)){
              if(browser.isGecko){
                event.preventDefault();
                }else{
                window.event.returnValue=false;
              }
            }
          }
          var sAutotab = this.getAttribute("tab");
          var smaxlength = this.getAttribute("maxlength");
          if(sAutotab){
            if(sformat){
              maxlength = sformat.length;
            } else {
              maxlength = this.getAttribute("maxlength");
            }
            if(this.value.length==maxlength){
              elementobj = document.getElementById(sAutotab)
            }
          }

        }finally{
        if(elementobj){
          try{elementobj.focus();}catch(err){}
          try{elementobj.select();}catch(err){}
        }
        try{
          this.oldOnKeypress();
        }catch(err){}
      }
    }
  }
}

function isEmpty(s){
  var re=/\s/g;
  var s=s.replace(re,"");
  RegExp.multiline=true;
  return(s.length==0 || s=='0,0')? true:false;
}

var MONTH_NAMES=new Array('January','February','March','April','May','June','July','August','September','October','November','December','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
var DAY_NAMES=new Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sun','Mon','Tue','Wed','Thu','Fri','Sat');
function LZ(x){return(x<0||x>9?"":"0")+x}
function isDate(val,format){
  if(format==null)
  format='d/M/yyyy';
  var date=getDateFromFormat(val,format);
  if(date==0){return false;}
  return true;
}
function v_isDate(v,e){
  return isDate(v);
}

function compareDates(date1,dateformat1,date2,dateformat2){
  var d1=getDateFromFormat(date1,dateformat1);
  var d2=getDateFromFormat(date2,dateformat2);
  if(d1==0 || d2==0){
    return -1;
  }
  else if(d1>d2){
    return 1;
  }
  return 0;
}
function formatDate(date,format){
  format=format+"";
  var result="";
  var i_format=0;
  var c="";
  var token="";
  var y=date.getYear()+"";
  var M=date.getMonth()+1;
  var d=date.getDate();
  var E=date.getDay();
  var H=date.getHours();
  var m=date.getMinutes();
  var s=date.getSeconds();
  var yyyy,yy,MMM,MM,dd,hh,h,mm,ss,ampm,HH,H,KK,K,kk,k;
  var value=new Object();
  if(y.length<4){y=""+(y-0+1900);}
  value["y"]=""+y;
  value["yyyy"]=y;
  value["yy"]=y.substring(2,4);
  value["M"]=M;
  value["MM"]=LZ(M);
  value["MMM"]=MONTH_NAMES[M-1];
  value["NNN"]=MONTH_NAMES[M+11];
  value["d"]=d;
  value["dd"]=LZ(d);
  value["E"]=DAY_NAMES[E+7];
  value["EE"]=DAY_NAMES[E];
  value["H"]=H;
  value["HH"]=LZ(H);
  if(H==0){value["h"]=12;}
  else if(H>12){value["h"]=H-12;}
  else{value["h"]=H;}
  value["hh"]=LZ(value["h"]);
  if(H>11){value["K"]=H-12;}else{value["K"]=H;}
  value["k"]=H+1;
  value["KK"]=LZ(value["K"]);
  value["kk"]=LZ(value["k"]);
  if(H>11){value["a"]="PM";}
  else{value["a"]="AM";}
  value["m"]=m;
  value["mm"]=LZ(m);
  value["s"]=s;
  value["ss"]=LZ(s);
  while(i_format<format.length){
    c=format.charAt(i_format);
    token="";
    while((format.charAt(i_format)==c)&&(i_format<format.length)){
      token+=format.charAt(i_format++);
    }
    if(value[token]!=null){result=result+value[token];}
    else{result=result+token;}
  }
  return result;
}
function _isInteger(val){
  var digits="1234567890";
  for(var i=0;i<val.length;i++){
    if(digits.indexOf(val.charAt(i))==-1){return false;}
  }
  return true;
}
function _getInt(str,i,minlength,maxlength){
  for(var x=maxlength;x>=minlength;x--){
    var token=str.substring(i,i+x);
    if(token.length<minlength){return null;}
    if(_isInteger(token)){return token;}
  }
  return null;
}
function getDateFromFormat(val,format){
  val=val+"";
  format=format+"";
  var i_val=0;
  var i_format=0;
  var c="";
  var token="";
  var token2="";
  var x,y;
  var now=new Date();
  var year=now.getYear();
  var month=now.getMonth()+1;
  var date=1;
  var hh=now.getHours();
  var mm=now.getMinutes();
  var ss=now.getSeconds();
  var ampm="";
  while(i_format<format.length){
    c=format.charAt(i_format);
    token="";
    while((format.charAt(i_format)==c)&&(i_format<format.length)){token+=format.charAt(i_format++);}
    if(token=="yyyy" || token=="yy" || token=="y"){
      if(token=="yyyy"){x=4;y=4;}
      if(token=="yy"){x=2;y=2;}
      if(token=="y"){x=2;y=4;}
      year=_getInt(val,i_val,x,y);
      if(year==null){return 0;}
      i_val+=year.length;
      if(year.length==2){
        if(year>70){year=1900+(year-0);}
        else{year=2000+(year-0);}
      }
    }
    else if(token=="MMM"||token=="NNN"){
      month=0;
      for(var i=0;i<MONTH_NAMES.length;i++){
        var month_name=MONTH_NAMES[i];
        if(val.substring(i_val,i_val+month_name.length).toLowerCase()==month_name.toLowerCase()){
          if(token=="MMM"||(token=="NNN"&&i>11)){
            month=i+1;
            if(month>12){month -=12;}
            i_val+=month_name.length;
            break;
          }
        }
      }
      if((month<1)||(month>12)){return 0;}
    }
    else if(token=="EE"||token=="E"){
      for(var i=0;i<DAY_NAMES.length;i++){
        var day_name=DAY_NAMES[i];
        if(val.substring(i_val,i_val+day_name.length).toLowerCase()==day_name.toLowerCase()){
          i_val+=day_name.length;
          break;
        }
      }
    }
    else if(token=="MM"||token=="M"){
      month=_getInt(val,i_val,token.length,2);
      if(month==null||(month<1)||(month>12)){return 0;}
      i_val+=month.length;}
    else if(token=="dd"||token=="d"){
      date=_getInt(val,i_val,token.length,2);
      if(date==null||(date<1)||(date>31)){return 0;}
      i_val+=date.length;}
    else if(token=="hh"||token=="h"){
      hh=_getInt(val,i_val,token.length,2);
      if(hh==null||(hh<1)||(hh>12)){return 0;}
      i_val+=hh.length;}
    else if(token=="HH"||token=="H"){
      hh=_getInt(val,i_val,token.length,2);
      if(hh==null||(hh<0)||(hh>23)){return 0;}
      i_val+=hh.length;}
    else if(token=="KK"||token=="K"){
      hh=_getInt(val,i_val,token.length,2);
      if(hh==null||(hh<0)||(hh>11)){return 0;}
      i_val+=hh.length;}
    else if(token=="kk"||token=="k"){
      hh=_getInt(val,i_val,token.length,2);
      if(hh==null||(hh<1)||(hh>24)){return 0;}
      i_val+=hh.length;hh--;}
    else if(token=="mm"||token=="m"){
      mm=_getInt(val,i_val,token.length,2);
      if(mm==null||(mm<0)||(mm>59)){return 0;}
      i_val+=mm.length;}
    else if(token=="ss"||token=="s"){
      ss=_getInt(val,i_val,token.length,2);
      if(ss==null||(ss<0)||(ss>59)){return 0;}
      i_val+=ss.length;}
    else if(token=="a"){
      if(val.substring(i_val,i_val+2).toLowerCase()=="am"){ampm="AM";}
      else if(val.substring(i_val,i_val+2).toLowerCase()=="pm"){ampm="PM";}
      else{return 0;}
      i_val+=2;}
    else{
      if(val.substring(i_val,i_val+token.length)!=token){return 0;}
      else{i_val+=token.length;}
    }
  }
  if(i_val!=val.length)return 0;
  if(month==2){
    if(((year%4==0)&&(year%100!=0))||(year%400==0)){
      if(date>29)return 0;
    }
    else{if(date>28)return 0}
  }
  if((month==4)||(month==6)||(month==9)||(month==11)){
    if(date>30)return 0;
  }
  if(hh<12 && ampm=="PM"){hh=hh-0+12;}
  else if(hh>11 && ampm=="AM"){hh-=12;}
  var newdate=new Date(year,month-1,date,hh,mm,ss);
  return newdate.getTime();
}
function parseDate(val){
  var preferEuro=(arguments.length==2)?arguments[1]:false;
  generalFormats=new Array('y-M-d','MMM d,y','MMM d,y','y-MMM-d','d-MMM-y','MMM d');
  monthFirst=new Array('M/d/y','M-d-y','M.d.y','MMM-d','M/d','M-d');
  dateFirst=new Array('d/M/y','d-M-y','d.M.y','d-MMM','d/M','d-M');
  var checkList=new Array('generalFormats',preferEuro?'dateFirst':'monthFirst',preferEuro?'monthFirst':'dateFirst');
  var d=null;
  for(var i=0;i<checkList.length;i++){
    var l=window[checkList[i]];
    for(var j=0;j<l.length;j++){
      d=getDateFromFormat(val,l[j]);
      if(d!=0){return new Date(d);}
    }
  }
  return null;
}
function isEmail(email){
  validEmail=/^([\w\.\-])+@+([\w\.\-])+([\.])+([\w\.\-])+$/i;
  if(!validEmail.test(email)){
    return false;
  }
  return true;
}
function isCnpj(cnpj){
  var erro=0;
  quatorze=/^(\d{14})+$/;
  soNum=/^(\d{2})+\.+(\d{3})+\.+(\d{3})+(\/|\\)+(\d{4})+\-+(\d{2})+$/;
  if(!quatorze.test(cnpj)){
    if(soNum.test(cnpj)){
      num=soNum.exec(cnpj);
      cnpj=num[1]+num[2]+num[3]+num[5]+num[6];
      }else{
      erro++;
    }
  }
  var a=[];
  var b=new Number;
  var c=[6,5,4,3,2,9,8,7,6,5,4,3,2];
  for(i=0;i<12;i++){
    a[i]=cnpj.charAt(i);
    b+=a[i] * c[i+1];
  }
  a[12]=((x=b % 11)<2)? 0:11 - x;
  b=0;
  for(y=0;y<13;y++){
    b+=(a[y] * c[y]);
  }
  a[13]=((x=b % 11)<2)? 0:11-x;
  if((cnpj.charAt(12)!=a[12])||(cnpj.charAt(13)!=a[13])){
    erro++;
  }
  if(erro>0){
    return false;
  }
  return true;
}
function isCpf(cpf){
  var erro=0;
  onze=/^(\d{11})+$/;
  if(!onze.test(cpf)){
    soNum=/^(\d{3})+\.+(\d{3})+\.+(\d{3})+\-+(\d{2})+$/;
    if(soNum.test(cpf)){
      num=soNum.exec(cpf);
      cpf=num[1]+num[2]+num[3]+num[4];
      }else{
      erro++;
    }
  }
  if(cpf=="00000000000" || cpf=="11111111111" || cpf=="22222222222" || cpf=="33333333333" || cpf=="44444444444" || cpf=="55555555555" || cpf=="66666666666" || cpf=="77777777777" || cpf=="88888888888" || cpf=="99999999999"){
    erro++;
  }
  var a=[];
  var b=new Number;
  var c=11;
  for(var i=0;i<11;i++){
    a[i]=cpf.charAt(i);
    if(i<9){
      b+=(a[i] * --c);
    }
  }
  a[9]=((x=b % 11)<2)? 0:11 - x;
  b=0;
  c=11;
  for(y=0;y<10;y++){
    b+=(a[y] * c--);
  }
  a[10]=((x=b % 11)<2)? 0:11 - x;
  if((cpf.charAt(9)!=a[9])||(cpf.charAt(10)!=a[10])){
    erro++;
  }
  if(erro>0){
    return false;
  }
  return true;
}
function trim(aString){
  result=String(aString).replace(/^[\s]+/g,"");
  return result.replace(/[\s]+$/g,"");
}
function zfill(s,n){
  s=String(s);
  while(s.length<n){
    s='0'+s;
  }
  return s;
}

function _parseFloat(numero){
  numero=trim(numero);
  if(numero==''){numero='0'}
  numero=numero.replace('.','');
  numero=numero.replace(',','.');
  return parseFloat(numero);
}


function floatBrComSeparador(numero){
  var tempn;
  var temp;
  if(numero.length){
    for(var i=0;i<numero.split('.').length;i++){
      numero = numero.replace('.','');
    }
    numero = numero.replace(',','.');
  } else {
    numero = trim(String(numero));
  }
  tempn = numero.split('.');
  if(!tempn[1] || tempn[1]=='undefined'){tempn[1]='00';}
  if(!tempn[0] || tempn[0]=='undefined'){tempn[0]='0';}
  res=String(parseFloat(tempn[0]+'.'+tempn[1])).replace('.',',');
  temp=String(res).split(',');
  if(!temp[1] || temp[1]=='undefined'){temp[1]='00';}
  var s = String(temp[1]);
  if(s.length>2)
  {
    temp[1] = s.substring(0,2);
  } else if(s.length==1){
    temp[1] = s + '0';
  } else if(s.length==0){
    temp[1] = '00';
  }

  var l = trim(String(temp[0]));
  var s = ''
  var ll = l.length;
  var cc = 0;
  for(var c=ll;c>0;c--){
    s = l.substring(c-1,c) + s;
    //alert(((cc+1)));
    if(((cc+1) % 3)==0){
      s = '.' + s
    }
    cc++;    
  }
  if(s.substring(0,1)=='.'){
    s = s.substring(1,s.length);
  } 
  temp[0] = s;
  
  res=temp[0]+','+temp[1];
  return res
}

//alert(floatBrComSeparador(0.3));

function floatBr(numero){
  var tempn;
  var temp;
  numero = trim(String(numero));
  for(var i=0;i<numero.split('.').length;i++){
    numero = numero.replace('.','');
  }
  numero = numero.replace(',','.');
  tempn = numero.split('.');
  if(!tempn[1] || tempn[1]=='undefined'){tempn[1]='00';}
  if(!tempn[0] || tempn[0]=='undefined'){tempn[0]='0';}
  res=String(parseFloat(tempn[0]+'.'+tempn[1])).replace('.',',');
  temp=String(res).split(',');
  if(!temp[1] || temp[1]=='undefined'){temp[1]='00';}
  var s = String(temp[1]);
  if(s.length>2)
  {
    temp[1] = s.substring(0,2);
  }
  /*s = ''
  l = String(temp[0]);
  ll = temp[0].length;
  for(var c=ll;c>0;c--){
    s = l.substring(c-1,c) + s;
    if(((c+1) % 3)==0){
      s = '.' + s
    }
  }
  temp[0] = s;*/
  res=temp[0]+','+temp[1];
  return res
}

function fmtDateBr(pData){
  var erro=0;
  var hoje=new Date();
  var anoatual=hoje.getFullYear()+'0';
  while(pData.indexOf('-')!=-1){pData=pData.replace('-','/');}
  var tempn=pData.split('/');
  if(!tempn[0] || tempn[0].match('[^0-9]')){erro++;}
  else{tempn[0]=zfill(tempn[0],2);}
  if(!tempn[1] || tempn[1].match('[^0-9]')){erro++;}
  else{tempn[1]=zfill(tempn[1],2);}
  if(!tempn[2]){tempn[2]=anoatual.substr(0,4);}
  else if(tempn[2].match('[^0-9]')){tempn[2]=anoatual.substr(0,4);}
  else{
    var num;
    num=tempn[2].length;
    num=4 - num;
    tempn[2]=anoatual.substr(0,num)+tempn[2];
    tempn[2]=tempn[2].substr(0,4);
  }
  var newData=tempn[0]+'/'+tempn[1]+'/'+tempn[2];
  if(erro>0 ||!isDate(newData)){return '';}
  else{return newData;}
}
function fmtDate(sdata,formato,formatoresp){
  if(trim(sdata)=='')return '';
  if(formato==null)formato='%d/%m/%Y';
  if(formatoresp==null)formatoresp=formato;
  cstrs=[];
  respcstrs=[];
  irespcstrs=[];
  others=[];
  sdata=String(sdata);
  dAtual=new Date();
  erro=0;
  re=/[%d|%m|%y|%Y|%H|%M|%S]/;
  result='';
  pattern={
    '%d':dAtual.getDate(),
    '%m':zfill(dAtual.getMonth()+1,2),'%y':String(dAtual.getFullYear()).substr(2,4),
    '%Y':dAtual.getFullYear(),
    '%H':dAtual.getHours(),
    '%M':String(dAtual.getMinutes()),
    '%S':zfill(dAtual.getSeconds(),2)
    };
  if(browser.isIe){
    formato=formato.split('');
    formatoresp=formatoresp.split('');
  }
  for(i=0;i<formato.length;i++){
    str=formato[i];
    if(str=='%' && formato[i+1]!='%'){
      ++i;
      str='%'+formato[i];
    }
    cstrs.push({'s':str,'i':i});
  }
  for(i=0;i<formatoresp.length;i++){
    str=formatoresp[i];
    if(str=='%' && formatoresp[i+1]!='%'){
      ++i;
      str='%'+formatoresp[i];
    }
    respcstrs.push({'s':str,'i':i});
  }
  auxsdata=sdata;
  while(auxsdata.indexOf(' ')!=-1)auxsdata=auxsdata.replace(' ',';');
  while(auxsdata.indexOf('-')!=-1)auxsdata=auxsdata.replace('-',';');
  while(auxsdata.indexOf(':')!=-1)auxsdata=auxsdata.replace(':',';');
  while(auxsdata.indexOf('/')!=-1)auxsdata=auxsdata.replace('/',';');
  retsdata=auxsdata.split(';');
  o=0;
  for(i in cstrs){
    if(re.test(cstrs[i]['s'])){
      pa=pattern[cstrs[i]['s']];
      di='';
      if(o<retsdata.length)di=retsdata[o];
      o++;
      if((cstrs[i]['s']=='%Y')&&(di.length<4)){
        di=String(pa).substr(0,(4 - di.length))+di;
        }else{
        di=zfill(di,2);
      }
      if(di=='00')di=pa;
      irespcstrs[String(cstrs[i]['s'])]=di;
    }
  }
  for(i in respcstrs){
    if(re.test(respcstrs[i]['s'])){
      result+=irespcstrs[String(respcstrs[i]['s'])];
      }else{
      result+=respcstrs[i]['s'];
    }
  }
  return result;
}
