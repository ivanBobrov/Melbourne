<?php

// Creating the widget
class ContactWidget extends WP_Widget {

	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'melbourne_contact_widget',
			// Widget name will appear in UI
			__('Melbourne: Contact Widget', 'sydney'),
			// Widget description
			array( 'description' => __( 'Displays contact in circle with info', 'sydney' ), )
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
		$imageSource = $instance['image_uri'];
		$name = $instance['name1'];
		$phone = $instance['phone1'];
		$mail = $instance['mail1'];

		?>

			<div class="contact-widget-container">
				<?php if (!empty($imageSource)) : ?>
					<div class="widget-contact-rounded-container">
						<img title="<?php echo $name; ?>" alt="" src="<?php echo $imageSource; ?>">
					</div>
				<?php endif; ?>
				<div>
					<div><?php echo $name; ?></div>

					<?php if (!empty($phone)) : ?>
						<div><?php echo $phone; ?></div>
					<?php endif; ?>

					<?php if (!empty($mail)) : ?>
						<div><?php echo $mail; ?></div>
					<?php endif; ?>			
				</div>
			</div>

		<?php


		echo $args['after_widget'];
	}

	// Widget Backend
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( '', 'sydney' );
		}

		$name1 = isset($instance['name1']) ? $instance['name1'] : 'Name';
		$phone1 = isset($instance['phone1']) ? $instance['phone1'] : '';
		$mail1 = isset($instance['mail1']) ? $instance['mail1'] : '';
		$image_uri = isset($instance['image_uri']) ? $instance['image_uri'] : '';

		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<hr>

		<p>
			<label for="<?php echo $this->get_field_id( 'name1' ); ?>"><?php _e( 'Name:' ); ?></label><br>
			<input size="50" type="text" id="<?php echo $this->get_field_id( 'name1' ) ?>" name="<?php echo $this->get_field_name( 'name1' ); ?>" value="<?php echo esc_attr($name1); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'phone1' ); ?>"><?php _e( 'Phone:' ); ?></label><br>
			<input size="50" type="text" id="<?php echo $this->get_field_id( 'phone1' ) ?>" name="<?php echo $this->get_field_name( 'phone1' ); ?>" value="<?php echo esc_attr($phone1); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'mail1' ); ?>"><?php _e( 'Mail:' ); ?></label><br>
			<input size="50" type="text" id="<?php echo $this->get_field_id( 'mail1' ) ?>" name="<?php echo $this->get_field_name( 'mail1' ); ?>" value="<?php echo esc_attr($mail1); ?>" />
		</p>

		<p>
      		<label for="<?php echo $this->get_field_id('image_uri'); ?>">Image</label><br />
      		<input type="text" class="img" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo esc_attr($image_uri); ?>" />
      		<input type="button" class="select-img" value="Select Image" />
    </p>

		<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['name1'] = ( ! empty($new_instance['name1']) ? $new_instance['name1'] : 'Name');
		$instance['phone1'] = ( ! empty($new_instance['phone1']) ? $new_instance['phone1'] : '');
		$instance['mail1'] = ( ! empty($new_instance['mail1']) ? $new_instance['mail1'] : '');
		$instance['image_uri'] = ( ! empty($new_instance['image_uri']) ? $new_instance['image_uri'] : '');

		return $instance;
	}

} // Class wpb_widget ends here

// Register and load the widget
function melbourne_contact_widget_load() {
    register_widget( 'ContactWidget' );
}
add_action( 'widgets_init', 'melbourne_contact_widget_load' );

// queue up the necessary js
function hrw_enqueue()
{
  wp_enqueue_style('thickbox');
  wp_enqueue_script('media-upload');
  wp_enqueue_script('thickbox');
  wp_enqueue_script('hrw', get_template_directory_uri() . '/widgets/contact-widget/script.js', null, null, true);
}
add_action('admin_enqueue_scripts', 'hrw_enqueue');

?>