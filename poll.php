<?php

session_write_close();
ignore_user_abort(false);
set_time_limit(40);

require_once 'Autoload.php';
new Autoload();

use src\Polling;

$Polling = new Polling('tempfile.txt');

try
{
	$message = isset($_POST['message']) ? $_POST['message'] : null;
	echo $Polling->poll($message);
}
catch(\Exception $e)
{
	echo json_encode(array('status' => false, 'error' => $e->getMessage()));
}
exit;
