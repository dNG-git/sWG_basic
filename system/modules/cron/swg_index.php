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
* cron/swg_index.php
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

//j// Script specific commands

if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }

if ($direct_globals['kernel']->serviceInitRBoolean ())
{
//j// BOA
$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_data_storager.php");
$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_log_storager.php");
$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_tmp_storager.php");

header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Expires: ".(gmdate ("D, d M Y H:i:s",($direct_cachedata['core_time'] - 2419200)))." GMT");
header ("Last-Modified: ".(gmdate ("D, d M Y H:i:s",$direct_cachedata['core_time']))." GMT");
header ("Content-Type: text/plain; charset=UTF-8");

echo "Searching for jobs ... ";

$direct_globals['db']->initSelect ($direct_settings['tmp_storage_table']);
$direct_globals['db']->defineAttributes ("*");

$direct_globals['db']->defineRowConditions ("<sqlconditions>
<element1 attribute='ddbtmp_storage_sid' value='9d3bb895f22bf0afa958d68c2a58ded7' type='string' />
".($direct_globals['db']->defineRowConditionsEncode ("ddbtmp_storage_time_min",$direct_cachedata['core_time'],"number","<"))."
</sqlconditions>");
// md5 ("cron")

$g_cronjobs_array = $direct_globals['db']->queryExec ("ma");

if (empty ($g_cronjobs_array)) { echo "done (".(time ()).")\n> Looks like there is nothing to do"; }
else
{
	echo "done (".(time ()).")\n> ".(count ($g_cronjobs_array))." jobs to consider";

	foreach ($g_cronjobs_array as $direct_cachedata['job'])
	{
		$direct_cachedata['job_data'] = direct_evars_get ($direct_cachedata['job']['ddbtmp_storage_data']);
		$direct_cachedata['job_result'] = "failed";
		echo "\n\nNew job ... ";

		if (($direct_cachedata['job_data']['job_identifier'])&&($direct_cachedata['job_data']['job_control_file']))
		{
			echo "{$direct_cachedata['job_data']['job_identifier']} (".(time ()).")";
			$g_continue_check = true;

			if (($direct_cachedata['job']['ddbtmp_storage_time_max'])&&($direct_cachedata['job']['ddbtmp_storage_time_max'] < $direct_cachedata['core_time']))
			{
$g_log_array = array (
"ddblog_identifier" => "cron_warning_time_limit",
"ddblog_data" => $direct_cachedata['job_data']['job_identifier'],
"ddblog_sid" => "9d3bb895f22bf0afa958d68c2a58ded7"
// md5 ("cron")
);

				direct_log_write ($g_log_array);
				echo "\n> Cron warning: Job has exceeded time limit";

				if ($direct_cachedata['job_data']['job_ignore_limit']) { echo "\n>> Job time limit will be ignored"; }
				else
				{
					echo "\n>> Job has been canceled";
					$g_continue_check = false;
				}
			}

			if ($g_continue_check)
			{
				echo "\n> Looking for control file ... ";

				if (file_exists ($direct_settings['path_system']."/modules/cron/".$direct_cachedata['job_data']['job_control_file']))
				{
					echo "done (".(time ()).")";
					$direct_globals['basic_functions']->includeFile ($direct_settings['path_system']."/modules/cron/".$direct_cachedata['job_data']['job_control_file']);

					if ($direct_cachedata['job_data']['job_control_function'])
					{
						echo "\n> Activating control function ... ";
						$g_cronjob_function = "direct_cron_".$direct_cachedata['job_data']['job_control_function'];

						if (function_exists ($g_cronjob_function))
						{
							echo "done (".(time ()).")";
							$g_cronjob_function ();
						}
						else { echo "failed (".(time ()).")\n>> Job has been canceled"; }
					}
				}
				else { echo "failed (".(time ()).")\n>> Job has been canceled"; }
			}
			else { direct_tmp_storage_write ("",$direct_cachedata['job_data']['job_identifier'],"","","s"); }

			if ($direct_cachedata['job_data']['job_log'])
			{
$g_log_array = array (
"ddblog_identifier" => "cron_result",
"ddblog_data" => $direct_cachedata['job_result'],
"ddblog_sid" => "9d3bb895f22bf0afa958d68c2a58ded7",
// md5 ("cron")
"ddblog_maintained" => 1
);

				direct_log_write ($g_log_array);
			}

			if ($direct_cachedata['job_data']['loop'])
			{
				$g_threshold_min = ($direct_cachedata['core_time'] + $direct_cachedata['job_data']['loop_interval'] - 30);
				$g_threshold_max = ($direct_cachedata['core_time'] + (2 * $direct_cachedata['job_data']['loop_interval']) + 120);

				direct_tmp_storage_write ($direct_cachedata['job_data'],$direct_cachedata['job_data']['job_identifier'],"9d3bb895f22bf0afa958d68c2a58ded7",$direct_cachedata['job']['ddbtmp_storage_identifier'],"evars",$g_threshold_min,$g_threshold_max,$direct_cachedata['job']['ddbtmp_storage_maintained']);
				// md5 ("cron")
			}
			else { direct_tmp_storage_write ("",$direct_cachedata['job_data']['job_identifier'],"","","s"); }
		}
		else { echo "failed (".(time ()).")\n> Job seems to be invalid"; }
	}
}
//j// EOA
}
else { header ("HTTP/1.1 403 Forbidden"); }

$direct_cachedata['core_service_activated'] = true;

//j// EOF
?>