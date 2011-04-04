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
* This file provides functions to create and read entries from the evars
* archive.
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

//f// direct_evar_storage_get ($f_evar_id,$f_sid = "",$f_identifier = "")
/**
* Retrieves entries from the evars archive.
*
* @param  string $f_evar_id Entry ID
* @param  string $f_sid Service ID for selection
* @param  string $f_identifier Identifier for selection
* @uses   direct_db::define_attributes()
* @uses   direct_db::define_row_conditions()
* @uses   direct_db::define_row_conditions_encode()
* @uses   direct_db::init_select()
* @uses   direct_db::query_exec()
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return mixed Array on success; false on error
* @since  v0.1.00
*/
function direct_evar_storage_get ($f_evar_id,$f_sid = "",$f_identifier = "")
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_evar_storage_get (+f_evars_id,$f_sid,$f_identifier)- (#echo(__LINE__)#)"); }

	if (strlen ($f_sid.$f_identifier)) { $f_evar_id = md5 ($f_sid.$f_identifier.$f_evar_id); }
	$f_return = false;

	$direct_globals['db']->init_select ($direct_settings['evars_archive_table']);
	$direct_globals['db']->define_attributes (array ($direct_settings['evars_archive_table'].".ddbevars_archive_data"));
	$direct_globals['db']->define_row_conditions ("<sqlconditions>".($direct_globals['db']->define_row_conditions_encode ($direct_settings['evars_archive_table'].".ddbevars_archive_id",$f_evar_id,"string"))."</sqlconditions>");

	$f_return = $direct_globals['db']->query_exec ("ss");
	if ($f_return) { $f_return = direct_evars_get ($f_return); }

	if (($f_return)&&((isset ($f_return['core_evar_time_min']))||(isset ($f_return['core_evar_time_max']))))
	{
		if ((isset ($f_return['core_evar_time_min']))&&($direct_cachedata['core_time'] < $f_return['core_evar_time_min'])) { $f_return = false; }
		elseif ((isset ($f_return['core_evar_time_max']))&&($f_return['core_evar_time_max'] < $direct_cachedata['core_time']))
		{
			$direct_globals['db']->init_delete ($direct_settings['evars_archive_table']);
			$direct_globals['db']->define_row_conditions ("<sqlconditions>".($direct_globals['db']->define_row_conditions_encode ($direct_settings['evars_archive_table'].".ddbevars_archive_id",$f_evar_id,"string"))."</sqlconditions>");
			if (($direct_globals['db']->query_exec ("ar"))&&(!$direct_settings['swg_auto_maintenance'])) { $direct_globals['db']->optimize_random ($direct_settings['evars_archive_table']); }

			$f_return = false;
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_evar_storage_get ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_evar_storage_write ($f_data,$f_evar_id,$f_sid = "",$f_identifier = "",$f_mintime = 0,$f_maxtime = 0,$f_evar_update = false)
/**
* This function saves entries into the evars archive.
*
* @param  array $f_data evars archive entry data
* @param  string $f_evar_id ID of an entry
* @param  string $f_sid Service ID
* @param  string $f_identifier Identifier
* @param  integer $f_mintime UNIX time stamp when the entry gets valid
* @param  integer $f_maxtime UNIX time stamp when the entry gets deleted (or 0
*         if it will be deleted manually)
* @param  boolean $f_evar_update Update an existing log entry
* @uses   direct_data_write()
* @uses   direct_db::define_row_conditions()
* @uses   direct_db::define_row_conditions_encode()
* @uses   direct_db::define_set_attributes()
* @uses   direct_db::define_set_attributes_encode()
* @uses   direct_db::init_insert()
* @uses   direct_db::init_update()
* @uses   direct_db::query_exec()
* @uses   direct_dbsync_event()
* @uses   direct_debug()
* @uses   direct_evars_write()
* @uses   USE_debug_reporting
* @return mixed Log entry ID on success; false on error
* @since  v0.1.00
*/
function direct_evar_storage_write ($f_data,$f_evar_id,$f_sid = "",$f_identifier = "",$f_mintime = 0,$f_maxtime = 0,$f_evar_update = false)
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_evar_storage_write (+f_data,$f_evar_id,$f_sid,$f_identifier,$f_type,$f_mintime,$f_maxtime,+f_evar_update)- (#echo(__LINE__)#)"); }

	if (!$f_evar_id)
	{
		$f_evar_id = uniqid ("");
		$f_evar_update = false;
	}

	$f_continue_check = false;
	if (strlen ($f_sid.$f_identifier)) { $f_evar_id = md5 ($f_sid.$f_identifier.$f_evar_id); }
	$f_return = false;

	if ((is_array ($f_data))&&($f_data))
	{
		if ($f_maxtime) { $f_data['core_evar_time_max'] = $f_maxtime; }
		if ($f_mintime) { $f_data['core_evar_time_min'] = $f_mintime; }

		if ($f_evar_update) { $direct_globals['db']->init_update ($direct_settings['evars_archive_table']); }
		else { $direct_globals['db']->init_insert ($direct_settings['evars_archive_table']); }

$f_data_values = ("<sqlvalues>
".($direct_globals['db']->define_set_attributes_encode ($direct_settings['evars_archive_table'].".ddbevars_archive_id",$f_evar_id,"string"))."
".($direct_globals['db']->define_set_attributes_encode ($direct_settings['evars_archive_table'].".ddbevars_archive_data",(direct_evars_write ($f_data)),"string"))."
</sqlvalues>");

		$direct_globals['db']->define_set_attributes ($f_data_values);
		if ($f_evar_update) { $direct_globals['db']->define_row_conditions ("<sqlconditions>".($direct_globals['db']->define_row_conditions_encode ($direct_settings['evars_archive_table'].".ddbevars_archive_id",$f_evar_id,"string"))."</sqlconditions>"); }
		$f_return = $direct_globals['db']->query_exec ("co");

		if (($f_return)&&(function_exists ("direct_dbsync_event")))
		{
			if ($this->data_insert_mode) { direct_dbsync_event ($direct_settings['evars_archive_table'],"insert",("<sqlconditions>".($direct_globals['db']->define_row_conditions_encode ($direct_settings['evars_archive_table'].".ddbevars_archive_id",$f_evar_id,"string"))."</sqlconditions>")); }
			else { direct_dbsync_event ($direct_settings['evars_archive_table'],"update",("<sqlconditions>".($direct_globals['db']->define_row_conditions_encode ($direct_settings['evars_archive_table'].".ddbevars_archive_id",$f_evar_id,"string"))."</sqlconditions>")); }
		}
	}
	else
	{
		$direct_globals['db']->init_delete ($direct_settings['evars_archive_table']);

		$f_delete_criteria = "<sqlconditions>".($direct_globals['db']->define_row_conditions_encode ($direct_settings['evars_archive_table'].".ddbevars_archive_id",$f_evar_id,"string"))."</sqlconditions>";
		$direct_globals['db']->define_row_conditions ($f_delete_criteria);

		$f_return = $direct_globals['db']->query_exec ("ar");
		if (($f_return)&&(function_exists ("direct_dbsync_event"))) { direct_dbsync_event ($direct_settings['evars_archive_table'],"delete",$f_delete_criteria); }
	}

	if (!$direct_settings['swg_auto_maintenance']) { $direct_globals['db']->optimize_random ($direct_settings['evars_archive_table']); }

	if ($f_return) { $f_return = $f_evar_id; }
	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_evar_storage_write ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// Script specific commands

if (!isset ($direct_settings['swg_auto_maintenance'])) { $direct_settings['swg_auto_maintenance'] = false; }
if (!isset ($direct_settings['swg_ip_save2db'])) { $direct_settings['swg_ip_save2db'] = true; }

$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_data_storager.php");

//j// EOF
?>