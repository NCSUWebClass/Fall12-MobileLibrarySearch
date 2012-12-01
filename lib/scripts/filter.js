function showFilter(str)
{
	var xmlhttp;    
	if (str=="")
	{
		document.getElementById("filterInfo").innerHTML="";
		return;
	}
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("filterInfo").innerHTML=xmlhttp.responseText;
		}
	}
	//alert(str);
	//xmlhttp.open("GET","localhost/m/lib/adv-header.php?filter="+str,true);
	xmlhttp.open("GET", "filter.php?filter="+str,true);
	xmlhttp.send();
}

function newResults(str)
{
	var xmlhttp;    
	if (str=="")
	{
		document.getElementById("filler").innerHTML="";
		return;
	}
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("filler").innerHTML=xmlhttp.responseText;
		}
	}
	//alert(str);
	//xmlhttp.open("GET","localhost/m/lib/adv-header.php?filter="+str,true);
	xmlhttp.open("GET", "newResults.php?request="+str,true);
	xmlhttp.send();
}
