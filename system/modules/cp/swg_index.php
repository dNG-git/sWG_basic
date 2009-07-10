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
* cp/swg_index.php
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
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGbasicVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "services"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "services"
case "services":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=services_ (#echo(__LINE__)#)"); }

	$direct_cachedata['output_page'] = (isset ($direct_settings['dsd']['page']) ? ($direct_classes['basic_functions']->inputfilter_number ($direct_settings['dsd']['page'])) : 1);

	$direct_cachedata['page_this'] = "m=cp&a=services&dsd=page+".$direct_cachedata['output_page'];
	$direct_cachedata['page_backlink'] = "";
	$direct_cachedata['page_homelink'] = "";

	if ($direct_classes['kernel']->service_init_default ())
	{
	//j// BOA
	direct_output_related_manager ("cp_index_services","pre_module_service_action");
	$direct_classes['kernel']->service_https ($direct_settings['cp_https'],$direct_cachedata['page_this']);
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formtags.php");
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_service_list.php");
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php");
	direct_local_integration ("cp_core");

	direct_class_init ("formtags");
	direct_class_init ("output");

	$direct_cachedata['output_filter_fid'] = "cp_services";
	$direct_cachedata['output_filter_source'] = urlencode (base64_encode ($direct_cachedata['page_this']));
	$direct_cachedata['output_filter_text'] = "";

	if ($direct_settings['user']['type'] == "gt") { $direct_cachedata['output_filter_tid'] = ""; }
	else { $direct_cachedata['output_filter_tid'] = $direct_settings['uuid']; }

	$g_task_array = direct_tmp_storage_get ("evars",$direct_settings['uuid'],"","task_cache");

	if (($g_task_array)&&(isset ($g_task_array['core_filter_cp_services']))&&($g_task_array['uuid'] == $direct_settings['uuid']))
	{
		$direct_cachedata['output_filter_text'] = $direct_classes['formtags']->decode ($g_task_array['core_filter_cp_services']);
		$g_services_array = direct_service_list_search ("cp",$direct_cachedata['output_filter_text'],"title-desc_preg",$direct_cachedata['output_page']);
	}
	else { $g_services_array = direct_service_list ("cp",$direct_cachedata['output_page']); }

	$direct_cachedata['output_services'] = $g_services_array['list'];

	$direct_cachedata['output_page'] = $g_services_array['data']['page'];
	$direct_cachedata['output_page_url'] = "m=cp&a=services&dsd=";
	$direct_cachedata['output_pages'] = $g_services_array['data']['pages'];
	$direct_cachedata['output_services_title'] = direct_local_get ("cp_core_service_list");

	direct_output_related_manager ("cp_index_services","post_module_service_action");
	$direct_classes['output']->oset ("default","service_list");
	$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
	$direct_classes['output']->header_elements ("<script language='JavaScript' src='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/swg_formbuilder.js++dbid+".$direct_settings['product_buildid'],true,false))."' type='text/javascript'><!-- // FormBuilder javascript functions // --></script>");
	$direct_classes['output']->page_show (direct_local_get ("cp_core_control_panel"));
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>