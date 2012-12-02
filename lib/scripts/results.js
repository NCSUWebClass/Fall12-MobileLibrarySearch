	// checks for url hash and scrolls to matching anchor position...jquery mobile overrides browser native anchor behavior
	$(document).bind("pageshow", function() {
		if (self.document.location.hash) {
		var hash = self.document.location.hash.substring(1);
		var offset = $('a#' + hash).offset();
		setTimeout(function() { $.mobile.silentScroll(offset.top)},1000);
		}
	});
	//auto show/hide review box
	//$(window).bind('scrollstart', function(event) {
	//	var scrollTop = $(window).scrollTop();
	//	$('.reviewbox').each(function(index) {
	//		var pos = $(this).position();
	//		if ((scrollTop >= pos.top+45) && (scrollTop < pos.top+100))
	//			$(this).show();
	//		else 
	//			$(this).hide(); 
	//	});
	//});
	//Show/hide review box
	function showhide(divID) {
		$('.reviewbox').each(function(index) {
			if ($(this).attr("id") == divID)
				$(this).show();
			else 
				$(this).hide();
		});
	}