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
* account/swg_registration.php
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

if (!isset ($direct_settings['account_registration'])) { $direct_settings['account_registration'] = false; }
if (!isset ($direct_settings['account_https_registration'])) { $direct_settings['account_https_registration'] = false; }
if (!isset ($direct_settings['account_registration_mods_support'])) { $direct_settings['account_registration_mods_support'] = false; }
if (!isset ($direct_settings['account_secid_bytemix'])) { $direct_settings['account_secid_bytemix'] = ($direct_settings['swg_id'] ^ (strrev ($direct_settings['swg_id']))); }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
if (!isset ($direct_settings['users_min'])) { $direct_settings['users_min'] = 3; }
if (!isset ($direct_settings['users_registration_credits_onetime'])) { $direct_settings['users_registration_credits_onetime'] = 200; }
if (!isset ($direct_settings['users_registration_credits_periodically'])) { $direct_settings['users_registration_credits_periodically'] = 0; }
if (!isset ($direct_settings['users_registration_time'])) { $direct_settings['users_registration_time'] = 864000; }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGbasicVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "form"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// ($direct_settings['a'] == "form")||($direct_settings['a'] == "form-save")
case "form":
case "form-save":
{
	if ($direct_settings['a'] == "form-save") { $g_mode_save = true; }
	else { $g_mode_save = false; }

	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }

	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['source'])) : "");
	$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['target'])) : "");

	if ($g_source) { $g_source_url = base64_decode ($g_source); }
	else { $g_source_url = "m=account&a=services"; }

	if ($g_target) { $g_target_url = base64_decode ($g_target); }
	else
	{
		$g_target = $g_source;
		$g_target_url = $g_source_url;
	}

	if ($g_mode_save)
	{
		$direct_cachedata['page_this'] = "";
		$direct_cachedata['page_backlink'] = "m=account&s=registration&a=form&dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_homelink'] = str_replace ("[oid]","",$g_source_url);
	}
	else
	{
		$direct_cachedata['page_this'] = "m=account&s=registration&a=form&dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_backlink'] = str_replace ("[oid]","",$g_source_url);
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'] ;
	}

	if ($direct_classes['kernel']->service_init_default ())
	{
	if ($direct_settings['account_registration'])
	{
	//j// BOA
	if ($direct_settings['user']['type'] = "gt")
	{
		if ($g_mode_save) { direct_output_related_manager ("account_registration_form_save","pre_module_service_action"); }
		else
		{
			direct_output_related_manager ("account_registration_form","pre_module_service_action");
			$direct_classes['kernel']->service_https ($direct_settings['account_https_registration'],$direct_cachedata['page_this']);
		}

		$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formbuilder.php");
		$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_credits_manager.php");
		$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_mods_support.php");
		direct_local_integration ("account");

		if ($g_mode_save)
		{
			$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_sendmailer_formtags.php");
			$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php");
		}

		direct_class_init ("formbuilder");
		direct_class_init ("output");
		$direct_classes['output']->servicemenu ("account");
		$direct_classes['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

		if ($g_mode_save)
		{
/* -------------------------------------------------------------------------
We should have input in save mode
------------------------------------------------------------------------- */

			$direct_cachedata['i_ausername'] = (isset ($GLOBALS['i_ausername']) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS['i_ausername'])) : "");
			$direct_cachedata['i_aemail'] = (isset ($GLOBALS['i_aemail']) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS['i_aemail'])) : "");
			$direct_cachedata['i_apassword'] = (isset ($GLOBALS['i_apassword']) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS['i_apassword'])) : "");

			$direct_cachedata['i_atou'] = (isset ($GLOBALS['i_atou']) ? (str_replace ("'","",$GLOBALS['i_atou'])) : 0);
			$direct_cachedata['i_atou'] = str_replace ("<value value='$direct_cachedata[i_atou]' />","<value value='$direct_cachedata[i_atou]' /><selected value='1' />","<evars><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes><no><value value='0' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no></evars>");
		}
		else
		{
			$direct_cachedata['i_ausername'] = "";
			$direct_cachedata['i_aemail'] = "";
			$direct_cachedata['i_apassword'] = "";
			$direct_cachedata['i_atou'] = "<evars><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes><no><value value='0' /><selected value='1' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no></evars>";
		}

