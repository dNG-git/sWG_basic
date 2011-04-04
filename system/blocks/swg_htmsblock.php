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
* The "htmsblock" returns a (X)HTML snipplet (from a file).
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

//j// Functions and classes

//f// direct_output_block_htmsblock ($f_options)
/**
* Read, parse and prepare a FormTags HTML block for output.
*
* @param  array $f_options Array with parameters from the block call
* @uses   direct_basic_functions::include_file()
* @uses   direct_class_init()
* @uses   direct_debug()
* @uses   direct_file_get()
* @uses   direct_formtags::decode()
* @uses   USE_debug_reporting
* @return string Parsed (X)HTML snipplet or an empty string on error
* @since  v0.1.00
*/
function direct_output_block_htmsblock ($f_options)
{
	global $direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_block_htmsblock (+f_options)- (#echo(__LINE__)#)"); }

	$f_continue_check = $direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_formtags.php");
	if (($f_continue_check)&&(!isset ($direct_globals['formtags']))) { $f_continue_check = direct_class_init ("formtags"); }
	$f_return = "";

	if ($f_continue_check)
	{
		if (file_exists ($direct_settings['path_data']."/settings/swg_{$f_options[0]}.htmsblock.$direct_settings[lang].php")) { $f_return = $direct_globals['formtags']->decode (direct_file_get ("s",$direct_settings['path_data']."/settings/swg_{$f_options[0]}.htmsblock.$direct_settings[lang].php")); }
		elseif (file_exists ($direct_settings['path_data']."/settings/swg_{$f_options[0]}.htmsblock.$direct_settings[swg_lang].php")) { $f_return = $direct_globals['formtags']->decode (direct_file_get ("s",$direct_settings['path_data']."/settings/swg_{$f_options[0]}.htmsblock.$direct_settings[swg_lang].php")); }
		elseif (file_exists ($direct_settings['path_data']."/settings/swg_{$f_options[0]}.htmsblock.php")) { $f_return = $direct_globals['formtags']->decode (direct_file_get ("s",$direct_settings['path_data']."/settings/swg_{$f_options[0]}.htmsblock.php")); }
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_output_block_htmsblock ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// EOF
?>