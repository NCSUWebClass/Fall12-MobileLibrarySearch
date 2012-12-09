<script type="text/javascript" src="../lib/scripts/filter.js"></script>
<?php
	session_start();
	$xml = simplexml_load_string($_SESSION['xml']);
	$filter = $_GET['filter'];
	echo '<p style="text-decoration:overline underline; font-size:0.1em;color:red"></p>';
	if(isset($filter) && isset($xml))
	{
		foreach($xml->facet as $facet)
		{
			$cat = $facet->attributes()->id; //category
			if(strcmp($cat,$filter) == 0) //if category == chosen filter
			{
				echo '<div class="content-primary" data-role="content" role="main" ">';
				echo '<br>';
				echo '<ul id="filter-list" data-role="listview" class="results ui-listview">';
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
					echo '<li class="ui-btn ui-btn-icon-left ui-li ui-btn-up-a" data-theme="a" style="margin-left:0px">';
					echo '<a style="text-decoration:none; line-height:1.5em; color:black"class="nextpage" id="nextpage" target="_self" href="' . htmlentities($url) . '" onClick="recordOutboundLink(this, \'catalogResults\', \'load more\'); return false;"><img src="../lib/images/add.png"> <span>'.$vtitle.' ('.$value->count.')</span></a></li>';
				}
				echo '</ul></div>';
				echo "<div id='filler'></div>";
			}
		}
	}
?>