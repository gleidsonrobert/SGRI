var aXmlIds = ["MSXML2.XMLHTTP.5.0", "MSXML2.XMLHTTP.4.0",
               "MSXML2.XMLHTTP.3.0", "MSXML2.XMLHTTP",
               "MICROSOFT.XMLHTTP.1.0", "MICROSOFT.XMLHTTP.1",
               "MICROSOFT.XMLHTTP"];


function XMLClient(sUrl)
{
    this.sUrl = sUrl;
    this.oHandler = null;
    this.oXMLRequest = null;
    this.sParams = '';
    this.bdoAsync = true;
    this.sClosureNode = "";
}


XMLClient.prototype.query = function (oHandler)
{
    this.oHandler = oHandler;
    if (window.XMLHttpRequest)
    {
                if (!this.oXMLRequest)
        {
            this.oXMLRequest = new XMLHttpRequest();
        }
    }
    else if (window.ActiveXObject)
    {
                for (var i = 0; i < aXmlIds.length; i++)
        {
            try
            {
                this.oXMLRequest = new ActiveXObject(aXmlIds[i]);
                break;
            }
            catch(e)
            {
            }
        }
    }
    else
    {
        if (!this.oIframe)
        {
            var oIframe = document.createElement("IFRAME");
            oIframe.setAttribute("id", "xmlhttpFrame");
            oIframe.setAttribute("name", "xmlhttpFrame");
            oIframe.style.visibility = "hidden";
            oIframe.style.position = "absolute"
            oIframe.style.top = "0px";
            oIframe.style.left = "0px";
            document.body.appendChild(oIframe);
            this.oIframe = document.getElementById("xmlhttpFrame");
        }

        this.oIframe.setAttribute("src", this.sUrl + "?" + this.sParams);
        window.clearInterval(this.iTimeout);
        this.bJustCalled = true;
        var oSelf = this;
        this.iTimeout = window.setInterval(function() {oSelf.processReqChange(oSelf);}, 500);
    }

    if (this.oXMLRequest)
    {    
        var oSelf = this;
        if(this.bdoAsync){ this.oXMLRequest.onreadystatechange = function () {oSelf.processReqChange()}; }
        this.oXMLRequest.open("POST", this.sUrl, this.bdoAsync);
        //this.oXMLRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');		
        this.oXMLRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');		
        this.oXMLRequest.send(this.sParams);
        if(!this.bdoAsync){ this.oHandler.onLoad(this.oXMLRequest.responseText); }
    }
}


XMLClient.prototype.setAsync = function (bdoAsync)
{
    this.bdoAsync = bdoAsync;
}


XMLClient.prototype.setClosureNode = function(sNodeName)
{
    this.sClosureNode = sNodeName;
}


XMLClient.prototype.processIFrame = function()
{
    var oLoadedData = null;
    if (document.frames["xmlhttpFrame"] != null)
    {
        var sDoc = document.frames["xmlhttpFrame"].document.body.innerHTML;
        if ((sDoc.indexOf("/" + this.sClosureNode) != -1) || (sDoc.indexOf(this.sClosureNode + "/") != -1))
        {
            oLoadedData = document.frames["xmlhttpFrame"].document;
            this.iReadyState = 4;
            window.clearInterval(this.iTimeout);
        }
        return oLoadedData;
    }

}


XMLClient.prototype.processReqChange = function ()
{
    if (this.oIframe != null)
    {
        if (this.bJustCalled)
        {
            this.bJustCalled = false;
            this.iReadyState = 1;
        }
        else
        {
            oLoadedData = this.processIFrame();
            if (oLoadedData == null)
            {
                return;
            }
        }
    }

    if (this.oXMLRequest != null)
    {
        this.iReadyState = this.oXMLRequest.readyState;
    }

    switch (this.iReadyState)
    {
            case 1:
                this.oHandler.onInit();
                break;

            case 2:
                if (window.XMLHttpRequest)
                {
                    if (this.oXMLRequest.status != 200)
                    {
                        this.oHandler.onError(this.oXMLRequest.status,
                                              this.oXMLRequest.statusText);
                        this.oXMLRequest.abort();
                    }
                }
                else if (this.oIframe != null)
                {
                    this.oHandler.onError(-1, oLoadedData);
                }
                break;

            case 3:
                var contentLength = 0;
                if (window.XMLHttpRequest)
                {
                                                            try
                    {
                        contentLength = this.oXMLRequest.getResponseHeader("Content-Length");
                    }
                    catch(ex)
                    {
                    }
                    if (this.oIframe != null)
                    {
                        this.oHandler.onProgress(oLoadedData.length);
                    }
                    this.oHandler.onProgress(this.oXMLRequest.responseText.length);
                }
                break;

            case 4:
                if (this.oIframe != null)
                {
                    this.oHandler.onLoad(oLoadedData);
                }
                else
                {
                    this.oHandler.onLoad(this.oXMLRequest.responseText);
                }
                break;
    }
}


XMLClient.prototype.addParam = function (paramName, paramValue)
{
    if (this.sParams.length > 0)
    {
        this.sParams = this.sParams + "&";
    }
    this.sParams= this.sParams + paramName + "=" + escape(paramValue);
}


XMLClient.prototype.clearParameters = function ()
{
    this.sParams = "";
}


XMLClient.prototype.getReadyState = function ()
{
        return this.iReadyState;
}


XMLClient.prototype.abort = function ()
{
    try
    {
        if (this.oXMLRequest)
        {
            this.oXMLRequest.abort();
        }
        else
        {
            this.oIframe.setAttribute("src", "");
        }
    }
    catch(e)
    {
    }
}

function XMLHandler ()
{
}

XMLHandler.onInit = function ()
{
}


XMLHandler.onError = function (status, statusText)
{
}


XMLHandler.onProgress = function (dataLength)
{
}


XMLHandler.onLoad = function (responseText)
{
}

function XMLParser ()
{
        try
    {
        this.parser = new DOMParser();
    }
    catch (e)
    {
        this.parser = new ActiveXObject('Microsoft.XMLDOM');
    }
}


XMLParser.prototype.parseString = function (xmlText)
{
    try
    {
        XMLDocument = this.parser.parseFromString(xmlText, "text/xml");
    }
    catch (e)
    {
        this.parser.async = 'false';
        this.parser.loadXML(xmlText);
        XMLDocument = this.parser;
    }

    return XMLDocument;
}

