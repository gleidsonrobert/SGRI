//<![CDATA[
//******************************************************************************
// @name:        util.popup.js
// @purpose:   script para lancar um popup no centro da tela.
//
// @author:      Ruhan Bidart - ruhan@2xt.com.br
// @created:     12/05/2008
//******************************************************************************
/**
 * Gera um popup de uma janela centralizado.
 * url:                  url da pagina que sera aberta como popup.
 * nome_janela: nome da nova janela
 * atributos:       dicionario com os atributos que voce quer adicionar {'width': 100}
 */
function popup(url, nome_janela, atributos) {
    window.open(url, name, handle_atributos(atributos));	
}

/*Gera os atributos para abrir o popup*/
function handle_atributos(args) {
    var attributes = 'scrollbars=yes,directories=no,menubar=no,resizable=yes';
    if (args != null) {
        for (var i in args) attributes += ("," +  i + "=" + args[i]);

        if (args.width && args.height) {
            var winl = (screen.width - args.width)/2;
            var wint = (screen.height - args.height)/2;
        } else {
            var winl = (screen.width)/2;
            var wint = (screen.height)/2;
        }

        if (winl < 0) winl = 0;
        if (wint < 0) wint = 0;
        attributes += ", top=" + wint + ", left=" + winl;
    }
	return attributes;
}
//]]>
