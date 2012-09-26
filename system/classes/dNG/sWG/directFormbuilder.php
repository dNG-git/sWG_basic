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
* Handling forms manually including checks for the right format of a given
* e-Mail-address is no longer required. Our FormBuilder will create forms and
* check the input automatically.
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
* @subpackage formbuilder
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
/*#ifdef(PHP5n) */

namespace dNG\sWG;
/* #*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

if (!defined ("CLASS_directFormbuilder"))
{
/**
* Handling forms manually including checks for the right format of a given
* e-Mail-address is no longer required. Our FormBuilder will create forms and
* check the input automatically.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage formbuilder
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directFormbuilder extends directVirtualClass
{
/**
	* @var array $check_result Contains the current result of a form check
	*      (each time "formGet ()" is called
*/
	/*#ifndef(PHP4) */public /* #*//*#ifdef(PHP4):var :#*/$check_result;
/**
	* @var array $form_cache Cache for added form elements
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $form_cache;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directFormbuilder)
	*
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->__construct (directFormbuilder)- (#echo(__LINE__)#)"); }

		if (!isset ($direct_globals['@names']['formtags'])) { $direct_globals['basic_functions']->includeClass ('dNG\sWG\directFormtags',2); }
		if (!isset ($direct_globals['formtags'])) { direct_class_init ("formtags"); }
		direct_local_integration ("formbuilder");
		if ($direct_settings['formbuilder_rcp_supported']) { direct_local_integration ("formbuilder_rcp"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions
------------------------------------------------------------------------- */

		$this->functions['entryAdd'] = true;
		$this->functions['entryAddEMail'] = true;
		$this->functions['entryAddEmbed'] = true;
		$this->functions['entryAddFileFtg'] = isset ($direct_globals['formtags']);
		$this->functions['entryAddMultiSelect'] = true;
		$this->functions['entryAddNumber'] = true;
		$this->functions['entryAddPassword'] = true;
		$this->functions['entryAddRadio'] = true;
		$this->functions['entryAddRange'] = true;
		$this->functions['entryAddRcpText'] = true;
		$this->functions['entryAddRcpTextarea'] = true;
		$this->functions['entryAddSelect'] = true;
		$this->functions['entryAddText'] = true;
		$this->functions['entryAddTextarea'] = true;
		$this->functions['entryDefaultsSet'] = true;
		$this->functions['entryErrorSet'] = true;
		$this->functions['entryFieldSizeSet'] = true;
		$this->functions['entryLengthCheck'] = true;
		$this->functions['entryLimitsSet'] = true;
		$this->functions['entryRangeCheck'] = true;
		$this->functions['entrySet'] = true;
		$this->functions['entryUpdate'] = true;
		$this->functions['formCheck'] = true;
		$this->functions['formGet'] = true;
		$this->functions['xmlForm'] = true;
		$this->functions['xmlEntrySet'] = true;

/* -------------------------------------------------------------------------
Set up some variables
------------------------------------------------------------------------- */

		$this->check_result = false;
		$this->form_cache = array ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directFormbuilder
	*
	* @since v0.1.00
*\/
	function directFormbuilder () { $this->__construct (); }
