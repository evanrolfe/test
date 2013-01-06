// JavaScript Document
<!--//--><![CDATA[//><!--
function CallPrint(strid)
{
var prtContent = document.getElementById(strid);
var WinPrint =
window.open('','','left=0,top=0,width=820,height=520,toolbar=0,scrollbars=1,status=0');
WinPrint.document.write(prtContent.innerHTML);
WinPrint.document.close();
WinPrint.focus();
WinPrint.print();
//WinPrint.close();
prtContent.innerHTML=strOldOne;
}
sfHover = function() {
	var sfEls = document.getElementById("nav").getElementsByTagName("LI");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" sfhover";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);

 function check_value(which_field,check_value)
    {
	formObj = document.getElementById("reg_form");
	if(formObj.elements[which_field].value==check_value){
	formObj.elements[which_field].value="";
   return;
	}
	}
function hidediv(id) {
	//safe function to hide an element with a specified id
	if (document.getElementById) { // DOM3 = IE5, NS6
		$("#"+id).hide("slow");
	}
	else {
		if (document.layers) { // Netscape 4
			$("#"+id).hide("slow");
		}
		else { // IE 4
			$("#"+id).hide("slow");
		}
	}
}

function showdiv(id) {
	//safe function to show an element with a specified id
		  
	if (document.getElementById) { // DOM3 = IE5, NS6
		$("#"+id).show("slow");
	}
	else {
		if (document.layers) { // Netscape 4
			$("#"+id).show("slow");
		}
		else { // IE 4
			$("#"+id).show("slow");
		}
	}
}
function flip_tab(id){
	


 if(document.getElementById(id))
 {
	
	if (document.getElementById(id).style.display == 'block')
	{ // DOM3 = IE5, NS6
		hidediv(id);
	}
	else
	{
		showdiv(id);
	}
 }
}
$(document).ready(function() {
			$("a.zoom2").fancybox({
				'frameWidth'		:	660,
				'frameHeight'		:	400,
				'zoomSpeedIn'		:	500,
				'zoomSpeedOut'		:	500,
				'hideOnContentClick'	:	false,
				'overlayOpacity'	:	0.7,
				'overlayColor'		:	'#000'
			});
			$("a.zoom3").fancybox({
				
				'zoomSpeedIn'		:	500,
				'zoomSpeedOut'		:	500,
				'overlayColor'		:	'#000'
			});
		});
     
//--><!]]>
