/*

Correctly handle PNG transparency in Win IE 5.5 & 6.
http://homepage.ntlworld.com/bobosola. Updated 18-Jan-2006.

Use in <HEAD> with DEFER keyword wrapped in conditional comments:
<!--[if lt IE 7]>
<script defer type="text/javascript" src="pngfix.js"></script>
<![endif]-->

*/

if(navigator.appName == "Microsoft Internet Explorer"){
  TransformerPNG = function(){
    var arVersion = navigator.appVersion.split("MSIE")
    var version = parseFloat(arVersion[1])

    if ((version >= 5.5) && (document.body.filters))
    {
       for(var i=0; i<document.images.length; i++)
       {
          var img = document.images[i]
          var imgName = img.src.toUpperCase()
          if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
          {
             var imgID = (img.id) ? "id='" + img.id + "' " : ""
             var imgClass = (img.className) ? "class='" + img.className + "' " : ""
             var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
             img.style.display = 'inline-block';
             var Sstyle = img.style.cssText;
             var imgStyle = Sstyle;
             if (img.align == "left") imgStyle = "float:left;" + imgStyle;
             if (img.align == "right") imgStyle = "float:right;" + imgStyle;
             if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle;
             var Ssstyle =    " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
                           +  "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
                           +  "(src=\'" + img.src + "\', sizingMethod='scale');\"";
             //var strNewHTML = "<span " + imgID + imgClass + imgTitle + Ssstyle + "></span>";
             var strNewHTML = "<img src='/static/img/pnghack.gif' " + imgID + imgClass + imgTitle + Ssstyle + "/>";
             img.outerHTML = strNewHTML;
             //alert(strNewHTML);
             i = i-1
          }
       }
    }
  }
} else {
  TransformerPNG = function(){}
}
