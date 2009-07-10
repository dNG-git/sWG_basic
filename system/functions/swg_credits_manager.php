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
* The sWG supports credits for payments or to provide "enhanced services" for
* active users.
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
* @subpackage account_credits
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

//f// direct_credits_payment_check ($f_return_information = false,$f_credits_change = 0)
/**
* Checks if a payment would be successful or not. Result is either a string
* or a boolean.
*
* @param  boolean $f_return_information True to return a string instead of a
*         boolean as result.
* @param  integer $f_credits_change Credits difference of the transaction
* @uses   direct_debug()
* @uses   direct_kernel_system::v_user_get()
* @uses   direct_local_get()
* @uses   USE_debug_reporting
* @return mixed String or boolean containing the payment status
* @since  v0.1.00
*/
function direct_credits_payment_check ($f_return_information = false,$f_credits_change = 0)
{
	global $direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_credits_payment_check (+f_return_information,$f_credits_change)- (#echo(__LINE__)#)"); }

	if ($direct_settings['account_credits'])
	{
		$f_credits_change = ceil ($f_credits_change);
		$f_result = false;

		if ($direct_settings['user']['id'])
		{
			$f_user_array = $direct_classes['kernel']->v_user_get ($direct_settings['user']['id']);

			if (($f_user_array['ddbusers_credits'])||($f_credits_change >= 0))
			{
				if ($f_credits_change >= 0) { $f_result = true; }
				else
				{
					if (($f_user_array['ddbusers_credits'] + $f_credits_change) >= 0) { $f_result = true; }
				}
			}
		}
		else
		{
			$f_user_array = array ("ddbusers_credits" => 0);
			if ($f_credits_change >= 0) { $f_result = true; }
		}

		if ($f_return_information)
		{
			if ($f_credits_change)
			{
				if ($f_result) { $f_return = (direct_local_get ("credits_manager_check_payment_1_1"))."<span style='font-weight:bold'>{$f_user_array['ddbusers_credits']}</span>".(direct_local_get ("credits_manager_check_payment_1_2"))."<span style='font-weight:bold'>".($f_user_array['ddbusers_credits'] + $f_credits_change)."</span>".(direct_local_get ("credits_manager_check_payment_1_3")); }
				else { $f_return = (direct_local_get ("credits_manager_check_payment_0_1"))."<span style='font-weight:bold'>{$f_user_array['ddbusers_credits']}</span>".(direct_local_get ("credits_manager_check_payment_0_2"))."<span style='font-weight:bold'>".($f_credits_change * -1)."</span>".(direct_local_get ("credits_manager_check_payment_0_3")); }
			}
			else { $f_return = ""; }
		}
		else { $f_return = $f_result; }
	}
	else
	{
		if ($f_return_information) { $f_return = ""; }
		else { $f_return = true; }
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_credits_payment_check ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_credits_payment_exec ($f_controller,$f_identifier,$f_id,$f_userid,$f_credits_onetime = 0,$f_credits_periodically = 0,$f_counter = 0)
/**
* Execute a payment.
*
* @param  string $f_controller The controller responsible for this payment.
* @param  string $f_identifier Payment identifier
* @param  string $f_id Payment ID
* @param  string $f_userid User ID used for the payment
* @param  integer $f_credits_onetime Onetime payment amount
* @param  integer $f_credits_periodically Periodically payment amount
* @param  integer $f_counter This parameter is used to limit the periodically
*         payments to a limited time.
* @uses   direct_db::define_values()
* @uses   direct_db::define_values_encode()
* @uses   direct_db::define_values_keys()
* @uses   direct_db::define_row_conditions()
* @uses   direct_db::define_row_conditions_encode()
* @uses   direct_db::init_delete()
* @uses   direct_db::init_replace()
* @uses   direct_db::query_exec()
* @uses   direct_db::v_optimize()
* @uses   direct_dbsync_event()
* @uses   direct_debug()
* @uses   direct_kernel_system::v_user_get()
* @uses   direct_kernel_system::v_user_update()
* @uses   direct_log_write()
* @uses   USE_debug_reporting
* @return boolean True on success
* @since  v0.1.00
*/
function direct_credits_payment_exec ($f_controller,$f_identifier,$f_id,$f_userid,$f_credits_onetime = 0,$f_credits_periodically = 0,$f_counter = 0)
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_credits_payment_exec ($f_controller,$f_identifier,$f_id,$f_userid,$f_credits_onetime,$f_credits_periodically)- (#echo(__LINE__)#)"); }

	if ($direct_settings['account_credits'])
	{
		$f_credits_onetime = ceil ($f_credits_onetime);
		$f_credits_periodically = ceil ($f_credits_periodically);
		$f_return = false;

		if ($f_userid) { $f_user_array = $direct_classes['kernel']->v_user_get ($f_userid); }
		else { $f_user_array = $direct_classes['kernel']->v_user_get ($direct_settings['user']['id']); }

		if ($f_user_array)
		{
			if ($f_credits_onetime)
			{
				$f_credits_old = $f_user_array['ddbusers_credits'];
				$f_user_array['ddbusers_credits'] += $f_credits_onetime;

				if ($f_user_array['ddbusers_credits'] < 0)
				{
$f_log_array = array (
"source_user_id" => $direct_settings['user']['id'],
"source_user_ip" => $direct_settings['user_ip'],
"target_user_id" => $f_user_array['ddbusers_id'],
"target_user_ip" => $f_user_array['ddbusers_lastvisit_ip'],
"sid" => "4063a52147d1bc5c975d3caf2966274d",
// md5 ("account_credits")
"identifier" => "account_credits_limit_zero_warning",
"data" => array ("fee" => $f_credits_onetime,"old" => $f_credits_old,"new" => $f_user_array['ddbusers_credits'])
);

					direct_log_write ($f_log_array);
					$f_user_array['ddbusers_credits'] = 0;
				}

				if ($f_user_array['ddbusers_credits'] > $direct_settings['users_credits_max'])
				{
$f_log_array = array (
"source_user_id" => $direct_settings['user']['id'],
"source_user_ip" => $direct_settings['user_ip'],
"target_user_id" => $f_user_array['ddbusers_id'],
"target_user_ip" => $f_user_array['ddbusers_lastvisit_ip'],
"sid" => "4063a52147d1bc5c975d3caf2966274d",
// md5 ("account_credits")
"identifier" => "account_credits_limit_max_warning",
"data" => array ("fee" => $f_credits_onetime,"old" => $f_credits_old,"new" => $f_user_array['ddbusers_credits'])
);

					direct_log_write ($f_log_array);
					$f_user_array['ddbusers_credits'] = $direct_settings['users_credits_max'];
				}

				if ($direct_classes['kernel']->v_user_update ($f_user_array['ddbusers_id'],$f_user_array))
				{
$f_log_array = array (
"source_user_id" => $direct_settings['user']['id'],
"source_user_ip" => $direct_settings['user_ip'],
"target_user_id" => $f_user_array['ddbusers_id'],
"target_user_ip" => $f_user_array['ddbusers_lastvisit_ip'],
"sid" => "4063a52147d1bc5c975d3caf2966274d",
// md5 ("account_credits")
"identifier" => "account_credits_payment",
"data" => array (
	"type" => "onetime",
	"fee" => $f_credits_onetime,
	"old" => $f_credits_old,
	"new" => $f_user_array['ddbusers_credits'],
	"controller" => $f_controller,
	"identifier" => $f_identifier,
	"objid" => $f_id
	)
);

					direct_log_write ($f_log_array);
					$f_return = true;
				}
			}
			else { $f_return = true; }

			if ($direct_settings['swg_auto_maintenance'])
			{
				if (($f_credits_periodically)&&($f_return))
				{
					$direct_classes['db']->init_insert ($direct_settings['users_credits_table']);

					$f_insert_attributes = array ($direct_settings['users_credits_table'].".ddbcredits_id",$direct_settings['users_credits_table'].".ddbcredits_id_obj",$direct_settings['users_credits_table'].".ddbcredits_id_user",$direct_settings['users_credits_table'].".ddbcredits_controller",$direct_settings['users_credits_table'].".ddbcredits_identifier",$direct_settings['users_credits_table'].".ddbcredits_time",$direct_settings['users_credits_table'].".ddbcredits_amount",$direct_settings['users_credits_table'].".ddbcredits_counter");
					$direct_classes['db']->define_values_keys ($f_insert_attributes);

					$f_credits_task_id = uniqid ("");
					$f_credits_task_time = ($direct_cachedata['core_time'] + ($direct_settings['users_credits_periodically_days'] * 86400));

$f_insert_values = ("<sqlvalues>
".($direct_classes['db']->define_values_encode ($f_credits_task_id,"string"))."
".($direct_classes['db']->define_values_encode ($f_id,"string"))."
".($direct_classes['db']->define_values_encode ($f_user_array['ddbusers_id'],"string"))."
".($direct_classes['db']->define_values_encode ($f_controller,"string"))."
".($direct_classes['db']->define_values_encode ($f_identifier,"string"))."
".($direct_classes['db']->define_values_encode ($f_credits_task_time,"number"))."
".($direct_classes['db']->define_values_encode ($f_credits_periodically,"number"))."
".($direct_classes['db']->define_values_encode ($f_counter,"number"))."
</sqlvalues>");

					$direct_classes['db']->define_values ($f_insert_values);
					$f_return = $direct_classes['db']->query_exec ("co");

					if (($f_return)&&(function_exists ("direct_dbsync_event"))) { direct_dbsync_event ($direct_settings['users_credits_table'],"insert",("<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ("ddbcredits_id",$f_credits_task_id,"string"))."</sqlconditions>")); }
				}
			}
			else { trigger_error ("sWG/#echo(__FILEPATH__)# -direct_credits_payment_exec ()- (#echo(__LINE__)#) reporting: sWG does not support periodically credits while running in non-auto-maintenance mode.",E_USER_WARNING); }

			if ((!$f_credits_onetime)&&(!$f_credits_periodically)&&($f_return))
			{
				$direct_classes['db']->init_delete ($direct_settings['users_credits_table']);

				$f_delete_criteria = "<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['users_credits_table'].".ddbcredits_id_obj",$f_id,"string"));
				if ($f_controller) { $f_delete_criteria .= $direct_classes['db']->define_row_conditions_encode ($direct_settings['users_credits_table'].".ddbcredits_controller",$f_controller,"string"); }
				if ($f_identifier) { $f_delete_criteria .= $direct_classes['db']->define_row_conditions_encode ($direct_settings['users_credits_table'].".ddbcredits_identifier",$f_identifier,"string"); }
				$f_delete_criteria .= "</sqlconditions>";

				$direct_classes['db']->define_row_conditions ($f_delete_criteria);
				$f_return = $direct_classes['db']->query_exec ("co");

				if ($f_return)
				{
					if (function_exists ("direct_dbsync_event")) { direct_dbsync_event ($direct_settings['users_credits_table'],"delete",$f_delete_criteria); }
					if (!$direct_settings['swg_auto_maintenance']) { $direct_classes['db']->v_optimize ($direct_settings['users_credits_table']); }
				}
			}
		}
	}
	else { $f_return = true; }

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_credits_payment_exec ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_credits_payment_get_specials ($f_identifier,$f_object,&$f_default_onetime,&$f_default_periodically)
/**
* Returns special payment values for the defined situation, user and group.
*
* @param  string $f_identifier Identifier for special credit settings
* @param  string $f_object The specific object (for example a category ID)
* @param  integer &$f_default_onetime Reference to the default onetime
*         payment amount
* @param  integer &$f_default_periodically Reference to the default
*         periodically payment amount
* @uses   direct_class_function_check()
* @uses   direct_db::define_attributes()
* @uses   direct_db::define_row_conditions()
* @uses   direct_db::define_row_conditions_encode()
* @uses   direct_db::init_select()
* @uses   direct_db::query_exec()
* @uses   direct_debug()
* @uses   direct_kernel_system::v_group_user_get_groups()
* @uses   USE_debug_reporting
* @since  v0.1.00
*/
function direct_credits_payment_get_specials ($f_identifier,$f_object,&$f_default_onetime,&$f_default_periodically)
{
	global $direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_credits_payment_get_specials ($f_identifier,$f_object,$f_default_onetime,$f_default_periodically)- (#echo(__LINE__)#)"); }

	if (($direct_settings['user']['type'] == "ad")||(!$direct_settings['account_credits']))
	{
		$f_default_onetime = 0;
		$f_default_periodically = 0;
	}
	elseif (($direct_settings['user']['type'] != "gt")&&(direct_class_function_check ($direct_classes['kernel'],"v_group_user_get_groups")))
	{
		$f_id_identifier = md5 ($f_identifier);

		$direct_classes['db']->init_select ($direct_settings['users_credits_specials_table']);
		$direct_classes['db']->define_attributes ("*");

		$f_select_criteria = "<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['users_credits_table'].".ddbcredits_specials_id_obj",$f_id_identifier,"string","==","or"))."</sqlconditions>";

		if ($f_object)
		{
			$f_id_obj = md5 ($f_identifier."_".$f_object);
			$f_select_criteria .= $direct_classes['db']->define_row_conditions_encode ($direct_settings['users_credits_table'].".ddbcredits_specials_id_obj",$f_id_obj,"string","==","or");
		}

		$f_select_criteria .= "</sqlconditions>";
		$direct_classes['db']->define_row_conditions ($f_select_criteria);

		$f_results_array = $direct_classes['db']->query_exec ("ma");

		if ($f_results_array)
		{
			$f_credits_default = array ();
			$f_credits_special_object = array ();
			$f_credits_special_groups = array ();

			foreach ($f_results_array as $f_result_array)
			{
				if ($f_result_array['ddbcredits_specials_id_obj'] == $f_id_identifier) { $f_credits_default = array ($f_result_array['ddbcredits_specials_onetime'],$f_result_array['ddbcredits_specials_periodically']); }
				if ($f_result_array['ddbcredits_specials_id_obj'] == $f_id_obj)
				{
					if ($f_result_array['ddbcredits_specials_group']) { $f_credits_special_groups[$f_result_array['ddbcredits_specials_group']] = $f_result_array; }
					else { $f_credits_special_object = array ($f_result_array['ddbcredits_specials_onetime'],$f_result_array['ddbcredits_specials_periodically']); }
				}
			}

			if (empty ($f_credits_special_object))
			{
				if (!empty ($f_credits_default))
				{
					$f_default_onetime = $f_credits_default[0];
					$f_default_periodically = $f_credits_default[1];
				}
			}

			if ($f_object)
			{
				$f_credits_special_group = array ();

				if (!empty ($f_credits_special_groups))
				{
					$f_groups_array = $direct_classes['kernel']->v_group_user_get_groups ();

					foreach ($f_credits_special_groups as $f_group => $f_result_array)
					{
						if (in_array ($f_group,$f_groups_array))
						{
							if ((empty ($f_credits_special_group))||($f_result_array['ddbcredits_specials_periodically'] < $f_credits_special_group[1])) { $f_credits_special_group = array ($f_result_array['ddbcredits_specials_onetime'],$f_result_array['ddbcredits_specials_periodically']); }
						}
					}
				}

				if (empty ($f_credits_special_group))
				{
					if (!empty ($f_credits_special_object))
					{
						$f_default_onetime = $f_credits_special_object[0];
						$f_default_periodically = $f_credits_special_object[1];
					}
				}
				else
				{
					$f_default_onetime = $f_credits_special_group[0];
					$f_default_periodically = $f_credits_special_group[1];
				}
			}
		}
	}
}

//f// direct_credits_payment_info ($f_credits_onetime = 0,$f_credits_periodically = 0)
/**
* Returns an informational message what will happen on
* "payment_exec()" based on the given values for "$f_credits_onetime"
* and "$f_credits_periodically".
*
* @param  integer $f_credits_onetime Onetime payment amount
* @param  integer $f_credits_periodically Periodically payment amount
* @uses   direct_debug()
* @uses   direct_local_get()
* @uses   USE_debug_reporting
* @return string Valid (X)HTML information string for output inclusion
* @since  v0.1.00
*/
function direct_credits_payment_info ($f_credits_onetime = 0,$f_credits_periodically = 0)
{
	global $direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_credits_payment_info ($f_credits_onetime,$f_credits_periodically)- (#echo(__LINE__)#)"); }

	if ($direct_settings['account_credits'])
	{
		$f_credits_onetime = ceil ($f_credits_onetime);
		$f_credits_periodically = ceil ($f_credits_periodically);
		$f_return = "";

		if ($f_credits_onetime)
		{
			if ($f_credits_onetime < 0)
			{
				$f_credits_onetime *= -1;
				$f_return .= (direct_local_get ("credits_manager_pay_onetime_preinfo_1"))."<span style='font-weight:bold'>$f_credits_onetime</span>".(direct_local_get ("credits_manager_pay_onetime_preinfo_2"));
			}
			else { $f_return .= (direct_local_get ("credits_manager_receive_onetime_preinfo_1"))."<span style='font-weight:bold'>$f_credits_onetime</span>".(direct_local_get ("credits_manager_receive_onetime_preinfo_2")); }
		}

		if (($direct_settings['swg_auto_maintenance'])&&($f_credits_periodically))
		{
			if ($f_return)
			{
				$f_return .= " ";
				$f_text_type = 2;
			}
			else { $f_text_type = 1; }

			if ($f_credits_periodically < 0)
			{
				$f_credits_periodically *= -1;
				$f_return .= (direct_local_get ("credits_manager_pay_periodically_preinfo_{$f_text_type}_1"))."<span style='font-weight:bold'>$f_credits_periodically</span>".(direct_local_get ("credits_manager_pay_periodically_preinfo_{$f_text_type}_2"));
			}
			else { $f_return .= (direct_local_get ("credits_manager_receive_periodically_preinfo_{$f_text_type}_1"))."<span style='font-weight:bold'>$f_credits_periodically</span>".(direct_local_get ("credits_manager_receive_periodically_preinfo_{$f_text_type}_2")); }
		}
	}
	else { $f_return = ""; }

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_credits_payment_info ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// Script specific commands

if (!isset ($direct_settings['account_credits'])) { $direct_settings['account_credits'] = false; }
if (!isset ($direct_settings['swg_auto_maintenance'])) { $direct_settings['swg_auto_maintenance'] = false; }
if (!isset ($direct_settings['users_credits_max'])) { $direct_settings['users_credits_max'] = 50000; }
if (!isset ($direct_settings['users_credits_periodically_days'])) { $direct_settings['users_credits_periodically_days'] = 30; }

$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_log_storager.php");
direct_local_integration ("credits_manager");

//j// EOF
?>