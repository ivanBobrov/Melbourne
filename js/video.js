(function videoModule($) {

	var video = null;

	function Video(container, mp4SourceUrl) {
		var mp4SourceElement = null;
		var videoElement = null;

		this.getVideoElement = function() {
			return videoElement;
		}

		this.load = function(onLoadListener, onLoadMetadataListener) {
			if ((typeof mp4SourceUrl === 'undefined') || !container) {
				return false;
			}
			
			mp4SourceElement = $("<source>");
			mp4SourceElement.attr('type', 'video/mp4');
			mp4SourceElement.attr('src', mp4SourceUrl);

			videoElement = $("<video></video>");
			videoElement.attr('preload', 'none');
			videoElement.prop('muted', true);
			videoElement.hide();
			videoElement.css('zIndex', '1');
			videoElement.addClass('video-front-item');
			videoElement.append(mp4SourceElement);

			container.append(videoElement);

			if (videoElement.get(0).readyState == 4) {
				if (onLoadMetadataListener) {
					onLoadMetadataListener();
				}

				if (onLoadListener) {
					onLoadListener();
				}

				return true;
			}

			if (onLoadListener) {
				videoElement.on('loadeddata', onLoadListener);
			}

			if (onLoadMetadataListener) {
				videoElement.on('loadedmetadata', onLoadMetadataListener);
			}

			videoElement.get(0).load();

			return true;
		}

		this.play = function(onEndListener) {
			videoElement.on('ended', function() {
				videoElement.fadeOut('normal');
				if (onEndListener) {
					onEndListener();
				}
			});

			videoElement.fadeIn(1500);
			videoElement.get(0).play();
		}

		this.getHeight = function() {
			return videoElement !== null ? videoElement.get(0).videoHeight : 0;
		}

		this.getWidth = function() {
			return videoElement !== null ? videoElement.get(0).videoWidth : 0;
		}

		this.isLoaded = function() {
			return videoElement !== null && videoElement.get(0).readyState == 4;
		}

		this.cancelLoading = function() {
			videoElement.get(0).pause(0);
			mp4SourceElement.attr('src', '');
			videoElement.off('loadeddata');
			videoElement.get(0).load();
			videoElement.remove();
		}

		this.canBePlayed = function() {
			if ($(window).width() < 1000) {
				return false;
			}
			var video = $("<video></video>").get(0);
			if (mp4SourceUrl && video && (video.canPlayType('video/mp4; codecs="avc1.42E01E, mp4a.40.2"')
										|| video.canPlayType('video/mp4; codecs="avc1.42E01E"'))) {
				return true;
			}

			return false;

			/*// Check for Ogg support
    		ogg = "" !== testEl.canPlayType( 'video/ogg; codecs="theora"' );

    		// Check for Webm support
    		webm = "" !== testEl.canPlayType( 'video/webm; codecs="vp8, vorbis"' );*/
		}

	}

	function LoopVideo(container, mp4SourceUrl, overlayMillis) { 
		var firstVideo = new Video(container, mp4SourceUrl);
		var secondVideo = new Video(container, mp4SourceUrl);

		this.load = function(onLoadListener, onLoadMetadataListener) {
			firstVideo.load(onLoadListener, onLoadMetadataListener);
			secondVideo.load();
		}

		function playVideo(currVideo, nextVideo) {
			currVideo.play();
			currVideo.getVideoElement().css('zIndex', 1);
			nextVideo.getVideoElement().css('zIndex', 0);
			currVideo.getVideoElement().on('timeupdate', (function() {
				return function(event) {
					var current = Math.round(event.target.currentTime * 1000);
					var total = Math.round(event.target.duration * 1000);

					if ( ( total - current ) < overlayMillis) {
						currVideo.getVideoElement().off('timeupdate');
						playVideo(nextVideo, currVideo);
					}
				}
			})());
		}

		this.play = function(onEndListener) {
			playVideo(firstVideo, secondVideo);
		}

		this.getHeight = function() {
			return firstVideo.getHeight();
		}

		this.getWidth = function() {
			return firstVideo.getWidth();
		}

		this.isLoaded = function() {
			return firstVideo.isLoaded();
		}

		this.canBePlayed = function() {
			return firstVideo.canBePlayed();
		}
	}

	var videoContainerResizeFunc = function() {
		if ($("#video-front") && video !== null) {
			var videoSourceHeight = video.getHeight();
			var height = ($(window).height() < videoSourceHeight || videoSourceHeight == 0) ? $(window).height() : videoSourceHeight;
			$("#video-front").height(height).width($(window).width());
		}
	}

	var prepareVideoContainer = function() {
		if (!$("#video-front")) {
			return;
		}

		var overlayMillis = +$("#video-container").data("loop");
		if (overlayMillis <= 0) {
			video = new Video($("#video-container"), $("#video-container").data("source-mp4"));
		} else {
			video = new LoopVideo($("#video-container"), $("#video-container").data("source-mp4"), overlayMillis);
		}

		if (!video.canBePlayed()) {
			console.log("cant be played");
			videoContainerResizeFunc();
			$("#main-video-image").fadeIn('normal');
			return;
		}

		$("#main-video-image").css('position', 'relative');
		$("#main-video-image").css('zIndex', '2');

		video.load(null, function() {
			videoContainerResizeFunc();
		});	

		setTimeout(function() {
			if (video.isLoaded()) {
				video.play(function() {
					$("#main-video-image").fadeIn(1500);
				});
			} else {
				$("#main-video-image").fadeIn('normal');
				setTimeout(function() {
					if (video.isLoaded()) {
						$("#main-video-image").fadeOut(1500);
						video.play(function() {
							$("#main-video-image").fadeIn(1500);
						});
					} else {
						setTimeout(function() {
							if (video.isLoaded()) {
								$("#main-video-image").fadeOut(1500);
								video.play(function() {
									$("#main-video-image").fadeIn(1500);
								});
							} else {
								//video.cancelLoading();
							}
						}, 3000);
					}
				}, 1800);
			}
		}, 200);
		
		videoContainerResizeFunc();
	}

	$(document).on('ready', prepareVideoContainer);
	$(window).on('resize', videoContainerResizeFunc);

})(jQuery);
