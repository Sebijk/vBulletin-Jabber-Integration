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
require_once(DIR . '/includes/functions_jabber_digest.php');

// ########################################################################
// ######################### START MAIN SCRIPT ############################
// ########################################################################

// send weekly digest of new posts in threads and threads in forums
exec_digest(3);

log_cron_action('', $nextitem, 1);
} // / Jabber Settings Check
?>