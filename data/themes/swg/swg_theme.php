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
* Welcome to the default theme for the sWG.
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
* @subpackage output_theme
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/

/*#use(direct_use) */
use dNG\sWG\directOHandler;
/* #\n*/

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

if (!defined ("CLASS_directOTheme"))
{
/**
* The theme support is "incremental". Our inline theme will be overwritten by
* this class. An additional subtype will overwrite this class.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage output_theme
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directOTheme extends directOHandler
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directOTheme)
	*
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -oTheme->__construct (directOTheme)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Check the blocker support and inform the system about available functions
------------------------------------------------------------------------- */

		if ($direct_globals['basic_functions']->includeFile ($direct_settings['path_system']."/functions/swg_blocker.php",2)) { $this->functions['themePage'] = true; }

		if ((isset ($_SERVER['HTTP_USER_AGENT']))&&(preg_match ("#msie (\d)\.#i",$_SERVER['HTTP_USER_AGENT'],$f_result_array))&&($f_result_array[1] < 7))
		{
$direct_globals['output']->headerElements ("<script src='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_mmedia]/ext_jquery/jquery.pngFix.min.js++dbid+".$direct_settings['product_buildid'],true,false))."' type='text/javascript'></script><!-- // jQuery pngFix library // -->
<script type='text/javascript'><![CDATA[
jQuery(function ()
{
	jQuery(self.document).pngFix ({ blankgif:'".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_mmedia]/ext_jquery/jquery.pngFix.gif",true,false))."' })
}));
]]></script>","script_pngfix");
		}

		$direct_globals['output']->headerElements ("<link href='$direct_settings[path_mmedia]/ext_jquery/themes/$direct_settings[theme_jquery_ui]/jquery-ui-1.9.1.min.css' rel='stylesheet' type='text/css' />","link_stylesheet_jquery_ui");

		$direct_globals['output']->cssHeader ();
		$direct_globals['output']->jsHeader ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directOTheme
	*
	* @since v0.1.00
*\/
	function directOTheme () { $this->__construct (); }
