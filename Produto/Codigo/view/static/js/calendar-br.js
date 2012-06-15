Calendar._DN = new Array
("Domingo",
 "Segunda",
 "Terça",
 "Quarta",
 "Quinta",
 "Sexta",
 "Sábado",
 "Domingo");

Calendar._SDN = new Array
("Dom",
 "Seg",
 "Ter",
 "Qua",
 "Qui",
 "Sex",
 "Sab",
 "Dom");

Calendar._FD = 0;

Calendar._MN = new Array
("Janeiro",
 "Fevereiro",
 "Março",
 "Abril",
 "Maio",
 "Junho",
 "Julho",
 "Agosto",
 "Setembro",
 "Outubro",
 "Novembro",
 "Dezembro");

Calendar._SMN = new Array
("Jan",
 "Fev",
 "Mar",
 "Abr",
 "Mai",
 "Jun",
 "Jul",
 "Ago",
 "Set",
 "Out",
 "Nov",
 "Dez");

Calendar._TT = {};
Calendar._TT["INFO"] = "Sobre o calendário";

Calendar._TT["ABOUT"] =
"Selecionar data:\n" +
"- Use as teclas \xab, \xbb para selecionar o ano\n" +
"- Use as teclas " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " para selecionar o mês\n" +
"- Clique e segure com o mouse em qualquer botão para selecionar rapidamente.";
Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Selecionar hora:\n" +
"- Clique em qualquer uma das partes da hora para aumentar\n" +
"- ou Shift-clique para diminuir\n" +
"- ou clique e arraste para selecionar rapidamente.";

Calendar._TT["PREV_YEAR"] = "Ano anterior (clique e segure para menu)";
Calendar._TT["PREV_MONTH"] = "Mês anterior (clique e segure para menu)";
Calendar._TT["GO_TODAY"] = "Ir para a data atual";
Calendar._TT["NEXT_MONTH"] = "Próximo mês (clique e segure para menu)";
Calendar._TT["NEXT_YEAR"] = "Próximo ano (clique e segure para menu)";
Calendar._TT["SEL_DATE"] = "Selecione uma data";
Calendar._TT["DRAG_TO_MOVE"] = "Clique e segure para mover";
Calendar._TT["PART_TODAY"] = " (hoje)";

Calendar._TT["DAY_FIRST"] = "Exibir %s primeiro";

Calendar._TT["WEEKEND"] = "0,6";

Calendar._TT["CLOSE"] = "Fechar";
Calendar._TT["TODAY"] = "Hoje";
Calendar._TT["TIME_PART"] = "(Shift-)Clique ou arraste para mudar o valor";

Calendar._TT["DEF_DATE_FORMAT"] = "%Y-%m-%d";
Calendar._TT["TT_DATE_FORMAT"] = "%a, %b %e";

Calendar._TT["WK"] = "sem";
Calendar._TT["TIME"] = "Hora:";