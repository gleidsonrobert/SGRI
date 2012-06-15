// JavaScript Document
// FUNÇÃO RESPONSÁVEL DE CONECTAR A UMA PAGINA EXTERNA NO NOSSO CASO A BUSCA_NOME.PHP
// E RETORNAR OS RESULTADOS
function ajax(url)
{
	//alert(nick);
	//alert(dest);
	//alert(msg);
	
	req = null;
	// Procura por um objeto nativo (Mozilla/Safari)
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
		req.onreadystatechange = processReqChange;
		req.open("GET",url,true);
		req.send(null);
	// Procura por uma versão ActiveX (IE)
	} else if (window.ActiveXObject) {
		req = new ActiveXObject("Microsoft.XMLHTTP");
		if (req) {
			req.onreadystatechange = processReqChange;
			req.open("GET",url,true);
			req.send();
		}
	}
}
function processReqChange()
{
	// apenas quando o estado for "completado"
	if (req.readyState == 4) {
		// apenas se o servidor retornar "OK"
		if (req.status ==200) {
			// procura pela div id="pagina" e insere o conteudo
			// retornado nela, como texto HTML
			document.getElementById('pagina').innerHTML = req.responseText;
		} else {
			alert("Houve um problema ao obter os dados:n" + req.statusText);
		}
	}
}