$('.bg').load(function() {    

	var theWindow        = $(window),
	    $bg              = $(".bg"),
	    aspectRatio      = $bg.width() / $bg.height();

	function resizeBg() {

		if ( (theWindow.width() / theWindow.height()) < aspectRatio ) {
		    $bg
		    	.addClass('bgheight');
		} else {
		    $bg
		    	.addClass('bgwidth');
		}

	}

	theWindow.resize(function() {
		resizeBg();
	}).trigger("resize");

});