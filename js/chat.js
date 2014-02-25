var user_id = 0;


function pushMessage(message, usernames)
{
	// Get the user for this conversation
	var usr = 0;
	if (message.from_id != user_id)
		usr = message.to_id;
	else
		usr = message.from_id;
	// Check to see if display window is open, if not, open it
	var wind = $( '#chat_wind_' + usr );
	if (wind.length == 0)
	{
		displayChatWindow(usr, usernames);	
	}
	wind = $( '#chat_wind_' + usr );
	wind.prepend('<div class="speech-bubble">'+
					message.content+
				 '</div>');
	$( '.chatbox input, .speech-bubble' ).click(function(e) {
		e.stopPropagation();
	});
}

function displayChatWindow(usr, usernames)
{
	// Doesn't work because of the async ajax bs
	var wind = 
	'<li class="dropdown">'+
  		'<li class="dropdown">'+
			'<a href="#" class="dropdown-toggle" data-toggle="dropdown">' + usernames[usr] + '</a>'+
	        	'<ul class="dropdown-menu">'+
					'<li class="chatbox">'+
						'<div class="row">'+
   							'<div class="col-md-12" id="chat_wind_' + usr + '">'+
				   			'</div>'+
				   			'<div class="col-md-12">'+
				   				'<input type="text" class="form-control input-md">'+
				   			'</div>'+
						'</div>'+
					'</li>'+
				'</ul>'+
			'</li>';
	$( '#chat_bar' ).append(wind);
}

function loadChat()
{
	$.get( "chat.php", {action: 'recent'}).done(function ( data ) {
		var result = JSON.parse( data );
		user_id = result.user_id;
		var messages = result.data.messages;
		for (var i = 0; i < messages.length; i++)
		{
			pushMessage(messages[i], result.data.usernames);
		}
	}).fail(function () {
	});
}