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
* dataport/swgap/default/swg_filter.php
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
* @subpackage default
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

if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGbasicVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "filter"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "filter"
case "filter":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=filter_ (#echo(__LINE__)#)"); }

	$g_fid = (isset ($direct_settings['dsd']['dfid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['dfid'])) : "");
	$g_ftext = (isset ($direct_settings['dsd']['dftext']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['dftext'])) : "");
	$g_tid = (isset ($direct_settings['dsd']['tid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['tid'])) : "");
	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['source'])) : "");
	$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['target'])) : "");

	if ($g_source) { $g_source_url = base64_decode ($g_source); }

	if ($g_target) { $g_target_url = base64_decode ($g_target); }
	else
	{
		$g_target = $g_source;
		$g_target_url = $g_source_url;
	}

	if ((isset ($direct_settings['dsd']['dtheme']))&&($direct_settings['dsd']['dtheme']))
	{
		$g_dtheme = true;

		if ($direct_settings['dsd']['dtheme'] == 2) { $g_dtheme_embedded = true; }
		else { $g_dtheme_embedded = false; }

		$direct_cachedata['page_this'] = "";
		$direct_cachedata['page_backlink'] = "";
		$direct_cachedata['page_homelink'] = "";

		$g_continue_check = $direct_classes['kernel']->service_init_default ();
	}
	else
	{
		$g_dtheme = false;
		$g_dtheme_embedded = false;

		$g_continue_check = $direct_classes['kernel']->service_init_rboolean ();
	}

	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php"); }

	if ($g_continue_check)
	{
	//j// BOA
	if ($g_tid == "") { $g_tid = $direct_settings['uuid']; }
	$g_task_array = direct_tmp_storage_get ("evars",$g_tid,"","task_cache");

	if (isset ($g_source_url/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$g_target_url))
	{
		if ($g_dtheme_embedded) { direct_output_related_manager ("default_filter_mark_switch","pre_module_service_action_embedded"); }
		elseif ($g_dtheme) { direct_output_related_manager ("default_filter_mark_switch","pre_module_service_action"); }
		else { direct_output_related_manager ("default_filter_mark_switch","pre_module_service_action_ajax"); }

		$direct_cachedata['page_backlink'] = $g_source_url;
		$direct_cachedata['page_homelink'] = str_replace ("[oid]","",$g_task_array['core_back_return']);
	}
	else { $g_continue_check = false; }

	if (isset ($g_task_array['core_sid'])) { $g_task_sid = $g_task_array['core_sid']; }
	else { $g_task_sid = "c21f969b5f03d33d43e04f8f136e7682"; }
	// md5 ("default")

	if ((isset ($g_task_array['uuid']))&&($g_task_array['uuid'] != $direct_settings['uuid'])) { $g_continue_check = false; }

	if ($g_dtheme_embedded) { direct_output_theme_subtype ("embedded"); }
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formtags.php");

	direct_class_init ("formtags");
	direct_class_init ("output");
	if ($g_dtheme) { $direct_classes['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0"); }

	if ($g_continue_check)
	{
		$g_task_array["core_filter_".$g_fid] = $direct_classes['formtags']->encode ($g_ftext);
		if ($g_tid == $direct_settings['uuid']) { $g_task_array['uuid'] = $direct_settings['uuid']; }

		if ($direct_settings['user']['type'] == "gt")
		{
			$g_uuid_string = $direct_classes['kernel']->v_uuid_get ("s");

			if (!$g_uuid_string)
			{
				$g_uuid_string = "<evars><userid /></evars>";
				$direct_classes['kernel']->v_uuid_write ($g_uuid_string);
				$direct_classes['kernel']->v_uuid_cookie_save ();
			}
		}

		direct_tmp_storage_write ($g_task_array,$g_tid,$g_task_sid,"task_cache","evars",$direct_cachedata['core_time'],($direct_cachedata['core_time'] + 3600));

		$direct_classes['output']->redirect (direct_linker ("url1",$g_target_url,false));
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