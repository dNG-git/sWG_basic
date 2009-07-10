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
* dataport/swgap/account/swg_selector.php
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

if (!isset ($direct_settings['account_https_selector'])) { $direct_settings['account_https_selector'] = false; }
if (!isset ($direct_settings['account_selector_users_per_page'])) { $direct_settings['account_selector_users_per_page'] = 40; }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGbasicVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "list"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "list"
case "list":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=list_ (#echo(__LINE__)#)"); }

	$direct_cachedata['output_tid'] = (isset ($direct_settings['dsd']['tid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['tid'])) : "");
	$direct_cachedata['output_page'] = (isset ($direct_settings['dsd']['page']) ? ($direct_classes['basic_functions']->inputfilter_number ($direct_settings['dsd']['page'])) : 1);

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

		$direct_cachedata['page_this'] = "m=dataport&s=swgap;account;selector&a=list&dsd=dtheme+{$direct_cachedata['output_dtheme_mode']}++tid+{$direct_cachedata['output_tid']}++page+".$direct_cachedata['output_page'];
		$direct_cachedata['page_backlink'] = "";
		$direct_cachedata['page_homelink'] = "";

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
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_formtags.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php"); }

	if ($g_continue_check)
	{
	//j// BOA
	$g_task_array = direct_tmp_storage_get ("evars",$direct_cachedata['output_tid'],"","task_cache");

	if (($g_task_array)&&(isset ($g_task_array['core_sid']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$g_task_array['uuid']))&&(!$g_task_array['account_selection_done'])&&($g_task_array['uuid'] == $direct_settings['uuid']))
	{
		if ($g_dtheme_embedded) { direct_output_related_manager ("account_selector_list","pre_module_service_action_embedded"); }
		elseif ($g_dtheme) { direct_output_related_manager ("account_selector_list","pre_module_service_action"); }
		else { direct_output_related_manager ("account_selector_list","pre_module_service_action_ajax"); }

		$direct_cachedata['page_backlink'] = str_replace ("[oid]","",$g_task_array['core_back_return']);
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'];

		if (!is_array ($g_task_array['account_users_marked'])) { $g_task_array['account_users_marked'] = array (); }
		if (!isset ($g_task_array['core_filter_account_selector'])) { $g_task_array['core_filter_account_selector'] = ""; }
	}
	else { $g_continue_check = false; }

	if ($g_dtheme) { $direct_classes['kernel']->service_https ($direct_settings['account_https_selector'],$direct_cachedata['page_this']); }
	if ($g_dtheme_embedded) { direct_output_theme_subtype ("embedded"); }
	direct_local_integration ("account");

	direct_class_init ("output");
	if (($g_dtheme)&&($direct_cachedata['page_backlink'])) { $direct_classes['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0"); }

	if ($g_continue_check)
	{
		direct_class_init ("formtags");

		$direct_cachedata['output_filter_source'] = base64_encode ("m=dataport&s=swgap;account;selector&a=list&dsd=dtheme+{$direct_cachedata['output_dtheme_mode']}++tid+{$direct_cachedata['output_tid']}++page+".$direct_cachedata['output_page']);

		if (isset ($g_task_array['core_filter_account_selector'])) { $direct_cachedata['output_filter_text'] = $direct_classes['formtags']->decode ($g_task_array['core_filter_account_selector']); }
		else { $direct_cachedata['output_filter_text'] = ""; }

		$direct_classes['db']->init_select ($direct_settings['users_table']);

		$g_select_attributes = array ("count-rows(ddbusers_id)");
		$direct_classes['db']->define_attributes ($g_select_attributes);

		if ($g_task_array['core_filter_account_selector'])
		{
$g_select_criteria = ("<sqlconditions searchtype='simple'>
<attribute value='ddbusers_name' />
".($direct_classes['db']->define_search_conditions_term ($g_task_array['core_filter_account_selector']))."
</sqlconditions>");

			$direct_classes['db']->define_search_conditions ($g_select_criteria);
		}

		$g_select_criteria = "<sqlconditions><element1 attribute='ddbusers_deleted' value='0' type='string' /></sqlconditions>";

		$direct_classes['db']->define_row_conditions ($g_select_criteria);
		$g_users_count = $direct_classes['db']->query_exec ("ss");

		if ((!$direct_cachedata['output_page'])||($direct_cachedata['output_page'] < 1)) { $direct_cachedata['output_page'] = 1; }
		$direct_cachedata['output_pages'] = ceil ($g_users_count / $direct_settings['account_selector_users_per_page']);
		if ($direct_cachedata['output_pages'] < 1) { $direct_cachedata['output_pages'] = 1; }
		if ($direct_cachedata['output_page'] > $direct_cachedata['output_pages']) { $direct_cachedata['output_page'] = $direct_cachedata['output_pages']; }

		$direct_classes['db']->init_select ($direct_settings['users_table']);

		$g_select_attributes = array ("ddbusers_id","ddbusers_name","ddbusers_password","ddbusers_email","ddbusers_registration_ip","ddbusers_registration_time","ddbusers_secid");
		$direct_classes['db']->define_attributes ($g_select_attributes);

		if ($g_task_array['core_filter_account_selector'])
		{
$g_select_criteria = ("<sqlconditions searchtype='simple'>
<attribute value='ddbusers_name' />
".($direct_classes['db']->define_search_conditions_term ($g_task_array['core_filter_account_selector']))."
</sqlconditions>");

			$direct_classes['db']->define_search_conditions ($g_select_criteria);
		}

		$g_select_criteria = "<sqlconditions><element1 attribute='ddbusers_deleted' value='0' type='string' /></sqlconditions>";
		$direct_classes['db']->define_row_conditions ($g_select_criteria);

		$g_select_criteria = "<sqlordering><element1 attribute='ddbusers_name' type='asc' /></sqlordering>";
		$direct_classes['db']->define_ordering ($g_select_criteria);

		$direct_classes['db']->define_limit ($direct_settings['account_selector_users_per_page']);

		$g_select_criteria = (($direct_cachedata['output_page'] - 1) * $direct_settings['account_selector_users_per_page']);
		$direct_classes['db']->define_offset ($g_select_criteria);

		$g_users_array = $direct_classes['db']->query_exec ("ma");
		$direct_cachedata['output_users_list'] = array ();

		if ((is_array ($g_users_array))&&(!empty ($g_users_array)))
		{
			foreach ($g_users_array as $g_user_array)
			{
				$g_user_parsed = $direct_classes['kernel']->v_user_parse ("",$g_user_array);

				if (in_array ($g_user_array['ddbusers_id'],$g_task_array['account_users_marked']))
				{
					$g_user_parsed['marked'] = true;

					if (isset ($g_task_array['account_marker_title_1'])) { $g_user_parsed['marker_title'] = $g_task_array['account_marker_title_1']; }
					else { $g_user_parsed['marker_title'] = direct_local_get ("account_user_selector_unmark"); }
				}
				else
				{
					$g_user_parsed['marked'] = false;

					if (isset ($g_task_array['account_marker_title_0'])) { $g_user_parsed['marker_title'] = $g_task_array['account_marker_title_0']; }
					else { $g_user_parsed['marker_title'] = direct_local_get ("account_user_selector_mark"); }
				}

				if ($g_dtheme) { $g_user_parsed['marker_url'] = direct_linker ("url0","m=dataport&s=swgap;account;selector&a=mark_switch&dsd=dtheme+{$direct_cachedata['output_dtheme_mode']}++tid+{$direct_cachedata['output_tid']}++auid+{$g_user_array['ddbusers_id']}++page+".$direct_cachedata['output_page']); }
				else { $g_user_parsed['marker_url'] = direct_linker ("asis","javascript:djs_dataport_{$direct_cachedata['output_tid']}_call_url0('m=dataport&amp;s=swgap;account;selector&amp;a=mark_switch&amp;dsd=dtheme+0++tid+{$direct_cachedata['output_tid']}++auid+{$g_user_array['ddbusers_id']}++page+{$direct_cachedata['output_page']}')"); }

				$direct_cachedata['output_users_list'][] = $g_user_parsed;
			}
		}

		if ((isset ($g_task_array['account_selection_title']))&&($g_task_array['account_selection_title'])) { $direct_cachedata['output_selection_title'] = $g_task_array['account_selection_title']; }
		else { $direct_cachedata['output_selection_title'] = direct_local_get ("account_user_selector"); }

		if ($g_dtheme)
		{
			if ($g_dtheme_embedded)
			{
				direct_output_related_manager ("account_selector_list","post_module_service_action_embedded");
				$direct_cachedata['output_page_url'] = "m=dataport&s=swgap;account;selector&a=list&dsd=dtheme+2++tid+{$direct_cachedata['output_tid']}++";
				$direct_classes['output']->oset ("account_embedded","selector");
			}
			else
			{
				direct_output_related_manager ("account_selector_list","post_module_service_action");
				$direct_cachedata['output_page_url'] = "m=dataport&s=swgap;account;selector&a=list&dsd=dtheme+1++tid+{$direct_cachedata['output_tid']}++";
				$direct_classes['output']->oset ("account","selector");
			}

			$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_classes['output']->page_show ($direct_cachedata['output_selection_title']);
		}
		else
		{
			$direct_cachedata['output_page_url'] = "javascript:djs_dataport_{$direct_cachedata['output_tid']}_call_url0('m=dataport&amp;s=swgap;account;selector&amp;a=list&amp;dsd=dtheme+0++tid+{$direct_cachedata['output_tid']}++page+[page]')";

			$direct_classes['output']->header (false);
			header ("Content-type: text/xml; charset=".$direct_local['lang_charset']);

echo ("<?xml version='1.0' encoding='$direct_local[lang_charset]' ?>
".(direct_output_smiley_decode ($direct_classes['output']->oset_content ("account_embedded","ajax_selector"))));
		}
	}
	elseif ($g_dtheme) { $direct_classes['error_functions']->error_page ("standard","core_tid_invalid","sWG/#echo(__FILEPATH__)# _a=list_ (#echo(__LINE__)#)"); }
	//j// BOA
	}

	$direct_cachedata['core_service_activated'] = 1;
	break 1;
}
//j// $direct_settings['a'] == "mark_switch"
case "mark_switch":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=mark_switch_ (#echo(__LINE__)#)"); }

	$g_uid = (isset ($direct_settings['dsd']['auid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['auid'])) : "");
	$g_tid = (isset ($direct_settings['dsd']['tid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['tid'])) : "");
	$g_page = (isset ($direct_settings['dsd']['page']) ? ($direct_classes['basic_functions']->inputfilter_number ($direct_settings['dsd']['page'])) : 1);

	if ((isset ($direct_settings['dsd']['dtheme']))&&($direct_settings['dsd']['dtheme']))
	{
		$g_dtheme = true;

		if ($direct_settings['dsd']['dtheme'] == 2)
		{
			$g_dtheme_embedded = true;
			$g_dtheme_mode = 2;
		}
		else
		{
			$g_dtheme_embedded = false;
			$g_dtheme_mode = 1;
		}

		$direct_cachedata['page_this'] = "";
		$direct_cachedata['page_backlink'] = "";
		$direct_cachedata['page_homelink'] = "";

		$g_continue_check = $direct_classes['kernel']->service_init_default ();
	}
	else
	{
		$g_dtheme = false;
		$g_dtheme_embedded = false;
		$g_dtheme_mode = 0;

		$g_continue_check = $direct_classes['kernel']->service_init_rboolean ();
	}

	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->settings_get ($direct_settings['path_data']."/settings/swg_account.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php"); }

	if ($g_continue_check)
	{
	//j// BOA
	$g_task_array = direct_tmp_storage_get ("evars",$g_tid,"","task_cache");

	if (($g_task_array)&&(isset ($g_task_array['core_sid']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$g_task_array['uuid']))&&(!$g_task_array['account_selection_done'])&&($g_task_array['uuid'] == $direct_settings['uuid']))
	{
		if ($g_dtheme_embedded) { direct_output_related_manager ("account_selector_list","pre_module_service_action_embedded"); }
		elseif ($g_dtheme) { direct_output_related_manager ("account_selector_list","pre_module_service_action"); }
		else { direct_output_related_manager ("account_selector_list","pre_module_service_action_ajax"); }

		$direct_cachedata['page_backlink'] = "m=dataport&s=swgap;account;selector&a=list&dsd=dtheme+{$g_dtheme_mode}++tid+{$g_tid}++page+".$g_page;
		$direct_cachedata['page_homelink'] = str_replace ("[oid]","",$g_task_array['core_back_return']);

		if (!is_array ($g_task_array['account_users_marked'])) { $g_task_array['account_users_marked'] = array (); }
	}
	else { $g_continue_check = false; }

	if ($g_dtheme_embedded) { direct_output_theme_subtype ("embedded"); }
	direct_local_integration ("account");

	direct_class_init ("output");
	if (($g_dtheme)&&($direct_cachedata['page_backlink'])) { $direct_classes['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0"); }

	if ($g_continue_check)
	{
		if ($direct_classes['kernel']->v_user_check ($g_uid,"",true))
		{
			if (in_array ($g_uid,$g_task_array['account_users_marked'])) { unset ($g_task_array['account_users_marked'][$g_uid]); }
			else
			{
				if ($g_task_array['account_selection_quantity'] > count ($g_task_array['account_users_marked'])) { $g_task_array['account_users_marked'][$g_uid] = $g_uid; }
				else
				{
					array_shift ($g_task_array['account_users_marked']);
					$g_task_array['account_users_marked'][$g_uid] = $g_uid;
				}
			}

			if ($g_task_array['account_marker_return']) { $g_task_array['datacenter_selection_done'] = 1; }
			direct_tmp_storage_write ($g_task_array,$g_tid,$g_task_array['core_sid'],"task_cache","evars",$direct_cachedata['core_time'],($direct_cachedata['core_time'] + 3600));

			if ((isset ($g_task_array['account_marker_return']))&&($g_task_array['account_marker_return']))
			{
				$g_back_link = str_replace ("[oid]","auid_d+$g_uid++",$g_task_array['account_marker_return']);
				$direct_classes['output']->redirect (direct_linker ("url1",$g_back_link,false));
			}
			else { $direct_classes['output']->redirect (direct_linker ("url1","m=dataport&s=swgap;account;selector&a=list&dsd=dtheme+{$g_dtheme_mode}++tid+{$g_tid}++page+{$g_page}#swgdhandleruser".$g_uid,false)); }
		}
		elseif ($g_dtheme) { $direct_classes['error_functions']->error_page ("standard","core_username_unknown","sWG/#echo(__FILEPATH__)# _a=mark_switch_ (#echo(__LINE__)#)"); }
	}
	elseif ($g_dtheme) { $direct_classes['error_functions']->error_page ("standard","core_tid_invalid","sWG/#echo(__FILEPATH__)# _a=mark_switch_ (#echo(__LINE__)#)"); }
	//j// BOA
	}

	$direct_cachedata['core_service_activated'] = 1;
	break 1;
}
//j// EOS
}

//j// EOF
?>