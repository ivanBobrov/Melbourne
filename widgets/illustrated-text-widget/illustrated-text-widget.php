<?php

// Creating the widget
class IllustratedTextWidget extends WP_Widget {

	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'melbourne_illustarted_text_widget',
			// Widget name will appear in UI
			__('Melbourne: Illustrated text widget', 'sydney'),
			// Widget description
			array( 'description' => __( 'Displays text box with illustration nearby', 'sydney' ), )
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		
		// This is where you run the code and display the output
		
		$text = isset($instance['content']) ? $instance['content'] : '';
		$imageUrl = isset($instance['imageUrl']) ? $instance['imageUrl'] : '';
		$boolImageFirst = isset($instance['imageFirst']) ? $instance['imageFirst'] : false;

		$textElement = "<div class='melbourne-illustrated-text-content-container'>$text</div>";
		$imgElement = "<div class='melbourne-illustrated-text-img-container'><img src='$imageUrl' ></div>";
		
		$widget = "<div class='melbourne-illustrated-text-container'>";
		if ($boolImageFirst) {
			$widget .= $imgElement;
			$widget .= $textElement;
		} else {
			$widget .= $textElement;
			$widget .= $imgElement;
		}
		$widget .= "</div>";

		echo $widget;

		echo $args['after_widget'];

	}

	// Widget Backend
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( '', 'sydney' );
		}

		$content = isset($instance['content']) ? $instance['content'] : '';
		$imageUrl = isset($instance['imageUrl']) ? $instance['imageUrl'] : '';
		$imageFirst = isset($instance['imageFirst']) ? $instance['imageFirst'] : false;

		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<hr>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('imageFirst')); ?>">Order</label><br>
			
			<input type="radio" id="<?php echo esc_attr($this->get_field_id('imageFirst')); ?>" name="<?php echo esc_attr($this->get_field_name('imageFirst')); ?>" value="false" <?php if (!$imageFirst) echo "checked"; ?> />Text first
			<input type="radio" id="<?php echo esc_attr($this->get_field_id('imageFirst')); ?>" name="<?php echo esc_attr($this->get_field_name('imageFirst')); ?>" value="true" <?php if ($imageFirst) echo "checked"; ?> />Image first
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('content')); ?>">Content:</label><br>
			<textarea rows="10" cols="100" id="<?php echo esc_attr($this->get_field_id('content')); ?>" name="<?php echo esc_attr($this->get_field_name('content')); ?>"><?php echo esc_textarea($content);
			?></textarea>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('imageUrl')); ?>">Image</label><br>
      		<input type="text" class="img" name="<?php echo esc_attr($this->get_field_name('imageUrl')); ?>" id="<?php echo esc_attr($this->get_field_id('imageUrl')); ?>" value="<?php echo esc_attr($imageUrl); ?>" />
      		<input type="button" class="select-img" value="Select Image" />
		</p>

		<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = (isset($new_instance['title'])) ? strip_tags( $new_instance['title'] ) : '';
		$instance['content'] = (isset( $new_instance['content'])) ? $new_instance['content'] : '';
		$instance['imageUrl'] = (isset($new_instance['imageUrl'])) ? esc_url($new_instance['imageUrl']) : '';
		$instance['imageFirst'] = isset($new_instance['imageFirst']) ? $new_instance['imageFirst'] === 'true' : false;
		
		return $instance;
	}

} // Class wpb_widget ends here

// Register and load the widget
function melbourne_illustrated_text_widget_load() {
    register_widget( 'IllustratedTextWidget' );
}
add_action( 'widgets_init', 'melbourne_illustrated_text_widget_load' );

// queue up the necessary js
function melbourne_illustrated_text_enqueue()
{
  wp_enqueue_style('thickbox');
  wp_enqueue_script('media-upload');
  wp_enqueue_script('thickbox');
  wp_enqueue_script('melbourne_illustarted_text_script', get_template_directory_uri() . '/widgets/illustrated-text-widget/script.js', null, null, true);
}
add_action('admin_enqueue_scripts', 'melbourne_illustrated_text_enqueue');

?>