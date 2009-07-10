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
* validation/swg_index.php
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
* @subpackage validation
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

if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }

$g_vid = (isset ($direct_settings['dsd']['idata']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['idata'])) : "");
$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['source'])) : "");
$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['target'])) : "");

if ($g_source) { $g_source_url = base64_decode ($g_source); }
else { $g_source_url = ""; }

if ($g_target) { $g_target_url = base64_decode ($g_target); }
else
{
	$g_target = $g_source;
	$g_target_url = $g_source_url;
}

if ($direct_classes['kernel']->service_init_default ())
{
//j// BOA
$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_data_storager.php");
$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php");
direct_local_integration ("validation");

$direct_cachedata['page_this'] = "m=validation&dsd=idata+".$g_vid;
$direct_cachedata['page_backlink'] = "";
$direct_cachedata['page_homelink'] = "";

if (trim ($g_vid))
{
	$g_vid_array = direct_tmp_storage_get ("evars",$g_vid,"a617908b172c473cb8e8cda059e55bf0");
	// md5 ("validation")

	if ($g_vid_array)
	{
		if (file_exists ($direct_settings['path_system']."/modules/validation/swgi_{$g_vid_array['core_vid_module']}.php"))
		{
			$direct_cachedata['validation_data'] = $g_vid_array;
			$direct_cachedata['validation_error'] = array ();
			$direct_cachedata['validation_remove_vid'] = true;

			include_once ($direct_settings['path_system']."/modules/validation/swgi_{$g_vid_array['core_vid_module']}.php");
			if ($direct_cachedata['validation_remove_vid']) { direct_tmp_storage_write ("",$g_vid,"","","s"); }

			if (empty ($direct_cachedata['validation_error']))
			{
				direct_class_init ("output");

				$direct_cachedata['output_job'] = direct_local_get ("validation_job");
				$direct_cachedata['output_job_desc'] = direct_local_get ("validation_done_job");

				if ($g_target_url)
				{
					$g_target_link = str_replace ("[oid]","vid_d+{$g_vid}++",$g_target_url);

					$direct_cachedata['output_jsjump'] = 5000;
					$direct_cachedata['output_pagetarget'] = str_replace ('"',"",(direct_linker ("url0",$g_target_link)));
					$direct_cachedata['output_scripttarget'] = str_replace ('"',"",(direct_linker ("url0",$g_target_link,false)));
				}
				else
				{
					$direct_cachedata['output_jsjump'] = 0;
					$direct_cachedata['output_pagetarget'] = direct_linker ("url0","a=index");
				}

				$direct_classes['output']->oset ("default","done");
				$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
				$direct_classes['output']->page_show ($direct_cachedata['output_job']);
			}
			else
			{
				if (is_array ($direct_cachedata['validation_error'])) { $direct_classes['error_functions']->error_page ("standard",$direct_cachedata['validation_error'][0],$direct_cachedata['validation_error'][1]); }
				else { $direct_classes['error_functions']->error_page ("standard","validation_unknown_type","FATAL ERROR:<br />The specified vID requires the error reporting module &quot;{$g_vid_array['vid_module']}&quot;<br />sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }
			}
		}
		else { $direct_classes['error_functions']->error_page ("standard","validation_unknown_type","FATAL ERROR:<br />The specified vID requires the unknown module &quot;{$g_vid_array['vid_module']}&quot;<br />sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }
	}
	else { $direct_classes['error_functions']->error_page ("standard","validation_vid_invalid","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }
}
else { $direct_classes['error_functions']->error_page ("standard","validation_vid_invalid","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }
//j// EOA
}

$direct_cachedata['core_service_activated'] = true;

//j// EOF
?>