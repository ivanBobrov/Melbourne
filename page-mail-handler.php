<?php

if (!empty($_POST["mail"]) && !empty($_POST["file"])) {
	$pMail = $_POST["mail"];
	$pFile = $_POST["file"];
	
	saveMail($pMail);
	sendFileToUser($pFile);
}

function saveMail($mail) {
	$dir = wp_upload_dir()['basedir'];
	$file = "$dir/mail.list";
	file_put_contents($file, $mail.PHP_EOL , FILE_APPEND | LOCK_EX);
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