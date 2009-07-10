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
* We need a redirecting script to convert search engine compatible static
* to sWG readable ones.
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
* @subpackage shadow
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

/* -------------------------------------------------------------------------
To get this tool working you will have to specify the local path to
"/swg.php" or "/index.php". The redirector gets a semicolon separated
request defining target module, system and action as well as dynamic service
data. It will convert these human-readable data and access specially
prepared functions to proceed.
------------------------------------------------------------------------- */

$my_swg_file = "<<CHANGE ME NOW>>";

//j// Basic configuration

import_request_variables ("CGP","i_");

//j// Script specific commands

if ((!$my_swg_file)||($my_swg_file == "<<CHANGE ME NOW>>")) { $my_swg_file = "swg.php"; }
define (OW_PHP_SELF,$my_swg_file);

if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($_SERVER['QUERY_STRING'],"&amp;") !== false) { parse_str (preg_replace ("#&amp;#i","&",$_SERVER['QUERY_STRING'])); }

header ("Cache-Control: no-cache, must-revalidate",true);
header ("Pragma: no-cache",true);
header ("Expires: ".(gmdate ("D, d M Y H:i:s",(time () - 2419200)))." GMT",true);
header ("Last-Modified: ".(gmdate ("D, d M Y H:i:s",(time () - 2419200)))." GMT",true);

if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($_SERVER['QUERY_STRING'],"/page.htm") === false)
{
/* -------------------------------------------------------------------------
Stay compatible with old Shadow URLs (<= v0.1.00 (before 03/02/2006))
------------------------------------------------------------------------- */

	$g_redirect_string = str_replace (".htm","",$_SERVER['QUERY_STRING']);
	$g_redirect_string = urldecode (str_replace (".0.","%",$g_redirect_string));
	$g_redirect_string = base64_decode (preg_replace ("#swg_(.*?)$#","\\1",$g_redirect_string));

	$g_redirect_options_array = explode ("&",$g_redirect_string);
	unset ($g_redirect_string);

	if (!empty ($g_redirect_options_array))
	{
		foreach ($g_redirect_options_array as $g_redirect_option)
		{
			$g_redirect_option_array = explode ("=",$g_redirect_option,2);

			if ($g_redirect_option_array[0] == "m") { $i_m = $g_redirect_option_array[1]; }
			if ($g_redirect_option_array[0] == "s") { $i_s = $g_redirect_option_array[1]; }
			if ($g_redirect_option_array[0] == "a") { $i_a = $g_redirect_option_array[1]; }
			if ($g_redirect_option_array[0] == "dsd") { $i_dsd = $g_redirect_option_array[1]; }
		}
	}
}
else
{
	$g_redirect_string = preg_replace ("#^/#","",$_SERVER['QUERY_STRING']);
	$g_redirect_string = str_replace ("/page.htm","",$g_redirect_string);

	$g_redirect_options_array = explode ("/",$g_redirect_string);
	unset ($g_redirect_string);

	if (!empty ($g_redirect_options_array))
	{
		foreach ($g_redirect_options_array as $g_redirect_option)
		{
			$g_redirect_option_array = explode ("-",$g_redirect_option,2);

			if ($g_redirect_option_array[0] == "m") { $i_m = $g_redirect_option_array[1]; }
			if ($g_redirect_option_array[0] == "s") { $i_s = $g_redirect_option_array[1]; }
			if ($g_redirect_option_array[0] == "a") { $i_a = $g_redirect_option_array[1]; }
			if ($g_redirect_option_array[0] == "dsd") { $i_dsd = $g_redirect_option_array[1]; }
		}
	}
}

$g_redirect_option = NULL;
$g_redirect_option_array = NULL;
$g_redirect_options_array = NULL;

@include ($my_swg_file);

//j// EOF
?>