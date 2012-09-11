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
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/

/*#use(direct_use) */
use dNG\sWG\directVirtualClass;
/* #\n*/

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

if (!defined ("CLASS_directSubkernelCp"))
{
/**
* Subkernel for: cp
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage cp
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directSubkernelCp extends directVirtualClass
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directSubkernelCp)
	*
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->__construct (directSubkernelCp)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about the available function
------------------------------------------------------------------------- */

		$this->functions['subkernelInit'] = true;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directSubkernelCp
	*
	* @since v0.1.00
*\/
	function directSubkernelCp () { $this->__construct (); }
:#*/
/**
	* Running subkernel specific checkups.
	*
	* @param  string $f_threshold_id This parameter is used to determine if
	*         a request to write data is below the threshold (timeout).
	* @return boolean True if the checkup finishes successfully
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function subkernelInit ($f_threshold_id = "")
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (2,"sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ($f_threshold_id)- (#echo(__LINE__)#)"); }

		$f_return = array ();

		if (file_exists ($direct_settings['path_data']."/settings/nim/swg_nim_runonce.xml"))
		{
			if (strpos ($direct_settings['s'],"nim/") === 0) { $direct_settings['user']['type'] = "ad"; }
			else { $f_return = array ("core_unconfigured","","sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)"); }
		}
		elseif ((!$direct_globals['basic_functions']->includeClass ('dNG\sWG\directDB'))||(!direct_class_init ("db"))) { $f_return = array ("errors_core_unknown_error","FATAL ERROR: Unable to instantiate &quot;db&quot;.","sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)"); }
		elseif ($direct_globals['db']->vConnect ())
		{
			$direct_globals['kernel']->vUserInit ($f_threshold_id);

			if (($direct_settings['ohandler'] == "atom")||($direct_settings['ohandler'] == "jsonrpc")||($direct_settings['ohandler'] == "xmlrpc"))
			{
				$f_continue_check = $direct_globals['basic_functions']->includeFile ($direct_settings['path_system']."/functions/web_services/swg_http_auth.php");

				if ($f_continue_check) { $f_continue_check = ((($direct_settings['swg_pyhelper'])&&((!isset ($direct_settings['swg_pyhelper_client']))||($direct_settings['user_ip'] == $direct_settings['swg_pyhelper_client']))&&(direct_web_http_auth_pw_basic_check ($direct_settings['swg_pyhelper_password']))) ? false : true); }
				else { $f_return = array ("core_required_object_not_found","FATAL ERROR: &quot;system/functions/web_services/swg_http_auth.php&quot; was not found","sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)"); }

				if ($f_continue_check) { direct_web_http_auth_check (); }
			}
			else { $f_continue_check = true; }

			if ($f_continue_check)
			{
/* -------------------------------------------------------------------------
Checking up basic rights
------------------------------------------------------------------------- */

				if (direct_class_function_check ($direct_globals['kernel'],"vGroupInit"))
				{
					$direct_globals['kernel']->vGroupInit ();
					if (($direct_globals['kernel']->vUsertypeGetInt ($direct_settings['user']['type']) < 3)&&(!$direct_globals['kernel']->vGroupUserCheckRight ("cp_access"))) { $f_return = array ("core_access_denied","sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)"); }
				}
				elseif ($direct_settings['user']['type'] != "ad") { $f_return = array ("core_access_denied","","sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)"); }
			}
		}
		else { $f_return = array ("core_database_error","FATAL ERROR: Error while setting up a database connection","sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)"); }

		if ((empty ($f_return))&&(!$direct_globals['basic_functions']->settingsGet ($direct_settings['path_data']."/settings/swg_cp.php"))) { $f_return = array ("core_required_object_not_found","FATAL ERROR: &quot;$direct_settings[path_data]/settings/swg_cp.php&quot; was not found","sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)"); }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directSubkernelCp",true);

//j// Script specific commands

$direct_globals['@names']['subkernel_cp'] = "directSubkernelCp";

direct_class_init ("subkernel_cp");
$direct_globals['kernel']->vCallSet ("vSubkernelInit",$direct_globals['subkernel_cp'],"subkernelInit");
}

//j// EOF
?>