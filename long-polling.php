<?php
session_write_close();
ignore_user_abort(false);
set_time_limit(40);

if(isset($_POST['message']))
{
	writeMessage($_POST['message']);
	return;
}

poll();

function poll()
{
	try {
		// lastUpdate cookie saves the file update time which was sent to the browser
		if (!isset($_COOKIE['lastUpdate'])) {
			setcookie('lastUpdate', 0);
			$_COOKIE['lastUpdate'] = 0;
		}

		$lastUpdate = $_COOKIE['lastUpdate'];
		$file = 'file.txt';

		if (!file_exists($file)) {
			throw new Exception($file . ' Does not exist');
		}

		while (true) {
			$fileModifyTime = filemtime($file);

			if ($fileModifyTime === false) {
				throw new Exception('Could not read last modification time');
			}

			// if the last modification time of the file is greater than the last update sent to the browser... 
			if ($fileModifyTime > $lastUpdate) {
				setcookie('lastUpdate', $fileModifyTime);
				$fileRead = file_get_contents($file);
				clearstatcache();

				exit(json_encode([
					'status' => true,
					'time' => $fileModifyTime, 
					'content' => $fileRead
				]));
			}
			else
			{
				sleep(1);
				clearstatcache();

				exit(json_encode([
					'status' => false,
					'time' => $fileModifyTime,
					'error' => 'nothing'
				]));
			}
		}
	} catch (Exception $e) {
		exit(
			json_encode(
				array (
					'status' => false,
					'error' => $e -> getMessage()
				)
			)
		);
	}
}

function writeMessage($message)
{
	$file = fopen('file.txt', "w");
	fwrite($file, $message);
	fclose($file);
}
