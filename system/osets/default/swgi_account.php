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
* osets/default/swgi_account.php
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

//f// direct_account_oset_status_ex_view ()
/**
* Create a view with the current login status.
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_account_oset_status_ex_view ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_account_oset_status_ex_view ()- (#echo(__LINE__)#)"); }

$f_return = ("<tr>
<td valign='top' align='right' class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding]'><span class='pageextracontent' style='font-weight:bold'>".(direct_local_get ("core_user_current")).":</span></td>
<td valign='middle' align='center' class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding]'><span class='pagecontent'>{$direct_cachedata['output_current_user']}</span></td>
</tr><tr>
<td valign='top' align='right' class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding]'><span class='pageextracontent' style='font-weight:bold'>".(direct_local_get ("account_status_ex_verification_type")).":</span></td>
<td valign='middle' align='center' class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding]'><span class='pagecontent'>{$direct_cachedata['output_current_verification']}</span></td>
</tr>");

	if (isset ($direct_cachedata['output_link_login']))
	{
		if ($direct_cachedata['output_dtheme_mode']) { $f_url_target = "_self"; }
		else { $f_url_target = "_top"; }

$f_return .= ("<tr>
<td colspan='2' align='center' class='pagebg' style='padding:$direct_settings[theme_td_padding]'><span class='pagecontent'><a href=\"{$direct_cachedata['output_link_login']}\" target='$f_url_target'>".(direct_local_get ("core_login"))."</a></span></td>
</tr>");
	}

	return $f_return;
}

//f// direct_account_oset_selector_users_parse ($f_users_array)
/**
* Generate the selector list for the given user array.
*
* @param  array $f_users_array Users to output
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_account_oset_selector_users_parse ($f_users_array)
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_account_oset_selector_users_parse (+f_users_array)- (#echo(__LINE__)#)"); }

	$f_return = "";

	if (!empty ($f_users_array))
	{
$f_return = ("<table cellspacing='1' summary='' class='pageborder1' style='width:100%;table-layout:auto'>
<thead class='pagehide'><tr>
<td colspan='2' align='left' class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding]'><span class='pagetitlecellcontent'>".(direct_local_get ("core_username"))."</span></td>
</tr></thead><tbody>");

		foreach ($f_users_array as $f_user_array)
		{
			if ($f_user_array['marked']) { $f_css_class = "extra"; }
			else { $f_css_class = ""; }

			if (isset ($f_right_switch))
			{
				if ($f_right_switch)
				{
					$f_return .= "</td>\n<td valign='middle' align='left' class='page{$f_css_class}bg' style='width:50%;padding:$direct_settings[theme_td_padding]'>";
					$f_right_switch = false;
				}
				else
				{
					$f_return .= "</td>\n</tr><tr>\n<td valign='middle' align='left' class='page{$f_css_class}bg' style='width:50%;padding:$direct_settings[theme_td_padding]'>";
					$f_right_switch = true;
				}
			}
			else
			{
				$f_return .= "<tr>\n<td valign='middle' align='left' class='page{$f_css_class}bg' style='width:50%;padding:$direct_settings[theme_td_padding]'>";
				$f_right_switch = true;
			}

$f_return .= ("<a id=\"{$f_user_array['id']}\" name=\"{$f_user_array['id']}\"></a><span class='page{$f_css_class}content'><span style='font-weight:bold'><a href='{$f_user_array['pageurl']}' target='_blank'>{$f_user_array['name']}</a></span><br />
<span style='font-size:10px'><a href=\"{$f_user_array['marker_url']}\" target='_self'>{$f_user_array['marker_title']}</a><br />
{$f_user_array['type']}</span></span>");
		}

		if ($f_right_switch) { $f_return .= "</td>\n<td style='width:50%'><span style='font-size:8px'>&#0160;</span></td>\n</tr></tbody>\n</table>"; }
		else { $f_return .= "</td>\n</tr></tbody>\n</table>"; }
	}

	return $f_return;
}

//j// Script specific commands

if (!isset ($direct_settings['theme_form_td_padding'])) { $direct_settings['theme_form_td_padding'] = "3px"; }
if (!isset ($direct_settings['theme_td_padding'])) { $direct_settings['theme_td_padding'] = "5px"; }

//j// EOF
?>