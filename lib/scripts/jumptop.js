/***********************************************
* Jump To Top Link Script- ? Dynamic Drive (www.dynamicdrive.com)
* Last updated Nov 13th, 03'.
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

//Specify the text to display
var displayed="<nobr><img src='../lib/images/up.png'></nobr>"

///////////////////////////Do not edit below this line////////////

var logolink='javascript:window.scrollTo(0,0)'
var ns4=document.layers
var ie4=document.all
var ns6=document.getElementById&&!document.all

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function regenerate(){
window.location.reload()
}
function regenerate2(){
if (ns4)
setTimeout("window.onresize=regenerate",400)
}

if (ie4||ns6)
document.write('<span id="logo" style="position:absolute;top:-300px;z-index:100">'+displayed+'</span>')

function createtext(){ //function for NS4
staticimage=new Layer(5)
staticimage.left=-300
staticimage.document.write('<a href="'+logolink+'">'+displayed+'</a>')
staticimage.document.close()
staticimage.visibility="show"
regenerate2()
staticitns()
}

function staticit(){ //function for IE4/ NS6
var w2=ns6? pageXOffset+w : ietruebody().scrollLeft+w
var h2=ns6? pageYOffset+h : ietruebody().scrollTop+h
crosslogo.style.left=w2+"px"
crosslogo.style.top=h2+"px"
}

function staticit2(){ //function for NS4
staticimage.left=pageXOffset+window.innerWidth-staticimage.document.width-28
staticimage.top=pageYOffset+window.innerHeight-staticimage.document.height-10
}

function inserttext(){ //function for IE4/ NS6
if (ie4)
crosslogo=document.all.logo
else if (ns6)
crosslogo=document.getElementById("logo")
crosslogo.innerHTML='<a href="'+logolink+'">'+displayed+'</a>'
w=ns6 || window.opera? window.innerWidth-crosslogo.offsetWidth-20 : ietruebody().clientWidth-crosslogo.offsetWidth-10
h=ns6 || window.opera? window.innerHeight-crosslogo.offsetHeight-15 : ietruebody().clientHeight-crosslogo.offsetHeight-10
crosslogo.style.left=w+"px"
crosslogo.style.top=h+"px"
if (ie4)
window.onscroll=staticit
else if (ns6)
startstatic=setInterval("staticit()",100)
}

if (ie4||ns6){
if (window.addEventListener)
window.addEventListener("load", inserttext, false)
else if (window.attachEvent)
window.attachEvent("onload", inserttext)
else
window.onload=inserttext
window.onresize=new Function("window.location.reload()")
}
else if (ns4)
window.onload=createtext

function staticitns(){ //function for NS4
startstatic=setInterval("staticit2()",90)
}