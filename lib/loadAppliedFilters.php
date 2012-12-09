<?php
	session_start();
	if($_SESSION['xml'])
	{
		$xml = simplexml_load_String($_SESSION['xml']);
	
		if(isset($xml->searchInfo->appliedFacet[0])) //only echo if there has been at least applied filter
		{
			echo '<div class="content-primary" data-role="content" role="main" ">';
			echo '<br>';
			echo '<ul id="filter-list" data-role="listview" class="results ui-listview">';
		}
		
		foreach($xml->searchInfo->appliedFacet as $facet)
		{
			$href = $facet->value->attributes()->href;
			$st="&N=";
			$url = "broken";
			$e="&view";
			$start = strpos($href,$st) + 2;					
			$end = strpos($href,$e,$start);
			$n = substr($href, $start+1, ($end-1)-$start);	//n value of the link  to get the results which exclude said applied facet
			
			$_SESSION['n'] = urlencode($n);					
			//build URL
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
			echo '<a style="text-decoration:none; line-height:1.5em; color:red" href=' . htmlentities($url) . '><img src="../lib/images/removeIcon.gif"><span style="margin:1px 5px">' . $facet->value . ' </span></a></li>';
		}
		if(isset($xml->searchInfo->appliedFacet[0])) //only close div tag if there has been at least one applied filter
			echo "</ul></div>";
	}
?>