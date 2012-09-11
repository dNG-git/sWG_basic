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
* This file contains support functions for the "data" table. 
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

//j// Functions and classes

/**
* Reads (document) data from the database.
*
* @param  mixed $f_id_data One ID (string) or multiple IDs (array) of the
*         requested data
* @return mixed Single or multi dimensional array; false on error
* @since  v0.1.00
*/
function direct_data_get ($f_id_data)
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_data_get (+f_id_data)- (#echo(__LINE__)#)"); }

	$f_return = false;

	if (is_array ($f_id_data))
	{
		$direct_globals['db']->initSelect ($direct_settings['data_table']);
		$direct_globals['db']->defineAttributes ($direct_settings['data_table'].".*");

		$f_select_criteria = "<sqlconditions>";
		foreach ($f_id_data as $f_id) { $f_select_criteria .= $direct_globals['db']->defineRowConditionsEncode ($direct_settings['data_table'].".ddbdata_id",$f_id,"string","==","or"); }
		$f_select_criteria .= "</sqlconditions>";

		$direct_globals['db']->defineRowConditions ($f_select_criteria);
		$f_return = $direct_globals['db']->queryExec ("ma");
	}
	else
	{
		$direct_globals['db']->initSelect ($direct_settings['data_table']);

		$direct_globals['db']->defineAttributes ($direct_settings['data_table'].".*");
		$direct_globals['db']->defineRowConditions ("<sqlconditions>".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['data_table'].".ddbdata_id",$f_id_data,"string"))."</sqlconditions>");

		$f_return = $direct_globals['db']->queryExec ("sa");
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_data_get ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

/**
* Writes (document) data to the database.
*
* @param  array $f_data Data array
* @param  string $f_id_data ID of the data element
* @param  string $f_id_cat ID of the category containing the element
* @return boolean True on success
* @since  v0.1.00
*/
function direct_data_write ($f_data,$f_id_data,$f_id_cat = "")
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_data_write (+f_data,$f_id_data,$f_id_cat)- (#echo(__LINE__)#)"); }

	$f_return = false;
	$f_replace_array = array ();

	if ((isset ($f_data['owner']))&&(isset ($f_data['title']))&&(isset ($f_data['data']))&&(isset ($f_data['sid']))&&(isset ($f_data['mode_user']))&&(isset ($f_data['mode_group']))&&(isset ($f_data['mode_all']))) { $f_replace_array = $f_data; }
	elseif ((isset ($f_data['ddbdata_owner']))&&(isset ($f_data['ddbdata_title']))&&(isset ($f_data['ddbdata_data']))&&(isset ($f_data['ddbdata_sid']))&&(isset ($f_data['ddbdata_mode_user']))&&(isset ($f_data['ddbdata_mode_group']))&&(isset ($f_data['ddbdata_mode_all'])))
	{
$f_replace_array = array (
"owner" => $f_data['ddbdata_owner'],
"title" => $f_data['ddbdata_title'],
"data" => $f_data['ddbdata_data'],
"sid" => $f_data['ddbdata_sid'],
"mode_user" => $f_data['ddbdata_mode_user'],
"mode_group" => $f_data['ddbdata_mode_group'],
"mode_all" => $f_data['ddbdata_mode_all']
);
	}

	if (!empty ($f_replace_array))
	{
		$direct_globals['db']->initReplace ($direct_settings['data_table']);

		$f_replace_attributes = array ($direct_settings['data_table'].".ddbdata_id",$direct_settings['data_table'].".ddbdata_id_cat",$direct_settings['data_table'].".ddbdata_owner",$direct_settings['data_table'].".ddbdata_title",$direct_settings['data_table'].".ddbdata_data",$direct_settings['data_table'].".ddbdata_sid",$direct_settings['data_table'].".ddbdata_mode_user",$direct_settings['data_table'].".ddbdata_mode_group",$direct_settings['data_table'].".ddbdata_mode_all");
		$direct_globals['db']->defineValuesKeys ($f_replace_attributes);

$f_replace_values = ("<sqlvalues>
".($direct_globals['db']->defineValuesEncode ($f_id_data,"string"))."
".($direct_globals['db']->defineValuesEncode ($f_id_cat,"string"))."
".($direct_globals['db']->defineValuesEncode ($f_replace_array['owner'],"string"))."
".($direct_globals['db']->defineValuesEncode ($f_replace_array['title'],"string"))."
".($direct_globals['db']->defineValuesEncode ($f_replace_array['data'],"string"))."
".($direct_globals['db']->defineValuesEncode ($f_replace_array['sid'],"string"))."
".($direct_globals['db']->defineValuesEncode ($f_replace_array['mode_user'],"string"))."
".($direct_globals['db']->defineValuesEncode ($f_replace_array['mode_group'],"string"))."
".($direct_globals['db']->defineValuesEncode ($f_replace_array['mode_all'],"string"))."
</sqlvalues>");

		$direct_globals['db']->defineValues ($f_replace_values);
		$f_return = $direct_globals['db']->queryExec ("co");

		if (($f_return)&&(function_exists ("direct_dbsync_event"))) { direct_dbsync_event ($direct_settings['data_table'],"replace",("<sqlconditions>".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['data_table'].".ddbdata_id",$f_id_data,"string"))."</sqlconditions>")); }
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_data_write ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// EOF
?>