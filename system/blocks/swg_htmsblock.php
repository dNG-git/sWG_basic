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
* Read, parse and prepare a FormTags HTML block for output.
*
* @param  array $f_options Array with parameters from the block call
* @return string Parsed (X)HTML snipplet or an empty string on error
* @since  v0.1.00
*/
function direct_output_block_htmsblock ($f_options)
{
	global $direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_block_htmsblock (+f_options)- (#echo(__LINE__)#)"); }

	$f_return = "";

	if ((isset ($direct_globals['formtags']))||(($direct_globals['basic_functions']->includeClass ('dNG\sWG\directFormtags'))&&(direct_class_init ("formtags"))))
	{
		if (file_exists ($direct_settings['path_data']."/settings/swg_{$f_options[0]}.htmsblock.$direct_settings[lang].php")) { $f_return = $direct_globals['formtags']->decode (direct_file_get ("s",$direct_settings['path_data']."/settings/swg_{$f_options[0]}.htmsblock.$direct_settings[lang].php")); }
		elseif (file_exists ($direct_settings['path_data']."/settings/swg_{$f_options[0]}.htmsblock.$direct_settings[swg_lang].php")) { $f_return = $direct_globals['formtags']->decode (direct_file_get ("s",$direct_settings['path_data']."/settings/swg_{$f_options[0]}.htmsblock.$direct_settings[swg_lang].php")); }
		elseif (file_exists ($direct_settings['path_data']."/settings/swg_{$f_options[0]}.htmsblock.php")) { $f_return = $direct_globals['formtags']->decode (direct_file_get ("s",$direct_settings['path_data']."/settings/swg_{$f_options[0]}.htmsblock.php")); }
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_output_block_htmsblock ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// EOF
?>