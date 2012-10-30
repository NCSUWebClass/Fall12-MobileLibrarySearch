<?php require_once('text-functions.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <title><?= $page_title ?></title>  
  <meta charset="utf-8" /> 
  <meta name="format-detection" content="telephone=no" />
  <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=0">
  <? if ($_SERVER['SERVER_NAME'] == "webdev2.lib.ncsu.edu") {?>
  <link rel="apple-touch-icon-precomposed" sizes="57x57" href="http://webdev2.lib.ncsu.edu/m/lib/images/homescreen-icon-57x57.png" />
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://webdev2.lib.ncsu.edu/m/lib/images/homescreen-icon-72x72.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://webdev2.lib.ncsu.edu/m/lib/images/homescreen-icon-114x114.png" />
  <? } else { ?>
  <link rel="apple-touch-icon-precomposed" sizes="57x57" href="http://m.lib.ncsu.edu/lib/images/homescreen-icon-57x57.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://m.lib.ncsu.edu/lib/images/homescreen-icon-72x72.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://m.lib.ncsu.edu/lib/images/homescreen-icon-114x114.png" />
	<? } ?>
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" />
  <? if ($_SERVER['SERVER_NAME'] == "webdev2.lib.ncsu.edu") {?>
  <link rel="stylesheet" href="http://webdev2.lib.ncsu.edu/m/lib/themes/ncsu-libraries-mobile-theme.min.css" />
  <link rel="stylesheet" href="http://webdev2.lib.ncsu.edu/m/lib/ncsu-libraries-mobile.css" type="text/css">
  <? } else { ?>
  <link rel="stylesheet" href="http://m.lib.ncsu.edu/lib/themes/ncsu-libraries-mobile-theme.min.css" />
  <link rel="stylesheet" href="http://m.lib.ncsu.edu/lib/ncsu-libraries-mobile.css" type="text/css">
	<? } ?>
	<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
	<script>
		$(document).bind("mobileinit", function(){
			$.mobile.ajaxEnabled = false;
			$.mobile.pushStateEnabled = false;
			$.mobile.hashListeningEnabled = false;
		});
	</script>
	<script src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script>
	<? if ($_SERVER['SERVER_NAME'] == "m.lib.ncsu.edu" or $_SERVER['SERVER_NAME'] == "www.lib.ncsu.edu") {?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-17138302-5']);
		_gaq.push(['_trackPageview']);
	
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
	<script type="text/javascript">
		function recordOutboundLink(link, category, action) {
		_gat._getTrackerByName()._trackEvent(category, action);
		setTimeout('document.location = "' + link.href + '"', 100);
		}
	</script>
	<? } ?>
</head>
<body>
	<div data-role="page" data-theme="a">