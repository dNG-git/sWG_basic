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
$Id: swg_language.php,v 1.5 2009/01/09 12:54:37 s4u Exp $
#echo(sWGbasicVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* account/swg_language.php
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
* @subpackage account
* @uses       direct_product_iversion
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

//j// Basic configuration

if (!defined ("direct_product_iversion")) { exit (); }

//j// Script specific commands

if (!isset ($direct_settings['account_https_language'])) { $direct_settings['account_https_language'] = false; }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGbasicVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "select"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// ($direct_settings['a'] == "select")||($direct_settings['a'] == "select-save")
case "select":
case "select-save":
{
	if ($direct_settings['a'] == "select-save") { $g_mode_save = true; }
	else { $g_mode_save = false; }

	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }

	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['source'])) : "");
	$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['target'])) : "");

	if ($g_source) { $g_source_url = base64_decode ($g_source); }
	else { $g_source_url = "m=account&a=services[lang]"; }

	if ($g_target) { $g_target_url = base64_decode ($g_target); }
	else
	{
		$g_target = $g_source;
		$g_target_url = $g_source_url;
	}

	if ($g_mode_save)
	{
		$direct_cachedata['page_this'] = "";
		$direct_cachedata['page_backlink'] = "m=account&s=forgotten_password&a=form&dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_homelink'] = str_replace (array ("[oid]","[lang]"),"",$g_source_url);
	}
	else
	{
		$direct_cachedata['page_this'] = "m=account&s=forgotten_password&a=form&dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_backlink'] = str_replace (array ("[oid]","[lang]"),"",$g_source_url);
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'] ;
	}

	if ($direct_classes['kernel']->service_init_default ())
	{
	//j// BOA
	if ($g_mode_save) { direct_output_related_manager ("account_language_select_save","pre_module_service_action"); }
	else
	{
		direct_output_related_manager ("account_language_select","pre_module_service_action");
		$direct_classes['kernel']->service_https ($direct_settings['account_https_language'],$direct_cachedata['page_this']);
	}

	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formbuilder.php");
	direct_local_integration ("account");

	direct_class_init ("formbuilder");
	direct_class_init ("output");
	$direct_classes['output']->servicemenu ("account");
	$direct_classes['output']->options_insert (2,"servicemenu","m=account&a=services",(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

	if (!$g_mode_save)
	{
		$g_languages_installed_array = array ();
		$g_languages_array = array ();

		if (file_exists ($direct_settings['path_data']."/lang/swg_languages_installed.xml"))
		{
			$g_file_data = direct_file_get ("s0",$direct_settings['path_data']."/lang/swg_languages_installed.xml");
			if ($g_file_data) { $g_languages_installed_array = direct_evars_get ($g_file_data); }
		}

		if (($g_languages_installed_array)&&(file_exists ($direct_settings['path_data']."/lang/swg_language_table.xml")))
		{
			$g_file_data = direct_file_get ("s0",$direct_settings['path_data']."/lang/swg_language_table.xml");
			if ($g_file_data) { $g_languages_array = direct_evars_get ($g_file_data); }
		}

		if ($g_languages_array)
		{
			$direct_cachedata['i_alang'] = "<evars>";

			foreach ($g_languages_installed_array as $g_language)
			{
				if ($g_language == $direct_settings['lang']) { $direct_cachedata['i_alang'] .= "<$g_language><value value='$g_language' /><selected value='1' />"; }
				else { $direct_cachedata['i_alang'] .= "<$g_language><value value='$g_language' />"; }

				if (isset ($g_languages_array[$g_language])) { $direct_cachedata['i_alang'] .= "<text><![CDATA[".(direct_html_encode_special ($g_languages_array[$g_language]['national']))."]]></text>"; }
				$direct_cachedata['i_alang'] .= "</$g_language>";
			}

			$direct_cachedata['i_alang'] .= "</evars>";
		}
		else { $direct_cachedata['i_alang'] = "<evars><$direct_settings[lang]><value value='$direct_settings[lang]' /><selected value='1' /></$direct_settings[lang]></evars>"; }

		$direct_classes['formbuilder']->entry_add_radio ("alang",(direct_local_get ("account_language")),true);
		$direct_cachedata['output_formelements'] = $direct_classes['formbuilder']->form_get (false);
	}

	if (($g_mode_save)&&(isset ($GLOBALS['i_alang'])))
	{
		$g_language = preg_replace ("#\W+#i","",$GLOBALS['i_alang']);
		if (file_exists ($direct_settings['path_lang']."/swg_account.$g_language.xml")) { $direct_settings['lang'] = $g_language; }

		direct_local_integration ("core","en",true);
		direct_local_integration ("account","en",true);

		$direct_cachedata['output_job'] = direct_local_get ("account_language_select");
		$direct_cachedata['output_job_desc'] = direct_local_get ("account_done_language_select");

		if ($g_target_url)
		{
			$g_target_link = str_replace (array ("[oid]","[lang]"),(array ("","&lang=".$g_lang)),$g_target_url);

			$direct_cachedata['output_jsjump'] = 2000;
			$direct_cachedata['output_pagetarget'] = str_replace ('"',"",(direct_linker ("url0",$g_target_link)));
			$direct_cachedata['output_scripttarget'] = str_replace ('"',"",(direct_linker ("url0",$g_target_link,false)));
		}
		else { $direct_cachedata['output_jsjump'] = 0; }

		direct_output_related_manager ("account_language_select_save","post_module_service_action");
		$direct_classes['output']->oset ("default","done");
		$direct_classes['output']->options_flush (true);
		$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
		$direct_classes['output']->page_show ($direct_cachedata['output_job']);
	}
	else
	{
		$direct_cachedata['output_formbutton'] = direct_local_get ("core_continue");
		$direct_cachedata['output_formtarget'] = "m=account&s=language&a=select-save&dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['output_formtitle'] = direct_local_get ("account_language_select");

		direct_output_related_manager ("account_language_select","post_module_service_action");
		$direct_classes['output']->oset ("default","form");
		$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
		$direct_classes['output']->page_show ($direct_cachedata['output_formtitle']);
	}
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>