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
$Id: swg_theme_printview.php,v 1.3 2007/07/11 17:43:36 s4u Exp $
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
if (defined ("CLASS_direct_output_theme_printview")) { $g_continue_check = false; }
if (!defined ("CLASS_direct_output_theme")) { $g_continue_check = false; }

if ($g_continue_check)
{
//c// direct_output_theme_printview
/**
* The theme support is "incremental". Our inline theme will be overwritten by
* the default sWG one. This light subtype will overwrite the default one.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage output_theme
* @uses       CLASS_direct_output_control
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_output_theme_printview extends direct_output_theme
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_output_theme_printview->__construct () and direct_output_theme_printview->direct_output_theme_printview ()
/**
	* Constructor (PHP5) __construct (direct_output_theme_printview)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_theme_class->__construct (direct_output_theme_printview)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['theme_page'] = true;

		$direct_classes['output']->css_header ();
		$direct_classes['output']->js_header ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_output_theme_printview
	* (direct_output_theme_printview)
	*
	* @since v0.1.00
*\/
	function direct_output_theme_printview () { $this->__construct (); }
:#*/
	//f// direct_output_theme_printview->theme_page ($f_title)
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
		global $direct_cachedata,$direct_classes,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_theme_class->theme_page ($f_title)- (#echo(__LINE__)#)"); }

		$direct_settings['theme_xhtml_type'] = "application/xhtml+xml; charset=".$direct_local['lang_charset'];
		header ("Content-Type: ".$direct_settings['theme_xhtml_type'],true);

$this->page = ("<?xml version='1.0' encoding='$direct_local[lang_charset]' ?>
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en'>

<head>
<title>$f_title</title>");

		if (strlen ($direct_cachedata['output_p3purl'])) { $this->page .= "\n<link rel='P3Pv1' href='{$direct_cachedata['output_p3purl']}'>"; }

$this->page .= ("\n<meta http-equiv='Content-Type' content='$direct_settings[theme_xhtml_type]' />
<meta name='author' content='direct Netware Group' />
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

body { height:100%;margin:0px;padding:0px 31px;background-color:#FFFFFF }
body { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-style:normal;line-height:normal;font-weight:normal }
form { margin:0px;padding:0px }
html { height:100% }
img { border:0px }
input.file { width:90%;text-align:center;background-color:#F5F5F5 }
input.file { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#000000 }
table { margin:0px;border:0px;table-layout:fixed }
td { padding:0px }

.designcopyrightcontent { text-align:center;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;color:#000000 }
.designcopyrightcontent a, .designcopyrightcontent a:link, .designcopyrightcontent a:active, .designcopyrightcontent a:visited, .designcopyrightcontent a:hover, .designcopyrightcontent a:focus { color:#000000 }

.designservicemenucontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }
.designservicemenucontent a, .designservicemenucontent a:link, .designservicemenucontent a:visited { color:#000000;text-decoration:underline }
.designservicemenucontent a:active, .designservicemenucontent a:hover, .designservicemenucontent a:focus { color:#444444;text-decoration:none }

.designtitlebg { background-image:url(".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_themes]/swg/v3/design_04.png",false,false)).");background-repeat:repeat-x }
.designtitlecontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#000000 }
.designtitlecontent a, .pagetitlecontent a:link, .pagetitlecontent a:visited { color:#000000;text-decoration:underline }
.designtitlecontent a:active, .pagetitlecontent a:hover, .pagetitlecontent a:focus { color:#363B21;text-decoration:none }

.pagebg { background-color:#FFFFFF }

.pageborder1 { background-color:#193879 }
.pageborder2 { border:1px solid #193879;background-color:#D9D9DA;padding:4px }

.pagecontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }
.pagecontent a, .pagecontent a:link, .pagecontent a:active, .pagecontent a:visited, .pagecontent a:hover, .pagecontent a:focus { color:#000000 }
.pagecontentinputbutton { background-color:#F5F5F5;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#000000 }
.pagecontentinputcheckbox { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222;background-color:#FFFFFF }
.pagecontentinputtextnpassword { border:1px solid #C0C0C0;background-color:#F5F5F5 }
.pagecontentinputtextnpassword { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }
.pagecontentselect { border:1px solid #C0C0C0;background-color:#F5F5F5 }
.pagecontentselect { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }
.pagecontenttextarea { border:1px solid #C0C0C0;background-color:#F5F5F5 }
.pagecontenttextarea { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }
.pagecontenttitle { border:1px solid #193879;background-color:#375A9D;padding:5px }
.pagecontenttitle { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;color:#DDDDDD }
.pagecontenttitle a, .pagecontenttitle a:link, .pagecontenttitle a:active, .pagecontenttitle a:visited, .pagecontenttitle a:hover, .pagecontenttitle a:focus { color:#FFFFFF }

.pageerrorcontent { font-weight:bold;color:#FF0000 }
.pageerrorcontent a, .pageerrorcontent a:link, .pageerrorcontent a:active, .pageerrorcontent a:visited, .pageerrorcontent a:hover, .pageerrorcontent a:focus { color:#CC0000 }

.pageextrabg { background-color:#D9D9DA }
.pageextracontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }
.pageextracontent a, .pageextracontent a:link, .pageextracontent a:active, .pageextracontent a:visited, .pageextracontent a:hover, .pageextracontent a:focus { color:#000000 }

.pagehide { display:none }
.pagehighlightborder1 { background-color:#FF0000 }
.pagehighlightborder2 { border:1px solid #FF0000;background-color:#FBF6CD;padding:4px }

.pagehr { height:1px;overflow:hidden;border-top:1px solid #193879 }

.pagetitlecellbg { background-color:#375A9D }
.pagetitlecellcontent { display:block;padding:3px }
.pagetitlecellcontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;color:#FFFFFF }
.pagetitlecellcontent a, .pagetitlecellcontent a:link, .pagetitlecellcontent a:active, .pagetitlecellcontent a:visited, .pagetitlecellcontent a:hover, .pagetitlecellcontent a:focus { color:#FFFFFF }
]]></style>
".($direct_classes['output']->header_elements ())."
</head>

<body onload='djs_run_onload ();'><!--
sWG print theme
// --><table cellspacing='1' summary='' style='width:100%;height:75px;border:1px solid #CCCDD1;background-color:#FFFFFF'>
<tbody><tr>
<td valign='middle' align='center' class='designtitlebg'>
<table cellspacing='0' summary='' style='width:100%;height:75px'>
<tbody><tr>
<td align='left' style='width:75px;line-height:0px'><a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode]' target='_blank'><img src='$direct_settings[iscript_url]a=cache&amp;dsd=dfile+swg_logo.png' width='75' height='75' alt='$direct_settings[product_lcode_txt]' title='$direct_settings[product_lcode_txt]' /></a></td>
<td valign='middle' align='right' style='width:100%;padding-right:10px'><span class='designtitlecontent'><span style='font-size:24px'><a href='".(direct_linker ("url0","a=info"))."' target='_blank' style='text-decoration:none'>$direct_settings[product_lcode_html]</a></span><br />
$direct_settings[product_lcode_subtitle_html]</span></td>
</tr></tbody>
</table>
</td>
</tr></tbody>
</table>");

		if ($direct_classes['output']->options_check ("servicemenu")) { $this->page .= "\n<p class='pageborder2' style='text-align:left'><span class='pageextracontent'>".($direct_classes['output']->options_generator ("h","servicemenu"))."</span></p>"; }
		$this->page .= "\n".$direct_classes['output']->page_content;
		if ($direct_classes['output']->options_check ("servicemenu")) { $this->page .= "\n<p class='pageborder2' style='text-align:right'><span class='pageextracontent'>".($direct_classes['output']->options_generator ("h","servicemenu"))."</span></p>"; }

$this->page .= ("<p class='designcopyrightcontent'>Powered by: $direct_settings[product_lcode_html] $direct_settings[product_version]<br />
&copy; <a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode]' target='_blank'><span style='font-style:italic'>direct</span> Netware Group</a> - All rights reserved");

		if ($direct_classes['output']->output_additional_copyright) { $this->page .= "<br />".$direct_classes['output']->output_additional_copyright; }

$this->page .= ("</p>
</body>

</html>");
	}
}

$direct_classes['@names']['output_theme'] = "direct_output_theme_printview";
define ("CLASS_direct_output_theme_printview",true);
}

//j// EOF
?>