/* -------------------------------------------------------------------------
Build the form
------------------------------------------------------------------------- */

		$direct_classes['formbuilder']->entry_add_text ("ausername",(direct_local_get ("core_username")),true,"l",$direct_settings['users_min'],100,((direct_local_get ("core_helper_username_1")).$direct_settings['users_min'].(direct_local_get ("core_helper_username_2"))),"",true);
		$direct_classes['formbuilder']->entry_add_email ("aemail",(direct_local_get ("account_email")),true,"l",5,255,(direct_local_get ("account_helper_email")),"",true);
		$direct_classes['formbuilder']->entry_add_password ("2_tmd5","apassword",(direct_local_get ("core_password")),true,"l",$direct_settings['users_password_min'],0,((direct_local_get ("core_helper_password_1")).$direct_settings['users_password_min'].(direct_local_get ("core_helper_password_2"))),"",true);
		$direct_classes['formbuilder']->entry_add_file_ftg ("aregister_tou",(direct_local_get ("account_register_tou")),$direct_settings['path_data']."/settings/swg_account_tou.ftf","l");
		$direct_classes['formbuilder']->entry_add_select ("atou",(direct_local_get ("account_register_tou_accept")),true,"s");

/* -------------------------------------------------------------------------
Call registered mods
------------------------------------------------------------------------- */

		if ($g_mode_save) { direct_mods_include ($direct_settings['account_registration_mods_support'],"account_registration","form_check"); }
		else { direct_mods_include ($direct_settings['account_registration_mods_support'],"account_registration","form"); }

		$direct_cachedata['output_formelements'] = $direct_classes['formbuilder']->form_get ($g_mode_save);

		if (($g_mode_save)&&($direct_classes['formbuilder']->check_result))
		{
			$g_email_blacklist_array = direct_file_get ("a",$direct_settings['path_data']."/settings/swg_blacklist_email.php");
			$g_username_invalid_chars = preg_replace ("#[0-9a-zA-Z\!\$\%\&\/\(\)\{\}\[\]\?\@\*\~\#,\.\-\;_ ]#i","",$direct_cachedata['i_ausername']);

			$direct_classes['db']->init_select ($direct_settings['users_table']);
			$direct_classes['db']->define_attributes (array ("ddbusers_email"));

$g_select_criteria = ("<sqlconditions>
".($direct_classes['db']->define_row_conditions_encode ("ddbusers_email",$direct_cachedata['i_aemail'],"string"))."
<element1 attribute='ddbusers_deleted' value='0' type='string' />
</sqlconditions>");

			$direct_classes['db']->define_row_conditions ($g_select_criteria);
			$direct_classes['db']->define_limit (1);

			if ($direct_classes['db']->query_exec ("nr")) { $direct_classes['error_functions']->error_page ("standard","account_email_exists","sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }
			elseif ($direct_classes['kernel']->v_user_check ("",$direct_cachedata['i_ausername'],true)) { $direct_classes['error_functions']->error_page ("standard","account_username_exists","SERVICE ERROR:<br />&quot;$direct_cachedata[i_ausername]&quot; has already been registered<br />sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }
			elseif (strlen ($g_username_invalid_chars)) { $direct_classes['error_functions']->error_page ("standard","account_username_invalid","SERVICE ERROR:<br />Allowed characters are: 0-9, a-z, A-Z as well as !$%&amp;/(){}[]?@*~#,.-;_ and space<br />sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }
			elseif (preg_match ("#".(implode ("$|",$g_email_blacklist_array))."$#im",$direct_cachedata['i_aemail'])) { $direct_classes['error_functions']->error_page ("standard","account_email_blacklisted","SERVICE ERROR:<br />Blacklisted by the administration<br />sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }
			elseif ($direct_cachedata['i_atou'])
			{
				$g_vid = md5 (uniqid (""));
				$g_vid_timeout = ($direct_cachedata['core_time'] + $direct_settings['users_registration_time']);
				$g_secid = $direct_classes['basic_functions']->tmd5 ($g_vid."_{$g_vid_timeout}_{$direct_cachedata['i_ausername']}_{$direct_cachedata['i_aemail']}_".$direct_cachedata['i_apassword'],$direct_settings['account_secid_bytemix']);

$g_vid_array = array (
"core_vid_module" => "account_registration",
"account_username" => $direct_cachedata['i_ausername'],
"account_email" => $direct_cachedata['i_aemail'],
"account_password" => $direct_cachedata['i_apassword'],
"account_secid" => $g_secid
);

				if (direct_mods_include ($direct_settings['account_registration_mods_support'],"account_registration","test")) { $g_vid_array = direct_mods_include (true,"account_registration","form_save",$g_vid_array); }
				$direct_cachedata['i_ausername'] = addslashes ($direct_cachedata['i_ausername']);

				if (isset ($g_vid_array['account_username']))
				{
					if (direct_tmp_storage_write ($g_vid_array,$g_vid,"a617908b172c473cb8e8cda059e55bf0","registration","evars",0,$g_vid_timeout))
					// md5 ("validation")
					{
						if (isset ($direct_settings['swg_redirect_url'])) { $g_redirect_url = $direct_settings['swg_redirect_url']; }
						else { $g_redirect_url = $direct_settings['home_url']."/swg_redirect.php"; }

						$g_sendmailer_object = new direct_sendmailer_formtags ();
						$g_sendmailer_object->recipients_define (array ($direct_cachedata['i_aemail'] => $direct_cachedata['i_ausername']));

$g_message = ("[contentform:highlight]".(direct_local_get ("core_message_by_request","text"))."

[font:bold]".(direct_local_get ("core_message_to","text")).":[/font] $direct_cachedata[i_ausername] ($direct_cachedata[i_aemail])[/contentform]
".(direct_local_get ("core_validation_required","text"))."

".(direct_local_get ("account_validation_for_registration","text"))."

[url]$g_redirect_url?validation;{$g_vid}[/url]

".(direct_local_get ("core_one_line_link","text"))."

[hr]
".(direct_local_get ("account_secid_howto","text"))."

".(direct_local_get ("account_secid","text")).":
".(wordwrap ($g_secid,32,"\n",1))."

[hr]
(C) $direct_settings[swg_title_txt] ([url]{$direct_settings['home_url']}[/url])
All rights reserved");

						$g_sendmailer_object->message_set ($g_message);
						$g_sendmailer_object->send ("single",$direct_settings['administration_email_out'],$direct_settings['swg_title_txt']." - ".(direct_local_get ("account_title_registration","text")));

						$direct_cachedata['output_job'] = direct_local_get ("core_registration");
						$direct_cachedata['output_job_desc'] = direct_local_get ("account_done_register");
						$direct_cachedata['output_jsjump'] = 0;

						if ($g_target_url)
						{
							$direct_cachedata['output_pagetarget'] = str_replace ("[oid]","",$g_target_url);
							$direct_cachedata['output_pagetarget'] = str_replace ('"',"",(direct_linker ("url0",$direct_cachedata['output_pagetarget'])));
						}

						direct_output_related_manager ("account_registration_form_save","post_module_service_action");
						$direct_classes['output']->oset ("default","done");
						$direct_classes['output']->options_flush (true);
						$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
						$direct_classes['output']->page_show ($direct_cachedata['output_job']);
					}
					else { $direct_classes['error_functions']->error_page ("fatal","core_database_error","FATAL ERROR:<br />tmpStorager has reported an error<br />sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }
				}
				else { $direct_classes['error_functions']->error_page ("standard","core_unknown_error","FATAL ERROR:<br />tmpStorager has reported an error<br />sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }
			}
			else { $direct_classes['error_functions']->error_page ("standard","account_tou_required","sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }
		}
		else
		{
			$direct_cachedata['output_credits_information'] = direct_credits_payment_info ($direct_settings['users_registration_credits_onetime'],$direct_settings['users_registration_credits_periodically']);
			$direct_cachedata['output_credits_payment_data'] = "";

			$direct_cachedata['output_formbutton'] = direct_local_get ("core_continue");
			$direct_cachedata['output_formtarget'] = "m=account&s=registration&a=form-save&dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
			$direct_cachedata['output_formtitle'] = direct_local_get ("core_registration");

			direct_output_related_manager ("account_registration_form","post_module_service_action");
			$direct_classes['output']->oset ("default","form");
			$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_classes['output']->page_show ($direct_cachedata['output_formtitle']);
		}
	}
	else { $direct_classes['output']->redirect (direct_linker ("url1",$direct_cachedata['page_backlink'],false)); }
	//j// EOA
	}
	else { $direct_classes['error_functions']->error_page ("standard","core_service_inactive","sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>