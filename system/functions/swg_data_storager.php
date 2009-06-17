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
$Id: swg_data_storager.php,v 1.2 2008/12/20 13:12:45 s4u Exp $
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
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

//f// direct_data_get ($f_id_data)
/**
* Reads (document) data from the database.
*
* @param  mixed $f_id_data One ID (string) or multiple IDs (array) of the
*         requested data
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
function direct_data_get ($f_id_data)
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_data_get (+f_id_data)- (#echo(__LINE__)#)"); }

	$f_return = false;

	if (is_array ($f_id_data))
	{
		$direct_classes['db']->init_select ($direct_settings['data_table']);
		$direct_classes['db']->define_attributes ($direct_settings['data_table'].".*");

		$f_select_criteria = "<sqlconditions>";
		foreach ($f_id_data as $f_id) { $f_select_criteria .= $direct_classes['db']->define_row_conditions_encode ($direct_settings['data_table'].".ddbdata_id",$f_id,"string","==","or"); }
		$f_select_criteria .= "</sqlconditions>";

		$direct_classes['db']->define_row_conditions ($f_select_criteria);
		$f_return = $direct_classes['db']->query_exec ("ma");
	}
	else
	{
		$direct_classes['db']->init_select ($direct_settings['data_table']);

		$direct_classes['db']->define_attributes ($direct_settings['data_table'].".*");
		$direct_classes['db']->define_row_conditions ("<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['data_table'].".ddbdata_id",$f_id_data,"string"))."</sqlconditions>");

		$f_return = $direct_classes['db']->query_exec ("sa");
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_data_get ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_data_write ($f_data,$f_id_data,$f_id_cat = "")
/**
* Writes (document) data to the database.
*
* @param  array $f_data Data array
* @param  string $f_id_data ID of the data element
* @param  string $f_id_cat ID of the category containing the element
* @uses   direct_db::define_values()
* @uses   direct_db::define_values_encode()
* @uses   direct_db::define_values_keys()
* @uses   direct_db::init_replace()
* @uses   direct_db::query_exec()
* @uses   direct_dbsync_event()
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return boolean True on success
* @since  v0.1.00
*/
function direct_data_write ($f_data,$f_id_data,$f_id_cat = "")
{
	global $direct_cachedata,$direct_classes,$direct_settings;
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
		$direct_classes['db']->init_replace ($direct_settings['data_table']);

		$f_replace_attributes = array ($direct_settings['data_table'].".ddbdata_id",$direct_settings['data_table'].".ddbdata_id_cat",$direct_settings['data_table'].".ddbdata_owner",$direct_settings['data_table'].".ddbdata_title",$direct_settings['data_table'].".ddbdata_data",$direct_settings['data_table'].".ddbdata_sid",$direct_settings['data_table'].".ddbdata_mode_user",$direct_settings['data_table'].".ddbdata_mode_group",$direct_settings['data_table'].".ddbdata_mode_all");
		$direct_classes['db']->define_values_keys ($f_replace_attributes);

$f_replace_values = ("<sqlvalues>
".($direct_classes['db']->define_values_encode ($f_id_data,"string"))."
".($direct_classes['db']->define_values_encode ($f_id_cat,"string"))."
".($direct_classes['db']->define_values_encode ($f_replace_array['owner'],"string"))."
".($direct_classes['db']->define_values_encode ($f_replace_array['title'],"string"))."
".($direct_classes['db']->define_values_encode ($f_replace_array['data'],"string"))."
".($direct_classes['db']->define_values_encode ($f_replace_array['sid'],"string"))."
".($direct_classes['db']->define_values_encode ($f_replace_array['mode_user'],"string"))."
".($direct_classes['db']->define_values_encode ($f_replace_array['mode_group'],"string"))."
".($direct_classes['db']->define_values_encode ($f_replace_array['mode_all'],"string"))."
</sqlvalues>");

		$direct_classes['db']->define_values ($f_replace_values);
		$f_return = $direct_classes['db']->query_exec ("co");

		if (($f_return)&&(function_exists ("direct_dbsync_event"))) { direct_dbsync_event ($direct_settings['data_table'],"replace",("<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['data_table'].".ddbdata_id",$f_id_data,"string"))."</sqlconditions>")); }
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_data_write ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// EOF
?>