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
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

/**
* Read in an XML blockmenu definition file, parse it and prepare it for
* output.
*
* @param  array $f_options Array with parameters from the block call
* @return boolean True on success
* @since  v0.1.00
*/
function direct_output_block_blockmenu ($f_options)
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_block_blockmenu (+f_options)- (#echo(__LINE__)#)"); }

	$f_type = $f_options[0];
	$f_menu = $f_options[1];
	$f_seperator = $f_options[2];
	$f_return = false;

	if (isset ($direct_globals['output']))
	{
		$f_blocks_array = ((file_exists ($direct_settings['path_data']."/settings/swg_{$f_menu}.blockmenu.xml")) ? $direct_globals['basic_functions']->memcacheGetFileMergedXml ($direct_settings['path_data']."/settings/swg_{$f_menu}.blockmenu.xml") : array ());

		if ((is_array ($f_blocks_array))&&(!empty ($f_blocks_array)))
		{
			foreach ($f_blocks_array as $f_key => $f_block_array)
			{
				if ((isset ($f_block_array['attributes']['active']))&&($f_block_array['attributes']['active']))
				{
					$f_continue_check = true;

					if ((isset ($f_block_array['attributes']['lang']))&&($f_block_array['attributes']['lang']))
					{
						if ($f_block_array['attributes']['lang'] != $direct_settings['lang']) { $f_continue_check = false; }
					}

					if ((isset ($f_blocks_array[$f_key."_title"]))&&($f_blocks_array[$f_key."_title"])) { $f_block_array['value'] = $f_blocks_array[$f_key."_title"]['value']; }
					else { $f_continue_check = false; }

					$f_block_array['attributes']['image'] = ((isset ($f_blocks_array[$f_key."_image"])) ? $f_blocks_array[$f_key."_image"]['value'] : "");

					if ((isset ($f_blocks_array[$f_key."_link"]))&&($f_blocks_array[$f_key."_link"]))
					{
						$f_block_array['attributes']['link'] = $f_blocks_array[$f_key."_link"];
						$f_block_array['attributes']['link']['type'] = ((isset ($f_block_array['attributes']['link']['attributes']['type'])) ? $f_block_array['attributes']['link']['attributes']['type'] : "");
					}
					else { $f_continue_check = false; }

					$f_right_check = false;
					if (($f_blocks_array[$f_key."_guests"])&&($f_blocks_array[$f_key."_guests"]['value'])&&(($direct_settings['user']['type'] == "ex")||($direct_settings['user']['type'] == "gt"))) { $f_right_check = true; }
					if (($f_blocks_array[$f_key."_members"])&&($f_blocks_array[$f_key."_members"]['value'])&&(direct_class_function_check ($direct_globals['kernel'],"vUsertypeGetInt"))&&($direct_globals['kernel']->vUsertypeGetInt ($direct_settings['user']['type']))) { $f_right_check = true; }

/*i// LICENSE_WARNING
----------------------------------------------------------------------------
The sWG Group Class has been published under the General Public License.
----------------------------------------------------------------------------
LICENSE_WARNING_END //i*/

					if ((!$f_right_check)&&($f_blocks_array[$f_key."_group_right"])&&(direct_class_function_check ($direct_globals['kernel'],"vGroupUserCheckRight")))
					{
						if (isset ($f_blocks_array[$f_key."_group_right"]['value']))
						{
							if ($f_blocks_array[$f_key."_group_right"]['value']) { $f_right_check = $direct_globals['kernel']->vGroupUserCheckRight ($f_blocks_array[$f_key."_group_right"]['value']); }
						}
						elseif (is_array ($f_blocks_array[$f_key."_group_right"]))
						{
							$f_group_rights_array = array ();

							foreach ($f_blocks_array[$f_key."_group_right"] as $f_group_right_array)
							{
								if (strlen ($f_group_right_array['value'])) { $f_group_rights_array[] = $f_group_right_array['value']; }
							}

							$f_right_check = $direct_globals['kernel']->vGroupUserCheckRight ($f_group_rights_array);
						}
					}

					if (($f_continue_check)&&($f_right_check))
					{
						if (isset ($f_block_array['attributes']['level'])) { $direct_globals['output']->optionsInsert ($f_block_array['attributes']['level'],"output_block_blockmenu_".$f_menu,$f_block_array['attributes']['link']['value'],$f_block_array['value'],$f_block_array['attributes']['image'],$f_block_array['attributes']['link']['type']); }
						else { $direct_globals['output']->optionsInsert (6,"output_block_blockmenu_".$f_menu,$f_block_array['attributes']['link']['value'],$f_block_array['value'],$f_block_array['attributes']['image'],$f_block_array['attributes']['link']['type']); }
					}
				}
			}

			$f_return = $direct_globals['output']->optionsGenerator ($f_type,"output_block_blockmenu_".$f_menu,$f_seperator);
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_output_block_blockmenu ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// EOF
?>