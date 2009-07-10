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
if (defined ("CLASS_direct_output_theme_light")) { $g_continue_check = false; }
if (!defined ("CLASS_direct_output_theme")) { $g_continue_check = false; }

if ($g_continue_check)
{
//c// direct_output_theme_light
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
class direct_output_theme_light extends direct_output_theme
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_output_theme_light->__construct () and direct_output_theme_light->direct_output_theme_light ()
/**
	* Constructor (PHP5) __construct (direct_output_theme_light)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_theme_class->__construct (direct_output_theme_light)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		if ($direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_blocker.php",2)) { $this->functions['theme_page'] = true; }

		$direct_classes['output']->css_header ();
		$direct_classes['output']->js_header ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_output_theme_light
	* (direct_output_theme_light)
	*
	* @since v0.1.00
*\/
	function direct_output_theme_light () { $this->__construct (); }
:#*/
	//f// direct_output_theme_light->theme_page ($f_title)
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
<title>$f_title - Light Edition</title>");

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

body { margin:0px;padding:0px;background-color:#FFFFFF }
body { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-style:normal;line-height:normal;font-weight:normal }
form { margin:0px;padding:0px }
img { border:0px }
table { margin:0px;border:0px }
td { padding:0px }

.designcopyrightcontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;color:#000000 }
.designcopyrightcontent a, .designcopyrightcontent a:link, .designcopyrightcontent a:active, .designcopyrightcontent a:visited, .designcopyrightcontent a:hover, .designcopyrightcontent a:focus { color:#000000 }

.designmenu1bg { background-color:#294563 }
.designmenu1content { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#EEEEEE }
.designmenu1content a, .designmenu1content a:link, .designmenu1content a:visited { color:#FFFFFF;text-decoration:none }
.designmenu1content a:active, .designmenu1content a:hover, .designmenu1content a:focus { color:#FFFFFF;text-decoration:underline }

.designmenu2bg { background-color:#FFFFFF }
.designmenu2content { text-align:center;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:11px;color:#222222 }
.designmenu2content a, .designmenu2content a:link, .designmenu2content a:visited { color:#000000;text-decoration:underline }
.designmenu2content a:active, .designmenu2content a:hover, .designmenu2content a:focus { color:#444444;text-decoration:none }

.designservicemenucontent { display:block;margin-bottom:1px;padding:5px;border:1px solid #CBDE7B;background-color:#F2F6DE }
.designservicemenucontent { text-align:center;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;color:#222222 }
.designservicemenucontent a, .designservicemenucontent a:link, .designservicemenucontent a:visited { color:#000000;text-decoration:underline }
.designservicemenucontent a:active, .designservicemenucontent a:hover, .designservicemenucontent a:focus { color:#444444;text-decoration:none }

.designtitlebg { background-image:url(".(direct_linker_dynamic ("url0","a=cache&dsd=dfile+swg_bg.png",false,false)).");background-color:#CCCDD1 }
.designtitlecontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#000000 }
.designtitlecontent a, .pagetitlecontent a:link, .pagetitlecontent a:visited { color:#000000;text-decoration:underline }
.designtitlecontent a:active, .pagetitlecontent a:hover, .pagetitlecontent a:focus { color:#363B21;text-decoration:none }

.pagebg { background-color:#ECECED }

.pageborder1 { background-color:#CCCCCC }
.pageborder2 { border:1px solid #CCCCCC;background-color:#FFFFFF;padding:5px }

.pagecontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#000000 }
.pagecontent a, .pagecontent a:link, .pagecontent a:active, .pagecontent a:visited, .pagecontent a:hover, .pagecontent a:focus { color:#000000 }
.pagecontentinputbutton { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#000000;background-color:#FFFFFF }
.pagecontentinputcheckbox { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#000000;background-color:#EEEEEE }
.pagecontentinputtextnpassword { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#000000;background-color:#FFFFFF }
.pagecontentselect { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#000000;background-color:#EEEEEE }
.pagecontenttextarea { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#000000;background-color:#FFFFFF }
.pagecontenttitle { border:1px solid #4C6C8F;background-color:#FFFFFF;padding:5px }
.pagecontenttitle { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;color:#000000 }
.pagecontenttitle a, .pagecontenttitle a:link, .pagecontenttitle a:active, .pagecontenttitle a:visited, .pagecontenttitle a:hover, .pagecontenttitle a:focus { color:#444444 }

.pageerrorcontent { font-weight:bold;color:#FF0000 }
.pageerrorcontent a, .pageerrorcontent a:link, .pageerrorcontent a:active, .pageerrorcontent a:visited, .pageerrorcontent a:hover, .pageerrorcontent a:focus { color:#CC0000 }

.pageextrabg { background-color:#FFFFFF }
.pageextracontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }
.pageextracontent a, .pageextracontent a:link, .pageextracontent a:active, .pageextracontent a:visited, .pageextracontent a:hover, .pageextracontent a:focus { color:#000000 }

.pagehide { display:none }
.pagehighlightborder1 { background-color:#FF0000 }
.pagehighlightborder2 { border:1px solid #FF0000;background-color:#FBF6CD;padding:4px }

.pagehr { height:1px;border-top:1px solid #FFAD65 }

.pagetitlecellbg { padding:5px;background-color:#FFFFFF }
.pagetitlecellcontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;color:#000000 }
.pagetitlecellcontent a, .pagetitlecellcontent a:link, .pagetitlecellcontent a:active, .pagetitlecellcontent a:visited, .pagetitlecellcontent a:hover, .pagetitlecellcontent a:focus { color:#444444 }
]]></style>
".($direct_classes['output']->header_elements ())."
</head>

<body onload='djs_run_onload ();'><!--
sWG light theme
// --><table cellspacing='1' summary='' style='width:100%;height:75px;border:1px solid #CCCDD1;background-color:#FFFFFF'>
<tbody><tr>
<td valign='middle' align='center' class='designtitlebg'>
<table cellspacing='0' summary='' style='width:100%;height:75px'>
<tbody><tr>
<td align='left' style='width:75px;line-height:0px'><a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode]' target='_blank'><img src='$direct_settings[iscript_url]a=cache&amp;dsd=dfile+swg_logo.png' width='75' height='75' alt='$direct_settings[product_lcode_txt]' title='$direct_settings[product_lcode_txt]' /></a></td>
<td valign='middle' align='right' style='width:100%;padding-right:10px'><span class='designtitlecontent'><span id='swgversion_ipoint' style='font-size:24px'><a href='".(direct_linker ("url0","a=info"))."' target='_blank' style='text-decoration:none'>$direct_settings[product_lcode_html]</a><br /></span><script language='JavaScript' type='text/javascript'><![CDATA[
if (djs_swgDOM)
{
 function djs_swgversion_switch ()
 {
  if (self.document.getElementById('swgversion').style.display == 'none') { self.document.getElementById('swgversion').style.display = 'inline'; }
  else { self.document.getElementById('swgversion').style.display = 'none'; }
 }

djs_swgDOM_replace (\"<span class='designtitlecontent'><span style='font-size:24px'><a href='javascript:djs_swgversion_switch();' style='text-decoration:none'>$direct_settings[product_lcode_html]</a></span><br />\\n\" +
\"<span id='swgversion' style='display:none'>$direct_settings[product_version] - $direct_settings[product_buildid]<br /></span></span>\",'swgversion_ipoint')
}
]]></script>$direct_settings[product_lcode_subtitle_html]</span></td>
</tr></tbody>
</table>
</td>
</tr></tbody>
</table>
<table cellspacing='1' summary='' style='width:100%;background-color:#CCCDD1'>
<tbody>");

		if ($direct_classes['output']->options_check ("pagemenu"))
		{
			$this->page .= "<tr>\n<td valign='top' align='center' class='designmenu2bg' style='padding:8px 3px'><span class='designmenu2content'>";
			if ($direct_cachedata['output_pagemenu_title']) { $this->page .= "<span style='font-weight:bold'>{$direct_cachedata['output_pagemenu_title']}:</span> "; }
			$this->page .= "<span style='white-space:nowrap'>[ ".($direct_classes['output']->options_generator ("v","pagemenu"," ]</span> <span style='white-space:nowrap'>[ "))." ]</span></span></td>\n</tr>";
		}

$this->page .= ("<tr>
<td valign='top' align='center' class='designmenu1bg' style='padding:8px 3px'><span class='designmenu1content'><span style='white-space:nowrap'>[ ".(direct_block_get ("blockmenu","h","mainmenu"," ]</span> <span style='white-space:nowrap'>[ "))." ]</span></span></td>
</tr><tr>
<td valign='top' align='center' class='designmenu2bg' style='padding:5px 3px'><span class='designmenu2content'><span style='white-space:nowrap'>[ ".($direct_classes['output']->options_generator ("v","servicemenu"," ]</span> <span style='white-space:nowrap'>[ "))." ]</span></span></td>
</tr></tbody>
</table><span style='font-size:8px'>&#0160;</span><table cellspacing='0' summary='' style='width:100%'>
<tbody><tr>
<td align='center'>
<table cellspacing='1' summary='' style='width:82%;border:1px solid #CCCDD1'>
<tbody><tr>
<td valign='middle' align='left' class='pagebg'>
<table cellspacing='0' summary='' style='width:100%;background-color:#FFFFFF'>
<tbody><tr>
<td valign='middle' align='left' class='pagebg' style='padding:5px'>".$direct_classes['output']->page_content);

		if ($direct_classes['output']->options_check ("servicemenu")) { $this->page .= "<p class='designservicemenucontent'>".($direct_classes['output']->options_generator ("h","servicemenu"))."</p>"; }

$this->page .= ("</td>
</tr></tbody>
</table>
</td>
</tr><tr>
<td valign='middle' align='center' style='height:40px'><span class='designcopyrightcontent'>Powered by: $direct_settings[product_lcode_html] $direct_settings[product_version]<br />
&copy; <a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode]' target='_blank'><span style='font-style:italic'>direct</span> Netware Group</a> - All rights reserved");

		if ($direct_classes['output']->output_additional_copyright) { $this->page .= "<br />".$direct_classes['output']->output_additional_copyright; }

$this->page .= ("</span></td>
</tr></tbody>
</table>
</td>
</tr></tbody>
</table>
</body>

</html>");
	}
}

$direct_classes['@names']['output_theme'] = "direct_output_theme_light";
define ("CLASS_direct_output_theme_light",true);
}

//j// EOF
?>