:#*/
/**
	* Creates spacing fields like "hidden", "element", "info", "spacer" or "subtitle".
	*
	* @param  string $f_type Form field type
	* @param  array $f_entry Form field data
	* @return boolean True if no error occured
	* @link   http://www.direct-netware.de/redirect.php?swg;handbooks;dev;formbuilder
	*         Click here to get a list of available form fields
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAdd ($f_type,$f_entry = array ())
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAdd ($f_type,+f_entry)- (#echo(__LINE__)#)"); }

		if (($f_type == "hidden")||($f_type == "element")||($f_type == "info")||($f_type == "spacer")||($f_type == "subtitle")||(is_callable ($f_type)))
		{
			$f_return = true;
			$f_entry = $this->entryDefaultsSet ($f_entry,NULL,NULL,NULL);
			$this->entrySet ((($f_type == "subtitle") ? "subTitle" : $f_type),$f_entry);
		}
		else { $f_return = false; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAdd ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* A single line text input field for eMail addresses.
	*
	* @param  array $f_entry Form field data
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddEMail ($f_entry)
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddEMail (+f_entry)- (#echo(__LINE__)#)"); }

		$f_entry = $this->entryDefaultsSet ($f_entry,"","",NULL);
		$f_entry = $this->entryFieldSizeSet ($f_entry);
		$f_entry = $this->entryLimitsSet ($f_entry);

		$f_entry['error'] = $this->entryLengthCheck ($f_entry['content'],$f_entry['min'],$f_entry['max'],$f_entry['required']);
		if ((strlen ($f_entry['content']))&&(!strlen ($direct_globals['basic_functions']->inputfilterEMail ($f_entry['content'])))) { $f_entry['error'] = "format_invalid"; }

		$this->entrySet ("eMail",$f_entry);

		if ($f_entry['error']) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddEMail ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddEMail ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Embeds external resources into the current form.
	*
	* @param  array $f_entry Form field data
	* @param  string $f_url URL for the embedded resource
	* @param  boolean $f_iframe_only True if we should not try AJAX to embed the
	*         given URL
	* @return boolean Currently always true
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddEmbed ($f_entry,$f_url,$f_iframe_only = false)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddEmbed (+f_entry,$f_url,+f_iframe_only)- (#echo(__LINE__)#)"); }

		$f_entry = $this->entryDefaultsSet ($f_entry,"","",NULL);
		$f_entry = $this->entryFieldSizeSet ($f_entry);

		if (!strlen ($direct_cachedata["i_".$f_entry['name']]))
		{
			$f_entry['content'] = uniqid ("");
			$direct_cachedata["i_".$f_entry['name']] = $f_entry['content'];
		}

		$f_entry['iframe_only'] = ($f_iframe_only ? true : false);
		$f_entry['url'] = $f_url."tid+".$f_entry['content'];

		$this->entrySet ("embed",$f_entry);
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddEmbed ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Adds a preformatted text from an external file.
	*
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  boolean $f_file_path Path to the FTG file
	* @param  string $f_field_size Size of the form field ("s", "m" or "l")
	* @return boolean Currently always true
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddFileFtg ($f_entry,$f_file_path)
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddFileFtg (+f_entry,$f_file_path)- (#echo(__LINE__)#)"); }

		$f_file_path = $direct_globals['basic_functions']->varfilter ($f_file_path,"settings");
		$f_return = false;

		if (file_exists ($f_file_path))
		{
			$f_file_data = direct_file_get ("s",$f_file_path);
			$f_file_data = $direct_globals['formtags']->decode (str_replace ("\n","[newline]",$f_file_data));

			$f_return = true;
		}
		else { $f_file_data = (direct_local_get ("formbuilder_error_file_not_found_1")).(direct_html_encode_special ($f_file_path)).(direct_local_get ("formbuilder_error_file_not_found_2")); }

		$f_entry = $this->entryDefaultsSet ($f_entry,"","",$f_file_data);
		$f_entry = $this->entryFieldSizeSet ($f_entry,"s");

		$this->entrySet ("fileFtg",$f_entry);
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddFileFtg ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Inserts a selectbox for multiple selectable options.
	*
	* @param  array $f_entry Form field data
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddMultiSelect ($f_entry)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddMultiSelect (+f_entry)- (#echo(__LINE__)#)"); }

		$f_entry = $this->entryDefaultsSet ($f_entry,"","",NULL);
		$f_entry = $this->entryFieldSizeSet ($f_entry,"s");

		$f_choices_array = direct_evars_get ($f_entry['content']);
		$f_entry['content'] = array ();
		$f_selected_array = array ();

		if (is_array ($f_choices_array))
		{
			foreach ($f_choices_array as $f_choice_array)
			{
				$f_choice_array['choice_id'] = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
				$direct_cachedata['formbuilder_element_counter']++;

				$f_choice_array['value'] = direct_html_encode_special ($f_choice_array['value']);
				$f_choice_array['text'] = str_replace ('"',"&quot;",$f_choice_array['text']);
				if (!strlen ($f_choice_array['text'])) { $f_choice_array['text'] = $f_choice_array['value']; }
				if (isset ($f_choice_array['selected'])) { $f_selected_array[] = $f_choice_array['value']; }

				$f_entry['content'][] = $f_choice_array;
			}
		}

		$direct_cachedata["i_".$f_entry['name']] = $f_selected_array;
		$f_entry['error'] = ((($f_entry['required'])&&(empty ($f_selected_array))) ? "required_element" : "");

		$this->entrySet ("multiSelect",$f_entry);

		if ($f_entry['error']) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddMultiSelect ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddMultiSelect ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Number (integer) input mechanism
	*
	* @param  array $f_entry Form field data
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddNumber ($f_entry)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddNumber (+f_entry)- (#echo(__LINE__)#)"); }

		$f_return = true;

		$f_entry = $this->entryDefaultsSet ($f_entry,"","",NULL);
		$f_entry = $this->entryFieldSizeSet ($f_entry);
		$f_entry = $this->entryLimitsSet ($f_entry);

		$f_entry['content'] = str_replace (" ","",$f_entry['content']);
		$f_entry['error'] = $this->entryRangeCheck ($f_entry['content'],$f_entry['min'],$f_entry['max'],$f_entry['required']);

		if ($f_entry['error']) { $f_return = false; }
		else { $direct_cachedata["i_".$f_entry['name']] = $f_entry['content']; }

		$this->entrySet ("number",$f_entry);
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddNumber ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Insert passwords (including optional a repetition check)
	*
	* @param  array $f_entry Form field data
	* @param  string $f_mode Password and encryption mode
	* @param  string $f_bytemix Bytemix to use for TMD5 (NULL for none)
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddPassword ($f_entry,$f_mode = "",$f_bytemix = "")
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddPassword (+f_entry,$f_mode,+f_bytemix)- (#echo(__LINE__)#)"); }

		$f_return = true;

		$f_entry = $this->entryDefaultsSet ($f_entry,"","",NULL);
		$f_entry = $this->entryFieldSizeSet ($f_entry);
		$f_entry = $this->entryLimitsSet ($f_entry);

		$f_entry['error'] = $this->entryLengthCheck ($f_entry['content'],$f_entry['min'],$f_entry['max'],$f_entry['required']);

		if ($f_bytemix === NULL) { $f_bytemix = ""; }
		elseif (!strlen ($f_bytemix)) { $f_bytemix = $direct_settings['account_password_bytemix']; }

		if (($f_mode != "2")&&(strpos ($f_mode,"2_") === false)) { $f_type = "password"; }
		else
		{
			$f_repetition_entry = "i_".$f_entry['name']."_repetition";

			if (isset ($direct_cachedata[$f_repetition_entry])) { $f_repetition_content = $direct_cachedata[$f_repetition_entry]; }
			elseif (isset ($GLOBALS[$f_repetition_entry])) { $f_repetition_content = $GLOBALS[$f_repetition_entry]; }
			else { $f_repetition_content = ""; }

			if ($f_entry['content'] != $f_repetition_content) { $f_entry['error'] = "password_repetition"; }
			$f_type = "password2";
		}

		if ($f_entry['error']) { $f_return = false; }
		elseif (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_mode,"tmd5") !== false) { $direct_cachedata["i_".$f_entry['name']] = $direct_globals['basic_functions']->tmd5 ($direct_cachedata["i_".$f_entry['name']],$f_bytemix); }
		elseif (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_mode,"md5") !== false) { $direct_cachedata["i_".$f_entry['name']] = md5 ($direct_cachedata["i_".$f_entry['name']]); }

		$this->entrySet ($f_type,$f_entry);
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddPassword ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Inserts radio fields for exact one selected option.
	*
	* @param  array $f_entry Form field data
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddRadio ($f_entry)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddRadio (+f_entry)- (#echo(__LINE__)#)"); }

		$f_entry = $this->entryDefaultsSet ($f_entry,"","",NULL);

		$f_choices_array = direct_evars_get ($f_entry['content']);
		$f_entry['content'] = array ();
		$f_selected_value = "";

		if (is_array ($f_choices_array))
		{
			foreach ($f_choices_array as $f_choice_array)
			{
				$f_choice_array['choice_id'] = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
				$direct_cachedata['formbuilder_element_counter']++;

				$f_choice_array['value'] = direct_html_encode_special ($f_choice_array['value']);
				$f_choice_array['text'] = str_replace ('"',"&quot;",$f_choice_array['text']);
				if (!strlen ($f_choice_array['text'])) { $f_choice_array['text'] = $f_choice_array['value']; }
				if (isset ($f_choice_array['selected'])) { $f_selected_value = $f_choice_array['value']; }

				$f_entry['content'][] = $f_choice_array;
			}
		}

		$direct_cachedata["i_".$f_entry['name']] = $f_selected_value;
		$f_entry['error'] = ((($f_entry['required'])&&(!strlen ($f_selected_value))) ? "required_element" : "");

		$this->entrySet ("radio",$f_entry);

		if ($f_entry['error']) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddRadio ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddRadio ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Inserts a range input.
	*
	* @param  array $f_entry Form field data
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddRange ($f_entry)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddRange (+f_entry)- (#echo(__LINE__)#)"); }

		$f_entry = $this->entryDefaultsSet ($f_entry,"","",NULL);
		$f_entry = $this->entryFieldSizeSet ($f_entry,"s");
		$f_entry = $this->entryLimitsSet ($f_entry,0,100);

		$f_entry['error'] = $this->entryRangeCheck ($f_entry['content'],$f_entry['min'],$f_entry['max'],$f_entry['required']);

		if ($f_entry['error']) { $f_return = false; }
		else { $direct_cachedata["i_".$f_entry['name']] = $f_entry['content']; }

		$f_entry['content'] = direct_html_encode_special ($f_entry['content']);

		$this->entrySet ("range",$f_entry);

		if ($f_entry['error']) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddRadio ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddRadio ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* A rcp enhanced text input field.
	*
	* @param  array $f_entry Form field data
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddRcpText ($f_entry)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddRcpText (+f_entry)- (#echo(__LINE__)#)"); }

		if ($direct_settings['formbuilder_rcp_supported'])
		{
			$f_return = true;

			$f_entry = $this->entryDefaultsSet ($f_entry,"","",NULL);
			$f_entry = $this->entryFieldSizeSet ($f_entry);
			$f_entry = $this->entryLimitsSet ($f_entry);

			$f_entry['content'] = str_replace (array ("\n","&lt;","&gt;","<br />"),(array ("[newline]","<",">","[newline]")),$f_entry['content']);
			$f_entry['error'] = $this->entryLengthCheck ($f_entry['content'],$f_entry['min'],$f_entry['max'],$f_entry['required']);

			if ($f_entry['error']) { $f_return = false; }
			else { $direct_cachedata["i_".$f_entry['name']] = $f_entry['content']; }

			$f_entry['content'] = direct_html_encode_special ($f_entry['content']);

			$this->entrySet ("rcpText",$f_entry);
		}
		else { $f_return = $this->entryAddText ($f_entry); }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddRcpText ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* A rcp enhanced textarea input field.
	*
	* @param  array $f_entry Form field data
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddRcpTextarea ($f_entry)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddRcpTextarea (+f_entry)- (#echo(__LINE__)#)"); }

		if ($direct_settings['formbuilder_rcp_supported'])
		{
			$f_return = true;

			$f_entry = $this->entryDefaultsSet ($f_entry,"","",NULL);
			$f_entry = $this->entryFieldSizeSet ($f_entry);
			$f_entry = $this->entryLimitsSet ($f_entry);

			$f_entry['content'] = str_replace (array ("[newline]","&lt;","&gt;","<br />"),(array ("\n","<",">","\n")),$f_entry['content']);
			$f_entry['error'] = $this->entryLengthCheck ($f_entry['content'],$f_entry['min'],$f_entry['max'],$f_entry['required']);

			if ($f_entry['error']) { $f_return = false; }
			else { $direct_cachedata["i_".$f_entry['name']] = $f_entry['content']; }

			$f_entry['content'] = direct_html_encode_special ($f_entry['content']);

			$this->entrySet ("rcpTextarea",$f_entry);
		}
		else { $f_return = $this->entryAddTextarea ($f_entry); }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddRcpTextarea ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Inserts a selectbox for exact one selected option.
	*
	* @param  array $f_entry Form field data
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddSelect ($f_entry)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddSelect (+f_entry)- (#echo(__LINE__)#)"); }

		$f_entry = $this->entryDefaultsSet ($f_entry,"","",NULL);
		$f_entry = $this->entryFieldSizeSet ($f_entry,"s");

		$f_choices_array = direct_evars_get ($f_entry['content']);
		$f_entry['content'] = array ();
		$f_selected_value = "";

		if (is_array ($f_choices_array))
		{
			foreach ($f_choices_array as $f_choice_array)
			{
				$f_choice_array['value'] = direct_html_encode_special ($f_choice_array['value']);
				$f_choice_array['text'] = str_replace ('"',"&quot;",$f_choice_array['text']);
				if (!strlen ($f_choice_array['text'])) { $f_choice_array['text'] = $f_choice_array['value']; }
				if (isset ($f_choice_array['selected'])) { $f_selected_value = $f_choice_array['value']; }

				$f_entry['content'][] = $f_choice_array;
			}
		}

		$direct_cachedata["i_".$f_entry['name']] = $f_selected_value;
		$f_entry['error'] = ((($f_entry['required'])&&(!strlen ($f_selected_value))) ? "required_element" : "");

		$this->entrySet ("select",$f_entry);

		if ($f_entry['error']) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddRadio ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddRadio ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* A single line text input field.
	*
	* @param  array $f_entry Form field data
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddText ($f_entry)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddText (+f_entry)- (#echo(__LINE__)#)"); }

		$f_return = true;

		$f_entry = $this->entryDefaultsSet ($f_entry,"","",NULL);
		$f_entry = $this->entryFieldSizeSet ($f_entry);
		$f_entry = $this->entryLimitsSet ($f_entry);

		$f_entry['content'] = str_replace (array ("\n","&lt;","&gt;","<br />"),(array ("[newline]","<",">","[newline]")),$f_entry['content']);
		$f_entry['error'] = $this->entryLengthCheck ($f_entry['content'],$f_entry['min'],$f_entry['max'],$f_entry['required']);

		if ($f_entry['error']) { $f_return = false; }
		else { $direct_cachedata["i_".$f_entry['name']] = $f_entry['content']; }

		$f_entry['content'] = direct_html_encode_special ($f_entry['content']);

		$this->entrySet ("text",$f_entry);
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddText ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* A standard textarea input field.
	*
	* @param  array $f_entry Form field data
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddTextarea ($f_entry)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddTextarea (+f_entry)- (#echo(__LINE__)#)"); }

		$f_return = true;

		$f_entry = $this->entryDefaultsSet ($f_entry,"","",NULL);
		$f_entry = $this->entryFieldSizeSet ($f_entry);
		$f_entry = $this->entryLimitsSet ($f_entry);

		$f_entry['content'] = str_replace (array ("[newline]","&lt;","&gt;","<br />"),(array ("\n","<",">","\n")),$f_entry['content']);
		$f_entry['error'] = $this->entryLengthCheck ($f_entry['content'],$f_entry['min'],$f_entry['max'],$f_entry['required']);

		if ($f_entry['error']) { $f_return = false; }
		else { $direct_cachedata["i_".$f_entry['name']] = $f_entry['content']; }

		$f_entry['content'] = direct_html_encode_special ($f_entry['content']);

		$this->entrySet ("textarea",$f_entry);
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryAddTextarea ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Creates spacing fields like "hidden", "element", "info", "spacer" or "subtitle".
	*
	* @param  string $f_type Form field type
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  mixed $f_content Form field related content data
	* @param  boolean $f_required True if the field is required to continue
	* @return mixed Array on success; NULL on error
	* @link   http://www.direct-netware.de/redirect.php?swg;handbooks;dev;formbuilder
	*         Click here to get a list of available form fields
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryDefaultsSet ($f_data,$f_name = "",$f_title = NULL,$f_content = "",$f_required = false)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryDefaultsSet (+f_data,$f_name,$f_title,+f_content,+f_required)- (#echo(__LINE__)#)"); }

		if (is_array ($f_data))
		{
			$f_return = $f_data;

			if (!isset ($f_return['section'])) { $f_return['section'] = ""; }
			if (!isset ($f_return['name'])) { $f_return['name'] = $f_name; }
			if (!isset ($f_return['title'])) { $f_return['title'] = $f_title; }

			if (($f_content == NULL)&&($f_return['name'] != NULL)&&(isset ($direct_cachedata["i_".$f_return['name']]))) { $f_return['content'] = $direct_cachedata["i_".$f_return['name']]; }
			elseif (!isset ($f_return['content'])) { $f_return['content'] = $f_content; }

			if (!isset ($f_return['required'])) { $f_return['required'] = $f_required; }
			if (!isset ($f_return['error'])) { $f_return['error'] = ""; }
			if (!isset ($f_return['helper_text'])) { $f_return['helper_text'] = ""; }
			if (!isset ($f_return['helper_url'])) { $f_return['helper_url'] = ""; }
			if (!isset ($f_return['helper_closing'])) { $f_return['helper_closing'] = true; }
		}
		else { $f_return = NULL; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryDefaultsSet ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Set an external error message for the given form field.
	*
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @return boolean False if the field is not defined
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryErrorSet ($f_name,$f_error,$f_section = "",$f_cache = NULL)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryErrorSet ($f_name,$f_error,+f_section,+f_cache)- (#echo(__LINE__)#)"); }

		$f_form_id = md5 ("i_".$f_name);
		$f_return = true;

		if (isset ($this->form_cache[$f_section]/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$this->form_cache[$f_section][$f_form_id])) { $this->form_cache[$f_section][$f_form_id]['error'] = $f_error; }
		else { $f_return = false; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryErrorSet ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Creates spacing fields like "hidden", "element", "info", "spacer" or "subtitle".
	*
	* @param  string $f_type Form field type
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  mixed $f_content Form field related content data
	* @param  boolean $f_required True if the field is required to continue
	* @return mixed Array on success; NULL on error
	* @link   http://www.direct-netware.de/redirect.php?swg;handbooks;dev;formbuilder
	*         Click here to get a list of available form fields
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryFieldSizeSet ($f_data,$f_size = "m")
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryFieldSizeSet (+f_data,$f_size)- (#echo(__LINE__)#)"); }

		if (is_array ($f_data))
		{
			$f_return = $f_data;
			if (!isset ($f_return['size'])) { $f_return['size'] = $f_size; }
		}
		else { $f_return = NULL; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryFieldSizeSet ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Checks the size for a given string.
	*
	* @param  string $f_data The string that should be checked
	* @param  integer $f_min Defines the minimal length for a string or 0 to
	*         ignore
	* @param  integer $f_max Defines the maximal length for a string or 0 for an
	*         unlimited size
	* @param  boolean $f_required True if the field is required to continue
	* @return boolean False if a required field is empty, it is smaller than
	*         the minimum or larger than the maximum
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryLengthCheck ($f_data,$f_min = 0,$f_max = 0,$f_required = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryLengthCheck (+f_data,$f_min,$f_max)- (#echo(__LINE__)#)"); }

		if (($f_required)&&(!$f_data)) { $f_return = "required_element"; }
		elseif (($f_data)&&($f_min)&&($f_min > (strlen ($f_data)))) { $f_return = "string_min|".$f_min; }
		elseif (($f_max)&&($f_max < (strlen ($f_data)))) { $f_return = "string_max|".$f_max; }
		else { $f_return = ""; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryLengthCheck ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Creates spacing fields like "hidden", "element", "info", "spacer" or "subtitle".
	*
	* @param  string $f_type Form field type
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  mixed $f_content Form field related content data
	* @param  boolean $f_required True if the field is required to continue
	* @return mixed Array on success; NULL on error
	* @link   http://www.direct-netware.de/redirect.php?swg;handbooks;dev;formbuilder
	*         Click here to get a list of available form fields
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryLimitsSet ($f_data,$f_min = 0,$f_max = 0)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryLimitsSet ($f_data,$f_min,$f_max)- (#echo(__LINE__)#)"); }

		if (is_array ($f_data))
		{
			$f_return = $f_data;
			if (!isset ($f_return['min'])) { $f_return['min'] = $f_min; }
			if (!isset ($f_return['max'])) { $f_return['max'] = $f_max; }
		}
		else { $f_return = NULL; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryLimitsSet ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Checks the size for a given string.
	*
	* @param  string $f_data The string that should be checked
	* @param  integer $f_min Defines the minimal range for a number or NULL to
	*         ignore
	* @param  integer $f_max Defines the maximal range for a number or NULL for an
	*         unlimited size
	* @param  boolean $f_required True if the field is required to continue
	* @return boolean False if a required field is empty, it is smaller than
	*         the minimum or larger than the maximum
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryRangeCheck ($f_data,$f_min = NULL,$f_max = NULL,$f_required = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryRangeCheck (+f_data,$f_min,$f_max)- (#echo(__LINE__)#)"); }
		$f_return = "";

		if (strlen ($f_data))
		{
			if (preg_match ("#^(-|)(\d+)$#i",$f_data))
			{
				if (($f_min != NULL)&&($f_min > $f_data)) { $f_return = "number_min|".$f_min; }
				elseif (($f_max != NULL)&&($f_max < $f_data)) { $f_return = "number_max|".$f_max; }
			}
			else { $f_return = "format_invalid"; }
		}
		elseif ($f_required) { $f_return = "required_element"; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->entryRangeCheck ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Creates spacing fields like "hidden", "element", "info", "spacer" or "subtitle".
	*
	* @param string $f_filter Form field output parser
	* @param array $f_entry Form field data
	* @link  http://www.direct-netware.de/redirect.php?swg;handbooks;dev;formbuilder
	*        Click here to get a list of available form fields
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function entrySet ($f_filter,$f_entry)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entrySet (+f_filter,+f_entry)- (#echo(__LINE__)#)"); }

		$f_entry['filter'] = $f_filter;

		if (strlen ($f_entry['name'])) { $f_name = $f_entry['name']; }
		else { $f_name = NULL; }

		if ($f_name == NULL) { $this->form_cache[$f_entry['section']][] = $f_entry; }
		else
		{
			$f_form_id = md5 ("i_".$f_name);
			$this->form_cache[$f_entry['section']][$f_form_id] = $f_entry;
		}
	}

/**
	* Updates existing field entries.
	*
	* @param string $f_filter Form field output parser
	* @param array $f_entry Form field data
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryUpdate ($f_section,$f_id,$f_entry)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->entryUpdate ($f_section,$f_id,+f_entry)- (#echo(__LINE__)#)"); }
		if ((is_array ($f_entry))&&(isset ($this->form_cache[$f_section]/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$this->form_cache[$f_section][$f_id]))) { $this->form_cache[$f_section][$f_id] = array_merge ($this->form_cache[$f_section][$f_id],$f_entry); }
	}

/**
	* Parses all previously defined form fields and checks them.
	*
	* @return boolean True if all checks are passed
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function formCheck ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->formCheck ()- (#echo(__LINE__)#)"); }
		$f_return = false;

		if (!empty ($this->form_cache))
		{
			$f_return = true;

			foreach ($this->form_cache as $f_section_array)
			{
				foreach ($f_section_array as $f_element_array)
				{
					if ($f_element_array['error'])
					{
						$f_return = false;
						break 2;
					}
				}
			}
		}

		return $f_return;
	}

/**
	* Parses all previously defined form fields, checks them and returns an array
	* ready for output.
	*
	* @param  boolean $f_check True if all fields should be checked (result will
	*         be stored in $this->check_result).
	* @return array Array of form fields ready for output
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function formGet ($f_check = false)
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->formGet (+f_check)- (#echo(__LINE__)#)"); }

		$f_return = array ();

		if (empty ($this->form_cache))
		{
			if ($f_check) { $this->check_result = false; }
		}
		elseif ((isset ($direct_globals['@names']['output_formbuilder']))||(($direct_globals['basic_functions']->includeClass ('dNG\sWG\directOFormbuilder',2))&&(isset ($direct_globals['@names']['output_formbuilder']))))
		{
			$f_section_count = count ($this->form_cache);
			if (isset ($this->form_cache[''])) { $f_return[''] = array (); }
			$this->check_result = true;

			foreach ($this->form_cache as $f_section => $f_section_array)
			{
				if ($f_section_count < 2) { $f_section = ""; }
				if (!isset ($f_return[$f_section])) { $f_return[$f_section] = array (); }

				foreach ($f_section_array as $f_form_id => $f_element_array)
				{
					if (($f_check)&&($f_element_array['error']))
					{
						$f_error_array = explode ("|",$f_element_array['error']);
						$this->check_result = false;

						switch ($f_error_array[0])
						{
						case "required_element":
						{
							$f_element_array['error'] = direct_local_get ("formbuilder_error_required_element");
							break 1;
						}
						case "format_invalid":
						{
							$f_element_array['error'] = direct_local_get ("formbuilder_error_format_invalid");
							break 1;
						}
						case "number_max":
						{
							$f_element_array['error'] = (direct_local_get ("formbuilder_error_number_max_1")).$f_error_array[1].(direct_local_get ("formbuilder_error_number_max_2"));
							break 1;
						}
						case "string_max":
						{
							$f_element_array['error'] = (direct_local_get ("formbuilder_error_string_max_1")).$f_error_array[1].(direct_local_get ("formbuilder_error_string_max_2"));
							break 1;
						}
						case "number_min":
						{
							$f_element_array['error'] = (direct_local_get ("formbuilder_error_number_min_1")).$f_error_array[1].(direct_local_get ("formbuilder_error_number_min_2"));
							break 1;
						}
						case "string_min":
						{
							$f_element_array['error'] = (direct_local_get ("formbuilder_error_string_min_1")).$f_error_array[1].(direct_local_get ("formbuilder_error_string_min_2"));
							break 1;
						}
						case "password_repetition":
						{
							$f_element_array['error'] = direct_local_get ("formbuilder_error_password_repetition");
							break 1;
						}
						default: { $f_element_array['error'] = direct_local_get ($f_element_array['error']); }
						}
					}
					else { $f_element_array['error'] = ""; }

					$f_return[$f_section][$f_form_id] = $f_element_array;
				}
			}

			$this->form_cache = array ();
		}

		return $f_return;
	}

/**
	* Checks a XML form entry definition and calls the corresponding method.
	*
	* @param  array &$f_xml_node_array XML form entry
	* @param  array &$f_xml_sub_node_array Array containing possible translation
	*         entries
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function xmlEntrySet ($f_entry,$f_xml_sub_node_array)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->xmlEntrySet (+f_entry,+f_xml_sub_node_array)- (#echo(__LINE__)#)"); }

		$f_formbuilder_function = "";
		$f_formbuilder_function_type = "";
		$f_formbuilder_function_type_selectable = false;
		$f_return = true;

		switch ($f_entry['filter'])
		{
		case "element":
		{
			if (isset ($f_entry['name']))
			{
				$f_value = direct_local_get_xml_translation ($f_xml_sub_node_array,"data",true,$direct_settings['lang']);

				if (strlen ($f_value))
				{
					$direct_cachedata["i_".$f_entry['name']] = $f_value;
					$f_formbuilder_function = "entryAdd";
					$f_formbuilder_function_type = "element";
				}
			}

			break 1;
		}
		case "hidden":
		{
			if (isset ($f_entry['name']))
			{
				$f_value = direct_local_get_xml_translation ($f_xml_sub_node_array,"content",true,$direct_settings['lang']);

				if (strlen ($f_value))
				{
					$direct_cachedata["i_".$f_entry['name']] = $f_value;
					$f_formbuilder_function = "entryAdd";
					$f_formbuilder_function_type = "hidden";
				}
			}

			break 1;
		}
		case "info":
		{
			if (isset ($f_entry['name']))
			{
				$f_value = direct_local_get_xml_translation ($f_xml_sub_node_array,"content",true,$direct_settings['lang']);

				if (strlen ($f_value))
				{
					$direct_cachedata["i_".$f_entry['name']] = $f_value;
					$f_formbuilder_function = "entryAdd";
					$f_formbuilder_function_type = "info";
				}
			}

			break 1;
		}
		case "file_ftg":
		{
			if (isset ($f_entry['name']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_entry['file'])) { $f_formbuilder_function = "entryAddFileFtg"; }
			break 1;
		}
		case "multiselect":
		{
			$f_formbuilder_function = "entryAddMultiSelect";
			$f_formbuilder_function_type_selectable = true;
			break 1;
		}
		case "password":
		{
			if (isset ($f_entry['name']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_entry['mode']))
			{
				if (!isset ($f_entry['bytemix'])) { $f_entry['bytemix'] = NULL; }
				$f_formbuilder_function = "entryAddPassword";
			}

			break 1;
		}
		case "radio":
		{
			$f_formbuilder_function = "entryAddRadio";
			$f_formbuilder_function_type_selectable = true;
			break 1;
		}
		case "select":
		{
			$f_formbuilder_function = "entryAddSelect";
			$f_formbuilder_function_type_selectable = true;
			break 1;
		}
		case "spacer":
		{
			$f_formbuilder_function = "entryAdd";
			$f_formbuilder_function_type = "spacer";

			break 1;
		}
		case "subtitle":
		{
			if ((isset ($f_entry['name']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_entry['title']))&&(strlen ($f_entry['title'])))
			{
				$f_formbuilder_function = "entryAdd";
				$f_formbuilder_function_type = "subtitle";
			}

			break 1;
		}
		default:
		{
			$f_filter = ucfirst ($f_entry['filter']);
			if ($this->vCallCheck ("entryAdd".$f_filter)) { $f_formbuilder_function = "entryAdd".$f_filter; }
		}
		}

		if (($f_formbuilder_function)&&(isset ($f_entry['name'])))
		{
			if ($f_formbuilder_function_type_selectable)
			{
				$direct_cachedata["i_".$f_entry['name']] = (isset ($direct_cachedata["i_".$f_entry['name']]) ? str_replace ("'","",$direct_cachedata["i_".$f_entry['name']]) : direct_local_get_xml_translation ($f_xml_sub_node_array,"predefined",true,$direct_settings['lang']));
				if (isset ($direct_cachedata["i_".$f_entry['name']])) { $direct_cachedata["i_".$f_entry['name']] = str_replace ((array ("<selected value='1' />","<value value='".$direct_cachedata["i_".$f_entry['name']]."' />")),(array ("","<value value='".$direct_cachedata["i_".$f_entry['name']]."' /><selected value='1' />")),$direct_cachedata["i_".$f_entry['name']]); }
			}
			elseif (!isset ($direct_cachedata["i_".$f_entry['name']])) { $direct_cachedata["i_".$f_entry['name']] = direct_local_get_xml_translation ($f_xml_sub_node_array,"predefined",true,$direct_settings['lang']); }

			switch ($f_formbuilder_function)
			{
			case "entryAdd":
			{
				$this->entryAdd ($f_formbuilder_function_type,$f_entry);
				break 1;
			}
			case "entryAddFileFtg":
			{
				$this->entryAddFileFtg ($f_entry,$f_entry['file']);
				break 1;
			}
			case "entryAddPassword":
			{
				$this->entryAddPassword ($f_entry,$f_entry['mode'],$f_entry['bytemix']);
				break 1;
			}
			default: { $this->{$f_formbuilder_function} ($f_entry); }
			}
		}
		else { $f_return = false; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->xmlEntrySet ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Parses a XML form definition.
	*
	* @param  mixed &$f_xml XML form definition string or preparsed XML array
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function xmlForm ($f_xml)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder->xmlForm (+f_xml)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (is_string ($f_xml)) { $f_xml = $direct_globals['xml_bridge']->xml2array ($f_xml,true,false); }
		elseif (!is_array ($f_xml)) { $f_xml = NULL; }

		if ((is_array ($f_xml))&&(isset ($f_xml['fields']['xml.item'])))
		{
			$f_return = true;

			if (isset ($f_xml['fields']['field']['xml.mtree']))
			{
				$f_xml = $f_xml['fields']['field'];
				unset ($f_xml['xml.mtree']);
			}
			else
			{
				$f_xml = $f_xml['fields'];
				unset ($f_xml['xml.item']);
			}
		}

		if (is_array ($f_xml))
		{
			foreach ($f_xml as $f_xml_node_array)
			{
				if ($f_return)
				{
					if (isset ($f_xml_node_array['xml.item']))
					{
						$f_xml_sub_node_array = $f_xml_node_array;
						$f_xml_node_array = $f_xml_node_array['xml.item'];
					}
					else { $f_xml_sub_node_array = array (); }

					if (isset ($f_xml_node_array['attributes']['filter']))
					{
						$f_entry = $f_xml_node_array['attributes'];

						if (isset ($f_entry['value_translation'])) { $f_entry['title'] = direct_local_get_xml_translation ($f_xml_sub_node_array,"title",true,$direct_settings['lang']); }
						elseif (isset ($f_xml_sub_node_array['title']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_xml_sub_node_array['title']['value'])) { $f_entry['title'] = $f_xml_sub_node_array['title']['value']; }
						elseif (isset ($f_xml_node_array['value'])) { $f_entry['title'] = $f_xml_node_array['value']; }

						if (isset ($f_entry['helper_translation'])) { $f_entry['helper_text'] = direct_local_get_xml_translation ($f_xml_sub_node_array,"helper_text",true,$direct_settings['lang']); }
						elseif (isset ($f_entry['helper_text'])) { $f_entry['helper_text'] = direct_local_get ($f_entry['helper_text']); }
						else { $f_entry['helper_text'] = ""; }

						$f_entry['helper_closing'] = (((!isset ($f_entry['helper_closing']))||($f_entry['helper_closing'])) ? true : false);

						$f_return = (isset ($f_entry['filter']) ? $this->xmlEntrySet ($f_entry,$f_xml_sub_node_array) : false);
					}
					else { $f_return = false; }
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder->xmlForm ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directFormbuilder",true);

//j// Script specific commands

global $direct_cachedata,$direct_globals,$direct_settings;
$direct_globals['@names']['formbuilder'] = 'dNG\sWG\directFormbuilder';

if (!isset ($direct_cachedata['formbuilder_element_counter'])) { $direct_cachedata['formbuilder_element_counter'] = 0; }
if (!isset ($direct_settings['account_password_bytemix'])) { $direct_settings['account_password_bytemix'] = ($direct_settings['swg_id'] ^ (strrev ($direct_settings['swg_id']))); }
if (!isset ($direct_settings['formbuilder_rcp_supported'])) { $direct_settings['formbuilder_rcp_supported'] = false; }
}

//j// EOF
?>