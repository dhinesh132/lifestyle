<html>
<head>
<script type="text/javascript" src="scripts/jquery.js"></script> 
<script type="text/javascript" src="scripts/thickbox.js"></script>
<link rel="stylesheet" href="scripts/thickbox.css" type="text/css" media="screen" />
<style type="text/css">
ul {
  padding: 0;
  margin: 0;
  list-style: none;
  }
  
li {
  float: left;
  position: relative;
  width: 10em;
  }
  
li ul {
  display: none;
  position: absolute; 
  top: 1em;
  left: 0;
  }
  
li > ul {
	top: auto;
	left: auto;
	}
li:hover ul { display: block; }

li:hover ul{ display: block; }

li:hover ul, li.over ul{ display: block; }


</style>
<script language="javascript">
startList = function() {
if (document.all&&document.getElementById) {
navRoot = document.getElementById("nav");
for (i=0; i<navRoot.childNodes.length; i++) {
node = navRoot.childNodes[i];
if (node.nodeName=="LI") {
node.onmouseover=function() {
this.className+=" over";
  }
  node.onmouseout=function() {
  this.className=this.className.replace(" over", "");
   }
   }
  }
 }
}
window.onload=startList;
</script>
</head>
<body>


<ul id="nav">
  <li>Sunfishes
    <ul >
      <li ><a href="">Blackbanded»
        sunfish</a></li>
      <li ><a href="">Shadow bass</a></li>
      <li><a href="">Ozark bass</a></li>
      <li><a href="">White crappie</a></li>
		</ul>
	</li>

  <li>Grunts
    <ul>
      <li><a href="">Smallmouth grunt
        </a></li>
      <li><a href="">Burrito</a></li>
      <li><a href="">Pigfish</a></li>
    </ul>
  </li>

  <li>Remoras
    <ul>
      <li><a href="">Whalesucker</a></li>
      <li><a href="">Marlinsucker</a></li>
      <li><a href="">Ceylonese remora</a></li>
      <li><a href="">Spearfish remora</a></li>
      <li><a href="">Slender suckerfish</a></li>
    </ul>
  </li>
</ul>


<a href="cust_login.php?height=85&width=250&modal=true" class="thickbox" title="Please Sign In">login (modal)</a>   

<a href="images/book.jpg" title="add a caption to title attribute / or leave blank" class="thickbox"><img src="images/book1.jpg" alt="Single Image"/></a></body></html>