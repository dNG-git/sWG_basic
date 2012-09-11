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

if (!defined ("CLASS_directIHandlerShadow"))
{
/**
* "directIHandlerShadow" parses HTTP requests from search engines.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage input
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directIHandlerShadow extends directIHandlerHttp
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directIHandlerShadow)
	*
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -input->__construct (directIHandlerShadow)- (#echo(__LINE__)#)"); }

		$f_iline = "";

		if (isset ($_SERVER['QUERY_STRING']))
		{
			$f_a = "";
			$f_dsd = "";
			$f_m = "";
			$f_s = "";
			$f_shadow_string = ((strpos ($_SERVER['QUERY_STRING'],"shadow;") === 0) ? substr ($_SERVER['QUERY_STRING'],7) : $_SERVER['QUERY_STRING']);

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_shadow_string,"/page.htm") === false)
			{
/* -------------------------------------------------------------------------
Stay compatible with old Shadow URLs (<= v0.1.00 (before 03/02/2006))
------------------------------------------------------------------------- */

				$f_shadow_string = str_replace (".htm","",$f_shadow_string);
				$f_shadow_string = urldecode (str_replace (".0.","%",$f_shadow_string));
				$f_shadow_string = base64_decode (preg_replace ("#swg_(.*?)$#","\\1",$f_shadow_string));

				$f_shadow_options_array = explode ("&",$f_shadow_string);
				$f_shadow_option_separator = "=";
			}
			else
			{
				$f_shadow_string = preg_replace ("#^[\/]+#","",$f_shadow_string);
				$f_shadow_string = str_replace ("/page.htm","",$f_shadow_string);

				$f_shadow_options_array = explode ("/",$f_shadow_string);
				$f_shadow_option_separator = "-";
			}

			if (!empty ($f_shadow_options_array))
			{
				foreach ($f_shadow_options_array as $f_shadow_option)
				{
					$f_shadow_option_array = explode ($f_shadow_option_separator,$f_shadow_option,2);

					if (isset ($f_shadow_option_array[1]))
					{
						switch ($f_shadow_option_array[0])
						{
						case "a":
						{
							$f_a = $f_shadow_option_array[1];
							break 1;
						}
						case "m":
						{
							$f_m = $f_shadow_option_array[1];
							break 1;
						}
						case "s":
						{
							$f_s = $f_shadow_option_array[1];
							break 1;
						}
						case "dsd":
						{
							$f_dsd = $f_shadow_option_array[1];
							break 1;
						}
						default:
						{
							if ($f_iline) { $f_iline .= ";"; }
							$f_iline .= $f_shadow_option_array[0]."=".$f_shadow_option_array[1];
						}
						}
					}
				}
			}

			if (strlen ($f_m)) { $direct_settings['m'] = preg_replace ("#[;\/\\\?:@\=\&\. \+]+#","",$f_m); }

			if (strlen ($f_s))
			{
				$f_s = ((strpos ($f_s," ") === false) ? $f_s : urlencode ($f_s));
				$direct_settings['s'] = preg_replace (array ("#[\+]+#i","#^\W*#","#[\/\\\?:@\=\&\.]+#","#\W*$#","#\\x20+#"),(array (" ","","","","/")),$f_s);
			}

			if (strlen ($f_a)) { $direct_settings['a'] = preg_replace ("#[;\/\\\?:@\=\&\. \+]+#","",(urldecode ($f_a))); }
			$f_iline = (((strlen ($f_dsd))&&(strpos ($f_dsd," ") !== false)) ? "dsd=".(urlencode ($f_dsd)) : "dsd=".$f_dsd).";".$f_iline;
		}

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ($f_iline);
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directIHandlerShadow
	*
	* @since v0.1.01
*\/
	function directIHandlerShadow () { $this->__construct (); }
:#*/
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directIHandlerShadow",true);

//j// Script specific commands

global $direct_globals;
$direct_globals['@names']['input'] = 'dNG\sWG\directIHandlerShadow';
}

//j// EOF
?>