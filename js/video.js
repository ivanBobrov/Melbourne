jQuery(function($){
	var videoContainerResizeFunc = function() {
		if ($("#video-front")) {
			var height = $(window).height() < 1080 ? $(window).height() : 1080;
			$("#video-front").height(height).width($(window).width());
		}
	}
	
	videoContainerResizeFunc();
	
	$(window).on('resize', videoContainerResizeFunc);
});