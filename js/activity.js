var user_id = 0;

function pushMessage(message, usernames)
{
	// Get the user for this conversation
	var usr = 0;
	if (message.from_id != user_id)
		usr = message.from_id;
	else
		usr = message.to_id;
	// Check to see if display window is open, if not, open it
	var wind = $( '#chat_wind_' + usr );
	if (wind.length == 0)
	{
		displayChatWindow(usr, usernames);	
	}
	wind = $( '#chat_wind_' + usr );
	wind.append('<div class="speech-bubble">'+
					message.content+
				 '</div>');
	$( '.chatbox input, .speech-bubble' ).click(function(e) {
		e.stopPropagation();
	});
	var input = $( '#chat_input_' + usr );
	input.keypress(function(event) {
    if (event.which == 13) {
        event.preventDefault();
        var text = input.val();
       	input.val("");
        if (text != "")
        {
        	$.get( "activity.php", {action: 'send', to: usr, message: text}).done();
        }
    }
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
				   				'<input id="chat_input_' + usr + '" type="text" class="form-control input-md">'+
				   			'</div>'+
						'</div>'+
					'</li>'+
				'</ul>'+
			'</li>';
	$( '#chat_bar' ).append(wind);
}

function processResponse(response)
{
		user_id = response.user_id;
		// Check for new notifications
		// Check for new messages
		var notifications = response.data.notifications;
		for (var i = 0; i < notifications.length; i++)
		{
			var notification = notifications[i];
			if (notification.type == 10 || notification.type == 11)
				pushMessage(notification, response.data.usernames);
		}
		// Check for group movement
}
function loadNotificationManager()
{
	$.get( "activity.php", {action: 'recent'}).done(function ( data ) {
		if (data != "")
		{
			var response = JSON.parse( data );
			processResponse(response);
		}
		// Enable notification manager
		(function poll(){
		$.ajax({ url: "activity.php?action=poll", success: function(data){
		     processResponse(data);
		}, dataType: 'json', complete: poll, timeout: 30000 });
		})();
	}).fail(function () {
	});
}