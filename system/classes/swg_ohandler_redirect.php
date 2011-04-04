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

$g_continue_check = ((defined ("CLASS_direct_oredirect")) ? false : true);
if (($g_continue_check)&&(!defined ("CLASS_direct_oxhtml"))) { $g_continue_check = ($direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_ohandler_xhtml.php",1) ? defined ("CLASS_direct_oxhtml") : false); }

if ($g_continue_check)
{
//c// direct_oredirect
/**
* "direct_oredirect" changes the input handler to parse HTTP redirect
* requests as send in e-Mails.
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
class direct_oredirect extends direct_oxhtml
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_basic_functions->__construct () and direct_basic_functions->direct_basic_functions ()
/**
	* Constructor (PHP5) __construct (direct_oredirect)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_class->__construct (direct_oredirect)- (#echo(__LINE__)#)"); }

		if ($direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_ihandler_redirect.php",1))
		{
			direct_class_init ("input",true);
			$direct_settings['ihandler'] = "redirect";
		}

		$direct_settings['ohandler'] = "xhtml";

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_oredirect (direct_oredirect)
	*
	* @since v0.1.01
*\/
	function direct_oredirect () { $this->__construct (); }
:#*/
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_globals['@names']['output'] = "direct_oredirect";
define ("CLASS_direct_oredirect",true);
}

//j// EOF
?>