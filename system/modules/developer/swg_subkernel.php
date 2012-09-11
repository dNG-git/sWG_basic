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
* Subkernel for: developer
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
* @subpackage developer
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/

/*#use(direct_use) */
use dNG\sWG\directVirtualClass;
/* #\n*/

//j// Basic configuration

if (!defined ("direct_product_iversion")) { exit (); }

//j// Functions and classes

if (!defined ("CLASS_directSubkernelDeveloper"))
{
/**
* Subkernel for: developer
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage developer
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directSubkernelDeveloper extends directVirtualClass
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directSubkernelDeveloper)
	*
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->__construct (directSubkernelDeveloper)- (#echo(__LINE__)#)"); }

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
	* Constructor (PHP4) directSubkernelDeveloper
	*
	* @since v0.1.00
*\/
	function directSubkernelDeveloper () { $this->__construct (); }
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

		if (($direct_globals['basic_functions']->includeClass ('dNG\sWG\directDB'))&&(direct_class_init ("db"))) { $f_return = array (); }
		else { $f_return = array ("errors_core_unknown_error","FATAL ERROR: Unable to instantiate &quot;db&quot;.","sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)"); }

		if (empty ($f_return))
		{
			if ($direct_globals['db']->vConnect ())
			{
				$direct_globals['kernel']->vUserInit ($f_threshold_id);

/* -------------------------------------------------------------------------
Checking up basic rights
------------------------------------------------------------------------- */

				if (direct_class_function_check ($direct_globals['kernel'],"vGroupInit"))
				{
					$direct_globals['kernel']->vGroupInit ();

					if ($direct_globals['kernel']->vUsertypeGetInt ($direct_settings['user']['type']) > 2)
					{
						if (($direct_globals['kernel']->vUsertypeGetInt ($direct_settings['user']['type']) < 4)&&(!$direct_globals['kernel']->vGroupUserCheckRight ("developer_access"))) { $f_return = array ("core_access_denied","sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)"); }
					}
					else { $f_return = array ("core_access_denied","","sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)"); }
				}
				else
				{
					if ($direct_settings['user']['type'] != "ad") { $f_return = array ("core_access_denied","","sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)"); }
				}
			}
			else { $f_return = array ("core_database_error","FATAL ERROR: Error while setting up a database connection","sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)"); }
		}

		if (empty ($f_return))
		{
			if ($direct_globals['basic_functions']->settingsGet ($direct_settings['path_data']."/settings/swg_developer.php"))
			{
				if (!$direct_settings['developer']) { $f_return = array ("core_service_inactive","","sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)"); }
			}
			else { $f_return = array ("core_required_object_not_found","FATAL ERROR: &quot;$direct_settings[path_data]/settings/swg_developer.php&quot; was not found","sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)"); }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directSubkernelDeveloper",true);

//j// Script specific commands

$direct_globals['@names']['subkernel_developer'] = "directSubkernelDeveloper";

direct_class_init ("subkernel_developer");
$direct_globals['kernel']->vCallSet ("vSubkernelInit",$direct_globals['subkernel_developer'],"subkernelInit");
}

//j// EOF
?>