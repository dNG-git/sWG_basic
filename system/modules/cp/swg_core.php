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
* cp/swg_core.php
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
* @subpackage cp
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

if (!isset ($direct_settings['cp_https'])) { $direct_settings['cp_https'] = false; }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGbasicVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "services"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "services"
case "services":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=services_ (#echo(__LINE__)#)"); }

	$direct_cachedata['output_page'] = (isset ($direct_settings['dsd']['page']) ? ($direct_globals['basic_functions']->inputfilter_number ($direct_settings['dsd']['page'])) : 1);

	$direct_cachedata['page_this'] = "m=cp;s=core;a=services;dsd=page+".$direct_cachedata['output_page'];
	$direct_cachedata['page_backlink'] = "m=cp;a=services";
	$direct_cachedata['page_homelink'] = "m=cp;a=services";

	if ($direct_globals['kernel']->service_init_default ())
	{
	//j// BOA
	$direct_globals['output']->related_manager ("cp_core_services","pre_module_service_action");
	$direct_globals['kernel']->service_https ($direct_settings['cp_https'],$direct_cachedata['page_this']);
	$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formtags.php");
	$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_service_list.php");
	$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php");
	direct_local_integration ("cp_core");

	direct_class_init ("formtags");
	$direct_globals['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

	$g_uuid = $direct_globals['input']->uuid_get ();

	$direct_cachedata['output_filter_fid'] = "cp_core_services";
	$direct_cachedata['output_filter_source'] = urlencode (base64_encode ($direct_cachedata['page_this']));
	$direct_cachedata['output_filter_text'] = "";
	$direct_cachedata['output_filter_tid'] = (($direct_settings['user']['type'] == "gt") ? "" : $g_uuid);

	$g_task_array = direct_tmp_storage_get ("evars",$g_uuid,"","task_cache");

	if (($g_task_array)&&(isset ($g_task_array['core_filter_cp_core_services']))&&($g_task_array['uuid'] == $g_uuid))
	{
		$direct_cachedata['output_filter_text'] = $direct_globals['formtags']->decode ($g_task_array['core_filter_cp_core_services']);
		$g_services_array = direct_service_list_search ("cp_core",$direct_cachedata['output_filter_text'],"title-desc_preg",$direct_cachedata['output_page']);
	}
	else { $g_services_array = direct_service_list ("cp_core",$direct_cachedata['output_page']); }

	$direct_cachedata['output_services'] = $g_services_array['list'];

	$direct_cachedata['output_page'] = $g_services_array['data']['page'];
	$direct_cachedata['output_page_url'] = "m=cp;s=core;a=services;dsd=";
	$direct_cachedata['output_pages'] = $g_services_array['data']['pages'];
	$direct_cachedata['output_services_title'] = direct_local_get ("cp_core_service_list");

	$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
	$direct_globals['output']->related_manager ("cp_core_services","post_module_service_action");
	$direct_globals['output']->oset ("default","service_list");
	$direct_globals['output']->output_send (direct_local_get ("cp_core_basic_settings"));
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>