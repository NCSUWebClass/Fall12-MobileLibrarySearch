<?php

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
// if N = 206422, search for available items
if($n = $_REQUEST["N"]) {
} else {
  $n = "";
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
  $xml = search($query, $ntk, $n, $count, $id);
  $resultcount = $xml->searchInfo->totalResults;
// If there are no results, show starting page
  if($resultcount==0) {
    $failed_search = True;
    require "form.php";
  }
// If there is just one result, go to 'single.tpl' which is almost identical to detail.tpl except for modified breadcrumb
  /* JMC
  elseif($resultcount==1) {
  $id = $xml->item->attributes()->id;  
  $xml = search_detail($id);
    require "$prefix/single.tpl";
  }*/
// If there are multiple results show results page
  else {
    require "results.php";
  }
}
// Show details for selected item 
elseif ($id) {
  $xml = search_detail($id);
  require "details.php";
}
// Show start page with message if there was an empty search
elseif(!$query && !$id) {
  $no_query = True;
  require "form.php";
}

?>