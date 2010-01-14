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
* We are sending URLs to the user via e-Mail. These URLs should look nicer
* than the normal sWG ones. That's why this redirection script exists.
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
* @subpackage redirect
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
define ("OW_PHP_SELF",$my_swg_file);

if (trim ($_SERVER['QUERY_STRING']))
{
	if ((/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($_SERVER['QUERY_STRING'],"%3b") !== false)&&(strpos ($_SERVER['QUERY_STRING'],";") === false)) { $g_query_array = explode (";;",(urldecode ($_SERVER['QUERY_STRING'])),2); }
	else { $g_query_array = explode (";;",$_SERVER['QUERY_STRING'],2); }

	if (isset ($g_query_array[1])) { $g_query_array[0] .= ";"; }
	$g_target_array = explode (";",$g_query_array[0],4);

	switch (count ($g_target_array))
	{
	case 4:
	{
		$i_m = (($g_target_array[0] == "-") ? "" : $g_target_array[0]);
		$i_s = (($g_target_array[1] == "-") ? "" : $g_target_array[1]);
		$i_a = (($g_target_array[2] == "-") ? "" : $g_target_array[2]);
		if (isset ($g_query_array[1])) { $g_target_array[3] = $g_query_array[1]; }
		if ($g_target_array[3] == "-") { $g_target_array[3] = ""; }

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_target_array[3],"++") === false) { $i_dsd = "idata+".(preg_replace ("#\&(.*?)$#","",$g_target_array[3])); }
		else { $i_dsd = preg_replace ("#\&(.*?)$#","",$g_target_array[3]); }

		break 1;
	}
	case 3:
	{
		$i_m = (($g_target_array[0] == "-") ? "" : $g_target_array[0]);
		$i_s = (($g_target_array[1] == "-") ? "" : $g_target_array[1]);
		if (isset ($g_query_array[1])) { $g_target_array[2] = $g_query_array[1]; }
		if ($g_target_array[2] == "-") { $g_target_array[2] = ""; }

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_target_array[2],"++") === false) { $i_dsd = "idata+".(preg_replace ("#\&(.*?)$#","",$g_target_array[2])); }
		else { $i_dsd = preg_replace ("#\&(.*?)$#","",$g_target_array[2]); }

		break 1;
	}
	case 2:
	{
		$i_m = (($g_target_array[0] == "-") ? "" : $g_target_array[0]);
		if (isset ($g_query_array[1])) { $g_target_array[1] = $g_query_array[1]; }
		if ($g_target_array[1] == "-") { $g_target_array[1] = ""; }

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_target_array[1],"++") === false) { $i_dsd = "idata+".(preg_replace ("#\&(.*?)$#","",$g_target_array[1])); }
		else { $i_dsd = preg_replace ("#\&(.*?)$#","",$g_target_array[1]); }

		break 1;
	}
	}

	unset ($g_query_array);
	unset ($g_target_array);
}

@include ($my_swg_file);

//j// EOF
?>