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
* The "blockmenu" adds blockmenu XML items to the Options Output System.
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

//j// Functions and classes

//f// direct_output_block_blockmenu ($f_options)
/**
* Read in an XML blockmenu definition file, parse it and prepare it for
* output.
*
* @param  array $f_options Array with parameters from the block call
* @uses   direct_class_function_check()
* @uses   direct_debug()
* @uses   direct_file_get()
* @uses   direct_kernel_system::v_group_user_check_right()
* @uses   direct_kernel_system::v_usertype_get_int()
* @uses   direct_output_control::options_generator()
* @uses   direct_output_control::options_insert()
* @uses   direct_xml_bridge::xml2array()
* @uses   USE_debug_reporting
* @return boolean True on success
* @since  v0.1.00
*/
function direct_output_block_blockmenu ($f_options)
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_block_blockmenu (+f_options)- (#echo(__LINE__)#)"); }

	if (!isset ($direct_cachedata['output_block_blockmenu_element'])) { $direct_cachedata['output_block_blockmenu_element'] = 0; }

	$f_type = $f_options[0];
	$f_menu = $f_options[1];
	$f_seperator = $f_options[2];
	$f_return = false;

	if (isset ($direct_classes['output']))
	{
		$f_blocks_array = ((file_exists ($direct_settings['path_data']."/settings/swg_{$f_menu}.blockmenu.xml")) ? $direct_classes['basic_functions']->memcache_get_file_merged_xml ($direct_settings['path_data']."/settings/swg_{$f_menu}.blockmenu.xml") : array ());

		if ((is_array ($f_blocks_array))&&(!empty ($f_blocks_array)))
		{
			foreach ($f_blocks_array as $f_key => $f_block_array)
			{
				if ((isset ($f_block_array['attributes']['active']))&&($f_block_array['attributes']['active']))
				{
					$f_continue_check = true;

					if ($f_block_array['attributes']['lang'])
					{
						if ($f_block_array['attributes']['lang'] != $direct_settings['lang']) { $f_continue_check = false; }
					}

					if ($f_blocks_array[$f_key."_title"]) { $f_block_array['value'] = $f_blocks_array[$f_key."_title"]['value']; }
					else { $f_continue_check = false; }

					$f_block_array['attributes']['image'] = ((isset ($f_blocks_array[$f_key."_image"])) ? $f_blocks_array[$f_key."_image"]['value'] : "");

					if ($f_blocks_array[$f_key."_link"])
					{
						$f_block_array['attributes']['link'] = $f_blocks_array[$f_key."_link"];
						$f_block_array['attributes']['link']['type'] = ((isset ($f_block_array['attributes']['link']['attributes']['type'])) ? $f_block_array['attributes']['link']['attributes']['type'] : "");
					}
					else { $f_continue_check = false; }

					$f_right_check = false;

					if ($f_blocks_array[$f_key."_guests"])
					{
						if (($f_blocks_array[$f_key."_guests"]['value'])&&(($direct_settings['user']['type'] == "ex")||($direct_settings['user']['type'] == "gt"))) { $f_right_check = true; }
					}

					if ($f_blocks_array[$f_key."_members"])
					{
						if (($f_blocks_array[$f_key."_members"]['value'])&&(direct_class_function_check ($direct_classes['kernel'],"v_usertype_get_int")))
						{
							if ($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type'])) { $f_right_check = true; }
						}
					}

/*i// LICENSE_WARNING
----------------------------------------------------------------------------
The sWG Group Class has been published under the General Public License.
----------------------------------------------------------------------------
LICENSE_WARNING_END //i*/

					if ((!$f_right_check)&&($f_blocks_array[$f_key."_group_right"]))
					{
						if (direct_class_function_check ($direct_classes['kernel'],"v_group_user_check_right"))
						{
							if (isset ($f_blocks_array[$f_key."_group_right"]['value']))
							{
								if ($f_blocks_array[$f_key."_group_right"]['value']) { $f_right_check = $direct_classes['kernel']->v_group_user_check_right ($f_blocks_array[$f_key."_group_right"]['value']); }
							}
							elseif (is_array ($f_blocks_array[$f_key."_group_right"]))
							{
								$f_group_rights_array = array ();

								foreach ($f_blocks_array[$f_key."_group_right"] as $f_group_right_array)
								{
									if (strlen ($f_group_right_array['value'])) { $f_group_rights_array[] = $f_group_right_array['value']; }
								}

								$f_right_check = $direct_classes['kernel']->v_group_user_check_right ($f_group_rights_array);
							}
						}
					}

					if (($f_continue_check)&&($f_right_check))
					{
						if (isset ($f_block_array['attributes']['level'])) { $direct_classes['output']->options_insert ($f_block_array['attributes']['level'],"output_block_blockmenu_".$direct_cachedata['output_block_blockmenu_element'],$f_block_array['attributes']['link']['value'],$f_block_array['value'],$f_block_array['attributes']['image'],$f_block_array['attributes']['link']['type']); }
						else { $direct_classes['output']->options_insert (6,"output_block_blockmenu_".$direct_cachedata['output_block_blockmenu_element'],$f_block_array['attributes']['link']['value'],$f_block_array['value'],$f_block_array['attributes']['image'],$f_block_array['attributes']['link']['type']); }
					}
				}
			}

			$f_return = $direct_classes['output']->options_generator ($f_type,"output_block_blockmenu_".$direct_cachedata['output_block_blockmenu_element'],$f_seperator);
			$direct_cachedata['output_block_blockmenu_element']++;
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_output_block_blockmenu ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// EOF
?>