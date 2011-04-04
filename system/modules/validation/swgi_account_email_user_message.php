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
#echo(sWGbasicVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* validation/swgi_account_email_user_message.php
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

if (!isset ($direct_settings['swg_pyhelper'])) { $direct_settings['swg_pyhelper'] = false; }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGbasicVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if (USE_debug_reporting) { direct_debug (2,"sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }

if (($direct_settings['swg_pyhelper'])&&($direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/web_services/swg_pyHelper.php"))) { $g_continue_check = defined ("CLASS_direct_web_pyHelper"); }
else { $g_continue_check = $direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_sendmailer_formtags.php"); }

if ($g_continue_check)
{
	direct_local_integration ("account");

$g_message = ("[contentform:highlight]".(direct_local_get ("core_message_by_user","text"))."

[font:bold]".(direct_local_get ("core_message_from","text")).":[/font] {$direct_cachedata['validation_data']['source_address']}
[font:bold]".(direct_local_get ("core_message_to","text")).":[/font] {$direct_cachedata['validation_data']['recipient_name']} ({$direct_cachedata['validation_data']['recipient_address']})[/contentform]

[font:bold]".(direct_local_get ("core_message","text")).":[/font]

[hr]
".$direct_cachedata['validation_data']['message']);

	if ($direct_settings['swg_pyhelper'])
	{
		$g_daemon_object = new direct_web_pyHelper ();

$g_entry_array = array (
"id" => uniqid (""),
"name" => "de.direct_netware.sWG.plugins.sendmail",
"identifier" => $direct_cachedata['validation_data']['recipient_address'],
"data" => direct_evars_write (array (
 "core_lang" => $g_user_array['ddbusers_lang'],
 "account_sendmail_message" => $g_message,
 "account_sendmail_recipient_email" => $direct_cachedata['validation_data']['recipient_address'],
 "account_sendmail_recipient_name" => $direct_cachedata['validation_data']['recipient_name'],
 "account_sendmail_title" => direct_local_get ("account_email_user_message","text")
 ))
);

		$g_continue_check = ($g_daemon_object ? $g_daemon_object->resource_check () : false);
		if ($g_continue_check) { $g_continue_check = $g_daemon_object->request ("de.direct_netware.psd.plugins.queue.addEntry",$g_entry_array); }
	}
	else
	{
		$g_sendmailer_object = new direct_sendmailer_formtags ();
		$g_sendmailer_object->recipients_define (array ($direct_cachedata['validation_data']['recipient_address'] => $direct_cachedata['validation_data']['recipient_name']));

		$g_sendmailer_object->message_set ($g_message);
		$g_continue_check = $g_sendmailer_object->send ("single",$direct_settings['administration_email_out'],$direct_settings['swg_title_txt']." - ".(direct_local_get ("account_email_user_message","text")));
	}
}

if (!$g_continue_check) { $direct_cachedata['validation_error'] = array ("core_unknown_error","","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }

//j// EOF
?>