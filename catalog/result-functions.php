<?php

   //GET THE CURRENT INFORMATION***************************************************************
   function load($query, $ntk, $n, $offset, $count, $id, $xml) {
      global $totalResults,$itemsPerPage, $page, $remainResults, $offset;
      $url = $_SERVER['SCRIPT_NAME'] . '?';
      $url .= 'query=' . $query;
      $url .= '&Ntk=' . $ntk;
      $url .= '&N=' .$n;
   // HANDLE ITEMS DISPLAY PER PAGE, LOAD NEXT PAGES
      $loadedResults = $offset+ $itemsPerPage;
      $page = $loadedResults/$itemsPerPage;
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
      readXML($xml);
      $xml = search($query, $ntk, $n, $offset, $count, $id);
      return $url;
   }
   //Translate XML items to listview items*********************************************
   function readXML($xml) {
      global $reviewID,$i;
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
	    //APPEND BOOK ITEM AS A LIST ITEM
	    echo '<li class="items ui-btn ui-btn-icon-right ui-li ui-li-last ui-btn-up-a" data-icon="false" data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-iconpos="right" data-theme="a">';
	    echo '<a data-transition="slide" style="text-decoration:none; color:black" id="item' . $i . '" style="white-space:normal;margin-left:10px" href="' . $_SERVER['SCRIPT_NAME'] . '?id=' . $id . '">';
	    //assign id for the item
	       $reviewID = $reviewID +1;
	    //if (strlen($isbn) > 1) 
	    //	echo '<img width="20" height="30" style="float:left" src="http://www.syndetics.com/index.aspx?isbn=' . $isbn . '/MC.GIF&amp;client=ncstateu" alt="cover"/>';
	    echo '<div>';
	       echo '<h5 style="white-space:0; margin-right:100; margin-top:0px;font-size: 1.2em">' . $title . '</h5>';
	       echo '<a style="text-decoration:overline underline; font-size:1.1em;color:#627ba1" href="javascript:showhide('.$reviewID.');">Review</a>';
	       if(count($available) == 0) {
		  if (preg_match('/(journal|magazine)/i', $format)) 
		     echo '<span style="margin-top:0px;font-size: .6em;color: #627ba1;">&#160;&#160;&#160;&#160;&#160;See full record.</span>';
		  else
		     echo '<span style="margin-top:0px;font-size: .6em;color: #627ba1;">&#160;&#160;&#160;&#160;&#160;Not available.</span>';
	       }
	       else 
		  echo '<span style="margin-top:0px;font-size: .6em;color: #627ba1;">&#160;&#160;&#160;&#160;&#160;' . count($available) . ' available.</span>';
	       echo '</div></a>';	
	       //********************************************************
	       //REVIEW BOX: ISBN, AUTHOR, FORMAT, PUBLISH DATE AND COVER.
	       //********************************************************
	       echo'<div  style="display: none;" class="reviewbox" id="'.$reviewID.'">';
		  echo '<div style="white-space:normal; font-size:0.8em;margin-top:0px;">';
		  if (strlen($isbn) > 1)
		     echo '<div style="white-space:normal;float:left;margin-left:0px;"><img class="cover" width="60" height="90" 
			src="http://www.syndetics.com/index.aspx?isbn=' . $isbn . '/MC.GIF&amp;client=ncstateu" alt="book cover image"/></div>';
		     echo '<div style="text-indent:10px;">';
			if (strlen($isbn) > 1)
			   echo '<div><span class="isbn"><span class="label">ISBN:</span> <span class="value">' . $isbn . '</span></span></div>';
			else
			   echo '<div><span class="isbn"><span class="label">ISBN:</span> <span class="value"> Unknown </span></span></div>';
		        if($author != '') {
			   //strim
			   //if(strlen($author) > 20)
			   //	$author1 = substr($author, 0, 20) . '...';
			   echo '<div><span class="author"><span class="label">Author:</span><span class="value">' . $author1 . '</span></span></div>';
			}
			else
			   echo '<div><span class="author"><span class="label">Author:</span><span class="value"> Unknown </span></span></div>';
			echo '<div class="formatpubbox">';
			   if($format != '') 
			      echo '<div><span class="label">Format: </span> <span class="value">' . $format . '</span></div>';
			   else
			      echo '<div><span class="label">Format: </span> <span class="value"> Unknown </span></div>';
			   if($pubDate != '') 
			      echo '<div><span class="label">Published:</span> <span class="value">' . $pubDate . '</span></div>';
			   else
			      echo '<div><span class="label">Published:</span> <span class="value"> Unknown </span></div>';
			echo '</div>';
		     echo '</div>';
		  echo '</div>';
	       echo '</div>';
	       //************************  
	    echo '</li>';
	 $i++;
      }
   }
?>
