<?php
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin - Jabber Integration	by Home of the Sebijk.com		      # ||
|| # ---------------------------------------------------------------- # ||
|| # Copyright ©2007-2008 Home of the Sebijk.com.                     # ||
|| #################################################################### ||
\*======================================================================*/

// xmpphp
if($is_vb_registry_mode == 1) {
  $jabber_user = explode("@", $this->registry->options['jabber_jid']);
  $jabber_class = new XMPPHP_XMPP($this->registry->options['jabber_hostname'], $this->registry->options['jabber_port'], $jabber_user[0], $this->registry->options['jabber_password'], "vBulletin", $jabber_user[1], $printlog=false, $loglevel=XMPPHP_Log::LEVEL_INFO);
}
else {
  $jabber_user = explode("@", $vbulletin->options['jabber_jid']);
  $jabber_class = new XMPPHP_XMPP($vbulletin->options['jabber_hostname'], $vbulletin->options['jabber_port'], $jabber_user[0], $vbulletin->options['jabber_password'], "vBulletin", $jabber_user[1], $printlog=false, $loglevel=XMPPHP_Log::LEVEL_INFO);
}
  //if($vbulletin->options['jabber_encryption'] == 0) $jabber->use_encryption = false; - Currently not work
  $jabber_class->connect();
  $jabber_class->processUntil('session_start');
?>