<?php

if (function_exists('melbourne_video_header')) {
	return;
}

function melbourne_video_header() {
	if ( get_theme_mod('front_header_type','slider') != 'video' || !is_front_page() ) {
		return;
	}

	$videoUrl = get_theme_mod('header_front_video_file', get_template_directory_uri() . '/images/video.mp4');
	$videoOverlayEnabled = get_theme_mod('header_video_loop_enabled', '');
	$videoOverlayMillis = get_theme_mod('header_video_loop_overlay', '1000');
	$mainImageUrl = get_theme_mod('video_main_image', get_template_directory_uri() . '/images/1.jpg');
	$videoTitle = get_theme_mod('front_video_title', 'Welcome');
	$videoSubtitle = get_theme_mod('front_video_subtitle', 'Join us!');
	
	if (!($videoOverlayEnabled == 1) || $videoOverlayMillis < 0) {
		$videoOverlayMillis = 0;
	}

	if (($videoOverlayEnabled == 1) && $videoOverlayMillis <= 0) {
		$videoOverlayMillis = 1;
	}

	?>
	
	<div id="video-front" class="header-slider">
		<div class="slides-container video-container" id="video-container" data-loop="<?php echo $videoOverlayMillis; ?>" data-source-mp4="<?php echo esc_url($videoUrl); ?>">
			<div id="main-video-image" class="video-image" style="display: none; height: 100%; background-image:url(<?php echo esc_url($mainImageUrl); ?>);">
			</div>
            <div class="slide-inner">
                <div class="contain animated fadeInRightBig text-slider">
                    <h2 class="maintitle"><?php echo esc_html($videoTitle); ?></h2>
                    <p class="subtitle"><?php echo esc_html($videoSubtitle); ?></p>
                </div>
                <?php sydney_slider_button(); ?>
            </div>
                    
		</div>
	</div>
	
	<?php
}

?>

<video class="video-front-item" autoplay muted>
	<source src="<?php echo esc_url($videoUrl); ?>" type="video/mp4">
	Your browser does not support html5 video.
</video>

