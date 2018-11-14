<?php

if(array_key_exists('base64encoded', $_POST))
{
	$stringDecoded = base64_decode($_POST['base64encoded']);
	$file = fopen('file.extension', 'w+');
	fwrite($file, $stringDecoded);
	fclose($file);
	echo json_encode('true');
}
else
{
	echo json_encode('false');
}
