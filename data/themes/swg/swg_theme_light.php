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
* Welcome to the default light theme for the sWG.
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

$g_continue_check = true;
if (defined ("CLASS_direct_oxhtml_theme_light")) { $g_continue_check = false; }
if (!defined ("CLASS_direct_oxhtml_theme")) { $g_continue_check = false; }

if ($g_continue_check)
{
//c// direct_oxhtml_theme_light
/**
* The theme support is "incremental". Our inline theme will be overwritten by
* the default sWG one. This light subtype will overwrite the default one.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage output_theme
* @uses       CLASS_direct_output_inline
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_oxhtml_theme_light extends direct_oxhtml_theme
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_oxhtml_theme_light->__construct () and direct_oxhtml_theme_light->direct_oxhtml_theme_light ()
/**
	* Constructor (PHP5) __construct (direct_oxhtml_theme_light)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_theme_class->__construct (direct_oxhtml_theme_light)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		if ($direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_blocker.php",2)) { $this->functions['theme_page'] = true; }

		$direct_globals['output']->css_header ();
		$direct_globals['output']->js_header ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_oxhtml_theme_light
	* (direct_oxhtml_theme_light)
	*
	* @since v0.1.00
*\/
	function direct_oxhtml_theme_light () { $this->__construct (); }
:#*/
	//f// direct_oxhtml_theme_light->theme_page ($f_title)
/**
	* This function will be activated to show the content in light mode.
	*
	* @param string $f_title Valid XHTML page title
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function theme_page ($f_title)
	{
		global $direct_cachedata,$direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_theme_class->theme_page ($f_title)- (#echo(__LINE__)#)"); }

		$direct_settings['theme_xhtml_type'] = "application/xhtml+xml; charset=".$direct_local['lang_charset'];
		$direct_globals['output']->output_header ("Content-Type",$direct_settings['theme_xhtml_type']);

		if (!isset ($direct_settings['theme_mainmenu'])) { $direct_settings['theme_mainmenu'] = "mainmenu"; }

$this->output_data = ("<?xml version='1.0' encoding='$direct_local[lang_charset]' ?><!DOCTYPE html SYSTEM \"about:legacy-compat\">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='$direct_local[lang_iso_domain]'>

<head>
<title>$f_title - Light Edition</title>");

		if (strlen ($direct_cachedata['output_p3purl'])) { $this->output_data .= "\n<link rel='P3Pv1' href='{$direct_cachedata['output_p3purl']}'>"; }

$this->output_data .= ("\n<meta name='author' content='direct Netware Group' />
<meta name='creator' content='$direct_settings[product_lcode_txt] by the direct Netware Group' />
<meta name='description' content='$direct_settings[product_lcode_subtitle_txt]' />
<style type='text/css'><![CDATA[
p, td { cursor:default }

a { cursor:pointer }
a:link { text-decoration:underline }
a:active { text-decoration:none }
a:visited { text-decoration:underline }
a:hover { text-decoration:none }
a:focus { text-decoration:underline }

body { margin:0px;padding:0px 19px;background-color:#6A6A6A }
body { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-style:normal;line-height:normal;font-weight:normal }
form { margin:0px;padding:0px }
h1, h2, h3, h4, h5, h6 { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:14px;font-style:normal;font-weight:bold }
img { border:none }
table { margin:0px;table-layout:fixed;border:none;border-collapse:collapse;border-spacing:0px }
td { padding:0px }

.designcopyrightbg { background-color:#808080 }
.designcopyrightcontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;color:#DDDDDD }
.designcopyrightcontent a, .designcopyrightcontent a:link, .designcopyrightcontent a:active, .designcopyrightcontent a:visited, .designcopyrightcontent a:hover, .designcopyrightcontent a:focus { color:#FFFFFF }

.designmainmenucontent { border:1px solid #375A9D;border-radius:3px 3px;padding:5px;text-align:center }
.designmainmenucontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }
.designmainmenucontent span { white-space:nowrap }
.designmainmenucontent span a, .designmainmenucontent span a:link, .designmainmenucontent span a:visited { color:#000000;text-decoration:underline }
.designmainmenucontent span a:active, .designmainmenucontent span a:hover, .designmainmenucontent span a:focus { color:#444444;text-decoration:none }

.designpagebg { background-color:#FFFFFF }
.designpagebg *:first-child { margin-top:0px }
.designpagebg *:last-child { margin-bottom:0px }

.designpagemenucontent { border:1px solid #193879;border-radius:3px 3px;padding:5px;text-align:center }
.designpagemenucontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;color:#222222 }
.designpagemenucontent span { white-space:nowrap }
.designpagemenucontent span a, .designpagemenucontent span a:link, .designpagemenucontent span a:visited { color:#000000;text-decoration:underline }
.designpagemenucontent span a:active, .designpagemenucontent span a:hover, .designpagemenucontent span a:focus { color:#444444;text-decoration:none }

.designtitlebg { background-image:url($direct_settings[iscript_url]a=cache;dsd=dfile+swg_bg.png);background-repeat:repeat-x;background-color:#FFFFFF }
.designtitlecontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#000000 }
.designtitlecontent a, .designtitlecontent a:link, .designtitlecontent a:visited { color:#000000;text-decoration:underline }
.designtitlecontent a:active, .designtitlecontent a:hover, .designtitlecontent a:focus { color:#193879;text-decoration:none }
]]></style>
".($direct_globals['output']->header_elements ())."
<link href='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_themes]/swg/v4/swg_theme.php.css++dbid+".$direct_settings['product_buildid'],true,false))."' rel='stylesheet' type='text/css' />
</head>

<body onload='djs_run_onload ();'><div id='swgAJAX_loading_point' style='display:none'><!-- iPoint // --></div><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_swgAJAX_init',params: { position:'center' } });
]]></script><div style='position:absolute;top:0px;left:0px;z-index:255;width:19px;height:71px;background-color:#FFFFFF'>
<div style='width:19px;height:16px;background-color:#000000'></div>
<div style='width:19px;height:1px;margin-top:1px;background-color:#000000'></div>
<div style='width:19px;height:49px;margin-top:1px;background-color:#193879'></div>
<div style='width:19px;height:1px;margin-top:1px;background-color:#193879'></div>
</div><div style='width:100%;height:10px;background-color:#000000'></div><table style='width:100%'>
<thead><tr>
<td class='designtitlebg' style='height:85px;padding:5px 15px;text-align:right;vertical-align:middle'><div style='float:left'><a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode]' target='_blank'><img src='$direct_settings[iscript_url]a=cache;amp;dsd=dfile+swg_logo.png' width='75' height='75' alt='$direct_settings[product_lcode_txt]' title='$direct_settings[product_lcode_txt]' /></a></div>
<p class='designtitlecontent'><span id='swgversion_ipoint' style='font-size:24px'><a href='".(direct_linker ("url0","a=info"))."' target='_blank' style='text-decoration:none'>$direct_settings[product_lcode_html]</a><br /></span><script type='text/javascript'><![CDATA[
function djs_theme_swgversion_switch () { \$('#swgversion').slideToggle (); }
djs_var.core_run_onload.push ({ func:'djs_swgDOM_replace',params: { id:'swgversion_ipoint',data:\"<span class='designtitlecontent'><span style='font-size:24px'><a href='javascript:djs_theme_swgversion_switch();' style='text-decoration:none'>$direct_settings[product_lcode_html]</a></span><br />\\n\" +
\"<span id='swgversion' style='display:none'>$direct_settings[product_version] - $direct_settings[product_buildid]<br /></span></span>\" } });
]]></script>$direct_settings[product_lcode_subtitle_html]</p></td>
</tr></thead><tbody><tr>
<td class='designpagebg' style='padding:10px 12px;text-align:left;vertical-align:middle'>");

		if ($direct_globals['output']->options_check ("pagemenu"))
		{
			$this->output_data .= "<p class='designpagemenucontent'>";
			if ($direct_cachedata['output_pagemenu_title']) { $this->output_data .= "<span style='font-weight:bold'>{$direct_cachedata['output_pagemenu_title']}:</span> "; }
			$this->output_data .= "<span>[ ".($direct_globals['output']->options_generator ("v","pagemenu"," ]</span> <span>[ "))." ]</span></p>";
		}

		$this->output_data .= "<p class='designmainmenucontent'><span>[ ".(direct_block_get ("blockmenu","h",$direct_settings['theme_mainmenu']," ]</span> <span>[ "))." ]</span></p>";

		if ((is_array ($direct_cachedata['output_warning']))&&(!empty ($direct_cachedata['output_warning'])))
		{
			foreach ($direct_cachedata['output_warning'] as $f_warning_array) { $this->output_data .= "<p class='pagehighlightborder2{$direct_settings['theme_css_corners']} pageextracontent'><span style='font-weight:bold'>{$f_warning_array['title']}</span><br />\n{$f_warning_array['text']}</p>"; }
		}

		if ($direct_globals['output']->options_check ("servicemenu")) { $this->output_data .= "\n<p class='pageborder2{$direct_settings['theme_css_corners']} pageextracontent' style='text-align:left'>".($direct_globals['output']->options_generator ("h","servicemenu"))."</p>"; }
		$this->output_data .= "\n".$direct_globals['output']->output_content;
		if ($direct_globals['output']->options_check ("servicemenu")) { $this->output_data .= "\n<p class='pageborder2{$direct_settings['theme_css_corners']} pageextracontent' style='text-align:right'>".($direct_globals['output']->options_generator ("h","servicemenu"))."</p>"; }

$this->output_data .= ("</td>
</tr></tbody><tfoot><tr>
<td class='designcopyrightbg' style='height:50px;text-align:center;vertical-align:middle'><span class='designcopyrightcontent'>Powered by: $direct_settings[product_lcode_html] $direct_settings[product_version]<br />
&#xA9; <a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode]' target='_blank'><span style='font-style:italic'>direct</span> Netware Group</a> - All rights reserved</span></td>
</tr></tfoot>
</table><div style='position:absolute;top:0px;right:0px;z-index:255;width:19px;height:71px;background-color:#FFFFFF'>
<div style='width:19px;height:16px;background-color:#000000'></div>
<div style='width:19px;height:1px;margin-top:1px;background-color:#000000'></div>
<div style='width:19px;height:49px;margin-top:1px;background-color:#193879'></div>
<div style='width:19px;height:1px;margin-top:1px;background-color:#193879'></div>
</div>
</body>

</html>");
	}
}

$direct_globals['@names']['output_theme'] = "direct_oxhtml_theme_light";
define ("CLASS_direct_oxhtml_theme_light",true);
}

//j// EOF
?>