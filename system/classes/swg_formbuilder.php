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
* Handling forms manually including checks for the right format of a given
* e-Mail-address is no longer required. Our FormBuilder will create forms and
* check the input automatically.
*
* @internal   We are usixng phpDocumentor to automate the documentation process
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

$g_continue_check = ((defined ("CLASS_direct_formbuilder")) ? false : true);
if (!defined ("CLASS_direct_virtual_class")) { $g_continue_check = false; }

if ($g_continue_check)
{
//c// direct_formbuilder
/**
* Handling forms manually including checks for the right format of a given
* e-Mail-address is no longer required. Our FormBuilder will create forms and
* check the input automatically.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage formbuilder
* @uses       CLASS_direct_virtual_class
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_formbuilder extends direct_virtual_class
{
/**
	* @var array $check_result Contains the current result of a form check
	*      (each time "form_get ()" is called
*/
	/*#ifndef(PHP4) */public /* #*//*#ifdef(PHP4):var :#*/$check_result;
/**
	* @var array $form_cache Cache for added form elements
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $form_cache;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_formbuilder->__construct () and direct_formbuilder->direct_formbuilder ()
/**
	* Constructor (PHP5) __construct (direct_formbuilder)
	*
	* @uses  direct_basic_functions::require_file()
	* @uses  direct_class_init()
	* @uses  direct_debug()
	* @uses  direct_local_integration()
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->__construct (direct_formbuilder)- (#echo(__LINE__)#)"); }

		if (!defined ("CLASS_direct_formtags")) { $direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_formtags.php",2); }
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

		$this->functions['entry_add'] = true;
		$this->functions['entry_add_email'] = true;
		$this->functions['entry_add_embed'] = true;
		$this->functions['entry_add_file_ftg'] = isset ($direct_globals['formtags']);
		$this->functions['entry_add_multiselect'] = true;
		$this->functions['entry_add_number'] = true;
		$this->functions['entry_add_password'] = true;
		$this->functions['entry_add_radio'] = true;
		$this->functions['entry_add_range'] = true;
		$this->functions['entry_add_rcp_text'] = true;
		$this->functions['entry_add_rcp_textarea'] = true;
		$this->functions['entry_add_select'] = true;
		$this->functions['entry_add_text'] = true;
		$this->functions['entry_add_textarea'] = true;
		$this->functions['entry_defaults_set'] = true;
		$this->functions['entry_error_set'] = true;
		$this->functions['entry_field_size_set'] = true;
		$this->functions['entry_length_check'] = true;
		$this->functions['entry_limits_set'] = true;
		$this->functions['entry_range_check'] = true;
		$this->functions['form_get'] = true;
		$this->functions['xml_form'] = true;
		$this->functions['xml_form_entry'] = true;

/* -------------------------------------------------------------------------
Set up some variables
------------------------------------------------------------------------- */

		$this->check_result = false;
		$this->form_cache = array ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_formbuilder (direct_formbuilder)
	*
	* @since v0.1.00
*\/
	function direct_formbuilder () { $this->__construct (); }
:#*/
	//f// direct_formbuilder->entry_add ($f_type,$f_entry = array ())
/**
	* Creates spacing fields like "hidden", "element", "info", "spacer" or "subtitle".
	*
	* @param  string $f_type Form field type
	* @param  array $f_entry Form field data
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True if no error occured
	* @link   http://www.direct-netware.de/redirect.php?swg;handbooks;dev;formbuilder
	*         Click here to get a list of available form fields
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add ($f_type,$f_entry = array ())
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add ($f_type,+f_entry)- (#echo(__LINE__)#)"); }

		if (($f_type == "hidden")||($f_type == "element")||($f_type == "info")||($f_type == "spacer")||($f_type == "subtitle")||(is_callable ($f_type)))
		{
			$f_return = true;
			$f_entry = $this->entry_defaults_set ($f_entry,NULL,NULL,NULL);
			$this->entry_set ($f_type,$f_entry);
		}
		else { $f_return = false; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_add_email ($f_entry)
/**
	* A single line text input field for eMail addresses.
	*
	* @param  array $f_entry Form field data
	* @uses   direct_basic_functions::inputfilter_email()
	* @uses   direct_debug()
	* @uses   direct_html_encode_special()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_email ($f_entry)
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_email (+f_entry)- (#echo(__LINE__)#)"); }

		$f_entry = $this->entry_defaults_set ($f_entry,"","",NULL);
		$f_entry = $this->entry_field_size_set ($f_entry);
		$f_entry = $this->entry_limits_set ($f_entry);

		$f_entry['error'] = $this->entry_length_check ($f_entry['content'],$f_entry['min'],$f_entry['max'],$f_entry['required']);
		if ((strlen ($f_entry['content']))&&(!strlen ($direct_globals['basic_functions']->inputfilter_email ($f_entry['content'])))) { $f_entry['error'] = "format_invalid"; }

		$this->entry_set ("text",$f_entry);

		if ($f_entry['error']) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_email ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_email ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_formbuilder->entry_add_embed ($f_entry,$f_url,$f_iframe_only = false)
/**
	* Embeds external resources into the current form.
	*
	* @param  array $f_entry Form field data
	* @param  string $f_url URL for the embedded resource
	* @param  boolean $f_iframe_only True if we should not try AJAX to embed the
	*         given URL
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean Currently always true
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_embed ($f_entry,$f_url,$f_iframe_only = false)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_embed (+f_entry,$f_url,+f_iframe_only)- (#echo(__LINE__)#)"); }

		$f_entry = $this->entry_defaults_set ($f_entry,"","",NULL);
		$f_entry = $this->entry_field_size_set ($f_entry);

		if (!strlen ($direct_cachedata["i_".$f_entry['name']]))
		{
			$f_entry['content'] = uniqid ("");
			$direct_cachedata["i_".$f_entry['name']] = $f_entry['content'];
		}

		$f_entry['iframe_only'] = ($f_iframe_only ? true : false);
		$f_entry['url'] = $f_url."tid+".$f_entry['content'];

		$this->entry_set ("embed",$f_entry);
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_embed ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_add_file_ftg ($f_entry,$f_file_path)
/**
	* Adds a preformatted text from an external file.
	*
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  boolean $f_file_path Path to the FTG file
	* @param  string $f_field_size Size of the form field ("s", "m" or "l")
	* @uses   direct_debug()
	* @uses   direct_formtags::decode()
	* @uses   direct_file_get()
	* @uses   direct_html_encode_special()
	* @uses   direct_local_get()
	* @uses   USE_debug_reporting
	* @return boolean Currently always true
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_file_ftg ($f_entry,$f_file_path)
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_file_ftg (+f_entry,$f_file_path)- (#echo(__LINE__)#)"); }

		$f_file_path = $direct_globals['basic_functions']->varfilter ($f_file_path,"settings");
		$f_return = false;

		if (file_exists ($f_file_path))
		{
			$f_file_data = direct_file_get ("s",$f_file_path);
			$f_file_data = $direct_globals['formtags']->decode (str_replace ("\n","[newline]",$f_file_data));

			$f_return = true;
		}
		else { $f_file_data = (direct_local_get ("formbuilder_error_file_not_found_1")).(direct_html_encode_special ($f_file_path)).(direct_local_get ("formbuilder_error_file_not_found_2")); }

		$f_entry = $this->entry_defaults_set ($f_entry,"","",$f_file_data);
		$f_entry = $this->entry_field_size_set ($f_entry,"s");

		$this->entry_set ("file_ftg",$f_entry);
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_file_ftg ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_add_multiselect ($f_entry)
/**
	* Inserts a selectbox for multiple selectable options.
	*
	* @param  array $f_entry Form field data
	* @uses   direct_debug()
	* @uses   direct_html_encode_special()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_multiselect ($f_entry)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_multiselect (+f_entry)- (#echo(__LINE__)#)"); }

		$f_entry = $this->entry_defaults_set ($f_entry,"","",NULL);
		$f_entry = $this->entry_field_size_set ($f_entry,"s");

		$f_choices_array = direct_evars_get ($f_entry['content']);
		$f_entry['content'] = "";
		$f_selected_array = array ();

		if (is_array ($f_choices_array))
		{
			foreach ($f_choices_array as $f_choice_array)
			{
				if ($f_entry['content']) { $f_entry['content'] .= "\n"; }

				$f_choice_array['value'] = direct_html_encode_special ($f_choice_array['value']);
				$f_choice_array['text'] = str_replace ('"',"&quot;",$f_choice_array['text']);
				if (!strlen ($f_choice_array['text'])) { $f_choice_array['text'] = $f_choice_array['value']; }

				if (isset ($f_choice_array['selected']))
				{
					$f_entry['content'] .= "<option value=\"{$f_choice_array['value']}\" selected='selected'>{$f_choice_array['text']}</option>";
					$f_selected_array[] = $f_choice_array['value'];
				}
				else { $f_entry['content'] .= "<option value=\"{$f_choice_array['value']}\">{$f_choice_array['text']}</option>"; }
			}
		}

		$direct_cachedata["i_".$f_entry['name']] = $f_selected_array;
		$f_entry['error'] = ((($f_entry['required'])&&(empty ($f_selected_array))) ? "required_element" : "");

		$this->entry_set ("multiselect",$f_entry);

		if ($f_entry['error']) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_multiselect ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_multiselect ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_formbuilder->entry_add_number ($f_entry)
/**
	* Number (integer) input mechanism
	*
	* @param  array $f_entry Form field data
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_number ($f_entry)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_number (+f_entry)- (#echo(__LINE__)#)"); }

		$f_return = true;

		$f_entry = $this->entry_defaults_set ($f_entry,"","",NULL);
		$f_entry = $this->entry_field_size_set ($f_entry);
		$f_entry = $this->entry_limits_set ($f_entry);

		$f_entry['content'] = str_replace (" ","",$f_entry['content']);
		$f_entry['error'] = $this->entry_range_check ($f_entry['content'],$f_entry['min'],$f_entry['max'],$f_entry['required']);

		if ($f_entry['error']) { $f_return = false; }
		else { $direct_cachedata["i_".$f_entry['name']] = $f_entry['content']; }

		$this->entry_set ("text",$f_entry);
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_number ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_add_password ($f_entry,$f_mode = "",$f_bytemix = "")
/**
	* Insert passwords (including optional a repetition check)
	*
	* @param  array $f_entry Form field data
	* @param  string $f_mode Password and encryption mode
	* @param  string $f_bytemix Bytemix to use for TMD5 (NULL for none)
	* @uses   direct_basic_functions::tmd5()
	* @uses   direct_debug()
	* @uses   direct_formbuilder::entry_length_check()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_password ($f_entry,$f_mode = "",$f_bytemix = "")
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_password (+f_entry,$f_mode,+f_bytemix)- (#echo(__LINE__)#)"); }

		$f_return = true;

		$f_entry = $this->entry_defaults_set ($f_entry,"","",NULL);
		$f_entry = $this->entry_field_size_set ($f_entry);
		$f_entry = $this->entry_limits_set ($f_entry);

		$f_entry['error'] = $this->entry_length_check ($f_entry['content'],$f_entry['min'],$f_entry['max'],$f_entry['required']);

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
			$f_type = "password_2";
		}

		if ($f_entry['error']) { $f_return = false; }
		elseif (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_mode,"tmd5") !== false) { $direct_cachedata["i_".$f_entry['name']] = $direct_globals['basic_functions']->tmd5 ($direct_cachedata["i_".$f_entry['name']],$f_bytemix); }
		elseif (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_mode,"md5") !== false) { $direct_cachedata["i_".$f_entry['name']] = md5 ($direct_cachedata["i_".$f_entry['name']]); }

		$this->entry_set ($f_type,$f_entry);
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_password ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_add_radio ($f_entry)
/**
	* Inserts radio fields for exact one selected option.
	*
	* @param  array $f_entry Form field data
	* @uses   direct_debug()
	* @uses   direct_evars_get()
	* @uses   direct_html_encode_special()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_radio ($f_entry)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_radio (+f_entry)- (#echo(__LINE__)#)"); }

		$f_entry = $this->entry_defaults_set ($f_entry,"","",NULL);

		$f_choices_array = direct_evars_get ($f_entry['content']);
		$f_entry['content'] = "";
		$f_input_required = ($f_entry['required'] ? " required='required'" : "");
		$f_selected_value = "";

		if (is_array ($f_choices_array))
		{
			foreach ($f_choices_array as $f_choice_array)
			{
				if ($f_entry['content']) { $f_entry['content'] .= "<br />\n"; }
				$f_label_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
				$direct_cachedata['formbuilder_element_counter']++;

				$f_choice_array['value'] = direct_html_encode_special ($f_choice_array['value']);
				$f_choice_array['text'] = str_replace ('"',"&quot;",$f_choice_array['text']);
				if (!strlen ($f_choice_array['text'])) { $f_choice_array['text'] = $f_choice_array['value']; }

				if (isset ($f_choice_array['selected']))
				{
					$f_entry['content'] .= "<input type='radio' name='{$f_entry['name']}' id='$f_label_id' value=\"{$f_choice_array['value']}\"$f_input_required checked='checked' /><label for='$f_label_id'> {$f_choice_array['text']}</label>";
					$f_selected_value = $f_choice_array['value'];
				}
				else { $f_entry['content'] .= "<input type='radio' name='{$f_entry['name']}' id='$f_label_id' value=\"{$f_choice_array['value']}\"$f_input_required /><label for='$f_label_id'> {$f_choice_array['text']}</label>"; }

$f_entry['content'] .= ("<script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'$f_label_id' } });
]]></script>");
			}
		}

		$direct_cachedata["i_".$f_entry['name']] = $f_selected_value;
		$f_entry['error'] = ((($f_entry['required'])&&(!strlen ($f_selected_value))) ? "required_element" : "");

		$this->entry_set ("radio",$f_entry);

		if ($f_entry['error']) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_radio ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_radio ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_formbuilder->entry_add_range ($f_entry)
/**
	* Inserts a range input.
	*
	* @param  array $f_entry Form field data
	* @uses   direct_debug()
	* @uses   direct_evars_get()
	* @uses   direct_html_encode_special()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_range ($f_entry)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_range (+f_entry)- (#echo(__LINE__)#)"); }

		$f_entry = $this->entry_defaults_set ($f_entry,"","",NULL);
		$f_entry = $this->entry_field_size_set ($f_entry,"s");
		$f_entry = $this->entry_limits_set ($f_entry,0,100);

		$f_entry['error'] = $this->entry_range_check ($f_entry['content'],$f_entry['min'],$f_entry['max'],$f_entry['required']);

		if ($f_entry['error']) { $f_return = false; }
		else { $direct_cachedata["i_".$f_entry['name']] = $f_entry['content']; }

		$f_entry['content'] = direct_html_encode_special ($f_entry['content']);

		$this->entry_set ("range",$f_entry);

		if ($f_entry['error']) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_radio ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_radio ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_formbuilder->entry_add_rcp_text ($f_entry)
/**
	* A rcp enhanced text input field.
	*
	* @param  array $f_entry Form field data
	* @uses   direct_debug()
	* @uses   direct_formbuilder::entry_add_text()
	* @uses   direct_formbuilder::entry_length_check()
	* @uses   direct_html_encode_special()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_rcp_text ($f_entry)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_rcp_text (+f_entry)- (#echo(__LINE__)#)"); }

		if ($direct_settings['formbuilder_rcp_supported'])
		{
			$f_return = true;

			$f_entry = $this->entry_defaults_set ($f_entry,"","",NULL);
			$f_entry = $this->entry_field_size_set ($f_entry);
			$f_entry = $this->entry_limits_set ($f_entry);

			$f_entry['content'] = str_replace (array ("\n","&lt;","&gt;","<br />"),(array ("[newline]","<",">","[newline]")),$f_entry['content']);
			$f_entry['error'] = $this->entry_length_check ($f_entry['content'],$f_entry['min'],$f_entry['max'],$f_entry['required']);

			if ($f_entry['error']) { $f_return = false; }
			else { $direct_cachedata["i_".$f_entry['name']] = $f_entry['content']; }

			$f_entry['content'] = direct_html_encode_special ($f_entry['content']);

			$this->entry_set ("rcp_text",$f_entry);
		}
		else { $f_return = $this->entry_add_text ($f_entry); }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_rcp_text ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_add_rcp_textarea ($f_entry)
/**
	* A rcp enhanced textarea input field.
	*
	* @param  array $f_entry Form field data
	* @uses   direct_debug()
	* @uses   direct_formbuilder::entry_add_textarea()
	* @uses   direct_formbuilder::entry_length_check()
	* @uses   direct_html_encode_special()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_rcp_textarea ($f_entry)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_rcp_textarea (+f_entry)- (#echo(__LINE__)#)"); }

		if ($direct_settings['formbuilder_rcp_supported'])
		{
			$f_return = true;

			$f_entry = $this->entry_defaults_set ($f_entry,"","",NULL);
			$f_entry = $this->entry_field_size_set ($f_entry);
			$f_entry = $this->entry_limits_set ($f_entry);

			$f_entry['content'] = str_replace (array ("[newline]","&lt;","&gt;","<br />"),(array ("\n","<",">","\n")),$f_entry['content']);
			$f_entry['error'] = $this->entry_length_check ($f_entry['content'],$f_entry['min'],$f_entry['max'],$f_entry['required']);

			if ($f_entry['error']) { $f_return = false; }
			else { $direct_cachedata["i_".$f_entry['name']] = $f_entry['content']; }

			$f_entry['content'] = direct_html_encode_special ($f_entry['content']);

			$this->entry_set ("rcp_textarea",$f_entry);
		}
		else { $f_return = $this->entry_add_textarea ($f_entry); }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_rcp_textarea ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_add_select ($f_entry)
/**
	* Inserts a selectbox for exact one selected option.
	*
	* @param  array $f_entry Form field data
	* @uses   direct_debug()
	* @uses   direct_evars_get()
	* @uses   direct_html_encode_special()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_select ($f_entry)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_select (+f_entry)- (#echo(__LINE__)#)"); }

		$f_entry = $this->entry_defaults_set ($f_entry,"","",NULL);
		$f_entry = $this->entry_field_size_set ($f_entry,"s");

		$f_choices_array = direct_evars_get ($f_entry['content']);
		$f_entry['content'] = "";
		$f_selected_value = "";

		if (is_array ($f_choices_array))
		{
			foreach ($f_choices_array as $f_choice_array)
			{
				if ($f_entry['content']) { $f_entry['content'] .= "\n"; }

				$f_choice_array['value'] = direct_html_encode_special ($f_choice_array['value']);
				$f_choice_array['text'] = str_replace ('"',"&quot;",$f_choice_array['text']);
				if (!strlen ($f_choice_array['text'])) { $f_choice_array['text'] = $f_choice_array['value']; }

				if (isset ($f_choice_array['selected']))
				{
					$f_entry['content'] .= "<option value=\"{$f_choice_array['value']}\" selected='selected'>{$f_choice_array['text']}</option>";
					$f_selected_value = $f_choice_array['value'];
				}
				else { $f_entry['content'] .= "<option value=\"{$f_choice_array['value']}\">{$f_choice_array['text']}</option>"; }
			}
		}

		$direct_cachedata["i_".$f_entry['name']] = $f_selected_value;
		$f_entry['error'] = ((($f_entry['required'])&&(!strlen ($f_selected_value))) ? "required_element" : "");

		$this->entry_set ("select",$f_entry);

		if ($f_entry['error']) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_radio ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_radio ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_formbuilder->entry_add_text ($f_entry)
/**
	* A single line text input field.
	*
	* @param  array $f_entry Form field data
	* @uses   direct_debug()
	* @uses   direct_formbuilder::entry_length_check()
	* @uses   direct_html_encode_special()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_text ($f_entry)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_text (+f_entry)- (#echo(__LINE__)#)"); }

		$f_return = true;

		$f_entry = $this->entry_defaults_set ($f_entry,"","",NULL);
		$f_entry = $this->entry_field_size_set ($f_entry);
		$f_entry = $this->entry_limits_set ($f_entry);

		$f_entry['content'] = str_replace (array ("\n","&lt;","&gt;","<br />"),(array ("[newline]","<",">","[newline]")),$f_entry['content']);
		$f_entry['error'] = $this->entry_length_check ($f_entry['content'],$f_entry['min'],$f_entry['max'],$f_entry['required']);

		if ($f_entry['error']) { $f_return = false; }
		else { $direct_cachedata["i_".$f_entry['name']] = $f_entry['content']; }

		$f_entry['content'] = direct_html_encode_special ($f_entry['content']);

		$this->entry_set ("text",$f_entry);
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_text ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_add_textarea ($f_entry)
/**
	* A standard textarea input field.
	*
	* @param  array $f_entry Form field data
	* @uses   direct_debug()
	* @uses   direct_formbuilder::entry_length_check()
	* @uses   direct_html_encode_special()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_textarea ($f_entry)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_textarea (+f_entry)- (#echo(__LINE__)#)"); }

		$f_return = true;

		$f_entry = $this->entry_defaults_set ($f_entry,"","",NULL);
		$f_entry = $this->entry_field_size_set ($f_entry);
		$f_entry = $this->entry_limits_set ($f_entry);

		$f_entry['content'] = str_replace (array ("[newline]","&lt;","&gt;","<br />"),(array ("\n","<",">","\n")),$f_entry['content']);
		$f_entry['error'] = $this->entry_length_check ($f_entry['content'],$f_entry['min'],$f_entry['max'],$f_entry['required']);

		if ($f_entry['error']) { $f_return = false; }
		else { $direct_cachedata["i_".$f_entry['name']] = $f_entry['content']; }

		$f_entry['content'] = direct_html_encode_special ($f_entry['content']);

		$this->entry_set ("textarea",$f_entry);
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_textarea ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_defaults_set ($f_data,$f_name = "",$f_title = "",$f_content = "",$f_required = false)
/**
	* Creates spacing fields like "hidden", "element", "info", "spacer" or "subtitle".
	*
	* @param  string $f_type Form field type
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  mixed $f_content Form field related content data
	* @param  boolean $f_required True if the field is required to continue
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return mixed Array on success; NULL on error
	* @link   http://www.direct-netware.de/redirect.php?swg;handbooks;dev;formbuilder
	*         Click here to get a list of available form fields
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_defaults_set ($f_data,$f_name = "",$f_title = NULL,$f_content = "",$f_required = false)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_defaults_set (+f_data,$f_name,$f_title,+f_content,+f_required)- (#echo(__LINE__)#)"); }

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

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_defaults_set ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_error_set ($f_name,$f_error,$f_section = NULL,$f_cache = NULL)
/**
	* Set an external error message for the given form field.
	*
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if the field is not defined
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_error_set ($f_name,$f_error,$f_section = "",$f_cache = NULL)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_set_error ($f_name,$f_error,+f_section,+f_cache)- (#echo(__LINE__)#)"); }

		$f_form_id = md5 ("i_".$f_name);
		$f_return = true;

		if (isset ($this->form_cache[$f_section]/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$this->form_cache[$f_section][$f_form_id])) { $this->form_cache[$f_section][$f_form_id]['error'] = $f_error; }
		else { $f_return = false; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_set_error ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_field_size_set ($f_data,$f_size = "m")
/**
	* Creates spacing fields like "hidden", "element", "info", "spacer" or "subtitle".
	*
	* @param  string $f_type Form field type
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  mixed $f_content Form field related content data
	* @param  boolean $f_required True if the field is required to continue
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return mixed Array on success; NULL on error
	* @link   http://www.direct-netware.de/redirect.php?swg;handbooks;dev;formbuilder
	*         Click here to get a list of available form fields
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_field_size_set ($f_data,$f_size = "m")
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_field_size_set (+f_data,$f_size)- (#echo(__LINE__)#)"); }

		if (is_array ($f_data))
		{
			$f_return = $f_data;
			if (!isset ($f_return['size'])) { $f_return['size'] = $f_size; }
		}
		else { $f_return = NULL; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_field_size_set ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_length_check ($f_data,$f_min = 0,$f_max = 0,$f_required = false)
/**
	* Checks the size for a given string.
	*
	* @param  string $f_data The string that should be checked
	* @param  integer $f_min Defines the minimal length for a string or 0 to
	*         ignore
	* @param  integer $f_max Defines the maximal length for a string or 0 for an
	*         unlimited size
	* @param  boolean $f_required True if the field is required to continue
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if a required field is empty, it is smaller than
	*         the minimum or larger than the maximum
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_length_check ($f_data,$f_min = 0,$f_max = 0,$f_required = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_length_check (+f_data,$f_min,$f_max)- (#echo(__LINE__)#)"); }

		if (($f_required)&&(!$f_data)) { $f_return = "required_element"; }
		elseif (($f_data)&&($f_min)&&($f_min > (strlen ($f_data)))) { $f_return = "string_min|".$f_min; }
		elseif (($f_max)&&($f_max < (strlen ($f_data)))) { $f_return = "string_max|".$f_max; }
		else { $f_return = ""; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_length_check ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_limits_set ($f_data,$f_min = 0,$f_max = 0)
/**
	* Creates spacing fields like "hidden", "element", "info", "spacer" or "subtitle".
	*
	* @param  string $f_type Form field type
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  mixed $f_content Form field related content data
	* @param  boolean $f_required True if the field is required to continue
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return mixed Array on success; NULL on error
	* @link   http://www.direct-netware.de/redirect.php?swg;handbooks;dev;formbuilder
	*         Click here to get a list of available form fields
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_limits_set ($f_data,$f_min = 0,$f_max = 0)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_limits_set ($f_data,$f_min,$f_max)- (#echo(__LINE__)#)"); }

		if (is_array ($f_data))
		{
			$f_return = $f_data;
			if (!isset ($f_return['min'])) { $f_return['min'] = $f_min; }
			if (!isset ($f_return['max'])) { $f_return['max'] = $f_max; }
		}
		else { $f_return = NULL; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_limits_set ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_range_check ($f_data,$f_min = 0,$f_max = 0,$f_required = false)
/**
	* Checks the size for a given string.
	*
	* @param  string $f_data The string that should be checked
	* @param  integer $f_min Defines the minimal range for a number or NULL to
	*         ignore
	* @param  integer $f_max Defines the maximal range for a number or NULL for an
	*         unlimited size
	* @param  boolean $f_required True if the field is required to continue
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if a required field is empty, it is smaller than
	*         the minimum or larger than the maximum
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_range_check ($f_data,$f_min = NULL,$f_max = NULL,$f_required = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_length_check (+f_data,$f_min,$f_max)- (#echo(__LINE__)#)"); }

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

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_range_check ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_set ($f_filter,$f_entry)
/**
	* Creates spacing fields like "hidden", "element", "info", "spacer" or "subtitle".
	*
	* @param string $f_filter Form field output parser
	* @param array $f_entry Form field data
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @link  http://www.direct-netware.de/redirect.php?swg;handbooks;dev;formbuilder
	*        Click here to get a list of available form fields
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function entry_set ($f_filter,$f_entry)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_set (+f_filter,+f_entry)- (#echo(__LINE__)#)"); }

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

	//f// direct_formbuilder->form_get ($f_check = false)
/**
	* Parses all previously defined form fields, checks them and returns an array
	* ready for output.
	*
	* @param  boolean $f_check True if all fields should be checked (result will
	*         be stored in $this->check_result).
	* @uses   direct_debug()
	* @uses   direct_local_get()
	* @uses   USE_debug_reporting
	* @return array Array of form fields ready for output
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function form_get ($f_check = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->form_get (+f_check)- (#echo(__LINE__)#)"); }

		$f_return = array ();

		if (empty ($this->form_cache))
		{
			if ($f_check) { $this->check_result = false; }
		}
		else
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

	//f// direct_formbuilder->xml_entry_set ($f_entry,$f_xml_sub_node_array)
/**
	* Checks a XML form entry definition and calls the corresponding method.
	*
	* @param  array &$f_xml_node_array XML form entry
	* @param  array &$f_xml_sub_node_array Array containing possible translation
	*         entries
	* @uses   direct_debug()
	* @uses   direct_local_get()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function xml_entry_set ($f_entry,$f_xml_sub_node_array)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->xml_entry_set (+f_entry,+f_xml_sub_node_array)- (#echo(__LINE__)#)"); }

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
					$f_formbuilder_function = "entry_add";
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
					$f_formbuilder_function = "entry_add";
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
					$f_formbuilder_function = "entry_add";
					$f_formbuilder_function_type = "info";
				}
			}

			break 1;
		}
		case "file_ftg":
		{
			if (isset ($f_entry['name']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_entry['file'])) { $f_formbuilder_function = "entry_add_file_ftg"; }
			break 1;
		}
		case "multiselect":
		{
			$f_formbuilder_function = "entry_add_multiselect";
			$f_formbuilder_function_type_selectable = true;
			break 1;
		}
		case "password":
		{
			if (isset ($f_entry['name']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_entry['mode']))
			{
				if (!isset ($f_entry['bytemix'])) { $f_entry['bytemix'] = NULL; }
				$f_formbuilder_function = "entry_add_password";
			}

			break 1;
		}
		case "radio":
		{
			$f_formbuilder_function = "entry_add_radio";
			$f_formbuilder_function_type_selectable = true;
			break 1;
		}
		case "select":
		{
			$f_formbuilder_function = "entry_add_select";
			$f_formbuilder_function_type_selectable = true;
			break 1;
		}
		default:
		{
			if ($this->v_call_check ("entry_add_".$f_entry['filter'])) { $f_formbuilder_function = "entry_add_".$f_entry['filter']; }
		}
		}

		if (($f_formbuilder_function)&&(isset ($f_entry['name'])))
		{
			if ($f_formbuilder_function_type_selectable)
			{
				$direct_cachedata["i_".$f_entry['name']] = str_replace ("'","",(isset ($direct_cachedata["i_".$f_entry['name']]) ? $direct_cachedata["i_".$f_entry['name']] : direct_local_get_xml_translation ($f_xml_sub_node_array,"predefined",true,$direct_settings['lang'])));
				if (isset ($direct_cachedata["i_".$f_entry['name']])) { $direct_cachedata["i_".$f_entry['name']] = str_replace ((array ("<selected value='1' />","<value value='".$direct_cachedata["i_".$f_entry['name']]."' />")),(array ("","<value value='".$direct_cachedata["i_".$f_entry['name']]."' /><selected value='1' />")),$direct_cachedata["i_".$f_entry['name']]); }
			}
			elseif (!isset ($direct_cachedata["i_".$f_entry['name']])) { $direct_cachedata["i_".$f_entry['name']] = direct_local_get_xml_translation ($f_xml_sub_node_array,"predefined",true,$direct_settings['lang']); }

			switch ($f_formbuilder_function)
			{
			case "entry_add":
			{
				$this->entry_add_file_ftg ($f_formbuilder_function_type,$f_entry);
				break 1;
			}
			case "entry_add_file_ftg":
			{
				$this->entry_add_file_ftg ($f_entry,$f_entry['file']);
				break 1;
			}
			case "entry_add_password":
			{
				$this->entry_add_password ($f_entry,$f_entry['mode'],$f_entry['bytemix']);
				break 1;
			}
			default: { $this->{$f_formbuilder_function} ($f_entry); }
			}
		}
		else { $f_return = false; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->xml_form_entry ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->xml_form ($f_xml)
/**
	* Parses a XML form definition.
	*
	* @param  mixed &$f_xml XML form definition string or preparsed XML array
	* @uses   direct_debug()
	* @uses   direct_local_get()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function xml_form ($f_xml)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->xml_form (+f_xml)- (#echo(__LINE__)#)"); }

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

					if (isset ($f_xml_node_array['value']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_xml_node_array['attributes']['filter']))
					{
						$f_entry = $f_xml_node_array['attributes'];

						if (isset ($f_entry['value_translation'])) { $f_entry['title'] = direct_local_get_xml_translation ($f_xml_sub_node_array,"title",true,$direct_settings['lang']); }
						else { $f_entry['title'] = ((isset ($f_xml_sub_node_array['title']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_xml_sub_node_array['title']['value'])) ? $f_xml_sub_node_array['title']['value'] : $f_xml_node_array['value']); }

						if (isset ($f_entry['helper_translation'])) { $f_entry['helper_text'] = direct_local_get_xml_translation ($f_xml_sub_node_array,"helper_text",true,$direct_settings['lang']); }
						elseif (isset ($f_entry['helper_text'])) { $f_entry['helper_text'] = direct_local_get ($f_entry['helper_text']); }
						else { $f_entry['helper_text'] = ""; }

						$f_entry['helper_closing'] = (((!isset ($f_entry['helper_closing']))||($f_entry['helper_closing'])) ? true : false);

						$f_return = (isset ($f_entry['filter']) ? $this->xml_entry_set ($f_entry,$f_xml_sub_node_array) : false);
					}
					else { $f_return = false; }
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->xml_form ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_globals['@names']['formbuilder'] = "direct_formbuilder";
define ("CLASS_direct_formbuilder",true);

if (!isset ($direct_cachedata['formbuilder_element_counter'])) { $direct_cachedata['formbuilder_element_counter'] = 0; }
if (!isset ($direct_settings['account_password_bytemix'])) { $direct_settings['account_password_bytemix'] = ($direct_settings['swg_id'] ^ (strrev ($direct_settings['swg_id']))); }
if (!isset ($direct_settings['formbuilder_rcp_supported'])) { $direct_settings['formbuilder_rcp_supported'] = false; }
}

$g_continue_check = true;
if (defined ("CLASS_direct_output_formbuilder")) { $g_continue_check = false; }
if (!defined ("CLASS_direct_virtual_class")) { $g_continue_check = false; }

if ($g_continue_check)
{
//c// direct_output_formbuilder->formbuilder
/**
* This is the extended output controller to create forms, their values and
* errors.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage formbuilder
* @uses       CLASS_direct_virtual_class
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_output_formbuilder extends direct_virtual_class
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_output_formbuilder->__construct () and direct_output_formbuilder->direct_output_formbuilder ()
/**
	* Constructor (PHP5) __construct (direct_output_formbuilder)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->__construct (direct_output_formbuilder)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['entry_add_element'] = true;
		$this->functions['entry_add_embed'] = true;
		$this->functions['entry_add_file_ftg'] = true;
		$this->functions['entry_add_hidden'] = true;
		$this->functions['entry_add_info'] = true;
		$this->functions['entry_add_multiselect'] = true;
		$this->functions['entry_add_password'] = true;
		$this->functions['entry_add_password_2'] = true;
		$this->functions['entry_add_radio'] = true;
		$this->functions['entry_add_range'] = true;
		$this->functions['entry_add_rcp_text'] = true;
		$this->functions['entry_add_rcp_textarea'] = true;
		$this->functions['entry_add_select'] = true;
		$this->functions['entry_add_spacer'] = true;
		$this->functions['entry_add_subtitle'] = true;
		$this->functions['entry_add_text'] = true;
		$this->functions['entry_add_textarea'] = true;
		$this->functions['form_get'] = true;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_output_formbuilder->formbuilder
	* (direct_output_formbuilder)
	*
	* @since v0.1.00
*\/
	function direct_output_formbuilder () { $this->__construct (); }
:#*/
	//f// direct_output_formbuilder->entry_add_element ($f_data)
/**
	* Add an user space defined object. Everything must be handled by user space.
	*
	* @param  array $f_data Array containing information about the form field
	* @uses   direct_debug()
	* @uses   direct_output_control::js_helper()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_element ($f_data)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_element (+f_data)- (#echo(__LINE__)#)"); }

		$f_return = "";

		if (isset ($f_data['title']))
		{
			if (strlen ($f_data['content']))
			{
				$f_js_helper = ($f_data['helper_text'] ? "<span style='font-size:8px'>&#0160;</span><br />\n<div class='pagecontent' style='font-size:10px'>".($direct_globals['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</div>" : "");
				$f_return = "<tr>";

				if ($f_data['title'] == "-") { $f_return .= "\n<td class='pageextrabg' style='width:25%;text-align:right;vertical-align:top'><span style='font-size:8px'>&#0160;</span></td>"; }
				else
				{
					$f_return .= "\n<td class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><span class='pageextracontent' style='font-weight:bold'>";
					if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }
					$f_return .= $f_data['title'].":</span></td>";
				}

$f_return .= ("\n<td class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center'>
<table style='margin:auto'>
<tbody><tr>
<td style='text-align:left'><div class='pagecontent'>$f_data[content]</div></td>
</tr></tbody>
</table>$f_js_helper</td>
</tr>");
			}
		}
		else
		{
			$f_js_helper = ($f_data['helper_text'] ? "<br />\n<span style='font-size:8px'>&#0160;</span><br />\n<div class='pagecontent' style='font-size:10px'>".($direct_globals['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</div>" : "");

$f_return = ("<tr>
<td colspan='2' class='pagebg' style='padding:$direct_settings[theme_form_td_padding];text-align:center'>
<table style='margin:auto'>
<tbody><tr>
<td style='text-align:left'><div class='pagecontent'>$f_data[content]</div></td>
</tr></tbody>
</table>$f_js_helper</td>
</tr>");
		}

		return $f_return;
	}

	//f// direct_output_formbuilder->entry_add_embed ($f_data)
/**
	* Include an embedded page via iframe for additional and extended options.
	*
	* @param  array $f_data Array containing information about the form field
	* @uses   direct_debug()
	* @uses   direct_linker()
	* @uses   direct_local_get()
	* @uses   direct_output_control::js_helper()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_embed ($f_data)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_embed (+f_data)- (#echo(__LINE__)#)"); }

		if (!$f_data['iframe_only']) { $f_embed_url_ajax = direct_linker ("asis","ajax_content;".$f_data['url']); }
		$f_embed_url_iframe = direct_linker ("url0","xhtml_embedded;".$f_data['url']);
		$f_embed_url_error = direct_linker ("url0",$f_data['url']);

		if ($f_data['size'] == "s") { $f_height = 230; }
		elseif ($f_data['size'] == "m") { $f_height = 315; }
		else { $f_height = 400; }

		$f_js_helper = ($f_data['helper_text'] ? "<div class='pagecontent' style='font-size:10px'>".($direct_globals['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</div>" : "");

		if (isset ($f_data['title']))
		{
			$f_return = "<tr>\n<td class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><span class='pageextracontent' style='font-weight:bold'>";
			if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }
			$f_return .= $f_data['title'].":</span></td>\n<td class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'>";
		}
		else { $f_return = "<tr>\n<td colspan='2' class='pagebg' style='padding:$direct_settings[theme_form_td_padding];text-align:center'>"; }

$f_embedded_code = (($f_data['size'] == "l") ? "<p class='pagecontent' id='swgAJAX_embed_{$f_data['content']}_point'>".(direct_local_get ("core_loading","text"))."</p>" : ("<div><span class='pagecontent' style='font-size:10px'>[ <a href=\"javascript:djs_swgDOM_css_change_px('swgAJAX_formbuilder_embed_{$f_data['content']}sb_point','height','-');\">-</a> ] [ <a href=\"javascript:djs_swgDOM_css_change_px('swgAJAX_formbuilder_embed_{$f_data['content']}sb_point','height','230');\">".(direct_local_get ("formbuilder_size_small"))."</a> ] [ <a href=\"javascript:djs_swgDOM_css_change_px('swgAJAX_formbuilder_embed_{$f_data['content']}sb_point','height','315');\">".(direct_local_get ("formbuilder_size_medium"))."</a> ] [ <a href=\"javascript:djs_swgDOM_css_change_px('swgAJAX_formbuilder_embed_{$f_data['content']}sb_point','height','400');\">".(direct_local_get ("formbuilder_size_large"))."</a> ] [ <a href=\"javascript:djs_swgDOM_css_change_px('swgAJAX_formbuilder_embed_{$f_data['content']}sb_point','height','+');\">+</a> ]<br /><br />
</span><div id='swgAJAX_formbuilder_embed_{$f_data['content']}sb_point' class='pageembeddedborder2{$direct_settings['theme_css_corners']} pagecontent' style='margin:auto;height:{$f_height}px;overflow:auto'><p id='swgAJAX_embed_{$f_data['content']}_point'>".(direct_local_get ("core_loading","text"))."</p></div></div>"));

		if ((!$f_data['iframe_only'])&&(isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']))) { $f_return .= $f_embedded_code; }
		else
		{
$f_return .= ("<div id='swgAJAX_formbuilder_embed_{$f_data['content']}_point'><span id='swgAJAX_formbuilder_embed_{$f_data['content']}sb_point' style='display:none'><!-- iPoint // --></span><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_swgDOM_replace',params:{ data:\"<span class='pagecontent' style='font-size:10px'>[ <a href=\\\"javascript:djs_formbuilder_iframe_change_height('swgAJAX_embed_{$f_data['content']}_point','-');\\\">-</a> ] [ <a href=\\\"javascript:djs_formbuilder_iframe_change_height('swgAJAX_embed_{$f_data['content']}_point','230');\\\">".(direct_local_get ("formbuilder_size_small"))."</a> ] [ <a href=\\\"javascript:djs_formbuilder_iframe_change_height('swgAJAX_embed_{$f_data['content']}_point','315');\\\">".(direct_local_get ("formbuilder_size_medium"))."</a> ] [ <a href=\\\"javascript:djs_formbuilder_iframe_change_height('swgAJAX_embed_{$f_data['content']}_point','400');\\\">".(direct_local_get ("formbuilder_size_large"))."</a> ] [ <a href=\\\"javascript:djs_formbuilder_iframe_change_height('swgAJAX_embed_{$f_data['content']}_point','+');\\\">+</a> ]<br /><br />\\n</span>\",id:'swgAJAX_formbuilder_embed_{$f_data['content']}sb_point' } });
]]></script><iframe src='$f_embed_url_iframe' id='swgAJAX_embed_{$f_data['content']}_point' class='pageembeddedborder2{$direct_settings['theme_css_corners']}' style='width:100%;height:{$f_height}px'><span class='pagecontent' style='font-weight:bold'>".(direct_local_get ("formbuilder_embed_unsupported_1"))."<a href='$f_embed_url_error' target='_blank'>".(direct_local_get ("formbuilder_embed_unsupported_2"))."</a>".(direct_local_get ("formbuilder_embed_unsupported_3"))."</span></iframe></div>");
		}

		$f_return .= "<input type='hidden' name='{$f_data['name']}' value='{$f_data['content']}' /><script type='text/javascript'><![CDATA[\n";

		if ($f_data['iframe_only']) { $f_return .= "djs_var.core_run_onload.push ({ func:'djs_load_functions',params: { file:'swg_formbuilder.php.js',block:'djs_formbuilder_iframe_change_height' } });"; }
		else
		{
$f_return .= ("djs_var.core_run_onload.push ({ func:'djs_load_functions',params: { file:'swg_AJAX.php.js',block:'djs_swgAJAX_replace' } });
djs_var.core_run_onload.push ({ func:'djs_load_functions',params: { file:'swg_DOM.php.js',block:'djs_swgDOM_css_change_px' } });\n");

			if (isset ($direct_settings['swg_clientsupport']['JSDOMManipulation'])) { $f_return .= ("djs_var.core_run_onload.push ({ func:'djs_swgAJAX_replace',params: { id:'swgAJAX_embed_{$f_data['content']}_point',url0:'$f_embed_url_ajax' } });"); }
			else { $f_return .= "djs_var.core_run_onload.push ({ func:'djs_swgDOM_replace',params: { data:\"".(str_replace (array ('"',"\n"),(array ('\"',"\" +\n\"")),$f_embedded_code))."\",id:'swgAJAX_formbuilder_embed_{$f_data['content']}_point',onReplaced:{ func:'djs_swgAJAX_replace',params: { id:'swgAJAX_embed_{$f_data['content']}_point',url0:'$f_embed_url_ajax' } } } });"; }
		}

		$f_return .= "\n]]></script>$f_js_helper</td>\n</tr>";

		return $f_return;
	}

	//f// direct_output_formbuilder->entry_add_file_ftg ($f_data)
/**
	* Format and return XHTML to show a FormTags formatted file.
	*
	* @param  array $f_data Array containing information about the form field
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_file_ftg ($f_data)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_file_ftg (+f_data)- (#echo(__LINE__)#)"); }

		$f_css_values = "";

		if ($f_data['size'] == "s")
		{
			if (strlen ($f_data['content']) > 575) { $f_css_values = ";height:275px"; }
		}
		elseif ($f_data['size'] == "m")
		{
			if (strlen ($f_data['content']) > 675) { $f_css_values = ";height:320px"; }
		}
		else
		{
			if (strlen ($f_data['content']) > 825) { $f_css_values = ";height:400px"; }
		}

$f_return = ("<tr>
<td class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><span class='pageextracontent' style='font-weight:bold'>$f_data[title]:</span></td>
<td class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:left;vertical-align:middle'><div class='pagecontent' style='margin:auto;padding:1px 5px;overflow:auto$f_css_values'>$f_data[content]</div></td>
</tr>");

		return $f_return;
	}

	//f// direct_output_formbuilder->entry_add_hidden ($f_data)
/**
	* Include a hidden form field and its value.
	*
	* @param  array $f_data Array containing information about the form field
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_hidden ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_hidden (+f_data)- (#echo(__LINE__)#)"); }
		return "<input type='hidden' name='$f_data[name]' value='$f_data[content]' />";
	}

	//f// direct_output_formbuilder->entry_add_info ($f_data)
/**
	* Format and return XHTML to show developer-defined information.
	*
	* @param  array $f_data Array containing information about the form field
	* @uses   direct_debug()
	* @uses   direct_output_control::js_helper()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_info ($f_data)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_info (+f_data)- (#echo(__LINE__)#)"); }

		$f_return = "";

		if (!$f_data['title'])
		{
			$f_js_helper = ($f_data['helper_text'] ? "<br />\n<span style='font-size:8px'>&#0160;</span><br />\n<div class='pagecontent' style='font-size:10px'>".($direct_globals['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</div>" : "");

$f_return .= ("<tr>
<td colspan='2' class='pagebg' style='padding:$direct_settings[theme_form_td_padding];text-align:center'>
<table style='margin:auto'>
<tbody><tr>
<td style='text-align:left'><div class='pagecontent' style='font-size:10px'>$f_data[content]</div></td>
</tr></tbody>
</table>$f_js_helper</td>
</tr>");
		}
		elseif (strlen ($f_data['content']))
		{
			$f_js_helper = ($f_data['helper_text'] ? "<span style='font-size:8px'>&#0160;</span><br />\n<div class='pagecontent' style='font-size:10px'>".($direct_globals['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</div>" : "");
			$f_return .= "<tr>";

			if ($f_data['title'] == "-") { $f_return .= "\n<td class='pageextrabg' style='width:25%;text-align:right;vertical-align:top'><span style='font-size:8px'>&#0160;</span></td>"; }
			else
			{
				$f_return .= "\n<td class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><span class='pageextracontent' style='font-weight:bold'>";
				if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }
				$f_return .= $f_data['title'].":</span></td>";
			}

$f_return .= ("\n<td class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center'>
<table style='margin:auto'>
<tbody><tr>
<td style='text-align:left'><div class='pagecontent'>$f_data[content]</div></td>
</tr></tbody>
</table>$f_js_helper</td>
</tr>");
		}

		return $f_return;
	}

	//f// direct_output_formbuilder->entry_add_multiselect ($f_data)
/**
	* Format and return XHTML to create multiple choice select options.
	*
	* @param  array $f_data Array containing information about the form field
	* @uses   direct_debug()
	* @uses   direct_output_control::js_helper()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_multiselect ($f_data)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_multiselect (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		$f_js_helper = ($f_data['helper_text'] ? "<br />\n<span style='font-size:8px'>&#0160;</span><br />\n<div class='pagecontent' style='font-size:10px'>".($direct_globals['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</div>" : "");

		if ($f_data['size'] == "s") { $f_rows = 2; }
		elseif ($f_data['size'] == "m") { $f_rows = 5; }
		else { $f_rows = 10; }

		$f_return = "<tr>\n<td class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><span class='pageextracontent' style='font-weight:bold'>";

		if ($f_data['required'])
		{
			$f_required = " required='required'";
			$f_return .= $direct_settings['swg_required_marker']." ";
		}
		else { $f_required = ""; }

$f_return .= ($f_data['title'].":</span></td>
<td class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'><span id='{$f_js_id}_point' style='display:none'><!-- iPoint // --></span><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_swgDOM_replace',params:{ data:\"<span class='pagecontent' style='font-size:10px'>[ <a href=\\\"javascript:djs_formbuilder_select_change_size('$f_js_id','-');\\\">-</a> ] [ <a href=\\\"javascript:djs_formbuilder_select_change_size('$f_js_id','2');\\\">".(direct_local_get ("formbuilder_size_small"))."</a> ] [ <a href=\\\"javascript:djs_formbuilder_select_change_size('$f_js_id','5');\\\">".(direct_local_get ("formbuilder_size_medium"))."</a> ] [ <a href=\\\"javascript:djs_formbuilder_select_change_size('$f_js_id','10');\\\">".(direct_local_get ("formbuilder_size_large"))."</a> ] [ <a href=\\\"javascript:djs_formbuilder_select_change_size('$f_js_id','+');\\\">+</a> ]<br />\\n</span>\",id:'{$f_js_id}_point' } });
]]></script><select name='{$f_data['name']}[]' id='$f_js_id'$f_required size='$f_rows' multiple='multiple' class='pagecontentselect'>$f_data[content]</select><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_formbuilder_tabindex',params: { id:'$f_js_id' } });
djs_var.core_run_onload.push ({ func:'djs_load_functions',params: { file:'swg_formbuilder.php.js',block:'djs_formbuilder_select_change_size' } });
]]></script>$f_js_helper</td>
</tr>");

		return $f_return;
	}

	//f// direct_output_formbuilder->entry_add_password ($f_data)
/**
	* Format and return XHTML for a password field.
	*
	* @param  array $f_data Array containing information about the form field
	* @uses   direct_debug()
	* @uses   direct_output_control::js_helper()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_password ($f_data)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_password (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		$f_js_helper = ($f_data['helper_text'] ? "<br />\n<span style='font-size:8px'>&#0160;</span><br />\n<div class='pagecontent' style='font-size:10px'>".($direct_globals['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</div>" : "");

		if ($f_data['size'] == "s")
		{
			$f_width = 10;
			$f_css_width = "30%";
		}
		elseif ($f_data['size'] == "m")
		{
			$f_width = 18;
			$f_css_width = "55%";
		}
		else
		{
			$f_width = 26;
			$f_css_width = "80%";
		}

		$f_return = "<tr>\n<td class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><span class='pageextracontent' style='font-weight:bold'>";

		if ($f_data['required'])
		{
			$f_required = " required='required'";
			$f_return .= $direct_settings['swg_required_marker']." ";
		}
		else { $f_required = ""; }

$f_return .= ($f_data['title'].":</span></td>
<td class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'><input type='password' name='$f_data[name]' id='$f_js_id' value=''$f_required size='$f_width' class='pagecontentinputtextnpassword' style='width:$f_css_width' /><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'$f_js_id' } });
]]></script>$f_js_helper</td>
</tr>");

		return $f_return;
	}

	//f// direct_output_formbuilder->entry_add_password_2 ($f_data)
/**
	* Format and return XHTML for a password and a confirmation field.
	*
	* @param  array $f_data Array containing information about the form field
	* @uses   direct_debug()
	* @uses   direct_local_get()
	* @uses   direct_output_control::js_helper()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_password_2 ($f_data)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_password_2 (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		$f_js_helper = ($f_data['helper_text'] ? "<div class='pagecontent' style='font-size:10px'>".($direct_globals['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</div>" : "");

		if ($f_data['size'] == "s")
		{
			$f_width = 10;
			$f_css_width = "30%";
		}
		elseif ($f_data['size'] == "m")
		{
			$f_width = 18;
			$f_css_width = "55%";
		}
		else
		{
			$f_width = 26;
			$f_css_width = "80%";
		}

		$f_return = "<tr>\n<td class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><span class='pageextracontent' style='font-weight:bold'>";

		if ($f_data['required'])
		{
			$f_required = " required='required'";
			$f_return .= $direct_settings['swg_required_marker']." ";
		}
		else { $f_required = ""; }

$f_return .= ($f_data['title'].":</span></td>
<td class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'><p><input type='password' name='$f_data[name]' id='$f_js_id' value=''$f_required size='$f_width' class='pagecontentinputtextnpassword' style='width:$f_css_width' /></p>
<p class='pagecontent' style='font-size:10px'>".(direct_local_get ("formbuilder_form_password_repetition")).":<br />
<input type='password' name='{$f_data['name']}_repetition' id='{$f_js_id}r' value=''$f_required size='$f_width' class='pagecontentinputtextnpassword' style='width:$f_css_width' /></p><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'$f_js_id' } });
djs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'{$f_js_id}r' } });
]]></script>$f_js_helper</td>
</tr>");

		return $f_return;
	}

	//f// direct_output_formbuilder->entry_add_radio ($f_data)
/**
	* Format and return XHTML to create radio options.
	*
	* @param  array $f_data Array containing information about the form field
	* @uses   direct_debug()
	* @uses   direct_output_control::js_helper()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_radio ($f_data)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_radio (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_helper = ($f_data['helper_text'] ? "<span style='font-size:8px'>&#0160;</span><br />\n<div class='pagecontent' style='font-size:10px'>".($direct_globals['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</div>" : "");

		$f_return = "<tr>\n<td class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><span class='pageextracontent' style='font-weight:bold'>";
		if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }

$f_return .= ($f_data['title'].":</span></td>
<td class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'>
<table style='margin:auto'>
<tbody><tr>
<td style='text-align:left'><div class='pagecontent'>$f_data[content]</div></td>
</tr></tbody>
</table>$f_js_helper</td>
</tr>");

		return $f_return;
	}

	//f// direct_output_formbuilder->entry_add_range ($f_data)
/**
	* Format and return XHTML to create a range input.
	*
	* @param  array $f_data Array containing information about the form field
	* @uses   direct_debug()
	* @uses   direct_output_control::js_helper()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_range ($f_data)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_range (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		$f_js_helper = ($f_data['helper_text'] ? "<span style='font-size:8px'>&#0160;</span><br />\n<div class='pagecontent' style='font-size:10px'>".($direct_globals['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</div>" : "");

		$f_return = "<tr>\n<td class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><span class='pageextracontent' style='font-weight:bold'>";

		if ($f_data['required'])
		{
			$f_required = " required='required'";
			$f_return .= $direct_settings['swg_required_marker']." ";
		}
		else { $f_required = ""; }

		$f_return .= $f_data['title'].":</span></td>\n<td class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'>";

		if ($f_data['size'] == "s") { $f_css_width = "30%"; }
		elseif ($f_data['size'] == "m") { $f_css_width = "55%"; }
		else { $f_css_width = "80%"; }

$f_return .= ("<table style='width:$f_css_width;margin:auto'>
<tbody><tr>
<td style='text-align:center'><div class='pagecontent'><select name='$f_data[name]' id='$f_js_id'$f_required size='1' class='pagecontentselect'>");

		for ($f_i = $f_data['min'];$f_i < $f_data['max'];$f_i++) { $f_return .= (($f_i == $f_data['content']) ? "\n<option value='$f_i' selected='selected'>$f_i</option>" : "\n<option value='$f_i'>$f_i</option>"); }

$f_return .= ("\n</select><input id='{$f_js_id}i' type='range' min=\"$f_data[min]\" max=\"$f_data[max]\" value=\"$f_data[content]\" style='display:none' /></div><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'$f_js_id',min:$f_data[min],max:$f_data[max],name:'$f_data[name]}',type:'range' } });
djs_var.core_run_onload.push ({ func:'djs_load_functions',params: { file:'swg_formbuilder.php.js',block:'djs_formbuilder_select_change_size' } });
]]></script></td>
</tr></tbody>
</table>$f_js_helper</td>
</tr>");

		return $f_return;
	}

	//f// direct_output_formbuilder->entry_add_rcp_text ($f_data)
/**
	* Format and return XHTML for a text input field.
	*
	* @param  array $f_data Array containing information about the form field
	* @uses   direct_debug()
	* @uses   direct_output_control::js_helper()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_rcp_text ($f_data)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_rcp_text (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		$f_js_helper = ($f_data['helper_text'] ? "<br />\n<div class='pagecontent' style='font-size:10px'>".($direct_globals['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</div>" : "");

		if ($f_data['size'] == "s")
		{
			$f_width = 10;
			$f_css_width = "30%";
		}
		elseif ($f_data['size'] == "m")
		{
			$f_width = 18;
			$f_css_width = "55%";
		}
		else
		{
			$f_width = 26;
			$f_css_width = "80%";
		}

		$f_return = "<tr>\n<td class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><span class='pageextracontent' style='font-weight:bold'>";

		if ($f_data['required'])
		{
			$f_required = " required='required'";
			$f_return .= $direct_settings['swg_required_marker']." ";
		}
		else { $f_required = ""; }

$f_return .= ($f_data['title'].":</span></td>
<td class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'><div id='{$f_js_id}b'><input type='text' name='$f_data[name]' id='$f_js_id' value=\"$f_data[content]\"$f_required size='$f_width' class='pagecontentinputtextnpassword' style='width:$f_css_width' /><span id='{$f_js_id}_point' style='display:none'><!-- iPoint // --></span><script type='text/javascript'><![CDATA[
if (djs_formbuilder_rcp_setup_input ('$f_js_id','$f_css_width')) { djs_swgDOM_replace (\"<span class='pagecontent' style='font-size:10px'><br />\\n<a href=\\\"javascript:djs_formbuilder_rcp_activate('$f_js_id');\\\">".(direct_local_get ("formbuilder_rcp_activate","text"))."</a></span>\",'{$f_js_id}_point'); }
djs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'$f_js_id' } });
]]></script></div>$f_js_helper</td>
</tr>");

		return $f_return;
	}

	//f// direct_output_formbuilder->entry_add_rcp_textarea ($f_data)
/**
	* Format and return XHTML for a textarea input field.
	*
	* @param  array $f_data Array containing information about the form field
	* @uses   direct_debug()
	* @uses   direct_output_control::js_helper()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_rcp_textarea ($f_data)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_rcp_textarea (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		$f_js_helper = ($f_data['helper_text'] ? "<br />\n<div class='pagecontent' style='font-size:10px'>".($direct_globals['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</div>" : "");

		if ($f_data['size'] == "s") { $f_rows = 5; }
		elseif ($f_data['size'] == "m") { $f_rows = 10; }
		else { $f_rows = 20; }

		$f_return = "<tr>\n<td class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><span class='pageextracontent' style='font-weight:bold'>";

		if ($f_data['required'])
		{
			$f_required = " required='required'";
			$f_return .= $direct_settings['swg_required_marker']." ";
		}
		else { $f_required = ""; }

$f_return .= ($f_data['title'].":</span></td>
<td class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'><div id='{$f_js_id}b'><span id='{$f_js_id}_point1' style='display:none'><!-- iPoint // --></span><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_swgDOM_replace',params:{ data:\"<span class='pagecontent' style='font-size:10px'>[ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_js_id','-');\\\">-</a> ] [ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_js_id','5');\\\">".(direct_local_get ("formbuilder_size_small"))."</a> ] [ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_js_id','10');\\\">".(direct_local_get ("formbuilder_size_medium"))."</a> ] [ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_js_id','20');\\\">".(direct_local_get ("formbuilder_size_large"))."</a> ] [ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_js_id','+');\\\">+</a> ]<br />\\n</span>\",id:'{$f_js_id}_point1' } });
]]></script><textarea name='$f_data[name]' id='$f_js_id'$f_required cols='26' rows='$f_rows' class='pagecontenttextarea' style='width:80%'>$f_data[content]</textarea><span id='{$f_js_id}_point2' style='display:none'><!-- iPoint // --></span><script type='text/javascript'><![CDATA[
if (djs_formbuilder_rcp_setup_textarea ('$f_js_id','$f_rows')) { djs_swgDOM_replace (\"<span class='pagecontent' style='font-size:10px'><br />\\n<a href=\\\"javascript:djs_formbuilder_rcp_activate('$f_js_id');\\\">".(direct_local_get ("formbuilder_rcp_activate","text"))."</a></span>\",'{$f_js_id}_point2'); }
djs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'$f_js_id' } });
djs_var.core_run_onload.push ({ func:'djs_load_functions',params: { file:'swg_formbuilder.php.js',block:'djs_formbuilder_textarea_change_rows' } });
]]></script></div>$f_js_helper</td>
</tr>");

		return $f_return;
	}

	//f// direct_output_formbuilder->entry_add_select ($f_data)
/**
	* Format and return XHTML to create select options.
	*
	* @param  array $f_data Array containing information about the form field
	* @uses   direct_debug()
	* @uses   direct_output_control::js_helper()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_select ($f_data)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_select (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		$f_js_helper = ($f_data['helper_text'] ? "<br />\n<span style='font-size:8px'>&#0160;</span><br />\n<div class='pagecontent' style='font-size:10px'>".($direct_globals['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</div>" : "");

		if ($f_data['size'] == "s") { $f_rows = 1; }
		elseif ($f_data['size'] == "m") { $f_rows = 4; }
		else { $f_rows = 8; }

		$f_return = "<tr>\n<td class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><span class='pageextracontent' style='font-weight:bold'>";

		if ($f_data['required'])
		{
			$f_required = " required='required'";
			$f_return .= $direct_settings['swg_required_marker']." ";
		}
		else { $f_required = ""; }

		$f_return .= $f_data['title'].":</span></td>\n<td class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'>";

		if ($f_rows > 1)
		{
$f_return .= ("<span id='{$f_js_id}_point' style='display:none'><!-- iPoint // --></span><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_swgDOM_replace',params:{ data:\"<span class='pagecontent' style='font-size:10px'>[ <a href=\\\"javascript:djs_formbuilder_select_change_size('$f_js_id','-');\\\">-</a> ] [ <a href=\\\"javascript:djs_formbuilder_select_change_size('$f_js_id','1');\\\">".(direct_local_get ("formbuilder_size_small"))."</a> ] [ <a href=\\\"javascript:djs_formbuilder_select_change_size('$f_js_id','4');\\\">".(direct_local_get ("formbuilder_size_medium"))."</a> ] [ <a href=\\\"javascript:djs_formbuilder_select_change_size('$f_js_id','8');\\\">".(direct_local_get ("formbuilder_size_large"))."</a> ] [ <a href=\\\"javascript:djs_formbuilder_select_change_size('$f_js_id','+');\\\">+</a> ]<br />\\n</span>\",id:'{$f_js_id}_point' } });
]]></script>");
		}

$f_return .= ("<select name='$f_data[name]' id='$f_js_id'$f_required size='$f_rows' class='pagecontentselect'>$f_data[content]</select><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'$f_js_id' } });
djs_var.core_run_onload.push ({ func:'djs_load_functions',params: { file:'swg_formbuilder.php.js',block:'djs_formbuilder_select_change_size' } });
]]></script>$f_js_helper</td>
</tr>");

		return $f_return;
	}

	//f// direct_output_formbuilder->entry_add_spacer ($f_data)
/**
	* Format and return XHTML for a spacer.
	*
	* @param  array $f_data Array containing information about the form field
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_spacer ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_spacer (+f_data)- (#echo(__LINE__)#)"); }
		return "<tr>\n<td colspan='2' class='pagebg'><span style='font-size:8px'>&#0160;</span></td>\n</tr>";
	}

	//f// direct_output_formbuilder->entry_add_subtitle ($f_data)
/**
	* Add a title line (subtitle for the form).
	*
	* @param  array $f_data Array containing information about the form field
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_subtitle ($f_data)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_subtitle (+f_data)- (#echo(__LINE__)#)"); }

		return "<tr>\n<td colspan='2' class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding];text-align:center'><span class='pagetitlecellcontent'>$f_data[title]</span></td>\n</tr>";
	}

	//f// direct_output_formbuilder->entry_add_text ($f_data)
/**
	* Format and return XHTML for a text input field.
	*
	* @param  array $f_data Array containing information about the form field
	* @uses   direct_debug()
	* @uses   direct_output_control::js_helper()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_text ($f_data)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_text (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		$f_js_helper = ($f_data['helper_text'] ? "<br />\n<span style='font-size:8px'>&#0160;</span><br />\n<div class='pagecontent' style='font-size:10px'>".($direct_globals['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</div>" : "");

		if ($f_data['size'] == "s")
		{
			$f_width = 10;
			$f_css_width = "30%";
		}
		elseif ($f_data['size'] == "m")
		{
			$f_width = 18;
			$f_css_width = "55%";
		}
		else
		{
			$f_width = 26;
			$f_css_width = "80%";
		}

		$f_return = "<tr>\n<td class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><span class='pageextracontent' style='font-weight:bold'>";

		if ($f_data['required'])
		{
			$f_required = " required='required'";
			$f_return .= $direct_settings['swg_required_marker']." ";
		}
		else { $f_required = ""; }

$f_return .= ($f_data['title'].":</span></td>
<td class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'><input type='text' name='$f_data[name]' id='$f_js_id' value=\"$f_data[content]\"$f_required size='$f_width' class='pagecontentinputtextnpassword' style='width:$f_css_width' /><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'$f_js_id' } });
]]></script>$f_js_helper</td>
</tr>");

		return $f_return;
	}

	//f// direct_output_formbuilder->entry_add_textarea ($f_data)
/**
	* Format and return XHTML for a textarea input field.
	*
	* @param  array $f_data Array containing information about the form field
	* @uses   direct_debug()
	* @uses   direct_output_control::js_helper()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_textarea ($f_data)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_textarea (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		$f_js_helper = ($f_data['helper_text'] ? "<br />\n<span style='font-size:8px'>&#0160;</span><br />\n<div class='pagecontent' style='font-size:10px'>".($direct_globals['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</div>" : "");

		if ($f_data['size'] == "s") { $f_rows = 5; }
		elseif ($f_data['size'] == "m") { $f_rows = 10; }
		else { $f_rows = 20; }

		$f_return = "<tr>\n<td class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><span class='pageextracontent' style='font-weight:bold'>";

		if ($f_data['required'])
		{
			$f_required = " required='required'";
			$f_return .= $direct_settings['swg_required_marker']." ";
		}
		else { $f_required = ""; }

$f_return .= ($f_data['title'].":</span></td>
<td class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'><span id='{$f_js_id}_point' style='display:none'><!-- iPoint // --></span><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_swgDOM_replace',params:{ data:\"<span class='pagecontent' style='font-size:10px'>[ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_js_id','-');\\\">-</a> ] [ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_js_id','5');\\\">".(direct_local_get ("formbuilder_size_small"))."</a> ] [ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_js_id','10');\\\">".(direct_local_get ("formbuilder_size_medium"))."</a> ] [ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_js_id','20');\\\">".(direct_local_get ("formbuilder_size_large"))."</a> ] [ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_js_id','+');\\\">+</a> ]<br />\\n</span>\",id:'{$f_js_id}_point' } });
]]></script><textarea name='$f_data[name]' id='$f_js_id'$f_required cols='26' rows='$f_rows' class='pagecontenttextarea' style='width:80%'>$f_data[content]</textarea><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'$f_js_id' } });
djs_var.core_run_onload.push ({ func:'djs_load_functions',params: { file:'swg_formbuilder.php.js',block:'djs_formbuilder_textarea_change_rows' } });
]]></script>$f_js_helper</td>
</tr>");

		return $f_return;
	}

	//f// direct_output_formbuilder->form_get ($f_data,$f_form_id = NULL)
/**
	* Reads an array of form elements and calls the corresponding function to get
	* valid XHTML for output.
	*
	* @param  array $f_data Array containing information about form fields
	* @uses   direct_class_function_check()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function form_get ($f_data,$f_form_id = NULL)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->form_get (+f_data,+f_form_id)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
Add additional HTML headers
------------------------------------------------------------------------- */

		$direct_globals['output']->header_elements ("<script src='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_mmedia]/swg_formbuilder.php.js++dbid+".$direct_settings['product_buildid'],true,false))."' type='text/javascript'><!-- // FormBuilder javascript functions // --></script>");
		#if ($direct_settings['formbuilder_rcp_supported']) { $direct_globals['output']->header_elements ("<link rel='stylesheet' type='text/css' href='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+data/mmedia/swg_formbuilder_rcp.css",true,false))."' />"); }

		if (isset ($f_data['']))
		{
			if (count ($f_data) > 1)
			{
				if (!isset ($f_form_id)) { $f_form_id = uniqid ('swg_form_'); }
				$f_return = "<div id='{$f_form_id}_sections'>".($this->form_get_section ($f_data[''],(direct_local_get ("formbuilder_section_general"))));
			}
			else { $f_return = $this->form_get_section ($f_data['']); }

			unset ($f_data['']);
		}
		else { $f_return = ""; }

		if (!empty ($f_data))
		{
			if (!isset ($f_form_id)) { $f_form_id = uniqid ('swg_form_'); }

			if (!$f_return) { $f_return .= "<div id='{$f_form_id}_sections'>"; }
			foreach ($f_data as $f_section => $f_elements_array) { $f_return .= $this->form_get_section ($f_elements_array,$f_section); }
			$f_return .= "</div><script type='text/javascript'><![CDATA[\ndjs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'{$f_form_id}_sections',type:'form_sections' } });\n]]></script>";
		}

		return $f_return;
	}

	//f// direct_output_formbuilder->form_get_results ($f_data,$f_show_all = false,$f_types_hidden = NULL)
