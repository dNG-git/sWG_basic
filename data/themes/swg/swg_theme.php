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
$Id: swg_theme.php,v 1.4 2007/07/11 17:43:36 s4u Exp $
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

if (!defined ("CLASS_direct_output_theme"))
{
//c// direct_output_theme
/**
* The theme support is "incremental". Our inline theme will be overwritten by
* this class. An additional subtype will overwrite this class.
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
class direct_output_theme extends direct_output_inline
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_output_theme->__construct () and direct_output_theme->direct_output_theme ()
/**
	* Constructor (PHP5) __construct (direct_output_theme)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_theme_class->__construct (direct_output_theme)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Check the blocker support and inform the system about available functions
------------------------------------------------------------------------- */

		if ($direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_blocker.php",2)) { $this->functions['theme_page'] = true; }

		$direct_classes['output']->css_header ();
		$direct_classes['output']->js_header ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_output_theme (direct_output_theme)
	*
	* @since v0.1.00
*\/
	function direct_output_theme () { $this->__construct (); }
:#*/
	//f// direct_output_theme->theme_page ($f_title)
/**
	* This function will be activated to show the content in default mode.
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

		if (!isset ($direct_settings['theme_mainmenu'])) { $direct_settings['theme_mainmenu'] = "mainmenu"; }

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

.designcopyrightbg { background-color:#606060 }
.designcopyrightcontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;color:#DDDDDD }
.designcopyrightcontent a, .designcopyrightcontent a:link, .designcopyrightcontent a:active, .designcopyrightcontent a:visited, .designcopyrightcontent a:hover, .designcopyrightcontent a:focus { color:#FFFFFF }

.designlogobg { background-image:url(".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_themes]/swg/v3/design_05.png",false,false)).");background-repeat:no-repeat }

.designmenu1content { border:1px solid #375A9D;border-radius:3px 3px;padding:5px;text-align:center }
.designmenu1content { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }
.designmenu1content a, .designmenu1content a:link, .designmenu1content a:visited { color:#000000;text-decoration:underline }
.designmenu1content a:active, .designmenu1content a:hover, .designmenu1content a:focus { color:#444444;text-decoration:none }

.designmenu2content { border:1px solid #193879;border-radius:3px 3px;padding:5px;text-align:center }
.designmenu2content { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;color:#222222 }
.designmenu2content a, .designmenu2content a:link, .designmenu2content a:visited { color:#000000;text-decoration:underline }
.designmenu2content a:active, .designmenu2content a:hover, .designmenu2content a:focus { color:#444444;text-decoration:none }

.designpagebg { background-image:url(".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_themes]/swg/v3/design_04.png",false,false)).");background-repeat:repeat-x;background-color:#FFFFFF }

.designservicemenucontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }
.designservicemenucontent a, .designservicemenucontent a:link, .designservicemenucontent a:visited { color:#000000;text-decoration:underline }
.designservicemenucontent a:active, .designservicemenucontent a:hover, .designservicemenucontent a:focus { color:#444444;text-decoration:none }

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

<body onload='djs_run_onload ();'><div id='swgAJAX_loading_point' style='display:none'><!-- iPoint // --></div><script language='JavaScript1.5' type='text/javascript'><![CDATA[
djs_swgAJAX_loading_writeln ('center');
]]></script><div style='position:absolute;top:0px;left:0px;z-index:254;width:31px;height:71px;background-color:#FFFFFF'>
<div style='width:31px;height:16px;background-color:#000000'></div>
<div style='width:19px;height:1px;margin-top:1px;background-color:#000000'></div>
<div style='width:19px;height:49px;margin-top:1px;background-color:#193879'></div>
<div style='width:19px;height:1px;margin-top:1px;background-color:#193879'></div>
</div><img src='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_themes]/swg/v3/design_01.png",true,false))."' width='31' height='125' alt='' title='' style='position:absolute;top:0px;left:0px;z-index:255' /><table cellspacing='0' summary='' style='width:100%;height:100%;border-top:10px solid #000000;background-image:url(".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_themes]/swg/v3/design_02.png",true,false)).");background-repeat:repeat-x'>
<tbody><tr style='height:100%'>
<td valign='top' align='left' class='designpagebg'><div class='designlogobg' style='position:absolute;top:14px;left:31px;z-index:1;width:152px;height:27px'><a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode]' target='_blank'><img src='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_themes]/swg/v3/design_06.png",true,false))."' width='75' height='75' alt='$direct_settings[product_lcode_txt]' title='$direct_settings[product_lcode_txt]' style='position:absolute;top:3px;left:0px;z-index:2' /></a></div>
<p class='designtitlecontent' style='width:100%;height:58px;padding-bottom:7px;text-align:right'><span id='swgversion_ipoint' style='font-size:24px'><a href='".(direct_linker ("url0","a=info"))."' target='_blank' style='text-decoration:none'>$direct_settings[product_lcode_html]</a><br /></span><script language='JavaScript' type='text/javascript'><![CDATA[
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
]]></script>$direct_settings[product_lcode_subtitle_html]</p>");

		if ($direct_classes['output']->options_check ("pagemenu"))
		{
			$this->page .= "<p class='designmenu2content'>";
			if ($direct_cachedata['output_pagemenu_title']) { $this->page .= "<span style='font-weight:bold'>{$direct_cachedata['output_pagemenu_title']}:</span> "; }
			$this->page .= "<span style='white-space:nowrap'>[ ".($direct_classes['output']->options_generator ("v","pagemenu"," ]</span> <span style='white-space:nowrap'>[ "))." ]</span></p>";
		}

		$this->page .= "<p class='designmenu1content'><span style='white-space:nowrap'>[ ".(direct_block_get ("blockmenu","h",$direct_settings['theme_mainmenu']," ]</span> <span style='white-space:nowrap'>[ "))." ]</span></p>";

		if ($direct_classes['output']->options_check ("servicemenu")) { $this->page .= "\n<p class='pageborder2' style='text-align:left'><span class='pageextracontent'>".($direct_classes['output']->options_generator ("h","servicemenu"))."</span></p>"; }
		$this->page .= "\n".$direct_classes['output']->page_content;
		if ($direct_classes['output']->options_check ("servicemenu")) { $this->page .= "\n<p class='pageborder2' style='text-align:right'><span class='pageextracontent'>".($direct_classes['output']->options_generator ("h","servicemenu"))."</span></p>"; }

$this->page .= ("</td>
</tr><tr style='height:50px'>
<td valign='middle' align='center' class='designcopyrightbg'><span class='designcopyrightcontent'>Powered by: $direct_settings[product_lcode_html] $direct_settings[product_version]<br />
&copy; <a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode]' target='_blank'><span style='font-style:italic'>direct</span> Netware Group</a> - All rights reserved");

		if ($direct_classes['output']->output_additional_copyright) { $this->page .= "<br />\n".$direct_classes['output']->output_additional_copyright; }

$this->page .= ("</span></td>
</tr></tbody>
</table><div style='position:absolute;top:0px;right:0px;z-index:254;width:31px;height:71px;background-color:#FFFFFF'>
<div style='width:31px;height:16px;background-color:#000000'></div>
<div style='width:19px;height:1px;margin-top:1px;background-color:#000000'></div>
<div style='width:19px;height:49px;margin-top:1px;background-color:#193879'></div>
<div style='width:19px;height:1px;margin-top:1px;background-color:#193879'></div>
</div><img src='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_themes]/swg/v3/design_03.png",true,false))."' width='31' height='125' alt='' title='' style='position:absolute;top:0px;right:0px;z-index:255' />
</body>

</html>");
	}
}

$direct_classes['@names']['output_theme'] = "direct_output_theme";
define ("CLASS_direct_output_theme",true);
}

//j// EOF
?>