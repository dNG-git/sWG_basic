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
$Id: swg_aphandler.php,v 1.2 2008/12/20 23:04:45 s4u Exp $
#echo(sWGbasicVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* Helfer functions to work with estimated processes using multiple page
* reloads or AJAX.
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
* @subpackage aphandler
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

//f// direct_aphandler_elapsed ($f_seconds)
/**
* Splits the given value in seconds into hours, minutes and seconds.
*
* @param  integer $f_seconds Number of total item
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return integer Calucalted percentage
* @since  v0.1.00
*/
function direct_aphandler_elapsed ($f_seconds)
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_aphandler_elapsed (+f_data)- (#echo(__LINE__)#)"); }

	$f_return = array (0,0,0);

	if ($f_seconds > 59)
	{
		$f_return[2] = ($f_seconds % 60);
		$f_seconds -= $f_return[2];
		$f_return[1] = ($f_seconds / 60);

		if ($f_return[1] > 59)
		{
			$f_return[1] = ($f_return[1] % 60);
			$f_return[0] = floor ($f_return[1] / 60);
		}
	}
	else { $f_return[2] = $f_seconds; }

	if ($f_return[0] < 10) { $f_return[0] = "0".$f_return[0]; }
	if ($f_return[1] < 10) { $f_return[1] = "0".$f_return[1]; }
	if ($f_return[2] < 10) { $f_return[2] = "0".$f_return[2]; }

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_aphandler_elapsed ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_aphandler_estimated ($f_time_start,$f_items_done,$f_items)
/**
* Calculates the estimated time until the process will finish.
*
* @param  integer $f_time_start UNIX timestamp
* @param  integer $f_items_done Completed items
* @param  integer $f_items Number of total item
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return integer Calucalted percentage
* @since  v0.1.00
*/
function direct_aphandler_estimated ($f_time_start,$f_items_done,$f_items)
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_aphandler_estimated ($f_time_start,$f_items_done,$f_items)- (#echo(__LINE__)#)"); }

	$f_percentage = direct_aphandler_percentage ($f_items_done,$f_items);
	$f_return = array (0,0,0);

	if ($f_percentage)
	{
		if ($f_percentage < 100)
		{
			$f_time_diff = (time () - $f_time_start);
			$f_seconds = (ceil ($f_time_diff * (100 / $f_percentage)) - $f_time_diff);
		}
		else { $f_seconds = 0; }
	}

	if ($f_seconds > 59)
	{
		$f_return[2] = ($f_seconds % 60);
		$f_seconds -= $f_return[2];
		$f_return[1] = ($f_seconds / 60);

		if ($f_return[1] > 59)
		{
			$f_return[1] = ($f_return[1] % 60);
			$f_return[0] = floor ($f_return[1] / 60);
		}
	}
	else { $f_return[2] = $f_seconds; }

	if ($f_return[0] < 10) { $f_return[0] = "0".$f_return[0]; }
	if ($f_return[1] < 10) { $f_return[1] = "0".$f_return[1]; }
	if ($f_return[2] < 10) { $f_return[2] = "0".$f_return[2]; }

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_aphandler_estimated ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_aphandler_percentage ($f_items_done,$f_items)
/**
* Calculates and returns the percentage.
*
* @param  integer $f_items_done Completed items
* @param  integer $f_items Number of total item
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return integer Calucalted percentage
* @since  v0.1.00
*/
function direct_aphandler_percentage ($f_items_done,$f_items)
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -c ($f_items_done,$f_items)- (#echo(__LINE__)#)"); }

	$f_return = 0;

	if (($f_items_done > 0)&&($f_items > 0))
	{
		$f_return = (round (($f_items_done / $f_items),2) * 100);

		if ($f_return < 1) { $f_return = 1; }
		if ($f_return > 100) { $f_return = 100; }
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_aphandler_percentage ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// Script specific commands

direct_local_integration ("aphandler");

//j// EOF
?>