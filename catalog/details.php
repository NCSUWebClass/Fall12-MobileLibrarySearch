<?php
$page_title = "Books &amp; Media";
require_once('../lib/page-header.php');
require_once('../lib/header.php');
?>
<div data-role="content" class="noPaddingTop">
<script src="email_form.js"  type="text/javascript"></script>
<script type="text/javascript">
	// scrolls for reveal text and email forms
	$(function(){
 		function scrollTo() {
 			var offset = $(this).offset();
			$.mobile.silentScroll(offset.top);
      return false;
		}
		$("div#emailForm h3.ui-collapsible-heading").click(scrollTo);
		$("div#textForm h3.ui-collapsible-heading").click(scrollTo);
		});
</script>
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



<div class="textEmailForm">

<div data-role="collapsible" id="emailForm" data-content-theme="d">
<h3>Email this record</h3>
  <form id="email-form" name="email-form" method="post" action="email.php">
    <input type="hidden" name="erecord_id" id="erecord_id" value="<?php echo $id; ?>" />
    <label for="email_to">Email address: </label>
    <input autocapitalize="off" autocorrect="off" data-theme="d" class="emailforminput" type="email" size="20" name="email_to" id="email_to" title="Send an email" />
    <input type="submit" value="Send" id="esubmit" title="Send" name="Send" onClick="_gaq.push(['_trackEvent', 'catalogDetail', 'email record']);" />
  </form>
</div>


<div data-role="collapsible" id="textForm" data-content-theme="d">
<h3>Text this record</h3>
  <form id="text-form" name="text-form" method="post" action="email.php">
    <input type="hidden" name="trecord_id" id="trecord_id" value="<?php echo $id; ?>" />
    <label for="text_provider">Mobile provider: </label>
    <select name="text_provider" id="text_provider">
        <option selected="selected" value="none">Select provider...</option>
        <option value="alltel">Alltel</option>
        <option value="att">AT&amp;T</option>
        <option value="cricket">Cricket</option>
        <option value="nextel">Nextel</option>
        <option value="sprint">Sprint</option>
        <option value="tmobile">T-Mobile</option>
        <option value="uscell">US Cellular</option>
        <option value="verizon">Verizon</option>
        <option value="virgin">Virgin Mobile</option>
    </select>
    <label for="phone_number">Phone number: </label>
    <input autocapitalize="off" autocorrect="off" class="emailforminput" type="tel" data-theme="d"  size="15" name="phone_number" id="phone_number" title="Send a text" />
    <input type="submit" value="Send" id="tsubmit" title="Send" name="Send" onClick="_gaq.push(['_trackEvent', 'catalogDetail', 'text record']);"/>
  </form>
 </div>
</div>

<?php	
}
?>
</div><!-- /content -->
<?php
require_once('../lib/footer.php');
?>