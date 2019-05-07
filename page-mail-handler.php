<?php

if (!empty($_POST["mail"]) && !empty($_POST["file"])) {
	$pMail = $_POST["mail"];
	$pFile = $_POST["file"];
	
	saveMail($pMail);
	header("HTTP/1.1 200 OK");
	//sendFileToUser($pFile);
}

function saveMail($mail) {
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

function sendFileToUser($file) {
	$dir = wp_upload_dir()['basedir'];
	$path = "$dir/$file";

	$renderedFileName = 'ASKKM_fest_2018.pdf';
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-Type: application/pdf");
	header("Content-Disposition: attachment; filename=$renderedFileName");
	header("Content-Transfer-Encoding: binary");

	readfile($path);
}

?>