:#*/
/**
	* This function will be activated to show the content in default mode.
	*
	* @param string $f_title Valid XHTML page title
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function themePage ($f_title)
	{
		global $direct_cachedata,$direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -oTheme->themePage ($f_title)- (#echo(__LINE__)#)"); }

		$direct_settings['theme_xhtml_type'] = "application/xhtml+xml; charset=".$direct_local['lang_charset'];
		$direct_globals['output']->outputHeader ("Content-Type",$direct_settings['theme_xhtml_type']);

		if (!isset ($direct_settings['theme_mainmenu'])) { $direct_settings['theme_mainmenu'] = "mainmenu"; }

$this->output_data = ("<?xml version='1.0' encoding='$direct_local[lang_charset]' ?><!DOCTYPE html SYSTEM \"about:legacy-compat\">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='$direct_local[lang_iso_domain]'>

<head>
<title>$f_title</title>");

		if (strlen ($direct_cachedata['output_p3purl'])) { $this->output_data .= "\n<link rel='P3Pv1' href='{$direct_cachedata['output_p3purl']}'>"; }

$this->output_data .= ("\n<meta name='author' content='direct Netware Group' />
<meta name='creator' content='$direct_settings[product_lcode_txt] by the direct Netware Group' />
<meta name='description' content='$direct_settings[product_lcode_subtitle_txt]' />
<link href='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_themes]/swg/v4/swg_theme.php.css++dbid+".$direct_settings['product_buildid'],true,false))."' rel='stylesheet' type='text/css' />
<style type='text/css'><![CDATA[
p, td, th { cursor:default }

a { cursor:pointer }
a:link { text-decoration:underline }
a:active { text-decoration:none }
a:visited { text-decoration:underline }
a:hover { text-decoration:none }
a:focus { text-decoration:underline }

body { margin:0px;padding:0px 31px;background-color:#6A6A6A }
body { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-style:normal;line-height:normal;font-weight:normal }
form { margin:0px;padding:0px }
h1, h2, h3, h4, h5, h6 { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:14px;font-style:normal;font-weight:bold }
img { border:none }
table { margin:0px;table-layout:fixed;border:none;border-collapse:collapse;border-spacing:0px }

td, th { padding:0px }
td:first-child, th:first-child { border-left:none }
td:last-child, th:last-child { border-right:none }

.designcopyright { height:50px;background-color:#808080;text-align:center;vertical-align:middle }
.designcopyright { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;color:#DDDDDD }
.designcopyright a, .designcopyright a:link, .designcopyright a:active, .designcopyright a:visited, .designcopyright a:hover, .designcopyright a:focus { color:#FFFFFF }

.designlogo { width:152px;height:80px;margin-top:4px;padding-top:1px;background-image:url(".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_themes]/swg/v4/design_05.png",false,false)).");background-repeat:no-repeat;text-align:left;float:left }

.designmainmenu { list-style:none;border:1px solid #375A9D;border-radius:3px 3px;padding:5px;text-align:center }
.designmainmenu { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }
.designmainmenu > li { display:inline-block;white-space:nowrap }
.designmainmenu > li > a, .designmainmenu > li > a:link, .designmainmenu > li > a:visited { color:#000000;text-decoration:underline }
.designmainmenu > li > a:active, .designmainmenu > li > a:hover, .designmainmenu > li > a:focus { color:#444444;text-decoration:none }

.designpage { padding:10px 12px;background-color:#FFFFFF;text-align:left;vertical-align:middle }
.designpage > :first-child { margin-top:0px }
.designpage > :last-child { margin-bottom:0px }

.designpagemenu { list-style:none;border:1px solid #193879;border-radius:3px 3px;padding:5px;text-align:center }
.designpagemenu { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;color:#222222 }
.designpagemenu > li { display:inline-block;white-space:nowrap }
.designpagemenu > li > a, .designpagemenu > li > a:link, .designpagemenu > li > a:visited { color:#000000;text-decoration:underline }
.designpagemenu > li > a:active, .designpagemenu > li > a:hover, .designpagemenu > li > a:focus { color:#444444;text-decoration:none }

.designtitle { height:85px;background-image:url(".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_themes]/swg/v4/design_04.png",false,false)).");background-repeat:repeat-x;background-color:#FFFFFF;text-align:right;vertical-align:middle }
.designtitle { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-weight:normal;color:#000000 }
.designtitle a, .designtitle a:link, .designtitle a:visited { color:#000000;text-decoration:underline }
.designtitle a:active, .designtitle a:hover, .designtitle a:focus { color:#193879;text-decoration:none }
]]></style>
".($direct_globals['output']->headerElements ())."
</head>

<body><div id='swgAJAX_loading_point' style='display:none'><!-- iPoint // --></div><script type='text/javascript'><![CDATA[
jQuery (function () { djs_swgAJAX_init ({ position:'center' }); });
]]></script><div style='position:absolute;top:0px;left:0px;z-index:254;width:31px;height:71px;background-color:#FFFFFF'>
<div style='width:31px;height:16px;background-color:#000000'></div>
<div style='width:19px;height:1px;margin-top:1px;background-color:#000000'></div>
<div style='width:19px;height:49px;margin-top:1px;background-color:#193879'></div>
<div style='width:19px;height:1px;margin-top:1px;background-color:#193879'></div>
</div><img src='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_themes]/swg/v4/design_01.png",true,false))."' width='31' height='125' alt='' title='' style='position:absolute;top:0px;left:0px;z-index:255' /><div style='width:100%;height:10px;background-color:#000000'></div><table style='width:100%;background-image:url(".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_themes]/swg/v4/design_02.png",true,false)).");background-repeat:repeat-x'>
<tbody><tr>
<td class='designtitle'><a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode]' target='_blank' class='designlogo'><img src='$direct_settings[iscript_url]a=cache;dsd=dfile+swg_logo.png' width='75' height='75' alt='$direct_settings[product_lcode_txt]' title='$direct_settings[product_lcode_txt]' /></a>
<div style='padding:5px 15px'>");

		$f_embedded_code = "<span><span style='font-size:24px'><a href='javascript:djs_theme_swgversion_switch();' style='text-decoration:none'>$direct_settings[product_lcode_html]</a></span><br /><span id='swgversion' style='display:none'>$direct_settings[product_version] - $direct_settings[product_buildid]<br /></span></span>";

$this->output_data .= ((isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']) ? $f_embedded_code."<script type='text/javascript'><![CDATA[" : ("<span id='swgversion_ipoint' style='font-size:24px'><a href='".(direct_linker_dynamic ("url0","a=info"))."' target='_blank' style='text-decoration:none'>$direct_settings[product_lcode_html]</a><br /></span><script type='text/javascript'><![CDATA[
jQuery (function () { djs_DOM_replace ({ data:\"".(str_replace ('"','\"',$f_embedded_code))."\",id:'swgversion_ipoint' }); });"))."
function djs_theme_swgversion_switch () { jQuery('#swgversion').toggle (); }
]]></script>$direct_settings[product_lcode_subtitle_html]</div></td>
</tr><tr>
<td class='designpage pagecontent ui-corner-bottom'>");

		if ($direct_globals['output']->optionsCheck ("pagemenu"))
		{
			$this->output_data .= "<ul class='designpagemenu'>";
			if (isset ($direct_cachedata['output_pagemenu_title'])) { $this->output_data .= "<li><strong>{$direct_cachedata['output_pagemenu_title']}:</strong></li>"; }
			$this->output_data .= "<li>[ ".($direct_globals['output']->optionsGenerator ("v","pagemenu"," ]</li><li>[ "))." ]</li></ul>\n";
		}

		$this->output_data .= "<ul class='designmainmenu'><li>[ ".(direct_block_get ("blockmenu","h",$direct_settings['theme_mainmenu']," ]</li><li>[ "))." ]</li></ul>\n";

		if ((is_array ($direct_cachedata['output_warning']))&&(!empty ($direct_cachedata['output_warning'])))
		{
			foreach ($direct_cachedata['output_warning'] as $f_warning_array) { $this->output_data .= "<p class='pagehighlightborder{$direct_settings['theme_css_corners']} pageextrabg pageextracontent'><strong>{$f_warning_array['title']}</strong><br />\n{$f_warning_array['text']}</p>\n"; }
		}

		if ($direct_globals['output']->optionsCheck ("servicemenu")) { $this->output_data .= "<p class='pageservicemenu{$direct_settings['theme_css_corners']}' style='text-align:left'>".($direct_globals['output']->optionsGenerator ("h","servicemenu"))."</p>\n"; }
		$this->output_data .= $direct_globals['output']->output_content;
		if ($direct_globals['output']->optionsCheck ("servicemenu")) { $this->output_data .= "\n<p class='pageservicemenu{$direct_settings['theme_css_corners']}' style='text-align:right'>".($direct_globals['output']->optionsGenerator ("h","servicemenu"))."</p>"; }

$this->output_data .= ("</td>
</tr></tbody><tfoot><tr>
<td class='designcopyright ui-corner-bottom'>Powered by: $direct_settings[product_lcode_html] $direct_settings[product_version]<br />
&#xA9; <a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode]' target='_blank'><em>direct</em> Netware Group</a> - All rights reserved");

		if ($direct_globals['output']->output_additional_copyright) { $this->output_data .= "<br />\n".$direct_globals['output']->output_additional_copyright; }

$this->output_data .= ("</td>
</tr></tfoot>
</table><div style='position:absolute;top:0px;right:0px;z-index:254;width:31px;height:71px;background-color:#FFFFFF'>
<div style='width:31px;height:16px;background-color:#000000'></div>
<div style='width:19px;height:1px;margin-top:1px;background-color:#000000'></div>
<div style='width:19px;height:49px;margin-top:1px;background-color:#193879'></div>
<div style='width:19px;height:1px;margin-top:1px;background-color:#193879'></div>
</div><img src='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_themes]/swg/v4/design_03.png",true,false))."' width='31' height='125' alt='' title='' style='position:absolute;top:0px;right:0px;z-index:255' />
</body>

</html>");
	}
}

define ("CLASS_directOTheme",true);

//j// Script specific commands

$direct_globals['@names']['output_theme'] = "directOTheme";
if (!isset ($direct_settings['theme_jquery_ui'])) { $direct_settings['theme_jquery_ui'] = "smoothness"; }
}

//j// EOF
?>