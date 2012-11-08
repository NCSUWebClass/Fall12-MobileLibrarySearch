<div data-role="header">
	<div data-role="header"  data-position="fixed">
	<div onclick="location.href='../index.php';" style="cursor: pointer; position: absolute; height: 41px; width: 70px;"></div>
	<a href="../index.php" data-role="none"><img src="../lib/images/library-logo-subpage.png" class="subpageLogo" alt="NCSU Libraries Logo"></a>
	
<a href="#popupPanel" data-rel="popup" data-transition="slide"  data-role="button" >Filter</a>
			
<div data-role="popup" id="popupPanel" data-corners="false" data-theme="a"  data-shadow="false" data-tolerance="0,0">

<div class = "refine">
<form method="get">
	<input type="search" id="query" name="query" value = "" data-theme="d" />
	
	<fieldset data-role="controlgroup">
		<input type = "checkbox" name="N" id="checkbox-0" value = "206422" />
		<label for="checkbox-0">Available Items Only</label>
	</fieldset>
	
	<fieldset data-role="controlgroup">
		<select name="Ntk" id="Ntk">
			<option value="Subject">Subject</option>
			<option value="Genre">Genre</option>
			<option value="ISBN">ISBN</option>
			<option value="Region">Region</option>
			<option value="Author">Author</option>
		</select>
	</fieldset>
	
	<input type="submit" name="search" value="Search" />

</form>
</div>
</div>

<script>

$( "#popupPanel" ).on({
    popupbeforeposition: function() {
        var h = $( window ).height();

        $( "#popupPanel" ).css( "height", h );
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