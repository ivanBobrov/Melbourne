<?php

if ( !function_exists('get_social_links')) :

function get_social_links() {
    $youtube_link = get_option('youtube_link_url');
    $facebook_link = get_option('facebook_link_url');

    ?>
    <div class="social-links-container">
        <?php create_social_link($youtube_link, get_template_directory_uri() . '/images/social/youtube_icon.svg'); ?>
        <?php create_social_link($facebook_link, get_template_directory_uri() . '/images/social/facebook_icon.svg'); ?>
    </div>
    <?php

}

function create_social_link($url, $logo_url) {
    if (!empty($url)) {
        ?>
        <div class="social-link">
            <a href="<?php echo esc_url($url); ?>">
                <img src="<?php echo esc_url($logo_url); ?>">
            </a>
        </div>
        <?php
    }
}


function social_links_settings_register() {
    register_setting( 'social-links-settings-group', 'youtube_link_url');
    register_setting( 'social-links-settings-group', 'facebook_link_url');
}

function social_links_settings_menu_create() {
    add_options_page( 'Social links options', 'Social links', 'manage_options', 'social_links_settings_page', 'social_links_settings_page_builder' );
    add_action('admin_init', 'social_links_settings_register');
}

add_action( 'admin_menu', 'social_links_settings_menu_create' );

function social_links_settings_page_builder() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    ?>
    <div class="wrap">
        <h1>Social links settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'social-links-settings-group' ); ?>
            <?php do_settings_sections( 'social-links-settings-group' ); ?>
            <table class="form-table">
                <tr>
                    <td>Youtube link:</td>
                    <td><input type="text" name="youtube_link_url" value="<?php echo get_option('youtube_link_url'); ?>"></td>
                </tr>
                <tr>
                    <td>Facebook link:</td>
                    <td><input type="text" name="facebook_link_url" value="<?php echo get_option('facebook_link_url'); ?>"></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

endif;    

?>