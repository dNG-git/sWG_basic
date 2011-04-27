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

$g_continue_check = ((defined ("CLASS_direct_oatom")) ? false : true);
if (($g_continue_check)&&(!defined ("CLASS_direct_oxhtml"))) { $g_continue_check = ($direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_ohandler_xhtml.php",1) ? defined ("CLASS_direct_oxhtml") : false); }

if ($g_continue_check)
{
//c// direct_oatom
/**
* "direct_oatom" is responsible for formatting content and displaying
* it as a Atom feed.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage output
* @uses       CLASS_direct_oxhtml
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_oatom extends direct_oxhtml
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_oatom->__construct () and direct_oatom->direct_oatom ()
/**
	* Constructor (PHP5) __construct (direct_oxhtml)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_class->__construct (direct_oatom)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		$direct_settings['swg_force_notheme'] = true;
		parent::__construct ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_oatom (direct_oatom)
	*
	* @since v0.1.01
*\/
	function direct_oatom () { $this->__construct (); }
:#*/
	//f// direct_oatom->output_response ($f_title = "",$f_headers = NULL)
/**
	* This function will actually send the prepared content and debug information
	* to user.
	*
	* @param string $f_title Valid XHTML page title
	* @uses  direct_debug()
	* @uses  direct_html_encode_special()
	* @uses  direct_local_get()
	* @uses  direct_output_inline::theme_page()
	* @uses  USE_debug_reporting
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function output_response ($f_title = "",$f_headers = NULL)
	{
		global $direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class->output_response (+f_title,+f_headers)- (#echo(__LINE__)#)"); }

		$this->output_header ("Content-Type","application/atom+xml; charset=".$direct_local['lang_charset']);

		$this->output_data = "<?xml version='1.0' encoding='$direct_local[lang_charset]' ?><feed xmlns='http://www.w3.org/2005/Atom' xmlns:history='http://purl.org/syndication/history/1.0'><generator>$direct_settings[product_lcode_txt] by the direct Netware Group</generator>";
		if ($f_title != NULL) { $this->output_data .= "<title type='xhtml'>".($direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "div","value" => $f_title,"attributes" => array ("xmlns" => "http://www.w3.org/1999/xhtml"))))."</title>"; }
		$this->output_data .= $this->output_content."<history:incremental>true</history:incremental></feed>";

		parent::output_response (NULL,$f_headers);
	}

	//f// direct_oatom->output_send_error ($f_type,$f_error,$f_extra_data = "",$f_error_position = "")
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
	* @uses  direct_basic_functions::require_file()
	* @uses  direct_basic_functions_inline::emergency_mode()
	* @uses  direct_class_function_check()
	* @uses  direct_class_init()
	* @uses  direct_debug()
	* @uses  direct_error_functions::backtrace_get()
	* @uses  direct_kernel_system::service_init()
	* @uses  direct_kernel_system::v_usertype_get_int()
	* @uses  direct_linker()
	* @uses  direct_local_get()
	* @uses  direct_output::options_flush()
	* @uses  direct_output::oset()
	* @uses  direct_output_inline::header()
	* @uses  direct_output_inline::output_send()
	* @uses  USE_debug_reporting
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function output_send_error ($f_type,$f_error,$f_extra_data = "",$f_error_position = "")
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class->output_send_error ($f_type,$f_error,+f_extra_data)- (#echo(__LINE__)#)"); }

		$f_continue_check = true;
		if (!function_exists ("direct_linker")) { $direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_linker.php"); }

		if ((isset ($direct_globals['kernel']))&&(direct_class_function_check ($direct_globals['kernel'],"service_init")))
		{
			$f_service_error = $direct_globals['kernel']->service_init ();

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

			$f_id_tag = $direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "id","value" => "urn:de.direct-netware.xmlns:atom.parameters:".$direct_cachedata['page_this']));
			$f_updated_tag = $direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "updated","value" => gmdate ("c",$direct_cachedata['core_time'])));

			$this->output_content = $f_updated_tag.$f_id_tag;
			if ($direct_cachedata['page_this']) { $this->output_content .= $direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "link","attributes" => array ("href" => $direct_cachedata['page_this'],"rel" => "alternate","type" => "application/xhtml+xml"))); }

$this->output_content .= ("<entry><title type='xhtml'>".($direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "div","value" => $direct_cachedata['output_error'],"attributes" => array ("xmlns" => "http://www.w3.org/1999/xhtml"))))."</title>
<content type='application/xml'>".($direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "details","value" => $direct_cachedata['output_error_extradata'],"attributes" => array ("xmlns" => "urn:de.direct-netware.xmlns:atom.error"))))."</content>
$f_updated_tag".($direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "id","value" => "urn:de.direct-netware.xmlns:atom.id:error_{$direct_settings['user_ip']}_".$direct_cachedata['core_time'])))."
</entry>");
		}
		else { $f_continue_check = false; }

		if ((USE_backtrace)||($f_type == "fatal")) { $direct_cachedata['core_debug_backtrace'] = $direct_globals['basic_functions']->backtrace_get (); }

		if ($f_continue_check)
		{
			$this->output_header ("HTTP/1.1","HTTP/1.1 500 Internal Server Error",true);
			$this->options_flush ();
			$this->header (false,true,@$direct_settings['p3p_url'],@$direct_settings['p3p_cp']);

			$f_title = (($f_type == "fatal") ? direct_local_get ("core_error_fatal") : direct_local_get ("core_error"));
			$this->output_send ($f_title);
		}
		else { parent::output_send_error ("fatal",$f_error,$f_extra_data."<br /><br />Request terminated",$f_error_position); }

/*#ifndef(PHP4) */
		$direct_cachedata['core_service_activated'] = true;
		throw new RuntimeException ($f_error);
/* #*//*#ifdef(PHP4):
		exit ();
:#\n*/
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_globals['@names']['output'] = "direct_oatom";
define ("CLASS_direct_oatom",true);
}

//j// EOF
?>