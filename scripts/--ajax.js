var xmlHttp
var completed = 1;
function showHint(str)
{ 
if (str.length > 0)
{ 
var url = str;
xmlHttp=GetXmlHttpObject(stateChanged);
xmlHttp.open("GET", url , true);
xmlHttp.send(null);
} 
else
{ 
document.getElementById("txtHint").innerHTML="";
} 
} 

function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
{
	alert(xmlHttp.responseText);
document.getElementById(display_ajax_id).innerHTML=xmlHttp.responseText; 

} 
} 

function GetXmlHttpObject(handler)
{ 
var objXmlHttp=null;

if (navigator.userAgent.indexOf("Opera")>=0)
{
alert("This example doesn't work in Opera") 
return 
}
if (navigator.userAgent.indexOf("MSIE")>=0)
{ 
var strName="Msxml2.XMLHTTP"
if (navigator.appVersion.indexOf("MSIE 5.5")>=0)
{
strName="Microsoft.XMLHTTP"
} 
try
{ 
objXmlHttp=new ActiveXObject(strName);
objXmlHttp.onreadystatechange=handler; 
return objXmlHttp;
} 
catch(e)
{ 
alert("Error. Scripting for ActiveX might be disabled") 
return 
} 
} 
if (navigator.userAgent.indexOf("Mozilla")>=0)
{
objXmlHttp=new XMLHttpRequest();
objXmlHttp.onload=handler;
objXmlHttp.onerror=handler; 
return objXmlHttp;
}
} 

function get_dynamic_dropdown(disp_id, file_name, q_str)
{
		
		display_ajax_id = disp_id;
		
		/*
		if(disp_id == 'maxmileid')
		alert(disp_id + ' - ' + file_name + ' - ' + q_str);
		*/
		var u = file_name + '?' + q_str;
		//alert(u);
		showHint(u);
}
function get_dynamic_dropdown1(disp_id, file_name, q_str)
{
		display_ajax_id = disp_id;
		/*
		if(disp_id == 'maxmileid')
		alert(disp_id + ' - ' + file_name + ' - ' + q_str);
		*/
		var u = file_name + '?' + q_str;
		showHint(u);
}