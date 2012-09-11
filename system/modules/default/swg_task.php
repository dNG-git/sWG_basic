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
* default/swg_task.php
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

//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "done"
case "done":
{
	$g_mode_ajax_content = (($direct_settings['ohandler'] == "ajax_content") ? true : false);
	$g_mode_embedded = (($direct_settings['ohandler'] == "xhtml_embedded") ? true : false);
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=filter_ (#echo(__LINE__)#)"); }

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

	$direct_cachedata['page_this'] = $g_target_url;
	$direct_cachedata['page_backlink'] = $g_source_url;
	$direct_cachedata['page_homelink'] = $g_source_url;

	if ($direct_globals['kernel']->serviceInitDefault ())
	{
	//j// BOA
	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_tmp_storager.php");
	$g_uuid = $direct_globals['input']->uuidGet ();

	if ($g_tid == "") { $g_tid = $g_uuid; }
	$g_task_array = direct_tmp_storage_get ("evars",$g_tid,"","task_cache");

	if ((isset ($g_task_array['core_done_description']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$g_task_array['core_done_report']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$g_task_array['core_done_title']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$g_task_array['uuid']))&&($g_task_array['uuid'] == $g_uuid))
	{
		if ($g_mode_ajax_content) { $direct_globals['output']->relatedManager ("default_task_done","pre_module_service_action_ajax"); }
		elseif ($g_mode_embedded) { $direct_globals['output']->relatedManager ("default_task_done","pre_module_service_action_embedded"); }
		else { $direct_globals['output']->relatedManager ("default_task_done","pre_module_service_action"); }

		if (isset ($g_task_array['core_back_return']))
		{
			if (!$g_source_url)
			{
				$direct_cachedata['page_backlink'] = str_replace ("[oid]","",$g_task_array['core_back_return']);
				$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'];
			}

			if (!$g_target_url) { $g_target_url = str_replace ("[oid]","",$g_task_array['core_back_return']); }
		}

		$g_continue_check = true;
	}
	else { $g_continue_check = false; }

	if ($direct_cachedata['page_backlink']) { $direct_globals['output']->optionsInsert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0"); }

	if ($g_continue_check)
	{
		$direct_cachedata['output_job'] = $g_task_array['core_done_title'];
		$direct_cachedata['output_job_desc'] = $g_task_array['core_done_description'];
		$direct_cachedata['output_job_entries'] = $g_task_array['core_done_report'];

		if ($g_target_url) { $direct_cachedata['output_pagetarget'] = direct_linker ("url0",$g_target_url); }

		$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
		$direct_globals['output']->relatedManager ("default_task_done","post_module_service_action");
		$direct_globals['output']->oset ("default","done_extended");
		$direct_globals['output']->outputSend ($direct_cachedata['output_job']);
	}
	else { $direct_globals['output']->outputSendError ("standard","core_tid_invalid","","sWG/#echo(__FILEPATH__)# _a=mark_switch_ (#echo(__LINE__)#)"); }
	//j// BOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}//j// $direct_settings['a'] == "keepalive"
case "keepalive":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=keepalive_ (#echo(__LINE__)#)"); }
	$direct_settings['swg_theme_deactivated'] = true;

	$g_tid = (isset ($direct_settings['dsd']['tid']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['tid'])) : "");

	$g_result = $direct_globals['kernel']->serviceInitRBoolean ();
	if ($g_result) { $g_result = $direct_globals['basic_functions']->includeFile ($direct_settings['path_system']."/functions/swg_tmp_storager.php"); }

	if ($g_result)
	{
		$g_uuid = $direct_globals['input']->uuidGet ();

		if ($g_tid == "") { $g_tid = $g_uuid; }
		$g_task_array = direct_tmp_storage_get ("evars",$g_tid,"","task_cache");

		if ((isset ($g_task_array['uuid']))&&($g_task_array['uuid'] == $g_uuid))
		{
			$g_sid = (isset ($g_task_array['sid']) ? $g_task_array['sid'] : "c21f969b5f03d33d43e04f8f136e7682");
			$g_result = direct_tmp_storage_write ($g_task_array,$g_tid,$g_sid,"task_cache","evars",$direct_cachedata['core_time'],($direct_cachedata['core_time'] + 3600));
		}
		else { $g_result = false; }
	}

	if ($g_result) { $direct_globals['output']->outputHeader ("HTTP/1.1","HTTP/1.1 204 No Content",true); }
	else { $direct_globals['output']->outputHeader ("HTTP/1.1","HTTP/1.1 410 Gone",true); }

	$direct_globals['output']->header (false,false);
	$direct_globals['output']->outputSend (NULL);
}
//j// EOS
}

//j// EOF
?>