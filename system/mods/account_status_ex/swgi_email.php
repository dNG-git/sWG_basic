<?php
//j// BOF

/*n// NOTE
----------------------------------------------------------------------------
secured WebGine
net-based application engine
----------------------------------------------------------------------------
(C) direct Netware Group - All rights reserved
http://www.direct-netware.de/redirect.php?swg

The following license agreement remains valid unless any additions or
changes are being made by direct Netware Group in a written form.

This program is free software; you can redistribute it and/or modify it
under the terms of the GNU General Public License as published by the
Free Software Foundation; either version 2 of the License, or (at your
option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
more details.

You should have received a copy of the GNU General Public License along with
this program; if not, write to the Free Software Foundation, Inc.,
59 Temple Place, Suite 330, Boston, MA 02111-1307, USA.
----------------------------------------------------------------------------
http://www.direct-netware.de/redirect.php?licenses;gpl
----------------------------------------------------------------------------
#echo(sWGbasicVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* account_status_ex/swgi_email.php
*
* @internal   We are using phpDocumentor to automate the documentation process
*             for creating the Developer's Manual. All sections including
*             these special comments will be removed from the release source
*             code.
*             Use the following line to ensure 76 character sizes:
* ----------------------------------------------------------------------------
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG
* @subpackage account
* @uses       direct_product_iversion
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;gpl
*             GNU General Public License 2
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

//f// direct_mods_account_status_ex_email_login ($f_data)
/**
* Modification function called by:
* m = account
* s = status_ex
* a = login
*
* @param  array $f_data Array containing call specific data.
* @uses   direct_debug()
* @uses   direct_local_get()
* @uses   direct_output_control::options_insert()
* @uses   USE_debug_reporting
* @return boolean Always true
* @since  v0.1.00
*/
function direct_mods_account_status_ex_email_login ($f_data)
{
	global $direct_cachedata,$direct_classes;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_mods_account_status_ex_email_login (+f_data)- (#echo(__LINE__)#)"); }

	if ($f_data[1] == "email")
	{
		$direct_cachedata['i_amods_account_status_ex_email'] = "";
		$direct_classes['formbuilder']->entry_add_email ("amods_account_status_ex_email",(direct_local_get ("account_email")),true,"l",5,255,(direct_local_get ("account_helper_email")),"",true);
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_mods_account_status_ex_email_login ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_mods_account_status_ex_email_login_check ($f_data)
/**
* Modification function called by:
* m = account
* s = status_ex
* a = login-save
*
* @param  array $f_data Array containing call specific data.
* @uses   direct_debug()
* @uses   direct_local_get()
* @uses   direct_output_control::options_insert()
* @uses   USE_debug_reporting
* @return boolean True if the modification is able to process the login
* @since  v0.1.00
*/
function direct_mods_account_status_ex_email_login_check ($f_data)
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_mods_account_status_ex_email_login_check (+f_data)- (#echo(__LINE__)#)"); }

	$f_return = ($f_data[0] ? $f_data[0] : false);

	if ($f_data[1] == "email")
	{
		$direct_cachedata['i_amods_account_status_ex_email'] = (isset ($GLOBALS['i_amods_account_status_ex_email']) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS['i_amods_account_status_ex_email'])) : "");
		$direct_classes['formbuilder']->entry_add_email ("amods_account_status_ex_email",(direct_local_get ("account_email")),true,"l",5,255,(direct_local_get ("account_helper_email")),"",true);
		$f_return = true;
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_mods_account_status_ex_email_login_check ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_mods_account_status_ex_email_login_process ($f_data)
/**
* Modification function called by:
* m = account
* s = status_ex
* a = login-save
*
* @param  array $f_data Array containing call specific data.
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return boolean True if modification login process was successful
* @since  v0.1.00
*/
function direct_mods_account_status_ex_email_login_process ($f_data)
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_mods_account_status_ex_email_login_process (+f_data)- (#echo(__LINE__)#)"); }

	$f_return = ($f_data[0] ? $f_data[0] : -1);

	if ($f_data[1] == "email")
	{
		$f_return = 1;
		$f_user_insert = false;

		if (is_array ($f_data[2]))
		{
			if ($f_data[2]['ddbusers_type'] != "ex")
			{
				$direct_cachedata['output_formelements']['6e50b8c9e332697b2f4299e46d305fb1']['error'] = direct_local_get ("errors_account_username_exists");
				// md5 ("i_ausername")
				$f_return = -1;
			}
			elseif (($f_data[2]['ddbusers_type_ex'] != "email")||($f_data[2]['ddbusers_email'] != $direct_cachedata['i_amods_account_status_ex_email']))
			{
				$direct_cachedata['output_formelements']['fb726466b46d55f1648fa354bb89f0c8']['error'] = direct_local_get ("errors_core_access_denied");
				// md5 ("i_amods_account_status_ex_email")
				$f_return = -1;
			}
			else { $f_user_array = $f_data[2]; }
		}
		else
		{
			$f_user_object = new direct_user ();

			if (($f_user_object)&&(direct_class_function_check ($f_user_object,"get_aid")))
			{
				$f_attributes = array ($direct_settings['users_table'].".ddbusers_banned",$direct_settings['users_table'].".ddbusers_deleted",$direct_settings['users_table'].".ddbusers_locked",$direct_settings['users_table'].".ddbusers_email");
				$f_values = array (0,0,0,$direct_cachedata['i_amods_account_status_ex_email']);
				$f_user_array = $f_user_object->get_aid ($f_attributes,$f_values);

				if (!is_array ($f_user_array))
				{
$f_user_array = array (
"ddbusers_id" => uniqid (""),
"ddbusers_type" => "ex",
"ddbusers_type_ex" => "email",
"ddbusers_banned" => 0,
"ddbusers_deleted" => 0,
"ddbusers_locked" => 0,
"ddbusers_name" => $direct_cachedata['i_ausername'],
"ddbusers_password" => "",
"ddbusers_email" => $direct_cachedata['i_amods_account_status_ex_email'],
"ddbusers_email_public" => 0,
"ddbusers_credits" => 0,
"ddbusers_registration_ip" => $direct_settings['user_ip'],
"ddbusers_registration_time" => $direct_cachedata['core_time'],
"ddbusers_secid" => "",
"ddbusers_lastvisit_ip" => $direct_settings['user_ip'],
"ddbusers_lastvisit_time" => $direct_cachedata['core_time'],
"ddbusers_timezone" => 0
);

					if ($f_user_object->set ($f_user_array)) { $f_user_insert = true; }
					else { $f_user_array = array ("ddbusers_type" => "gt"); }
				}

				if ($f_user_array['ddbusers_type'] != "ex")
				{
					$direct_cachedata['output_formelements']['6e50b8c9e332697b2f4299e46d305fb1']['error'] = direct_local_get ("errors_account_username_exists");
					// md5 ("i_ausername")
					$f_return = -1;
				}
				elseif ($f_user_array['ddbusers_type_ex'] != "email")
				{
					$direct_cachedata['output_formelements']['fb726466b46d55f1648fa354bb89f0c8']['error'] = direct_local_get ("errors_core_access_denied");
					// md5 ("i_amods_account_status_ex_email")
					$f_return = -1;
				}
				elseif ($f_user_array['ddbusers_deleted']) { $f_user_array['ddbusers_deleted'] = 0; }
			}
			else
			{
				$direct_cachedata['output_formelements']['fb726466b46d55f1648fa354bb89f0c8']['error'] = direct_local_get ("errors_core_unknown_error");
				// md5 ("i_amods_account_status_ex_email")
				$f_return = -1;
			}
		}

		if ($f_return > 0)
		{
			if ($f_user_insert) { $f_return = $direct_classes['kernel']->v_user_insert ($f_user_array['ddbusers_id'],$f_user_array); }
			else
			{
				if ($direct_cachedata['i_ausername'] != $f_user_array['ddbusers_name']) { $f_user_array['ddbusers_name'] = $direct_cachedata['i_ausername']; }
				$f_user_array['ddbusers_lastvisit_ip'] = $direct_settings['user_ip'];
				$f_user_array['ddbusers_lastvisit_time'] = $direct_cachedata['core_time'];
				$f_return = $direct_classes['kernel']->v_user_update ($f_user_array['ddbusers_id'],$f_user_array);
			}

			if ($f_return) { $f_return = 1; }
			else
			{
				$direct_cachedata['output_formelements']['fb726466b46d55f1648fa354bb89f0c8']['error'] = direct_local_get ("errors_core_unknown_error");
				// md5 ("i_amods_account_status_ex_email")
				$f_return = -1;
			}
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_mods_account_status_ex_email_login_process ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_mods_account_status_ex_email_login_save ($f_data)
/**
* Modification function called by:
* m = account
* s = status_ex
* a = login-save
*
* @param  array $f_data Array containing call specific data.
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return boolean True if modification login process was successful
* @since  v0.1.00
*/
function direct_mods_account_status_ex_email_login_save ($f_data)
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_mods_account_status_ex_email_login_save (+f_data)- (#echo(__LINE__)#)"); }

	$f_return = ((is_array ($f_data[0])) ? $f_data[0] : $f_data[3]);

	if (!$direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_sendmailer_formtags.php")) { $f_return = array (); }

	if (($f_data[1] == "email")&&(isset ($f_return['userid'])))
	{
		$f_uuid_storage_array = direct_tmp_storage_get ("evars",$direct_settings['uuid'],"","task_cache");
		if (!$f_uuid_storage_array) { $f_uuid_storage_array = array (); }

		$f_uuid_storage_array['account_status_ex_type'] = "email";
		$f_uuid_storage_array['account_status_ex_verified'] = 0;
		if (!isset ($f_uuid_storage_array['core_sid'])) { $f_uuid_storage_array['core_sid'] = "e268443e43d93dab7ebef303bbe9642f"; }
		// md5 ("account")
		if (!isset ($f_uuid_storage_array['uuid'])) { $f_uuid_storage_array['uuid'] = $direct_settings['uuid']; }

		if (direct_tmp_storage_write ($f_uuid_storage_array,$direct_settings['uuid'],$f_uuid_storage_array['core_sid'],"task_cache","evars",$direct_cachedata['core_time'],($direct_cachedata['core_time'] + $direct_settings['uuids_maxage_inactivity'])))
		{
			$f_vid = md5 (uniqid (""));
			$f_vid_timeout = ($direct_cachedata['core_time'] + $direct_settings['account_status_ex_email_validation_timeout']);

$f_vid_array = array (
"core_vid_module" => "account_status_ex_verification",
"account_username" => $direct_cachedata['i_ausername'],
"account_email" => $direct_cachedata['i_amods_account_status_ex_email'],
"account_uuid" => $direct_settings['uuid']
);

			$direct_cachedata['i_ausername'] = addslashes ($direct_cachedata['i_ausername']);

			if (direct_tmp_storage_write ($f_vid_array,$f_vid,"a617908b172c473cb8e8cda059e55bf0","status_ex","evars",0,$f_vid_timeout))
			// md5 ("validation")
			{
				$f_redirect_url = ((isset ($direct_settings['swg_redirect_url'])) ? $direct_settings['swg_redirect_url'] : $direct_settings['home_url']."/swg_redirect.php");
				$f_sendmailer_object = new direct_sendmailer_formtags ();
				$f_sendmailer_object->recipients_define (array ($direct_cachedata['i_amods_account_status_ex_email'] => $direct_cachedata['i_ausername']));

$f_message = ("[contentform:highlight]".(direct_local_get ("core_message_by_request","text"))."

[font:bold]".(direct_local_get ("core_message_to","text")).":[/font] $direct_cachedata[i_ausername] ($direct_cachedata[i_amods_account_status_ex_email])[/contentform]
".(direct_local_get ("core_validation_required","text"))."

".(direct_local_get ("account_status_ex_validation","text"))."

[url]$f_redirect_url?validation;{$f_vid}[/url]

".(direct_local_get ("core_one_line_link","text"))."

[hr]
(C) $direct_settings[swg_title_txt] ([url]{$direct_settings['home_url']}[/url])
All rights reserved");

				$f_sendmailer_object->message_set ($f_message);
				if (!$f_sendmailer_object->send ("single",$direct_settings['administration_email_out'],$direct_settings['swg_title_txt']." - ".(direct_local_get ("account_title_status_ex","text")))) { $f_return = array (); }
			}
			else { $f_return = array (); }
		}
		else { $f_return = array (); }
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_mods_account_status_ex_email_login_save ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// Script specific functions

if (!isset ($direct_settings['account_status_ex_email_validation_timeout'])) { $direct_settings['account_status_ex_email_validation_timeout'] = 18000; }
if (!isset ($direct_settings['uuids_maxage_inactivity'])) { $direct_settings['uuids_maxage_inactivity'] = 604800; }

//j// EOF
?>