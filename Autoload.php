<?php

class Autoload
{
	public function __construct()
	{
		spl_autoload_register(array($this, 'load'));
	}
	public function load($className)
	{
		require_once __DIR__ . DIRECTORY_SEPARATOR . $className . '.php'; 
	}
}
