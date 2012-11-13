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
</script>
<?php
require_once('../lib/adv-header.php');
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

  echo '<li><a id="item' . $i . '" style="white-space:normal" href="' . $_SERVER['SCRIPT_NAME'] . '?id=' . $id . '"><h3 class="notruncate">' . $title . '</h3>';
  if(count($available) == 0) {
    if (preg_match('/(journal|magazine)/i', $format)) {
	echo '<h4><span class="smallprint">See full record</span></h4>';
    } else {
	    echo '<h4><span class="smallprint">Not available</span></h4>';
    }
  }
  else {
    echo '<h4><span class="smallprint">' . count($available) . ' available</span></h4>';
  }
  echo '</a></li>';
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

// TODO: Fix this

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