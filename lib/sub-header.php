<div data-role="header">
	<div onclick="location.href='../index.php';" style="cursor: pointer; position: absolute; height: 41px; width: 70px;"></div>
	<a onclick="history.go(-1);return true;" data-transition="slide"  data-role="button"  >Back</a>
	<a href="../index.php" data-role="none"><img src="../lib/images/library-logo-subpage.png" class="subpageLogo" alt="NCSU Libraries Logo"></a>
	<h1><?= truncate($page_title, 32) ?></h1>
</div>