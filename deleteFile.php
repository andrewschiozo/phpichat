<?php
echo '<pre>';
if(file_exists('file.png'))
{
	var_dump(scandir());
	if(unlink('file.png'))
	{
		echo 'Apagou';
	}
	else
	{
		echo 'Não apagou';
	}
	var_dump(scandir());
}
else
{
	echo 'Arquivo não existe';
}
