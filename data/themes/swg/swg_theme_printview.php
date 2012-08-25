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
* Welcome to the default Print View theme for the sWG.
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

if (!defined ("CLASS_directOThemePrintView"))
{
/**
* The theme support is "incremental". Our inline theme will be overwritten by
* the default sWG one. This light subtype will overwrite the default one.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage output_theme
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class directOThemePrintView extends directOTheme
{
/*#ifdef(PHP4):
/* -------------------------------------------------------------------------
Extend the class using old behavior
------------------------------------------------------------------------- *\/

/**
	* Constructor (PHP4) directOThemePrintView
	*
	* @since v0.1.00
*\/
	function directOThemePrintView () { $this->__construct (); }
:#\n*/
/**
	* This function will be activated to show the content in light mode.
	*
	* @param string $f_title Valid XHTML page title
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function themePage ($f_title)
	{
		global $direct_cachedata,$direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_theme_class->themePage ($f_title)- (#echo(__LINE__)#)"); }

		$direct_settings['theme_xhtml_type'] = "application/xhtml+xml; charset=".$direct_local['lang_charset'];
		$direct_globals['output']->outputHeader ("Content-Type",$direct_settings['theme_xhtml_type']);

$this->output_data = ("<?xml version='1.0' encoding='$direct_local[lang_charset]' ?><!DOCTYPE html SYSTEM \"about:legacy-compat\">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='$direct_local[lang_iso_domain]'>

<head>
<title>$f_title</title>");

		if (strlen ($direct_cachedata['output_p3purl'])) { $this->output_data .= "\n<link rel='P3Pv1' href='{$direct_cachedata['output_p3purl']}'>"; }

$this->output_data .= ("\n<meta name='author' content='direct Netware Group' />
<meta name='creator' content='$direct_settings[product_lcode_txt] by the direct Netware Group' />
<meta name='description' content='$direct_settings[product_lcode_subtitle_txt]' />
<style type='text/css'><![CDATA[
p, td, th { cursor:default }

a { cursor:pointer }
a:link { text-decoration:underline }
a:active { text-decoration:none }
a:visited { text-decoration:underline }
a:hover { text-decoration:none }
a:focus { text-decoration:underline }

body { margin:0px;padding:0px 4%;background-color:#FFFFFF }
body { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-style:normal;line-height:normal;font-weight:normal }
form { margin:0px;padding:0px }
h1, h2, h3, h4, h5, h6 { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:14px;font-style:normal;font-weight:bold }
img { border:none }
table { margin:0px;table-layout:fixed;border:none;border-collapse:collapse;border-spacing:0px }
td, th { padding:0px }

.designcopyright { height:50px;border-top:1px solid #CCCDD1;text-align:center;vertical-align:middle }
.designcopyright { text-align:center;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;color:#000000 }
.designcopyright a, .designcopyright a:link, .designcopyright a:active, .designcopyright a:visited, .designcopyright a:hover, .designcopyright a:focus { color:#000000 }

.designpage { padding:20px 0px;text-align:left;vertical-align:middle }
.designpage > :first-child { margin-top:0px }
.designpage > :last-child { margin-bottom:0px }

.designtitle { height:85px;background-image:url(".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_themes]/swg/v3/design_04.png",false,false)).");background-repeat:repeat-x;border:1px solid #CCCDD1;text-align:right;vertical-align:middle }
.designtitle { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-weight:normal;color:#000000 }
.designtitle a, .pagetitlecontent a:link, .pagetitlecontent a:visited { color:#000000;text-decoration:underline }
.designtitle a:active, .pagetitlecontent a:hover, .pagetitlecontent a:focus { color:#363B21;text-decoration:none }
]]></style>
".($direct_globals['output']->headerElements ())."
<link href='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_themes]/swg/v4/swg_theme.php.css++dbid+".$direct_settings['product_buildid'],true,false))."' rel='stylesheet' type='text/css' />
</head>

<body><div id='swgAJAX_loading_point' style='display:none'><!-- iPoint // --></div><script type='text/javascript'><![CDATA[
jQuery (function () { djs_swgAJAX_init ({ position:'center' }); });
]]></script><table style='width:100%'>
<tbody><tr>
<td class='designtitle'><a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode]' target='_blank' style='float:left'><img src='$direct_settings[iscript_url]a=cache;amp;dsd=dfile+swg_logo.png' width='75' height='75' alt='$direct_settings[product_lcode_txt]' title='$direct_settings[product_lcode_txt]' /></a>
<div style='padding:5px 15px'>");

		$f_embedded_code = "<span><span style='font-size:24px'><a href='javascript:djs_theme_swgversion_switch();' style='text-decoration:none'>$direct_settings[product_lcode_html]</a></span><br /><span id='swgversion' style='display:none'>$direct_settings[product_version] - $direct_settings[product_buildid]<br /></span></span>";

$this->output_data .= ((isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']) ? $f_embedded_code."<script type='text/javascript'><![CDATA[" : ("<span id='swgversion_ipoint' style='font-size:24px'><a href='".(direct_linker_dynamic ("url0","a=info"))."' target='_blank' style='text-decoration:none'>$direct_settings[product_lcode_html]</a><br /></span><script type='text/javascript'><![CDATA[
jQuery (function () { djs_DOM_replace ({ data:\"".(str_replace ('"','\"',$f_embedded_code))."\",id:'swgversion_ipoint' }); });"))."
function djs_theme_swgversion_switch () { jQuery('#swgversion').toggle (); }
]]></script>$direct_settings[product_lcode_subtitle_html]</div></td>
</tr><tr>
<td class='designpage pagecontent'>");

		if ($direct_globals['output']->optionsCheck ("servicemenu")) { $this->output_data .= "<p class='pageservicemenu{$direct_settings['theme_css_corners']}' style='text-align:left'>".($direct_globals['output']->optionsGenerator ("h","servicemenu"))."</p>\n"; }
		$this->output_data .= $direct_globals['output']->output_content;
		if ($direct_globals['output']->optionsCheck ("servicemenu")) { $this->output_data .= "\n<p class='pageservicemenu{$direct_settings['theme_css_corners']}' style='text-align:right'>".($direct_globals['output']->optionsGenerator ("h","servicemenu"))."</p>"; }

$this->output_data .= ("</td>
</tr></tbody><tfoot><tr>
<td class='designcopyright'>Powered by: $direct_settings[product_lcode_html] $direct_settings[product_version]<br />
&#xA9; <a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode]' target='_blank'><em>direct</em> Netware Group</a> - All rights reserved</td>
</tr></tfoot>
</table>
</body>

</html>");
	}
}

define ("CLASS_directOThemePrintView",true);

//j// Script specific commands

$direct_globals['@names']['output_theme'] = "directOThemePrintView";
if (!isset ($direct_settings['theme_jquery_ui'])) { $direct_settings['theme_jquery_ui'] = "smoothness"; }
}

//j// EOF
?>