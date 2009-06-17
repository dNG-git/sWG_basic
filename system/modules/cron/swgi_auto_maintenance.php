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
$Id: swgi_auto_maintenance.php,v 1.3 2008/12/20 13:40:30 s4u Exp $
#echo(sWGbasicVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* cron/swgi_auto_maintenance.php
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
* @subpackage cron
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

//j// Script specific commands

if (!isset ($direct_settings['log_time_limit'])) { $direct_settings['log_time_limit'] = 3628800; }

if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }

if (!empty ($direct_cachedata['job_data']))
{
	echo "\n> Cleaning up \"$direct_settings[log_table]\" ... ";

	$g_threshold = ($direct_cachedata['core_time'] - $direct_settings['log_time_limit']);

	$direct_classes['db']->init_delete ($direct_settings['log_table']);
	$g_delete_criteria = "<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['log_table'].".ddblog_time",$g_threshold,"number","<"))."</sqlconditions>";
	$direct_classes['db']->define_row_conditions ($g_delete_criteria);

	$g_continue_check = $direct_classes['db']->query_exec ("co");

	if ($g_continue_check)
	{
		if (function_exists ("direct_dbsync_event")) { direct_dbsync_event ($direct_settings['log_table'],"delete",$g_delete_criteria); }
		$direct_classes['db']->optimize_random ($direct_settings['log_table']);
		echo "done (".(time ()).")";
	}
	else { echo "failed (".(time ()).")"; }

	echo "\n> Cleaning up \"$direct_settings[tmp_storage_table]\" ... ";

	$direct_classes['db']->init_delete ($direct_settings['tmp_storage_table']);

$g_delete_criteria = ("<sqlconditions>
<element1 attribute='{$direct_settings['tmp_storage_table']}.ddbtmp_storage_time_max' value='0' type='number' operator='>' />
".($direct_classes['db']->define_row_conditions_encode ($direct_settings['tmp_storage_table'].".ddbtmp_storage_time_max",$direct_cachedata['core_time'],"number","<"))."
<element2 attribute='{$direct_settings['tmp_storage_table']}.ddbtmp_storage_maintained' value='0' type='string' />
</sqlconditions>");

	$direct_classes['db']->define_row_conditions ($g_delete_criteria);
	$g_continue_check = $direct_classes['db']->query_exec ("co");

	if ($g_continue_check)
	{
		$direct_classes['db']->optimize_random ($direct_settings['tmp_storage_table']);
		echo "done (".(time ()).")";
	}
	else { echo "failed (".(time ()).")"; }

	echo "\n> Cleaning up \"$direct_settings[uuids_table]\" ... ";

	$direct_classes['db']->init_delete ($direct_settings['uuids_table']);

	$g_delete_criteria = "<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['uuids_table'].".ddbuuids_list_maxage_inactivity",$direct_cachedata['core_time'],"number","<"))."</sqlconditions>";
	$direct_classes['db']->define_row_conditions ($g_delete_criteria);

	$g_continue_check = $direct_classes['db']->query_exec ("co");

	if ($g_continue_check)
	{
		$direct_classes['db']->optimize_random ($direct_settings['uuids_table']);
		echo "done (".(time ()).")";
	}
	else { echo "failed (".(time ()).")"; }

	$direct_cachedata['job_result'] = "done";
}

//j// EOF
?>