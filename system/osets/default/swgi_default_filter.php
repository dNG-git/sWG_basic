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
$Id: swgi_default_filter.php,v 1.1 2008/12/20 22:49:47 s4u Exp $
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

//f// direct_output_oset_default_filter_table ($g_js_mode,$f_ipoint_id,$f_button,$f_button_onclick,$f_text)
/**
* Generates the filter form for inclusion.
*
* @param  boolean $g_js_mode True to return JavaScript code instead of
*         simple (X)HTML
* @param  string $f_ipoint_id iPoint ID to be used for this form
* @param  string $f_button Button text
* @param  string $f_button_onclick Javascript to be called on the button
*         clicked event
* @param  string $f_text Predefined filter text to be shown
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_default_filter_table ($g_js_mode,$f_ipoint_id,$f_button,$f_button_onclick,$f_text)
{
	global $direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_oset_developer_input_result ()- (#echo(__LINE__)#)"); }

$f_return = ("<table id=\"$f_ipoint_id\" cellspacing='1' summary='' class='pageborder1' style='width:100%;table-layout:fixed'>
<thead class='pagehide'><tr>
<td valign='middle' align='center' class='pagetitlecellbg' style='width:25%;padding:$direct_settings[theme_td_padding]'><span class='pagetitlecellcontent'>".(direct_local_get ("formbuilder_field","text"))."</span></td>
<td valign='middle' align='center' class='pagetitlecellbg' style='width:75%;padding:$direct_settings[theme_td_padding]'><span class='pagetitlecellcontent'>".(direct_local_get ("formbuilder_field_content","text"))."</span></td>
</tr></thead><tbody><tr>
<td valign='top' align='right' class='pageextrabg' style='width:25%;padding:$direct_settings[theme_td_padding]'><span class='pageextracontent' style='font-weight:bold'>".(direct_local_get ("core_filter","text")).":</span></td>
<td valign='middle' align='center' class='pagebg' style='width:75%;padding:$direct_settings[theme_td_padding]'><input type='text' id='{$f_ipoint_id}_f' value=\"$f_text\" size='18' class='pagecontentinputtextnpassword' style='width:55%' /></td>
</tr><tr>
<td colspan='2' align='center' class='pagebg' style='padding:$direct_settings[theme_td_padding]'><input type='button' id='{$f_ipoint_id}_b' value=\"$f_button\" class='pagecontentinputbutton' onclick=\"javscript:$f_button_onclick;\" /></td>
</tr></tbody>
</table>");

	if ($g_js_mode) { $f_return = "djs_swgDOM_replace (\"".(str_replace (array ('"',"\n"),(array ('\"',"\\n\" +\n\"")),$f_return))."\",\"$f_ipoint_id\");"; }

	return $f_return;
}

//j// Script specific commands

if (!isset ($direct_settings['theme_td_padding'])) { $direct_settings['theme_td_padding'] = "5px"; }
direct_local_integration ("formbuilder");

//j// EOF
?>