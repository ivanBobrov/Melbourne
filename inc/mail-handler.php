<?php
/**
	Module to support saving mails through page-mail-handler.php
*/

function melbourne_add_mail_table() {
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

function melbourne_save_mail($mail) {
	global $wpdb;

	$mail_id = $wpdb->get_var($wpdb->prepare("SELECT id FROM " . $wpdb->prefix . 
											 "melbourne_mail WHERE mail = %s LIMIT 1", $mail));

	if ($mail_id == NULL) {
		$date = current_time('mysql');
		$wpdb->insert($wpdb->prefix . 'melbourne_mail', array(
			'mail' => $mail,
			'insert_date' => $date
		));
	}
}

function melbourne_move_mail_to_db() {
	global $wpdb;

	$dir = wp_upload_dir()['basedir'];
	$file = "$dir/mail.list";

	if (file_exists($file)) {
		$handle = fopen($file, 'r');
		if ($handle) {
			while (($line = fgets($handle)) !== false) {
				melbourne_save_mail(trim($line));
			}
		}

		fclose($handle);
		unlink($file);
	}
}

function melbourne_mail_handler_setup() {
	melbourne_add_mail_table();
	melbourne_move_mail_to_db();
}
add_action('upgrader_process_complete', 'melbourne_mail_handler_setup')

?>