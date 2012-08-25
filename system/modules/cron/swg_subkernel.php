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
* Subkernel for: cron
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
* @subpackage cron
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
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

if (!defined ("CLASS_directSubkernelCron"))
{
/**
* Subkernel for: cron
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage cron
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class directSubkernelCron extends directVirtualClass
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directSubkernelCron)
	*
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->__construct (directSubkernelCron)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about the available function
------------------------------------------------------------------------- */

		$direct_settings['swg_theme_deactivated'] = true;
		$this->functions['subkernelInit'] = true;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directSubkernelCron
	*
	* @since v0.1.00
*\/
	function directSubkernelCron () { $this->__construct (); }
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
				if ((isset ($direct_settings['swg_cron_client']))&&($direct_settings['user_ip'] != $direct_settings['swg_cron_client'])) { $f_return = array ("core_access_denied","","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }
			}
			else { $f_return = array ("core_database_error","FATAL ERROR: Error while setting up a database connection","sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)"); }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directSubkernelCron",true);

//j// Script specific commands

$direct_globals['@names']['subkernel_cron'] = "directSubkernelCron";

direct_class_init ("subkernel_cron");
$direct_globals['kernel']->vCallSet ("vSubkernelInit",$direct_globals['subkernel_cron'],"subkernelInit");
}

//j// EOF
?>