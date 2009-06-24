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
$Id: swg_formbuilder.php,v 1.1 2008/12/20 13:33:28 s4u Exp $
#echo(sWGbasicVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* developer/swg_formbuilder.php
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

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "view"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "view"
case "view":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=view_ (#echo(__LINE__)#)"); }

	$direct_cachedata['page_this'] = "m=developer&s=formbuilder";
	$direct_cachedata['page_backlink'] = "m=developer&a=services";
	$direct_cachedata['page_homelink'] = "m=developer&a=services";

	if ($direct_classes['kernel']->service_init_default ())
	{
	//j// BOA
	direct_output_related_manager ("developer_formbuilder_view","pre_module_service_action");
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formbuilder.php");
	direct_local_integration ("developer");

	direct_class_init ("formbuilder");
	direct_class_init ("output");
	direct_class_init ("output_formbuilder");
	$direct_classes['output']->options_insert (1,"servicemenu","m=developer&a=services",(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

$g_form_element_array = array (
"type" => "",
"name" => 0,
"title" => 0,
"required" => false,
"size" => "m",
"helper_text" => "",
"helper_url" => direct_linker ("url0","m=developer&s=forbuilder"),
"helper_closing" => false,
"content" => ""
);

	$direct_cachedata['output_formelements'] = array ();
	$g_form_element_count = 0;

	foreach ($direct_classes['output_formbuilder']->functions as $g_method => $g_method_available)
	{
		if (($g_method_available)&&(preg_match ("#^entry_add_(.+?)$#",$g_method,$g_result_array)))
		{
			$g_form_element_count++;

			$g_form_element_array['type'] = $g_result_array[1];
			$g_form_element_array['name'] = "swgf".$g_form_element_count;
			$g_form_element_array['title'] = (direct_local_get ("developer_formbuilder_element_1")).$g_form_element_count.(direct_local_get ("developer_formbuilder_element_2"));
			$g_form_element_array['helper_text'] = $g_method;

			$direct_cachedata['output_formelements'][] = $g_form_element_array;
		}
	}

	$direct_cachedata['output_formbutton'] = direct_local_get ("core_continue");
	$direct_cachedata['output_formtarget'] = "m=developer&s=formbuilder";
	$direct_cachedata['output_formtitle'] = direct_local_get ("developer_formbuilder");

	direct_output_related_manager ("developer_formbuilder_view","post_module_service_action");
	$direct_classes['output']->oset ("default","form");
	$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
	$direct_classes['output']->page_show ($direct_cachedata['output_formtitle']);
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>