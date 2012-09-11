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
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
/*#ifdef(PHP5n) */

namespace dNG\sWG\kernel;
/* #*/
/*#use(direct_use) */
use dNG\sWG\directVirtualClass;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

if (!defined ("CLASS_directVUuids"))
{
/**
* uuIDs (Unique User Identification Service) functions provide the possibility
* to handle sessions and multi page data transfers.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage kernel
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directVUuids extends directVirtualClass
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
	* @var boolean $uuid_insert_mode True if the next "update ()" call is an
	*      insert - the code is the same.
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $uuid_insert_mode;
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

/**
	* Constructor (PHP5) __construct (directVUuids)
	*
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->__construct (directVUuids)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions
------------------------------------------------------------------------- */

		$this->functions['uuidCheckUsage'] = false;
		$this->functions['uuidCookieLoad'] = false;
		$this->functions['uuidCookieSave'] = false;
		$this->functions['uuidGet'] = false;
		$this->functions['uuidInit'] = false;
		$this->functions['uuidIsCookied'] = false;
		$this->functions['uuidWrite'] = false;

/* -------------------------------------------------------------------------
Set up the unique user ID system
------------------------------------------------------------------------- */

		if (!direct_class_function_check ($direct_globals['kernel'],"vUuidInit"))
		{
			$direct_globals['kernel']->vCallSet ("vUuidInit",$this,"uuidInit");
			$this->functions['uuidInit'] = true;
		}

		$direct_globals['kernel']->vUuidInit ();
		$this->uuid_insert_mode = false;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directVUuids (directVUuids)
	*
	* @since v0.1.00
*\/
	function directVUuids () { $this->__construct (); }
:#*/
/**
	* We are using a cookie to transport the uuID and related data from one
	* session to another. Overwrite uuidInit where appropriately.
	*
	* @return boolean True if uuID is valid and used
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function uuidCheckUsage ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->uuidCheckUsage ()- (#echo(__LINE__)#)"); }

		if (($this->uuid_status == "verified")&&(!empty ($this->uuid_data))) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->uuidCheckUsage ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->uuidCheckUsage ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* We are using a cookie to transport the uuID and related data from one
	* request to another.
	*
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function uuidCookieLoad ()
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->uuidCookieLoad ()- (#echo(__LINE__)#)"); }

		$f_return = false;

		if ((isset ($_COOKIE[$direct_settings['uuids_cookie']]))&&(trim ($_COOKIE[$direct_settings['uuids_cookie']])))
		{
			$f_uuid_maxage_inactivity = ($direct_cachedata['core_time'] + $direct_settings['uuids_maxage_inactivity']);
			$uuid_name = "";
			$uuid_timeout = "";
			$uuid_passcode = "";
			$uuid_verification = "";

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($_COOKIE[$direct_settings['uuids_cookie']],"=") === false) { $_COOKIE[$direct_settings['uuids_cookie']] = urldecode ($_COOKIE[$direct_settings['uuids_cookie']]); }
			parse_str ($_COOKIE[$direct_settings['uuids_cookie']]);
			$f_cookie_data = preg_replace ("#&uuid_verification=(.*?)(&|$)#im","",$_COOKIE[$direct_settings['uuids_cookie']]);

			if (($uuid_timeout + $f_uuid_maxage_inactivity > $direct_cachedata['core_time'])&&(trim ($uuid_passcode))&&((md5 ($f_cookie_data)) == $uuid_verification))
			{
				$f_return = true;

				$this->uuid = $uuid_name;
				$this->uuid_cookie_timeout = $uuid_timeout;
				$this->uuid_passcode = $uuid_passcode;
				$this->uuid_status = "unverified";
				$this->uuid_cookie_mode = true;

				$direct_globals['input']->uuidSet ($this->uuid);
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->uuidCookieLoad ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Writing the uuIDs cookie.
	*
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function uuidCookieSave ()
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->uuidCookieSave ()- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (($direct_settings['uuids_setcookie'])&&($this->uuid_status == "verified"))
		{
			$f_cookie_expires = "Sat, 01-Jan-00 01:00:00 GMT";

			if ($this->uuid_cookie_mode)
			{
				if (($this->uuid)&&($this->uuid_data))
				{
					$f_uuid_maxage_inactivity = ($direct_cachedata['core_time'] + $direct_settings['uuids_maxage_inactivity']);

					$this->uuid_cookie = ("uuid_name=".$this->uuid."&uuid_timeout=$f_uuid_maxage_inactivity&uuid_passcode=".$this->uuid_passcode);
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

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->uuidCookieSave ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Checking the uuIDs and loading session data.
	*
	* @param  string $f_type Return type (a = array; s = string)
	* @param  mixed $f_cookie_mode Boolean for (de)activation - empty string to
	*         use system setting
	* @return mixed Array or string on success; False on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function uuidGet ($f_type,$f_cookie_mode = false)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -kernel->uuidGet ($f_type,+f_cookie_mode)- (#echo(__LINE__)#)"); }

		$f_return = false;
		if (isset ($this->uuid_cookie_mode)) { $f_cookie_mode = $this->uuid_cookie_mode; }

		if ((((mt_rand (0,30)) > 20))&&(!$direct_settings['uuids_auto_maintenance']))
		{
			$direct_globals['db']->initDelete ($direct_settings['uuids_table']);

			$f_select_criteria = "<sqlconditions>".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['uuids_table'].".ddbuuids_list_maxage_inactivity",$direct_cachedata['core_time'],"number","<"))."</sqlconditions>";
			$direct_globals['db']->defineRowConditions ($f_select_criteria);

			if ($direct_globals['db']->queryExec ("co")) { $direct_globals['db']->optimizeRandom ($direct_settings['uuids_table']); }
		}

		if (($this->uuid_status != "verified")&&($this->uuid))
		{
			$direct_globals['db']->initSelect ($direct_settings['uuids_table']);
			$direct_globals['db']->defineAttributes ($direct_settings['uuids_table'].".*");

$f_select_criteria = ("<sqlconditions>
".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['uuids_table'].".ddbuuids_list_id",$this->uuid,"string"))."
".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['uuids_table'].".ddbuuids_list_maxage_inactivity",$direct_cachedata['core_time'],"number",">"))."
</sqlconditions>");

			$direct_globals['db']->defineRowConditions ($f_select_criteria);
			$direct_globals['db']->defineLimit (1);

			$f_uuid_array = $direct_globals['db']->queryExec ("sa");
		}

		if (!trim ($this->uuid)) { $this->uuid_status = "invalid"; }
		elseif ($this->uuid_status == "new")
		{
			$this->uuid_status = "verified";
			$this->uuid_cookie_mode = $f_cookie_mode;
			$this->uuid_data = "";
			$this->uuid_insert_mode = true;
			$f_return = "";

			if ($f_cookie_mode)
			{
				mt_srand (/*#ifdef(PHP4):((double)microtime ()) * 1000000:#*/);
				$this->uuid_passcode = $direct_globals['basic_functions']->tmd5 (uniqid (mt_rand ()));
				$this->uuid_passcode_prev = $this->uuid_passcode;
			}
		}
		elseif ($this->uuid_status == "verified")
		{
			if ($f_type == "a") { $f_return = explode ("\n",(trim ($this->uuid_data))); }
			else { $f_return = trim ($this->uuid_data); }
		}
		elseif ($f_uuid_array)
		{
			$f_timeout_check = (((!$this->uuid_cookie_timeout)||(($f_uuid_array['ddbuuids_list_maxage_inactivity'] + $direct_settings['uuids_cookie_interaction_timeout']) >= $this->uuid_cookie_timeout)) ? true : false);
			$f_validation_check = false;

			if (($f_uuid_array['ddbuuids_list_passcode_timeout'])||($this->uuid_passcode))
			{
				if (($f_uuid_array['ddbuuids_list_passcode'])&&($f_uuid_array['ddbuuids_list_passcode'] == $this->uuid_passcode)) { $f_validation_check = true; }
/* -------------------------------------------------------------------------
Parallel requests are supported. For a time of usually 30 seconds we accept
both the old and new passcode.
------------------------------------------------------------------------- */

				if ((!$f_validation_check)&&($direct_cachedata['core_time'] <= ($f_uuid_array['ddbuuids_list_passcode_timeout'] - $direct_settings['uuids_passcode_timeout'] + $direct_settings['uuids_cookie_interaction_timeout']))&&($this->uuid_passcode == $f_uuid_array['ddbuuids_list_passcode_prev'])) { $f_validation_check = true; }
			}
			elseif ($f_uuid_array['ddbuuids_list_ip'] == $direct_settings['user_ip']) { $f_validation_check = true; }

			if (($f_timeout_check)&&($f_validation_check)&&($f_uuid_array['ddbuuids_list_maxage_inactivity'] > $direct_cachedata['core_time']))
			{
				$this->uuid_status = "verified";

				if ($f_uuid_array['ddbuuids_list_passcode_timeout'])
				{
					$this->uuid_cookie_mode = true;

					if (($f_uuid_array['ddbuuids_list_passcode_timeout'] < $direct_cachedata['core_time'])&&(!$direct_settings['swg_cookies_deactivated']))
					{
						mt_srand (/*#ifdef(PHP4):((double)microtime ()) * 1000000:#*/);
						$this->uuid_passcode_prev = $f_uuid_array['ddbuuids_list_passcode'];
						$this->uuid_passcode = $direct_globals['basic_functions']->tmd5 (uniqid (mt_rand ()));

						$this->uuidWrite ($f_uuid_array['ddbuuids_list_data']);
						$this->uuidCookieSave ();
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
			$direct_globals['db']->initDelete ($direct_settings['uuids_table']);

			$f_select_criteria = "<sqlconditions>".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['uuids_table'].".ddbuuids_list_id",$this->uuid,"string"))."</sqlconditions>";
			$direct_globals['db']->defineRowConditions ($f_select_criteria);

			$direct_globals['db']->defineLimit (1);
			if (($direct_globals['db']->queryExec ("co"))&&(!$direct_settings['uuids_auto_maintenance'])) { $direct_globals['db']->vOptimize ($direct_settings['uuids_table']); }

			$this->uuid = md5 (uniqid ($direct_settings['user_ip']."_".(mt_rand ())."_"));
			$this->uuid_status = "verified";
			$this->uuid_cookie_mode = $f_cookie_mode;
			$this->uuid_data = "";
			$this->uuid_insert_mode = true;

			$direct_globals['input']->uuidSet ($this->uuid);
			$f_return = "";

			if ($f_cookie_mode)
			{
				mt_srand (/*#ifdef(PHP4):((double)microtime ()) * 1000000:#*/);
				$this->uuid_passcode = $direct_globals['basic_functions']->tmd5 (uniqid (mt_rand ()));
				$this->uuid_passcode_prev = $this->uuid_passcode;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->uuidGet ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Getting the uuIDs up and running at kernel time.
	*
	* @param  string $f_uuid uuID of the current session
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function uuidInit ($f_uuid = NULL)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->uuidInit ($f_uuid)- (#echo(__LINE__)#)"); }

		if (!isset ($direct_globals['db'])) { $f_return = ((($direct_globals['basic_functions']->includeClass ('dNG\sWG\directDB',1))&&(direct_class_init ("db"))) ? $direct_globals['db']->vConnect () : false); }
		else { $f_return = true; }

		if ($f_return)
		{
/* -------------------------------------------------------------------------
Set the uuID for this session and activate other uuIDs specific functions.
------------------------------------------------------------------------- */

			if (isset ($f_uuid)) { $this->uuid = $f_uuid; }
			else { $this->uuid = $direct_globals['input']->uuidGet (); }

			$this->uuid_cookie_timeout = "";

			if (trim ($this->uuid)) { $this->uuid_status = "unverified"; }
			else
			{
				$this->uuid = md5 (uniqid ($direct_settings['user_ip']."_".(mt_rand ())."_"));
				$direct_globals['input']->uuidSet ($this->uuid);
			}

			$this->uuid_cookie = "";
			$this->uuid_cookie_mode = false;
			$this->uuid_data = "";
			$this->uuid_passcode = "";
			$this->uuid_passcode_prev = "";

			if (!direct_class_function_check ($direct_globals['kernel'],"vUuidCheckUsage"))
			{
				$direct_globals['kernel']->vCallSet ("vUuidCheckUsage",$this,"uuidCheckUsage");
				$direct_globals['kernel']->vCallSet ("vUuidCookieLoad",$this,"uuidCookieLoad");
				$direct_globals['kernel']->vCallSet ("vUuidCookieSave",$this,"uuidCookieSave");
				$direct_globals['kernel']->vCallSet ("vUuidGet",$this,"uuidGet");
				$direct_globals['kernel']->vCallSet ("vUuidIsCookied",$this,"uuidIsCookied");
				$direct_globals['kernel']->vCallSet ("vUuidWrite",$this,"uuidWrite");
				$this->functions['uuidCheckUsage'] = true;
				$this->functions['uuidCookieLoad'] = true;
				$this->functions['uuidCookieSave'] = true;
				$this->functions['uuidGet'] = true;
				$this->functions['uuidIsCookied'] = true;
				$this->functions['uuidWrite'] = true;
			}

			$direct_globals['kernel']->vUuidCookieLoad ();
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->uuidInit ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Returns true if uuID relevant data are saved in a cookie.
	*
	* @return boolean True if a cookie is used
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function uuidIsCookied ()
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->uuidIsCookied ()- (#echo(__LINE__)#)"); }

		if (($direct_settings['uuids_setcookie'])&&($this->uuid_status == "verified")&&($this->uuid_cookie_mode)) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->uuidIsCookied ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->uuidIsCookied ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Writes the uuID data to the database.
	*
	* @param  mixed $f_data uuID data array or string
	* @param  mixed $f_cookie_mode Boolean for (de)activation - empty string to
	*         use system setting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function uuidWrite ($f_data,$f_cookie_mode = NULL)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -kernel->uuidWrite ($f_data,+f_cookie_mode)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (is_bool ($f_cookie_mode)) { $this->uuid_cookie_mode = $f_cookie_mode; }
		else { $f_cookie_mode = $this->uuid_cookie_mode; }

		if ($this->uuid_status != "verified") { $direct_globals['kernel']->vUuidGet ("s",$f_cookie_mode); }
		else
		{
			$f_uuid_data = trim ((is_array ($f_data)) ? implode ("\n",$f_data) : $f_data);

			if ($f_uuid_data)
			{
				if (!$this->uuid)
				{
					$this->uuid = md5 (uniqid ($direct_settings['user_ip']."_".(mt_rand ())."_"));
					$this->uuid_insert_mode = true;
				}

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
					$f_maxage_inactivity = ($direct_cachedata['core_time'] + $direct_settings['uuids_maxage_session_inactivity']);
					if ($this->uuid_passcode) { $this->uuid_passcode = ""; }
				}

				if ($this->uuid_insert_mode) { $direct_globals['db']->initInsert ($direct_settings['uuids_table']); }
				else { $direct_globals['db']->initUpdate ($direct_settings['uuids_table']); }

$f_data_values = ("<sqlvalues>
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['uuids_table'].".ddbuuids_list_id",$this->uuid,"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['uuids_table'].".ddbuuids_list_passcode_timeout",$f_passcode_timeout,"number"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['uuids_table'].".ddbuuids_list_maxage_inactivity",$f_maxage_inactivity,"number"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['uuids_table'].".ddbuuids_list_ip",$direct_settings['user_ip'],"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['uuids_table'].".ddbuuids_list_passcode",$this->uuid_passcode,"string"))."
".($direct_globals['db']->defineSetAttributesEncode ($direct_settings['uuids_table'].".ddbuuids_list_data",$f_uuid_data,"string")));

				if ($this->uuid_passcode_prev) { $f_data_values .= $direct_globals['db']->defineSetAttributesEncode ($direct_settings['uuids_table'].".ddbuuids_list_passcode_prev",$this->uuid_passcode_prev,"string"); }
				$f_data_values .= "</sqlvalues>";

				$direct_globals['db']->defineSetAttributes ($f_data_values);
				if (!$this->uuid_insert_mode) { $direct_globals['db']->defineRowConditions ("<sqlconditions>".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['uuids_table'].".ddbuuids_list_id",$this->uuid,"string"))."</sqlconditions>"); }
				$f_return = $direct_globals['db']->queryExec ("co");

				if ($f_return)
				{
					$this->uuid_status = "verified";
					$this->uuid_data = $f_uuid_data;
					$this->uuid_insert_mode = false;

					if (!$direct_settings['uuids_auto_maintenance']) { $direct_globals['db']->optimizeRandom ($direct_settings['uuids_table']); }
				}
			}
			else
			{
				$direct_globals['db']->initDelete ($direct_settings['uuids_table']);

				$f_select_criteria = "<sqlconditions>".($direct_globals['db']->defineRowConditionsEncode ($direct_settings['uuids_table'].".ddbuuids_list_id",$this->uuid,"string"))."</sqlconditions>";
				$direct_globals['db']->defineRowConditions ($f_select_criteria);

				$direct_globals['db']->defineLimit (1);
				if (($direct_globals['db']->queryExec ("co"))&&(!$direct_settings['uuids_auto_maintenance'])) { $direct_globals['db']->vOptimize ($direct_settings['uuids_table']); }

				$this->uuid_status = "new";
				$this->uuid_data = "";
				$this->uuid_insert_mode = true;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->uuidWrite ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directVUuids",true);

//j// Script specific functions

global $direct_globals,$direct_settings;
$direct_globals['@names']['kernel_uuids'] = 'dNG\sWG\kernel\directVUuids';

if (!isset ($direct_settings['swg_auto_maintenance'])) { $direct_settings['swg_auto_maintenance'] = false; }
if (!isset ($direct_settings['uuids_auto_maintenance'])) { $direct_settings['uuids_auto_maintenance'] = $direct_settings['swg_auto_maintenance']; }
if (!isset ($direct_settings['uuids_cookie'])) { $direct_settings['uuids_cookie'] = "direct_uuids"; }
if (!isset ($direct_settings['uuids_cookie_interaction_timeout'])) { $direct_settings['uuids_cookie_interaction_timeout'] = 30; }
if (!isset ($direct_settings['uuids_maxage_inactivity'])) { $direct_settings['uuids_maxage_inactivity'] = 604800; }
if (!isset ($direct_settings['uuids_maxage_session_inactivity'])) { $direct_settings['uuids_maxage_session_inactivity'] = 900; }
if (!isset ($direct_settings['uuids_passcode_timeout'])) { $direct_settings['uuids_passcode_timeout'] = 300; }
if (!isset ($direct_settings['uuids_path'])) { $direct_settings['uuids_path'] = ""; }
if (!isset ($direct_settings['uuids_server'])) { $direct_settings['uuids_server'] = ""; }
if (!isset ($direct_settings['uuids_setcookie'])) { $direct_settings['uuids_setcookie'] = true; }
if (!isset ($direct_settings['uuids_table'])) { $direct_settings['uuids_table'] = "direct_uuids_list"; }
}

//j// EOF
?>