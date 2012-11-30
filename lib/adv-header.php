<script>
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
  alert(str);
xmlhttp.open("GET","localhost/m/lib/adv-header.php?filter="+str,true);
xmlhttp.send();
}
</script>



<div data-role="header"  data-position="fixed">
	<div onclick="location.href='../index.php';" style="cursor: pointer; position: absolute; height: 41px; width: 70px;"></div>
	<a onclick="history.go(-1);return true;" data-transition="slide"  data-role="button"  >Back</a>

<a href="#popupPanel" data-rel="popup" data-transition="slide"  data-role="button"  >Filter</a>

<div data-role="popup" id="popupPanel" data-corners="false" data-theme="a" data-overlay-theme="a"  data-shadow="false" data-tolerance="0,0">

<div class = "refine">
<form method="get">

	<!--<input type="search" id="query" name="query" value = "" data-theme="b"/> 
	
	<fieldset data-role="controlgroup">
		<input type = "checkbox" name="N" id="checkbox-0" value = "206422" data-theme="b"/>
		<label for="checkbox-0">Available Items Only</label>
	</fieldset> -->
	
	<fieldset data-role="controlgroup">
		<select name="filter" id="filter" data-theme="b" onchange="showFilter(this.value)">
			<option data-placeholder="true" value="">Select a Filter</option>
			<option value="topic">Subject</option>
			<option value="genre">Genre</option>
			<option value="lc_class">Call Number Location</option>
			<option value="library">Library</option>
			<option value="author">Author</option>
			<option value="region">Region</option>
		</select>
	</fieldset>
	<!--
	<input type="submit" name="filter" value="Go" data-inline="true" data-theme="b" data-icon="refresh" data-iconpos="right" />
	-->
	<div class="line-separator"></div>
	
	<div id="filterInfo"></div>
	
	<?php
		$filter = $_GET['filter'];
		if($xml && $filter)
		{
			//echo "$query<br>$ntk<br>$n<br>$no<br>$count<br>$id";
			foreach($xml->facet as $facet)
			{
				//echo "<p>$facet_id</p>";
				$cat = $facet->attributes()->id;
				//echo "<p>$id</p>";
				if(strcmp($cat,"topic") == 0)
				{
					//echo "<h1>$facet->id</h1>";
					//$temp = $facet->attributes()->id;
					//echo "<p>$temp</p>";
					echo "<p>$facet->title<p>";
					foreach($facet->value as $value)
						echo "$value->title ($value->count)<br>";
				}
				//else
					//echo "<h1>DO NOT PRINT.</h1>";
			}
		}
		else
			echo '<h1>TEST2<h1>';
		/*
		if($ntk)
		{
			foreach($xml->facet as $facet) 
			{
				if(strcmp($facet->id,$ntk) == 0)
				{
					echo '---$facet->title---<br>';
					echo '	<fieldset data-role="controlgroup">
								<select name="request" id="Ntk" data-theme="b">
									<option data-placeholder="true" value="">Select a Filter</option>';
					foreach($facet->value as $option)
					{						
						echo '<a href="">$option->title ($option->count)</a>'; 
					}
					break;
				}
				
			}
		}
		else
		{
		   echo '<h1>ERROR - sanity check</h1>';
		}
		*/
	?>
</form>
</div>
</div>

<script>

$( "#popupPanel" ).on({
    popupbeforeposition: function() {
        var h = $( window ).height();

        $( "#popupPanel" ).css( "height", h);
    }
});
</script>

<script>
$(document).bind("mobileinit", function(){
  $.mobile.touchOverflowEnabled = true;
});
</script>
	<h1><?= truncate($page_title, 32) ?></h1>
	
</div>