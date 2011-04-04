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
* This module provides uuIDs (Unique User Identification Service) functions
* for the sWG kernel.
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

if (!defined ("CLASS_direct_kernel_uuids"))
{
//c// direct_kernel_uuids
/**
* uuIDs (Unique User Identification Service) functions provide the possibility
* to handle sessions and multi page data transfers.
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
class direct_kernel_uuids extends direct_virtual_class
{
/**
	* @var string $uuid Current uuID
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $uuid;
/**
	* @var boolean $uuid_cookie uuID cookie content
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $uuid_cookie;
/**
	* @var boolean $uuid_cookie_mode uuID cookie mode
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $uuid_cookie_mode;
/**
	* @var integer $uuid_cookie_timeout Timeout value
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $uuid_cookie_timeout;
/**
	* @var string $uuid_data Current read uuID data
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $uuid_data;
/**
	* @var string $uuid_passcode 96 byte PassCode
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $uuid_passcode;
/**
	* @var string $uuid_passcode Old 96 byte PassCode
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $uuid_passcode_prev;
/**
	* @var string $uuid_status uuIDs status
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $uuid_status;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_kernel_uuids->__construct () and direct_kernel_uuids->direct_kernel_uuids ()
/**
	* Constructor (PHP5) __construct (direct_kernel_uuids)
	*
	* @uses  direct_class_function_check()
	* @uses  direct_debug()
	* @uses  direct_kernel_system::v_uuid_init()
	* @uses  direct_virtual_class::v_call_set()
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -subkernel_uuids->__construct (direct_kernel_uuids)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions
------------------------------------------------------------------------- */

		$this->functions['uuid_check_usage'] = false;
		$this->functions['uuid_cookie_load'] = false;
		$this->functions['uuid_cookie_save'] = false;
		$this->functions['uuid_get'] = false;
		$this->functions['uuid_init'] = false;
		$this->functions['uuid_is_cookied'] = false;
		$this->functions['uuid_write'] = false;

/* -------------------------------------------------------------------------
Set up the unique user ID system
------------------------------------------------------------------------- */

		if (!direct_class_function_check ($direct_globals['kernel'],"v_uuid_init"))
		{
			$direct_globals['kernel']->v_call_set ("v_uuid_init",$this,"uuid_init");
			$this->functions['uuid_init'] = true;
		}

		$direct_globals['kernel']->v_uuid_init ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_kernel_uuids (direct_kernel_uuids)
	*
	* @since v0.1.00
*\/
	function direct_kernel_uuids () { $this->__construct (); }
:#*/
	//f// direct_kernel_uuids->uuid_check_usage ()
/**
	* We are using a cookie to transport the uuID and related data from one
	* session to another. Overwrite uuid_init where appropriately.
	*
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True if uuID is valid and used
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function uuid_check_usage ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -subkernel_uuids->uuid_check_usage ()- (#echo(__LINE__)#)"); }

		if (($this->uuid_status == "verified")&&(!empty ($this->uuid_data))) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_uuids->uuid_check_usage ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_uuids->uuid_check_usage ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_kernel_uuids->uuid_cookie_load ()
/**
	* We are using a cookie to transport the uuID and related data from one
	* request to another.
	*
	* @uses   direct_basic_functions::set_debug_result()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function uuid_cookie_load ()
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -subkernel_uuids->uuid_cookie_load ()- (#echo(__LINE__)#)"); }

		$f_return = false;

		if ((isset ($_COOKIE[$direct_settings['uuids_cookie']]))&&(trim ($_COOKIE[$direct_settings['uuids_cookie']])))
		{
			$f_uuid_maxage_inactivity = ($direct_cachedata['core_time'] + $direct_settings['uuids_maxage_inactivity']);
			$f_uuid_maxage_timeout = ($direct_cachedata['core_time'] + $direct_settings['uuids_maxage_timeout']);
			$uuid_name = "";
			$uuid_timeout = "";
			$uuid_passcode = "";
			$uuid_verification = "";

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($_COOKIE[$direct_settings['uuids_cookie']],"=") === false) { $_COOKIE[$direct_settings['uuids_cookie']] = urldecode ($_COOKIE[$direct_settings['uuids_cookie']]); }
			parse_str ($_COOKIE[$direct_settings['uuids_cookie']]);
			$f_cookie_data = preg_replace ("#&uuid_verification=(.*?)(&|$)#im","",$_COOKIE[$direct_settings['uuids_cookie']]);

			if ((($uuid_timeout + ($f_uuid_maxage_inactivity - $f_uuid_maxage_timeout)) > $direct_cachedata['core_time'])&&(trim ($uuid_passcode))&&((md5 ($f_cookie_data)) == $uuid_verification))
			{
				$f_return = true;

				$this->uuid = $uuid_name;
				$this->uuid_cookie_timeout = $uuid_timeout;
				$this->uuid_passcode = $uuid_passcode;
				$this->uuid_status = "unverified";
				$this->uuid_cookie_mode = true;

				$direct_globals['input']->uuid_set ($this->uuid);
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_uuids->uuid_cookie_load ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_kernel_uuids->uuid_cookie_save ()
/**
	* Writing the uuIDs cookie.
	*
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function uuid_cookie_save ()
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -subkernel_uuids->uuid_cookie_save ()- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (($direct_settings['uuids_setcookie'])&&($this->uuid_status == "verified"))
		{
			$f_cookie_expires = "Sat, 01-Jan-00 01:00:00 GMT";

			if ($this->uuid_cookie_mode)
			{
				if (($this->uuid)&&($this->uuid_data))
				{
					$f_uuid_maxage_inactivity = ($direct_cachedata['core_time'] + $direct_settings['uuids_maxage_inactivity']);
					$f_uuid_maxage_timeout = ($direct_cachedata['core_time'] + $direct_settings['uuids_maxage_timeout']);

					$this->uuid_cookie = ("uuid_name=".$this->uuid."&uuid_timeout=$f_uuid_maxage_timeout&uuid_passcode=".$this->uuid_passcode);
					$f_uuid_verification = md5 ($this->uuid_cookie);
					$this->uuid_cookie = urlencode ($this->uuid_cookie."&uuid_verification=".$f_uuid_verification);

					$f_cookie_expires = (gmdate ("D, d-M-y H:i:s",$f_uuid_maxage_inactivity))." GMT";
				}
				else { $this->uuid_cookie = ""; }
			}
			elseif ((isset ($_COOKIE[$direct_settings['uuids_cookie']]))&&(trim ($_COOKIE[$direct_settings['uuids_cookie']]))) { $this->uuid_cookie = ""; }
			else { $f_cookie_expires = ""; }

			if ($f_cookie_expires)
			{
				$f_cookie_options = "";
				if ($direct_settings['uuids_path']) { $f_cookie_options .= " PATH=$direct_settings[uuids_path];"; }
				if ($direct_settings['uuids_server']) { $f_cookie_options .= " DOMAIN=$direct_settings[uuids_server];"; }

				$direct_cachedata['core_cookies'][$direct_settings['uuids_cookie']] = $direct_settings['uuids_cookie']."=".$this->uuid_cookie.";$f_cookie_options EXPIRES=$f_cookie_expires; HTTPONLY";
			}

			$f_return = true;
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_uuids->uuid_cookie_save ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_kernel_uuids->uuid_get ($f_type,$f_cookie_mode = false)
/**
	* Checking the uuIDs and loading session data.
	*
	* @param  string $f_type Return type (a = array; s = string)
	* @param  mixed $f_cookie_mode Boolean for (de)activation - empty string to
	*         use system setting
	* @uses   direct_basic_functions::set_debug_result()
	* @uses   direct_basic_functions::tmd5()
	* @uses   direct_db::define_attributes()
	* @uses   direct_db::define_limit()
	* @uses   direct_db::define_row_conditions()
	* @uses   direct_db::define_row_conditions_encode()
	* @uses   direct_db::init_delete()
	* @uses   direct_db::init_select()
	* @uses   direct_db::query_exec()
	* @uses   direct_db::optimize_random()
	* @uses   direct_db::v_optimize()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return mixed Array or string on success; False on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function uuid_get ($f_type,$f_cookie_mode = false)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -subkernel_uuids->uuid_get ($f_type,+f_cookie_mode)- (#echo(__LINE__)#)"); }

		$f_return = false;
		if (!empty ($this->uuid_cookie_mode)) { $f_cookie_mode = $this->uuid_cookie_mode; }

		if ((((mt_rand (0,30)) > 20))&&(!$direct_settings['uuids_auto_maintenance']))
		{
			$direct_globals['db']->init_delete ($direct_settings['uuids_table']);

			$f_select_criteria = "<sqlconditions>".($direct_globals['db']->define_row_conditions_encode ($direct_settings['uuids_table'].".ddbuuids_list_maxage_inactivity",$direct_cachedata['core_time'],"number","<"))."</sqlconditions>";
			$direct_globals['db']->define_row_conditions ($f_select_criteria);

			if ($direct_globals['db']->query_exec ("co")) { $direct_globals['db']->optimize_random ($direct_settings['uuids_table']); }
		}

		if (($this->uuid_status != "verified")&&($this->uuid))
		{
			$direct_globals['db']->init_select ($direct_settings['uuids_table']);
			$direct_globals['db']->define_attributes ($direct_settings['uuids_table'].".*");

$f_select_criteria = ("<sqlconditions>
".($direct_globals['db']->define_row_conditions_encode ($direct_settings['uuids_table'].".ddbuuids_list_id",$this->uuid,"string"))."
".($direct_globals['db']->define_row_conditions_encode ($direct_settings['uuids_table'].".ddbuuids_list_maxage_inactivity",$direct_cachedata['core_time'],"number",">"))."
</sqlconditions>");

			$direct_globals['db']->define_row_conditions ($f_select_criteria);
			$direct_globals['db']->define_limit (1);

			$f_uuid_array = $direct_globals['db']->query_exec ("sa");
		}

		if (!trim ($this->uuid)) { $this->uuid_status = "invalid"; }
		elseif ($this->uuid_status == "new")
		{
			$this->uuid_status = "verified";
			$this->uuid_data = "";
			$f_return = "";

			mt_srand (/*#ifdef(PHP4):((double)microtime ()) * 1000000:#*/);
			if ($f_cookie_mode) { $this->uuid_passcode = $direct_globals['basic_functions']->tmd5 (uniqid (mt_rand ())); }
		}
		elseif ($this->uuid_status == "verified")
		{
			if ($f_type == "a") { $f_return = explode ("\n",(trim ($this->uuid_data))); }
			else { $f_return = trim ($this->uuid_data); }
		}
		elseif ($f_uuid_array)
		{
			$f_timeout_check = false;
			$f_validation_check = false;

			if ($this->uuid_cookie_timeout)
			{
				if ($f_uuid_array['ddbuuids_list_maxage_timeout'] >= $this->uuid_cookie_timeout) { $f_timeout_check = true; }
			}
			else { $f_timeout_check = true; }

			if (($f_uuid_array['ddbuuids_list_passcode_timeout'])||($this->uuid_passcode))
			{
				if (($f_uuid_array['ddbuuids_list_passcode'])&&($f_uuid_array['ddbuuids_list_passcode'] == $this->uuid_passcode)) { $f_validation_check = true; }

/* -------------------------------------------------------------------------
Parallel requests are supported. For a time of usually 2 seconds we accept
both the old and new passcode.
------------------------------------------------------------------------- */

				if (($f_uuid_array['ddbuuids_list_passcode_timeout'] - $direct_cachedata['core_time']) > ($direct_settings['uuids_passcode_timeout'] - $direct_settings['uuids_passcode_timeout_prev']))
				{
					$this->uuid_passcode_prev = $f_uuid_array['ddbuuids_list_passcode_prev'];
					if ((!$f_validation_check)&&($this->uuid_passcode == $this->uuid_passcode_prev)) { $f_validation_check = true; }
				}
			}
			else
			{
				if ($f_uuid_array['ddbuuids_list_ip'] == $direct_settings['user_ip']) { $f_validation_check = true; }
			}

			if (($f_timeout_check)&&($f_validation_check)&&($f_uuid_array['ddbuuids_list_maxage_inactivity'] > $direct_cachedata['core_time']))
			{
				$this->uuid_status = "verified";

				if ($f_uuid_array['ddbuuids_list_passcode_timeout'])
				{
					$this->uuid_cookie_mode = true;

					if ($f_uuid_array['ddbuuids_list_passcode_timeout'] < $direct_cachedata['core_time'])
					{
						mt_srand (/*#ifdef(PHP4):((double)microtime ()) * 1000000:#*/);
						$this->uuid_passcode_prev = $this->uuid_passcode;
						$this->uuid_passcode = $direct_globals['basic_functions']->tmd5 (uniqid (mt_rand ()));
					}
				}
				else { $this->uuid_cookie_mode = false; }

				if ($f_uuid_array['ddbuuids_list_ip'] == $direct_settings['user_ip']) { $direct_settings['user_ipcwarn'] = false; }
				else
				{
					$direct_globals['output']->warning (direct_local_get ("core_user_warning"),(direct_local_get ("core_user_warning_ip")));
					$direct_settings['user_ipcwarn'] = true;
				}

				$this->uuid_data = $f_uuid_array['ddbuuids_list_data'];
				$f_return = (($f_type == "a") ? explode ("\n",(trim ($this->uuid_data))) : trim ($this->uuid_data));
			}
			else { $this->uuid_status = "invalid"; }
		}
		else { $this->uuid_status = "invalid"; }

		if ($this->uuid_status == "invalid")
		{
			$direct_globals['db']->init_delete ($direct_settings['uuids_table']);

			$f_select_criteria = "<sqlconditions>".($direct_globals['db']->define_row_conditions_encode ($direct_settings['uuids_table'].".ddbuuids_list_id",$this->uuid,"string"))."</sqlconditions>";
			$direct_globals['db']->define_row_conditions ($f_select_criteria);

			$direct_globals['db']->define_limit (1);
			if (($direct_globals['db']->query_exec ("co"))&&(!$direct_settings['uuids_auto_maintenance'])) { $direct_globals['db']->v_optimize ($direct_settings['uuids_table']); }

			$this->uuid = md5 (uniqid ($direct_settings['user_ip']."_".(mt_rand ())."_"));
			$this->uuid_status = "verified";
			$this->uuid_data = "";

			$direct_globals['input']->uuid_set ($this->uuid);
			$f_return = "";

			mt_srand (/*#ifdef(PHP4):((double)microtime ()) * 1000000:#*/);
			if ($f_cookie_mode) { $this->uuid_passcode = $direct_globals['basic_functions']->tmd5 (uniqid (mt_rand ())); }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_uuids->uuid_get ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_kernel_uuids->uuid_init ($f_uuid = NULL)
/**
	* Getting the uuIDs up and running at kernel time.
	*
	* @param  string $f_uuid uuID of the current session
	* @uses   direct_basic_functions::include_file()
	* @uses   direct_db::connect()
	* @uses   direct_debug()
	* @uses   direct_kernel_uuids::uuid_cookie_load()
	* @uses   direct_kernel_uuids::uuid_init()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function uuid_init ($f_uuid = NULL)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -subkernel_uuids->uuid_init ($f_uuid)- (#echo(__LINE__)#)"); }

		if (!isset ($direct_globals['db']))
		{
			$f_return = false;

			if ($direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_db.php",1))
			{
				if (direct_class_init ("db")) { $f_return = $direct_globals['db']->v_connect (); }
			}
		}
		else { $f_return = true; }

		if ($f_return)
		{
/* -------------------------------------------------------------------------
Set the uuID for this session and activate other uuIDs specific functions.
------------------------------------------------------------------------- */

			if (isset ($f_uuid)) { $this->uuid = $f_uuid; }
			else { $this->uuid = $direct_globals['input']->uuid_get (); }

			$this->uuid_cookie_timeout = "";

			if (trim ($this->uuid)) { $this->uuid_status = "unverified"; }
			else
			{
				$this->uuid = md5 (uniqid ($direct_settings['user_ip']."_".(mt_rand ())."_"));
				$direct_globals['input']->uuid_set ($this->uuid);
			}

			$this->uuid_cookie = "";
			$this->uuid_cookie_mode = false;
			$this->uuid_data = "";
			$this->uuid_passcode = "";
			$this->uuid_passcode_prev = "";

			if (!direct_class_function_check ($direct_globals['kernel'],"v_uuid_check_usage"))
			{
				$direct_globals['kernel']->v_call_set ("v_uuid_check_usage",$this,"uuid_check_usage");
				$direct_globals['kernel']->v_call_set ("v_uuid_cookie_load",$this,"uuid_cookie_load");
				$direct_globals['kernel']->v_call_set ("v_uuid_cookie_save",$this,"uuid_cookie_save");
				$direct_globals['kernel']->v_call_set ("v_uuid_get",$this,"uuid_get");
				$direct_globals['kernel']->v_call_set ("v_uuid_is_cookied",$this,"uuid_is_cookied");
				$direct_globals['kernel']->v_call_set ("v_uuid_write",$this,"uuid_write");
				$this->functions['uuid_check_usage'] = true;
				$this->functions['uuid_cookie_load'] = true;
				$this->functions['uuid_cookie_save'] = true;
				$this->functions['uuid_get'] = true;
				$this->functions['uuid_is_cookied'] = true;
				$this->functions['uuid_write'] = true;
			}

			$direct_globals['kernel']->v_uuid_cookie_load ();
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_uuids->uuid_init ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_kernel_uuids->uuid_is_cookied ()
/**
	* Returns true if uuID relevant data are saved in a cookie.
	*
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True if a cookie is used
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function uuid_is_cookied ()
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -subkernel_uuids->uuid_is_cookied ()- (#echo(__LINE__)#)"); }

		if (($direct_settings['uuids_setcookie'])&&($this->uuid_status == "verified")&&($this->uuid_cookie_mode)) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_uuids->uuid_is_cookied ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_uuids->uuid_is_cookied ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_kernel_uuids->uuid_write ($f_data,$f_cookie_mode = "")
/**
	* Writes the uuID data to the database.
	*
	* @param  mixed $f_data uuID data array or string
	* @param  mixed $f_cookie_mode Boolean for (de)activation - empty string to
	*         use system setting
	* @uses   direct_basic_functions::tmd5()
	* @uses   direct_db::define_values()
	* @uses   direct_db::define_values_encode()
	* @uses   direct_db::define_values_keys()
	* @uses   direct_db::init_replace()
	* @uses   direct_db::query_exec()
	* @uses   direct_debug()
	* @uses   direct_kernel_uuids::uuid_get()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function uuid_write ($f_data,$f_cookie_mode = "")
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -subkernel_uuids->uuid_write ($f_data,+f_cookie_mode)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (is_bool ($f_cookie_mode)) { $this->uuid_cookie_mode = $f_cookie_mode; }
		else { $f_cookie_mode = $this->uuid_cookie_mode; }

		if ($this->uuid_status != "verified") { $direct_globals['kernel']->v_uuid_get ("s",$f_cookie_mode); }
		else
		{
			$f_uuid_data = ((is_array ($f_data)) ? trim (implode ("\n",$f_data)) : trim ($f_data));

			if ($f_uuid_data)
			{
				if (!$this->uuid) { $this->uuid = md5 (uniqid ($direct_settings['user_ip']."_".(mt_rand ())."_")); }
				$f_maxage_timeout = ($direct_cachedata['core_time'] + $direct_settings['uuids_maxage_timeout']);

				if ($f_cookie_mode)
				{
					$f_passcode_timeout = ($direct_cachedata['core_time'] + $direct_settings['uuids_passcode_timeout']);
					$f_maxage_inactivity = ($direct_cachedata['core_time'] + $direct_settings['uuids_maxage_inactivity']);

					if (!$this->uuid_passcode)
					{
						mt_srand (/*#ifdef(PHP4):((double)microtime ()) * 1000000:#*/);
						$this->uuid_passcode = $direct_globals['basic_functions']->tmd5 (uniqid (mt_rand ()));
					}
				}
				else
				{
					$f_passcode_timeout = 0;
					$f_maxage_inactivity = $f_maxage_timeout;

					if ($this->uuid_passcode) { $this->uuid_passcode = ""; }
				}

				$direct_globals['db']->init_replace ($direct_settings['uuids_table']);

				$f_replace_attributes = array ($direct_settings['uuids_table'].".ddbuuids_list_id",$direct_settings['uuids_table'].".ddbuuids_list_passcode_timeout",$direct_settings['uuids_table'].".ddbuuids_list_maxage_timeout",$direct_settings['uuids_table'].".ddbuuids_list_maxage_inactivity",$direct_settings['uuids_table'].".ddbuuids_list_ip",$direct_settings['uuids_table'].".ddbuuids_list_passcode",$direct_settings['uuids_table'].".ddbuuids_list_passcode_prev",$direct_settings['uuids_table'].".ddbuuids_list_data");
				$direct_globals['db']->define_values_keys ($f_replace_attributes);

