<?
require_once 'data.php';

if ($action=$_REQUEST['action'])
{
	if ($action=="send")
	{
		$email = $_REQUEST['email'];
		if (validateEmail($email))
		{
			$invite = new Invite(null, $market->getUserID(), 0);
			$invite.write();
			$message = "You have been invited to join Agora. Click to <a href=\"http://socialmarket.ag/register.php?invite_code=$invite->invite_code/\">join</a>.";
			$m_email = $market-getMarketEmail();
			mail($user->email, "Registration", $message, "From: {$m_email}");
		}
	}
}
