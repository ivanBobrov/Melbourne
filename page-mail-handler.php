<?php

if (!empty($_POST["mail"]) && !empty($_POST["file"])) {
	$pMail = $_POST["mail"];
	$pFile = $_POST["file"];
	
	$dir = wp_upload_dir()['basedir'];
	saveMail($pMail, "$dir/mail.list");

	
	$file = "$dir/$pFile";

	$filename = 'ASKKM_fest_2018.pdf';
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-Type: application/pdf");
	header("Content-Disposition: attachment; filename=$filename");
	header("Content-Transfer-Encoding: binary");

	readfile($file);
}

function saveMail($mail, $filename) {
	file_put_contents($filename, $mail.PHP_EOL , FILE_APPEND | LOCK_EX);
}

?>