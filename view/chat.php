<?
function displayChat()
{
?>
	<div class="navbar navbar-fixed-bottom dropup" id="chat">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
    	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#friends-collapse">
      	<span class="sr-only">Friends</span>
      	<span class="icon-bar"></span>
      	<span class="icon-bar"></span>
      	<span class="icon-bar"></span></button>
      	<a class="navbar-brand" href="#">Chat</a>
  	</div>

  	<!-- Collect the nav links, forms, and other content for toggling -->
  	<div class="collapse navbar-collapse" id="friends-collapse">
    	<ul class="nav navbar-nav navbar">
	      	<li class="dropdown">
	        	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Chat 1</a>
	        	<ul class="dropdown-menu">
	        		<script>
	        			loadChat();
	        		</script>
				</ul>
			</li>
		</ul>
    	<ul class="nav navbar-nav navbar-right">
	      	<li class="dropdown">
	        	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Friends</a>
	        	<ul class="dropdown-menu">
				</ul>
			</li>
		</ul>
	</div><!-- /.navbar-collapse -->
</div>
<?
}
