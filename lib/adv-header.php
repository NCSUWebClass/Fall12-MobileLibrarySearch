<script type="text/javascript" src="../lib/scripts/filter.js"></script>

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
	
	<fieldset data-role="controlgroup" data-mini="true">
		<select name="filter" id="filter" data-theme="a" onchange="showFilter(this.value)">
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
	<input type="submit" name="submit" value="submit" data-inline="true" data-theme="b"  data-iconpos="right" />
	-->
	<!--<div class="line-separator"></div>-->
	
	<div id="filterInfo"></div>
	
	
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