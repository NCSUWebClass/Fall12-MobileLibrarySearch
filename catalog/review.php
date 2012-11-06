<?php

if($id) {
  // search_detail($id); 
  $available = array();
  echo '<div>';
  echo "\n";
  $catalogLink = htmlspecialchars($xml->item->catalogLink);
  $title = htmlspecialchars($xml->item->title);
  $author = htmlspecialchars($xml->item->author);
  $pubDate = htmlspecialchars($xml->item->pubDate);
  $format = htmlspecialchars($xml->item->format);
  $isbn = trim($xml->item->isbn);
  if (strlen($isbn) > 1) {
      echo '<div class="coverimagebox"><img class="cover" style="" src="http://www.syndetics.com/index.aspx?isbn=' . $isbn . '/MC.GIF&amp;client=ncstateu" alt="book cover image"/></div>';
  }

  echo '<h3 class="title">' . truncate($title, 100) . '</h3>';

  echo '<div class="detailbox">';
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

  echo '<div class="clear"></div>';

  echo '</div>';
  echo '<div>'; 
  echo '<div class="catalogControls">';
  echo '<a href="' . $catalogLink . ' " data-role="button" style="margin-left: 0; margin-right:0;" onClick="_gaq.push([\'_trackEvent\', \'catalogDetail\', \'full catalog record\']);">View Record in Full Catalog</a>';
  echo '</div>';
  echo '</div>';  

  if (isset($xml->item->holdings->library)) {
      foreach($xml->item->holdings->library as $library) {
          echo '<div class="focal">';
          $libraryname = htmlspecialchars($library->attributes()->name);
          echo '<h3>' . $libraryname . '</h3>';
          if (preg_match('/(journal|magazine)/i', $format)) {
              echo '<div><span class="label">Availability:</span> ';
              echo '<span class="value">See full record</span></div>';
          }
          if (isset($library->holdingsItem)) {
              foreach($library->holdingsItem as $holdingsItem) {
                  $callNumber = htmlspecialchars($holdingsItem->callNumber);
                  $location = htmlspecialchars($holdingsItem->location);
                  if (isset($holdingsItem->floorLocation)) {
                      $location .= ': ' . htmlspecialchars($holdingsItem->floorLocation);
                  }
                  $status = htmlspecialchars($holdingsItem->status);
                  echo '<div class="location">';
                  if($callNumber != '') {
                      echo '<span class="label">Call number:</span> <span class="value">' . $callNumber . '</span>';
                  }
                  echo '<div><span class="label">Location:</span> <span class="value">' . $location . '</span></div>';
                  echo '<div><span class="label">Availability:</span> ';
                  if ($libraryname == 'Online') {
                      echo '<span class="value">Online</span></div></div>';
                  }
                  elseif($status != 'Available') {
                      echo '<span class="value">Not available</span></div></div>';
                  }
                  else {
                      echo '<span class="value">Available</span></div></div>';
                  }
              }
          }
          echo '</div>';
      }
  }

?>

<div>
	$( "#popupPanel" ).on({
		popupbeforeposition: function() {
			var h = $( window ).height();
			$( "#popupPanel" ).css( "height", h );
		}
        });
	<a href="#popupPanel" data-rel="popup" data-transition="slide" data-position-to="window" data-role="button">Open panel</a>
				
	<div data-role="popup" id="popupPanel" data-corners="false" data-theme="none" data-shadow="false" data-tolerance="0,0">
	
	    <button data-theme="a" data-icon="back" data-mini="true">Back</button>
	    <button data-theme="a" data-icon="grid" data-mini="true">Menu</button>
	    <button data-theme="a" data-icon="search" data-mini="true">Search</button>
		 
	</div>
</div>