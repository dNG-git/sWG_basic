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
internet PacKage Standard
Version: v1.10 / Version: v2.0.0
----------------------------------------------------------------------------
This file contains functions and or supports the internet PacKage Standard.
The named file format was developed by the direct Netware Group and is
licensed under the GNU Lesser General Public License 2.1 (GNU LGPL 2.1).
----------------------------------------------------------------------------
(C) direct Netware Group - All rights reserved
http://www.direct-netware.de/redirect.php?ipk

This library is free software; you can redistribute it and/or modify it
under the terms of the GNU Lesser General Public License as published by the
Free Software Foundation; either version 2.1 of the License, or (at your
option) any later version.

This library is distributed in the hope that it will be useful, but WITHOUT
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License
for more details.

You should have received a copy of the GNU Lesser General Public License
along with this library; if not, write to the Free Software Foundation, Inc.
59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
----------------------------------------------------------------------------
http://www.direct-netware.de/redirect.php?licenses;lgpl
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* OOP (Object Oriented Programming) requires an abstract data handling. The
* sWG is OO (where it makes sense).
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
* @subpackage ipk
* @link       http://www.direct-netware.de/redirect.php?ipk;handbooks
*             Click here for more information about iPK files
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
/*#ifdef(PHP5n) */

namespace dNG\sWG;
/* #*/
/*#use(direct_use) */
use dNG\directIPKv1,
    dNG\directIPKv2,
    dNG\sWG\directFileFunctions;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

