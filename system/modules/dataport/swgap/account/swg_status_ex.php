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
* dataport/swgap/account/swg_status_ex.php
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

if (!isset ($direct_settings['account_https_login'])) { $direct_settings['account_https_login'] = false; }
if (!isset ($direct_settings['account_status_ex_type_preselected'])) { $direct_settings['account_status_ex_type_preselected'] = ""; }
if (!isset ($direct_settings['account_status_ex_types_supported'])) { $direct_settings['account_status_ex_types_supported'] = array ("email"); }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGbasicVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "status"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// ($direct_settings['a'] == "login")||($direct_settings['a'] == "login-save")
case "login":
case "login-save":
{
	$g_mode_save = (($direct_settings['a'] == "login-save") ? true : false);
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }

	$g_aex_form_type = (isset ($GLOBALS['i_aex_type']) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS['i_aex_type'])) : "");
	$g_ex_type = (isset ($direct_settings['dsd']['aex_type']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['aex_type'])) : $g_aex_form_type);
	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['source'])) : "");
	$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['target'])) : "");

	$g_source_url = ($g_source ? base64_decode ($g_source) : "");

	if ($g_target) { $g_target_url = base64_decode ($g_target); }
	else
	{
		$g_target = $g_source;
		$g_target_url = $g_source_url;
	}

	if ((isset ($direct_settings['dsd']['dtheme']))&&($direct_settings['dsd']['dtheme']))
	{
		$g_dtheme = true;

		if ($direct_settings['dsd']['dtheme'] == 2)
		{
			$g_dtheme_mode = 2;
			$g_dtheme_embedded = true;
		}
		else
		{
			$g_dtheme_mode = 1;
			$g_dtheme_embedded = false;
		}

		if ($g_mode_save)
		{
			$direct_cachedata['page_this'] = "";
			$direct_cachedata['page_backlink'] = "m=dataport&s=swgap;account;status_ex&a=login&dsd=dtheme+{$g_dtheme_mode}++aex_type+{$g_ex_type}++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
			$direct_cachedata['page_homelink'] = "m=dataport&s=swgap;account;status_ex&a=login-mode&dsd=dtheme+{$g_dtheme_mode}++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		}
		else
		{
			$direct_cachedata['page_this'] = "m=dataport&s=swgap;account;status_ex&a=login&dsd=dtheme+{$g_dtheme_mode}++aex_type+{$g_ex_type}++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
			$direct_cachedata['page_backlink'] = "m=dataport&s=swgap;account;status_ex&a=login-mode&dsd=dtheme+{$g_dtheme_mode}++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
			$direct_cachedata['page_homelink'] = str_replace ("[oid]","",$g_source_url);
		}

		$g_continue_check = $direct_classes['kernel']->service_init_default ();
	}
	else
	{
		$g_dtheme_mode = 0;
		$g_dtheme = false;
		$g_dtheme_embedded = false;

		$g_continue_check = $direct_classes['kernel']->service_init_rboolean ();
	}

	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->settings_get ($direct_settings['path_data']."/settings/swg_account.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_formbuilder.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_mods_support.php"); }
	if (($g_continue_check)&&($g_mode_save)) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_log_storager.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php"); }
	if (is_string ($direct_settings['account_status_ex_types_supported'])) { $direct_settings['account_status_ex_types_supported'] = array ($direct_settings['account_status_ex_types_supported']); }

	if ($g_continue_check)
	{
	if (in_array ($g_ex_type,$direct_settings['account_status_ex_types_supported']))
	{
	//j// BOA
	$g_related_page = ($g_mode_save ? "account_status_ex_login_form_save" : "account_status_ex_login_form");

	if ($g_dtheme_embedded) { direct_output_related_manager ($g_related_page,"pre_module_service_action_embedded"); }
	elseif ($g_dtheme) { direct_output_related_manager ($g_related_page,"pre_module_service_action"); }
	else { direct_output_related_manager ($g_related_page,"pre_module_service_action_ajax"); }

	if ($g_dtheme) { $direct_classes['kernel']->service_https ($direct_settings['account_https_login'],$direct_cachedata['page_this']); }
	if ($g_dtheme_embedded) { direct_output_theme_subtype ("embedded"); }
	direct_local_integration ("account");

	direct_class_init ("formbuilder");
	direct_class_init ("output");
	if (($g_dtheme)&&($direct_cachedata['page_backlink'])) { $direct_classes['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0"); }

	if ($g_mode_save)
	{
/* -------------------------------------------------------------------------
We should have input in save mode
------------------------------------------------------------------------- */

		$direct_cachedata['i_ausername'] = (isset ($GLOBALS['i_ausername']) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS['i_ausername'])) : "");

		if (USE_cookies)
		{
			$direct_cachedata['i_acookie'] = (isset ($GLOBALS['i_acookie']) ? (str_replace ("'","",$GLOBALS['i_acookie'])) : "");
			$direct_cachedata['i_acookie'] = str_replace ("<value value='$direct_cachedata[i_acookie]' />","<value value='$direct_cachedata[i_acookie]' /><selected value='1' />","<evars><no><value value='0' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes></evars>");
		}
	}
	else
	{
		$direct_cachedata['i_ausername'] = "";
		if (USE_cookies) { $direct_cachedata['i_acookie'] = "<evars><no><value value='0' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no><yes><value value='1' /><selected value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes></evars>"; }
	}

/* -------------------------------------------------------------------------
Build the form
------------------------------------------------------------------------- */

	$direct_classes['formbuilder']->entry_add_text ("ausername",(direct_local_get ("core_username")),true,"l",$direct_settings['users_min'],100,((direct_local_get ("core_helper_username_1")).$direct_settings['users_min'].(direct_local_get ("core_helper_username_2"))),"",true);
	if (USE_cookies) { $direct_classes['formbuilder']->entry_add_radio ("acookie",(direct_local_get ("account_use_cookie")),true); }
	$direct_classes['formbuilder']->entry_add ("spacer");

/* -------------------------------------------------------------------------
Call registered mods
------------------------------------------------------------------------- */

	if ($g_mode_save)
	{
		$g_continue_check = direct_mods_include (true,"account_status_ex","login_check",$g_ex_type);
		$direct_cachedata['output_formelements'] = $direct_classes['formbuilder']->form_get (true);
	}
	else
	{
		direct_mods_include (true,"account_status_ex","login",$g_ex_type);
		$direct_cachedata['output_formelements'] = $direct_classes['formbuilder']->form_get (false);
	}

	if (($g_mode_save)&&(($direct_classes['formbuilder']->check_result)||($g_continue_check)))
	{
/* -------------------------------------------------------------------------
Save data edited
------------------------------------------------------------------------- */

		$g_cookie = (((USE_cookies)&&($direct_cachedata['i_acookie'])) ? true : false);
		$g_form_view = false;
		$g_user_array = $direct_classes['kernel']->v_user_get ("",$direct_cachedata['i_ausername'],true);

		if (direct_mods_include (true,"account_status_ex","test"))
		{
			$g_login_check = direct_mods_include (true,"account_status_ex","login_process",$g_ex_type,$g_user_array);
			if ($g_login_check > 0) { $g_user_array = $direct_classes['kernel']->v_user_get ("",$direct_cachedata['i_ausername'],true); }
		}
		else { $g_login_check = -1; }

		if ($g_login_check > 0)
		{
			if ($g_user_array['ddbusers_banned']) { $direct_classes['error_functions']->error_page ("standard","account_username_banned","SECURITY ERROR:<br />&quot;$direct_cachedata[i_ausername]&quot; has been banned<br />sWG/#echo(__FILEPATH__)# _a=login-save_ (#echo(__LINE__)#)"); }
			elseif ($g_user_array['ddbusers_deleted']) { $direct_classes['error_functions']->error_page ("standard","core_username_unknown","SECURITY ERROR:<br />&quot;$direct_cachedata[i_ausername]&quot; was deleted<br />sWG/#echo(__FILEPATH__)# _a=login-save_ (#echo(__LINE__)#)"); }
			elseif ($g_user_array['ddbusers_locked']) { $direct_classes['error_functions']->error_page ("standard","account_username_locked","SECURITY ERROR:<br />&quot;$direct_cachedata[i_ausername]&quot; has been locked by the administration or the system<br />sWG/#echo(__FILEPATH__)# _a=login-save_ (#echo(__LINE__)#)"); }
			else
			{
$g_uuid_array = array (
"userid" => $g_user_array['ddbusers_id'],
"username" => $g_user_array['ddbusers_name']
);

				if (direct_mods_include (true,"account_status_ex","test")) { $g_uuid_array = direct_mods_include (true,"account_status_ex","login_save",$g_ex_type,$g_user_array,$g_uuid_array); }

				if (isset ($g_uuid_array['userid']))
				{
					$direct_classes['kernel']->v_uuid_write ((direct_evars_write ($g_uuid_array)),$g_cookie);

/* -------------------------------------------------------------------------
Hardcoding the user type should prevent successful attacks against the log
in infrastructure.
------------------------------------------------------------------------- */

					$direct_settings['user'] = array ("id" => $g_user_array['ddbusers_id'],"name" => $g_user_array['ddbusers_name'],"name_html" => (direct_html_encode_special ($g_user_array['ddbusers_name'])),"type" => "ex","timezone" => $g_user_array['ddbusers_timezone']);
					if (direct_class_function_check ($direct_classes['kernel'],"v_group_user_get_rights")) { $direct_classes['kernel']->v_group_user_get_rights (); }
					$direct_classes['kernel']->v_uuid_cookie_save ();

					$g_lang = $g_user_array['ddbusers_lang'];
					$g_theme = $g_user_array['ddbusers_theme'];

$g_log_array = array (
"source_user_id" => $g_user_array['ddbusers_id'],
"source_user_ip" => $direct_settings['user_ip'],
"sid" => "e268443e43d93dab7ebef303bbe9642f",
// md5 ("account")
"identifier" => "account_login"
);

					direct_log_write ($g_log_array);

					$direct_cachedata['output_job'] = direct_local_get ("account_status_ex");
					$direct_cachedata['output_job_desc'] = direct_local_get ("account_done_login");

					if ($g_target_url)
					{
						$g_target_link = str_replace (array ("[oid]","[lang]","[theme]"),(array ("auid_d+{$g_user_array['ddbusers_id']}++","&lang=".$g_lang,"&theme=".$g_theme)),$g_target_url);

						$direct_cachedata['output_jsjump'] = 2000;
						$direct_cachedata['output_pagetarget'] = str_replace ('"',"",(direct_linker ("url0",$g_target_link)));
						$direct_cachedata['output_scripttarget'] = str_replace ('"',"",(direct_linker ("url0",$g_target_link,false)));
					}
					else { $direct_cachedata['output_jsjump'] = 0; }

					direct_output_related_manager ("account_status_login_form_save","post_module_service_action");
					$direct_classes['output']->oset ("default","done");
					$direct_classes['output']->options_flush (true);
					$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
					$direct_classes['output']->page_show ($direct_cachedata['output_job']);
				}
				else { $direct_classes['error_functions']->error_page ("standard","core_unknown_error","sWG/#echo(__FILEPATH__)# _a=login-save_ (#echo(__LINE__)#)"); }
			}
		}
		elseif ($g_login_check < 0) { $g_form_view = true; }
	}
	else { $g_form_view = true; }

	if ($g_form_view)
	{
/* -------------------------------------------------------------------------
View form
------------------------------------------------------------------------- */

		$direct_cachedata['output_formbutton'] = direct_local_get ("core_login");
		$direct_cachedata['output_formtarget'] = "m=dataport&s=swgap;account;status_ex&a=login-save&dsd=dtheme+{$g_dtheme_mode}++aex_type+{$g_ex_type}++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['output_formtitle'] = direct_local_get ("account_status_ex");

		if ($g_dtheme)
		{
			if ($g_dtheme_embedded)
			{
				direct_output_related_manager ("account_status_ex_login_mode","post_module_service_action_embedded");
				$direct_classes['output']->oset ("default_embedded","form");
			}
			else
			{
				direct_output_related_manager ("account_status_ex_login_mode","post_module_service_action");
				$direct_classes['output']->oset ("default","form");
			}

			$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_classes['output']->page_show ($direct_cachedata['output_formtitle']);
		}
		else
		{
			$direct_classes['output']->header (false);
			header ("Content-type: text/xml; charset=".$direct_local['lang_charset']);

echo ("<?xml version='1.0' encoding='$direct_local[lang_charset]' ?>
".(direct_output_smiley_decode ($direct_classes['output']->oset_content ("default_embedded","ajax_form"))));
		}
	}
	//j// BOA
	}
	elseif ($g_dtheme) { $direct_classes['error_functions']->error_page ("standard","core_service_inactive","sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }
	}

	$direct_cachedata['core_service_activated'] = 1;
	break 1;
}
//j// $direct_settings['a'] == "login-mode"
case "login-mode":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=login-mode_ (#echo(__LINE__)#)"); }

	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['source'])) : "");
	$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['target'])) : "");

	$g_source_url = ($g_source ? base64_decode ($g_source) : "");

	if ($g_target) { $g_target_url = base64_decode ($g_target); }
	else
	{
		$g_target = $g_source;
		$g_target_url = $g_source_url;
	}

	if ((isset ($direct_settings['dsd']['dtheme']))&&($direct_settings['dsd']['dtheme']))
	{
		$g_dtheme = true;

		if ($direct_settings['dsd']['dtheme'] == 2)
		{
			$g_dtheme_mode = 2;
			$g_dtheme_embedded = true;
		}
		else
		{
			$g_dtheme_mode = 1;
			$g_dtheme_embedded = false;
		}

		$g_back_link = ($g_source_url ? str_replace ("[oid]","",$g_source_url) : "");

		$direct_cachedata['page_this'] = "m=dataport&s=swgap;account;status_ex&a=login-mode&dsd=dtheme+{$g_dtheme_mode}++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_backlink'] = $g_back_link;
		$direct_cachedata['page_homelink'] = $g_back_link;

		$g_continue_check = $direct_classes['kernel']->service_init_default ();
	}
	else
	{
		$g_dtheme_mode = 0;
		$g_dtheme = false;
		$g_dtheme_embedded = false;

		$g_continue_check = $direct_classes['kernel']->service_init_rboolean ();
	}

	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->settings_get ($direct_settings['path_data']."/settings/swg_account.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_formbuilder.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php"); }
	if (is_string ($direct_settings['account_status_ex_types_supported'])) { $direct_settings['account_status_ex_types_supported'] = array ($direct_settings['account_status_ex_types_supported']); }

	if ($g_continue_check)
	{
	if (!empty ($direct_settings['account_status_ex_types_supported']))
	{
	//j// BOA
	if ($g_dtheme_embedded) { direct_output_related_manager ("account_status_ex_login_mode","pre_module_service_action_embedded"); }
	elseif ($g_dtheme) { direct_output_related_manager ("account_status_ex_login_mode","pre_module_service_action"); }
	else { direct_output_related_manager ("account_status_ex_login_mode","pre_module_service_action_ajax"); }

	if ($g_dtheme) { $direct_classes['kernel']->service_https ($direct_settings['account_https_login'],$direct_cachedata['page_this']); }
	if ($g_dtheme_embedded) { direct_output_theme_subtype ("embedded"); }
	direct_local_integration ("account");

	direct_class_init ("formbuilder");
	direct_class_init ("output");

	$g_type_preselected = (((strlen ($direct_settings['account_status_ex_type_preselected']))&&(in_array ($direct_settings['account_status_ex_type_preselected'],$direct_settings['account_status_ex_types_supported']))) ? $direct_settings['account_status_ex_type_preselected'] : $direct_settings['account_status_ex_types_supported'][0]);

	if ($direct_settings['user']['type'] == "ex")
	{
		$g_uuid_storage_array = direct_tmp_storage_get ("evars",$direct_settings['uuid'],"","task_cache");
		if (($g_uuid_storage_array)&&(isset ($g_uuid_storage_array['account_status_ex_type'],$g_uuid_storage_array['account_status_ex_verified']))) { $g_type_preselected = $g_uuid_storage_array['account_status_ex_type']; }
	}

	$direct_cachedata['i_aex_type'] = "<evars>";

	foreach ($direct_settings['account_status_ex_types_supported'] as $g_type_supported)
	{
		$g_type_name = direct_string_id_translation ("account_status_ex",$g_type_supported);

		$direct_cachedata['i_aex_type'] .= "<t$g_type_supported><value value='$g_type_supported' />";
		if ($g_type_preselected == $g_type_supported) { $direct_cachedata['i_aex_type'] .= "<selected value='1' />"; }
		$direct_cachedata['i_aex_type'] .= ($g_type_name ? "<text><![CDATA[$g_type_name]]></text>" : "<text><![CDATA[".(direct_local_get ("core_unknown"))." ($g_type_supported)]]></text>");
		$direct_cachedata['i_aex_type'] .= "</t$g_type_supported>";
	}

	$direct_cachedata['i_aex_type'] .= "</evars>";

	$direct_classes['formbuilder']->entry_add_radio ("aex_type",(direct_local_get ("account_status_ex_verification_type")),true);

	$direct_cachedata['output_formbutton'] = direct_local_get ("core_continue");
	$direct_cachedata['output_formelements'] = $direct_classes['formbuilder']->form_get ($g_mode_save);
	$direct_cachedata['output_formtarget'] = "m=dataport&s=swgap;account;status_ex&a=login&dsd=dtheme+{$g_dtheme_mode}++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
	$direct_cachedata['output_formtitle'] = direct_local_get ("account_status_ex");

	if ($g_dtheme)
	{
		if ($g_dtheme_embedded)
		{
			direct_output_related_manager ("account_status_ex_login_mode","post_module_service_action_embedded");
			$direct_classes['output']->oset ("default_embedded","form");
		}
		else
		{
			direct_output_related_manager ("account_status_ex_login_mode","post_module_service_action");
			$direct_classes['output']->oset ("default","form");
		}

		$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
		$direct_classes['output']->page_show ($direct_cachedata['output_formtitle']);
	}
	else
	{
		$direct_classes['output']->header (false);
		header ("Content-type: text/xml; charset=".$direct_local['lang_charset']);

echo ("<?xml version='1.0' encoding='$direct_local[lang_charset]' ?>
".(direct_output_smiley_decode ($direct_classes['output']->oset_content ("default_embedded","ajax_form"))));
	}
	//j// BOA
	}
	elseif ($g_dtheme) { $direct_classes['error_functions']->error_page ("standard","core_service_inactive","sWG/#echo(__FILEPATH__)# _a=login-mode_ (#echo(__LINE__)#)"); }
	}

	$direct_cachedata['core_service_activated'] = 1;
	break 1;
}
//j// $direct_settings['a'] == "status"
case "status":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=status_ (#echo(__LINE__)#)"); }

	$g_no_login = (isset ($direct_settings['dsd']['anologin']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['anologin'])) : 0);
	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['source'])) : "");
	$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['target'])) : "");

	$g_source_url = ($g_source ? base64_decode ($g_source) : "");

	if ($g_target) { $g_target_url = base64_decode ($g_target); }
	else
	{
		$g_target = $g_source;
		$g_target_url = $g_source_url;
	}

	if ((isset ($direct_settings['dsd']['dtheme']))&&($direct_settings['dsd']['dtheme']))
	{
		$g_dtheme = true;

		if ($direct_settings['dsd']['dtheme'] == 2)
		{
			$direct_cachedata['output_dtheme_mode'] = 2;
			$g_dtheme_embedded = true;
		}
		else
		{
			$direct_cachedata['output_dtheme_mode'] = 1;
			$g_dtheme_embedded = false;
		}

		$direct_cachedata['page_this'] = "m=dataport&s=swgap;account;status_ex&dsd=dtheme+{$direct_cachedata['output_dtheme_mode']}++anologin+{$g_no_login}++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));

		if ($g_source_url)
		{
			$direct_cachedata['page_backlink'] = str_replace ("[oid]","",$g_source_url);
			$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'];
		}
		else
		{
			$direct_cachedata['page_backlink'] = "";
			$direct_cachedata['page_homelink'] = "";
		}

		$g_continue_check = $direct_classes['kernel']->service_init_default ();
	}
	else
	{
		$direct_cachedata['output_dtheme_mode'] = 0;
		$g_dtheme = false;
		$g_dtheme_embedded = false;

		$g_continue_check = $direct_classes['kernel']->service_init_rboolean ();
	}

	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->settings_get ($direct_settings['path_data']."/settings/swg_account.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_string_translator.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php"); }

	if ($g_continue_check)
	{
	//j// BOA
	if ($g_dtheme_embedded) { direct_output_related_manager ("account_status_ex_status","pre_module_service_action_embedded"); }
	elseif ($g_dtheme) { direct_output_related_manager ("account_status_ex_status","pre_module_service_action"); }
	else { direct_output_related_manager ("account_status_ex_status","pre_module_service_action_ajax"); }

	if ($g_dtheme) { $direct_classes['kernel']->service_https ($direct_settings['account_https_login'],$direct_cachedata['page_this']); }
	if ($g_dtheme_embedded) { direct_output_theme_subtype ("embedded"); }
	direct_local_integration ("account");

	direct_class_init ("output");
	$g_guest_check = false;

	if ($direct_settings['user']['type'] == "gt")
	{
		$g_guest_check = true;
		$g_uuid_string = "<evars><userid /></evars>";
		$direct_classes['kernel']->v_uuid_write ($g_uuid_string);
		$direct_classes['kernel']->v_uuid_cookie_save ();
	}
	else
	{
		$direct_cachedata['output_current_user'] = $direct_settings['user']['name_html'];

		switch ($direct_settings['user']['type'])
		{
		case "ad":
		{
			$direct_cachedata['output_current_verification'] = direct_local_get ("core_usertype_administrator");
			$g_no_login = 1;
			break 1;
		}
		case "ex":
		{
			$g_uuid_storage_array = direct_tmp_storage_get ("evars",$direct_settings['uuid'],"","task_cache");

			if (($g_uuid_storage_array)&&(isset ($g_uuid_storage_array['account_status_ex_type'],$g_uuid_storage_array['account_status_ex_verified'])))
			{
				$g_type_name = direct_string_id_translation ("account_status_ex",$g_uuid_storage_array['account_status_ex_type']);
				$direct_cachedata['output_current_verification'] = ($g_type_name ? $g_type_name : (direct_local_get ("core_unknown"))." ($g_uuid_storage_array[account_status_ex_type])");
				$direct_cachedata['output_current_verification_status'] = ($g_uuid_storage_array['account_status_ex_verified'] ? direct_local_get ("account_status_ex_login_verified") : direct_local_get ("account_status_ex_login_unverified"));
			}
			else
			{
				$g_guest_check = true;
				$g_uuid_string = "<evars><userid /></evars>";
				$direct_classes['kernel']->v_uuid_write ($g_uuid_string);
				$direct_classes['kernel']->v_uuid_cookie_save ();
			}

			break 1;
		}
		case "ma":
		{
			$direct_cachedata['output_current_verification'] = direct_local_get ("core_usertype_main_moderator");
			$g_no_login = 1;
			break 1;
		}
		case "mo":
		{
			$direct_cachedata['output_current_verification'] = direct_local_get ("core_usertype_moderator");
			$g_no_login = 1;
			break 1;
		}
		case "sm":
		{
			$direct_cachedata['output_current_verification'] = direct_local_get ("core_usertype_member_special");
			$g_no_login = 1;
			break 1;
		}
		default:
		{
			$direct_cachedata['output_current_verification'] = direct_local_get ("core_usertype_member");
			$g_no_login = 1;
		}
		}
	}

	if ($g_guest_check)
	{
		$direct_cachedata['output_current_user'] = direct_local_get ("core_guest");
		$direct_cachedata['output_current_verification'] = direct_local_get ("core_unknown");
	}

	if ((!empty ($direct_settings['account_status_ex_types_supported']))&&(!$g_no_login)) { $direct_cachedata['output_link_login'] = ($g_dtheme ? direct_linker ("url0","m=dataport&s=swgap;account;status_ex&a=login-mode&dsd=dtheme+{$direct_cachedata['output_dtheme_mode']}++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target))) : direct_linker ("url0","m=dataport&s=swgap;account;status_ex&a=login-mode&dsd=dtheme+1")); }

	if ($g_dtheme)
	{
		if ($g_dtheme_embedded)
		{
			direct_output_related_manager ("account_status_ex_status","post_module_service_action_embedded");
			$direct_classes['output']->oset ("account_embedded","status_ex");
		}
		else
		{
			direct_output_related_manager ("account_status_ex_status","post_module_service_action");
			$direct_classes['output']->oset ("account","status_ex");
		}

		$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
		$direct_classes['output']->page_show (direct_local_get ("account_status_ex"));
	}
	else
	{
		$direct_classes['output']->header (false);
		header ("Content-type: text/xml; charset=".$direct_local['lang_charset']);

echo ("<?xml version='1.0' encoding='$direct_local[lang_charset]' ?>
".(direct_output_smiley_decode ($direct_classes['output']->oset_content ("account_embedded","ajax_status_ex"))));
	}
	//j// BOA
	}

	$direct_cachedata['core_service_activated'] = 1;
	break 1;
}
//j// EOS
}

//j// EOF
?>