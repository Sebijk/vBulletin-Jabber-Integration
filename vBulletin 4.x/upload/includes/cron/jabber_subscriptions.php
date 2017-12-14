<?php
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin - Jabber Integration	by Home of the Sebijk.com		      # ||
|| #################################################################### ||
\*======================================================================*/

// ######################## SET PHP ENVIRONMENT ###########################
error_reporting(E_ALL & ~E_NOTICE);
if (!is_object($vbulletin->db))
{
	exit;
}

// Jabber Settings Check
if($vbulletin->options['jabber_jid'] AND $vbulletin->options['jabber_password'] AND $vbulletin->options['jabber_port'] AND $vbulletin->options['jabber_hostname']) {

// ########################## REQUIRE BACK-END ############################
require_once(DIR . '/includes/class_paid_subscription.php');
require_once(DIR . '/includes/jabber_classes.php');

// ########################################################################
// ######################### START MAIN SCRIPT ############################
// ########################################################################
$subobj = new vB_PaidSubscription($vbulletin);
$subobj->cache_user_subscriptions();

if (is_array($subobj->subscriptioncache))
{
	foreach ($subobj->subscriptioncache as $key => $subscription)
	{
		// disable people :)
		$subscribers = $vbulletin->db->query_read("
			SELECT userid
			FROM " . TABLE_PREFIX . "subscriptionlog
			WHERE subscriptionid = $subscription[subscriptionid]
				AND expirydate <= " . TIMENOW . "
				AND status = 1
		");

		while ($subscriber = $vbulletin->db->fetch_array($subscribers))
		{
			$subobj->delete_user_subscription($subscription['subscriptionid'], $subscriber['userid'], -1, true);
		}
	}

	// time for the reminders
	$subscriptions_reminders = $vbulletin->db->query_read("
		SELECT subscriptionlog.subscriptionid, subscriptionlog.userid, subscriptionlog.expirydate, user.username, user.email, user.languageid
		FROM " . TABLE_PREFIX . "subscriptionlog AS subscriptionlog
		LEFT JOIN " . TABLE_PREFIX . "user AS user ON (user.userid = subscriptionlog.userid)
		WHERE subscriptionlog.expirydate >= " . (TIMENOW + (86400 * 2)) . "
			AND subscriptionlog.expirydate <= " . (TIMENOW + (86400 * 3)) . "
			AND status = 1
	");

	require_once(DIR. '/includes/start.jabber.php'); // start Jabber Connection
	while ($subscriptions_reminder = $vbulletin->db->fetch_array($subscriptions_reminders))
	{
		require_once(DIR . '/includes/functions_misc.php');
		$subscription_title = fetch_phrase('sub' . $subscriptions_reminder['subscriptionid'] . '_title', 'subscription', '', true, true, $subscriptions_reminder['languageid']);

		$username = unhtmlspecialchars($subscriptions_reminder['username']);
		eval(fetch_email_phrases('paidsubscription_reminder', $subscriptions_reminder['languageid']));
		if($vbulletin->options['jabber_selectcharset'] == 1) {
           $message = utf8_encode($message);
           $subject = utf8_encode($subject);
  }
		if($subscriptions_reminder['jabber']) $jabber_class->message($subscriptions_reminder['jabber'], $message, "chat", $subject); // xmpphp
		
	}
	$jabber_class->disconnect();

	($hook = vBulletinHook::fetch_hook('cron_script_subscriptions')) ? eval($hook) : false;
}

log_cron_action('', $nextitem, 1);

} //  / Jabber Settings Check
?>