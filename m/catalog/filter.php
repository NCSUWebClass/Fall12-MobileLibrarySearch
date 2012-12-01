<script type="text/javascript" src="filter.js"></script>
<?php
	session_start();
	
	//foreach($_SESSION as $key=>$value)
	//	echo "<p>$key  $value</p>";
	
	//session_start();
	//$_SESSION['xml'] = $xml;

	$xml = simplexml_load_string($_SESSION['xml']);
	
	//if(isset($_SESSION['xml']))
	//	echo '<p>WOOT!!!!</p>';
	$filter = $_GET['filter'];
	echo "<p>$filter</p>";
	//echo "<h1>$_REQUEST['filter']</h1>";
	//if($xml)
	if(isset($xml))
		echo '<p>xml defined</p>';
	if(isset($filter) && isset($xml))
	{
		//echo "$query<br>$ntk<br>$n<br>$no<br>$count<br>$id";
		foreach($xml->facet as $facet)
		{
			//echo "<p>$facet_id</p>";
			$cat = $facet->attributes()->id; //category
			//echo "<p>$id</p>";
			if(strcmp($cat,$filter) == 0) //if category == chosen filter
			{
				//echo "<h1>$facet->id</h1>";
				//$temp = $facet->attributes()->id;
				//echo "<p>$temp</p>";
				echo "<p>$facet->title<p>";
				foreach($facet->value as $value)
				{
					$href = $value->attributes()->href;
					//change buttons back to div's
					echo "<button onclick='newResults(\"$href\")'> $value->title ($value->count)</button>";
				}
				echo "<div id='filler'></div>";
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