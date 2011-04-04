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
* Subkernel for: cp
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
* @subpackage cp
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

/* -------------------------------------------------------------------------
Testing for required classes
------------------------------------------------------------------------- */

if (!defined ("CLASS_direct_subkernel_cp"))
{
//c// direct_subkernel_cp
/**
* Subkernel for: cp
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage cp
* @uses       CLASS_direct_virtual_class
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_subkernel_cp extends direct_virtual_class
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_subkernel_cp->__construct () and direct_subkernel_cp->direct_subkernel_cp ()
/**
	* Constructor (PHP5) __construct (direct_subkernel_cp)
	*
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel_class->__construct (direct_subkernel_cp)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about the available function
------------------------------------------------------------------------- */

		$this->functions['subkernel_init'] = true;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_subkernel_cp (direct_subkernel_cp)
	*
	* @since v0.1.00
*\/
	function direct_subkernel_cp () { $this->__construct (); }
:#*/
	//f// direct_subkernel_cp->subkernel_init ($f_threshold_id = "")
/**
	* Running subkernel specific checkups.
	*
	* @param  string $f_threshold_id This parameter is used to determine if
	*         a request to write data is below the threshold (timeout).
	* @uses   USE_debug_reporting
	* @return boolean True if the checkup finishes successfully
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function subkernel_init ($f_threshold_id = "")
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (2,"sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_init ($f_threshold_id)- (#echo(__LINE__)#)"); }

		$f_return = array ();

		if (file_exists ($direct_settings['path_data']."/settings/nim/swg_nim_runonce.xml"))
		{
			if (strpos ($direct_settings['s'],"nim/") === 0) { $direct_settings['user']['type'] = "ad"; }
			else { $f_return = array ("core_unconfigured","","sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_init ()- (#echo(__LINE__)#)"); }
		}
		else
		{
			if ((!$direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_db.php"))||(!direct_class_init ("db"))) { $f_return = array ("errors_core_unknown_error","FATAL ERROR: Unable to instantiate &quot;db&quot;.","sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_init ()- (#echo(__LINE__)#)"); }
			else
			{
				if ($direct_globals['db']->v_connect ())
				{
					$direct_globals['kernel']->v_user_init ($f_threshold_id);

					if (($direct_settings['ohandler'] == "atom")||($direct_settings['ohandler'] == "json")||($direct_settings['ohandler'] == "xmlrpc"))
					{
						$g_continue_check = $direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/functions/web_services/swg_http_auth.php");

						if ($g_continue_check) { $g_continue_check = ((($direct_settings['swg_pyhelper'])&&((!isset ($direct_settings['swg_pyhelper_client']))||($direct_settings['user_ip'] == $direct_settings['swg_pyhelper_client']))&&(direct_web_http_auth_pw_basic_check ($direct_settings['swg_pyhelper_password']))) ? false : true); }
						else { $f_return = array ("core_required_object_not_found","FATAL ERROR: &quot;$direct_settings[path_system]/functions/web_services/swg_http_auth.php&quot; was not found","sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_init ()- (#echo(__LINE__)#)"); }

						if ($g_continue_check) { direct_web_http_auth_check (); }
					}
					else { $g_continue_check = true; }

					if ($g_continue_check)
					{
/* -------------------------------------------------------------------------
Checking up basic rights
------------------------------------------------------------------------- */

/*i// LICENSE_WARNING
----------------------------------------------------------------------------
The sWG Group Class has been published under the General Public License.
----------------------------------------------------------------------------
LICENSE_WARNING_END //i*/

						if (class_exists ("direct_kernel_group",/*#ifndef(PHP4) */false/* #*/))
						{
							$direct_globals['kernel']->v_group_init ();
							if (($direct_globals['kernel']->v_usertype_get_int ($direct_settings['user']['type']) < 3)&&(!$direct_globals['kernel']->v_group_user_check_right ("cp_access"))) { $f_return = array ("core_access_denied","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }
						}
						else
						{
							if ($direct_settings['user']['type'] != "ad") { $f_return = array ("core_access_denied","","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }
						}
					}
				}
				else { $f_return = array ("core_database_error","FATAL ERROR: Error while setting up a database connection","sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_init ()- (#echo(__LINE__)#)"); }
			}

			if ((empty ($f_return))&&(!$direct_globals['basic_functions']->settings_get ($direct_settings['path_data']."/settings/swg_cp.php"))) { $f_return = array ("core_required_object_not_found","FATAL ERROR: &quot;$direct_settings[path_data]/settings/swg_cp.php&quot; was not found","sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_init ()- (#echo(__LINE__)#)"); }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_init ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_globals['@names']['subkernel_cp'] = "direct_subkernel_cp";
define ("CLASS_direct_subkernel_cp",true);

//j// Script specific commands

direct_class_init ("subkernel_cp");
$direct_globals['kernel']->v_call_set ("v_subkernel_init",$direct_globals['subkernel_cp'],"subkernel_init");
}

//j// EOF
?>