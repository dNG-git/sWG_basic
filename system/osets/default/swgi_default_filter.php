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
* osets/default/swgi_default_filter.php
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

/**
* Generates the filter form for inclusion.
*
* @param  boolean $g_js_mode True to return JavaScript code instead of
*         simple (X)HTML
* @param  string $f_ipoint_id iPoint ID to be used for this form
* @param  string $f_button Button text
* @param  string $f_text Predefined filter text to be shown
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_default_filter_content ($g_js_mode,$f_ipoint_id,$f_button,$f_text)
{
	global $direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_oset_developer_input_result ()- (#echo(__LINE__)#)"); }

	$direct_globals['output']->headerElements ("<script src='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_mmedia]/swg_filter.php.js++dbid+".$direct_settings['product_buildid'],true,false))."' type='text/javascript'></script><!-- // FormBuilder javascript functions // -->","script_filter");
	$direct_globals['output']->headerElements ("<script src='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_mmedia]/swg_formbuilder.php.js++dbid+".$direct_settings['product_buildid'],true,false))."' type='text/javascript'></script><!-- // FormBuilder javascript functions // -->","script_formbuilder");

	$f_return = "<p id=\"$f_ipoint_id\" style='padding:{$direct_settings['theme_form_td_padding']};text-align:center'><label for='{$f_ipoint_id}i'><strong>".(direct_local_get ("core_filter","text")).":</strong></label> <input type='text' id='{$f_ipoint_id}i' value=\"$f_text\" size='18' class='pagecontentinputtextnpassword' style='width:55%' /> <input type='button' id='{$f_ipoint_id}b' value=\"$f_button\" class='pagecontentinputbutton' /></p>";
	if ($g_js_mode) { $f_return = "\"".(str_replace ('"','\"',$f_return))."\""; }

	return $f_return;
}

//j// Script specific commands

if (!isset ($direct_settings['theme_form_td_padding'])) { $direct_settings['theme_form_td_padding'] = "3px"; }
direct_local_integration ("formbuilder");

//j// EOF
?>