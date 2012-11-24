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
	//Auto-load - work on DESKTOP
        $(function () {
		var $win = $(window);
		$win.scroll(function () {
			if ($win.height() + $win.scrollTop() == $(document).height()) {
				//document.getElementById("getmore").click();
			}
		});
        });
	//Auto show/hide review box
	//$('.reviewbox').each(function(index) {
	//	var pos = $(this).position();
	///	if(pos.top >= 10 && pos.top <= 60)
	//		$(this).show(200);
	//	else 
	//		$(this).hide(600);	
	//});
	//window.onscroll = function () {
		var scrollTop = $(window).scrollTop();
		$('.reviewbox').each(function(index) {
			var pos = $(this).position();
			if (scrollTop < (pos.top +200) && (scrollTop > pos.top-200))
				$(this).show();
			else 
				$(this).hide(); 
		});
	//}
	//Show/hide review box
	function showhide(divID) {
		$('.reviewbox').each(function(index) {
			if ($(this).attr("id") == divID)
				$(this).slideDown(100);
			else 
				$(this).slideUp(300);
		});
	}
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
	echo '<style>
	#my-wrapper {padding-top : 45px;}
	#my-wrapper form {position :fixed;top:55px;width:100%;z-index:10;}</style>';
	echo '<div id="my-wrapper">';
	echo '<ul data-role="listview" data-filter="true" data-filter-placeholder="Refine results by (Title,ISBN,Author,Format,Published)" class="results">';
	echo "\n";
	$i = 1;
	$reviewID = 0; //the id of the review box
	foreach($xml->item as $item) {
		$catalogLink = htmlspecialchars($item->catalogLink);
		$id = $item->attributes()->id;
		$title = htmlspecialchars($item->title);
		$author = htmlspecialchars($item->author);
		$pubDate = htmlspecialchars($item->pubDate);
		$format = htmlspecialchars($item->format);
		$isbn = $item->isbn;
		//strim the title
		if(strlen($title) > 90)
			$title = substr($title, 0, 90) . '...';
		$available = array();

		if (isset($item->holdings->library)) {
			foreach($item->holdings->library as $library) {
				if (isset($library->holdingsItem)) {
					foreach($library->holdingsItem as $holdingsItem) {
						$status = htmlspecialchars($holdingsItem->status);
						if($status == 'Available')
							$available[] = $status;
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
		echo '<li data-icon="false" >';
		echo '<a style="text-decoration:none; color:black" id="item' . $i . '" style="white-space:normal;margin-left:10px" href="' . $_SERVER['SCRIPT_NAME'] . '?id=' . $id . '">';
		//assign id for the item
		$reviewID = $reviewID +1;
		//if (strlen($isbn) > 1) {
		//	echo '<img width="20" height="30" style="float:left"
		//	src="http://www.syndetics.com/index.aspx?isbn=' . $isbn . '/MC.GIF&amp;client=ncstateu" alt="cover image"/>';
		//}
		echo '<div>';
		echo '<h5 style="white-space:0; margin-right:100; margin-top:0px;font-size: 1.1em">' . $title . '</h5>';
		echo '<a style="white-space:0; font-size:1.1em;text-decoration:none; color:#627ba1" href="javascript:showhide('.$reviewID.');">     [Review]     </a>';
		if(count($available) == 0) {
			if (preg_match('/(journal|magazine)/i', $format)) 
				echo '<span style="white-space:0;margin-top:0px;font-size: .6em;color: #627ba1;">See full record</span>';
			else
				echo '<span style="white-space:0;margin-top:0px;font-size: .6em;color: #627ba1;">[Not available]</span>';
		}
		else 
			echo '<span style="white-space:0;margin-top:0px;font-size: .6em;color: #627ba1;">[' . count($available) . ' available]</span>';
		echo '</div></span></a>';
		
	  //********************************************************
	  //REVIEW BOX: ISBN, AUTHOR, FORMAT, PUBLISH DATE AND COVER.
	  //********************************************************
		echo'<div  style="display: none;" class="reviewbox" id="'.$reviewID.'">';
			echo '<div style="white-space:normal; font-size:0.8em;margin-top:0px;">';
				if (strlen($isbn) > 1)
				      echo '<div style="white-space:normal;float:left;margin-left:0px;"><img class="cover" width="60" height="90" 
				      src="http://www.syndetics.com/index.aspx?isbn=' . $isbn . '/MC.GIF&amp;client=ncstateu" alt="book cover image"/></div>';
				echo '<div>';
					if (strlen($isbn) > 1)
						echo '<div><span class="isbn"><span class="label">. ISBN:</span> <span class="value">' . $isbn . '</span></span></div>';
					else
						echo '<div><span class="isbn"><span class="label">. ISBN:</span> <span class="value"> Unknown </span></span></div>';
					if($author != '') 
						echo '<div><span class="author"><span class="label">. Author:</span><span class="value">' . $author . '</span></span></div>';
					else
						echo '<div><span class="author"><span class="label">. Author:</span><span class="value"> Unknown </span></span></div>';
					echo '<div class="formatpubbox">';
						if($format != '') 
							echo '<div><span class="label">. Format: </span> <span class="value">' . $format . '</span></div>';
						else
							echo '<div><span class="label">. Format: </span> <span class="value"> Unknown </span></div>';
						if($pubDate != '') 
							echo '<div><span class="label">. Published:</span> <span class="value">' . $pubDate . '</span></div>';
						else
							echo '<div><span class="label">. Published:</span> <span class="value"> Unknown </span></div>';
						echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
		//************************  
		echo '</li>';
		echo "\n";
		$i++;
	}
	//GET THE CURRENT URL
	$url = $_SERVER['SCRIPT_NAME'] . '?';
	if($query) 
		$url .= 'query=' . $query;
	if($ntk) 
		$url .= '&Ntk=' . $ntk;
	if($n) 
		$url .= '&N=206422';

	// HANDLE ITEMS DISPLAY PER PAGE, LOAD NEXT PAGES

	if ($itemsPerPage <= $totalResults) {
		$newCount = $itemsPerPage + 20;
		$jumpto = $itemsPerPage + 1;
	}
	else 
		$jumpto = $itemsPerPage -19;
	if($newCount > $totalResults)
		$newCount = $totalResults;
	$moreItems = $totalResults - $itemsPerPage;
	if($moreItems < 20)
		$numberMoreResults = $moreItems;
	else 
		$numberMoreResults = 20;
	$url .= '&count=' . $newCount;
	$url .= '#item' . $jumpto;

	if($numberMoreResults > 0)
		echo '<li><a id="getmore" target="_self" class="loadmore" href="' . htmlentities($url) . '" onClick="recordOutboundLink(this, \'catalogResults\', \'load more\'); return false;"><span class="bold">Load ' . $numberMoreResults . ' more results...</span><br />1 to ' . $itemsPerPage . ' of ' . $totalResults . '</a></li>';
	else 
		echo '<li class="loadmore">1 to ' . $totalResults . ' of ' . $totalResults . '</li>';
	echo '</ul>';
	echo '</div>';//list div
	?>
</div><!-- /content -->
<?php
require_once('../lib/footer.php');
?>