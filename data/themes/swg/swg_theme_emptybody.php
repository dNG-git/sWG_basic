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
if (defined ("CLASS_direct_output_theme_emptybody")) { $g_continue_check = false; }
if (!defined ("CLASS_direct_output_theme")) { $g_continue_check = false; }

if ($g_continue_check)
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
class direct_output_theme_emptybody extends direct_output_theme
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
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_theme_class->__construct (direct_output_theme)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Check the blocker support and inform the system about available functions
------------------------------------------------------------------------- */

		$this->functions['theme_page'] = true;
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

body { height:100%;margin:0px;padding:0px;background-color:#FFFFFF }
body { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-style:normal;line-height:normal;font-weight:normal }
form { margin:0px;padding:0px }
html { height:100% }
img { border:0px }
table { margin:0px;border:0px }
td { padding:0px }
]]></style>
".($direct_classes['output']->header_elements ())."
</head>

<body onload='djs_run_onload ();'>".$direct_classes['output']->page_content."</body>

</html>");
	}
}

$direct_classes['@names']['output_theme'] = "direct_output_theme_emptybody";
define ("CLASS_direct_output_theme_emptybody",true);
}

//j// EOF
?>