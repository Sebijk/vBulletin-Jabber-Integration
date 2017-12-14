<?php
// Jabber Integration Product ID Upgrade Script
// Written by Home of the Sebijk.com

// ######################## SET PHP ENVIRONMENT ###########################
error_reporting(E_ALL & ~E_NOTICE & ~8192);

// #################### PRE-CACHE TEMPLATES AND DATA ######################
$phrasegroups = array('style');
$specialtemplates = array('products');

// ########################## REQUIRE BACK-END ############################
require_once('./global.php');
require_once(DIR . '/includes/adminfunctions_template.php');

$this_script = 'jid_pid';
$oldpid = 'patria_20061231';
$newpid ='enhanced_jabber';

// ########################## SUPERADMIN CHECK ############################
if (!in_array($vbulletin->userinfo['userid'], preg_split('#\s*,\s*#s', $vbulletin->config['SpecialUsers']['superadministrators'], -1, PREG_SPLIT_NO_EMPTY)) ) {
	rpm_print_stop_back("You don't have permission to access this page.");
}

print_cp_header();

/////////////////////// front page
	print_form_header('', '');
if ($oldpid)
{
	$check = $db->query_first_slave("SELECT * FROM ".TABLE_PREFIX."product WHERE productid = '".$db->escape_string($oldpid)."'");
	if ($check['version'])
	{
		echo "<br /><center>Setup-Meldungen / Install Information / Установка:</center><br />";
		echo "<center><font color='green'>Eine vorherige Installation des Jabber-Integration wurde entdeckt und wird aktualisiert.<br />A previous Installation from Jabber Integration was detected and updating this.<br />Обнаружена предыдущая версия интеграции Jabber, она будет обновлена.</font></center><br /><br />";
		vbflush();
		$db->query_write("UPDATE ".TABLE_PREFIX."cron SET product = '".$db->escape_string($newpid)."' where product = '".$db->escape_string($oldpid)."'"); 
		$db->query_write("UPDATE ".TABLE_PREFIX."phrase SET product = '".$db->escape_string($newpid)."' where product = '".$db->escape_string($oldpid)."'"); 
		$db->query_write("UPDATE ".TABLE_PREFIX."plugin SET product = '".$db->escape_string($newpid)."' where product = '".$db->escape_string($oldpid)."'"); 
		$db->query_write("UPDATE ".TABLE_PREFIX."product SET productid = '".$db->escape_string($newpid)."' where productid = '".$db->escape_string($oldpid)."'");
		$db->query_write("UPDATE ".TABLE_PREFIX."productcode SET productid = '".$db->escape_string($newpid)."' where productid = '".$db->escape_string($oldpid)."'");
		$db->query_write("UPDATE ".TABLE_PREFIX."productdependency SET productid = '".$db->escape_string($newpid)."' where productid = '".$db->escape_string($oldpid)."'");
		$db->query_write("UPDATE ".TABLE_PREFIX."setting SET product = '".$db->escape_string($newpid)."' where product = '".$db->escape_string($oldpid)."'");
		$db->query_write("UPDATE ".TABLE_PREFIX."settinggroup SET product = '".$db->escape_string($newpid)."' where product = '".$db->escape_string($oldpid)."'");
		$db->query_write("UPDATE ".TABLE_PREFIX."template SET product = '".$db->escape_string($newpid)."' where product = '".$db->escape_string($oldpid)."'");
		if ($vbulletin->products['tms']) 
		{
			$db->query_write("UPDATE ".TABLE_PREFIX."templateedit SET product = '".$db->escape_string($newpid)."' where product = '".$db->escape_string($oldpid)."'");
			$db->query_write("UPDATE ".TABLE_PREFIX."templateeditlocation SET product = '".$db->escape_string($newpid)."' where product = '".$db->escape_string($oldpid)."'");
		}
		// rebuild the $vboptions array
		vBulletinHook::build_datastore($db);
		build_product_datastore();
		echo "<center><b>Aktualisierung abgeschlossen. / Upgrade complete. / Обновление завершено.</b></center><br /><br />";
	}
	elseif($vbulletin->products['patria_20061231'])
	{
		// rebuild the $vboptions array
		vBulletinHook::build_datastore($db);
		build_product_datastore();
		echo "<center><b>Datastore Build complete.</b></center><br /><br />";
	}
	else
	{
		echo "<center><b>Es wurde keine &auml;lteren Jabber-Integrations-Add-ons gefunden, die aktualisiert werden sollen.<br />No older Jabber Integration version found.</b></center><br /><br />";
	}
}
else 
{
	echo "<center><b>Fehler: Es wurde keine Produkt-ID eingegeben, die aktualisiert werden soll.</b></center><br /><br />";
}
echo "<center><font color='red'><b>Bitte l&ouml;schen Sie nun aus Sicherheitsgr&uuml;nden die jid_pid.php.<br />For security reasons, please delete the file jid_pid.php.</b></font></center><br /><br />";
print_cp_footer();
?>