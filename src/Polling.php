<?php

namespace src;

class Polling
{
	private $file;

	public function __construct($file)
	{
		$this->setFile($file);
	}

	private function setFile($file)
	{
		if (file_exists($file)) {
			$this->file = $file;
		}
		else
		{
			throw new \Exception('Arquivo ' . $file . ' Não existe');
		}
	}

	private function getLastUpdate()
	{
		if(!isset($_COOKIE['lastUpdate'])) {
			$this->setLastUpdate(0);
		}
		return $_COOKIE['lastUpdate'];	
	}

	private function setLastUpdate($lastUpdate)
	{
		setcookie('lastUpdate', $lastUpdate);
	}

	private function writeFile($content)
	{
		$file = fopen($this->file, "w");
		fwrite($file, $content);
		fclose($file);
	}

	public function poll($message = null)
	{
		if($message)
		{
			$this->writeFile($message);
		}
		$lastUpdate = $this->getLastUpdate();

		while (true) {
			$fileModifyTime = filemtime($this->file);

			if ($fileModifyTime === false) {
				throw new \Exception('Não foi possível obter a última modificação');
			}

			if ($fileModifyTime > $lastUpdate) {
				$this->setLastUpdate($fileModifyTime);
				$fileRead = file_get_contents($this->file);
				clearstatcache();

				return json_encode(array('status' => true, 'time' => $fileModifyTime, 'content' => $fileRead));
			}
			else
			{
				sleep(1);
				clearstatcache();

				return json_encode(array('status' => false, 'time' => $fileModifyTime, 'error' => 'nothing'));
			}
		}
	}
}
