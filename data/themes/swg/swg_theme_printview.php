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
if (defined ("CLASS_direct_oxhtml_theme_printview")) { $g_continue_check = false; }
if (!defined ("CLASS_direct_oxhtml_theme")) { $g_continue_check = false; }

if ($g_continue_check)
{
//c// direct_oxhtml_theme_printview
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
class direct_oxhtml_theme_printview extends direct_oxhtml_theme
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_oxhtml_theme_printview->__construct () and direct_oxhtml_theme_printview->direct_oxhtml_theme_printview ()
/**
	* Constructor (PHP5) __construct (direct_oxhtml_theme_printview)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_theme_class->__construct (direct_oxhtml_theme_printview)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['theme_page'] = true;

		$direct_globals['output']->css_header ();
		$direct_globals['output']->js_header ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_oxhtml_theme_printview
	* (direct_oxhtml_theme_printview)
	*
	* @since v0.1.00
*\/
	function direct_oxhtml_theme_printview () { $this->__construct (); }
:#*/
	//f// direct_oxhtml_theme_printview->theme_page ($f_title)
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

$this->output_data = ("<?xml version='1.0' encoding='$direct_local[lang_charset]' ?><!DOCTYPE html SYSTEM \"about:legacy-compat\">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='$direct_local[lang_iso_domain]'>

<head>
<title>$f_title</title>");

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

body { margin:0px;padding:0px 4%;background-color:#FFFFFF }
body { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-style:normal;line-height:normal;font-weight:normal }
form { margin:0px;padding:0px }
img { border:none }
input.file { width:90%;text-align:center;background-color:#F5F5F5 }
input.file { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#000000 }
table { margin:0px;table-layout:fixed;border:none;border-collapse:collapse;border-spacing:0px }
td { padding:0px }

.designcopyrightcontent { text-align:center;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;color:#000000 }
.designcopyrightcontent a, .designcopyrightcontent a:link, .designcopyrightcontent a:active, .designcopyrightcontent a:visited, .designcopyrightcontent a:hover, .designcopyrightcontent a:focus { color:#000000 }

.designpagebg *:first-child { margin-top:0px }
.designpagebg *:last-child { margin-bottom:0px }

.designtitlebg { background-image:url(".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_themes]/swg/v3/design_04.png",false,false)).");background-repeat:repeat-x }
.designtitlecontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#000000 }
.designtitlecontent a, .pagetitlecontent a:link, .pagetitlecontent a:visited { color:#000000;text-decoration:underline }
.designtitlecontent a:active, .pagetitlecontent a:hover, .pagetitlecontent a:focus { color:#363B21;text-decoration:none }

.pagebg { background-color:#FFFFFF }

.pageborder1 { background-color:#193879;border-collapse:separate;border-spacing:1px }
.pageborder2 { border:1px solid #193879;background-color:#D9D9DA;padding:4px }

.pagecontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }
.pagecontent a, .pagecontent a:link, .pagecontent a:active, .pagecontent a:visited, .pagecontent a:hover, .pagecontent a:focus { color:#000000 }
.pagecontentinputbutton { background-color:#F5F5F5;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#000000 }
.pagecontentinputcheckbox { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222;background-color:#FFFFFF }
.pagecontentinputfocused { border-color:#193879 }
.pagecontentinputtextnpassword { border:1px solid #C0C0C0;background-color:#F5F5F5 }
.pagecontentinputtextnpassword { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }
.pagecontentselect { border:1px solid #C0C0C0;background-color:#F5F5F5 }
.pagecontentselect { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }
.pagecontenttextarea { border:1px solid #C0C0C0;background-color:#F5F5F5 }
.pagecontenttextarea { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }
.pagecontenttitle { border:1px solid #193879;background-color:#375A9D;padding:5px }
.pagecontenttitle { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;color:#DDDDDD }
.pagecontenttitle a, .pagecontenttitle a:link, .pagecontenttitle a:active, .pagecontenttitle a:visited, .pagecontenttitle a:hover, .pagecontenttitle a:focus { color:#FFFFFF }

.pageembeddedborder1 { background-color:#DDDDDD;border-collapse:separate;border-spacing:1px }
.pageembeddedborder2 { border:1px solid #DDDDDD;background-color:#FFFFFF;padding:4px }

.pageerrorcontent { font-weight:bold;color:#FF0000 }
.pageerrorcontent a, .pageerrorcontent a:link, .pageerrorcontent a:active, .pageerrorcontent a:visited, .pageerrorcontent a:hover, .pageerrorcontent a:focus { color:#CC0000 }

.pageextrabg { background-color:#D9D9DA }
.pageextracontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }
.pageextracontent a, .pageextracontent a:link, .pageextracontent a:active, .pageextracontent a:visited, .pageextracontent a:hover, .pageextracontent a:focus { color:#000000 }

.pagehide { display:none }
.pagehighlightborder1 { background-color:#FF0000;border-collapse:separate;border-spacing:1px }
.pagehighlightborder2 { border:1px solid #FF0000;background-color:#FBF6CD;padding:4px }

.pagehoveropacity, .pagehoveropacity:link, .pagehoveropacity:visited { opacity:0.75 }
.pagehoveropacity:active, .pagehoveropacity:hover, .pagehoveropacity:focus { opacity:1 }

.pagehr { height:1px;overflow:hidden;border-top:1px solid #193879 }

.pageservicemenubg { border:1px solid #D9D9DA;padding:5px }
.pageservicemenucontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;color:#222222 }
.pageservicemenucontent a, .pageservicemenucontent a:link, .pageservicemenucontent a:visited { color:#000000;text-decoration:underline }
.pageservicemenucontent a:active, .pageservicemenucontent a:hover, .pageservicemenucontent a:focus { color:#444444;text-decoration:none }

.pagetitlecellbg { background-color:#375A9D }
.pagetitlecellcontent { display:block;padding:3px }
.pagetitlecellcontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;color:#FFFFFF }
.pagetitlecellcontent a, .pagetitlecellcontent a:link, .pagetitlecellcontent a:active, .pagetitlecellcontent a:visited, .pagetitlecellcontent a:hover, .pagetitlecellcontent a:focus { color:#FFFFFF }
]]></style>
".($direct_globals['output']->header_elements ())."
</head>

<body onload='djs_run_onload ();'><div id='swgAJAX_loading_point' style='display:none'><!-- iPoint // --></div><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_swgAJAX_init',params: { position:'center' } });
]]></script><table style='width:100%'>
<thead><tr>
<td class='designtitlebg' style='height:85px;padding:5px 15px;border:1px solid #CCCDD1;text-align:right;vertical-align:middle'><div style='float:left'><a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode]' target='_blank'><img src='$direct_settings[iscript_url]a=cache;amp;dsd=dfile+swg_logo.png' width='75' height='75' alt='$direct_settings[product_lcode_txt]' title='$direct_settings[product_lcode_txt]' /></a></div>
<p class='designtitlecontent'><span id='swgversion_ipoint' style='font-size:24px'><a href='".(direct_linker ("url0","a=info"))."' target='_blank' style='text-decoration:none'>$direct_settings[product_lcode_html]</a><br /></span><script type='text/javascript'><![CDATA[
function djs_theme_swgversion_switch () { \$('#swgversion').slideToggle (); }
djs_var.core_run_onload.push ({ func:'djs_swgDOM_replace',params: { id:'swgversion_ipoint',data:\"<span class='designtitlecontent'><span style='font-size:24px'><a href='javascript:djs_theme_swgversion_switch();' style='text-decoration:none'>$direct_settings[product_lcode_html]</a></span><br />\\n\" +
\"<span id='swgversion' style='display:none'>$direct_settings[product_version] - $direct_settings[product_buildid]<br /></span></span>\" } });
]]></script>$direct_settings[product_lcode_subtitle_html]</p></td>
</tr></thead><tbody><tr>
<td class='designpagebg' style='padding:20px 0px;text-align:left;vertical-align:middle'>");

		if ($direct_globals['output']->options_check ("servicemenu")) { $this->output_data .= "\n<p class='pageborder2{$direct_settings['theme_css_corners']} pageextracontent' style='text-align:left'>".($direct_globals['output']->options_generator ("h","servicemenu"))."</p>"; }
		$this->output_data .= "\n".$direct_globals['output']->output_content;
		if ($direct_globals['output']->options_check ("servicemenu")) { $this->output_data .= "\n<p class='pageborder2{$direct_settings['theme_css_corners']} pageextracontent' style='text-align:right'>".($direct_globals['output']->options_generator ("h","servicemenu"))."</p>"; }

$this->output_data .= ("</td>
</tr></tbody><tfoot><tr>
<td style='height:50px;border-top:1px solid #CCCDD1;text-align:center;vertical-align:middle'><span class='designcopyrightcontent'>Powered by: $direct_settings[product_lcode_html] $direct_settings[product_version]<br />
&#xA9; <a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode]' target='_blank'><span style='font-style:italic'>direct</span> Netware Group</a> - All rights reserved</span></td>
</tr></tfoot>
</table>
</body>

</html>");
	}
}

$direct_globals['@names']['output_theme'] = "direct_oxhtml_theme_printview";
define ("CLASS_direct_oxhtml_theme_printview",true);
}

//j// EOF
?>