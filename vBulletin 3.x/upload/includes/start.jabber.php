<?php
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin - Jabber Integration	by Home of the Sebijk.com		      # ||
|| # ---------------------------------------------------------------- # ||
|| # Copyright ©2007-2008 Home of the Sebijk.com.                     # ||
|| #################################################################### ||
\*======================================================================*/

if($is_vb_registry_mode == 1) {
   if($this->registry->options['jabber_encryption'] == 1) { $jabber_security_c = "SECURITY_SSL"; }
   if($this->registry->options['jabber_encryption'] == 2) { $jabber_security_c = "SECURITY_TLS"; }
   else { $jabber_security_c = "SECURITY_NONE"; }
   
   if($this->registry->options['jabber_selectclass'] == 1) { 
      // for PHP 4 compatibility reasons I place the xmpphp start code to a external file
      require_once(DIR. "/includes/start.xmpphp.php"); // xmpphp
    }
    else { // legacy
      $jabber_class = new Jabber($this->registry->options['jabber_jid'], $this->registry->options['jabber_password'], $jabber_security_c, $this->registry->options['jabber_port'], $this->registry->options['jabber_hostname']);
      $jabber_class->login();
      $jabber_class->presence();
      }
} else {
   if($vbulletin->options['jabber_encryption'] == 1) { $jabber_security_c = "SECURITY_SSL"; }
   if($vbulletin->options['jabber_encryption'] == 2) { $jabber_security_c = "SECURITY_TLS"; }
   else { $jabber_security_c = "SECURITY_NONE"; }
   
  if($vbulletin->options['jabber_selectclass'] == 1) { 
  // for PHP 4 compatibility reasons I place the xmpphp start code to a external file
  require_once(DIR. "/includes/start.xmpphp.php"); // xmpphp
  }
  else { // legacy
  $jabber_class = new Jabber($vbulletin->options['jabber_jid'], $vbulletin->options['jabber_password'], $jabber_security_c, $vbulletin->options['jabber_port'], $vbulletin->options['jabber_hostname']);
  $jabber_class->login();
  $jabber_class->presence();
  }
}

?>