/**
	* Reads an array of form elements and calls the corresponding function to get
	* valid XHTML for output.
	*
	* @param  array $f_data Array containing information about form fields
	* @uses   direct_class_function_check()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function form_get_results ($f_data,$f_show_all = false,$f_types_hidden = NULL)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->form_get_results (+f_data,+f_show_all,+f_types_hidden)- (#echo(__LINE__)#)"); }

		$f_types_hidden = (isset ($f_types_hidden) ? array_merge (array ("hidden","info","subtitle"),$f_types_hidden) : array ("hidden","info","subtitle"));
		$f_return = "";
		$f_return_all = "";

		if (isset ($f_data['']))
		{
			$f_section_array = $f_data[''];
			unset ($f_data['']);
		}
		else { $f_section_array = array_shift ($f_data); }

		while ($f_section_array != NULL)
		{
			foreach ($f_section_array as $f_element_array)
			{
				if ((isset ($f_element_array['filter']))&&((direct_class_function_check ($direct_globals['output_formbuilder'],"entry_add_".$f_element_array['filter']))||(is_callable ($f_element_array['filter']))))
				{
					if ($f_return_all) { $f_return_all .= (($f_element_array['filter'] == "spacer") ? "</p>\n<p>" : "<br />\n"); }
					else { $f_return_all = "<p>"; }

					$f_return_all .= "<span style='font-weight:bold'>";
					if ($f_element_array['required']) { $f_return_all .= $direct_settings['swg_required_marker']." "; }
					$f_return_all .= $f_element_array['title'].":</span> ";

					if ((isset ($f_element_array['error']))&&($f_element_array['error']))
					{
						$f_return_all .= $f_element_array['error'];

						if (!$f_show_all)
						{
							if ($f_return) { $f_return .= (($f_element_array['filter'] == "spacer") ? "</p>\n<p>" : "<br />\n"); }
							else { $f_return = "<p>"; }

							$f_return .= "<span style='font-weight:bold'>{$f_element_array['title']}:</span> ".$f_element_array['error'];
						}
					}
					else { $f_return_all .= direct_local_get ("formbuilder_field_accepted"); }
				}
			}

			$f_section_array = array_shift ($f_data);
		}

		if (($f_return)&&(!$f_show_all)) { $f_return .= "</p>"; }
		elseif ($f_return_all) { $f_return = $f_return_all."</p>"; }
		else { $f_return .= direct_local_get ("core_unknown"); }

		return $f_return;
	}

	//f// direct_output_formbuilder->form_get_section ($f_data,$f_section = NULL)
/**
	* Reads an array of form elements and calls the corresponding function to get
	* valid XHTML for output.
	*
	* @param  array $f_data Array containing information about form fields
	* @uses   direct_class_function_check()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function form_get_section ($f_data,$f_section = NULL)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->form_get_section (+f_data,+f_section)- (#echo(__LINE__)#)"); }

		$f_return = (isset ($f_section) ? "<p class='pagecontenttitle ui-accordion-header'><a href='#swg_form_".(md5 ($f_section))."'>".(direct_html_encode_special ($f_section))."</a></p><div>" : "");

$f_return .= ("<table class='pageborder1' style='width:100%;table-layout:auto'>
<thead class='pagehide'><tr>
<td class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'><span class='pagetitlecellcontent'>".(direct_local_get ("formbuilder_field"))."</span></td>
<td class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'><span class='pagetitlecellcontent'>".(direct_local_get ("formbuilder_field_content"))."</span></td>
</tr></thead><tbody>");

		foreach ($f_data as $f_element_array)
		{
			$f_output = NULL;

			if (isset ($f_element_array['filter']))
			{
				if (direct_class_function_check ($direct_globals['output_formbuilder'],"entry_add_".$f_element_array['filter']))
				{
					$f_output_function = "entry_add_".$f_element_array['filter'];
					$f_output = $this->{$f_output_function} ($f_element_array);
				}
				elseif (is_callable ($f_element_array['filter'])) { $f_output = $f_element_array['filter'] ($f_element_array); }
			}

			if ($f_output)
			{
				if ($f_return) { $f_return .= "\n"; }
				$f_return .= $f_output;

				if ((isset ($f_element_array['error']))&&($f_element_array['error']))
				{
$f_return .= ("<tr>
<td colspan='2' class='pagebg' style='padding:5px;text-align:center'><span class='pageerrorcontent'>{$f_element_array['error']}</span></td>
</tr>");
				}
			}
			else
			{
$f_return .= ("<tr>
<td colspan='2' class='pagebg' style='padding:5px;text-align:center'><span class='pageerrorcontent'>".(direct_local_get ("formbuilder_error"))."</span></td>
</tr>");
			}
		}

		$f_return .= "</tbody>\n</table>";
		if (isset ($f_section)) { $f_return .= "</div>"; }
		return $f_return;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_globals['@names']['output_formbuilder'] = "direct_output_formbuilder";
define ("CLASS_direct_output_formbuilder",true);

//j// Script specific commands

if (!isset ($direct_cachedata['output_credits_information'])) { $direct_cachedata['output_credits_information'] = ""; }
if (!isset ($direct_cachedata['output_credits_payment_data'])) { $direct_cachedata['output_credits_payment_data'] = ""; }
$direct_settings['theme_css_corners'] = ((isset ($direct_settings['theme_css_corners_class'])) ? " ".$direct_settings['theme_css_corners_class'] : " ui-corner-all");
if (!isset ($direct_settings['theme_td_padding'])) { $direct_settings['theme_td_padding'] = "5px"; }
if (!isset ($direct_settings['theme_form_td_padding'])) { $direct_settings['theme_form_td_padding'] = "3px"; }
}

//j// EOF
?>