$f_replace_values = ("<sqlvalues>
".($direct_globals['db']->define_values_encode ($this->uuid,"string"))."
".($direct_globals['db']->define_values_encode ($f_passcode_timeout,"number"))."
".($direct_globals['db']->define_values_encode ($f_maxage_timeout,"number"))."
".($direct_globals['db']->define_values_encode ($f_maxage_inactivity,"number"))."
".($direct_globals['db']->define_values_encode ($direct_settings['user_ip'],"string"))."
".($direct_globals['db']->define_values_encode ($this->uuid_passcode,"string"))."
".($direct_globals['db']->define_values_encode ($this->uuid_passcode_prev,"string"))."
".($direct_globals['db']->define_values_encode ($f_uuid_data,"string"))."
</sqlvalues>");

				$direct_globals['db']->define_values ($f_replace_values);
				$f_return = $direct_globals['db']->query_exec ("co");
				if ($f_return) { $this->uuid_data = $f_uuid_data; }
			}
			else
			{
				$direct_globals['db']->init_delete ($direct_settings['uuids_table']);

				$f_select_criteria = "<sqlconditions>".($direct_globals['db']->define_row_conditions_encode ($direct_settings['uuids_table'].".ddbuuids_list_id",$this->uuid,"string"))."</sqlconditions>";
				$direct_globals['db']->define_row_conditions ($f_select_criteria);

				if (($direct_globals['db']->query_exec ("co"))&&(!$direct_settings['uuids_auto_maintenance'])) { $direct_globals['db']->optimize_random ($direct_settings['uuids_table']); }
				$this->uuid = "";
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -subkernel_uuids->uuid_write ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_globals['@names']['kernel_uuids'] = "direct_kernel_uuids";
define ("CLASS_direct_kernel_uuids",true);

//j// Script specific functions

if (!isset ($direct_settings['swg_auto_maintenance'])) { $direct_settings['swg_auto_maintenance'] = false; }
if (!isset ($direct_settings['uuids_auto_maintenance'])) { $direct_settings['uuids_auto_maintenance'] = $direct_settings['swg_auto_maintenance']; }
if (!isset ($direct_settings['uuids_cookie'])) { $direct_settings['uuids_cookie'] = "direct_uuids"; }
if (!isset ($direct_settings['uuids_maxage_inactivity'])) { $direct_settings['uuids_maxage_inactivity'] = 604800; }
if (!isset ($direct_settings['uuids_maxage_timeout'])) { $direct_settings['uuids_maxage_timeout'] = 900; }
if (!isset ($direct_settings['uuids_passcode_timeout'])) { $direct_settings['uuids_passcode_timeout'] = 300; }
if (!isset ($direct_settings['uuids_passcode_timeout_prev'])) { $direct_settings['uuids_passcode_timeout_prev'] = 30; }
if (!isset ($direct_settings['uuids_path'])) { $direct_settings['uuids_path'] = ""; }
if (!isset ($direct_settings['uuids_server'])) { $direct_settings['uuids_server'] = ""; }
if (!isset ($direct_settings['uuids_setcookie'])) { $direct_settings['uuids_setcookie'] = true; }
if (!isset ($direct_settings['uuids_table'])) { $direct_settings['uuids_table'] = "direct_uuids_list"; }

direct_class_init ("kernel_uuids");
}

//j// EOF
?>