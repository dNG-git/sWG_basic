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
* This module provides user centric functions for the sWG kernel.
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
* @subpackage kernel
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

/* -------------------------------------------------------------------------
Testing for required classes
------------------------------------------------------------------------- */

if (!defined ("CLASS_direct_kernel_user"))
{
//c// direct_kernel_user
/**
* "direct_kernel_user" provides the default interface to user specific data.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage kernel
* @uses       CLASS_direct_virtual_class
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_kernel_user extends direct_virtual_class
{
/**
	* @var array $user_cache User cache
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $user_cache;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_kernel_user->__construct () and direct_kernel_user->direct_kernel_user ()
/**
	* Constructor (PHP5) __construct (direct_kernel_user)
	*
	* @uses  direct_class_function_check()
	* @uses  direct_debug()
	* @uses  direct_kernel_system::v_call_set()
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_classes;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -subkernel_user->__construct (direct_kernel_user)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions
------------------------------------------------------------------------- */

		$this->functions['user_check'] = false;
		$this->functions['user_get'] = false;
		$this->functions['user_init'] = false;
		$this->functions['user_parse'] = false;
		$this->functions['user_insert'] = false;
		$this->functions['user_update'] = false;
		$this->functions['user_write_kernel'] = false;
		$this->functions['usertype_get_int'] = false;

/* -------------------------------------------------------------------------
Set up the user initialisation code
------------------------------------------------------------------------- */

		if (!direct_class_function_check ($direct_classes['kernel'],"v_user_init"))
		{
			$direct_classes['kernel']->v_call_set ("v_user_init",$this,"user_init");
			$this->functions['user_init'] = true;
		}

		$this->user_cache = array ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_kernel_user (direct_kernel_user)
	*
	* @since v0.1.00
*\/
	function direct_kernel_user () { $this->__construct (); }
:#*/
	//f// direct_kernel_user->user_check ($f_user_id,$f_username = "",$f_all = false)
/**
	* Check if a user account exist.
	*
	* @param  string $f_user_id User ID
	* @param  string $f_username Username
	* @param  boolean $f_all Include banned and locked account if true
	* @uses   direct_debug()
	* @uses   direct_user->get()
	* @uses   USE_debug_reporting
	* @return boolean True if the user exists and no error occurred
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function user_check ($f_user_id,$f_username = "",$f_all = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -subkernel_user->user_check ($f_user_id,$f_username,+f_all)- (#echo(__LINE__)#)"); }

		$f_return = false;
		$f_user_array = array ();
		$f_username_id = md5 ($f_username);

		if (($f_user_id)&&(isset ($this->user_cache['userids'][$f_user_id]))) { $f_user_array = $this->user_cache['userids'][$f_user_id]->get (); }
		elseif (isset ($this->user_cache['usernames'][$f_username_id])) { $f_user_array = $this->user_cache['usernames'][$f_username_id]->get (); }

		if (empty ($f_user_array))
		{
			$f_user_object = new direct_user ();
			$f_user_array = $f_user_object->get ($f_user_id,$f_username,$f_all);

			if ($f_user_array)
			{
				$this->user_cache['userids'][$f_user_array['ddbusers_id']] = $f_user_object;
				$f_username_id = md5 ($f_user_array['ddbusers_name']);
				$this->user_cache['usernames'][$f_username_id] =& $this->user_cache['userids'][$f_user_id];
			}
		}

		if ($f_user_array)
		{
			if (!$f_all)
			{
				if ((!$f_user_array['ddbusers_banned'])&&(!$f_user_array['ddbusers_locked'])) { $f_return = true; }
			}
			else { $f_return = true; }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_user->user_check ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_kernel_user->user_get ($f_user_id,$f_username = "",$f_all = false,$f_overwrite = false)
/**
	* Get user data using the user ID or username.
	*
	* @param  string $f_user_id User ID
	* @param  string $f_username Username
	* @param  boolean $f_all Include banned, locked and deleted accounts if true
	* @param  boolean $f_overwrite Overwrite already read data
	* @uses   direct_debug()
	* @uses   direct_user->get()
	* @uses   USE_debug_reporting
	* @return mixed User data array on success; False on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function user_get ($f_user_id,$f_username = "",$f_all = false,$f_overwrite = false)
	{
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -subkernel_user->user_get ($f_user_id,$f_username,+f_all,+f_force)- (#echo(__LINE__)#)"); }

		$f_continue_check = false;
		$f_return = false;

		if (strlen ($f_user_id))
		{
			if ((!$f_overwrite)&&(isset ($this->user_cache['userids'][$f_user_id]))) { $f_return = $this->user_cache['userids'][$f_user_id]->get (); }
			else { $f_continue_check = true; }
		}
		else
		{
			$f_username_id = md5 ($f_username);

			if ((!$f_overwrite)&&(isset ($this->user_cache['usernames'][$f_username_id])))
			{
				$f_return = $this->user_cache['usernames'][$f_username_id]->get ();
				if ((!$f_all)&&($f_return['ddbusers_deleted'])) { $f_return = false; }
			}
			else { $f_continue_check = true; }
		}

		if ($f_continue_check)
		{
			$f_user_object = new direct_user ();
			$f_user_array = $f_user_object->get ($f_user_id,$f_username,$f_all);

			if ($f_user_array)
			{
				$this->user_cache['userids'][$f_user_array['ddbusers_id']] = $f_user_object;
				$f_username_id = md5 ($f_user_array['ddbusers_name']);
				$this->user_cache['usernames'][$f_username_id] =& $this->user_cache['userids'][$f_user_id];

				$f_return = $f_user_array;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_user->user_get ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_kernel_user->user_init ($f_threshold_id = "")
/**
	* Initiates the user subkernel.
	*
	* @param  string $f_threshold_id This parameter is used to determine if
	*         a request to write data is below the threshold (timeout). Multiple
	*         thresholds may exist.
	* @uses   direct_basic_functions->include_file()
	* @uses   direct_class_function_check()
	* @uses   direct_class_init()
	* @uses   direct_db::v_connect()
	* @uses   direct_debug()
	* @uses   direct_evars_get()
	* @uses   direct_kernel_system::v_user_check()
	* @uses   direct_kernel_system::v_user_get()
	* @uses   direct_kernel_system::v_uuid_check_usage()
	* @uses   direct_kernel_system::v_uuid_cookie_save()
	* @uses   direct_kernel_system::v_uuid_get()
	* @uses   direct_kernel_system::v_uuid_write()
	* @uses   direct_virtual_class::v_call_set()
	* @uses   direct_local_integration()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function user_init ($f_threshold_id = "")
	{
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -subkernel_user->user_init ()- (#echo(__LINE__)#)"); }

		$f_return = true;

		if (!isset ($direct_classes['db']))
		{
			$f_return = false;

			if ($direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_db.php",1))
			{
				if (direct_class_init ("db")) { $f_return = $direct_classes['db']->v_connect (); }
			}
		}

		if (!class_exists ("direct_user",/*#ifndef(PHP4) */false/* #*/))
		{
			if (!$direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/dhandler/swg_user.php",1)) { $f_return = false; }
		}

		if ($f_return)
		{
			$direct_classes['kernel']->v_call_set ("v_user_check",$this,"user_check");
			$direct_classes['kernel']->v_call_set ("v_user_get",$this,"user_get");
			$direct_classes['kernel']->v_call_set ("v_user_parse",$this,"user_parse");
			$direct_classes['kernel']->v_call_set ("v_user_insert",$this,"user_insert");
			$direct_classes['kernel']->v_call_set ("v_user_update",$this,"user_update");
			$direct_classes['kernel']->v_call_set ("v_user_write_kernel",$this,"user_write_kernel");
			$direct_classes['kernel']->v_call_set ("v_usertype_get_int",$this,"usertype_get_int");
			$this->functions['user_check'] = true;
			$this->functions['user_get'] = true;
			$this->functions['user_parse'] = true;
			$this->functions['user_insert'] = true;
			$this->functions['user_update'] = true;
			$this->functions['user_write_kernel'] = true;
			$this->functions['usertype_get_int'] = true;

			$direct_cachedata['kernel_lastvisit'] = 0;

			if (direct_class_function_check ($direct_classes['kernel'],"v_uuid_get")) { $f_uuid_data = $direct_classes['kernel']->v_uuid_get ("s"); }
			else { $f_uuid_data = ""; }

			if ($f_uuid_data)
			{
				$f_uuid_array = direct_evars_get ($f_uuid_data);

				if ($f_uuid_array)
				{
					if ($direct_classes['kernel']->v_user_check ($f_uuid_array['userid']))
					{
						if (direct_class_function_check ($direct_classes['kernel'],"v_uuid_write"))
						{
							if ((strlen ($f_threshold_id))&&(isset ($direct_settings[$f_threshold_id."_threshold"])))
							{
								if ((!isset ($f_uuid_array[$f_threshold_id."_threshold"]))||($direct_cachedata['core_time'] > $f_uuid_array[$f_threshold_id."_threshold"]))
								{
									$f_uuid_array[$f_threshold_id."_threshold"] = ($direct_cachedata['core_time'] + $direct_settings[$f_threshold_id."_threshold"]);
									$f_uuid_data = direct_evars_write ($f_uuid_array);
								}
								else { $direct_settings[$f_threshold_id."_threshold_warning"] = true; }
							}

							$direct_classes['kernel']->v_uuid_write ($f_uuid_data);
							$direct_classes['kernel']->v_uuid_cookie_save ();
						}

						$f_user_array = $direct_classes['kernel']->v_user_get ($f_uuid_array['userid']);

						if ((!isset ($GLOBALS['i_lang']))&&(file_exists ($direct_settings['path_lang']."/swg_core.{$f_user_array['ddbusers_lang']}.php")))
						{
							$direct_settings['lang'] = $f_user_array['ddbusers_lang'];
/* -------------------------------------------------------------------------
Reloading language file (if required)
------------------------------------------------------------------------- */

							direct_local_integration ("core","en",true);
						}

						if (!isset ($GLOBALS['i_theme'])) { $direct_settings['theme'] = $f_user_array['ddbusers_theme']; }

						$direct_cachedata['kernel_lastvisit'] = $f_user_array['ddbusers_lastvisit_time'];
						$direct_settings['user'] = array ("id" => $f_uuid_array['userid'],"name" => $f_uuid_array['username'],"name_html" => (direct_html_encode_special ($f_uuid_array['username'])),"type" => $f_user_array['ddbusers_type'],"timezone" => $f_user_array['ddbusers_timezone']);
						if (isset ($f_uuid_array['groups'])) { $direct_settings['user']['groups'] = $f_uuid_array['groups']; }
						if (isset ($f_uuid_array['rights'])) { $direct_settings['user']['rights'] = $f_uuid_array['rights']; }

						$direct_classes['kernel']->v_user_write_kernel ($direct_settings['user']['id']);
					}
					else
					{
						$direct_settings['user'] = array ("id" => "","type" => "gt","timezone" => 0);
						if (isset ($f_uuid_array['groups'])) { $direct_settings['user']['groups'] = $f_uuid_array['groups']; }
						if (isset ($f_uuid_array['rights'])) { $direct_settings['user']['rights'] = $f_uuid_array['rights']; }

						if ($direct_classes['kernel']->v_uuid_check_usage ())
						{
							$direct_classes['kernel']->v_uuid_write ($f_uuid_data);
							$direct_classes['kernel']->v_uuid_cookie_save ();
						}
					}
				}
			}

			if (isset ($_COOKIE[$direct_settings['swg_cookie_name']."_lastvisit"]))
			{
				if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($_COOKIE[$direct_settings['swg_cookie_name']."_lastvisit"],"=") === false) { $_COOKIE[$direct_settings['swg_cookie_name']."_lastvisit"] = urldecode ($_COOKIE[$direct_settings['swg_cookie_name']."_lastvisit"]); }
				$f_lastvisit_array = explode ("|",$_COOKIE[$direct_settings['swg_cookie_name']."_lastvisit"]);
			}
			else { $f_lastvisit_array = array (); }

			if (count ($f_lastvisit_array) < 2)
			{
				$f_lastvisit_array[0] = $direct_cachedata['core_time'];
				$direct_cachedata['kernel_lastvisit'] = $direct_cachedata['core_time'];
			}
			elseif (($f_lastvisit_array[1] + $direct_settings['swg_lastvisit_timeout']) < $direct_cachedata['core_time'])
			{
				$f_lastvisit_array[0] = $f_lastvisit_array[1];
				$direct_cachedata['kernel_lastvisit'] = $f_lastvisit_array[1];
			}
			else { $direct_cachedata['kernel_lastvisit'] = $f_lastvisit_array[0]; }

			$f_lastvisit_array[1] = $direct_cachedata['core_time'];
			$f_cookie_data = urlencode ($f_lastvisit_array[0]."|".$f_lastvisit_array[1]);

			$f_cookie_expires = (gmdate ("D, d-M-y H:i:s",($direct_cachedata['core_time'] + 31536000)))." GMT";

			$f_cookie_options = "";
			if ($direct_settings['swg_cookie_path']) { $f_cookie_options .= " PATH=$direct_settings[swg_cookie_path];"; }
			if ($direct_settings['swg_cookie_server']) { $f_cookie_options .= " DOMAIN=$direct_settings[swg_cookie_server];"; }

			$f_cookie_name = $direct_settings['swg_cookie_name']."_lastvisit";
			$direct_cachedata['core_cookies'][$f_cookie_name] = $f_cookie_name."=$f_cookie_data;$f_cookie_options EXPIRES=$f_cookie_expires; HTTPONLY";
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_user->user_init ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_kernel_user->user_parse ($f_user_id = "",$f_data = "")
/**
	* Parses given user data in preparation for (X)HTML output .
	*
	* @param  string $f_user_id User ID
	* @param  mixed $f_data Array containing user data or empty string
	* @param  string $f_prefix Key prefix
	* @uses   direct_debug()
	* @uses   direct_user->parse()
	* @uses   direct_user->set()
	* @uses   USE_debug_reporting
	* @return mixed Parsed (X)HTML data array; False on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function user_parse ($f_user_id = "",$f_data = "",$f_prefix = "")
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -subkernel_user->user_parse ($f_user_id,+f_data,$f_prefix)- (#echo(__LINE__)#)"); }

		$f_return = false;

 		if (is_array ($f_data))
 		{
 			if (isset ($f_data['ddbusers_id'])) { $f_user_id = $f_data['ddbusers_id']; }
 		}

 		if (!is_string ($f_user_id)) { $f_user_id = ""; }

		if (strlen ($f_user_id))
		{
 			if (isset ($this->user_cache['userids'][$f_user_id])) { $f_return = $this->user_cache['userids'][$f_user_id]->parse ($f_prefix); }
	 		elseif (is_array ($f_data))
 			{
	 			if (isset ($f_data['ddbusers_name']))
	 			{
					if ((strlen ($f_user_id))&&(empty ($f_data['ddbusers_id']))) { $f_data['ddbusers_id'] = $f_user_id; }

					if (isset ($f_data['ddbusers_id']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_data['ddbusers_name']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_data['ddbusers_password']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_data['ddbusers_email']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_data['ddbusers_registration_ip']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_data['ddbusers_registration_time']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_data['ddbusers_secid']))
					{
		 				$this->user_cache['userids'][$f_user_id] = new direct_user ();
 						$this->user_cache['userids'][$f_user_id]->set ($f_data);
						$f_username_id = md5 ($f_data['ddbusers_name']);
						$this->user_cache['usernames'][$f_username_id] =& $this->user_cache['userids'][$f_user_id];

						$f_user_object =& $this->user_cache['userids'][$f_user_id];
					}
					else { $f_user_object = new direct_user (); }
	 				
 					$f_user_object->set ($f_data);
 					$f_return = $f_user_object->parse ($f_prefix);
	 			}
 			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_user->user_parse ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_kernel_user->user_insert ($f_user_id = "",$f_data = "",$f_use_current_data = true)
/**
	* Inserts a new user to the user cache and database.
	*
	* @param  string $f_user_id User ID
	* @param  mixed $f_data Array containing user data or empty string
	* @param  boolean $f_use_current_data True to set user settings to current
	*         ones (time, theme, ...)
	* @uses   direct_debug()
	* @uses   direct_user->set()
	* @uses   direct_user->set_insert()
	* @uses   direct_user->update()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function user_insert ($f_user_id = "",$f_data = "",$f_use_current_data = true)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -subkernel_user->user_insert ($f_user_id,+f_data,+f_use_current_data)- (#echo(__LINE__)#)"); }

		$f_return = false;

 		if (!is_string ($f_user_id)) { $f_user_id = ""; }

		if (strlen ($f_user_id)) { $f_user_id = $f_user_id; }
 		elseif (is_array ($f_data))
 		{
 			if (isset ($f_data['ddbusers_id'])) { $f_user_id = $f_data['ddbusers_id']; }
 		}

		if ((strlen ($f_user_id))&&(isset ($f_data['ddbusers_name']))&&(is_array ($f_data)))
		{
			if ($f_use_current_data)
			{
				$f_data['ddbusers_lang'] = $direct_settings['lang'];
				$f_data['ddbusers_theme'] = $direct_settings['theme'];
				$f_data['ddbusers_lastvisit_ip'] = $direct_settings['user_ip'];
				$f_data['ddbusers_lastvisit_time'] = $direct_cachedata['core_time'];
			} 

			if ((strlen ($f_user_id))&&(empty ($f_data['ddbusers_id']))) { $f_data['ddbusers_id'] = $f_user_id; }

			$this->user_cache['userids'][$f_user_id] = new direct_user ();
			$f_return = $this->user_cache['userids'][$f_user_id]->set_insert ($f_data);

			if ($f_return)
			{
				$f_username_id = md5 ($f_data['ddbusers_name']);
				$this->user_cache['usernames'][$f_username_id] =& $this->user_cache['userids'][$f_user_id];
			}
			else { unset ($this->user_cache['userids'][$f_user_id]); }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_user->user_insert ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_kernel_user->user_update ($f_user_id = "",$f_data = "",$f_use_current_data = true)
/**
	* Updates all user specific data in the user cache and database.
	*
	* @param  string $f_user_id User ID
	* @param  mixed $f_data Array containing user data or empty string
	* @param  boolean $f_use_current_data True to set user settings to current
	*         ones (time, theme, ...)
	* @uses   direct_debug()
	* @uses   direct_user->set()
	* @uses   direct_user->set_insert()
	* @uses   direct_user->update()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function user_update ($f_user_id = "",$f_data = "",$f_use_current_data = true)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -subkernel_user->user_update ($f_user_id,+f_data,+f_use_current_data)- (#echo(__LINE__)#)"); }

		$f_return = false;

 		if (!is_string ($f_user_id)) { $f_user_id = ""; }

		if (strlen ($f_user_id)) { $f_user_id = $f_user_id; }
 		elseif (is_array ($f_data))
 		{
 			if (isset ($f_data['ddbusers_id'])) { $f_user_id = $f_data['ddbusers_id']; }
 		}

		if (strlen ($f_user_id))
		{
			if ((is_array ($f_data))&&($f_use_current_data))
			{
				$f_data['ddbusers_lang'] = $direct_settings['lang'];
				$f_data['ddbusers_theme'] = $direct_settings['theme'];
				$f_data['ddbusers_lastvisit_ip'] = $direct_settings['user_ip'];
				$f_data['ddbusers_lastvisit_time'] = $direct_cachedata['core_time'];
			} 

 			if (isset ($this->user_cache['userids'][$f_user_id]))
 			{
 				if (is_array ($f_data)) { $this->user_cache['userids'][$f_user_id]->set ($f_data); }
 				$f_return = $this->user_cache['userids'][$f_user_id]->update ();
 			}
	 		elseif (is_array ($f_data))
 			{
	 			if (isset ($f_data['ddbusers_name']))
	 			{
					if ((strlen ($f_user_id))&&(empty ($f_data['ddbusers_id']))) { $f_data['ddbusers_id'] = $f_user_id; }

	 				$this->user_cache['userids'][$f_user_id] = new direct_user ();
 					$f_return = $this->user_cache['userids'][$f_user_id]->set_update ($f_data);

					if ($f_return)
					{
						$f_username_id = md5 ($f_data['ddbusers_name']);
						$this->user_cache['usernames'][$f_username_id] =& $this->user_cache['userids'][$f_user_id];
					}
					else { unset ($this->user_cache['userids'][$f_user_id]); }
	 			}
 			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_user->user_update ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_kernel_user->user_write_kernel ($f_user_id)
/**
	* Writes kernel specific data like the last visit time to the database.
	*
	* @param  string $f_user_id User ID
	* @uses   direct_db->define_row_conditions()
	* @uses   direct_db->define_row_conditions_encode()
	* @uses   direct_db->define_set_attributes()
	* @uses   direct_db->define_set_attributes_encode()
	* @uses   direct_db->init_update()
	* @uses   direct_db->optimize_random()
	* @uses   direct_db->query_exec()
	* @uses   direct_dbsync_event()
	* @uses   direct_debug()
	* @uses   direct_user->get()
	* @uses   direct_user->set()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function user_write_kernel ($f_user_id)
	{
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -subkernel_user->user_write_kernel ($f_user_id)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (isset ($direct_classes['db']))
		{
			$direct_classes['db']->init_update ($direct_settings['users_table']);

			if ($direct_settings['swg_ip_save2db']) { $f_user_ip = $direct_settings['user_ip']; }
			else { $f_user_ip = "unknown"; }

$f_data = ("<sqlvalues>
".($direct_classes['db']->define_set_attributes_encode ($direct_settings['users_table'].".ddbusers_lang",$direct_settings['lang'],"string"))."
".($direct_classes['db']->define_set_attributes_encode ($direct_settings['users_table'].".ddbusers_theme",$direct_settings['theme'],"string"))."
".($direct_classes['db']->define_set_attributes_encode ($direct_settings['users_table'].".ddbusers_lastvisit_ip",$f_user_ip,"string"))."
".($direct_classes['db']->define_set_attributes_encode ($direct_settings['users_table'].".ddbusers_lastvisit_time",$direct_cachedata['core_time'],"string"))."
</sqlvalues>");

			$direct_classes['db']->define_set_attributes ($f_data);

			$f_data = "<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['users_table'].".ddbusers_id",$f_user_id,"string"))."</sqlconditions>";
			$direct_classes['db']->define_row_conditions ($f_data);

			$f_return = $direct_classes['db']->query_exec ("co");

			if ($f_return)
			{
				if (function_exists ("direct_dbsync_event")) { direct_dbsync_event ($direct_settings['users_table'],"update",$f_data); }
				if (!$direct_settings['swg_auto_maintenance']) { $direct_classes['db']->optimize_random ($direct_settings['users_table']); }

				if (isset ($this->user_cache['userids'][$f_user_id]))
				{
					$f_user_array = $this->user_cache['userids'][$f_user_id]->get ();
					$f_user_array['ddbusers_lang'] = $direct_settings['lang'];
					$f_user_array['ddbusers_theme'] = $direct_settings['theme'];
					$f_user_array['ddbusers_lastvisit_ip'] = $direct_settings['user_ip'];
					$f_user_array['ddbusers_lastvisit_time'] = $direct_cachedata['core_time'];
 					$this->user_cache['userids'][$f_user_id]->set ($f_user_array);
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_user->user_write_kernel ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_kernel_user->usertype_get_int ($f_data = 0)
/**
	* Return a integer value of the given group type string.
	*
	* @param  string $f_data String value for a group type
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return integer Integer value for a group type
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function usertype_get_int ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -subkernel_user->usertype_get_int ($f_data)- (#echo(__LINE__)#)"); }

		switch ($f_data)
		{
		case "ad": { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_user->usertype_get_int ()- (#echo(__LINE__)#)",:#*/5/*#ifdef(DEBUG):,true):#*/; }
		case "ma": { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_user->usertype_get_int ()- (#echo(__LINE__)#)",:#*/4/*#ifdef(DEBUG):,true):#*/; }
		case "me": { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_user->usertype_get_int ()- (#echo(__LINE__)#)",:#*/1/*#ifdef(DEBUG):,true):#*/; }
		case "mo": { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_user->usertype_get_int ()- (#echo(__LINE__)#)",:#*/3/*#ifdef(DEBUG):,true):#*/; }
		case "sm": { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_user->usertype_get_int ()- (#echo(__LINE__)#)",:#*/2/*#ifdef(DEBUG):,true):#*/; }
		default: { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_user->usertype_get_int ()- (#echo(__LINE__)#)",:#*/0/*#ifdef(DEBUG):,true):#*/; }
		}
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_classes['@names']['kernel_user'] = "direct_kernel_user";
define ("CLASS_direct_kernel_user",true);

//j// Script specific functions

if (!isset ($direct_settings['swg_auto_maintenance'])) { $direct_settings['swg_auto_maintenance'] = false; }
if (!isset ($direct_settings['swg_ip_save2db'])) { $direct_settings['swg_ip_save2db'] = true; }
if (!isset ($direct_settings['swg_lastvisit_timeout'])) { $direct_settings['swg_lastvisit_timeout'] = 900; }

direct_class_init ("kernel_user");
}

//j// EOF
?>