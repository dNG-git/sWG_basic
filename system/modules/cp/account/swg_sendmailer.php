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
* cp/account/swg_sendmailer.php
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
* @subpackage cp_account
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
if (!isset ($direct_settings['swg_pyhelper_password'])) { $direct_settings['swg_pyhelper_password'] = NULL; }

//j// BOS
switch ($direct_settings['a'])
{
//j// ($direct_settings['a'] == "sendmail")
case "sendmail":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=sendmail_ (#echo(__LINE__)#)"); }

	if (($direct_globals['kernel']->service_init_default ())&&($direct_settings['ohandler'] == "xmlrpc"))
	{
	$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/classes/web_services/swg_http_xmlrpc.php");

	if ($direct_globals['input']->user_get () == $direct_settings['swg_id'])
	{
	//j// BOA
	$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_sendmailer_formtags.php");

	$g_data = $direct_globals['basic_functions']->inputfilter_basic ($direct_globals['input']->get_params (0));
	$g_data_array = ($g_data ? direct_evars_get ($g_data) : NULL);

	if ((is_array ($g_data_array))&&(isset ($g_data_array['account_sendmail_message'],$g_data_array['account_sendmail_recipient_email'],$g_data_array['account_sendmail_title'])))
	{
		$g_sendmailer_object = new direct_sendmailer_formtags ();

		if (isset ($g_data_array['account_sendmail_recipient_name'])) { $g_sendmailer_object->recipients_define (array ($g_data_array['account_sendmail_recipient_email'] => $g_data_array['account_sendmail_recipient_name'])); }
		else { $g_sendmailer_object->recipients_define ($g_data_array['account_sendmail_recipient_email']); }

		$g_sendmailer_object->message_set ($g_data_array['account_sendmail_message']);
		$g_continue_check = (((isset ($g_data_array['account_sendmail_sender']))&&(strlen ($g_data_array['account_sendmail_sender']))) ? $g_sendmailer_object->send ("single",$g_data_array['account_sendmail_sender'],$direct_settings['swg_title_txt']." - ".$g_data_array['account_sendmail_title']) : $g_sendmailer_object->send ("single",$direct_settings['administration_email_out'],$direct_settings['swg_title_txt']." - ".$g_data_array['account_sendmail_title']));

		if ($g_continue_check)
		{
			$direct_globals['output']->set (true);
			$direct_globals['output']->output_send ();
		}
		else { $direct_globals['output']->output_send_error (direct_web_http_xmlrpc::$RESULT_504); }
	}
	else { $direct_globals['output']->output_send_error (direct_web_http_xmlrpc::$RESULT_400); }
	//j// EOA
	}
	else { $direct_globals['output']->output_send_error (direct_web_http_xmlrpc::$RESULT_403); }

	$direct_cachedata['core_service_activated'] = true;
	}

	break 1;
}
//j// EOS
}

//j// EOF
?>