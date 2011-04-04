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
* osets/default/swg_account.php
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

//f// direct_output_oset_account_actives ()
/**
* direct_output_oset_account_actives ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_actives ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_actives ()- (#echo(__LINE__)#)"); }

	$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_account_profile.php");

	if (empty ($direct_cachedata['output_users'])) { $f_return = "<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("account_actives_1")).$direct_cachedata['output_minutes'].(direct_local_get ("account_actives_2"))."</p>\n<p class='pagecontent'>".(direct_local_get ("account_actives_empty"))."</p>"; }
	else
	{
$f_return = ("<table class='pageborder1' style='width:100%;table-layout:auto'>
<thead><tr>
<td colspan='2' class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding];text-align:left'><span class='pagetitlecellcontent'>".(direct_local_get ("account_actives_1")).$direct_cachedata['output_minutes'].(direct_local_get ("account_actives_2"))."</span></td>
</tr></thead><tbody>");

		foreach ($direct_cachedata['output_users'] as $f_user_array)
		{
			if (isset ($f_right_switch))
			{
				if ($f_right_switch)
				{
					$f_return .= "</td>\n<td class='pagebg' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
					$f_right_switch = false;
				}
				else
				{
					$f_return .= "</td>\n</tr><tr>\n<td class='pagebg' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
					$f_right_switch = true;
				}
			}
			else
			{
				$f_return .= "<tr>\n<td class='pagebg' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
				$f_right_switch = true;
			}

			$f_return .= direct_account_oset_parse_user_fullh ($f_user_array,"page");
		}

		$f_return .= ($f_right_switch ? "</td>\n<td class='pagebg' style='width:50%'><span style='font-size:8px'>&#0160;</span></td>\n</tr></tbody>\n</table>" : "</td>\n</tr></tbody>\n</table>");
	}

	return $f_return;
}

if ($direct_globals['@names']['output_formbuilder'])
{
	//f// direct_output_oset_account_login ()
/**
	* direct_output_oset_account_login ()
	*
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML code
	* @since  v0.1.00
*/
	function direct_output_oset_account_login ()
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_login ()- (#echo(__LINE__)#)"); }

		if (!isset ($direct_globals['output_oset_formbuilder'])) { direct_class_init ("output_formbuilder"); }
		$f_form_id = uniqid ("swg");

		$f_return = $direct_settings['iscript_form']." name='swg_form' id='swg_form'>".(direct_linker ("form",$direct_cachedata['output_formtarget']));

		if (isset ($direct_cachedata['i_atimeoffset']))
		{
$f_return .= ("<script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_swgDOM_insert_append',params: { data:\"<input type='hidden' name='atimeoffset' value=\\\"\" + (new Date().getTimezoneOffset () / -60) + \"\\\" />\",hide:true,id:'swg_form' } });
]]></script>");
		}

$f_return .= ($direct_globals['output_formbuilder']->form_get ($direct_cachedata['output_formelements'])."
<p class='pagecontent' style='text-align:center'><input type='submit' id='$f_form_id' value='{$direct_cachedata['output_formbutton']}' class='pagecontentinputbutton' /><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'$f_form_id',type:'button' } });\n");

		if (isset ($direct_cachedata['output_formsupport_ajax_dialog'])) { $f_return .= "djs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'swg_form',id_button:'$f_form_id',type:'form' } });\n"; }
		$f_return .= "]]></script></p></form>";

		return $f_return;
	}
}

