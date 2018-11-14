<?php

if(file_exists('file.extension'))
{
	if(unlink('file.extension'))
	{
		echo 'Apagou';
	}
	else
	{
		echo 'Não apagou';
	}
}
else
{
	echo 'Arquivo não existe';
}
