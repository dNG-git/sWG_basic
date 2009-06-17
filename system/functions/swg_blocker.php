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
$Id: swg_blocker.php,v 1.2 2008/12/20 13:11:29 s4u Exp $
#echo(sWGbasicVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* The blocker functions are used in themes to add blocks of menus or (X)HTML
* code to the output.
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
* @subpackage extra_functions
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

//f// direct_block_get ()
/**
* Returns a block definition.
*
* @uses   direct_basic_functions::memcache_get_file()
* @uses   direct_basic_functions::include_file()
* @uses   direct_basic_functions::inputfilter_filepath()
* @uses   direct_xml_bridge::xml2array()
* @return boolean True on success
* @since  v0.1.00
*/
function direct_block_get ()
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_block_get (+f_block)- (#echo(__LINE__)#)"); }

	if (!isset ($direct_classes['basic_functions'])) { direct_class_init ("basic_functions"); }
	if (!isset ($direct_classes['xml_bridge'])) { direct_class_init ("xml_bridge"); }
	if (!function_exists ("direct_file_get")) { $direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_file_functions.php",2); }

	$f_options = func_get_args ();
	$f_block = array_shift ($f_options);
	$f_return = false;

	if (!isset ($direct_cachedata['blocker_data']))
	{
		if ((isset ($direct_classes['basic_functions']))||(isset ($direct_classes['xml_bridge']))||(file_exists ($direct_settings['path_data']."/settings/swg_blocks_installed.php")))
		{
			$direct_cachedata['blocker_data'] = $direct_classes['basic_functions']->memcache_get_file ($direct_settings['path_data']."/settings/swg_blocks_installed.php");

			if ($direct_cachedata['blocker_data'])
			{
				$direct_cachedata['blocker_data'] = $direct_classes['xml_bridge']->xml2array ($direct_cachedata['blocker_data'],true,false);
				$direct_cachedata['blocker_data'] = $direct_cachedata['blocker_data']['swg_blocks_file_v1'];
			}
		}
		else { $direct_cachedata['blocker_data'] = array (); }
	}

	if (isset ($direct_cachedata['blocker_data'][$f_block]['xml.item']))
	{
		$f_file_path = "";
		$f_function = "";

		foreach ($direct_cachedata['blocker_data'][$f_block] as $f_xml_node_array)
		{
			switch ($f_xml_node_array['tag'])
			{
			case "file":
			{
				$f_file_path = $direct_classes['basic_functions']->inputfilter_filepath ($f_xml_node_array['value']);
				break 1;
			}
			case "function":
			{
				$f_function = ("direct_output_block_".(preg_replace ("#\W#","",$f_xml_node_array['value'])));
				break 1;
			}
			}
		}

		if (($f_file_path)&&($f_function))
		{
			if ($direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/blocks/".$f_file_path))
			{
				if (function_exists ($f_function)) { $f_return = $f_function ($f_options); }
			}
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_block_get ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// EOF
?>