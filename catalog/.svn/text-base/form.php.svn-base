<?php
$page_title = "Books &amp; Media";
require_once('../lib/page-header.php');
require_once('../lib/header.php');
?>
<div data-role="content" class="noPaddingTop">
  <?php if($failed_search) { ?>
    <div class="focal">
      <p>No matches found</p>
    </div>
  <?php } ?>

<div class="focal">
<form method="get">
			<input type="search" id="query" name="query" value="" data-theme="d" />
	
<fieldset data-role="controlgroup">
	<input type="checkbox" name="N" id="checkbox-0" value="206422"/>
	<label for="checkbox-0">Available Items Only</label>
	</fieldset>
<fieldset data-role="controlgroup">

   <select name="Ntk" id="Ntk">
	      <option value="Keyword">Anywhere</option>
	      <option value="Title">Title</option>
	      <option value="Journal_Title">Journal Title</option>
	      <option value="Author">Author</option>
	      <option value="Subject">Subject Heading</option>
	      <option value="ISBN">ISBN</option>
   </select>
	</fieldset>

   	<input type="submit" name="search" value="Search" />
   	
</form>
</div>
</div><!-- /content -->
<?php
require_once('../lib/footer.php');
?>