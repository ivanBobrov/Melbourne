<?php

if (function_exists('melbourne_video_header')) {
	return;
}

function melbourne_video_header() {
	if ( get_theme_mod('front_header_type','slider') != 'video' || !is_front_page() ) {
		return;
	}

	$videoUrl = get_theme_mod('header_front_video_file', get_template_directory_uri() . '/images/video.mp4');
	$videoTitle = get_theme_mod('front_video_title', 'Welcome');
	$videoSubtitle = get_theme_mod('front_video_subtitle', 'Join us!');
	
	?>
	
	<div id="video-front" class="header-slider">
		<div class="slides-container video-container">
			<video class="video-front-item" autoplay muted>
				<source src="<?php echo esc_url($videoUrl); ?>" type="video/mp4">
				Your browser does not support html5 video.
			</video>
			
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



