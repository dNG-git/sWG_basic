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
* Service lists provide a selection of module specific options.
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

/* -------------------------------------------------------------------------
Direct calls will be honored with an "exit ()"
------------------------------------------------------------------------- */

if (!defined ("direct_product_iversion")) { exit (); }

//j// Functions and classes

//f// direct_service_list ($f_module,$f_page = 1)
/**
* Reads and parses a service list XML file.
*
* @param  string $f_module Service list module name
* @param  integer $f_page Requested page if multiple exist
* @uses   direct_basic_functions::memcache_get_file_merged_xml()
* @uses   direct_class_function_check()
* @uses   direct_debug()
* @uses   direct_kernel_system::v_group_user_check_right()
* @uses   direct_kernel_system::v_usertype_get_int()
* @uses   direct_service_list_parse()
* @uses   USE_debug_reporting
* @return array Returns a multi dimensional array containing list information
*         and the ready to output service list
* @since  v0.1.00
*/
function direct_service_list ($f_module,$f_page = 1)
{
	global $direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_service_list ($f_module,$f_page)- (#echo(__LINE__)#)"); }

	$f_module = preg_replace ("#[\/\\\?:@\=\&\. \+]#i","",$f_module);
	$f_module_file_name = str_replace (";","_",$f_module);
	$f_return = array ();

	if (file_exists ($direct_settings['path_data']."/settings/swg_{$f_module_file_name}.services.xml")) { $f_xml_array = $direct_classes['basic_functions']->memcache_get_file_merged_xml ($direct_settings['path_data']."/settings/swg_{$f_module_file_name}.services.xml"); }
	else { $f_xml_array = array (); }

	if ((is_array ($f_xml_array))&&(!empty ($f_xml_array)))
	{
		$f_services_array = array ();

		foreach ($f_xml_array as $f_tag => $f_xml_node_array)
		{
			if ((isset ($f_xml_node_array['attributes']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_xml_node_array['attributes']['active']))&&($f_xml_node_array['attributes']['active']))
			{
				$f_continue_check = true;

				if ($f_xml_node_array['attributes']['lang'])
				{
					if ($f_xml_node_array['attributes']['lang'] != $direct_settings['lang']) { $f_continue_check = false; }
				}

				if ($f_xml_array[$f_tag."_title"]) { $f_xml_node_array['value'] = $f_xml_array[$f_tag."_title"]['value']; }
				else { $f_continue_check = false; }

				if ($f_xml_array[$f_tag."_description"]) { $f_xml_node_array['attributes']['description'] = $f_xml_array[$f_tag."_description"]['value']; }
				if ($f_xml_array[$f_tag."_image"]) { $f_xml_node_array['attributes']['image'] = $f_xml_array[$f_tag."_image"]['value']; }

				if ($f_xml_array[$f_tag."_link"]) { $f_xml_node_array['attributes']['link'] = $f_xml_array[$f_tag."_link"]; }
				else { $f_continue_check = false; }

				$f_right_check = false;

				if ($f_xml_array[$f_tag."_guests"])
				{
					if (($f_xml_array[$f_tag."_guests"]['value'])&&(($direct_settings['user']['type'] == "ex")||($direct_settings['user']['type'] == "gt"))) { $f_right_check = true; }
				}

				if ($f_xml_array[$f_tag."_members"])
				{
					if (($f_xml_array[$f_tag."_members"]['value'])&&(direct_class_function_check ($direct_classes['kernel'],"v_usertype_get_int")))
					{
						if ($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type'])) { $f_right_check = true; }
					}
				}

				if ((!$f_right_check)&&($f_xml_array[$f_tag."_group_right"]))
				{
					if (direct_class_function_check ($direct_classes['kernel'],"v_group_user_check_right"))
					{
						if (isset ($f_xml_array[$f_tag."_group_right"]['value']))
						{
							if ($f_xml_array[$f_tag."_group_right"]['value']) { $f_right_check = $direct_classes['kernel']->v_group_user_check_right ($f_xml_array[$f_tag."_group_right"]['value']); }
						}
						elseif (is_array ($f_xml_array[$f_tag."_group_right"]))
						{
							$f_group_rights_array = array ();

							foreach ($f_xml_array[$f_tag."_group_right"] as $f_group_right_array)
							{
								if (strlen ($f_group_right_array['value'])) { $f_group_rights_array[] = $f_group_right_array['value']; }
							}

							$f_right_check = $direct_classes['kernel']->v_group_user_check_right ($f_group_rights_array);
						}
					}
				}

				if (($f_continue_check)&&($f_right_check))
				{
					$f_xml_node_array['value'] = direct_string_translation ($f_module,$f_xml_node_array['value']);
					$f_xml_node_array['attributes']['description'] = direct_string_translation ($f_module,$f_xml_node_array['attributes']['description']);

					if ((isset ($f_xml_node_array['attributes']['position']))&&(!isset ($f_services_array[$f_xml_node_array['attributes']['position']]))) { $f_services_array[$f_xml_node_array['attributes']['position']] = $f_xml_node_array; }
					else { $f_services_array[] = $f_xml_node_array; }
				}
			}
		}

		if (!empty ($f_services_array)) { $f_return = direct_service_list_parse ($f_module,(array_values ($f_services_array)),$f_page); }
	}
	else
	{
		$f_return['data'] = array ("page" => 1, "pages" => 1);
		$f_return['list'] = array ();
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_service_list ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_service_list_parse ($f_module,$f_list,$f_page)
/**
* Parses internally prepared service list entries for output.
*
* @param  string $f_module Service list module name
* @param  array $f_list List of services
* @param  integer $f_page Requested page if multiple exist
* @uses   direct_debug()
* @uses   direct_linker()
* @uses   direct_string_translation()
* @uses   USE_debug_reporting
* @return mixed Single or multi dimensional array; false on error
* @since  v0.1.00
*/
function direct_service_list_parse ($f_module,$f_list,$f_page)
{
	global $direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_service_list_parse ($f_module,+f_list,$f_page)- (#echo(__LINE__)#)"); }

	$f_return = array ();

	if (is_array ($f_list))
	{
		$f_return['data'] = array ();
		$f_return['data']['page'] = $f_page;
		$f_return['data']['pages'] = ceil ((count ($f_list)) / $direct_settings['swg_services_per_page']);

		if ((!$f_return['data']['page'])||($f_return['data']['page'] < 1)) { $f_return['data']['page'] = 1; }
		if ($f_return['data']['page'] > $f_return['data']['pages']) { $f_return['data']['page'] = $f_return['data']['pages']; }
		if ($f_return['data']['pages'] < 1) { $f_return['data']['pages'] = 1; }

		$f_offset_start = (($f_return['data']['page'] - 1) * $direct_settings['swg_services_per_page']);
		$f_offset_end = ($f_return['data']['page'] * $direct_settings['swg_services_per_page']);
		$f_return['list'] = array ();

		for ($f_i = $f_offset_start;(($f_i < $f_offset_end)&&(!empty ($f_list[$f_i])));$f_i++)
		{
			$f_link_type = "url0";

			if ($f_list[$f_i]['attributes']['link']['attributes']['type'])
			{
				if (($f_list[$f_i]['attributes']['link']['attributes']['type'] == "url1")||($f_list[$f_i]['attributes']['link']['attributes']['type'] == "asis")) { $f_link_type = $f_list[$f_i]['attributes']['link']['attributes']['type']; }
			}

			$f_list[$f_i]['attributes']['link']['value'] = direct_linker ($f_link_type,$f_list[$f_i]['attributes']['link']['value']);

			if ($f_list[$f_i]['attributes']['image'])
			{
				if (file_exists ($direct_settings['path_themes']."/$direct_settings[theme]/".$f_list[$f_i]['attributes']['image'])) { $f_list[$f_i]['attributes']['image'] = direct_linker_dynamic ("url0","m=default&s=cache&dsd=dfile+$direct_settings[path_themes]/$direct_settings[theme]/".$f_list[$f_i]['attributes']['image'],true,false); }
				else { $f_list[$f_i]['attributes']['image'] = ""; }
			}
			else { $f_list[$f_i]['attributes']['image'] = ""; }

			$f_services_array = array ($f_list[$f_i]['attributes']['image'],$f_list[$f_i]['value'],$f_list[$f_i]['attributes']['link']['value'],$f_list[$f_i]['attributes']['description']);
			$f_return['list'][] = $f_services_array;
		}
	}

	return $f_return;
}

//f// direct_service_list_search ($f_module,$f_sstring,$f_smode = "title-desc_preg",$f_page = 1)
/**
* Reads and parses a service list XML file. Returns only results matching
* the search criteria.
*
* @param  string $f_module Service list module name
* @param  string $f_sstring User defined search string to use
* @param  string $f_smode Search mode to use
* @param  integer $f_page Requested page if multiple exist
* @uses   direct_basic_functions::memcache_get_file_merged_xml()
* @uses   direct_class_function_check()
* @uses   direct_debug()
* @uses   direct_kernel_system::v_group_user_check_right()
* @uses   direct_kernel_system::v_usertype_get_int()
* @uses   direct_service_list_parse()
* @uses   USE_debug_reporting
* @return array Returns a multi dimensional array containing list information
*         and the ready to output service list
* @since  v0.1.00
*/
function direct_service_list_search ($f_module,$f_sstring,$f_smode = "title_preg",$f_page = 1)
{
	global $direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_service_list_search ($f_module,$f_page)- (#echo(__LINE__)#)"); }

	$f_module = preg_replace ("#[\/\\\?:@\=\&\. \+]#i","",$f_module);
	$f_module_file_name = str_replace (";","_",$f_module);
	$f_return = array ();
	if (($f_smode == "title_preg")||($f_smode == "title-desc_preg")) { $f_sstring = str_replace ("\*","(.+?)",("#".(preg_quote ($f_sstring,"#"))."#si")); }

	if (file_exists ($direct_settings['path_data']."/settings/swg_{$f_module_file_name}.services.xml")) { $f_xml_array = $direct_classes['basic_functions']->memcache_get_file_merged_xml ($direct_settings['path_data']."/settings/swg_{$f_module_file_name}.services.xml"); }
	else { $f_xml_array = array (); }

	if ((is_array ($f_xml_array))&&(!empty ($f_xml_array)))
	{
		$f_services_array = array ();

		foreach ($f_xml_array as $f_tag => $f_xml_node_array)
		{
			if ((isset ($f_xml_node_array['attributes']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_xml_node_array['attributes']['active']))&&($f_xml_node_array['attributes']['active']))
			{
				$f_continue_check = true;
				$f_search_check = false;

				if ($f_xml_array[$f_tag."_title"])
				{
					$f_xml_node_array['value'] = direct_string_translation ($f_module,$f_xml_array[$f_tag."_title"]['value']);
					
					if (($f_smode == "title_preg")||($f_smode == "title-desc_preg"))
					{
						if (preg_match ($f_sstring,$f_xml_node_array['value'])) { $f_search_check = true; }
					}
					else { $f_search_check = /*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_xml_node_array['value'],$f_sstring); }
				}
				else { $f_continue_check = false; }

				if ($f_xml_array[$f_tag."_description"])
				{
					$f_xml_node_array['attributes']['description'] = direct_string_translation ($f_module,$f_xml_array[$f_tag."_description"]['value']);

					if ($f_search_check === false)
					{
						switch ($f_smode)
						{
						case "title-desc_exact":
						{
							$f_search_check = /*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_xml_node_array['attributes']['description'],$f_sstring);
							break 1;
						}
						case "title-desc_preg":
						{
							if (preg_match ($f_sstring,$f_xml_node_array['attributes']['description'])) { $f_search_check = true; }
							break 1;
						}
						}
					}
				}

				if ($f_search_check !== false)
				{
					if ($f_xml_node_array['attributes']['lang'])
					{
						if ($f_xml_node_array['attributes']['lang'] != $direct_settings['lang']) { $f_continue_check = false; }
					}

					if ($f_xml_array[$f_tag."_image"]) { $f_xml_node_array['attributes']['image'] = $f_xml_array[$f_tag."_image"]['value']; }

					if ($f_xml_array[$f_tag."_link"]) { $f_xml_node_array['attributes']['link'] = $f_xml_array[$f_tag."_link"]; }
					else { $f_continue_check = false; }

					$f_right_check = false;

					if ($f_xml_array[$f_tag."_guests"])
					{
						if (($f_xml_array[$f_tag."_guests"]['value'])&&($direct_settings['user']['type'] == "gt")) { $f_right_check = true; }
					}

					if ($f_xml_array[$f_tag."_members"])
					{
						if (($f_xml_array[$f_tag."_members"]['value'])&&(direct_class_function_check ($direct_classes['kernel'],"v_usertype_get_int")))
						{
							if ($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type'])) { $f_right_check = true; }
						}
					}

					if ((!$f_right_check)&&($f_xml_array[$f_tag."_group_right"]))
					{
						if (direct_class_function_check ($direct_classes['kernel'],"v_group_user_check_right"))
						{
							if (isset ($f_xml_array[$f_tag."_group_right"]['value']))
							{
								if ($f_xml_array[$f_tag."_group_right"]['value']) { $f_right_check = $direct_classes['kernel']->v_group_user_check_right ($f_xml_array[$f_tag."_group_right"]['value']); }
							}
							elseif (is_array ($f_xml_array[$f_tag."_group_right"]))
							{
								$f_group_rights_array = array ();

								foreach ($f_xml_array[$f_tag."_group_right"] as $f_group_right_array)
								{
									if (strlen ($f_group_right_array['value'])) { $f_group_rights_array[] = $f_group_right_array['value']; }
								}

								$f_right_check = $direct_classes['kernel']->v_group_user_check_right ($f_group_rights_array);
							}
						}
					}

					if (($f_continue_check)&&($f_right_check))
					{
						if ((isset ($f_xml_node_array['attributes']['position']))&&(!isset ($f_services_array[$f_xml_node_array['attributes']['position']]))) { $f_services_array[$f_xml_node_array['attributes']['position']] = $f_xml_node_array; }
						else { $f_services_array[] = $f_xml_node_array; }
					}
				}
			}
		}

		if (!empty ($f_services_array)) { $f_return = direct_service_list_parse ($f_module,(array_values ($f_services_array)),$f_page); }
	}
	else
	{
		$f_return['data'] = array ("page" => 1, "pages" => 1);
		$f_return['list'] = array ();
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_service_list_search ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// Script specific commands

if (!isset ($direct_settings['swg_services_per_page'])) { $direct_settings['swg_services_per_page'] = 20; }

//j// EOF
?>