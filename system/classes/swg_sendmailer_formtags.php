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
* Combining FormTags and eMails provide the possibility to send HTML enhanced
* eMails while staying backward compatible with text/plain.
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
* @subpackage extra_functions
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

/* -------------------------------------------------------------------------
Testing for required classes
------------------------------------------------------------------------- */

$g_continue_check = ((defined ("CLASS_direct_sendmailer_formtags")) ? false : true);
if (($g_continue_check)&&(!defined ("CLASS_direct_formtags"))) { $g_continue_check = $direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_formtags.php"); }
if (($g_continue_check)&&(!defined ("CLASS_direct_sendmailer"))) { $g_continue_check = ($direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_sendmailer.php") ? defined ("CLASS_direct_sendmailer") : false); }

if ($g_continue_check)
{
//c// direct_sendmailer_formtags
/**
* This special mail class provides the possibility to use FormTags for eMail
* messages.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage extra_functions
* @uses       CLASS_direct_sendmailer
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_sendmailer_formtags extends direct_sendmailer
{
/**
	* @var array $data_formtags FormTags message cache
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $data_formtags;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_sendmailer_formtags->__construct () and direct_sendmailer_formtags->direct_sendmailer_formtags ()
/**
	* Constructor (PHP5) __construct (direct_sendmailer_formtags)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel_class->__construct (direct_sendmailer_formtags)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions
------------------------------------------------------------------------- */

		$this->functions['message_get'] = false;
		$this->functions['message_set'] = false;

/* -------------------------------------------------------------------------
Set up the FormTags message cache
------------------------------------------------------------------------- */

		$this->data_formtags = array ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_sendmailer_formtags (direct_sendmailer_formtags)
	*
	* @since v0.1.00
*\/
	function direct_sendmailer_formtags () { $this->__construct (); }
:#*/
	//f// direct_sendmailer_formtags->message_get ()
/**
	* This method will send the email. It will return false if this failed or if
	* the total size of the email is too large.
	*
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function message_get ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer_class->message_get ()- (#echo(__LINE__)#)"); }

		if (!empty ($this->data_formtags)) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -sendmailer_class->message_get ()- (#echo(__LINE__)#)",:#*/$this->data_formtags/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -sendmailer_class->message_get ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_sendmailer_formtags->message_set ($f_data,$f_encoding = "")
/**
	* This method will send the email. It will return false if this failed or if
	* the total size of the email is too large.
	*
	* @param  string $f_data FormTags message
	* @param  string $f_encoding FormTags message encoding
	* @uses   direct_class_init()
	* @uses   direct_debug()
	* @uses   direct_formtags::encode()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function message_set ($f_data,$f_encoding = "")
	{
		global $direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer_class->message_set (+f_data,$f_encoding)- (#echo(__LINE__)#)"); }

		if (!isset ($direct_globals['formtags'])) { direct_class_init ("formtags"); }

		if (isset ($direct_globals['formtags']))
		{
			if (isset ($direct_settings['swg_sendmailer_copyright'])) { $f_data .= $direct_settings['swg_sendmailer_copyright']; }
			else
			{
$f_data .= ("\n\n[hr]
(C) $direct_settings[swg_title_txt] ([url]{$direct_settings['home_url']}[/url])
All rights reserved");
			}

			$f_data = str_replace ("[rewrite:ilink]","[rewrite:elink]",$f_data);
			if (!strlen ($f_encoding)) { $f_encoding = $direct_local['lang_charset']; }
			$this->data_formtags = array ("encoding" => $f_encoding,"data" => $direct_globals['formtags']->encode ($f_data));
		}
	}

	//f// direct_sendmailer_formtags->send ($f_type,$f_msg)
/**
	* This method will send the email. It will return false if this failed or if
	* the total size of the email is too large.
	*
	* @param  string $f_type Send eMail in default or BCC mode ("single" or "bcc")
	* @param  string $f_from Sender information
	* @param  string $f_subject Title of the eMail
	* @uses   direct_class_init()
	* @uses   direct_debug()
	* @uses   direct_formtags::cleanup()
	* @uses   direct_formtags::decode()
	* @uses   direct_sendmailer::send()
	* @uses   direct_sendmailer::text_set()
	* @uses   direct_sendmailer::xhtml_set()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function send ($f_type,$f_from,$f_subject)
	{
		global $direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer_class->send ($f_type,$f_from,$f_subject)- (#echo(__LINE__)#)"); }

		if (!isset ($direct_globals['formtags'])) { direct_class_init ("formtags"); }
		$f_return = false;

		if (isset ($direct_globals['formtags']))
		{
			$f_data = $direct_globals['formtags']->cleanup ($this->data_formtags['data']);
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($this->data_formtags['data'],"[hr]") !== false) { $this->data_formtags['data'] = str_replace ("[hr]","<div class='pagehr' style='$direct_settings[theme_hr_style]' xml:space='preserve'> </div>",$this->data_formtags['data']); }
			$this->text_set ($this->data_formtags['encoding'],$f_data);

$f_data = ("<?xml version='1.0' encoding='$direct_local[lang_charset]' ?><!DOCTYPE html SYSTEM \"about:legacy-compat\">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='$direct_local[lang_iso_domain]'>

<head>
<title>$f_subject</title>
<meta name='author' content='direct Netware Group' />
<meta name='creator' content='$direct_settings[product_lcode_txt] by the direct Netware Group' />
<meta name='description' content='$direct_settings[product_lcode_subtitle_txt]' />
<style type='text/css'><![CDATA[
p, td { cursor:default }

a { cursor:pointer }
a:link { color:#202020;text-decoration:underline }
a:active { color:#000000;text-decoration:none }
a:visited { color:#505050;text-decoration:underline }
a:hover { color:#000000;text-decoration:none }
a:focus { color:#000000;text-decoration:underline }

body { margin:0px;padding:0px;background-color:#FFFFFF }
body { font-size:100%;font-style:normal;font-weight:normal;color:#000000 }
form { margin:0px;padding:0px }
html { margin:0px;padding:0px }
img { border:none }
table { margin:0px;table-layout:fixed;border:none;border-collapse:collapse;border-spacing:0px }
td { padding:0px }

.pagebg { background-color:#FFFFFF }

.pageborder1 { background-color:#CCCCCC;border-collapse:separate;border-spacing:1px }
.pageborder2 { border:1px solid #CCCCCC;background-color:#FFFFFF;padding:5px }

.pagecontent { font-size:100%;color:#000000 }
.pagecontent a, .pagecontent a:link, .pagecontent a:active, .pagecontent a:visited, .pagecontent a:hover, .pagecontent a:focus { color:#000000 }
.pagecontentinputbutton { font-size:100%;color:#000000;background-color:#E0E0E0 }
.pagecontentinputcheckbox { font-size:100%;color:#000000;background-color:#FFFFFF }
.pagecontentinputtextnpassword { font-size:100%;color:#000000;background-color:#E0E0E0 }
.pagecontentselect { font-size:100%;color:#000000;background-color:#FFFFFF }
.pagecontenttextarea { font-size:100%;color:#000000;background-color:#E0E0E0 }
.pagecontenttitle { border:1px solid #CCCCCC;background-color:#FFFFFF;padding:5px }
.pagecontenttitle { font-size:100%;font-weight:bold;color:#000000 }
.pagecontenttitle a, .pagecontenttitle a:link, .pagecontenttitle a:active, .pagecontenttitle a:visited, .pagecontenttitle a:hover, .pagecontenttitle a:focus { color:#444444 }

.pageerrorcontent { font-weight:bold;color:#FF0000 }
.pageerrorcontent a, .pageerrorcontent a:link, .pageerrorcontent a:active, .pageerrorcontent a:visited, .pageerrorcontent a:hover, .pageerrorcontent a:focus { color:#CC0000 }

.pageextrabg { background-color:#E0E0E0 }
.pageextracontent { font-size:100%;color:#222222 }
.pageextracontent a, .pageextracontent a:link, .pageextracontent a:active, .pageextracontent a:visited, .pageextracontent a:hover, .pageextracontent a:focus { color:#000000 }

.pagehide { display:none }
.pagehighlightborder1 { background-color:#294563;border-collapse:separate;border-spacing:1px }
.pagehighlightborder2 { border:1px solid #294563;background-color:#F0F0FF;padding:4px }

.pagehr { height:1px;overflow:hidden;border-top:1px solid #CCCCCC }

.pagetitlecellbg { background-color:#FFFFFF }
.pagetitlecellcontent { font-size:100%;font-weight:bold;color:#000000 }
.pagetitlecellcontent a, .pagetitlecellcontent a:link, .pagetitlecellcontent a:active, .pagetitlecellcontent a:visited, .pagetitlecellcontent a:hover, .pagetitlecellcontent a:focus { color:#444444 }
]]></style>
</head>

<body><!--
sWG e-Mail
// --><table style='width:100%;border-collapse:separate;border-spacing:10px'>
<tbody><tr>
<td style='padding:1px'><div>".($direct_globals['formtags']->decode ($this->data_formtags['data']))."</div></td>
</tr></tbody>
</table>
</body>

</html>");

			$this->xhtml_set ($this->data_formtags['encoding'],$f_data);
			$f_return = parent::send ($f_type,$f_from,$f_subject);
		}

		return $f_return;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_direct_sendmailer_formtags",true);
}

//j// Script specific commands

if (!isset ($direct_settings['theme_hr_style'])) { $direct_settings['theme_hr_style'] = "display:block;height:1px;overflow:hidden"; }

//j// EOF
?>