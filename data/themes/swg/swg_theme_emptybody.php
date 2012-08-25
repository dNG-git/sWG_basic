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

if (!defined ("CLASS_directOThemeEmptyBody"))
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
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class directOThemeEmptyBody extends directOTheme
{
/*#ifdef(PHP4):
/* -------------------------------------------------------------------------
Extend the class using old behavior
------------------------------------------------------------------------- *\/

/**
	* Constructor (PHP4) directOThemeEmptyBody
	*
	* @since v0.1.00
*\/
	function directOThemeEmptyBody () { $this->__construct (); }
:#\n*/
/**
	* This function will be activated to show the content in default mode.
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

body { height:100%;margin:0px;padding:0px;background-color:#6A6A6A }
body { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-style:normal;line-height:normal;font-weight:normal }
form { margin:0px;padding:0px }
h1, h2, h3, h4, h5, h6 { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:14px;font-style:normal;font-weight:bold }
html { height:100% }
img { border:none }
table { margin:0px;table-layout:fixed;border:none;border-collapse:collapse;border-spacing:0px }
td, th { padding:0px }
]]></style>
".($direct_globals['output']->headerElements ())."
</head>

<body>".$direct_globals['output']->output_content."</body>

</html>");
	}
}

define ("CLASS_directOThemeEmptyBody",true);

//j// Script specific commands

$direct_globals['@names']['output_theme'] = "directOThemeEmptyBody";
if (!isset ($direct_settings['theme_jquery_ui'])) { $direct_settings['theme_jquery_ui'] = "smoothness"; }
}

//j// EOF
?>