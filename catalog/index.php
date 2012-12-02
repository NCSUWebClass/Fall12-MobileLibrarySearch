<?php
session_start();
require "catalog.php";

$scroll_to_top = true;

if($query = $_REQUEST["query"]) {
} else {
  $query = "";
}
// Ntk defines where to search for the search term (anywhere, title, journal title, author, subject heading, ISBN)
if($ntk = $_REQUEST["Ntk"]) {
} else {
  $ntk = "";
}
/*
// if N = 206422, search for available items
if($n = $_REQUEST["N"]) {
} else {
  $n = "";
}*/

if($n = $_REQUEST["N"]) {
} else {
    $n = "";
}

// page number
if($offset = $_REQUEST["offset"]) {
  $scroll_to_top = false;
} else {
  $offset = "";
}
if($count = $_REQUEST["count"]) {
    $scroll_to_top = false;
} else {
  $count = "";
}
if($id = $_REQUEST["id"]) {
} else {
  $id = "";
}

if ($query) {
  $xml = search($query, $ntk, $n, $offset, $count, $id);
  $resultcount = $xml->searchInfo->totalResults;
// If there are no results, show starting page*************************
  if($resultcount==0) {
    $failed_search = True;
    require "form.php";
  }
//*********************************************************************
// If there is just one result, go to 'single.tpl' which is almost identical to detail.tpl except for modified breadcrumb
  /* JMC
  elseif($resultcount==1) {
  $id = $xml->item->attributes()->id;  
  $xml = search_detail($id);
    require "$prefix/single.tpl";
  }*/
//***********************SHOWING SEARCH RESULTS*******************
  else {
    //Declare global variables
    $_SESSION['query'] = $query;
    $_SESSION['ntk'] = $ntk;
    $_SESSION['n'] = urlencode($n);
    session_start();
    $page_title = "Books &amp; Media";
    require_once('../lib/page-header.php');
    require_once('../lib/adv-header.php');
    require_once('result-functions.php');
          ?>
      <!--<script type="text/javascript">
      var i = 0;
      $(document).bind("ready", function(){
	for(; i<10; i++)
		$("#list").append($("echo'<li>x<br></li>';"));
	$("#list").listview('refresh');
	$('#footer').waypoint(function (a, b) {
	        alert('de');
		$("#list").append($("echo'<li>x<br></li>';"));
		$("#list").listview('refresh');
		$('#footer').waypoint({ offset:'100%'});
	}, { offset:'100%'});
      });
      </script>-->
      <?php
    //creating a content holder
    echo '<div id="content" data-role="content"><ul id ="list" data-role="listview" data-filter="true" data-filter-theme="a" data-filter-placeholder="Search content" class="results">';
    //load the content of the first page
      $url = load($query, $ntk, $n, $offset, $count, $id, $xml);
    //load more content
      //$url = load($query, $ntk, $n, $offset, $count, $id, $xml);
    echo '</ul></div>';
    //link to load more content
    echo '<div id="loader"><a name="nextpage" class="nextpage" id="nextpage" target="_self" href="' . htmlentities($url) . '" onClick="recordOutboundLink(this, \'catalogResults\', \'load more\'); return false;"><span style="text-align:center;font-size: 1.1em;line-height: 1em;">Load more...</span></a></div>';
    require_once('../lib/result-footer.php');
    require_once('../lib/footer.php');
  }
//*********************************************************************
}
// Show details for selected item *************************************
elseif ($id) {
  $xml = search_detail($id);
  require "details.php";
}
//*********************************************************************
// Show start page with message if there was an empty search***********
elseif(!$query && !$id) {
  $no_query = True;
  require "form.php";
}
//*********************************************************************
?>