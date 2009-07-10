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
* Modifications can be integrated into requested actions that support it.
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

//f// direct_mods_include ()
/**
* Include modifications with a given modname and function if support has been
* activated. Needed parameters: $f_support (boolean) True if modification
* support is enabled; $f_modname (string) Modification identifier; $f_function
* (string) Function to call.
*
* @uses   direct_basic_functions::include_file()
* @uses   direct_basic_functions::memcache_get_file()
* @uses   direct_debug()
* @uses   direct_xml_bridge::xml2array()
* @uses   USE_debug_reporting
* @return mixed Return whatever is required by the modification specification
* @since  v0.1.00
*/
function direct_mods_include ()
{
	global $direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_mods_include ()- (#echo(__LINE__)#)"); }

	$f_data = func_get_args ();
	$f_return = false;

	$f_support = $f_data[0];
	$f_modname = $f_data[1];
	$f_function_id = $f_data[2];

	unset ($f_data[0]);
	unset ($f_data[1]);

	$f_data[2] = $f_return;
	$f_data = array_values ($f_data);

	if ($f_support)
	{
		$f_file_data = $direct_classes['basic_functions']->memcache_get_file ($direct_settings['path_system']."/mods/$f_modname/swg_modlist.xml");

		if ($f_file_data)
		{
			$f_xml_array = $direct_classes['xml_bridge']->xml2array ($f_file_data,true,false);

			if (isset ($f_xml_array['swg_modlist_file_v1']))
			{
				if ($f_function_id == "test") { $f_return = true; }
				else
				{
					unset ($f_xml_array['swg_modlist_file_v1']['xml.item']);

					foreach ($f_xml_array['swg_modlist_file_v1'] as $f_xml_node_array)
					{
						if (isset ($f_xml_node_array['xml.mtree']))
						{
							unset ($f_xml_node_array['xml.mtree']);

							foreach ($f_xml_node_array as $f_xml_sub_node_array)
							{
								if (isset ($f_xml_sub_node_array['attributes']['module']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_xml_sub_node_array['attributes']['function']))
								{
									$direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/mods/$f_modname/swgi_{$f_xml_sub_node_array['attributes']['module']}.php");
									$f_function = "direct_mods_{$f_modname}_{$f_xml_sub_node_array['attributes']['function']}_".$f_function_id;

									if (function_exists ($f_function)) { $f_data[0] = $f_function ($f_data); }
									else { trigger_error ("sWG/#echo(__FILEPATH__)# -direct_mods_include ()- (#echo(__LINE__)#) reporting: Can't find specified modification interface &quot;$f_function_id&quot;",E_USER_NOTICE); }
								}
							}
						}
						elseif (isset ($f_xml_node_array['attributes']['module']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_xml_node_array['attributes']['function']))
						{
							$direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/mods/$f_modname/swgi_{$f_xml_node_array['attributes']['module']}.php");
							$f_function = "direct_mods_{$f_modname}_{$f_xml_node_array['attributes']['function']}_".$f_function_id;

							if (function_exists ($f_function)) { $f_data[0] = $f_function ($f_data); }
							else { trigger_error ("sWG/#echo(__FILEPATH__)# -direct_mods_include ()- (#echo(__LINE__)#) reporting: Can't find specified modification interface &quot;$f_function_id&quot;",E_USER_WARNING); }
						}
					}

					$f_return = $f_data[0];
				}
			}
		}
		else { trigger_error ("sWG/#echo(__FILEPATH__)# -direct_mods_include ()- (#echo(__LINE__)#) reporting: Requested modification support is broken",E_USER_WARNING); }
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_mods_include ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// EOF
?>