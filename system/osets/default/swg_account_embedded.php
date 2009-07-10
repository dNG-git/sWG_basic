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
* osets/default/swg_account_embedded.php
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
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

//f// direct_output_oset_account_embedded_ajax_selector ()
/**
* direct_output_oset_account_embedded_ajax_selector ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_embedded_ajax_selector ()
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_embedded_ajax_selector ()- (#echo(__LINE__)#)"); }

	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_account.php");
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_default_filter.php");

$f_return = ("<div id='swgAJAX_account_selector_{$direct_cachedata['output_tid']}_point' style='text-align:left'><table cellspacing='1' summary='' class='pageborder1' style='width:100%;table-layout:auto'>
<thead><tr>
<td colspan='2' align='left' class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding]'><span class='pagetitlecellcontent'>{$direct_cachedata['output_selection_title']}</span></td>
</tr></thead><tbody>");

	if ($direct_cachedata['output_pages'] > 1)
	{
$f_return .= ("<tr>
<td colspan='2' align='center' class='pageextrabg' style='padding:$direct_settings[theme_td_padding]'><span class='pageextracontent' style='font-size:10px'>".(direct_output_pages_generator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page'],"asis"))."</span></td>
</tr>");
	}

$f_return .= ("</tbody>
</table><span style='font-size:8px'>&#0160;</span><br />
".(direct_output_oset_default_filter_table (false,"swg_account_selector_filter_point",(direct_local_get ("core_filter_search","text")),"djs_dataport_{$direct_cachedata['output_tid']}_call_url0 ('m=dataport&amp;s=swgap;default;filter&amp;dsd=dtheme+0++dfid+account_selector++dftext+[f_text]++tid+{$direct_cachedata['output_tid']}++source+{$direct_cachedata['output_filter_source']}'.replace (/\[f_text\]/g,(encodeURIComponent (self.document.getElementById('swg_account_selector_filter_point_f').value))))",$direct_cachedata['output_filter_text'])));

	if (empty ($direct_cachedata['output_users_list'])) { $f_return .= "\n<p class='pagecontent' style='font-weight:bold'>".(direct_local_get ("account_user_selector_empty"))."</p>"; }
	else
	{
		$f_return .= "<span style='font-size:8px'>&#0160;</span>".(direct_account_oset_selector_users_parse ($direct_cachedata['output_users_list']));
		if ($direct_cachedata['output_pages'] > 1) { $f_return .= "\n<p class='pageborder2' style='text-align:center'><span class='pageextracontent' style='font-size:10px'>".(direct_output_pages_generator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page'],"asis"))."</span></p>"; }
	}

	return $f_return."</div>";
}

//f// direct_output_oset_account_embedded_ajax_status_ex ()
/**
* direct_output_oset_account_embedded_ajax_status_ex ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_embedded_ajax_status_ex ()
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_embedded_ajax_status_ex ()- (#echo(__LINE__)#)"); }

	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_account.php");

return ("<div id='swgAJAX_account_status_ex_point' style='text-align:left'><table cellspacing='1' summary='' class='pageborder1' style='width:100%;table-layout:auto'>
<thead><tr>
<td colspan='2' align='left' class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding]'><span class='pagetitlecellcontent'>".(direct_local_get ("account_status_ex"))."</span></td>
</tr></thead><tbody>".(direct_account_oset_status_ex_view ())."</tbody>
</table></div>");
}

//f// direct_output_oset_account_embedded_selector ()
/**
* direct_output_oset_account_embedded_selector ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_embedded_selector ()
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_embedded_selector ()- (#echo(__LINE__)#)"); }

	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_account.php");
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_default_filter.php");

$f_return = ("<table cellspacing='1' summary='' class='pageborder1' style='width:100%;table-layout:auto'>
<thead><tr>
<td colspan='2' align='left' class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding]'><span class='pagetitlecellcontent'>{$direct_cachedata['output_selection_title']}</span></td>
</tr></thead>");

	if ($direct_cachedata['output_pages'] > 1)
	{
$f_return .= ("\n<tbody><tr>
<td colspan='2' align='center' class='pageextrabg' style='padding:$direct_settings[theme_td_padding]'><span class='pageextracontent' style='font-size:10px'>".(direct_output_pages_generator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page']))."</span></td>
</tr></tbody>");
	}

$f_return .= ("\n</table><span id='swg_account_selector_filter_point' style='display:none'><!-- iPoint // --></span><script language='JavaScript1.5' type='text/javascript'><![CDATA[
if (djs_swgDOM)
{
	function djs_account_selector_filter_process () { self.document.location.replace ('".(direct_linker ("url1","m=dataport&s=swgap;default;filter&dsd=dtheme+2++dfid+account_selector++dftext+[f_text]++tid+{$direct_cachedata['output_tid']}++source+{$direct_cachedata['output_filter_source']}",false))."'.replace (/\[f_text\]/g,(encodeURIComponent (self.document.getElementById('swg_account_selector_filter_point_f').value)))); }
	djs_swgDOM_replace (\"<div style='font-size:8px'>&#0160;<br />\\n<span id='swg_account_selector_filter_point' style='display:none'><!-- iPoint // --></span></div>\",'swg_account_selector_filter_point');

".(direct_output_oset_default_filter_table (true,"swg_account_selector_filter_point",(direct_local_get ("core_filter_search","text")),"djs_account_selector_filter_process ()",$direct_cachedata['output_filter_text']))."
}
]]></script>");

	if (empty ($direct_cachedata['output_users_list'])) { $f_return .= "\n<p class='pagecontent' style='font-weight:bold'>".(direct_local_get ("account_user_selector_empty"))."</p>"; }
	else
	{
		$f_return .= "<span style='font-size:8px'>&#0160;</span>".(direct_account_oset_selector_users_parse ($direct_cachedata['output_users_list']));
		if ($direct_cachedata['output_pages'] > 1) { $f_return .= "\n<p class='pageborder2' style='text-align:center'><span class='pageextracontent' style='font-size:10px'>".(direct_output_pages_generator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page']))."</span></p>"; }
	}

	return $f_return;
}

//f// direct_output_oset_account_embedded_status_ex ()
/**
* direct_output_oset_account_embedded_status_ex ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_embedded_status_ex ()
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_embedded_status_ex ()- (#echo(__LINE__)#)"); }

	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_account.php");

return ("<table cellspacing='1' summary='' class='pageborder1' style='width:100%;table-layout:auto'>
<thead><tr>
<td colspan='2' align='left' class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding]'><span class='pagetitlecellcontent'>".(direct_local_get ("account_status_ex"))."</span></td>
</tr></thead><tbody>".(direct_account_oset_status_ex_view ())."</tbody>
</table>");
}

//j// Script specific commands

if (!isset ($direct_settings['theme_td_padding'])) { $direct_settings['theme_td_padding'] = "5px"; }

//j// EOF
?>