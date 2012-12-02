<script type="text/javascript" src="../lib/scripts/filter.js"></script>
<?php
	session_start();
	$xml = simplexml_load_string($_SESSION['xml']);
	$filter = $_GET['filter'];
	echo '<h3 style="text-decoration:overline underline; font-size:1.3em;color:red">Select a sub-filter:</h3>';
	if(isset($filter) && isset($xml))
	{
		foreach($xml->facet as $facet)
		{
			$cat = $facet->attributes()->id; //category
			if(strcmp($cat,$filter) == 0) //if category == chosen filter
			{
				echo '<div style="width:195px;height:200px;line-height:1.5em;overflow:auto;padding:0px;background-color:white;color:black;border:4px double red;">';
				foreach($facet->value as $value)
				{
					$href = $value->attributes()->href;
					$st="&N=";
					$e="&view";
					$start = strpos($href,$st) + 2;					
					$end = strpos($href,$e,$start);
					$n = substr($href, $start+1, ($end-1)-$start);					
					
					$_SESSION['n'] = urlencode($n);					
					
					$url = 'index.php?';
					$url .= 'query=' . $_SESSION['query']; 
			 
					$url .= '&service=search';
					$url .= '&N=' . $n;
					$q = $_SESSION['query'];
					$nt = $_SESSION['ntk'];
					
					$vtitle = $value->title;
					if(strlen($vtitle) > 15)
						$vtitle = substr($vtitle, 0, 15) . '..';
					echo '<a style="text-decoration:overline; color:black"class="nextpage" id="nextpage" target="_self" href="' . htmlentities($url) . '" onClick="recordOutboundLink(this, \'catalogResults\', \'load more\'); return false;"> '.$vtitle.' ('.$value->count.')</a><br>';
				}
				echo '</div>';
				echo "<div id='filler'></div>";
			}
		}
	}
?>