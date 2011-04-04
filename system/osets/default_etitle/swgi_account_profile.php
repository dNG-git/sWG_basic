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
* osets/default_etitle/swgi_account_profile.php
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

//f// direct_account_oset_parse_user_fullh ($f_data,$f_pageclass,$f_user_pageurl = "",$f_user_ip = "",$f_prefix = "")
/**
* Return a user information panel for horizontal views.
*
* @param  array $f_data User array
* @param  string $f_pageclass CSS class used for the (X)HTML panel
* @param  string $f_user_pageurl User page URL to be used for the link
* @param  string $f_user_ip Alternative user IP to be shown
* @param  string $f_prefix Key prefix
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_account_oset_parse_user_fullh ($f_data,$f_pageclass,$f_user_pageurl = "",$f_user_ip = "",$f_prefix = "")
{
	global $direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_account_oset_parse_user_fullh (+f_data,$f_pageclass,$f_user_pageurl,$f_user_ip,$f_prefix)- (#echo(__LINE__)#)"); }

	if ((is_array ($f_data))&&(!empty ($f_data)))
	{
		$f_return = "<table class='pageborder1' style='width:100%;table-layout:auto'>\n<thead class='pagehide'><tr>";

		if ($f_data[$f_prefix."avatar_small"]) { $f_return .= "<td colspan='2' class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding];text-align:left'><span class='pagetitlecellcontent'>".(direct_local_get ("core_username"))."</span></td>"; }
		else { $f_return .= "<td class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding];text-align:left'><span class='pagetitlecellcontent'>".(direct_local_get ("core_username"))."</span></td>"; }

		$f_return .= "\n</tr></thead><tbody><tr>\n";

		if ($f_data[$f_prefix."avatar_small"]) { $f_return .= "<td class='pageextrabg' style='padding:5px;text-align:left;vertical-align:middle'><img src='".$f_data[$f_prefix."avatar_small"]."' border='0' alt=\"".$f_data[$f_prefix."name"]."\" title=\"".$f_data[$f_prefix."name"]."\" /></td>\n<td class='{$f_pageclass}bg' style='width:100%;padding:5px;text-align:left;vertical-align:middle'>"; }
		else { $f_return .= "<td class='{$f_pageclass}bg' style='width:100%;padding:5px;text-align:left;vertical-align:middle'>"; }

		$f_return .= "<p class='{$f_pageclass}content'><span style='font-weight:bold'>";

		if ($f_user_pageurl) { $f_return .= (((isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']))||(substr ($direct_settings['ohandler'],0,5) == "ajax_")) ? "<a href=\"javascript:djs_dialog(null,{url:'".(str_replace ("?","?xhtml_embedded;",$f_user_pageurl))."'})\">".$f_data[$f_prefix."name"]."</a>" : "<a href='$f_user_pageurl' target='_self'>".$f_data[$f_prefix."name"]."</a>"); }
		elseif ($f_data[$f_prefix."pageurl"]) { $f_return .= (((isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']))||(substr ($direct_settings['ohandler'],0,5) == "ajax_")) ? "<a href=\"javascript:djs_dialog(null,{url:'".(str_replace ("?","?xhtml_embedded;",$f_data[$f_prefix."pageurl"]))."'})\">".$f_data[$f_prefix."name"]."</a>" : "<a href='".$f_data[$f_prefix."pageurl"]."' target='_self'>".$f_data[$f_prefix."name"]."</a>"); }
		else { $f_return .= $f_data[$f_prefix."name"]; }

		$f_return .= "</span>";
		if ($f_data[$f_prefix."title"]) { $f_return .= "<br />\n".$f_data[$f_prefix."title"]; }

		if ($f_user_ip) { $f_return .= "<br />\n<span style='font-size:10px'>($f_user_ip)</span>"; }
		elseif ($f_data[$f_prefix."ip"]) { $f_return .= "<br />\n<span style='font-size:10px'>(".$f_data[$f_prefix."ip"].")</span>"; }

		$f_return .= "</p>";
		if ($f_data[$f_prefix."type"]) { $f_return .= "\n<p class='{$f_pageclass}content' style='font-size:10px'>".$f_data[$f_prefix."type"]."</p>"; }
		$f_return .= "</td>\n</tr></tbody>\n</table>";
	}
	else { $f_return = "<p class='{$f_pageclass}content' style='font-weight:bold'>".(direct_local_get ("core_unknown"))."</p>"; }

	return $f_return;
}

//f// direct_account_oset_parse_user_fullv ($f_data,$f_pageclass,$f_user_pageurl = "",$f_user_ip = "",$f_prefix = "")
/**
* Return user information for vertical views.
*
* @param  array $f_data User array
* @param  string $f_pageclass CSS class used for the (X)HTML panel
* @param  string $f_user_pageurl User page URL to be used for the link
* @param  string $f_user_ip Alternative user IP to be shown
* @param  string $f_prefix Key prefix
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_account_oset_parse_user_fullv ($f_data,$f_pageclass,$f_user_pageurl = "",$f_user_ip = "",$f_prefix = "")
{
	global $direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_account_oset_parse_user_fullv (+f_data,$f_pageclass,$f_user_pageurl,$f_user_ip,$f_prefix)- (#echo(__LINE__)#)"); }

	if ((is_array ($f_data))&&(!empty ($f_data)))
	{
		$f_return = "";
		if ($f_data[$f_prefix."avatar_small"]) { $f_return .= "<p><img src='".$f_data[$f_prefix."avatar_small"]."' border='0' alt=\"".$f_data[$f_prefix."name"]."\" title=\"".$f_data[$f_prefix."name"]."\" /></p>"; }
		$f_return .= "<p class='$f_pageclass'><span style='font-weight:bold'>";

		if ($f_user_pageurl) { $f_return .= (((isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']))||(substr ($direct_settings['ohandler'],0,5) == "ajax_")) ? "<a href=\"javascript:djs_dialog(null,{url:'".(str_replace ("?","?xhtml_embedded;",$f_user_pageurl))."'})\">".$f_data[$f_prefix."name"]."</a>" : "<a href='$f_user_pageurl' target='_self'>".$f_data[$f_prefix."name"]."</a>"); }
		elseif ($f_data[$f_prefix."pageurl"]) { $f_return .= (((isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']))||(substr ($direct_settings['ohandler'],0,5) == "ajax_")) ? "<a href=\"javascript:djs_dialog(null,{url:'".(str_replace ("?","?xhtml_embedded;",$f_data[$f_prefix."pageurl"]))."'})\">".$f_data[$f_prefix."name"]."</a>" : "<a href='".$f_data[$f_prefix."pageurl"]."' target='_self'>".$f_data[$f_prefix."name"]."</a>"); }
		else { $f_return .= $f_data[$f_prefix."name"]; }

		$f_return .= "</span>";
		if ($f_data[$f_prefix."title"]) { $f_return .= "<br />\n".$f_data[$f_prefix."title"]; }

		if ($f_user_ip) { $f_return .= "<br />\n<span style='font-size:10px'>($f_user_ip)</span>"; }
		elseif ($f_data[$f_prefix."ip"]) { $f_return .= "<br />\n<span style='font-size:10px'>(".$f_data[$f_prefix."ip"].")</span>"; }

		$f_return .= "</p>";
		if ($f_data[$f_prefix."type"]) { $f_return .= "<p class='$f_pageclass' style='font-size:10px'>".$f_data[$f_prefix."type"]."</p>"; }
	}
	else { $f_return = "<p class='$f_pageclass' style='font-weight:bold'>".(direct_local_get ("core_unknown"))."</p>"; }

	return $f_return;
}

//j// Script specific commands

if (!isset ($direct_settings['theme_td_padding'])) { $direct_settings['theme_td_padding'] = "5px"; }

//j// EOF
?>