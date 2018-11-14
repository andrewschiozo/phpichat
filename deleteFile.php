<?php
echo '<pre>';
if(file_exists('file.extension'))
{
	var_dump(scandir());
	if(unlink('file.extension'))
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
