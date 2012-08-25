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
/*#ifdef(PHP5n) */

namespace dNG\sWG;
/* #*/
/*#use(direct_use) */
use dNG\sWG\directOHandlerAjaxContent;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

if (!defined ("CLASS_directOHandlerAjaxDialog"))
{
/**
* "directOHandlerAjaxDialog" is responsible for formatting content and displaying
* it as an AJAX dialog.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage output
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class directOHandlerAjaxDialog extends directOHandlerAjaxContent
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directOHandlerAjaxDialog)
	*
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		parent::__construct ();
		$this->osetSet ("ajax_dialog");
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directOHandlerAjaxDialog
	*
	* @since v0.1.01
*\/
	function directOHandlerAjaxDialog () { $this->__construct (); }
:#*/
/**
	* There are 4 different types of errors. The behavior of
	* "outputSendError ()" ranges from a simple error message (continuing
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
	/*#ifndef(PHP4) */public /* #*/function outputSendError ($f_type,$f_error,$f_extra_data = "",$f_error_position = "")
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->outputSendError ($f_type,$f_error,+f_extra_data,$f_error_position)- (#echo(__LINE__)#)"); }

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

		$this->relatedManager ("error_".(preg_replace ("#\W+#","",$f_type))."_".(preg_replace ("#\W+#","",$f_error)),"pre_module_service_action_ajax");

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
			$direct_cachedata['output_link_back'] = (((isset ($direct_cachedata['page_backlink']))&&($direct_cachedata['page_backlink'])&&($direct_cachedata['page_this'] != $direct_cachedata['page_backlink'])) ? direct_linker_dynamic ("url0",$direct_cachedata['page_backlink']) : "");
			$direct_cachedata['output_link_retry'] = ($direct_cachedata['page_this'] ? direct_linker_dynamic ("url0",$direct_cachedata['page_this']) : "");

			if (($f_type == "login")&&(direct_class_function_check ($direct_globals['kernel'],"vUsertypeGetInt")))
			{
				if ($direct_globals['kernel']->vUsertypeGetInt ($direct_settings['user']['type'])) { $direct_cachedata['output_current_user'] = $direct_settings['user']['name_html']; }
				else { $direct_cachedata['output_current_user'] = direct_local_get ("core_guest"); }

				if ($direct_cachedata['page_this']) { $direct_cachedata['output_link_login'] = direct_linker_dynamic ("url0","m=account;s=status;a=login;dsd=source+".(urlencode (base64_encode ($direct_cachedata['page_this'])))); }
				elseif ($direct_cachedata['page_backlink']) { $direct_cachedata['output_link_login'] = direct_linker_dynamic ("url0","m=account;s=status;a=login;dsd=source+".(urlencode (base64_encode ($direct_cachedata['page_backlink'])))); }
				else { $direct_cachedata['output_link_login'] = direct_linker_dynamic ("url0","m=account;s=status;a=login"); }

				$f_continue_check = $this->oset ("default","error_login");
			}
			else { $f_continue_check = $this->oset ("default","error_standard"); }
		}
		else { $f_continue_check = false; }

		$this->relatedManager ("error_".(preg_replace ("#\W+#","",$f_type))."_".(preg_replace ("#\W+#","",$f_error)),"post_module_service_action_ajax");
		if ((USE_backtrace)||($f_type == "fatal")) { $direct_cachedata['core_debug_backtrace'] = $direct_globals['basic_functions']->backtraceGet (); }

		if ($f_continue_check)
		{
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

define ("CLASS_directOHandlerAjaxDialog",true);

//j// Script specific commands

global $direct_globals;
$direct_globals['@names']['output'] = 'dNG\sWG\directOHandlerAjaxDialog';
}

//j// EOF
?>