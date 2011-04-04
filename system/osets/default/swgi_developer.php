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
* osets/default/swgi_developer.php
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

//j// Functions and classes

//f// direct_oset_developer_input_result ()
/**
* direct_oset_developer_input_result ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_oset_developer_input_result ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_oset_developer_input_result ()- (#echo(__LINE__)#)"); }

	if ($direct_cachedata['output_input_result'])
	{
return ("<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("developer_input_result"))."</p>
<p class='pageborder2{$direct_settings['theme_css_corners']} pageextracontent'>{$direct_cachedata['output_input_result']}</p>");
	}
	else { return ""; }
}

//f// direct_oset_developer_input_result_sourcecode ()
/**
* direct_oset_developer_input_result_sourcecode ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_oset_developer_input_result_sourcecode ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_oset_developer_input_result_sourcecode ()- (#echo(__LINE__)#)"); }

	if ($direct_cachedata['output_input_result'])
	{
return ("<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("developer_input_result"))."</p>
<p class='pageborder2{$direct_settings['theme_css_corners']} pageextracontent' style='overflow:auto;white-space:pre;font-family:\"Courier New\",Courier,mono'>{$direct_cachedata['output_input_result']}</p>");
	}
	else { return ""; }
}

//f// direct_oset_developer_sqlsource_decode ()
/**
* direct_oset_developer_sqlsource_decode ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_oset_developer_sqlsource_decode ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_oset_developer_sqlsource_decode ()- (#echo(__LINE__)#)"); }

	if ($direct_cachedata['output_sql_result'])
	{
return ("<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("developer_sqlsource_decode_result"))."</p>
<p class='pageborder2{$direct_settings['theme_css_corners']} pageextracontent' style='overflow:auto;white-space:pre;font-family:\"Courier New\",Courier,mono'>{$direct_cachedata['output_sql_source']}</p>
<p class='pageborder2{$direct_settings['theme_css_corners']} pageextracontent' style='overflow:auto;white-space:pre;font-family:\"Courier New\",Courier,mono'>{$direct_cachedata['output_sql_result']}</p>");
	}
	else { return ""; }
}

//j// Script specific commands

$direct_settings['theme_css_corners'] = ((isset ($direct_settings['theme_css_corners_class'])) ? " ".$direct_settings['theme_css_corners_class'] : " ui-corner-all");

//j// EOF
?>