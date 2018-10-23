$(function(){

	$('#btnEnviar').click(function(){
		$.post('poll.php', {message: $('#mensagem').val()});
		$('#mensagem').val('');
	});

	$('#mensagens').on('click', '.messageCheck', function(){
		if($('.messageCheck:checkbox:checked').length > 0)
		{
			$('#tools .btn').attr('disabled', false);
		}
		else
		{
			$('#tools .btn').attr('disabled', true);
		}
	});

	$('#btnApagarMensagens').click(function(){
		var checked = $('.messageCheck:checkbox:checked');
		$.each(checked, function(index, value){
			$($(value).parents()[1]).remove();
		});
		$(this).attr('disabled', true);
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
				messageBox.addClass('checkbox');
				messageBox.append('<label><input type="checkbox" class="messageCheck" value="">' + json.content + '</label>')
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
