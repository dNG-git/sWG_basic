<?php
//j// BOF

/*n// NOTE
----------------------------------------------------------------------------
secured WebGine
net-based application engine
----------------------------------------------------------------------------
(C) direct Netware Group - All rights reserved
http://www.direct-netware.de/redirect.php?swg

This Source Code Form is subject to the terms of the Mozilla Public License,
v. 2.0. If a copy of the MPL was not distributed with this file, You can
obtain one at http://mozilla.org/MPL/2.0/.
----------------------------------------------------------------------------
http://www.direct-netware.de/redirect.php?licenses;mpl2
----------------------------------------------------------------------------
#echo(sWGbasicVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* default/swg_filter.php
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
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
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
	$g_mode_ajax_content = (($direct_settings['ohandler'] == "ajax_content") ? true : false);
	$g_mode_embedded = (($direct_settings['ohandler'] == "xhtml_embedded") ? true : false);
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=filter_ (#echo(__LINE__)#)"); }

	$g_fid = (isset ($direct_settings['dsd']['dfid']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['dfid'])) : "");
	$g_ftext = (isset ($direct_settings['dsd']['dftext']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['dftext'])) : "");
	$g_tid = (isset ($direct_settings['dsd']['tid']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['tid'])) : "");
	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['source'])) : "");
	$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['target'])) : "");

	$g_source_url = ($g_source ? base64_decode ($g_source) : "");

	if ($g_target) { $g_target_url = base64_decode ($g_target); }
	else
	{
		$g_target = $g_source;
		$g_target_url = $g_source_url;
	}

	$direct_cachedata['page_this'] = "";
	$direct_cachedata['page_backlink'] = "";
	$direct_cachedata['page_homelink'] = "";

	if ($direct_globals['kernel']->serviceInitDefault ())
	{
	//j// BOA
	$direct_globals['basic_functions']->requireClass ('dNG\sWG\directFormtags');
	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_tmp_storager.php");

	direct_class_init ("formtags");

	$g_continue_check = true;
	$g_uuid = $direct_globals['input']->uuidGet ();

	if ($g_tid == "") { $g_tid = $g_uuid; }
	$g_task_array = direct_tmp_storage_get ("evars",$g_tid,"","task_cache");

	if (isset ($g_source_url/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$g_target_url))
	{
		if ($g_mode_ajax_content) { $direct_globals['output']->relatedManager ("default_filter_mark_switch","pre_module_service_action_ajax"); }
		elseif ($g_mode_embedded) { $direct_globals['output']->relatedManager ("default_filter_mark_switch","pre_module_service_action_embedded"); }
		else { $direct_globals['output']->relatedManager ("default_filter_mark_switch","pre_module_service_action"); }

		$direct_cachedata['page_backlink'] = $g_source_url;
		$direct_cachedata['page_homelink'] = str_replace ("[oid]","",$g_task_array['core_back_return']);
	}
	else { $g_continue_check = false; }

	if ($direct_cachedata['page_backlink']) { $direct_globals['output']->optionsInsert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0"); }

	$g_task_sid = ((isset ($g_task_array['core_sid'])) ? $g_task_array['core_sid'] : "c21f969b5f03d33d43e04f8f136e7682");
	// md5 ("default")

	if ((isset ($g_task_array['uuid']))&&($g_task_array['uuid'] != $g_uuid)) { $g_continue_check = false; }

	if ($g_continue_check)
	{
		$g_task_array["core_filter_".$g_fid] = $direct_globals['formtags']->encode ($g_ftext);
		if ($g_tid == $g_uuid) { $g_task_array['uuid'] = $g_uuid; }

		if ($direct_settings['user']['type'] == "gt")
		{
			$g_uuid_string = $direct_globals['kernel']->vUuidGet ("s");

			if (!$g_uuid_string)
			{
				$g_uuid_string = "<evars><userid /></evars>";
				$direct_globals['kernel']->vUuidWrite ($g_uuid_string);
				$direct_globals['kernel']->vUuidCookieSave ();
			}
		}

		direct_tmp_storage_write ($g_task_array,$g_tid,$g_task_sid,"task_cache","evars",$direct_cachedata['core_time'],($direct_cachedata['core_time'] + 3600));

		if ($g_mode_ajax_content) { $direct_globals['output']->redirect (direct_linker_dynamic ("url1",$g_target_url,false),true,false); }
		else { $direct_globals['output']->redirect (direct_linker ("url1",$g_target_url,false)); }
	}
	else { $direct_globals['output']->outputSendError ("standard","core_tid_invalid","","sWG/#echo(__FILEPATH__)# _a=mark_switch_ (#echo(__LINE__)#)"); }
	//j// BOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>