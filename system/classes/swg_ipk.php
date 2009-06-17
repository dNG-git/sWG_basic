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
$Id: swg_ipk.php,v 1.7 2008/12/20 11:23:19 s4u Exp $
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

$g_continue_check = true;
if (defined ("CLASS_direct_ipk")) { $g_continue_check = false; }
if (!defined ("CLASS_direct_file_functions")) { $g_continue_check = false; }

if ($g_continue_check)
{
//c// direct_ipk
/**
* This abstraction layer is a wrapper for iPK v1.10 and v2.0.0.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage ipk
* @uses       CLASS_direct_virtual_class
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;lgpl
*             GNU Lesser General Public License 2.1
*/
class direct_ipk extends direct_virtual_class
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

	//f// direct_ipk->__construct () and direct_ipk->direct_ipk ()
/**
	* Constructor (PHP5) __construct (direct_ipk)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -ipk_handler->__construct (direct_ipk)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['close'] = true;
		$this->functions['config_read'] = true;
		$this->functions['config_write'] = true;
		$this->functions['entry_delete'] = true;
		$this->functions['entry_exists'] = true;
		$this->functions['entry_read'] = true;
		$this->functions['entry_rename'] = true;
		$this->functions['entry_write'] = true;
		$this->functions['fileindex_read'] = true;
		$this->functions['fileindex_write'] = true;
		$this->functions['lock'] = true;
		$this->functions['open'] = true;
		$this->functions['tmd5_compare'] = true;

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
	* Constructor (PHP4) direct_ipk (direct_ipk)
	*
	* @since v0.1.00
*\/
	function direct_ipk () { $this->__construct (); }
:#\n*/
	//f// direct_ipk->__destruct ()
/**
	* Destructor (PHP5) __destruct (direct_ipk)
	*
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __destruct () { $this->close (); }

	//f// direct_ipk->close ($f_delete_empty = true)
/**
	* Closes an active iPK session.
	*
	* @param  boolean $f_delete_empty If the file handle is valid, the file is
	*         empty and this parameter is true then the file will be deleted.
	* @uses   direct_file_functions::close()
	* @uses   direct_ipk_*::close()
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function close ($f_delete_empty = true)
	{
		if (is_object ($this->data)) { return $this->data->close ($f_delete_empty); }
		elseif (is_object ($this->resource)) { return $this->resource->close ($f_delete_empty); }
		else { return false; }
	}

	//f// direct_ipk->config_read ()
/**
	* Load the iPK config from the iPK file session.
	*
	* @uses   direct_ipk_*::config_read()
	* @return mixed config on success, false on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function config_read ()
	{
		if (is_object ($this->data)) { return $this->data->config_read (); }
		else { return false; }
	}

	//f// direct_ipk->config_write ($f_data = "")
/**
	* Write the iPK config to the iPK file session.
	*
	* @param  string $f_data Config string
	* @uses   direct_ipk_*::config_write()
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function config_write ($f_data = "")
	{
		if ((!$this->readonly)&&(is_object ($this->data))) { return $this->data->config_write ($f_data); }
		else { return false; }
	}

	//f// direct_ipk->entry_delete ($f_file_path,$f_update = false)
/**
	* Delete an iPK entry in the iPK file session.
	*
	* @param  string $f_file_path Relative file path in the archive
	* @param  boolean $f_update Sync the archive configuration after this change
	* @uses   direct_ipk_*::entry_delete()
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_delete ($f_file_path,$f_update = false)
	{
		if ((!$this->readonly)&&(is_object ($this->data))) { return $this->data->entry_delete ($f_file_path,$f_update); }
		else { return false; }
	}

	//f// direct_ipk->entry_exists ($f_file_path)
/**
	* Checks if an iPK entry exists.
	*
	* @param  string $f_file_path Relative file path in the archive
	* @uses   direct_ipk_*::entry_exists()
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_exists ($f_file_path)
	{
		if (is_object ($this->data)) { return $this->data->entry_exists ($f_file_path); }
		else { return false; }
	}

	//f// direct_ipk->entry_read ($f_file_path)
/**
	* Load an iPK entry from the iPK file session.
	*
	* @param  string $f_file_path Relative file path in the archive
	* @uses   direct_ipk_*::entry_read()
	* @return mixed File content on success, false if CRC32 mismatches or other
	*         errors occured.
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_read ($f_file_path)
	{
		if (is_object ($this->data)) { return $this->data->entry_read ($f_file_path); }
		else { return false; }
	}

	//f// direct_ipk->entry_rename ($f_file_path_old,$f_file_path_new,$f_update = false)
/**
	* Rename an iPK entry in the iPK file session.
	*
	* @param  string $f_file_path_old Relative old file path in the archive
	* @param  string $f_file_path_new Relative new file path in the archive
	* @param  boolean $f_update Sync the archive configuration after this change
	* @uses   direct_ipk_*::entry_rename()
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_rename ($f_file_path_old,$f_file_path_new,$f_update = false)
	{
		if ((!$this->readonly)&&(is_object ($this->data))) { return $this->data->entry_rename ($f_file_path_old,$f_file_path_new,$f_update); }
		else { return false; }
	}

	//f// direct_ipk->entry_write ($f_file_path,$f_data,$f_update = false,$f_compress = false,$f_comment = "")
/**
	* Write an iPK entry to the iPK file session.
	*
	* @param  string $f_file_path Relative file path in the archive
	* @param  string $f_data Binary data string
	* @param  boolean $f_update Sync the archive configuration after this change
	* @param  boolean $f_compress Compress the data
	* @param  string $f_comment iPK file entry comment
	* @uses   direct_ipk_*::entry_write()
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_write ($f_file_path,$f_data,$f_update = false,$f_compress = false,$f_comment = "")
	{
		if ((!$this->readonly)&&(is_object ($this->data))) { return $this->data->entry_write ($f_file_path,$f_data,$f_update,$f_compress,$f_comment); }
		else { return false; }
	}

	//f// direct_ipk->fileindex_read ($f_file_path = "")
/**
	* Load the iPK fileindex from the iPK file session.
	*
	* @param  string $f_file_path Relative file path in the archive
	* @uses   direct_ipk_*::fileindex_read()
	* @return mixed File index on success, false on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function fileindex_read ($f_file_path = "")
	{
		if (is_object ($this->data)) { return $this->data->fileindex_read ($f_file_path); }
		else { return false; }
	}

	//f// direct_ipk->fileindex_write ()
/**
	* Write the iPK fileindex to the iPK file session.
	*
	* @uses   direct_ipk_*::fileindex_write()
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function fileindex_write ()
	{
		if ((!$this->readonly)&&(is_object ($this->data))) { return $this->data->fileindex_write (); }
		else { return false; }
	}

	//f// direct_ipk->lock ($f_mode)
/**
	* Changes iPK file locking if needed.
	*
	* @param  string $f_mode The requested file locking mode ("r" or "w").
	* @uses   direct_debug()
	* @uses   direct_ipk_*::lock()
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function lock ($f_mode)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -ipk_handler->lock ($f_mode)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (is_object ($this->resource)) { $f_return = $this->resource->lock ($f_mode); }
		else { trigger_error ("sWG/#echo(__FILEPATH__)# -ipk_handler->lock ()- (#echo(__LINE__)#) reporting: iPK resource invalid",E_USER_WARNING); }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -ipk_handler->lock ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_ipk->open ($f_file_path,$f_readonly = false)
/**
	* Opens an iPK session.
	*
	* @param  string $f_file_path File path to the archive
	* @param  boolean $f_readonly True to block all write attempts
	* @uses   direct_file_functions::close()
	* @uses   direct_file_functions::open()
	* @uses   direct_file_functions::Read()
	* @uses   direct_ipk_*::open()
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function open ($f_file_path,$f_readonly = false)
	{
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -ipk_handler->open ($f_file_path,+f_readonly)- (#echo(__LINE__)#)"); }

		if (is_object ($this->data)) { $f_return = false; }
		else
		{
			if ($f_readonly) { $this->readonly = true; }
			$f_return = true;

			if (file_exists ($f_file_path))
			{
 				if (($this->readonly)||(!is_writable ($f_file_path))) { $f_file_mode = "rb"; }
				else { $f_file_mode = "r+b"; }

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
				$f_file = new direct_file_functions ();
				$f_file->open ($f_file_path,$this->readonly,$f_file_mode);
			}
			else { trigger_error ("sWG/#echo(__FILEPATH__)# -ipk_handler->open ()- (#echo(__LINE__)#) reporting: Failed opening $f_file_path - file does not exist",E_USER_NOTICE); }

			if ($f_file->resource_check ()) { $this->resource =& $f_file; }
			else
			{
				$f_file->close ($f_created_check);
				$this->resource = "";
			}

			$f_return = false;

			if (is_object ($this->resource))
			{
				if ($this->filesize > 2) { $f_file_id = $this->resource->read (3); }
				else { $f_file_id = ""; }

				if ($f_file_id == "iPS")
				{
					$f_version = $this->resource->read (4);
					$f_result_array = unpack ("Vversion",$f_version);

					if ($f_result_array['version'] == 200000)
					{
						if (!defined ("CLASS_direct_ipk_v200000")) { $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/ext_ipk/ipk_v2.0.0.php"); }

						if (defined ("CLASS_direct_ipk_v200000"))
						{
							$this->data = new direct_ipk_v200000 ($direct_settings['swg_umask_change'],$direct_settings['swg_chmod_files_change'],$direct_cachedata['core_time'],$direct_settings['timeout'],"",USE_debug_reporting);
							$this->data->set_resource ($this->resource);
							$f_return = $this->data->open ($f_file_path,$f_readonly);
						}
					}
				}
				elseif ($f_file_id == "iPK")
				{
					if (!defined ("CLASS_direct_ipk_v1")) { $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/ext_ipk/ipk_v1.php"); }

					if (defined ("CLASS_direct_ipk_v1"))
					{
						$this->readonly = true;
						$this->data = new direct_ipk_v1 ($direct_settings['swg_umask_change'],$direct_settings['swg_chmod_files_change'],$direct_cachedata['core_time'],$direct_settings['timeout'],"",USE_debug_reporting);
						$this->data->set_resource ($this->resource);
						$f_return = $this->data->open ($f_file_path);
					}
				}
				elseif ($f_created_check)
				{
					if (!defined ("CLASS_direct_ipk_v200000")) { $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/ext_ipk/ipk_v2.0.0.php"); }

					if (defined ("CLASS_direct_ipk_v200000"))
					{
						$this->data = new direct_ipk_v200000 ($direct_settings['swg_umask_change'],$direct_settings['swg_chmod_files_change'],$direct_cachedata['core_time'],$direct_settings['timeout'],$direct_settings['path_system']."/classes/ext_ipk",USE_debug_reporting);
						$this->data->set_resource ($this->resource);
						$f_return = $this->data->open ($f_file_path);
					}
				}
			}

			if (($f_return)&&(is_object ($this->resource))) { $this->resource_file_path = $f_file_path; }
			else
			{
				$this->resource->close ($f_created_check);
				$this->resource = "";
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -ipk_handler->open ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_ipk->tmd5_compare ($f_tmd5)
/**
	* Compares the recalculated triple MD5 with the given one.
	*
	* @param  string $f_tmd5 TMD5 for comparison
	* @uses   direct_ipk_*::tmd5_compare()
	* @return boolean True if the triple MD5s are identical 
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function tmd5_compare ($f_tmd5)
	{
		if (is_object ($this->data)) { return $this->data->tmd5_compare ($f_tmd5); }
		else { return false; }
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_direct_ipk",true);

//j// Script specific commands

if (!isset ($direct_settings['swg_ipk_compression'])) { $direct_settings['swg_ipk_compression'] = 7; }
}

//j// EOF
?>