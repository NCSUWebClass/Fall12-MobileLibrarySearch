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
    //creating a content holder
    echo '<div id="quicksearch" data-role="content"><ul id ="results" data-role="listview" data-filter="true" data-filter-theme="a" data-filter-placeholder="Search content" class="results">';
    //load the content of the first page
      readXML($xml);
      $url =getURL($query,$ntk,$n);
    //load more content
      //if($_POST['submit']) {
      //$xml = search($query, $ntk, $n, $offset, $count, $id);
      //readXML($xml);
      //$url =getURL($query,$ntk,$n);
      //}
    echo '</ul></div>';
    //link to load more content
    echo '<a name="nextpage" class="nextpage" id="nextpage" target="_self" href="' . htmlentities($url) . '" onClick="recordOutboundLink(this, \'catalogResults\', \'load more\'); return false;"><span style="text-align:center;font-size: 1.1em;line-height: 1em;">Load more...</span></a>';
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