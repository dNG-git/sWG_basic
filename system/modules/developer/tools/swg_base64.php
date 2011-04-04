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
* developer/tools/swg_base64.php
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
* @subpackage developer
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

//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "decode"
case "decode":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=decode_ (#echo(__LINE__)#)"); }

	$direct_cachedata['page_this'] = "m=developer;a=tools+base64;a=decode";
	$direct_cachedata['page_backlink'] = "m=developer;a=services";
	$direct_cachedata['page_homelink'] = "m=developer;a=services";

	if ($direct_globals['kernel']->service_init_default ())
	{
	//j// BOA
	$direct_globals['output']->related_manager ("developer_tools_base64_decode","pre_module_service_action");
	$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formbuilder.php");
	direct_local_integration ("developer");

	direct_class_init ("formbuilder");
	$direct_globals['output']->options_insert (1,"servicemenu","m=developer;a=services",(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

	$direct_cachedata['i_dinput'] = (isset ($GLOBALS['i_dinput']) ? ($direct_globals['basic_functions']->inputfilter_basic ($GLOBALS['i_dinput'])) : "");
	$direct_globals['formbuilder']->entry_add_textarea (array ("name" => "dinput","title" => (direct_local_get ("developer_input")),"size" => "l","min" => 1));

	if ($direct_cachedata['i_dinput'])
	{
		$direct_cachedata['i_dinput'] = preg_replace ("#\W#i","",$direct_cachedata['i_dinput']);
		$direct_cachedata['output_input_result'] = direct_html_encode_special (base64_decode ($direct_cachedata['i_dinput']));
	}
	else { $direct_cachedata['output_input_result'] = ""; }

	$direct_cachedata['output_preview_function_file'] = "swgi_developer";
	$direct_cachedata['output_preview_function'] = "oset_developer_input_result_sourcecode";

	$direct_cachedata['output_formbutton'] = direct_local_get ("core_continue");
	$direct_cachedata['output_formelements'] = $direct_globals['formbuilder']->form_get (true);
	$direct_cachedata['output_formtarget'] = "m=developer;s=tools+base64;a=decode";
	$direct_cachedata['output_formtitle'] = direct_local_get ("developer_base64_decode");

	$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
	$direct_globals['output']->related_manager ("developer_tools_base64_decode","post_module_service_action");
	$direct_globals['output']->oset ("default","form_preview");
	$direct_globals['output']->output_send ($direct_cachedata['output_formtitle']);
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// $direct_settings['a'] == "encode"
case "encode":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=encode_ (#echo(__LINE__)#)"); }

	$direct_cachedata['page_this'] = "m=developer;a=tools+base64;a=encode";
	$direct_cachedata['page_backlink'] = "m=developer;a=services";
	$direct_cachedata['page_homelink'] = "m=developer;a=services";

	if ($direct_globals['kernel']->service_init_default ())
	{
	//j// BOA
	$direct_globals['output']->related_manager ("developer_tools_base64_encode","pre_module_service_action");
	$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formbuilder.php");
	direct_local_integration ("developer");

	direct_class_init ("formbuilder");
	$direct_globals['output']->options_insert (1,"servicemenu","m=developer;a=services",(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

	$direct_cachedata['i_dinput'] = (isset ($GLOBALS['i_dinput']) ? ($direct_globals['basic_functions']->inputfilter_basic ($GLOBALS['i_dinput'])) : "");
	$direct_globals['formbuilder']->entry_add_textarea (array ("name" => "dinput","title" => (direct_local_get ("developer_input")),"size" => "l","min" => 1));

	if ($direct_cachedata['i_dinput'])
	{
		$direct_cachedata['output_input_result'] = base64_encode ($direct_cachedata['i_dinput']);
		$direct_cachedata['output_input_result'] = direct_html_encode_special (wordwrap ($direct_cachedata['output_input_result'],72,"\n",1));
	}
	else { $direct_cachedata['output_input_result'] = ""; }

	$direct_cachedata['output_preview_function_file'] = "swgi_developer";
	$direct_cachedata['output_preview_function'] = "oset_developer_input_result_sourcecode";

	$direct_cachedata['output_formbutton'] = direct_local_get ("core_continue");
	$direct_cachedata['output_formelements'] = $direct_globals['formbuilder']->form_get (true);
	$direct_cachedata['output_formtarget'] = "m=developer;s=tools+base64;a=encode";
	$direct_cachedata['output_formtitle'] = direct_local_get ("developer_base64_encode");

	$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
	$direct_globals['output']->related_manager ("developer_tools_base64_encode","post_module_service_action");
	$direct_globals['output']->oset ("default","form_preview");
	$direct_globals['output']->output_send ($direct_cachedata['output_formtitle']);
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>