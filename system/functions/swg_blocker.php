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
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

/**
* Returns a block definition.
*
* @return boolean True on success
* @since  v0.1.00
*/
function direct_block_get ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_block_get (+f_block)- (#echo(__LINE__)#)"); }

	if (!isset ($direct_globals['basic_functions'])) { direct_class_init ("basic_functions"); }
	if (!isset ($direct_globals['xml_bridge'])) { direct_class_init ("xml_bridge"); }
	if (!function_exists ("direct_file_get")) { $direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_file_functions.php",2); }

	$f_options = func_get_args ();
	$f_block = array_shift ($f_options);
	$f_return = false;

	if (!isset ($direct_cachedata['blocker_data']))
	{
		if ((isset ($direct_globals['basic_functions']))||(isset ($direct_globals['xml_bridge']))||(file_exists ($direct_settings['path_data']."/settings/swg_blocks_installed.php")))
		{
			$direct_cachedata['blocker_data'] = $direct_globals['basic_functions']->memcacheGetFile ($direct_settings['path_data']."/settings/swg_blocks_installed.php");

			if ($direct_cachedata['blocker_data'])
			{
				$direct_cachedata['blocker_data'] = $direct_globals['xml_bridge']->xml2array ($direct_cachedata['blocker_data'],true,false);
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
				$f_file_path = $direct_globals['basic_functions']->inputfilterFilePath ($f_xml_node_array['value']);
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
			if ($direct_globals['basic_functions']->includeFile ($direct_settings['path_system']."/blocks/".$f_file_path))
			{
				if (function_exists ($f_function)) { $f_return = $f_function ($f_options); }
			}
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_block_get ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// EOF
?>