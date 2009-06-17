<?php
//j// BOF

/*n// NOTE
----------------------------------------------------------------------------
secured WebGine
net-based application engine
----------------------------------------------------------------------------
(C) direct Netware Group - All rights reserved
http://www.direct-netware.de/redirect.php?swg

This work is distributed under the W3C (R) Software License, but without any
warranty; without even the implied warranty of merchantability or fitness
for a particular purpose.
----------------------------------------------------------------------------
http://www.direct-netware.de/redirect.php?licenses;w3c
----------------------------------------------------------------------------
$Id: swgi_account_registration.php,v 1.4 2008/12/30 19:02:14 s4u Exp $
#echo(sWGbasicVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* validation/swg_account_registration.php
*
* @internal   We are using phpDocumentor to automate the documentation process
*             for creating the Developer's Manual. All sections including
*             these special comments will be removed from the release source
*             code.
*             Use the following line to ensure 76 character sizes:
* ----------------------------------------------------------------------------
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage account
* @uses       direct_product_iversion
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Basic configuration

/* -------------------------------------------------------------------------
Direct calls will be honored with an "exit ()"
------------------------------------------------------------------------- */

if (!defined ("direct_product_iversion")) { exit (); }

//j// Script specific commands

if (!isset ($direct_settings['account_registration_mods_support'])) { $direct_settings['account_registration_mods_support'] = false; }
if (!isset ($direct_settings['users_registration_credits_onetime'])) { $direct_settings['users_registration_credits_onetime'] = 200; }
if (!isset ($direct_settings['users_registration_credits_periodically'])) { $direct_settings['users_registration_credits_periodically'] = 0; }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGbasicVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

$direct_classes['basic_functions']->settings_get ($direct_settings['path_data']."/settings/swg_account.php",true);
$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_mods_support.php");
$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_log_storager.php");
$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_credits_manager.php");

if (USE_debug_reporting) { direct_debug (2,"sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }

if (direct_local_integration ("account"))
{
	$direct_classes['db']->init_select ($direct_settings['users_table']);
	$direct_classes['db']->define_attributes (array ($direct_settings['users_table'].".ddbusers_email"));

$g_select_criteria = ("<sqlconditions>
".($direct_classes['db']->define_row_conditions_encode ($direct_settings['users_table'].".ddbusers_email",$direct_cachedata['validation_data']['account_email'],"string"))."
<element1 attribute='{$direct_settings['users_table']}.ddbusers_deleted' value='0' type='string' />
</sqlconditions>");

	$direct_classes['db']->define_row_conditions ($g_select_criteria);
	$direct_classes['db']->define_limit (1);

	if ($direct_classes['db']->query_exec ("nr")) { $direct_cachedata['validation_error'] = array ("validation_email_exists","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }
	elseif ($direct_classes['kernel']->v_user_check ("",$direct_cachedata['validation_data']['account_username'],true)) { $direct_cachedata['validation_error'] = array ("validation_username_exists","SERVICE ERROR:<br />&quot;{$direct_cachedata['validation_data']['account_username']}&quot; has already been registered in the meantime<br />sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }
	else
	{
		$g_uid = uniqid ("");

$g_user_array = array (
"ddbusers_id" => $g_uid,
"ddbusers_type" => "me",
"ddbusers_banned" => 0,
"ddbusers_deleted" => 0,
"ddbusers_locked" => 0,
"ddbusers_name" => $direct_cachedata['validation_data']['account_username'],
"ddbusers_password" => $direct_cachedata['validation_data']['account_password'],
"ddbusers_email" => $direct_cachedata['validation_data']['account_email'],
"ddbusers_email_public" => 0,
"ddbusers_credits" => $direct_settings['users_registration_credits_onetime'],
"ddbusers_registration_ip" => $direct_settings['user_ip'],
"ddbusers_registration_time" => $direct_cachedata['core_time'],
"ddbusers_secid" => $direct_cachedata['validation_data']['account_secid'],
"ddbusers_lastvisit_ip" => $direct_settings['user_ip'],
"ddbusers_lastvisit_time" => $direct_cachedata['core_time'],
"ddbusers_timezone" => 0
);

		if ($direct_classes['kernel']->v_user_insert ($g_uid,$g_user_array))
		{
			if ($direct_settings['users_registration_credits_periodically']) { direct_credits_payment_exec ("account","account",$g_uid,$g_uid,0,$direct_settings['users_registration_credits_periodically']); }

$g_log_array = array (
"source_user_id" => $g_uid,
"source_user_ip" => $direct_settings['user_ip'],
"sid" => "e268443e43d93dab7ebef303bbe9642f",
// md5 ("account")
"identifier" => "account_registered"
);

			direct_log_write ($g_log_array);

			if (direct_mods_include ($direct_settings['account_registration_mods_support'],"account_registration","test")) { direct_mods_include (true,"account_registration","validation",$g_user_array); }
		}
		else
		{
			$direct_cachedata['validation_error'] = array ("core_database_error","FATAL ERROR:<br />The system was unable to create the new account for ID &quot;$g_uid&quot;<br />sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)");
			$direct_cachedata['validation_remove_vid'] = false;
		}
	}
}
else
{
	$direct_cachedata['validation_error'] = array ("error" => true);
	$direct_cachedata['validation_remove_vid'] = false;
}

//j// EOF
?>