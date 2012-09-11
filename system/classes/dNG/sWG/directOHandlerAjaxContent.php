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
use dNG\sWG\directOHandlerAjax;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

if (!defined ("CLASS_directOHandlerAjaxContent"))
{
/**
* "directOHandlerAjaxContent" is responsible for formatting content and displaying
* it as an AJAX dialog.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage output
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directOHandlerAjaxContent extends directOHandlerAjax
{
/*#ifdef(PHP4):
/* -------------------------------------------------------------------------
Extend the class using old behavior
------------------------------------------------------------------------- *\/

/**
	* Constructor (PHP4) directOHandlerAjaxContent
	*
	* @since v0.1.01
*\/
	function directOHandlerAjaxContent () { $this->__construct (); }
:#\n*/
/**
	* We need some header outputs for redirecting, that's why there exists this
	* function
	*
	* @param  string $f_url The target URL
	* @param  boolean $f_use_current_url True for allowing the redirect to be
	*         cached
	* @since  v0.1.02
*/
	/*#ifndef(PHP4) */public /* #*/function redirect ($f_url,$f_use_current_url = true,$f_js_redirect = true)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->redirect ($f_url,+f_use_current_url)- (#echo(__LINE__)#)"); }

		if ($f_js_redirect)
		{
			$this->output_content = ($f_use_current_url ? "<script type='text/javascript'><![CDATA[ self.location.replace (\"".(str_replace ('"','\"',$f_url))."\"); ]]></script>" : "<script type='text/javascript'><![CDATA[ self.location.href = \"".(str_replace ('"','\"',$f_url))."\"; ]]></script>");
			$this->header ($f_use_current_url);
			$this->outputSend ();

			$direct_cachedata['core_service_activated'] = true;
		}
		else { parent::redirect ($f_url,$f_use_current_url); }
	}

/**
	* This function will actually send the prepared content and debug information
	* to user.
	*
	* @param string $f_title Valid XHTML page title
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function outputResponse ($f_title = "",$f_headers = NULL)
	{
		global $direct_cachedata,$direct_globals;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->outputResponse (+f_title,+f_headers)- (#echo(__LINE__)#)"); }

		$f_data_array = explode ("<script",$this->output_content);
		$f_occurrences = (count ($f_data_array) - 1);
		$f_script = "";

		for ($f_i = $f_occurrences;$f_i > 0;$f_i--)
		{
			$f_data_closed_array = explode ("</script>",$f_data_array[$f_i],2);
			unset ($f_data_array[$f_i]);

			if (count ($f_data_closed_array) > 1)
			{
				if ($f_script) { $f_script .= "\n"; }
				$f_script .= substr ($f_data_closed_array[0],(strpos ($f_data_closed_array[0],">") + 1));
				unset ($f_data_closed_array[0]);

				$f_data_array[($f_i - 1)] .= $f_data_closed_array[1];
			}
			else { $f_data_array[($f_i - 1)] .= $f_data_closed_array[0]; }
		}

		$this->output_content = "<swgAJAX xmlns='urn:de-direct-netware-xmlns:swg.swgAJAX.js.v1'><content><![CDATA[".(str_replace ("]]>","]]]]><![CDATA[>",$f_data_array[0]))."]]></content><content_hide>1</content_hide>";
		if ($f_title != NULL) { $this->output_content .= $direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "title","value" => $f_title)); }

		if (isset ($direct_cachedata['output_ajax_javascript_requirements']))
		{
			$f_script_closure = "";

			foreach ($direct_cachedata['output_ajax_javascript_requirements'] as $f_ajax_requirement_definition)
			{
				if ($f_script_closure) { $f_script_closure .= ","; }
				else { $f_script_closure = "djs_load_functions([ "; }

				$f_script_closure .= "{ $f_ajax_requirement_definition }";
			}

			$f_script_closure .= " ])";
		}

		if ($f_script)
		{
			if (isset ($direct_cachedata['output_ajax_javascript_requirements'])) { $f_script = $f_script_closure.".done (function ()\n{\n$f_script\n});"; }
			$this->output_content .= "<javascript><![CDATA[\n".(str_replace (array ("<![CDATA[","]]>"),"",$f_script))."\n]]></javascript>";
		}
		elseif (isset ($direct_cachedata['output_ajax_javascript_requirements'])) { $this->output_content .= "<javascript><![CDATA[$f_script_closure;]]></javascript>"; }

		if ((isset ($direct_cachedata['output_ajax_closeable']))&&(!$direct_cachedata['output_ajax_closeable'])) { $this->output_content .= "<closeable>0</closeable>"; }
		if (isset ($direct_cachedata['output_ajax_width'])) { $this->output_content .= "<width>{$direct_cachedata['output_ajax_width']}</width>"; }
		if ((isset ($direct_cachedata['output_ajax_window_closeable']))&&(!$direct_cachedata['output_ajax_window_closeable'])) { $this->output_content .= "<window_closeable>0</window_closeable>"; }
		if ((isset ($direct_cachedata['output_ajax_window_modal']))&&(!$direct_cachedata['output_ajax_window_modal'])) { $this->output_content .= "<window_modal>0</window_modal>"; }
		$this->output_content .= "</swgAJAX>";

		parent::outputResponse (NULL,$f_headers);
	}

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

			if ($f_type == "fatal") { $f_continue_check = $this->oset ("default_embedded","ajax_error_fatal"); }
			elseif ($f_type == "critical") { $f_continue_check = $this->oset ("default_embedded","ajax_error_critical"); }
			elseif (($f_type == "login")&&(direct_class_function_check ($direct_globals['kernel'],"vUsertypeGetInt")))
			{
				if ($direct_globals['kernel']->vUsertypeGetInt ($direct_settings['user']['type'])) { $direct_cachedata['output_current_user'] = $direct_settings['user']['name_html']; }
				else { $direct_cachedata['output_current_user'] = direct_local_get ("core_guest"); }

				if ($direct_cachedata['page_this']) { $direct_cachedata['output_link_login'] = direct_linker_dynamic ("url0","m=account;s=status;a=login;dsd=source+".(urlencode (base64_encode ($direct_cachedata['page_this'])))); }
				elseif ($direct_cachedata['page_backlink']) { $direct_cachedata['output_link_login'] = direct_linker_dynamic ("url0","m=account;s=status;a=login;dsd=source+".(urlencode (base64_encode ($direct_cachedata['page_backlink'])))); }
				else { $direct_cachedata['output_link_login'] = direct_linker_dynamic ("url0","m=account;s=status;a=login"); }

				$f_continue_check = $this->oset ("default_embedded","ajax_error_login");
			}
			else { $f_continue_check = $this->oset ("default_embedded","ajax_error_standard"); }
		}
		else { $f_continue_check = false; }

		$this->relatedManager ("error_".(preg_replace ("#\W+#","",$f_type))."_".(preg_replace ("#\W+#","",$f_error)),"post_module_service_action_ajax");
		if ((USE_backtrace)||($f_type == "fatal")) { $direct_cachedata['core_debug_backtrace'] = $direct_globals['basic_functions']->backtraceGet (); }

		if ($f_continue_check)
		{
			$this->optionsFlush ();
			$this->header (false,true,@$direct_settings['p3p_url'],@$direct_settings['p3p_cp']);
			$this->outputSend (NULL);
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

define ("CLASS_directOHandlerAjaxContent",true);

//j// Script specific commands

global $direct_globals;
$direct_globals['@names']['output'] = 'dNG\sWG\directOHandlerAjaxContent';
}

//j// EOF
?>