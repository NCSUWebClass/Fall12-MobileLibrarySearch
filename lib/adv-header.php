<script type="text/javascript" src="../lib/scripts/filter.js"></script>

<div data-role="header"  data-position="fixed">
	<div onclick="location.href='./index.php';" style="cursor: pointer; position: absolute; height: 41px; width: 70px;"></div>
	<a onclick="location.href='./index.php';"  data-transition="slide"  data-role="button"  >Home</a>

<a href="#popupPanel" data-rel="popup" data-transition="slide"  data-role="button"  >Filter</a>

<div data-role="popup" id="popupPanel" data-corners="false" data-theme="a" data-overlay-theme="a"  data-shadow="false" data-tolerance="0,0">

<div class="refine">

	<div id="appliedFilterInfo"></div>
	<form method="get">		
		<fieldset data-role="controlgroup" data-mini="true">
			<button type="button" onclick="showFilter(this.value)" value="topic">Subject</button>
			<button type="button" onclick="showFilter(this.value)" value="genre">Genre</button>
			<button type="button" onclick="showFilter(this.value)" value="lc_class">Call Num. Location</button>
			<button type="button" onclick="showFilter(this.value)" value="library">Library</button>
			<button type="button" onclick="showFilter(this.value)" value="author">Author</button>
			<button type="button" onclick="showFilter(this.value)" value="region">Region</button>		
		</fieldset>
		<div id="filterInfo"></div>	

	</form>

</div>
</div>

<script>

$( "#popupPanel" ).on({
    popupbeforeposition: function() {
        var h = $( window ).height();
        $( "#popupPanel" ).css( "height", h);
	loadAppliedFilters();
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