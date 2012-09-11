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
* Input handlers fetch data based in a protocol specific manner.
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
* @subpackage input
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
/*#ifdef(PHP5n) */

namespace dNG\sWG;
/* #*/
/*#use(direct_use) */
use dNG\sWG\directIHandlerHttp;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

if (!defined ("CLASS_directIHandlerRedirect"))
{
/**
* "directIHandlerRedirect" parses HTTP redirect requests as send in e-Mails.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage input
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directIHandlerRedirect extends directIHandlerHttp
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directIHandlerRedirect)
	*
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -iHandler->__construct (directIHandlerRedirect)- (#echo(__LINE__)#)"); }

		$f_continue_check = false;
		$f_iline = "";

		if (isset ($_SERVER['QUERY_STRING']))
		{
			$f_query = (((/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($_SERVER['QUERY_STRING'],"%3b") !== false)&&(strpos ($_SERVER['QUERY_STRING'],";") === false)) ? urldecode ($_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING']);
			if (strpos ($_SERVER['QUERY_STRING'],"redirect;") === 0) { $f_continue_check = true; }
		}

		if ($f_continue_check)
		{
			$f_query_array = explode (";;",(substr ($f_query,9)),2);

			if (isset ($f_query_array[1])) { $f_query_array[0] .= ";"; }
			$f_target_array = explode (";",$f_query_array[0],4);

			$f_a = "";
			$f_dsd = "";
			$f_m = "";
			$f_s = "";

			switch (count ($f_target_array))
			{
			case 4:
			{
				$f_m = (($f_target_array[0] == "-") ? "" : $f_target_array[0]);
				$f_s = (($f_target_array[1] == "-") ? "" : $f_target_array[1]);
				$f_a = (($f_target_array[2] == "-") ? "" : $f_target_array[2]);

				if (isset ($f_query_array[1])) { $f_target_array[3] = $f_query_array[1]; }
				$f_dsd = (($f_target_array[3] == "-") ? "" : $f_target_array[3]);

				break 1;
			}
			case 3:
			{
				$f_m = (($f_target_array[0] == "-") ? "" : $f_target_array[0]);
				$f_s = (($f_target_array[1] == "-") ? "" : $f_target_array[1]);

				if (isset ($f_query_array[1])) { $f_target_array[2] = $f_query_array[1]; }
				$f_dsd = (($f_target_array[2] == "-") ? "" : $f_target_array[2]);

				break 1;
			}
			case 2:
			{
				$f_m = (($f_target_array[0] == "-") ? "" : $f_target_array[0]);
				if (isset ($f_query_array[1])) { $f_target_array[1] = $f_query_array[1]; }
				$f_dsd = (($f_target_array[1] == "-") ? "" : $f_target_array[1]);

				break 1;
			}
			}

			if (strlen ($f_m)) { $direct_settings['m'] = preg_replace ("#[;\/\\\?:@\=\&\. \+]+#","",$f_m); }

			if (strlen ($f_s))
			{
				$f_s = ((strpos ($f_s," ") === false) ? $f_s : urlencode ($f_s));
				$direct_settings['s'] = preg_replace (array ("#[\+]+#i","#^\W*#","#[\/\\\?:@\=\&\.]+#","#\W*$#","#\\x20+#"),(array (" ","","","","/")),$f_s);
			}

			if (strlen ($f_a)) { $direct_settings['a'] = preg_replace ("#[;\/\\\?:@\=\&\. \+]+#","",(urldecode ($f_a))); }
			if ((strlen ($f_dsd))&&(strpos ($f_dsd," ") !== false)) { $f_dsd = urlencode ($f_dsd); }

			$f_iline = ((strpos ($f_dsd,"++") === false) ? "dsd=idata+".$f_dsd : "dsd=".$f_dsd);
		}

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ($f_iline);
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directIHandlerRedirect
	*
	* @since v0.1.01
*\/
	function directIHandlerRedirect () { $this->__construct (); }
:#\n*/
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directIHandlerRedirect",true);

//j// Script specific commands

global $direct_globals;
$direct_globals['@names']['input'] = 'dNG\sWG\directIHandlerRedirect';
}

//j// EOF
?>