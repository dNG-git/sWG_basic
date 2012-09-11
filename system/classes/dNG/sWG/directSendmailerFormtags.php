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
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
/*#ifdef(PHP5n) */

namespace dNG\sWG;
/* #*/
/*#use(direct_use) */
use dNG\sWG\directSendmailer;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

if (!defined ("CLASS_directSendmailerFormtags"))
{
/**
* This special mail class provides the possibility to use FormTags for eMail
* messages.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage extra_functions
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directSendmailerFormtags extends directSendmailer
{
/**
	* @var array $data_formtags FormTags message cache
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $data_formtags;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directSendmailerFormtags)
	*
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer->__construct (directSendmailerFormtags)- (#echo(__LINE__)#)"); }

		if (!isset ($direct_globals['@names']['formtags'])) { $direct_globals['basic_functions']->includeClass ('dNG\sWG\directFormtags',2); }
		if (!isset ($direct_globals['formtags'])) { direct_class_init ("formtags"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions
------------------------------------------------------------------------- */

		$this->functions['messageGet'] = false;
		$this->functions['messageSet'] = isset ($direct_globals['formtags']);

/* -------------------------------------------------------------------------
Set up the FormTags message cache
------------------------------------------------------------------------- */

		$this->data_formtags = NULL;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directSendmailerFormtags
	*
	* @since v0.1.00
*\/
	function directSendmailerFormtags () { $this->__construct (); }
:#*/
/**
	* This method will send the email. It will return false if this failed or if
	* the total size of the email is too large.
	*
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function messageGet ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer->messageGet ()- (#echo(__LINE__)#)"); }

		if (isset ($this->data_formtags)) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -sendmailer->messageGet ()- (#echo(__LINE__)#)",:#*/$this->data_formtags['data']/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -sendmailer->messageGet ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* This method will send the email. It will return false if this failed or if
	* the total size of the email is too large.
	*
	* @param  string $f_data FormTags message
	* @param  string $f_encoding FormTags message encoding
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function messageSet ($f_data,$f_encoding = "")
	{
		global $direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer->messageSet (+f_data,$f_encoding)- (#echo(__LINE__)#)"); }

		if (isset ($direct_settings["swg_sendmailer_{$direct_settings['lang']}_copyright"])) { $f_data .= $direct_settings["swg_sendmailer_{$direct_settings['lang']}_copyright"]; }
		elseif (isset ($direct_settings['swg_sendmailer_copyright'])) { $f_data .= $direct_settings['swg_sendmailer_copyright']; }
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

/**
	* This method will send the email. It will return false if this failed or if
	* the total size of the email is too large.
	*
	* @param  string $f_type Send eMail in default or BCC mode ("single" or "bcc")
	* @param  string $f_from Sender information
	* @param  string $f_subject Title of the eMail
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function send ($f_type,$f_from,$f_subject)
	{
		global $direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer->send ($f_type,$f_from,$f_subject)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (isset ($this->data_formtags))
		{
			$f_data = $direct_globals['formtags']->cleanup ($this->data_formtags['data']);
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($this->data_formtags['data'],"[hr]") !== false) { $this->data_formtags['data'] = str_replace ("[hr]","<div class='pagehr' style='$direct_settings[theme_hr_style]' xml:space='preserve'> </div>",$this->data_formtags['data']); }
			$this->textSet ($this->data_formtags['encoding'],$f_data);

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
.pageborder { border:1px solid #CCCCCC;padding:5px }

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
.pagehighlightbg { background-color:#F0F0FF }
.pagehighlightborder { border:1px solid #294563;padding:4px }

.pagehighlighttable { border-collapse:collapse }
.pagehighlighttable td, .pagehighlighttable th { border:1px solid #294563 }

.pagehr { height:1px;overflow:hidden;border-top:1px solid #CCCCCC }

.pagetable { border-collapse:collapse }
.pagetable td, .pagetable th { border:1px solid #CCCCCC }

.pagetitlecell { background-color:#FFFFFF }
.pagetitlecell { font-size:100%;font-weight:bold;color:#000000 }
.pagetitlecell a, .pagetitlecell a:link, .pagetitlecell a:active, .pagetitlecell a:visited, .pagetitlecell a:hover, .pagetitlecell a:focus { color:#444444 }
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

			$this->xhtmlSet ($this->data_formtags['encoding'],$f_data);
			$f_return = parent::send ($f_type,$f_from,$f_subject);
		}

		return $f_return;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directSendmailerFormtags",true);

//j// Script specific commands

global $direct_settings;
if (!isset ($direct_settings['theme_hr_style'])) { $direct_settings['theme_hr_style'] = "display:block;height:1px;overflow:hidden"; }
}

//j// EOF
?>