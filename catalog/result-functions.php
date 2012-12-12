<?php

   //GET THE CURRENT INFORMATION***************************************************************
   function load($query, $ntk, $n, $offset, $count, $id, $xml,$previewID, $i) {
      global $totalResults,$itemsPerPage, $loadedResults, $offset;
      $url = $_SERVER['SCRIPT_NAME'] . '?';
      $url .= 'query=' . $query;
      $url .= '&Ntk=' . $ntk;
      $url .= '&N=' .$n;
   // HANDLE ITEMS DISPLAY PER PAGE, LOAD NEXT PAGES
      $loadedResults = $offset+ $itemsPerPage;
      //$page = $loadedResults/$itemsPerPage;
      if($loadedResults > $totalResults)
         $loadedResults = $totalResults;
      $remainResults = $totalResults - $loadedResults;
      //Do more search if there are still more results.
      if($remainResults > 0) {
         $offset = $offset + $itemsPerPage;
         $url .= '&offset=' . $offset;
      }
      else 
	 $url = null;
   //GET,READ AND DISPLAY XML
      readXML($xml,$loadedResults,$totalResults,$i);
      $xml = search($query, $ntk, $n, $offset, $count, $id);
      return $url;
   }
   //Translate XML items to listview items*********************************************
   function readXML($xml,$loadedResults, $totalResults, $i) {
      global $totalResults, $loadedResults, $i;
      foreach($xml->item as $item) {
	 $catalogLink = htmlspecialchars($item->catalogLink);
	 $id = $item->attributes()->id;
	 $title = htmlspecialchars($item->title);
	 $author = htmlspecialchars($item->author);
	 $pubDate = htmlspecialchars($item->pubDate);
	 $format = htmlspecialchars($item->format);
	 $isbn = $item->isbn;
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
	 //assign id for the item
	 $previewID = $previewID +1;
	 //APPEND BOOK ITEM AS A LIST ITEM
	 echo '<li class="items ui-btn ui-btn-icon-right ui-li ui-btn-up-a" data-icon="false" data-theme="a">';	 
	       echo '<a class="ui-link-inherit" style="padding:0px;text-decoration:none; color:black" id="item' . $i . '" style="white-space:normal;" href="' . $_SERVER['SCRIPT_NAME'] . '?id=' . $id . '">';
		  //strim the title
		  if(strlen($title) > 80)
		     $title = substr($title, 0, 80) . '...';
		  echo '<h5 style="margin:0px;font-size: 1.2em">' . $title . '</h5>';
		  if(count($available) == 0) {
		     if (preg_match('/(journal|magazine)/i', $format)) 
			echo '<span style="margin-top:0px;font-size: .6em;color: #627ba1;">&#160;&#160;&#160;&#160;&#160;See full record.</span>';
		     else
			echo '<span style="margin-top:0px;font-size: .6em;color: #627ba1;">&#160;&#160;&#160;&#160;&#160;Not available.</span>';
		  }
		  else 
		     echo '<span style="margin:0px;font-size: .6em;color: #627ba1;">&#160;&#160;&#160;&#160;&#160;' . count($available) . ' available.</span>';
		  //echo '<a href="#'.$previewID.'" style="margin-top:0px;font-size: 1.4em;" data-rel="popup" data-mini="true" data-inline="true" data-icon="info" data-theme="a" data-transition="slide">Preview</a>';
		  //********************************************************
		  //REVIEW BOX: ISBN, AUTHOR, FORMAT, PUBLISH DATE AND COVER.
		  //********************************************************
		  echo '<div style="margin:0px;">';
		     //$imgc = getimagesize("http://www.syndetics.com/index.aspx?isbn=' . $isbn . '/MC.GIF&amp;client=ncstateu");

		     if (strlen($isbn)>1)  {
			//if(!is_array($imgc))
			   //echo '<div style="white-space:normal;float:left;"><img class="cover" width="60" height="90" 
			   //src="../lib/images/images.JPG" alt="book cover image"/></div>';
			//else
			   echo '<div style="margin:0px;white-space:normal;float:left;"><img class="cover" width="60" height="90" 
			   src="http://www.syndetics.com/index.aspx?isbn=' . $isbn . '/MC.GIF&amp;client=ncstateu" alt="book cover image"/></div>';
                     }
		     else
			echo '<div style="margin:0;white-space:normal;float:left;"><img class="cover" width="60" height="90" 
			   src="../lib/images/images.JPG" alt="book cover image"/></div>';
		     echo '<div style="margin-left:0px;margin-bottom:0px; text-indent:10px;">';
			if (strlen($isbn) > 1)
			   echo '<div><span class="isbn"><span class="label">Call Number:</span><span class="value">' .$callNumber. '</span></span></div>';
			if($author != '') {
			   //strim the title
			   if(strlen($author) >20)
				 $author = substr($author, 0, 20) . '..';
			   echo '<div><span class="author"><span class="label">Author:</span><span class="value">' . $author . '</span></span></div>';
			}
			echo '<div class="formatpubbox">';
			   if($format != '') 
			      echo '<div><span class="label">Format: </span> <span class="value">' . $format . '</span></div>';
			   if($pubDate != '') 
			      echo '<div><span class="label">Published:</span> <span class="value">' . $pubDate . '</span></div>';
			echo '</div>';
		     echo '</div>';
		  echo '</div>';
		  //**********************************************************
	       echo '</a>';
	    echo '</li>';
	 $i++;
      }
   }
?>