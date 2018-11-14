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

	$('#mensagens').on('click', '.downloadFile', function(){
		var data = $($(this).parents()[0]).children(0).text();
		$.post('base64download.php', {base64encoded: data}, function(response){
			alert(response);
		})
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
				messageBox.append('<label><input type="checkbox" class="messageCheck" value="">' + json.content + '</label><br><button type="button" class="btn btn-sm btn-dark downloadFile">Download</button>');
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
