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
* developer/swg_translations.php
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

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "select"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// ($direct_settings['a'] == "form")||($direct_settings['a'] == "form-save")
case "form":
case "form-save":
{
	$g_mode_save = (($direct_settings['a'] == "form-save") ? true : false);
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }

	if ($g_mode_save)
	{
		$g_tfile = (isset ($direct_settings['dsd']['tfile']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['tfile'])) : "");
		$g_tlang = (isset ($direct_settings['dsd']['tlang']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['tlang'])) : "");

		$direct_cachedata['page_this'] = "";
		$direct_cachedata['page_backlink'] = "m=developer&s=translations&dsd=tfile+{$g_tfile}++tlang+".$g_tlang;
		$direct_cachedata['page_homelink'] = "m=developer&a=services";
	}
	else
	{
		$g_tfile = (isset ($GLOBALS['i_tfile']) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS['i_tfile'])) : "");
		$g_tlang = ((isset ($GLOBALS['i_tlang']) && (is_array ($GLOBALS['i_tlang']))) ? (implode (",",$GLOBALS['i_tlang'])) : "");

		$direct_cachedata['page_this'] = "m=developer&s=translations&dsd=tfile+{$g_tfile}++tlang+".$g_tlang;
		$direct_cachedata['page_backlink'] = "m=developer&a=services";
		$direct_cachedata['page_homelink'] = "m=developer&a=services";
	}

	if ($direct_classes['kernel']->service_init_default ())
	{
	//j// BOA
	if ($g_mode_save) { direct_output_related_manager ("developer_translations_form_save","pre_module_service_action"); }
	else { direct_output_related_manager ("developer_translations_form","pre_module_service_action"); }

	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formbuilder.php");
	direct_local_integration ("developer");

	if ($g_mode_save) { $direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_xml.php"); }

	direct_class_init ("formbuilder");
	direct_class_init ("output");
	$direct_classes['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

	$g_languages_array = array ();
	$g_languages_installed_array = array ();
	$g_languages_translated_array = array ();

	if (file_exists ($direct_settings['path_data']."/lang/swg_languages_installed.xml"))
	{
		$g_file_content = direct_file_get ("s0",$direct_settings['path_data']."/lang/swg_languages_installed.xml");
		if ($g_file_content) { $g_languages_installed_array = direct_evars_get ($g_file_content); }
	}

	if (($g_languages_installed_array)&&(file_exists ($direct_settings['path_data']."/lang/swg_language_table.xml")))
	{
		$g_file_content = direct_file_get ("s0",$direct_settings['path_data']."/lang/swg_language_table.xml");
		if ($g_file_content) { $g_languages_translated_array = direct_evars_get ($g_file_content); }
	}

	$g_tlang_array = explode (",",$g_tlang);

	if ($g_languages_translated_array)
	{
		foreach ($g_languages_installed_array as $g_language_id)
		{
			if (in_array ($g_language_id,$g_tlang_array))
			{
				if (isset ($g_languages_translated_array[$g_language_id])) { $g_languages_array[$g_language_id] = (direct_html_encode_special ($g_languages_translated_array[$g_language_id]['national']))." (".(direct_html_encode_special ($g_languages_translated_array[$g_language_id]['international'])).")"; }
			}
		}
	}

	$g_tfile = preg_replace ("#\W#","",$g_tfile);
	$g_tlang_array = array_keys ($g_languages_array);
	$g_tlang = implode (",",$g_tlang_array);

	if ((!empty	($g_languages_array))&&(file_exists ($direct_settings['path_lang']."/swg_$g_tfile.xml")))
	{
		$t_translations_array = array ();

		foreach ($g_languages_array as $g_language_id => $g_language)
		{
			if (file_exists ($direct_settings['path_lang']."/swg_$g_tfile.$g_language_id.xml"))
			{
				$g_file_content = direct_file_get ("s",$direct_settings['path_lang']."/swg_$g_tfile.$g_language_id.xml");
				$g_translation_array = $direct_classes['xml_bridge']->xml2array ($g_file_content,false);
				$t_translations_array[$g_language_id] = $g_translation_array;
			}
			else { $t_translations_array[$g_language_id] = array (); }
		}

		$g_file_content = direct_file_get ("s",$direct_settings['path_lang']."/swg_$g_tfile.xml");
		$t_translation_elements_array = $direct_classes['xml_bridge']->xml2array ($g_file_content,false);
		$g_continue_check = ((empty ($t_translation_elements_array)) ? false : true);
	}
	else { $g_continue_check = false; }

	if ($g_continue_check)
	{
/* -------------------------------------------------------------------------
Build the form
------------------------------------------------------------------------- */

		if ($g_mode_save)
		{
/* -------------------------------------------------------------------------
We should have input in save mode
------------------------------------------------------------------------- */

			$g_xml_object = new direct_xml ();

			foreach ($t_translation_elements_array as $g_element_id => $g_element_node_array)
			{
				if (isset ($g_element_node_array['attributes']['input']))
				{
					$g_element_id = preg_replace ("#^swg_lang_file_v1_#","",$g_element_id);
					if ($g_element_node_array['tag'] == "input") { $g_element_id = preg_replace ("#_input$#","",$g_element_id); }

					$direct_classes['formbuilder']->entry_add ("subtitle","t".$g_element_id,$g_element_id);

					foreach ($g_languages_array as $g_language_id => $g_language)
					{
						if ($g_element_node_array['attributes']['input'] == "number")
						{
							$direct_cachedata["i_t{$g_element_id}_".$g_language_id] = (isset ($GLOBALS["i_t{$g_element_id}_".$g_language_id]) ? ($direct_classes['basic_functions']->inputfilter_number ($GLOBALS["i_t{$g_element_id}_".$g_language_id])) : 0);
							if (!$direct_cachedata["i_t{$g_element_id}_".$g_language_id]) { $direct_cachedata["i_t{$g_element_id}_".$g_language_id] = 0; }

							$direct_classes['formbuilder']->entry_add_number ("t{$g_element_id}_".$g_language_id,$g_language,false,"s");
						}
						else
						{
							$direct_cachedata["i_t{$g_element_id}_".$g_language_id] = (isset ($GLOBALS["i_t{$g_element_id}_".$g_language_id]) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS["i_t{$g_element_id}_".$g_language_id])) : "");
							$direct_classes['formbuilder']->entry_add_text ("t{$g_element_id}_".$g_language_id,$g_language,false,"l");
						}

						$g_xml_node_path = $g_language_id." swg_lang_file_v1 ".(str_replace ("_"," ",$g_element_id));

						if ($g_element_node_array['tag'] == "input")
						{
							$g_element_input = $direct_cachedata["i_t{$g_element_id}_".$g_language_id];
							$g_element_input_html = direct_html_encode_special ($direct_cachedata["i_t{$g_element_id}_".$g_language_id]);

							if ($g_element_input == $g_element_input_html) { $g_xml_object->node_add ($g_xml_node_path." universal",$g_element_input,(array ("xml:space" => "preserve"))); }
							else
							{
								$g_xml_object->node_add ($g_xml_node_path." html",$g_element_input_html,(array ("xml:space" => "preserve")));
								$g_xml_object->node_add ($g_xml_node_path." text",$g_element_input,(array ("xml:space" => "preserve")));
							}
						}
						else { $g_xml_object->node_add ($g_xml_node_path,$direct_cachedata["i_t{$g_element_id}_".$g_language_id],(array ("xml:space" => "preserve"))); }
					}
				}
			}
		}
		else
		{
			foreach ($t_translation_elements_array as $g_element_id => $g_element_node_array)
			{
				if (isset ($g_element_node_array['attributes']['input']))
				{
					$g_element_id = preg_replace ("#^swg_lang_file_v1_#","",$g_element_id);
					if ($g_element_node_array['tag'] == "input") { $g_element_id = preg_replace ("#_input$#","",$g_element_id); }

					$direct_classes['formbuilder']->entry_add ("subtitle","t".$g_element_id,$g_element_id);

					foreach ($g_languages_array as $g_language_id => $g_language)
					{
						if ($g_element_node_array['tag'] == "input")
						{
							if (isset ($t_translations_array[$g_language_id]["swg_lang_file_v1_{$g_element_id}_universal"])) { $direct_cachedata["i_t{$g_element_id}_".$g_language_id] = $t_translations_array[$g_language_id]["swg_lang_file_v1_{$g_element_id}_universal"]['value']; }
							elseif (isset ($t_translations_array[$g_language_id]["swg_lang_file_v1_{$g_element_id}_text"])) { $direct_cachedata["i_t{$g_element_id}_".$g_language_id] = $t_translations_array[$g_language_id]["swg_lang_file_v1_{$g_element_id}_text"]['value']; }
							else { $direct_cachedata["i_t{$g_element_id}_".$g_language_id] = ""; }
						}
						else { $direct_cachedata["i_t{$g_element_id}_".$g_language_id] = ((isset ($t_translations_array[$g_language_id]["swg_lang_file_v1_".$g_element_id])) ? $t_translations_array[$g_language_id]["swg_lang_file_v1_".$g_element_id]['value'] : ""); }

						if ($g_element_node_array['attributes']['input'] == "number") { $direct_classes['formbuilder']->entry_add_number ("t{$g_element_id}_".$g_language_id,$g_language,false,"s"); }
						else { $direct_classes['formbuilder']->entry_add_text ("t{$g_element_id}_".$g_language_id,$g_language,false,"l"); }
					}
				}
			}
		}

		$direct_cachedata['output_formelements'] = $direct_classes['formbuilder']->form_get ($g_mode_save);

		if (($g_mode_save)&&($direct_classes['formbuilder']->check_result))
		{
			foreach ($g_languages_array as $g_language_id => $g_language)
			{
				$g_xml_object->node_change_attributes ($g_language_id." swg_lang_file_v1",(array ("xmlns" => "urn:de.direct-netware.xmlns:swg.lang.v1")));
				$g_language_array = $g_xml_object->node_get ($g_language_id);

				if (!empty ($g_language_array))
				{
					$g_file_content = "<?xml version='1.0' encoding='$direct_local[lang_charset]' ?>";
					$g_file_content .= $g_xml_object->array2xml ($g_language_array,false);
					$direct_classes['basic_functions']->memcache_write_file ($g_file_content,$direct_settings['path_lang']."/swg_$g_tfile.$g_language_id.xml","s0");
				}
			}

			$direct_cachedata['output_job'] = direct_local_get ("developer_translations_form");
			$direct_cachedata['output_job_desc'] = direct_local_get ("developer_done_translations_saved");
			$direct_cachedata['output_jsjump'] = 2000;
			$direct_cachedata['output_pagetarget'] = direct_linker ("url0","m=developer&s=translations");
			$direct_cachedata['output_scripttarget'] = direct_linker ("url0","m=developer&s=translations",false);

			direct_output_related_manager ("developer_translations_form_save","post_module_service_action");
			$direct_classes['output']->oset ("default","done");
			$direct_classes['output']->options_flush (true);
			$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_classes['output']->page_show ($direct_cachedata['output_job']);
		}
		else
		{
			$direct_cachedata['output_formbutton'] = direct_local_get ("core_continue");
			$direct_cachedata['output_formtarget'] = "m=developer&s=translations&a=form-save&dsd=tfile+$g_tfile++tlang+".$g_tlang;
			$direct_cachedata['output_formtitle'] = direct_local_get ("developer_translations_form");

			direct_output_related_manager ("developer_translations_form","post_module_service_action");
			$direct_classes['output']->oset ("default","form");
			$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_classes['output']->page_show ($direct_cachedata['output_formtitle']);
		}
	}
	else { $direct_classes['error_functions']->error_page ("standard","developer_translations_file_invalid","sWG/#echo(__FILEPATH__)# _a=form_ (#echo(__LINE__)#)"); }
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// $direct_settings['a'] == "select"
case "select":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=select_ (#echo(__LINE__)#)"); }

	$direct_cachedata['page_this'] = "m=developer&s=translations";
	$direct_cachedata['page_backlink'] = "m=developer&a=services";
	$direct_cachedata['page_homelink'] = "m=developer&a=services";

	if ($direct_classes['kernel']->service_init_default ())
	{
	//j// BOA
	direct_output_related_manager ("developer_translations_select","pre_module_service_action");
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formbuilder.php");
	direct_local_integration ("developer");

	direct_class_init ("formbuilder");
	direct_class_init ("output");
	$direct_classes['output']->options_insert (2,"servicemenu","m=developer&a=services",(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

	$g_dir_pointer = @opendir ($direct_settings['path_lang']);

	if ($g_dir_pointer)
	{
		$g_tfiles_array = array ();

		while ($g_dir = readdir ($g_dir_pointer))
		{
			if (preg_match ("#swg_([\w]+).xml#i",$g_dir,$g_result_array)) { $g_tfiles_array[] = $g_result_array[1]; }
		}

		closedir ($g_dir_pointer);

		$direct_cachedata['i_tfile'] = "<evars>";

		if ($g_tfiles_array)
		{
			natsort ($g_tfiles_array);
			foreach ($g_tfiles_array as $g_tfile) { $direct_cachedata['i_tfile'] .= "<s$g_tfile><value value='$g_tfile' /></s$g_tfile>"; }
		}

		$direct_cachedata['i_tfile'] .= "</evars>";

		$g_languages_installed_array = array ();
		$g_languages_translated_array = array ();

		if (file_exists ($direct_settings['path_data']."/lang/swg_languages_installed.xml"))
		{
			$g_file_content = direct_file_get ("s0",$direct_settings['path_data']."/lang/swg_languages_installed.xml");
			if ($g_file_content) { $g_languages_installed_array = direct_evars_get ($g_file_content); }
		}

		if (($g_languages_installed_array)&&(file_exists ($direct_settings['path_data']."/lang/swg_language_table.xml")))
		{
			$g_file_content = direct_file_get ("s0",$direct_settings['path_data']."/lang/swg_language_table.xml");
			if ($g_file_content) { $g_languages_translated_array = direct_evars_get ($g_file_content); }
		}

		if ($g_languages_translated_array)
		{
			$direct_cachedata['i_tlang'] = "<evars>";

			foreach ($g_languages_installed_array as $g_language_id)
			{
				$direct_cachedata['i_tlang'] .= (($g_language_id == $direct_settings['lang']) ? "<l$g_language_id><value value='$g_language_id' /><selected value='1' />" : "<l$g_language_id><value value='$g_language_id' />");
				if (isset ($g_languages_translated_array[$g_language_id])) { $direct_cachedata['i_tlang'] .= "<text><![CDATA[".(direct_html_encode_special ($g_languages_translated_array[$g_language_id]['national']))." (".(direct_html_encode_special ($g_languages_translated_array[$g_language_id]['international'])).")]]></text>"; }
				$direct_cachedata['i_tlang'] .= "</l$g_language_id>";
			}

			$direct_cachedata['i_tlang'] .= "</evars>";
		}
		else { $direct_cachedata['i_alang'] = "<evars><$direct_settings[lang]><value value='$direct_settings[lang]' /><selected value='1' /></$direct_settings[lang]></evars>"; }

		$direct_classes['formbuilder']->entry_add_select ("tfile",(direct_local_get ("developer_translations_file")),true,"l");
		$direct_classes['formbuilder']->entry_add_multiselect ("tlang",(direct_local_get ("developer_translations_languages")),true,"m");

		$direct_cachedata['output_formbutton'] = direct_local_get ("core_continue");
		$direct_cachedata['output_formelements'] = $direct_classes['formbuilder']->form_get (false);
		$direct_cachedata['output_formtarget'] = "m=developer&s=translations&a=form";
		$direct_cachedata['output_formtitle'] = direct_local_get ("developer_translations_select");

		direct_output_related_manager ("developer_translations_select","post_module_service_action");
		$direct_classes['output']->oset ("default","form");
		$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
		$direct_classes['output']->page_show ($direct_cachedata['output_formtitle']);
	}
	else { $direct_classes['error_functions']->error_page ("standard","developer_translations_dir_invalid","sWG/#echo(__FILEPATH__)# _a=select_ (#echo(__LINE__)#)"); }
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>