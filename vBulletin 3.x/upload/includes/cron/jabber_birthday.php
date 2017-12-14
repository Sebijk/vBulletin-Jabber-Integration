<?php
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin - Jabber Integration	by Home of the Sebijk.com		      # ||
|| #################################################################### ||
\*======================================================================*/

// ######################## SET PHP ENVIRONMENT ###########################
error_reporting(E_ALL & ~E_NOTICE & ~8192);
if (!is_object($vbulletin->db))
{
	exit;
}

// Jabber Settings Check
if($vbulletin->options['jabber_jid'] AND $vbulletin->options['jabber_password'] AND $vbulletin->options['jabber_port'] AND $vbulletin->options['jabber_hostname']) {

// ########################## REQUIRE BACK-END ############################
require_once(DIR . '/includes/jabber_classes.php');

// ########################################################################
// ######################### START MAIN SCRIPT ############################
// ########################################################################

$today = date('m-d', TIMENOW);

$ids = '0';
foreach($vbulletin->usergroupcache AS $usergroupid => $usergroup)
{
	if ($usergroup['genericoptions'] & $vbulletin->bf_ugp_genericoptions['showbirthday'] AND !in_array($usergroup['usergroupid'], array(1, 3, 4)))
	{
		$ids .= ",$usergroupid";
	}
}

$birthdays = $vbulletin->db->query_read("
	SELECT username, email, jabber, languageid
	FROM " . TABLE_PREFIX . "user
	WHERE birthday LIKE '$today-%' AND
	(options & " . $vbulletin->bf_misc_useroptions['adminemail'] . ") AND
	usergroupid IN ($ids)
");

require_once(DIR. '/includes/start.jabber.php'); // start Jabber Connection

while ($userinfo = $vbulletin->db->fetch_array($birthdays))
{
	$username = unhtmlspecialchars($userinfo['username']);
	eval(fetch_email_phrases('birthday', $userinfo['languageid']));
	if($userinfo['jabber']) {
    if($vbulletin->options['jabber_selectcharset'] == 1) {
           $message = utf8_encode($message);
           $subject = utf8_encode($subject);
  }
    if($vbulletin->options['jabber_selectclass'] == 1) $jabber_class->message($userinfo['jabber'], $message, "chat", $subject); // xmpphp
    else $jabber_class->send_message($userinfo['jabber'], $message, $subject); // legacy
    }

	$emails .= iif($emails, ', ');
	$emails .= $userinfo['username'];
}

// This function are the same one
$jabber_class->disconnect();

if ($emails)
	{
	log_cron_action($emails, $nextitem, 1);
}

} // / Jabber Settings Check
?>