if (!defined ("CLASS_directIPK"))
{
/**
* This abstraction layer is a wrapper for iPK v1.10 and v2.0.0.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage ipk
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;lgpl
*             GNU Lesser General Public License 2.1
*/
class directIPK extends directVirtualClass
{
/**
	* @var resource $data "data" contains the object to handle the file format
	*      version.
*/
	/*#ifndef(PHP4) */private/* #*//*#ifdef(PHP4):var:#*/ $data;
/**
	* @var integer $filesize Current file size of the resource
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $filesize;
/**
	* @var boolean $readonly True for an readonly resource
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $readonly;
/**
	* @var resource $resource The iPK file object
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $resource;
/**
	* @var string $resource_file_path Filename for the resource pointer
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $resource_file_path;
/**
	* @var boolean $up_to_date True if all changes are already written to the
	*      file.
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $up_to_date;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directIPK)
	*
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -iPK->__construct (directIPK)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['close'] = true;
		$this->functions['configRead'] = true;
		$this->functions['configWrite'] = true;
		$this->functions['entryDelete'] = true;
		$this->functions['entryExists'] = true;
		$this->functions['entryRead'] = true;
		$this->functions['entryRename'] = true;
		$this->functions['entryWrite'] = true;
		$this->functions['fileindexRead'] = true;
		$this->functions['fileindexWrite'] = true;
		$this->functions['lock'] = true;
		$this->functions['open'] = true;
		$this->functions['tmd5Compare'] = true;

/* -------------------------------------------------------------------------
Set default iPK data
------------------------------------------------------------------------- */

		$this->data = "";
		$this->filesize = 0;
		$this->readonly = false;
		$this->resource = "";
		$this->resource_file_path = "";
		$this->up_to_date = true;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directIPK
	*
	* @since v0.1.00
*\/
	function directIPK () { $this->__construct (); }
:#\n*/
/**
	* Destructor (PHP5) __destruct (directIPK)
	*
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __destruct () { $this->close (); }

/**
	* Closes an active iPK session.
	*
	* @param  boolean $f_delete_empty If the file handle is valid, the file is
	*         empty and this parameter is true then the file will be deleted.
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function close ($f_delete_empty = true)
	{
		if (is_object ($this->data)) { return $this->data->close ($f_delete_empty); }
		elseif (is_object ($this->resource)) { return $this->resource->close ($f_delete_empty); }
		else { return false; }
	}

/**
	* Load the iPK config from the iPK file session.
	*
	* @return mixed config on success, false on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function configRead () { return ((is_object ($this->data)) ? $this->data->configRead () : false); }

/**
	* Write the iPK config to the iPK file session.
	*
	* @param  string $f_data Config string
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function configWrite ($f_data = "") { return (((!$this->readonly)&&(is_object ($this->data))) ? $this->data->configWrite ($f_data) : false); }

/**
	* Delete an iPK entry in the iPK file session.
	*
	* @param  string $f_file_path Relative file path in the archive
	* @param  boolean $f_update Sync the archive configuration after this change
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryDelete ($f_file_path,$f_update = false) { return (((!$this->readonly)&&(is_object ($this->data))) ? $this->data->entryDelete ($f_file_path,$f_update) : false); }

/**
	* Checks if an iPK entry exists.
	*
	* @param  string $f_file_path Relative file path in the archive
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryExists ($f_file_path) { return ((is_object ($this->data)) ? $this->data->entryExists ($f_file_path) : false); }

/**
	* Load an iPK entry from the iPK file session.
	*
	* @param  string $f_file_path Relative file path in the archive
	* @return mixed File content on success, false if CRC32 mismatches or other
	*         errors occured.
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryRead ($f_file_path) { return ((is_object ($this->data)) ? $this->data->entryRead ($f_file_path) : false); }

/**
	* Rename an iPK entry in the iPK file session.
	*
	* @param  string $f_file_path_old Relative old file path in the archive
	* @param  string $f_file_path_new Relative new file path in the archive
	* @param  boolean $f_update Sync the archive configuration after this change
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryRename ($f_file_path_old,$f_file_path_new,$f_update = false) { return (((!$this->readonly)&&(is_object ($this->data))) ? $this->data->entryRename ($f_file_path_old,$f_file_path_new,$f_update) : false); }

/**
	* Write an iPK entry to the iPK file session.
	*
	* @param  string $f_file_path Relative file path in the archive
	* @param  string $f_data Binary data string
	* @param  boolean $f_update Sync the archive configuration after this change
	* @param  boolean $f_compress Compress the data
	* @param  string $f_comment iPK file entry comment
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryWrite ($f_file_path,$f_data,$f_update = false,$f_compress = false,$f_comment = "") { return (((!$this->readonly)&&(is_object ($this->data))) ? $this->data->entryWrite ($f_file_path,$f_data,$f_update,$f_compress,$f_comment) : false); }

/**
	* Load the iPK fileindex from the iPK file session.
	*
	* @param  string $f_file_path Relative file path in the archive
	* @return mixed File index on success, false on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function fileindexRead ($f_file_path = "") { return ((is_object ($this->data)) ? $this->data->fileindexRead ($f_file_path) : false); }

/**
	* Write the iPK fileindex to the iPK file session.
	*
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function fileindexWrite () { return (((!$this->readonly)&&(is_object ($this->data))) ? $this->data->fileindexWrite () : false); }

/**
	* Changes iPK file locking if needed.
	*
	* @param  string $f_mode The requested file locking mode ("r" or "w").
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function lock ($f_mode)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -iPK->lock ($f_mode)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (is_object ($this->resource)) { $f_return = $this->resource->lock ($f_mode); }
		else { trigger_error ("sWG/#echo(__FILEPATH__)# -iPK->lock ()- (#echo(__LINE__)#) reporting: iPK resource invalid",E_USER_WARNING); }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -iPK->lock ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Opens an iPK session.
	*
	* @param  string $f_file_path File path to the archive
	* @param  boolean $f_readonly True to block all write attempts
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function open ($f_file_path,$f_readonly = false)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -iPK->open ($f_file_path,+f_readonly)- (#echo(__LINE__)#)"); }

		if (is_object ($this->data)) { $f_return = false; }
		else
		{
			if ($f_readonly) { $this->readonly = true; }
			$f_return = true;

			if (file_exists ($f_file_path))
			{
				$f_file_mode = ((($this->readonly)||(!is_writable ($f_file_path))) ? "rb" : "r+b");
				$f_created_check = false; 
				$this->filesize = @filesize ($f_file_path);
			}
			elseif (!$this->readonly)
			{
				$f_created_check = true;
				$f_file_mode = "w+b";
				$this->filesize = 0;
			}
			else { $f_return = false; }

			if ($f_return)
			{
				$f_file = new directFileFunctions ();
				$f_file->open ($f_file_path,$this->readonly,$f_file_mode);
			}
			else { trigger_error ("sWG/#echo(__FILEPATH__)# -iPK->open ()- (#echo(__LINE__)#) reporting: Failed opening $f_file_path - file does not exist",E_USER_NOTICE); }

			if ($f_file->resourceCheck ()) { $this->resource =& $f_file; }
			else
			{
				$f_file->close ($f_created_check);
				$this->resource = "";
			}

			$f_return = false;

			if (is_object ($this->resource))
			{
				$f_file_id = (($this->filesize > 2) ? $this->resource->read (3) : "");

				if ($f_file_id == "iPS")
				{
					$f_version = $this->resource->read (4);
					$f_result_array = unpack ("Vversion",$f_version);

					if ($f_result_array['version'] == 200000)
					{
						$this->data = new directIPKv2 ($direct_settings['swg_umask_change'],$direct_settings['swg_chmod_files_change'],$direct_cachedata['core_time'],$direct_settings['timeout'],"",USE_debug_reporting);
						$this->data->setResource ($this->resource);
						$f_return = $this->data->open ($f_file_path,$f_readonly);
					}
				}
				elseif ($f_file_id == "iPK")
				{
					$this->readonly = true;
					$this->data = new directIPKv1 ($direct_settings['swg_umask_change'],$direct_settings['swg_chmod_files_change'],$direct_cachedata['core_time'],$direct_settings['timeout'],"",USE_debug_reporting);
					$this->data->setResource ($this->resource);
					$f_return = $this->data->open ($f_file_path);
				}
				elseif ($f_created_check)
				{
					$this->data = new directIPKv2 ($direct_settings['swg_umask_change'],$direct_settings['swg_chmod_files_change'],$direct_cachedata['core_time'],$direct_settings['timeout'],$direct_settings['path_system']."/classes/ext_ipk",USE_debug_reporting);
					$this->data->setResource ($this->resource);
					$f_return = $this->data->open ($f_file_path);
				}
			}

			if (($f_return)&&(is_object ($this->resource))) { $this->resource_file_path = $f_file_path; }
			else
			{
				$this->resource->close ($f_created_check);
				$this->resource = "";
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -iPK->open ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Compares the recalculated triple MD5 with the given one.
	*
	* @param  string $f_tmd5 TMD5 for comparison
	* @return boolean True if the triple MD5s are identical 
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function tmd5Compare ($f_tmd5) { return ((is_object ($this->data)) ? $this->data->tmd5Compare ($f_tmd5) : false); }
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directIPK",true);

//j// Script specific commands

global $direct_settings;
if (!isset ($direct_settings['swg_ipk_compression'])) { $direct_settings['swg_ipk_compression'] = 7; }
}

//j// EOF
?>