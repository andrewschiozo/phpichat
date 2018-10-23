$(function(){

	$('#btnEnviar').click(function(){
		$.post('poll.php', {message: $('#mensagem').val()});
		$('#mensagem').val('');
	});

	function poll()
	{
		$.get('poll.php', function(data){
			try {
				var json = JSON.parse(data);
			} catch {
				poll();
				return;
			}

			if (json.status) {
				var messageBox = $('<div></div>');
				messageBox.text(json.content);
				$('#mensagens').append(messageBox);
			}
			else
			{
				if(json.error != 'nothing')
				{
					console.log(json.error);
				}
			}
			poll();
		});
	}
	poll();
});
