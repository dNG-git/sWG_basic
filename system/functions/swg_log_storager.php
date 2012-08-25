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
* This file provides functions to create and read log entries.
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

/**
* Count matching log entries based on defined search criteria.
*
* @param  mixed $f_log_id One ID (string) or multiple IDs (array) of log data
* @return integer 
* @since  v0.1.00
*/
function direct_log_count ($f_log_criteria)
{
	global $direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_log_count (+f_log_criteria)- (#echo(__LINE__)#)"); }

	$f_return = 0;

	if (is_array ($f_log_criteria))
	{
		$direct_globals['db']->initSelect ($direct_settings['log_table']);
		$direct_globals['db']->defineAttributes (array ("count-rows({$direct_settings['log_table']}.ddblog_id)"));

		$f_select_criteria = "<sqlconditions>";
		foreach ($f_log_criteria as $f_attribute => $f_value) { $f_select_criteria .= $direct_globals['db']->defineRowConditionsEncode ($direct_settings['log_table'].".".$f_attribute,$f_value,"string","=="); }
		$f_select_criteria .= "</sqlconditions>";

		$direct_globals['db']->defineRowConditions ($f_select_criteria);
		$f_return = $direct_globals['db']->queryExec ("ss");
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_log_count ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

/**
* Retrieves log entries (including custom data entries).
*
* @param  mixed $f_log_id One ID (string) or multiple IDs (array) of log data
* @param  boolean $f_withcustom True to read and return the custom data entry
* @return mixed Single or multi dimensional array; false on error
* @since  v0.1.00
*/
function direct_log_get ($f_log_id,$f_withcustom = false)
{
	global $direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_log_get (+f_log_id,+f_withcustom)- (#echo(__LINE__)#)"); }

	$f_return = false;

	$direct_globals['db']->initSelect ($direct_settings['log_table']);

	$f_select_attributes = array ($direct_settings['log_table'].".*");
	if ($f_withcustom) { $f_select_attributes[] = $direct_settings['data_table'].".*"; }

	$direct_globals['db']->defineAttributes ($f_select_attributes);
	if ($f_withcustom) { $direct_globals['db']->defineJoin ("left-outer-join",$direct_settings['data_table'],"<sqlconditions><element1 attribute='$direct_settings[data_table].ddbdata_id' value='$direct_settings[log_table].ddblog_id' type='attribute' /></sqlconditions>"); }

	if (is_array ($f_log_id))
	{
		$f_select_criteria = "<sqlconditions>";
		foreach ($f_log_id as $f_id) { $f_select_criteria .= $direct_globals['db']->defineRowConditionsEncode ($direct_settings['log_table'].".ddblog_id",$f_id,"string","==","or"); }
		$f_select_criteria .= "</sqlconditions>";

		$direct_globals['db']->defineRowConditions ($f_select_criteria);
		$f_return = $direct_globals['db']->queryExec ("ma");
	}
	else
	{
		$direct_globals['db']->defineRowConditions ("<sqlconditions>".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['log_table'].".ddblog_id",$f_log_id,"string"))."</sqlconditions>");
		$f_return = $direct_globals['db']->queryExec ("sa");
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_log_get ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

/**
* Retrieves log entries (including custom data entries) based on defined
* search criteria.
*
* @param  mixed $f_log_id One ID (string) or multiple IDs (array) of log data
* @param  boolean $f_withcustom True to read and return the custom data entry
* @param  integer $f_offset Offset for the result list
* @param  integer $f_perpage Object count limit for the result list
* @param  string $f_sorting_mode Sorting algorithm
* @return mixed Single or multi dimensional array; false on error
* @since  v0.1.00
*/
function direct_log_search ($f_log_criteria,$f_withcustom = false,$f_offset = 0,$f_perpage = "",$f_sorting_mode = "time-desc")
{
	global $direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_log_search (+f_log_criteria,+f_withcustom,$f_offset,$f_perpage,$f_sorting_mode)- (#echo(__LINE__)#)"); }

	$f_return = false;

	if (is_array ($f_log_criteria))
	{
		$direct_globals['db']->initSelect ($direct_settings['log_table']);

		$f_select_attributes = array ($direct_settings['log_table'].".*");
		if ($f_withcustom) { $f_select_attributes[] = $direct_settings['data_table'].".*"; }

		$direct_globals['db']->defineAttributes ($f_select_attributes);
		if ($f_withcustom) { $direct_globals['db']->defineJoin ("left-outer-join",$direct_settings['data_table'],"<sqlconditions><element1 attribute='$direct_settings[data_table].ddbdata_id' value='$direct_settings[log_table].ddblog_id' type='attribute' /></sqlconditions>"); }

		$f_select_criteria = "<sqlconditions>";
		foreach ($f_log_criteria as $f_attribute => $f_value) { $f_select_criteria .= $direct_globals['db']->defineRowConditionsEncode ($direct_settings['log_table'].".".$f_attribute,$f_value,"string","=="); }
		$f_select_criteria .= "</sqlconditions>";

		$direct_globals['db']->defineRowConditions ($f_select_criteria);

		switch ($f_sorting_mode)
		{
		case "id-asc":
		{
			$f_select_ordering = "<sqlordering><element1 attribute='$direct_settings[log_table].ddblog_id' type='desc' /></sqlordering>";
			break 1;
		}
		case "id-desc":
		{
			$f_select_ordering = "<sqlordering><element1 attribute='$direct_settings[log_table].ddblog_id' type='desc' /></sqlordering>";
			break 1;
		}
		case "time-asc":
		{
$f_select_ordering = ("<sqlordering>
<element1 attribute='$direct_settings[log_table].ddblog_time' type='asc' />
<element2 attribute='$direct_settings[log_table].ddblog_id' type='asc' />
</sqlordering>");

			break 1;
		}
		default:
		{
$f_select_ordering = ("<sqlordering>
<element1 attribute='$direct_settings[log_table].ddblog_time' type='desc' />
<element2 attribute='$direct_settings[log_table].ddblog_id' type='desc' />
</sqlordering>");
		}
		}

		$direct_globals['db']->defineOrdering ($f_select_ordering);

		if (is_numeric ($f_perpage))
		{
			$direct_globals['db']->defineLimit ($f_perpage);
			$direct_globals['db']->defineOffset ($f_offset);
		}

		$f_return = $direct_globals['db']->queryExec ("ma");
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_log_search ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

/**
* This function saves log entries.
*
* @param  array $f_data Log entry data
* @param  string $f_log_id ID of a log entry
* @param  boolean $f_log_update Update an existing log entry
* @return mixed Log entry ID on success; false on error
* @since  v0.1.00
*/
function direct_log_write ($f_data,$f_log_id = "",$f_log_update = true)
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_log_write (+f_data,$f_log_id,+f_log_update)- (#echo(__LINE__)#)"); }

	if (!$f_log_id)
	{
		$f_log_id = uniqid ("");
		$f_log_update = false;
	}

	$f_continue_check = isset ($f_data['ddblog_sid']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_data['ddblog_identifier']);
	$f_customdata_id = "";
	$f_return = false;

	if ($f_continue_check)
	{
		if (isset ($f_data['ddbdata_title']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_data['ddbdata_data']))
		{
			$f_customdata_id = uniqid ("");

$f_insert_array = array (
"ddbdata_owner" => $f_data['ddbdata_owner'],
"ddbdata_title" => $f_data['ddbdata_title'],
"ddbdata_data" => $f_data['ddbdata_data'],
"ddbdata_sid" => $f_data['ddbdata_sid'],
"ddbdata_mode_user" => "w",
"ddbdata_mode_group" => "r",
"ddbdata_mode_all" => ""
);

			$f_continue_check = direct_data_write ($f_insert_array,$f_customdata_id);
		}
		elseif (!isset ($f_data['ddblog_data'])) { $f_data['ddblog_data'] = NULL; }

		if (!isset ($f_data['ddblog_source_id'])) { $f_data['ddblog_source_id'] = ""; }
		if ((!isset ($f_data['ddblog_time']))||(!$f_data['ddblog_time'])) { $f_data['ddblog_time'] = $direct_cachedata['core_time']; }

		if ((!isset ($f_data['ddblog_source_user_id']))||(!$f_data['ddblog_source_user_id']))
		{
			$f_data['ddblog_source_user_id'] = $direct_settings['user']['id'];
			$f_data['ddblog_source_user_ip'] = $direct_settings['user_ip'];
		}

		if ((!isset ($f_data['ddblog_target_user_id']))||(!$f_data['ddblog_target_user_id']))
		{
			$f_data['ddblog_target_user_id'] = "";
			$f_data['ddblog_target_user_ip'] = "";
		}

		if (!$direct_settings['swg_ip_save2db'])
		{
			$f_data['ddblog_source_user_ip'] = "unknown";
			$f_data['ddblog_target_user_ip'] = "unknown";
		}

		if (is_array ($f_data['ddblog_data'])) { $f_data['ddblog_data'] = direct_evars_write ($f_data['ddblog_data']); }
		if (!isset ($f_data['ddblog_maintained'])) { $f_data['ddblog_maintained'] = 0; }
	}

	if ($f_continue_check)
	{
		if ($f_log_update) { $direct_globals['db']->initUpdate ($direct_settings['log_table']); }
		else { $direct_globals['db']->initInsert ($direct_settings['log_table']); }

$f_data_values = ("<sqlvalues>
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['log_table'].".ddblog_id",$f_log_id,"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['log_table'].".ddblog_source_id",$f_data['ddblog_source_id'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['log_table'].".ddblog_time",$f_data['ddblog_time'],"number"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['log_table'].".ddblog_source_user_id",$f_data['ddblog_source_user_id'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['log_table'].".ddblog_source_user_ip",$f_data['ddblog_source_user_ip'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['log_table'].".ddblog_target_user_id",$f_data['ddblog_target_user_id'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['log_table'].".ddblog_target_user_ip",$f_data['ddblog_target_user_ip'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['log_table'].".ddblog_sid",$f_data['ddblog_sid'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['log_table'].".ddblog_identifier",$f_data['ddblog_identifier'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['log_table'].".ddblog_data",$f_data['ddblog_data'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['log_table'].".ddblog_maintained",$f_data['ddblog_maintained'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['log_table'].".ddblog_customdata_id",$f_customdata_id,"string"))."
</sqlvalues>");

		$direct_globals['db']->defineSetAttributes ($f_data_values);
		if ($f_log_update) { $direct_globals['db']->defineRowConditions ("<sqlconditions>".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['log_table'].".ddblog_id",$f_log_id,"string"))."</sqlconditions>"); }
		$f_return = $direct_globals['db']->queryExec ("co");

		if ($f_return)
		{
			if (function_exists ("direct_dbsync_event"))
			{
				if ($f_log_update) { direct_dbsync_event ($direct_settings['log_table'],"update",("<sqlconditions>".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['log_table'].".ddblog_id",$f_log_id,"string"))."</sqlconditions>")); }
				else { direct_dbsync_event ($direct_settings['log_table'],"insert",("<sqlconditions>".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['log_table'].".ddblog_id",$f_log_id,"string"))."</sqlconditions>")); }
			}

			if (!$direct_settings['swg_auto_maintenance']) { $direct_globals['db']->optimizeRandom ($direct_settings['log_table']); }
		}
	}

	if ($f_return) { $f_return = $f_log_id; }
	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_log_write ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// Script specific commands

if (!isset ($direct_settings['swg_auto_maintenance'])) { $direct_settings['swg_auto_maintenance'] = false; }
if (!isset ($direct_settings['swg_ip_save2db'])) { $direct_settings['swg_ip_save2db'] = true; }

$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_data_storager.php");

//j// EOF
?>