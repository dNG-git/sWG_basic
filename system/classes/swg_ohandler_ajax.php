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

$g_continue_check = ((defined ("CLASS_direct_oajax")) ? false : true);
if (($g_continue_check)&&(!defined ("CLASS_direct_oxhtml"))) { $g_continue_check = ($direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_ohandler_xhtml.php",1) ? defined ("CLASS_direct_oxhtml") : false); }

if ($g_continue_check)
{
//c// direct_oajax
/**
* "direct_oajax" is responsible for formatting content and displaying
* it as an AJAX dialog.
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
class direct_oajax extends direct_oxhtml
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_oajax->__construct () and direct_oajax->direct_oajax ()
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
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_class->__construct (direct_oajax)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		$direct_settings['swg_force_notheme'] = true;
		parent::__construct ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_oajax (direct_oajax)
	*
	* @since v0.1.01
*\/
	function direct_oajax () { $this->__construct (); }
:#*/
	//f// direct_oajax->output_response ($f_title = "",$f_headers = NULL)
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
		global $direct_local;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class->output_response (+f_title,+f_headers)- (#echo(__LINE__)#)"); }

		$this->output_data = "<?xml version='1.0' encoding='$direct_local[lang_charset]' ?>\n".$this->output_content;
		$this->output_header ("Content-Type","text/xml; charset=".$direct_local['lang_charset']);

		parent::output_response (NULL,$f_headers);
	}

	//f// direct_oajax->output_send_error ($f_type,$f_error,$f_extra_data = "",$f_error_position = "")
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
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class->output_send_error ($f_type,$f_error,+f_extra_data,$f_error_position)- (#echo(__LINE__)#)"); }

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

		$this->related_manager ("error_".(preg_replace ("#\W+#","",$f_type))."_".(preg_replace ("#\W+#","",$f_error)),"pre_module_service_action_ajax");

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

		$this->output_content = "";

		if (($f_continue_check)&&(function_exists ("direct_linker")))
		{
			$this->output_content = "<swg xmlns='urn:de.direct-netware.xmlns:swg.ajax.error.v1'>";
			$this->output_content .= (($f_type == "fatal") ? $direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "title","value" => direct_local_get ("core_error_fatal"))) : $direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "title","value" => direct_local_get ("core_error"))));
			$this->output_content .= $direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "data","value" => $direct_cachedata['output_error']));

			if ($direct_cachedata['output_error_extradata']) { $this->output_content .= $direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "extradata","value" => $direct_cachedata['output_error_extradata'])); }

			if (!isset ($direct_cachedata['page_this'])) { $direct_cachedata['page_this'] = ""; }
			elseif ($direct_cachedata['page_this']) { $this->output_content .= $direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "pagelink","value" => direct_linker ("url0",$direct_cachedata['page_this']))); }

			if ((isset ($direct_cachedata['page_backlink']))&&($direct_cachedata['page_backlink'])&&($direct_cachedata['page_this'] != $direct_cachedata['page_backlink'])) { $this->output_content .= $direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "backlink","value" => direct_linker ("url0",$direct_cachedata['page_backlink']))); }

			if (($f_type == "login")&&(direct_class_function_check ($direct_globals['kernel'],"v_usertype_get_int")))
			{
				if ($direct_globals['kernel']->v_usertype_get_int ($direct_settings['user']['type'])) { $f_current_user = $direct_settings['user']['name_html']; }
				else { $f_current_user = direct_local_get ("core_guest"); }

				$this->output_content .= $direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "username_html","value" => $f_current_user));

				if ($direct_cachedata['page_this']) { $f_link_login = direct_linker ("url0","m=account;s=status;a=login;dsd=source+".(urlencode (base64_encode ($direct_cachedata['page_this'])))); }
				elseif ($direct_cachedata['page_backlink']) { $f_link_login = direct_linker ("url0","m=account;s=status;a=login;dsd=source+".(urlencode (base64_encode ($direct_cachedata['page_backlink'])))); }
				else { $f_link_login = direct_linker ("url0","m=account;s=status;a=login"); }

				$this->output_content .= $direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "loginlink","value" => $f_link_login));
			}
		}

		$this->related_manager ("error_".(preg_replace ("#\W+#","",$f_type))."_".(preg_replace ("#\W+#","",$f_error)),"post_module_service_action_ajax");

		if ($this->output_content)
		{
			if ((USE_backtrace)||($f_type == "fatal"))
			{
				$f_backtrace_array = $direct_globals['basic_functions']->backtrace_get ();

				$this->output_content .= "<backtrace>";
				foreach ($f_backtrace_array as $f_backtrace_line) { $this->output_content .= $direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "data","value" => $f_backtrace_line)); }
				$this->output_content .= "</backtrace>";
			}

			$this->output_content .= "</swg>";
		}

		if ($f_continue_check)
		{
			$this->output_header ("HTTP/1.1","HTTP/1.1 500 Internal Server Error",true);
			$this->options_flush ();
			$this->header (false,true,@$direct_settings['p3p_url'],@$direct_settings['p3p_cp']);
			$this->output_send (NULL);
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

$direct_globals['@names']['output'] = "direct_oajax";
define ("CLASS_direct_oajax",true);
}

//j// EOF
?>