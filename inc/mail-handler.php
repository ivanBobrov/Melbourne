<?php
/**
	Module to support saving mails through page-mail-handler.php
*/

function melbourne_mail_handler_setup() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'melbourne_mail';
	if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE $table_name (
			id INT NOT NULL AUTO_INCREMENT,
			mail VARCHAR(255) NOT NULL,
			insert_date DATE NOT NULL,
			PRIMARY KEY(id),
			CONSTRAINT wp_melbourne_mail_uq UNIQUE (mail)
		) $charset_collate;";
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
}
//add_action('upgrader_process_complete', 'melbourne_mail_handler_setup')
melbourne_mail_handler_setup();

?>