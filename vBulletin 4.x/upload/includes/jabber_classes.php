<?php
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin - Jabber Integration	by Home of the Sebijk.com		      # ||
|| # ---------------------------------------------------------------- # ||
|| # Copyright ©2007-2012 Home of the Sebijk.com.                     # ||
|| #################################################################### ||
\*======================================================================*/

// Use the standard vBulletin or Registry Mode?
if($is_vb_registry_mode == 1) {

   if($this->registry->options['jabber_selectclass'] == 1)
   {
      require_once(DIR. "/includes/XMPPHP/XMPP.php"); // xmpphp
   }
}
else
{
    require_once(DIR. "/includes/XMPPHP/XMPP.php"); // xmpphp
}
?>