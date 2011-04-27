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
* account/swg_email.php
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

if (!isset ($direct_settings['account_email_change_time'])) { $direct_settings['account_email_change_time'] = 432000; }
if (!isset ($direct_settings['account_email_validation_time'])) { $direct_settings['account_email_validation_time'] = $direct_settings['account_email_change_time']; }
if (!isset ($direct_settings['account_https_email'])) { $direct_settings['account_https_email'] = false; }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
if (!isset ($direct_settings['swg_pyhelper'])) { $direct_settings['swg_pyhelper'] = false; }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGbasicVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "form"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// ($direct_settings['a'] == "form")||($direct_settings['a'] == "form-save")
case "form":
case "form-save":
{
	$g_mode_ajax_dialog = false;
	$g_mode_save = false;

	if ($direct_settings['a'] == "form-save")
	{
		if ($direct_settings['ohandler'] == "ajax_dialog") { $g_mode_ajax_dialog = true; }
		$g_mode_save = true;
	}

	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }

	$direct_cachedata['output_uid'] = (isset ($direct_settings['dsd']['auid']) ? ($direct_globals['basic_functions']->inputfilter_basic ($direct_settings['dsd']['auid'])) : "");
	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_globals['basic_functions']->inputfilter_basic ($direct_settings['dsd']['source'])) : "");
	$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_globals['basic_functions']->inputfilter_basic ($direct_settings['dsd']['target'])) : "");

	$g_source_url = ($g_source ? base64_decode ($g_source) : "m=account;s=profile;a=view;dsd=[oid]");

	if ($g_target) { $g_target_url = base64_decode ($g_target); }
	else
	{
		$g_target = $g_source;
		$g_target_url = $g_source_url;
	}

	if ($g_mode_save)
	{
		$direct_cachedata['page_this'] = "";
		$direct_cachedata['page_backlink'] = "m=account;s=email;a=form;dsd=auid+{$direct_cachedata['output_uid']}++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_homelink'] = str_replace ("[oid]","auid+{$direct_cachedata['output_uid']}++",$g_source_url);
	}
	else
	{
		$direct_cachedata['page_this'] = "m=account;s=email;a=form;dsd=auid+{$direct_cachedata['output_uid']}++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_backlink'] = str_replace ("[oid]","auid+{$direct_cachedata['output_uid']}++",$g_source_url);
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'] ;
	}

	if ($direct_globals['kernel']->service_init_default ())
	{
	//j// BOA
	if ($g_mode_save)
	{
		if ($g_mode_ajax_dialog) {$direct_globals['output']->related_manager ("account_email_form_save","pre_module_service_action_ajax"); }
		else {$direct_globals['output']->related_manager ("account_email_form_save","pre_module_service_action"); }
	}
	elseif ($g_mode_ajax_dialog) { $direct_globals['output']->related_manager ("account_email_form","pre_module_service_action_ajax"); }
	else
	{
		$direct_globals['output']->related_manager ("account_email_form","pre_module_service_action");
		$direct_globals['kernel']->service_https ($direct_settings['account_https_email'],$direct_cachedata['page_this']);
	}

	$g_user_array = $direct_globals['kernel']->v_user_get ($direct_cachedata['output_uid'],"",true);

	if ((is_array ($g_user_array))&&(($g_user_array['ddbusers_email_public']))||($direct_globals['kernel']->v_usertype_get_int ($direct_settings['user']['type']) > 3))
	{
		$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formbuilder.php");
		direct_local_integration ("account");

		if ($g_mode_save)
		{
			$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php");

			if ($direct_settings['swg_pyhelper']) { $direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/classes/web_services/swg_pyHelper.php"); }
			else { $direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_sendmailer_formtags.php"); }
		}

		direct_class_init ("formbuilder");
		$direct_globals['output']->servicemenu ("account");
		$direct_globals['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

		if ($g_mode_save)
		{
/* -------------------------------------------------------------------------
We should have input in save mode
------------------------------------------------------------------------- */

			$direct_cachedata['i_asource_address'] = (isset ($GLOBALS['i_asource_address']) ? ($direct_globals['basic_functions']->inputfilter_basic ($GLOBALS['i_asource_address'])) : "");
			$direct_cachedata['i_amessage'] = (isset ($GLOBALS['i_amessage']) ? ($direct_globals['basic_functions']->inputfilter_basic ($GLOBALS['i_amessage'])) : "");
		}

/* -------------------------------------------------------------------------
Build the form
------------------------------------------------------------------------- */

		if (($direct_settings['user']['type'] == "ex")||($direct_settings['user']['type'] == "gt")) { $direct_globals['formbuilder']->entry_add_email (array ("name" => "asource_address","title" => (direct_local_get ("account_email_user_source")),"required" => true,"size" => "s","min" => 5,"max" => 255)); }
		$direct_globals['formbuilder']->entry_add_rcp_textarea (array ("name" => "amessage","title" => (direct_local_get ("account_email_user_message")),"required" => true,"size" => "l"));

		$direct_cachedata['output_formelements'] = $direct_globals['formbuilder']->form_get ($g_mode_save);

		if (($g_mode_save)&&($direct_globals['formbuilder']->check_result))
		{
			$direct_cachedata['i_amessage'] = $direct_globals['formtags']->encode ($direct_cachedata['i_amessage']);
			$g_continue_check = false;

			if (($direct_settings['user']['type'] == "ex")||($direct_settings['user']['type'] == "gt"))
			{
				$g_vid = md5 (uniqid (""));
				$g_vid_timeout = ($direct_cachedata['core_time'] + $direct_settings['account_email_validation_time']);

$g_vid_array = array (
"core_vid_module" => "account_email_user_message",
"account_recipient_address" => $g_user_array['ddbusers_email'],
"account_recipient_name" => $g_user_array['ddbusers_name'],
"account_source_address" => $direct_cachedata['i_asource_address'],
"account_message" => $direct_cachedata['i_amessage']
);

				if (direct_tmp_storage_write ($g_vid_array,$g_vid,"a617908b172c473cb8e8cda059e55bf0","email_user_message","evars",0,$g_vid_timeout))
				{
					$g_redirect_url = ((isset ($direct_settings['swg_redirect_url'])) ? $direct_settings['swg_redirect_url'] : $direct_settings['iscript_req']."?redirect;");

$g_message = ("[contentform:highlight]".(direct_local_get ("core_message_by_request","text"))."

[font:bold]".(direct_local_get ("core_message_to","text")).":[/font] {$direct_cachedata['i_asource_address']}[/contentform]

".(direct_local_get ("core_validation_required","text"))."

".(direct_local_get ("account_validation_for_email_1","text"))."\"{$g_user_array['ddbusers_name']}\"".(direct_local_get ("account_validation_for_email_2","text"))."

[url]{$g_redirect_url}validation;".$g_vid."[/url]

".(direct_local_get ("core_one_line_link","text")));

					if ($direct_settings['swg_pyhelper'])
					{
						$g_daemon_object = new direct_web_pyHelper ();

$g_entry_array = array (
"id" => uniqid (""),
"name" => "de.direct_netware.sWG.plugins.sendmail",
"identifier" => $direct_cachedata['i_asource_address'],
"data" => direct_evars_write (array (
 "core_lang" => $direct_settings['lang'],
 "account_sendmail_message" => $g_message,
 "account_sendmail_recipient_email" => $direct_cachedata['i_asource_address'],
 "account_sendmail_title" => direct_local_get ("account_email_user_message","text")
 ))
);

						$g_continue_check = $g_daemon_object->resource_check ();
						if ($g_continue_check) { $g_continue_check = $g_daemon_object->request ("de.direct_netware.psd.plugins.queue.addEntry",$g_entry_array); }
					}
					else
					{
						$g_sendmailer_object = new direct_sendmailer_formtags ();
						$g_sendmailer_object->recipients_define ($direct_cachedata['i_asource_address']);

						$g_sendmailer_object->message_set ($g_message);
						$g_continue_check = $g_sendmailer_object->send ("single",$direct_settings['administration_email_out'],$direct_settings['swg_title_txt']." - ".(direct_local_get ("account_email_user_message","text")));
					}

					$direct_cachedata['output_job_desc'] = direct_local_get ("account_done_email_user_1");
					$direct_cachedata['output_jsjump'] = 5000;
				}
			}
			else
			{
				$g_source_array = $direct_globals['kernel']->v_user_get ($direct_settings['user']['id'],"",true);
				$g_sender = $g_source_array['ddbusers_name']." ({$g_source_array['ddbusers_email']})";

$g_message = ("[contentform:highlight]".(direct_local_get ("core_message_by_user","text"))."

[font:bold]".(direct_local_get ("core_message_from","text")).":[/font] $g_sender
[font:bold]".(direct_local_get ("core_message_to","text")).":[/font] {$g_user_array['ddbusers_name']} ({$g_user_array['ddbusers_email']})[/contentform]

[font:bold]".(direct_local_get ("core_message","text")).":[/font]

[hr]
".$direct_cachedata['i_amessage']);

				if ($direct_settings['swg_pyhelper'])
				{
					$g_daemon_object = new direct_web_pyHelper ();

$g_entry_array = array (
"id" => uniqid (""),
"name" => "de.direct_netware.sWG.plugins.sendmail",
"identifier" => $g_user_array['ddbusers_email'],
"data" => direct_evars_write (array (
 "core_lang" => $direct_settings['lang'],
 "account_sendmail_message" => $g_message,
 "account_sendmail_recipient_email" => $g_user_array['ddbusers_email'],
 "account_sendmail_recipient_name" => $g_user_array['ddbusers_name'],
 "account_sendmail_title" => direct_local_get ("account_email_user_message","text")
 ))
);

					$g_continue_check = $g_daemon_object->resource_check ();
					if ($g_continue_check) { $g_continue_check = $g_daemon_object->request ("de.direct_netware.psd.plugins.queue.addEntry",$g_entry_array); }
				}
				else
				{
					$g_sendmailer_object = new direct_sendmailer_formtags ();
					$g_sendmailer_object->recipients_define (array ($g_user_array['ddbusers_email'] => $g_user_array['ddbusers_name']));

					$g_sendmailer_object->message_set ($g_message);
					$g_continue_check = $g_sendmailer_object->send ("single",$direct_settings['administration_email_out'],$direct_settings['swg_title_txt']." - ".(direct_local_get ("account_email_user_message","text")));
				}

				$direct_cachedata['output_job_desc'] = direct_local_get ("account_done_email_user_2");
				$direct_cachedata['output_jsjump'] = 2000;
			}

			if ($g_continue_check)
			{
				$direct_cachedata['output_job'] = direct_local_get ("account_email_user");

				if ($g_target_url)
				{
					$g_target_link = str_replace ("[oid]","auid_d+{$g_user_array['ddbusers_id']}++",$g_target_url);

					$direct_cachedata['output_pagetarget'] = str_replace ('"',"",(direct_linker ("url0",$g_target_link)));
					$direct_globals['output']->options_flush (true);
				}
				else { $direct_cachedata['output_jsjump'] = 0; }

				if ($g_mode_ajax_dialog)
				{
					$direct_globals['output']->header (false,true);
					$direct_globals['output']->related_manager ("account_email_form_save","post_module_service_action_ajax");
					$direct_globals['output']->oset ("default_embedded","ajax_dialog_done");
					$direct_globals['output']->output_send (direct_local_get ("core_done").": ".$direct_cachedata['output_job']);
				}
				else
				{
					$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
					$direct_globals['output']->related_manager ("account_email_form_save","post_module_service_action");
					$direct_globals['output']->oset ("default","done");
					$direct_globals['output']->output_send ($direct_cachedata['output_job']);
				}
			}
			else { $direct_globals['output']->output_send_error ("fatal","core_unknown_error","","sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }
		}
		elseif ($g_mode_ajax_dialog)
		{
			$direct_globals['output']->header (false,true);
			$direct_globals['output']->related_manager ("account_email_form_save","post_module_service_action_ajax");
			$direct_globals['output']->oset ("default_embedded","ajax_dialog_form_results");
			$direct_globals['output']->output_send (direct_local_get ("formbuilder_error"));
		}
		else
		{
/* -------------------------------------------------------------------------
View form
------------------------------------------------------------------------- */

			$direct_cachedata['output_formbutton'] = direct_local_get ("core_continue");
			$direct_cachedata['output_formsupport_ajax_dialog'] = true;
			$direct_cachedata['output_formtarget'] = "m=account;s=email;a=form-save;dsd=auid+{$direct_cachedata['output_uid']}++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
			$direct_cachedata['output_formtitle'] = direct_local_get ("account_email_user");

			$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_globals['output']->related_manager ("account_email_form","post_module_service_action");
			$direct_globals['output']->oset ("default","form");
			$direct_globals['output']->output_send ($direct_cachedata['output_formtitle']);
		}
	}
	else { $direct_globals['output']->output_send_error ("standard","core_username_unknown","","sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>