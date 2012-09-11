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
* osets/default/mods/swgi_mods_support.php
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
* Include the OSet data returned from the given modifications.
*
* @param  string $f_modname Modification name
* @param  array $f_modlist List of activated modifications.
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_oset_mods_include ($f_modname,$f_modlist)
{
	global $direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_oset_mods_include ($f_modname,+f_modlist)- (#echo(__LINE__)#)"); }

	$f_return = "";

	if ((is_array ($f_modlist))&&(!empty ($f_modlist)))
	{
		foreach ($f_modlist as $f_mod)
		{
			if (file_exists ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/mods/$f_modname/swgi_$f_mod.php"))
			{
				$direct_globals['basic_functions']->includeFile ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/mods/$f_modname/swgi_$f_mod.php");

				$f_function = "direct_oset_mods_{$f_modname}_".$f_mod;
				if (function_exists ($f_function)) { $f_return .= $f_function (); }
			}
		}
	}

	return $f_return;
}

//j// EOF
?>