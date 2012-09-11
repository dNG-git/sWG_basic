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
* Storing temporary data in the database provide the possibility to build
* multi page applications as well as AJAX based interfaces.
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
* @subpackage extra_functions
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
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

/**
* Reads an entry from the "tmp_storage" table.
*
* @param  string $f_type Returns the result as array ("a"), parsed evars or
*         plain string ("s")
* @param  string $f_id Entry ID
* @param  string $f_sid Required service ID for selection
* @param  string $f_identifier Required identifier for selection
* @return mixed Array, parsed evars array or string; false on error
* @since  v0.1.00
*/
function direct_tmp_storage_get ($f_type,$f_id,$f_sid = "",$f_identifier = "")
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_tmp_storage_get ($f_type,$f_id,$f_sid,$f_identifier)- (#echo(__LINE__)#)"); }

	$f_return = false;

	if ((((mt_rand (0,30)) > 20))&&(!$direct_settings['swg_auto_maintenance']))
	{
		$direct_globals['db']->initDelete ($direct_settings['tmp_storage_table']);

$f_delete_criteria = ("<sqlconditions>
<element1 attribute='{$direct_settings['tmp_storage_table']}.ddbtmp_storage_time_max' value='0' type='number' operator='>' />
".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['tmp_storage_table'].".ddbtmp_storage_time_max",$direct_cachedata['core_time'],"number","<"))."
<element2 attribute='{$direct_settings['tmp_storage_table']}.ddbtmp_storage_sid' value='9d3bb895f22bf0afa958d68c2a58ded7' type='string' operator='!=' />
<element3 attribute='{$direct_settings['tmp_storage_table']}.ddbtmp_storage_maintained' value='0' type='number' />
</sqlconditions>");

		$direct_globals['db']->defineRowConditions ($f_delete_criteria);

		if (($direct_globals['db']->queryExec ("ar"))&&(!$direct_settings['swg_auto_maintenance'])) { $direct_globals['db']->optimizeRandom ($direct_settings['tmp_storage_table']); }
	}

	$f_id = $direct_globals['basic_functions']->tmd5 ($f_id);

	$direct_globals['db']->initSelect ($direct_settings['tmp_storage_table']);
	$direct_globals['db']->defineAttributes (array ($direct_settings['tmp_storage_table'].".ddbtmp_storage_data"));

$f_select_criteria = ("<sqlconditions>
".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['tmp_storage_table'].".ddbtmp_storage_id",$f_id,"string"))."
<sub1 type='sublevel'>
<element1 attribute='{$direct_settings['tmp_storage_table']}.ddbtmp_storage_time_max' value='0' type='number' condition='or' />
".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['tmp_storage_table'].".ddbtmp_storage_time_max",$direct_cachedata['core_time'],"number",">","or"))."
</sub1>
".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['tmp_storage_table'].".ddbtmp_storage_time_min",$direct_cachedata['core_time'],"number","<=")));

	if ($f_sid) { $f_select_criteria .= $direct_globals['db']->defineRowConditionsEncode ($direct_settings['tmp_storage_table'].".ddbtmp_storage_sid",$f_sid,"string"); }
	if ($f_identifier) { $f_select_criteria .= $direct_globals['db']->defineRowConditionsEncode ($direct_settings['tmp_storage_table'].".ddbtmp_storage_identifier",$f_identifier,"string"); }

	$f_select_criteria .= "</sqlconditions>";

	$direct_globals['db']->defineRowConditions ($f_select_criteria);
	$direct_globals['db']->defineLimit (1);

	$f_result = $direct_globals['db']->queryExec ("ss");

	if ($f_result)
	{
		if ($f_type == "evars") { $f_return = direct_evars_get ($f_result); }
		else { $f_return = (($f_type == "a") ? explode ("\n",(trim ($f_result))) : trim ($f_result)); }
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_tmp_storage_get ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

/**
* Writes an entry to the "tmp_storage" table.
*
* @param  mixed $f_data Data to write to the database
* @param  string $f_id Entry ID
* @param  string $f_sid Service ID
* @param  string $f_identifier Identifier
* @param  string $f_type Returns the result as array ("a"), parsed evars or
*         plain string ("s")
* @param  integer $f_mintime UNIX time stamp when the entry gets valid
* @param  integer $f_maxtime UNIX time stamp when the entry gets deleted (or 0
*         if it will be deleted manually)
* @param  boolean $f_maintained True to manually maintain the entry state 
* @return mixed Array, parsed evars array or string; false on error
* @since  v0.1.00
*/
function direct_tmp_storage_write ($f_data,$f_id,$f_sid,$f_identifier = "",$f_type = "evars",$f_mintime = 0,$f_maxtime = 0,$f_maintained = false)
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_tmp_storage_write (+f_data,$f_id,$f_sid,$f_identifier,$f_type,$f_mintime,$f_maxtime,$f_maintained)- (#echo(__LINE__)#)"); }

	$f_return = false;

	if (((is_array ($f_data))&&($f_type == "evars"))||($f_type != "evars"))
	{
		$f_id = $direct_globals['basic_functions']->tmd5 ($f_id);

		if ($f_type == "evars") { $f_data = direct_evars_write ($f_data); }
		else { $f_data = trim (($f_type == "a") ? implode ("\n",$f_data) : $f_data); }

		if ($f_data)
		{
			$direct_globals['db']->initReplace ($direct_settings['tmp_storage_table']);

			$f_replace_attributes = array ($direct_settings['tmp_storage_table'].".ddbtmp_storage_id",$direct_settings['tmp_storage_table'].".ddbtmp_storage_time_min",$direct_settings['tmp_storage_table'].".ddbtmp_storage_time_max",$direct_settings['tmp_storage_table'].".ddbtmp_storage_sid",$direct_settings['tmp_storage_table'].".ddbtmp_storage_identifier",$direct_settings['tmp_storage_table'].".ddbtmp_storage_data",$direct_settings['tmp_storage_table'].".ddbtmp_storage_maintained");
			$direct_globals['db']->defineValuesKeys ($f_replace_attributes);

			$f_replace_values = "<sqlvalues>".($direct_globals['db']->defineValuesEncode ($f_id,"string"));
			$f_replace_values .= ($f_mintime ? $direct_globals['db']->defineValuesEncode ($f_mintime,"number") : $direct_globals['db']->defineValuesEncode ($direct_cachedata['core_time'],"number"));
			$f_replace_values .= ($f_maxtime ? $direct_globals['db']->defineValuesEncode ($f_maxtime,"number") : "<element1 value='0' type='number' />");

$f_replace_values .= (($direct_globals['db']->defineValuesEncode ($f_sid,"string"))."
".($direct_globals['db']->defineValuesEncode ($f_identifier,"string"))."
".($direct_globals['db']->defineValuesEncode ($f_data,"string")));

			$f_replace_values .= ($f_maintained ? "<element2 value='1' type='string' />" : "<element2 value='0' type='string' />");
			$f_replace_values .= "</sqlvalues>";

			$direct_globals['db']->defineValues ($f_replace_values);

			$f_return = $direct_globals['db']->queryExec ("co");
			if (($f_return)&&(function_exists ("direct_dbsync_event"))) { direct_dbsync_event ($direct_settings['tmp_storage_table'],"replace",("<sqlconditions>".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['tmp_storage_table'].".ddbtmp_storage_id",$f_id,"string"))."</sqlconditions>")); }
		}
		else
		{
			$direct_globals['db']->initDelete ($direct_settings['tmp_storage_table']);

			$f_delete_criteria = "<sqlconditions>".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['tmp_storage_table'].".ddbtmp_storage_id",$f_id,"string"))."</sqlconditions>";
			$direct_globals['db']->defineRowConditions ($f_delete_criteria);

			$f_return = $direct_globals['db']->queryExec ("ar");

			if ($f_return)
			{
				if (function_exists ("direct_dbsync_event")) { direct_dbsync_event ($direct_settings['tmp_storage_table'],"delete",$f_delete_criteria); }
			}
		}

		if (!$direct_settings['swg_auto_maintenance']) { $direct_globals['db']->optimizeRandom ($direct_settings['tmp_storage_table']); }
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_tmp_storage_write ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// Script specific functions

if (!isset ($direct_settings['swg_auto_maintenance'])) { $direct_settings['swg_auto_maintenance'] = false; }

//j// EOF
?>