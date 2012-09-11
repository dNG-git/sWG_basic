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
* Output handlers parse and convert data in a protocol specific manner.
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
* @subpackage output
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
/*#ifdef(PHP5n) */

namespace dNG\sWG;
/* #*/
/*#use(direct_use) */
use dNG\sWG\directOHandlerXhtml;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

if (!defined ("CLASS_directOHandlerAtom"))
{
/**
* "directOHandlerAtom" is responsible for formatting content and displaying
* it as a Atom feed.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage output
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directOHandlerAtom extends directOHandlerXhtml
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directOHandlerAtom)
	*
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		parent::__construct ();
		$this->osetSet ("atom");
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directOHandlerAtom
	*
	* @since v0.1.01
*\/
	function directOHandlerAtom () { $this->__construct (); }
:#*/
/**
	* This function will actually send the prepared content and debug information
	* to user.
	*
	* @param string $f_title Valid XHTML page title
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function outputResponse ($f_title = "",$f_headers = NULL)
	{
		global $direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class->output_response (+f_title,+f_headers)- (#echo(__LINE__)#)"); }

		$this->outputHeader ("Content-Type","application/atom+xml; charset=".$direct_local['lang_charset']);

		$this->output_data = "<?xml version='1.0' encoding='$direct_local[lang_charset]' ?><feed xmlns='http://www.w3.org/2005/Atom'>\n<generator>$direct_settings[product_lcode_txt] by the direct Netware Group</generator>\n";
		if ($f_title != NULL) { $this->output_data .= "<title type='xhtml'>".($direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "div","value" => $f_title,"attributes" => array ("xmlns" => "http://www.w3.org/1999/xhtml"))))."</title>\n"; }
		$this->output_data .= $this->output_content."\n</feed>";

		parent::outputResponse (NULL,$f_headers);
	}

/**
	* There are 4 different types of errors. The behavior of
	* "output_send_error ()" ranges from a simple error message (continuing
	* with script) up to critical or fatal error messages (with the current
	* theme) and interrupting the process.
	*
	* @param string $f_type Defines the error type that needs to be managed.
	*        The following types are defined: "critical", "fatal", "login" or
	*        "standard". The default error type is "fatal".
	* @param string $f_error A key for localisation strings or an error message
	* @param string $f_extra_data More detailed information to track down the
	*        problem
	* @param string $f_error_position Position where the error occurred
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function output_send_error ($f_type,$f_error,$f_extra_data = "",$f_error_position = "")
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class->output_send_error ($f_type,$f_error,+f_extra_data)- (#echo(__LINE__)#)"); }

		$f_continue_check = true;
		if (!function_exists ("direct_linker")) { $direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_linker.php"); }

		if ((isset ($direct_globals['kernel']))&&(direct_class_function_check ($direct_globals['kernel'],"serviceInit")))
		{
			$f_service_error = $direct_globals['kernel']->serviceInit ();

			if (!empty ($f_service_error))
			{
				$f_error = $f_service_error[0];
				$f_extra_data = $f_service_error[1];
			}
		}
		else { direct_class_init ("basic_functions"); }

		if (isset ($direct_cachedata['output_error_extradata'])) { $f_continue_check = false; }
		else
		{
			$direct_cachedata['output_error'] = (((!preg_match ("#\W+#i",$f_error))&&(function_exists ("direct_local_get"))) ? direct_local_get ("errors_".$f_error) : $f_error);

			if (strlen ($f_extra_data))
			{
				$direct_cachedata['output_error_extradata'] = preg_replace ("#(\/|\&amp;|\&|\?|,)(?!\>|(\w{2,4};))#"," \\1 \\2",$f_extra_data);
				if ((USE_debug_reporting)&&($f_error_position)) { $direct_cachedata['output_error_extradata'] .= "<br />\n".$f_error_position; }
			}
			elseif ((USE_debug_reporting)&&($f_error_position)) { $direct_cachedata['output_error_extradata'] = $f_error_position; }
			else { $direct_cachedata['output_error_extradata'] = ""; }
		}

		if (($f_continue_check)&&(function_exists ("direct_linker")))
		{
			if (!isset ($direct_cachedata['page_this'])) { $direct_cachedata['page_this'] = ""; }
			$direct_cachedata['output_link_back'] = (((isset ($direct_cachedata['page_backlink']))&&($direct_cachedata['page_backlink'])&&($direct_cachedata['page_this'] != $direct_cachedata['page_backlink'])) ? direct_linker ("url0",$direct_cachedata['page_backlink']) : "");
			$direct_cachedata['output_link_retry'] = ($direct_cachedata['page_this'] ? direct_linker ("url0",$direct_cachedata['page_this']) : "");

			$f_id_tag = $direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "id","value" => "urn:de-direct-netware-xmlns:atom.parameters:".$direct_cachedata['page_this']));
			$f_updated_tag = $direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "updated","value" => gmdate ("c",$direct_cachedata['core_time'])));

			$this->output_content = $f_updated_tag.$f_id_tag;
			if ($direct_cachedata['page_this']) { $this->output_content .= $direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "link","attributes" => array ("href" => $direct_cachedata['page_this'],"rel" => "alternate","type" => "application/xhtml+xml"))); }

$this->output_content .= ("<entry><title type='xhtml'>".($direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "div","value" => $direct_cachedata['output_error'],"attributes" => array ("xmlns" => "http://www.w3.org/1999/xhtml"))))."</title>
<content type='application/xml'>".($direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "details","value" => $direct_cachedata['output_error_extradata'],"attributes" => array ("xmlns" => "urn:de-direct-netware-xmlns:atom.error"))))."</content>
$f_updated_tag".($direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "id","value" => "urn:de-direct-netware-xmlns:atom.id:error_{$direct_settings['user_ip']}_".$direct_cachedata['core_time'])))."
</entry>");
		}
		else { $f_continue_check = false; }

		if ((USE_backtrace)||($f_type == "fatal")) { $direct_cachedata['core_debug_backtrace'] = $direct_globals['basic_functions']->backtraceGet (); }

		if ($f_continue_check)
		{
			if ($this->output_header ("HTTP/1.1",NULL,true) === NULL) { $this->outputHeader ("HTTP/1.1","HTTP/1.1 500 Internal Server Error",true); }
			$this->optionsFlush ();
			$this->header (false,true,@$direct_settings['p3p_url'],@$direct_settings['p3p_cp']);

			$f_title = (($f_type == "fatal") ? direct_local_get ("core_error_fatal") : direct_local_get ("core_error"));
			$this->outputSend ($f_title);
		}
		else { parent::outputSendError ("fatal",$f_error,$f_extra_data."<br /><br />Request terminated",$f_error_position); }

/*#ifndef(PHP4) */
		$direct_cachedata['core_service_activated'] = true;
		throw new /*#ifdef(PHP5n) */\RuntimeException/* #*//*#ifndef(PHP5n):RuntimeException:#*/ ($f_error);
/* #*//*#ifdef(PHP4):
		exit ();
:#\n*/
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directOHandlerAtom",true);

//j// Script specific commands

global $direct_globals;
$direct_globals['@names']['output'] = 'dNG\sWG\directOHandlerAtom';
}

//j// EOF
?>