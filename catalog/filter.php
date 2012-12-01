<script type="text/javascript" src="../lib/scripts/filter.js"></script>
<?php
	session_start();

	$xml = simplexml_load_string($_SESSION['xml']);
	$filter = $_GET['filter'];
	if(isset($filter) && isset($xml))
	{
		foreach($xml->facet as $facet)
		{
			$cat = $facet->attributes()->id; //category
			if(strcmp($cat,$filter) == 0) //if category == chosen filter
			{
				foreach($facet->value as $value)
				{
					$href = $value->attributes()->href;
					$start="&N=";
					$end="&view";
					$start_pos = strpos($href,$start) + 2;					
					$end_pos = strpos($href,$end,$start_pos);
					$n = substr($href, $start_pos+1, ($end_pos-1)-$start_pos);					
					
					$_SESSION['n'] = urlencode($n);					
					
					$url = 'index.php?';
					$url .= 'query=' . $_SESSION['query']; 
			 
					$url .= '&service=search';
					$url .= '&N=' . $n;
					$q = $_SESSION['query'];
					$nt = $_SESSION['ntk'];
					echo "<div><a style='color:red' href='$url'> $value->title ($value->count)</a></div>";
				}
				echo "<div id='filler'></div>";
			}
		}
	}
?>