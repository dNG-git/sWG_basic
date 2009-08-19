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

//f// direct_log_get ($f_log_id,$f_withcustom = false)
/**
* Retrieves log entries (including custom data entries).
*
* @param  mixed $f_log_id One ID (string) or multiple IDs (array) of log data
* @param  boolean $f_withcustom True to read and return the custom data entry
* @uses   direct_db::define_attributes()
* @uses   direct_db::define_row_conditions()
* @uses   direct_db::define_row_conditions_encode()
* @uses   direct_db::init_select()
* @uses   direct_db::query_exec()
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return mixed Single or multi dimensional array; false on error
* @since  v0.1.00
*/
function direct_log_get ($f_log_id,$f_withcustom = false)
{
	global $direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_log_get ($f_log_id,$f_withcustom)- (#echo(__LINE__)#)"); }

	$f_return = false;

	if (is_array ($f_log_id))
	{
		$direct_classes['db']->init_select ($direct_settings['log_table']);

		$f_select_attributes = array ($direct_settings['log_table'].".*");
		if ($f_withcustom) { $f_select_attributes[] = $direct_settings['data_table'].".*"; }

		$direct_classes['db']->define_attributes ($f_select_attributes);
		if ($f_withcustom) { $direct_classes['db']->define_join ("left-outer-join",$direct_settings['data_table'],"<sqlconditions><element1 attribute='$direct_settings[data_table].ddbdata_id' value='$direct_settings[log_table].ddblog_id' type='attribute' /></sqlconditions>"); }

		$f_select_criteria = "<sqlconditions>";
		foreach ($f_log_id as $f_id) { $f_select_criteria .= $direct_classes['db']->define_row_conditions_encode ($direct_settings['log_table'].".ddblog_id",$f_id,"string","==","or"); }
		$f_select_criteria .= "</sqlconditions>";

		$direct_classes['db']->define_row_conditions ($f_select_criteria);
		$f_return = $direct_classes['db']->query_exec ("ma");
	}
	else
	{
		$direct_classes['db']->init_select ($direct_settings['log_table']);

		$f_select_attributes = array ($direct_settings['log_table'].".*");
		if ($f_withcustom) { $f_select_attributes[] = $direct_settings['data_table'].".*"; }

		$direct_classes['db']->define_attributes ($f_select_attributes);
		if ($f_withcustom) { $direct_classes['db']->define_join ("left-outer-join",$direct_settings['data_table'],"<sqlconditions><element1 attribute='$direct_settings[data_table].ddbdata_id' value='$direct_settings[log_table].ddblog_id' type='attribute' /></sqlconditions>"); }

		$direct_classes['db']->define_row_conditions ("<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['log_table'].".ddblog_id",$f_log_id,"string"))."</sqlconditions>");
		$f_return = $direct_classes['db']->query_exec ("sa");
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_log_get ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_log_write ($f_data,$f_log_id = "")
/**
* This function saves log entries.
*
* @param  array $f_data Log entry data
* @param  string $f_log_id ID of the new log entry (replaces old database entries)
* @uses   direct_data_write()
* @uses   direct_db::define_values()
* @uses   direct_db::define_values_encode()
* @uses   direct_db::define_values_keys()
* @uses   direct_db::init_replace()
* @uses   direct_db::query_exec()
* @uses   direct_dbsync_event()
* @uses   direct_debug()
* @uses   direct_evars_write()
* @uses   USE_debug_reporting
* @return mixed Single or multi dimensional array; false on error
* @since  v0.1.00
*/
function direct_log_write ($f_data,$f_log_id = "")
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_log_write (+f_data,$f_log_id)- (#echo(__LINE__)#)"); }

	if (!$f_log_id) { $f_log_id = uniqid (""); }

	$f_continue_check = false;
	$f_customdata_id = "";
	$f_return = false;

	if ((isset ($f_data['identifier']))&&(isset ($f_data['sid'])))
	{
		if (($f_data['customdata_title'])&&($f_data['customdata_text']))
		{
			$f_customdata_id = uniqid ("");

$f_customdata_array = array (
"owner" => $f_data['source_user_id'],
"title" => $f_data['customdata_title'],
"data" => $f_data['customdata_text'],
"sid" => $f_data['sid'],
"mode_user" => "w",
"mode_group" => "r",
"mode_all" => ""
);

			$f_continue_check = direct_data_write ($f_customdata_array,$f_customdata_id);
		}
		else { $f_continue_check = true; }
	}
	elseif ((isset ($f_data['ddblog_identifier']))&&(isset ($f_data['ddblog_sid'])))
	{
		if (($f_data['ddbdata_title'])&&($f_data['ddbdata_data']))
		{
			$f_customdata_id = uniqid ("");

$f_customdata_array = array (
"owner" => $f_data['ddbdata_owner'],
"title" => $f_data['ddbdata_title'],
"data" => $f_data['ddbdata_data'],
"sid" => $f_data['ddbdata_sid'],
"mode_user" => "w",
"mode_group" => "r",
"mode_all" => ""
);

			$f_continue_check = direct_data_write ($f_customdata_array,$f_customdata_id);
		}
		else { $f_continue_check = true; }

$f_data = array (
"data" => $f_data['ddblog_data'],
"identifier" => $f_data['ddblog_identifier'],
"sid" => $f_data['ddblog_sid'],
"source_user_id" => $f_data['ddblog_source_user_id'],
"source_user_ip" => $f_data['ddblog_source_user_ip'],
"target_user_id" => $f_data['ddblog_target_user_id'],
"target_user_ip" => $f_data['ddblog_target_user_ip'],
"time" => $f_data['ddblog_time']
);

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
	}

	if ($f_continue_check)
	{
		$direct_classes['db']->init_replace ($direct_settings['log_table']);

		$f_replace_attributes = array ($direct_settings['log_table'].".ddblog_id",$direct_settings['log_table'].".ddblog_time",$direct_settings['log_table'].".ddblog_source_user_id",$direct_settings['log_table'].".ddblog_source_user_ip",$direct_settings['log_table'].".ddblog_target_user_id",$direct_settings['log_table'].".ddblog_target_user_ip",$direct_settings['log_table'].".ddblog_sid",$direct_settings['log_table'].".ddblog_identifier",$direct_settings['log_table'].".ddblog_data",$direct_settings['log_table'].".ddblog_customdata_id");
		$direct_classes['db']->define_values_keys ($f_replace_attributes);

		$f_replace_values = "<sqlvalues>".($direct_classes['db']->define_values_encode ($f_log_id,"string"));
		$f_replace_values .= ($f_data['time'] ? $direct_classes['db']->define_values_encode ($f_data['time'],"number") : $direct_classes['db']->define_values_encode ($direct_cachedata['core_time'],"number"));

		if ((isset ($f_data['source_user_id']))&&($f_data['source_user_id']))
		{
$f_replace_values .= (($direct_classes['db']->define_values_encode ($f_data['source_user_id'],"string"))."
".($direct_classes['db']->define_values_encode ($f_data['source_user_ip'],"string")));
		}
		else
		{
$f_replace_values .= (($direct_classes['db']->define_values_encode ($direct_settings['user']['id'],"string"))."
".($direct_classes['db']->define_values_encode ($direct_settings['user_ip'],"string")));
		}

		if ((isset ($f_data['target_user_id']))&&($f_data['target_user_id']))
		{
$f_replace_values .= (($direct_classes['db']->define_values_encode ($f_data['target_user_id'],"string"))."
".($direct_classes['db']->define_values_encode ($f_data['target_user_ip'],"string")));
		}
		else { $f_replace_values .= "<element1 value='' type='string' /><element2 value='' type='string' />"; }

		$f_replace_values .= (($direct_classes['db']->define_values_encode ($f_data['sid'],"string")).($direct_classes['db']->define_values_encode ($f_data['identifier'],"string")));
		$f_replace_values .= ((is_array ($f_data['data'])) ? $direct_classes['db']->define_values_encode ((direct_evars_write ($f_data['data'])),"string") : $direct_classes['db']->define_values_encode ($f_data['data'],"string"));
		$f_replace_values .= ($direct_classes['db']->define_values_encode ($f_customdata_id,"string"))."</sqlvalues>";

		$direct_classes['db']->define_values ($f_replace_values);
		$f_return = $direct_classes['db']->query_exec ("co");

		if (($f_return)&&(function_exists ("direct_dbsync_event"))) { direct_dbsync_event ($direct_settings['log_table'],"replace",("<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['log_table'].".ddblog_id",$f_log_id,"string"))."</sqlconditions>")); }
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_log_write ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// Script specific commands

$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_data_storager.php");

//j// EOF
?>