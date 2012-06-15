document.write("<style>div.fora{background: #000000; width: 100%; left: 0; top: 0; position: absolute; z-index: 40000; filter: alpha(opacity=40); -moz-opacity: 0.4; opacity: 0.4; }</style>");

function hideBox()
{
	if (document.getElementById('fora') != null)
		document.body.removeChild(document.getElementById('fora'));

	if (document.getElementById('div_msg') != null)
		document.body.removeChild(document.getElementById('div_msg'));
}

function showBox(msg, tipo)
{
	var img = '../static/img/confirma01.gif';
	var cls = 'box box_ok';

	if (tipo == 'erro')
	{
		img = '../static/img/confirma02.gif';
		cls = 'box box_erro';
	}
	else if (tipo == 'help')
	{
		img = '/static/img/confirma03.gif';
		cls = 'box box_inform';
	}
	else if (tipo == 'alert')
	{
		img = '../static/img/confirma04.gif';
		cls = 'box box_inform';
	}		

	var tam_pag = tamPage();

	var div0 = document.createElement('div');
	var div1 = document.createElement('div');

	div1.className    = 'fora';
	div1.id           = 'fora';
	div1.style.height = (tam_pag.y + 'px');

	var top  = tam_pag.xScrool + ((tam_pag.h - 90 - 26) / 2);
	var left = ((tam_pag.x - 300 - 40) / 2);

	div0.className    = cls;
	div0.id           = 'div_msg';
	div0.style.zIndex = '50000';

	var div0_1     = document.createElement('div');
	var div0_1_img = document.createElement('img');

	div0_1.className = 'box_esq';
	div0_1_img.src   = img;

	div0_1.appendChild(div0_1_img);

	var div0_2    = document.createElement('div');
	var div0_2_ul = document.createElement('ul');
	var div0_2_li = document.createElement('li');

	div0_2.className = 'box_dir';

	div0_2.appendChild(div0_2_ul);
	div0_2_ul.appendChild(div0_2_li);
	div0_2_li.appendChild(document.createTextNode(msg));

	var div0_3 = document.createElement('div');
	var div0_3_a = document.createElement('a');

	div0_3.className      = 'fechar';
	div0_3.align          = 'right';
	div0_3_a.style.cursor = 'pointer';
	div0_3_a.onclick      = function() { hideBox(); };

	div0_3_a.appendChild(document.createTextNode("FECHAR [x]"));
	div0_3.appendChild(div0_3_a);

	div0.style.top     = (top < 0) ? "0px" : top + "px";
	div0.style.left    = (left < 0) ? "0px" : left + "px";
	div0.style.display = "block";

	div0.appendChild(div0_1);
	div0.appendChild(div0_2);
	div0.appendChild(div0_3);

	document.body.appendChild(div1);
	document.body.appendChild(div0);
}

function tamPage()
{
	var x, y, w, h, xScrool;

	if (window.innerHeight && window.scrollMaxY)
	{
		x = document.body.scrollWidth;
		y = window.innerHeight + window.scrollMaxY;
	}
	else if (document.body.scrollHeight > document.body.offsetHeight)
	{
		x = document.body.scrollWidth;
		y = document.body.scrollHeight;
	}
	else
	{
		x = document.body.offsetWidth;
		y = document.body.offsetHeight;
	}

	if (self.innerHeight)
	{
		w = self.innerWidth;
		h = self.innerHeight;
	}
	else if (document.documentElement && document.documentElement.clientHeight)
	{
		w = document.documentElement.clientWidth;
		h = document.documentElement.clientHeight;
	}
	else if (document.body)
	{
		w = document.body.clientWidth;
		h = document.body.clientHeight;
	}

	if (self.pageYOffset)
		xScrool = self.pageYOffset;
	else if (document.documentElement && document.documentElement.scrollTop)
		xScrool = document.documentElement.scrollTop;
	else if (document.body)
		xScrool = document.body.scrollTop;

	if (y < h)
		y = h;

	if (x < w)
		x = w;

	return { x:x, y:y, w:w, h:h, xScrool:xScrool };
}