//f// direct_output_oset_account_otp_list ()
/**
* direct_output_oset_account_otp_list ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_otp_list ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_otp_list ()- (#echo(__LINE__)#)"); }

$f_return = ("<table class='pageborder1' style='width:100%;table-layout:auto'>
<thead><tr>
<td colspan='2' class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding];text-align:left'><span class='pagetitlecellcontent'>".(direct_local_get ("account_otp_list"))."</span></td>
</tr></thead><tbody>");

	foreach ($direct_cachedata['output_otp_list'] as $f_position => $f_password)
	{
		if (isset ($f_right_switch))
		{
			if ($f_right_switch)
			{
				$f_return .= "</td>\n<td class='pagebg' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'>";
				$f_right_switch = false;
			}
			else
			{
				$f_return .= "</td>\n</tr><tr>\n<td class='pagebg' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'>";
				$f_right_switch = true;
			}
		}
		else
		{
			$f_return .= "<tr>\n<td class='pagebg' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'>";
			$f_right_switch = true;
		}

		$f_return .= "<span class='pagecontent'><span style='font-weight:bold'>$f_position</span><br />\n$f_password</span>";
	}

	$f_return .= ($f_right_switch ? "</td>\n<td class='pagebg' style='width:50%'><span style='font-size:8px'>&#0160;</span></td>\n</tr></tbody>\n</table>" : "</td>\n</tr></tbody>\n</table>");
	$f_return .= "\n<p class='pagehighlightborder2{$direct_settings['theme_css_corners']} pagecontent' style='text-align:left;font-weight:bold'>".(direct_local_get ("account_otp_list_not_viewable_again"))."</p>";

	return $f_return;
}

//f// direct_output_oset_account_selector ()
/**
* direct_output_oset_account_selector ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_selector ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_selector ()- (#echo(__LINE__)#)"); }

	$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_account.php");
	$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_default_filter.php");

$f_return = ("<table class='pageborder1' style='width:100%;table-layout:auto'>
<thead><tr>
<td colspan='2' class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding];text-align:left'><span class='pagetitlecellcontent'>{$direct_cachedata['output_selection_title']}</span></td>
</tr></thead>");

	if ($direct_cachedata['output_pages'] > 1)
	{
$f_return .= ("\n<tbody><tr>
<td colspan='2' class='pageextrabg' style='padding:$direct_settings[theme_td_padding];text-align:center'><span class='pageextracontent' style='font-size:10px'>".($direct_globals['output']->pages_generator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page']))."</span></td>
</tr></tbody>");
	}

$f_return .= ("\n</table><span id='swg_account_selector_filter_point' style='display:none'><!-- iPoint // --></span><script type='text/javascript'><![CDATA[
function djs_account_selector_filter_init (f_params)
{
	\$('#swg_account_selector_filter_point').addClass ('pageborder1');
	\$('#swg_account_selector_filter_pointb').bind ('click',function () { djs_account_selector_filter_process (encodeURIComponent (\$('#swg_account_selector_filter_pointi').val ())); });

	djs_formbuilder_init ({ id:'swg_account_selector_filter_pointi' });
	djs_formbuilder_init ({ id:'swg_account_selector_filter_pointb',type:'button' });
}

function djs_account_selector_filter_process (f_text) { self.location.replace ('".(direct_linker ("url1","s=filter;dsd=dfid+account_selector++dftext+[text]++tid+{$direct_cachedata['output_tid']}++source+".$direct_cachedata['output_filter_source'],false))."'.replace (/\[text\]/g,f_text)); }

djs_var.core_run_onload.push ({ func:'djs_swgDOM_replace',params:{ id:'swg_account_selector_filter_point',id_replaced:'swg_account_selector_filter_box',
data:(\"<div style='font-size:8px'>&#0160;<br />\\n\" + ".(direct_output_oset_default_filter_table (true,"swg_account_selector_filter_point",(direct_local_get ("core_filter_search","text")),$direct_cachedata['output_filter_text']))." + '</div>'),
onReplace:{ func:'djs_account_selector_filter_init',params: { } } } });
]]></script>");

	if (empty ($direct_cachedata['output_users_list'])) { $f_return .= "\n<p class='pagecontent' style='font-weight:bold'>".(direct_local_get ("account_user_selector_empty"))."</p>"; }
	else
	{
		$f_return .= "<span style='font-size:8px'>&#0160;</span>".(direct_account_oset_selector_users_parse ($direct_cachedata['output_users_list']));
		if ($direct_cachedata['output_pages'] > 1) { $f_return .= "\n<p class='pageborder2{$direct_settings['theme_css_corners']} pageextracontent' style='text-align:center;font-size:10px'>".($direct_globals['output']->pages_generator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page']))."</p>"; }
	}

	return $f_return;
}

//f// direct_output_oset_account_status_ex ()
/**
* direct_output_oset_account_status_ex ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_status_ex ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_status_ex ()- (#echo(__LINE__)#)"); }

	$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_account.php");

return ("<table class='pageborder1' style='width:100%;table-layout:auto'>
<thead><tr>
<td colspan='2' class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding];text-align:left'><span class='pagetitlecellcontent'>".(direct_local_get ("account_status_ex"))."</span></td>
</tr></thead><tbody>".(direct_account_oset_status_ex_view ())."</tbody>
</table>");
}

//f// direct_output_oset_account_view ()
/**
* direct_output_oset_account_view ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_account_view ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_account_view ()- (#echo(__LINE__)#)"); }

	if ($direct_settings['account_profile_mods_support']) { $direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/mods/swgi_mods_support.php"); }

$f_return = ("<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("account_profile_view"))."</p>
<table class='pageborder1' style='width:100%;table-layout:auto'>
<thead><tr>
<td colspan='2' class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding];text-align:center'><span class='pagetitlecellcontent'>{$direct_cachedata['output_username']}</span></td>
</tr></thead><tbody><tr>
<td colspan='2' class='pagebg' style='padding:$direct_settings[theme_td_padding];text-align:left'>");

	if ($direct_cachedata['output_useravatar_large']) { $f_return .= "<div class='pageborder2{$direct_settings['theme_css_corners']}' style='margin-left:$direct_settings[theme_td_padding];float:right;clear:right'><img src='{$direct_cachedata['output_useravatar_large']}' border='0' alt='' title='' /></div>"; }
	elseif ($direct_cachedata['output_useravatar_small']) { $f_return .= "<div class='pageborder2{$direct_settings['theme_css_corners']}' style='margin-left:$direct_settings[theme_td_padding];float:right;clear:right'><img src='{$direct_cachedata['output_useravatar_small']}' border='0' alt='' title='' /></div>"; }

	$f_return .= "<div class='pageborder1' style='padding:1px'><div class='pagebg' style='padding:$direct_settings[theme_td_padding]'><p class='pagecontent'><span style='font-weight:bold'>".(direct_local_get ("core_usertype")).":</span> ".$direct_cachedata['output_usertype'];
	if ($direct_cachedata['output_usertitle']) { $f_return .= "<br />\n".$direct_cachedata['output_usertitle']; }

	$f_registered_ip = ($direct_cachedata['output_registration_ip'] ? " ({$direct_cachedata['output_registration_ip']})" : "");
	$f_lastvisit_ip = ($direct_cachedata['output_lastvisit_ip'] ? " ({$direct_cachedata['output_lastvisit_ip']})" : "");

$f_return .= ("</p>
<p class='pagecontent' style='font-size:10px'><span style='font-weight:bold'>".(direct_local_get ("account_registered")).":</span> {$direct_cachedata['output_registration_time']}$f_registered_ip<br />
<span style='font-weight:bold'>".(direct_local_get ("account_lastvisit")).":</span> {$direct_cachedata['output_lastvisit_time']}$f_lastvisit_ip</p></div></div></td>
</tr>");

	if ($direct_cachedata['output_pageurl_email'])
	{
$f_return .= ("\n<tr>
<td class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:middle'><span class='pageextracontent' style='font-weight:bold'>".(direct_local_get ("account_email")).":</span></td>
<td class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'><span class='pagecontent'><a href='{$direct_cachedata['output_pageurl_email']}' target='_self'>");

		$f_return .= ($direct_cachedata['output_email'] ? $direct_cachedata['output_email'] : direct_local_get ("account_email_user"));
		$f_return .= "</a></span></td>\n</tr>";
	}

	if ($direct_cachedata['output_signature'])
	{
$f_return .= ("\n<tr>
<td class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><span class='pageextracontent' style='font-weight:bold'>".(direct_local_get ("account_signature")).":</span></td>
<td class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'><span class='pagecontent'>{$direct_cachedata['output_signature']}</span></td>
</tr>");
	}

$f_return .= ("\n<tr>
<td class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:middle'><span class='pageextracontent' style='font-weight:bold'>".(direct_local_get ("account_rating")).":</span></td>
<td class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'><span class='pagecontent'>{$direct_cachedata['output_rating']}</span></td>
</tr></tbody>
</table>");

	if ($direct_settings['account_profile_mods_support']) { $f_return .= direct_oset_mods_include ("account_profile",$direct_cachedata['output_modstoview']); }

	return $f_return;
}

//j// Script specific commands

$direct_settings['theme_css_corners'] = ((isset ($direct_settings['theme_css_corners_class'])) ? " ".$direct_settings['theme_css_corners_class'] : " ui-corner-all");
if (!isset ($direct_settings['theme_td_padding'])) { $direct_settings['theme_td_padding'] = "5px"; }
if (!isset ($direct_settings['theme_form_td_padding'])) { $direct_settings['theme_form_td_padding'] = "3px"; }

//j// EOF
?>