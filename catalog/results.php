<?php
$page_title = "Books &amp; Media";
require_once('../lib/page-header.php');
?>
<script type="text/javascript">
	// checks for url hash and scrolls to matching anchor position
	// jquery mobile overrides browser native anchor behavior
	$(document).bind("pageshow", function() {
		if (self.document.location.hash) {
		var hash = self.document.location.hash.substring(1);
		var offset = $('a#' + hash).offset();
		setTimeout(function() { $.mobile.silentScroll(offset.top)},1000);
		}
	});
	// Show review box
	$(function(){
 		function scrollTo() {
 			var offset = $(this).offset();
			$.mobile.silentScroll(offset.top);
			return false;
		}
		//$("div#review h2.ui-collapsible-heading").click(scrollTo);
	});
</script>
<?php
require_once('../lib/header.php');
?>
<div data-role="content">
<?php
search($query, $ntk, $n, $count, $id);
$itemsPerPage = $xml->searchInfo->itemsPerPage;
$totalResults = $xml->searchInfo->totalResults;
$count = $xml->searchInfo->count;
echo '<ul data-role="listview" class="results">';
echo "\n";
$i = 1;

foreach($xml->item as $item) {
  $catalogLink = htmlspecialchars($item->catalogLink);
  $id = $item->attributes()->id;
  $title = htmlspecialchars($item->title);
  $author = htmlspecialchars($item->author);
  $pubDate = htmlspecialchars($item->pubDate);
  $format = htmlspecialchars($item->format);
  $isbn = $item->isbn;
  if(strlen($title) > 90) {
	$title = substr($title, 0, 90) . '...';
  }
  $available = array();

  if (isset($item->holdings->library)) {
      foreach($item->holdings->library as $library) {
          if (isset($library->holdingsItem)) {
              foreach($library->holdingsItem as $holdingsItem) {
                  $status = htmlspecialchars($holdingsItem->status);
                  if($status == 'Available') {
                      $available[] = $status;
                  }
              }
          }
      }
  }

  if (isset($item->holdings->library->holdingsItem)) {
      foreach($item->holdings->library->holdingsItem as $holdingsItem) {
          $callNumber = htmlspecialchars($holdingsItem->callNumber);
          $location = htmlspecialchars($holdingsItem->location);
      }
  }

  echo '<li>
  <a id="item' . $i . '" style="white-space:normal;margin-left:0px" href="' . $_SERVER['SCRIPT_NAME'] . '?id=' . $id . '">';
  if (strlen($isbn) > 1) {
	echo '<img width="20" height="30" style="float:left"
	src="http://www.syndetics.com/index.aspx?isbn=' . $isbn . '/MC.GIF&amp;client=ncstateu" alt="cover image"/>';
  }
  echo '<div><h3 style="white-space:normal;margin-top:0px; margin-left:10px">' . $title . '</h3>';
  if(count($available) == 0) {
    if (preg_match('/(journal|magazine)/i', $format)) {
	echo '<h4><span style="white-space:normal;margin-top:0px;font-size: .9em;color: #627ba1;">See full record</span></h4>';
    }
    else {
	echo '<h4><span style="white-space:normal;margin-top:0px;font-size: .9em;color: #627ba1;">Not available</span></h4>';
    }
  }
  else {
    echo '<h4><span style="white-space:normal;margin-top:0px;font-size: .9em;color: #627ba1;">' . count($available) . ' available</span></h4>';
  }
  echo '</div></a>';
 
  
  //********************************************************
  //REVIEW BOX: ISBN, AUTHOR, FORMAT, PUBLISH DATE AND COVER.
  //********************************************************
  echo'<div data-role="collapsible" data-content-theme="a" data-inline="true" data-mini="true">';
	echo '<h6>Review</h6>';
	echo '<div style="white-space:normal; font-size:0.8em;margin-top:0px;">';
	      if (strlen($isbn) > 1) {
		      echo '<div style="white-space:normal;float:left;margin-left:0px;"><img class="cover" width="60" height="90" 
		      src="http://www.syndetics.com/index.aspx?isbn=' . $isbn . '/MC.GIF&amp;client=ncstateu" alt="book cover image"/></div>';
	      }
	      echo '<div>';
		      if (strlen($isbn) > 1) {
			      echo '<div><span class="isbn"><span class="label">ISBN:</span> <span class="value">' . $isbn . '</span></span></div>';
		      }
		      if($author != '') {
			      echo '<div><span class="author"><span class="label">Author:</span> <span class="value">' . $author . '</span></span></div>';
		      }
		      echo '<div class="formatpubbox">';
			      if($format != '') {
				      echo '<div><span class="label">Format: </span> <span class="value">' . $format . '</span></div>';
			      }
			      if($pubDate != '') {
				      echo '<div><span class="label">Published:</span> <span class="value">' . $pubDate . '</span></div>';
			      }
		      echo '</div>';
	      echo '</div>';
	echo '</div>';
  echo '</div>';
  //************************  
  echo '</li>';
  echo "\n";
  $i++;
}
$url = $_SERVER['SCRIPT_NAME'] . '?';
if($query) {
  $url .= 'query=' . $query;
}
if($ntk) {
  $url .= '&Ntk=' . $ntk;
}
if($n) {
  $url .= '&N=206422';
}

// HANDLE ITEMS DISPLAY PER PAGE, LOAD NEXT PAGES

if ($itemsPerPage <= $totalResults) {
  $newCount = $itemsPerPage + 20;
  $jumpto = $itemsPerPage + 1;
}
else {

  $jumpto = $itemsPerPage -19;
}
if($newCount > $totalResults) {
  $newCount = $totalResults;
}
$moreItems = $totalResults - $itemsPerPage;
if($moreItems < 20) {
  $numberMoreResults = $moreItems;
}
else {
  $numberMoreResults = 20;
}
$url .= '&count=' . $newCount;
$url .= '#item' . $jumpto;

if($numberMoreResults > 0) {
  echo '<li class="loadmore"><a target="_self" class="loadmore" href="' . htmlentities($url) . '" onClick="recordOutboundLink(this, \'catalogResults\', \'load more\'); return false;"><span class="bold">Load ' . $numberMoreResults . ' more results...</span><br />1 to ' . $itemsPerPage . ' of ' . $totalResults . '</a></li>';
}
else {
 echo '<li class="loadmore">1 to ' . $totalResults . ' of ' . $totalResults . '</li>';
}
echo '</ul>';
?>
</div><!-- /content -->
<?php
require_once('../lib/footer.php');
?>