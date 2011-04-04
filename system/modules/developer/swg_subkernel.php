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
* @uses       direct_product_iversion
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

//j// Basic configuration

if (!defined ("direct_product_iversion")) { exit (); }

//j// Functions and classes

/* -------------------------------------------------------------------------
Testing for required classes
------------------------------------------------------------------------- */

if (!defined ("CLASS_direct_subkernel_developer"))
{
//c// direct_subkernel_developer
/**
* Subkernel for: developer
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage developer
* @uses       CLASS_direct_virtual_class
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_subkernel_developer extends direct_virtual_class
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_subkernel_developer->__construct () and direct_subkernel_developer->direct_subkernel_developer ()
/**
	* Constructor (PHP5) __construct (direct_subkernel_developer)
	*
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel_class->__construct (direct_subkernel_developer)- (#echo(__LINE__)#)"); }

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
	* Constructor (PHP4) direct_subkernel_developer (direct_subkernel_developer)
	*
	* @since v0.1.00
*\/
	function direct_subkernel_developer () { $this->__construct (); }
:#*/
	//f// direct_subkernel_developer->subkernel_init ($f_threshold_id = "")
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

		if (($direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_db.php"))&&(direct_class_init ("db"))) { $f_return = array (); }
		else { $f_return = array ("errors_core_unknown_error","FATAL ERROR: Unable to instantiate &quot;db&quot;.","sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_init ()- (#echo(__LINE__)#)"); }

		if (empty ($f_return))
		{
			if ($direct_globals['db']->v_connect ())
			{
				$direct_globals['kernel']->v_user_init ($f_threshold_id);

/* -------------------------------------------------------------------------
Checking up basic rights
------------------------------------------------------------------------- */

/*i// LICENSE_WARNING
----------------------------------------------------------------------------
The sWG Group Class has been published under the General Public License.
----------------------------------------------------------------------------
LICENSE_WARNING_END //i*/

				if (direct_class_function_check ($direct_globals['kernel'],"v_group_user_check_right"))
				{
					$direct_globals['kernel']->v_group_init ();

					if ($direct_globals['kernel']->v_usertype_get_int ($direct_settings['user']['type']) > 2)
					{
						if (($direct_globals['kernel']->v_usertype_get_int ($direct_settings['user']['type']) < 4)&&(!$direct_globals['kernel']->v_group_user_check_right ("developer_access"))) { $f_return = array ("core_access_denied","sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_init ()- (#echo(__LINE__)#)"); }
					}
					else { $f_return = array ("core_access_denied","","sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_init ()- (#echo(__LINE__)#)"); }
				}
				else
				{
					if ($direct_settings['user']['type'] != "ad") { $f_return = array ("core_access_denied","","sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_init ()- (#echo(__LINE__)#)"); }
				}
			}
			else { $f_return = array ("core_database_error","FATAL ERROR: Error while setting up a database connection","sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_init ()- (#echo(__LINE__)#)"); }
		}

		if (empty ($f_return))
		{
			if ($direct_globals['basic_functions']->settings_get ($direct_settings['path_data']."/settings/swg_developer.php"))
			{
				if (!$direct_settings['developer']) { $f_return = array ("core_service_inactive","","sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_init ()- (#echo(__LINE__)#)"); }
			}
			else { $f_return = array ("core_required_object_not_found","FATAL ERROR: &quot;$direct_settings[path_data]/settings/swg_developer.php&quot; was not found","sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_init ()- (#echo(__LINE__)#)"); }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_init ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_globals['@names']['subkernel_developer'] = "direct_subkernel_developer";
define ("CLASS_direct_subkernel_developer",true);

//j// Script specific commands

direct_class_init ("subkernel_developer");
$direct_globals['kernel']->v_call_set ("v_subkernel_init",$direct_globals['subkernel_developer'],"subkernel_init");
}

//j// EOF
?>