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
* account/swg_password_change.php
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

if (!isset ($direct_settings['account_https_password_change'])) { $direct_settings['account_https_password_change'] = false; }
if (!isset ($direct_settings['serviceicon_account_profile_edit'])) { $direct_settings['serviceicon_account_profile_edit'] = "mini_default_option.png"; }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
if (!isset ($direct_settings['swg_pyhelper'])) { $direct_settings['swg_pyhelper'] = false; }
if (!isset ($direct_settings['users_password_min'])) { $direct_settings['users_password_min'] = 6; }
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

	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_globals['basic_functions']->inputfilter_basic ($direct_settings['dsd']['source'])) : "");
	$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_globals['basic_functions']->inputfilter_basic ($direct_settings['dsd']['target'])) : "");

	$g_source_url = ($g_source ? base64_decode ($g_source) : "m=account;a=services");
	$g_target_url = ($g_target ? base64_decode ($g_target) : "m=account;s=profile;a=view;dsd=[oid]");

	if ($g_mode_save)
	{
		$direct_cachedata['page_this'] = "";
		$direct_cachedata['page_backlink'] = "m=account;s=password_change;a=form;dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_homelink'] = str_replace ("[oid]","",$g_source_url);
	}
	else
	{
		$direct_cachedata['page_this'] = "m=account;s=password_change;a=form;dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_backlink'] = str_replace ("[oid]","",$g_source_url);
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'] ;
	}

	if ($direct_globals['kernel']->service_init_default ())
	{
	if (($direct_settings['user']['type'] == "ex")||($direct_settings['user']['type'] == "gt")) { $direct_globals['output']->output_send_error ("login","core_access_denied","","sWG/#echo(__FILEPATH__)# _a=form_ (#echo(__LINE__)#)"); }
	else
	{
	//j// BOA
	if ($g_mode_save)
	{
		if ($g_mode_ajax_dialog) { $direct_globals['output']->related_manager ("account_password_change_form_save","pre_module_service_action_ajax"); }
		else { $direct_globals['output']->related_manager ("account_password_change_form_save","pre_module_service_action"); }
	}
	elseif ($g_mode_ajax_dialog) { $direct_globals['output']->related_manager ("account_password_change_form","pre_module_service_action_ajax"); }
	else
	{
		$direct_globals['output']->related_manager ("account_password_change_form","pre_module_service_action");
		$direct_globals['kernel']->service_https ($direct_settings['account_https_password_change'],$direct_cachedata['page_this']);
	}

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
	$direct_globals['output']->options_insert (1,"servicemenu","m=account;s=profile;a=edit",(direct_local_get ("account_profile_edit")),$direct_settings['serviceicon_account_profile_edit'],"url0");
	$direct_globals['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

	if ($g_mode_save)
	{
/* -------------------------------------------------------------------------
We should have input in save mode
------------------------------------------------------------------------- */

		$direct_cachedata['i_apassword'] = (isset ($GLOBALS['i_apassword']) ? ($direct_globals['basic_functions']->inputfilter_basic ($GLOBALS['i_apassword'])) : "");
		$direct_cachedata['i_apassword_new'] = (isset ($GLOBALS['i_apassword_new']) ? ($direct_globals['basic_functions']->inputfilter_basic ($GLOBALS['i_apassword_new'])) : "");
	}

/* -------------------------------------------------------------------------
Build the form
------------------------------------------------------------------------- */

	$direct_globals['formbuilder']->entry_add_password (array ("name" => "apassword","title" => (direct_local_get ("core_password")),"required" => true,"min" => $direct_settings['users_password_min']),"tmd5");
	$direct_globals['formbuilder']->entry_add_password (array ("name" => "apassword_new","title" => (direct_local_get ("account_password_new")),"required" => true,"min" => $direct_settings['users_password_min'],"max" => 0,"helper_text" => ((direct_local_get ("core_helper_password_1")).$direct_settings['users_password_min'].(direct_local_get ("core_helper_password_2")))),"2_tmd5");

	$direct_cachedata['output_formelements'] = $direct_globals['formbuilder']->form_get ($g_mode_save);

	if (($g_mode_save)&&($direct_globals['formbuilder']->check_result))
	{
		$g_user_array = $direct_globals['kernel']->v_user_get ($direct_settings['user']['id'],"",true);

		if ($direct_cachedata['i_apassword'] == $g_user_array['ddbusers_password'])
		{
			if (!$direct_settings['account_password_change_time']) { $direct_settings['account_password_change_time'] = 432000; }

$g_vid_array = array (
"core_vid_module" => "account_password_change",
"account_userid" => $direct_settings['user']['id'],
"account_password" => $direct_cachedata['i_apassword_new']
);

			$g_vid = md5 (uniqid (""));
			$g_vid_timeout = ($direct_cachedata['core_time'] + $direct_settings['account_password_change_time']);
			$g_continue_check = direct_tmp_storage_write ($g_vid_array,$g_vid,"a617908b172c473cb8e8cda059e55bf0","password_change","evars",0,$g_vid_timeout);
			// md5 ("validation")

			if ($g_continue_check)
			{
				$g_redirect_url = ((isset ($direct_settings['swg_redirect_url'])) ? $direct_settings['swg_redirect_url'] : $direct_settings['iscript_req']."?redirect;");

$g_message = ("[contentform:highlight]".(direct_local_get ("core_message_by_request","text"))."

[font:bold]".(direct_local_get ("core_message_to","text")).":[/font] {$g_user_array['ddbusers_name']} ({$g_user_array['ddbusers_email']})[/contentform]

".(direct_local_get ("core_validation_required","text"))."

".(direct_local_get ("account_validation_for_password_change","text"))."

[url]{$g_redirect_url}validation;{$g_vid}[/url]

".(direct_local_get ("core_one_line_link","text")));

				if ($direct_settings['swg_pyhelper'])
				{
					$g_daemon_object = new direct_web_pyHelper ();

$g_entry_array = array (
"id" => uniqid (""),
"name" => "de.direct_netware.sWG.plugins.sendmail",
"identifier" => $g_user_array['ddbusers_email'],
"data" => direct_evars_write (array (
 "core_lang" => $g_user_array['ddbusers_lang'],
 "account_sendmail_message" => $g_message,
 "account_sendmail_recipient_email" => $g_user_array['ddbusers_email'],
 "account_sendmail_recipient_name" => $g_user_array['ddbusers_name'],
 "account_sendmail_title" => direct_local_get ("account_title_password_change","text")
 ))
);

					$g_continue_check = ($g_daemon_object ? $g_daemon_object->resource_check () : false);

					if ($g_continue_check) { $g_daemon_object->request ("de.direct_netware.psd.plugins.queue.addEntry",$g_entry_array); }
					else { $direct_globals['output']->output_send_error ("standard","core_daemon_unavailable","","sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }
				}
				else
				{
					$g_sendmailer_object = new direct_sendmailer_formtags ();
					$g_sendmailer_object->recipients_define (array ($g_user_array['ddbusers_email'] => $g_user_array['ddbusers_name']));

					$g_sendmailer_object->message_set ($g_message);
					$g_sendmailer_object->send ("single",$direct_settings['administration_email_out'],$direct_settings['swg_title_txt']." - ".(direct_local_get ("account_title_password_change","text")));
				}
			}
			else { $direct_globals['output']->output_send_error ("fatal","core_database_error","FATAL ERROR: tmpStorager has reported an error","sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }

			if ($g_continue_check)
			{
				$direct_cachedata['output_job'] = direct_local_get ("account_password_change");
				$direct_cachedata['output_job_desc'] = direct_local_get ("account_done_password_change");
				$direct_cachedata['output_jsjump'] = 0;

				if ($g_target_url)
				{
					$direct_cachedata['output_pagetarget'] = str_replace ("[oid]","auid_d+{$direct_settings['user']['id']}++",$g_target_url);
					$direct_cachedata['output_pagetarget'] = str_replace ('"',"",(direct_linker ("url0",$direct_cachedata['output_pagetarget'])));
				}

				if ($g_mode_ajax_dialog)
				{
					$direct_globals['output']->header (false,true);
					$direct_globals['output']->related_manager ("account_password_change_form_save","post_module_service_action_ajax");
					$direct_globals['output']->oset ("default_embedded","ajax_dialog_done");
					$direct_globals['output']->output_send (direct_local_get ("core_done").": ".$direct_cachedata['output_job']);
				}
				else
				{
					$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
					$direct_globals['output']->related_manager ("account_password_change_form_save","post_module_service_action");
					$direct_globals['output']->oset ("default","done");
					$direct_globals['output']->output_send ($direct_cachedata['output_job']);
				}
			}
		}
		else { $direct_globals['output']->output_send_error ("standard","account_password_invalid","","sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }
	}
	elseif ($g_mode_ajax_dialog)
	{
		$direct_globals['output']->header (false,true);
		$direct_globals['output']->related_manager ("account_password_change_form_save","post_module_service_action_ajax");
		$direct_globals['output']->oset ("default_embedded","ajax_dialog_form_results");
		$direct_globals['output']->output_send (direct_local_get ("formbuilder_error"));
	}
	else
	{
/* -------------------------------------------------------------------------
View form
------------------------------------------------------------------------- */

		$direct_cachedata['output_formbutton'] = direct_local_get ("account_password_change");
		$direct_cachedata['output_formsupport_ajax_dialog'] = true;
		$direct_cachedata['output_formtarget'] = "m=account;s=password_change;a=form-save;dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['output_formtitle'] = direct_local_get ("account_password_change");

		$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
		$direct_globals['output']->related_manager ("account_password_change_form","post_module_service_action");
		$direct_globals['output']->oset ("default","form");
		$direct_globals['output']->output_send ($direct_cachedata['output_formtitle']);
	}
	//j// EOA
	}
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>