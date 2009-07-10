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
if (defined ("CLASS_direct_formbuilder")) { $g_continue_check = false; }
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
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->__construct (direct_formbuilder)- (#echo(__LINE__)#)"); }

		if (!defined ("CLASS_direct_formtags")) { $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_formtags.php",2); }
		if (!isset ($direct_classes['formtags'])) { direct_class_init ("formtags"); }
		direct_local_integration ("formbuilder");
		if ($direct_settings['formbuilder_jfield_supported']) { direct_local_integration ("formbuilder_jfield"); }

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
		$this->functions['entry_add_file_ftg'] = isset ($direct_classes['formtags']);
		$this->functions['entry_add_jfield_text'] = true;
		$this->functions['entry_add_jfield_textarea'] = true;
		$this->functions['entry_add_multiselect'] = true;
		$this->functions['entry_add_number'] = true;
		$this->functions['entry_add_password'] = true;
		$this->functions['entry_add_radio'] = true;
		$this->functions['entry_add_select'] = true;
		$this->functions['entry_add_text'] = true;
		$this->functions['entry_add_textarea'] = true;
		$this->functions['entry_check_length'] = true;
		$this->functions['entry_set_error'] = true;
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
	//f// direct_formbuilder->entry_add ($f_type,$f_name = "",$f_title = "",$f_required = false,$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
/**
	* Creates spacing fields like "hidden", "element", "info", "spacer" or "subtitle".
	*
	* @param  string $f_type Form field type
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  boolean $f_required True if the field is required to continue
	* @param  string $f_helper_text Contains a text that will be displayed to
	*         aid the user in filling out the field
	* @param  string $f_helper_url Links the whole help box to a given URL
	* @param  boolean $f_helper_closing True if the help window should be
	*         minimized after loading the page
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True if no error occured
	* @link   http://www.direct-netware.de/redirect.php?swg;handbooks;dev;formbuilder
	*         Click here to get a list of available form fields
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add ($f_type,$f_name = "",$f_title = "",$f_required = false,$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add ($f_type,$f_name,$f_title,+f_required,+f_helper_text,+f_helper_url,+f_helper_closing)- (#echo(__LINE__)#)"); }

		if (($f_type == "hidden")||($f_type == "element")||($f_type == "info")||($f_type == "spacer")||($f_type == "subtitle"))
		{
			$f_return = true;

			if (strlen ($f_name))
			{
				$f_form_id = md5 ("i_".$f_name);

$this->form_cache[$f_form_id] = array (
"type" => $f_type,
"name" => $f_name,
"title" => $f_title,
"required" => $f_required,
"helper_text" => $f_helper_text,
"helper_url" => $f_helper_url,
"helper_closing" => $f_helper_closing
);

				if (isset ($direct_cachedata["i_".$f_name])) { $this->form_cache[$f_form_id]['content'] = $direct_cachedata["i_".$f_name]; }
				else { $this->form_cache[$f_form_id]['content'] = ""; }
			}
			else
			{
$this->form_cache[] = array (
"type" => $f_type,
"name" => "",
"title" => $f_title,
"required" => $f_required,
"helper_text" => $f_helper_text,
"helper_url" => $f_helper_url,
"helper_closing" => $f_helper_closing
);
			}
		}
		else { $f_return = false; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_add_email ($f_name,$f_title,$f_required = false,$f_field_size = "m",$f_length_min = 0,$f_length_max = 0,$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
/**
	* A single line text input field for eMail addresses.
	*
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  boolean $f_required True if the field is required to continue
	* @param  string $f_field_size Size of the form field ("s", "m" or "l")
	* @param  integer $f_length_min Minimum characters required
	* @param  integer $f_length_max Maximum characters allowed
	* @param  string $f_helper_text Contains a text that will be displayed to
	*         aid the user in filling out the field
	* @param  string $f_helper_url Links the whole help box to a given URL
	* @param  boolean $f_helper_closing True if the help window should be
	*         minimized after loading the page
	* @uses   direct_basic_functions::inputfilter_email()
	* @uses   direct_debug()
	* @uses   direct_html_encode_special()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_email ($f_name,$f_title,$f_required = false,$f_field_size = "m",$f_length_min = 0,$f_length_max = 0,$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
	{
		global $direct_cachedata,$direct_classes;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_email ($f_name,$f_title,+f_required,$f_field_size,$f_length_min,$f_length_max,+f_helper_text,+f_helper_url,+f_helper_closing)- (#echo(__LINE__)#)"); }

		$f_error = $this->entry_check_size ($direct_cachedata["i_".$f_name],$f_length_min,$f_length_max,$f_required);
		$f_form_id = md5 ("i_".$f_name);

		if (strlen ($direct_cachedata["i_".$f_name]))
		{
			if (!strlen ($direct_classes['basic_functions']->inputfilter_email ($direct_cachedata["i_".$f_name]))) { $f_error = "format_invalid"; }
		}
		elseif ($f_required) { $f_error = "required_element"; }

$this->form_cache[$f_form_id] = array (
"type" => "text",
"name" => $f_name,
"title" => $f_title,
"required" => $f_required,
"size" => $f_field_size,
"helper_text" => $f_helper_text,
"helper_url" => $f_helper_url,
"helper_closing" => $f_helper_closing,
"content" => direct_html_encode_special ($direct_cachedata["i_".$f_name]),
"error" => $f_error
);

		if ($f_error) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_email ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_email ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_formbuilder->entry_add_embed ($f_name,$f_title,$f_required = false,$f_field_size = "m",$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
/**
	* Embeds external resources into the current form.
	*
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  boolean $f_required True if the field is required to continue
	* @param  string $f_field_size Size of the form field ("s", "m" or "l")
	* @param  string $f_url URL for the embedded resource
	* @param  string $f_helper_text Contains a text that will be displayed to
	*         aid the user in filling out the field
	* @param  string $f_helper_url Links the whole help box to a given URL
	* @param  boolean $f_helper_closing True if the help window should be
	*         minimized after loading the page
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean Currently always true
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_embed ($f_name,$f_title,$f_required = false,$f_url = "",$f_field_size = "m",$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_embed ($f_name,$f_title,+f_required,$f_field_size,*f_helper_text,+f_helper_url,+f_helper_closing)- (#echo(__LINE__)#)"); }

		$f_form_id = md5 ("i_".$f_name);

		if ($direct_cachedata["i_".$f_name]) { $f_embed_id = $direct_cachedata["i_".$f_name]; }
		else
		{
			$f_embed_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
			$direct_cachedata["i_".$f_name] = $f_embed_id;
			$direct_cachedata['formbuilder_element_counter']++;
		}

$this->form_cache[$f_form_id] = array (
"type" => "embed",
"name" => $f_name,
"title" => $f_title,
"required" => $f_required,
"size" => $f_field_size,
"helper_text" => $f_helper_text,
"helper_url" => $f_helper_url,
"helper_closing" => $f_helper_closing,
"content" => $f_url,
"id" => $f_embed_id
);

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_embed ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_add_file_ftg ($f_name,$f_title,$f_file_path,$f_field_size = "s")
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
	/*#ifndef(PHP4) */public /* #*/function entry_add_file_ftg ($f_name,$f_title,$f_file_path,$f_field_size = "s")
	{
		global $direct_classes;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_file_ftg ($f_name,$f_title,$f_file_path,$f_field_size)- (#echo(__LINE__)#)"); }

		$f_file_path = $direct_classes['basic_functions']->varfilter ($f_file_path,"settings");
		$f_form_id = md5 ("i_".$f_name);

		if (file_exists ($f_file_path))
		{
			$f_file_data = direct_file_get ("s",$f_file_path);
			$f_file_data = $direct_classes['formtags']->decode (str_replace ("\n","[newline]",$f_file_data));
		}
		else { $f_file_data = (direct_local_get ("formbuilder_error_file_not_found_1")).(direct_html_encode_special ($f_file_path)).(direct_local_get ("formbuilder_error_file_not_found_2")); }

$this->form_cache[$f_form_id] = array (
"type" => "file_ftg",
"name" => $f_name,
"title" => $f_title,
"required" => false,
"size" => $f_field_size,
"content" => $f_file_data
);

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_file_ftg ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_add_jfield_text ($f_name,$f_title,$f_required = false,$f_field_size = "m",$f_length_min = 0,$f_length_max = 0,$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
/**
	* A jfield enhanced text input field.
	*
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  boolean $f_required True if the field is required to continue
	* @param  string $f_field_size Size of the form field ("s", "m" or "l")
	* @param  integer $f_length_min Minimum characters required
	* @param  integer $f_length_max Maximum characters allowed
	* @param  string $f_helper_text Contains a text that will be displayed to
	*         aid the user in filling out the field
	* @param  string $f_helper_url Links the whole help box to a given URL
	* @param  boolean $f_helper_closing True if the help window should be
	*         minimized after loading the page
	* @uses   direct_debug()
	* @uses   direct_formbuilder::entry_add_text()
	* @uses   direct_formbuilder::entry_check_size()
	* @uses   direct_html_encode_special()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_jfield_text ($f_name,$f_title,$f_required = false,$f_field_size = "m",$f_length_min = 0,$f_length_max = 0,$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_jfield_text ($f_name,$f_title,+f_required,$f_field_size,$f_length_min,$f_length_max,+f_helper_text,+f_helper_url,+f_helper_closing)- (#echo(__LINE__)#)"); }

		if ($direct_settings['formbuilder_jfield_supported'])
		{
			$f_error = $this->entry_check_size ($direct_cachedata["i_".$f_name],$f_length_min,$f_length_max,$f_required);
			$f_form_id = md5 ("i_".$f_name);

			$direct_cachedata["i_".$f_name] = str_replace ("<br />","\n",$direct_cachedata["i_".$f_name]);
			$direct_cachedata["i_".$f_name] = str_replace ("[newline]","\n",$direct_cachedata["i_".$f_name]);
			$direct_cachedata["i_".$f_name] = str_replace ("&lt;","<",$direct_cachedata["i_".$f_name]);
			$direct_cachedata["i_".$f_name] = str_replace ("&gt;",">",$direct_cachedata["i_".$f_name]);

$this->form_cache[$f_form_id] = array (
"type" => "jfield_text",
"name" => $f_name,
"title" => $f_title,
"required" => $f_required,
"size" => $f_field_size,
"helper_text" => $f_helper_text,
"helper_url" => $f_helper_url,
"helper_closing" => $f_helper_closing,
"content" => direct_html_encode_special ($direct_cachedata["i_".$f_name]),
"error" => $f_error
);

			if ($f_error) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_jfield_text ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
			else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_jfield_text ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
		}
		else { return $this->entry_add_text ($f_name,$f_title,$f_required,$f_field_size,$f_length_min,$f_length_max,$f_helper_text,$f_helper_url,$f_helper_closing); }
	}

	//f// direct_formbuilder->entry_add_jfield_textarea ($f_name,$f_title,$f_required = false,$f_field_size = "m",$f_length_min = 0,$f_length_max = 0,$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
/**
	* A jfield enhanced textarea input field.
	*
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  boolean $f_required True if the field is required to continue
	* @param  string $f_field_size Size of the form field ("s", "m" or "l")
	* @param  integer $f_length_min Minimum characters required
	* @param  integer $f_length_max Maximum characters allowed
	* @param  string $f_helper_text Contains a text that will be displayed to
	*         aid the user in filling out the field
	* @param  string $f_helper_url Links the whole help box to a given URL
	* @param  boolean $f_helper_closing True if the help window should be
	*         minimized after loading the page
	* @uses   direct_debug()
	* @uses   direct_formbuilder::entry_add_textarea()
	* @uses   direct_formbuilder::entry_check_size()
	* @uses   direct_html_encode_special()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_jfield_textarea ($f_name,$f_title,$f_required = false,$f_field_size = "m",$f_length_min = 0,$f_length_max = 0,$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_jfield_textarea ($f_name,$f_title,+f_required,$f_field_size,$f_length_min,$f_length_max,+f_helper_text,+f_helper_url,+f_helper_closing)- (#echo(__LINE__)#)"); }

		if ($direct_settings['formbuilder_jfield_supported'])
		{
			$f_error = $this->entry_check_size ($direct_cachedata["i_".$f_name],$f_length_min,$f_length_max,$f_required);

			$direct_cachedata["i_".$f_name] = str_replace ("<br />","\n",$direct_cachedata["i_".$f_name]);
			$direct_cachedata["i_".$f_name] = str_replace ("[newline]","\n",$direct_cachedata["i_".$f_name]);
			$direct_cachedata["i_".$f_name] = str_replace ("&lt;","<",$direct_cachedata["i_".$f_name]);
			$direct_cachedata["i_".$f_name] = str_replace ("&gt;",">",$direct_cachedata["i_".$f_name]);

			$f_form_id = md5 ("i_".$f_name);

$this->form_cache[$f_form_id] = array (
"type" => "jfield_textarea",
"name" => $f_name,
"title" => $f_title,
"required" => $f_required,
"size" => $f_field_size,
"helper_text" => $f_helper_text,
"helper_url" => $f_helper_url,
"helper_closing" => $f_helper_closing,
"content" => direct_html_encode_special ($direct_cachedata["i_".$f_name]),
"error" => $f_error
);

			if ($f_error) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_jfield_textarea ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
			else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_jfield_textarea ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
		}
		else { return $this->entry_add_textarea ($f_name,$f_title,$f_required,$f_field_size,$f_length_min,$f_length_max,$f_helper_text,$f_helper_url,$f_helper_closing); }
	}

	//f// direct_formbuilder->entry_add_multiselect ($f_name,$f_title,$f_required = false,$f_field_size = "s",$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
/**
	* Inserts a selectbox for multiple selectable options.
	*
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  boolean $f_required True if the field is required to continue
	* @param  string $f_field_size Size of the form field ("s", "m" or "l")
	* @param  string $f_helper_text Contains a text that will be displayed to
	*         aid the user in filling out the field
	* @param  string $f_helper_url Links the whole help box to a given URL
	* @param  boolean $f_helper_closing True if the help window should be
	*         minimized after loading the page
	* @uses   direct_debug()
	* @uses   direct_html_encode_special()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_multiselect ($f_name,$f_title,$f_required = false,$f_field_size = "s",$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_multiselect ($f_name,$f_title,+f_required,$f_field_size,+f_helper_text,+f_helper_url,+f_helper_closing)- (#echo(__LINE__)#)"); }

		$f_choices_array = direct_evars_get ($direct_cachedata["i_".$f_name]);
		$direct_cachedata["i_".$f_name] = array ();
		$f_form_id = md5 ("i_".$f_name);
		$f_options = "";

		if (is_array ($f_choices_array))
		{
			foreach ($f_choices_array as $f_choice_array)
			{
				if ($f_options) { $f_options .= "\n"; }

				$f_choice_array['value'] = direct_html_encode_special ($f_choice_array['value']);
				$f_choice_array['text'] = str_replace ('"',"&quot;",$f_choice_array['text']);
				if (!strlen ($f_choice_array['text'])) { $f_choice_array['text'] = $f_choice_array['value']; }

				if (isset ($f_choice_array['selected']))
				{
					$direct_cachedata["i_".$f_name][] = $f_choice_array['value'];
					$f_options .= "<option value=\"{$f_choice_array['value']}\" selected='selected'>{$f_choice_array['text']}</option>";
				}
				else { $f_options .= "<option value=\"{$f_choice_array['value']}\">{$f_choice_array['text']}</option>"; }
			}
		}

		if (($f_required)&&(empty ($direct_cachedata["i_".$f_name]))) { $f_error = "required_element"; }
		else { $f_error = ""; }

$this->form_cache[$f_form_id] = array (
"type" => "multiselect",
"name" => $f_name,
"title" => $f_title,
"required" => $f_required,
"size" => $f_field_size,
"helper_text" => $f_helper_text,
"helper_url" => $f_helper_url,
"helper_closing" => $f_helper_closing,
"content" => $f_options,
"error" => $f_error
);

		if ($f_error) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_multiselect ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_multiselect ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_formbuilder->entry_add_number ($f_name,$f_title,$f_required = false,$f_field_size = "m",$f_number_min = 0,$f_number_max = 0,$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
/**
	* Number (integer) input mechanism
	*
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  boolean $f_required True if the field is required to continue
	* @param  string $f_field_size Size of the form field ("s", "m" or "l")
	* @param  integer $f_number_min Minimum number required
	* @param  integer $f_number_max Maximum number allowed
	* @param  string $f_helper_text Contains a text that will be displayed to
	*         aid the user in filling out the field
	* @param  string $f_helper_url Links the whole help box to a given URL
	* @param  boolean $f_helper_closing True if the help window should be
	*         minimized after loading the page
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_number ($f_name,$f_title,$f_required = false,$f_field_size = "m",$f_number_min = 0,$f_number_max = 0,$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_number ($f_name,$f_title,+f_required,$f_field_size,$f_number_min,$f_number_max,+f_helper_text,+f_helper_url,+f_helper_closing)- (#echo(__LINE__)#)"); }

		$direct_cachedata["i_".$f_name] = str_replace (" ","",$direct_cachedata["i_".$f_name]);
		$f_form_id = md5 ("i_".$f_name);
		$f_error = "";

		if (strlen ($direct_cachedata["i_".$f_name]))
		{
			if (preg_match ("#^(-|)(\d+)$#i",$direct_cachedata["i_".$f_name]))
			{
				if (($f_number_min)&&($f_number_min > $direct_cachedata["i_".$f_name])) { $f_error = "number_min|".$f_number_min; }
				elseif (($f_number_max)&&($f_number_max < $direct_cachedata["i_".$f_name])) { $f_error = "number_max|".$f_number_max; }
			}
			else { $f_error = "format_invalid"; }
		}
		elseif ($f_required) { $f_error = "required_element"; }

$this->form_cache[$f_form_id] = array (
"type" => "text",
"name" => $f_name,
"title" => $f_title,
"required" => $f_required,
"size" => $f_field_size,
"helper_text" => $f_helper_text,
"helper_url" => $f_helper_url,
"helper_closing" => $f_helper_closing,
"content" => $direct_cachedata["i_".$f_name],
"error" => $f_error
);

		if ($f_error) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_number ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_number ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_formbuilder->entry_add_password ($f_mode,$f_name,$f_title,$f_required = false,$f_field_size = "m",$f_length_min = 0,$f_length_max = 0,$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true,$f_bytemix = "")
/**
	* Insert passwords (including optional a repetition check)
	*
	* @param  string $f_mode Password and encryption mode
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  boolean $f_required True if the field is required to continue
	* @param  string $f_field_size Size of the form field ("s", "m" or "l")
	* @param  integer $f_length_min Minimum characters required
	* @param  integer $f_length_max Maximum characters allowed
	* @param  string $f_helper_text Contains a text that will be displayed to
	*         aid the user in filling out the field
	* @param  string $f_helper_url Links the whole help box to a given URL
	* @param  boolean $f_helper_closing True if the help window should be
	*         minimized after loading the page
	* @param  string $f_bytemix Bytemix to use for TMD5 (NULL for none)
	* @uses   direct_basic_functions::tmd5()
	* @uses   direct_debug()
	* @uses   direct_formbuilder::entry_check_size()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_password ($f_mode,$f_name,$f_title,$f_required = false,$f_field_size = "m",$f_length_min = 0,$f_length_max = 0,$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true,$f_bytemix = "")
	{
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_password ($f_name,$f_title,+f_required,$f_field_size,$f_length_min,$f_length_max,+f_helper_text,+f_helper_url,+f_helper_closing,+f_bytemix)- (#echo(__LINE__)#)"); }

		if ($f_bytemix === NULL) { $f_bytemix = ""; }
		elseif (!strlen ($f_bytemix)) { $f_bytemix = $direct_settings['account_password_bytemix']; }

		$f_error = $this->entry_check_size ($direct_cachedata["i_".$f_name],$f_length_min,$f_length_max,$f_required);
		$f_form_id = md5 ("i_".$f_name);

		if (($f_mode != "2")&&(strpos ($f_mode,"2_") === false)) { $f_output_mode = "password"; }
		else
		{
			if (isset ($direct_cachedata["i_{$f_name}_repetition"])) { $f_password_repetition = $direct_cachedata["i_{$f_name}_repetition"]; }
			elseif (isset ($GLOBALS["i_{$f_name}_repetition"])) { $f_password_repetition = $GLOBALS["i_{$f_name}_repetition"]; }
			else { $f_password_repetition = ""; }

			if ($direct_cachedata["i_".$f_name] != $f_password_repetition) { $f_error = "password_repetition"; }
			$f_output_mode = "password_2";
		}

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_mode,"tmd5") !== false) { $direct_cachedata["i_".$f_name] = $direct_classes['basic_functions']->tmd5 ($direct_cachedata["i_".$f_name],$f_bytemix); }
		elseif (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_mode,"md5") !== false) { $direct_cachedata["i_".$f_name] = md5 ($direct_cachedata["i_".$f_name]); }

$this->form_cache[$f_form_id] = array (
"type" => $f_output_mode,
"name" => $f_name,
"title" => $f_title,
"required" => $f_required,
"size" => $f_field_size,
"helper_text" => $f_helper_text,
"helper_url" => $f_helper_url,
"helper_closing" => $f_helper_closing,
"error" => $f_error
);

		if ($f_error) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_password ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_password ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_formbuilder->entry_add_radio ($f_name,$f_title,$f_required = false,$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
/**
	* Inserts radio fields for exact one selected option.
	*
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  boolean $f_required True if the field is required to continue
	* @param  string $f_helper_text Contains a text that will be displayed to
	*         aid the user in filling out the field
	* @param  string $f_helper_url Links the whole help box to a given URL
	* @param  boolean $f_helper_closing True if the help window should be
	*         minimized after loading the page
	* @uses   direct_debug()
	* @uses   direct_evars_get()
	* @uses   direct_html_encode_special()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_radio ($f_name,$f_title,$f_required = false,$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_radio ($f_name,$f_title,+f_required,$f_helper_text,+f_helper_url,+f_helper_closing)- (#echo(__LINE__)#)"); }

		$f_choices_array = direct_evars_get ($direct_cachedata["i_".$f_name]);
		$direct_cachedata["i_".$f_name] = "";
		$f_form_id = md5 ("i_".$f_name);
		$f_inputs = "";

		if (is_array ($f_choices_array))
		{
			foreach ($f_choices_array as $f_choice_array)
			{
				if ($f_inputs) { $f_inputs .= "<br />\n"; }
				$f_label_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
				$direct_cachedata['formbuilder_element_counter']++;

				$f_choice_array['value'] = direct_html_encode_special ($f_choice_array['value']);
				$f_choice_array['text'] = str_replace ('"',"&quot;",$f_choice_array['text']);
				if (!strlen ($f_choice_array['text'])) { $f_choice_array['text'] = $f_choice_array['value']; }

				if (isset ($f_choice_array['selected']))
				{
					$direct_cachedata["i_".$f_name] = $f_choice_array['value'];
					$f_inputs .= "<input type='radio' name='$f_name' value=\"{$f_choice_array['value']}\" id='$f_label_id' checked='checked' onfocus=\"djs_formbuilder_focused('$f_label_id');\" /><label for='$f_label_id'> {$f_choice_array['text']}</label>";
				}
				else { $f_inputs .= "<input type='radio' name='$f_name' value=\"{$f_choice_array['value']}\" id='$f_label_id' onfocus=\"djs_formbuilder_focused('$f_label_id');\" /><label for='$f_label_id'> {$f_choice_array['text']}</label>"; }

$f_inputs .= ("<script language='JavaScript1.5' type='text/javascript'><![CDATA[
djs_formbuilder_tabindex ('$f_label_id');
]]></script>");
			}
		}

		if (($f_required)&&(!strlen ($direct_cachedata["i_".$f_name]))) { $f_error = "required_element"; }
		else { $f_error = ""; }

$this->form_cache[$f_form_id] = array (
"type" => "radio",
"name" => $f_name,
"title" => $f_title,
"required" => $f_required,
"helper_text" => $f_helper_text,
"helper_url" => $f_helper_url,
"helper_closing" => $f_helper_closing,
"content" => $f_inputs,
"error" => $f_error
);

		if ($f_error) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_radio ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_radio ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_formbuilder->entry_add_select ($f_name,$f_title,$f_required = false,$f_field_size = "s",$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
/**
	* Inserts a selectbox for exact one selected option.
	*
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  boolean $f_required True if the field is required to continue
	* @param  string $f_field_size Size of the form field ("s", "m" or "l")
	* @param  string $f_helper_text Contains a text that will be displayed to
	*         aid the user in filling out the field
	* @param  string $f_helper_url Links the whole help box to a given URL
	* @param  boolean $f_helper_closing True if the help window should be
	*         minimized after loading the page
	* @uses   direct_debug()
	* @uses   direct_evars_get()
	* @uses   direct_html_encode_special()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_select ($f_name,$f_title,$f_required = false,$f_field_size = "s",$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_select ($f_name,$f_title,+f_required,$f_field_size,+f_helper_text,+f_helper_url,+f_helper_closing)- (#echo(__LINE__)#)"); }

		$f_choices_array = direct_evars_get ($direct_cachedata["i_".$f_name]);
		$direct_cachedata["i_".$f_name] = "";
		$f_form_id = md5 ("i_".$f_name);
		$f_options = "";

		if (is_array ($f_choices_array))
		{
			foreach ($f_choices_array as $f_choice_array)
			{
				if ($f_options) { $f_options .= "\n"; }

				$f_choice_array['value'] = direct_html_encode_special ($f_choice_array['value']);
				$f_choice_array['text'] = str_replace ('"',"&quot;",$f_choice_array['text']);
				if (!strlen ($f_choice_array['text'])) { $f_choice_array['text'] = $f_choice_array['value']; }

				if (isset ($f_choice_array['selected']))
				{
					$direct_cachedata["i_".$f_name] = $f_choice_array['value'];
					$f_options .= "<option value=\"{$f_choice_array['value']}\" selected='selected'>{$f_choice_array['text']}</option>";
				}
				else { $f_options .= "<option value=\"{$f_choice_array['value']}\">{$f_choice_array['text']}</option>"; }
			}
		}

		if (($f_required)&&(!strlen ($direct_cachedata["i_".$f_name]))) { $f_error = "required_element"; }
		else { $f_error = ""; }

$this->form_cache[$f_form_id] = array (
"type" => "select",
"name" => $f_name,
"title" => $f_title,
"required" => $f_required,
"size" => $f_field_size,
"helper_text" => $f_helper_text,
"helper_url" => $f_helper_url,
"helper_closing" => $f_helper_closing,
"content" => $f_options,
"error" => $f_error
);

		if ($f_error) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_select ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_select ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_formbuilder->entry_add_text ($f_name,$f_title,$f_required = false,$f_field_size = "m",$f_length_min = 0,$f_length_max = 0,$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
/**
	* A single line text input field.
	*
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  boolean $f_required True if the field is required to continue
	* @param  string $f_field_size Size of the form field ("s", "m" or "l")
	* @param  integer $f_length_min Minimum characters required
	* @param  integer $f_length_max Maximum characters allowed
	* @param  string $f_helper_text Contains a text that will be displayed to
	*         aid the user in filling out the field
	* @param  string $f_helper_url Links the whole help box to a given URL
	* @param  boolean $f_helper_closing True if the help window should be
	*         minimized after loading the page
	* @uses   direct_debug()
	* @uses   direct_formbuilder::entry_check_size()
	* @uses   direct_html_encode_special()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_text ($f_name,$f_title,$f_required = false,$f_field_size = "m",$f_length_min = 0,$f_length_max = 0,$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_text ($f_name,$f_title,+f_required,$f_field_size,$f_length_min,$f_length_max,+f_helper_text,+f_helper_url,+f_helper_closing)- (#echo(__LINE__)#)"); }

		$f_error = $this->entry_check_size ($direct_cachedata["i_".$f_name],$f_length_min,$f_length_max,$f_required);
		$f_form_id = md5 ("i_".$f_name);

		$direct_cachedata["i_".$f_name] = str_replace ("<br />","\n",$direct_cachedata["i_".$f_name]);
		$direct_cachedata["i_".$f_name] = str_replace ("[newline]","\n",$direct_cachedata["i_".$f_name]);
		$direct_cachedata["i_".$f_name] = str_replace ("&lt;","<",$direct_cachedata["i_".$f_name]);
		$direct_cachedata["i_".$f_name] = str_replace ("&gt;",">",$direct_cachedata["i_".$f_name]);

$this->form_cache[$f_form_id] = array (
"type" => "text",
"name" => $f_name,
"title" => $f_title,
"required" => $f_required,
"size" => $f_field_size,
"helper_text" => $f_helper_text,
"helper_url" => $f_helper_url,
"helper_closing" => $f_helper_closing,
"content" => direct_html_encode_special ($direct_cachedata["i_".$f_name]),
"error" => $f_error
);

		if ($f_error) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_text ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_text ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_formbuilder->entry_add_textarea ($f_name,$f_title,$f_required = false,$f_field_size = "m",$f_length_min = 0,$f_length_max = 0,$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
/**
	* A standard textarea input field.
	*
	* @param  string $f_name Internal name of the form field
	* @param  string $f_title Public title for the form field
	* @param  boolean $f_required True if the field is required to continue
	* @param  string $f_field_size Size of the form field ("s", "m" or "l")
	* @param  integer $f_length_min Minimum characters required
	* @param  integer $f_length_max Maximum characters allowed
	* @param  string $f_helper_text Contains a text that will be displayed to
	*         aid the user in filling out the field
	* @param  string $f_helper_url Links the whole help box to a given URL
	* @param  boolean $f_helper_closing True if the help window should be
	*         minimized after loading the page
	* @uses   direct_debug()
	* @uses   direct_formbuilder::entry_check_size()
	* @uses   direct_html_encode_special()
	* @uses   USE_debug_reporting
	* @return boolean False if the content was not accepted
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_textarea ($f_name,$f_title,$f_required = false,$f_field_size = "m",$f_length_min = 0,$f_length_max = 0,$f_helper_text = "",$f_helper_url = "",$f_helper_closing = true)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_textarea ($f_name,$f_title,+f_required,$f_field_size,$f_length_min,$f_length_max,+f_helper_text,+f_helper_url,+f_helper_closing)- (#echo(__LINE__)#)"); }

		$f_error = $this->entry_check_size ($direct_cachedata["i_".$f_name],$f_length_min,$f_length_max,$f_required);
		$f_form_id = md5 ("i_".$f_name);

		$direct_cachedata["i_".$f_name] = str_replace ("<br />","\n",$direct_cachedata["i_".$f_name]);
		$direct_cachedata["i_".$f_name] = str_replace ("[newline]","\n",$direct_cachedata["i_".$f_name]);
		$direct_cachedata["i_".$f_name] = str_replace ("&lt;","<",$direct_cachedata["i_".$f_name]);
		$direct_cachedata["i_".$f_name] = str_replace ("&gt;",">",$direct_cachedata["i_".$f_name]);

$this->form_cache[$f_form_id] = array (
"type" => "textarea",
"name" => $f_name,
"title" => $f_title,
"required" => $f_required,
"size" => $f_field_size,
"helper_text" => $f_helper_text,
"helper_url" => $f_helper_url,
"helper_closing" => $f_helper_closing,
"content" => direct_html_encode_special ($direct_cachedata["i_".$f_name]),
"error" => $f_error
);

		if ($f_error) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_textarea ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_add_textarea ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_formbuilder->entry_check_size ($f_data,$f_length_min = 0,$f_length_max = 0,$f_required = false)
/**
	* Checks the size for a given string.
	*
	* @param  string $f_data The string that should be checked
	* @param  integer $f_length_min Defines the minimal length for a string or 0
	*         to ignore
	* @param  integer $f_length_max Defines the maximal length for a string or 0
	*         for an unlimited size
	* @param  boolean $f_required True if the field is required to continue
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if a required field is empty, it is smaller than
	*         the minimum or larger than the maximum
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_check_size ($f_data,$f_length_min = 0,$f_length_max = 0,$f_required = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_check_size (+f_data,$f_length_min,$f_length_max)- (#echo(__LINE__)#)"); }

		$f_return = "";

		if (($f_required)&&(!$f_data)) { $f_return = "required_element"; }
		elseif (($f_data)&&($f_length_min)&&($f_length_min > (strlen ($f_data)))) { $f_return = "string_min|".$f_length_min; }
		elseif (($f_length_max)&&($f_length_max < (strlen ($f_data)))) { $f_return = "string_max|".$f_length_max; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_check_size ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->entry_set_error ($f_name,$f_error)
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
	/*#ifndef(PHP4) */public /* #*/function entry_set_error ($f_name,$f_error)
	{
		global $direct_cachedata,$direct_classes;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_set_error ($f_name,$f_error)- (#echo(__LINE__)#)"); }

		$f_form_id = md5 ("i_".$f_name);
		$f_return = isset ($this->form_cache[$f_form_id]);
		if ($f_return) { $this->form_cache[$f_form_id]['error'] = $f_error; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->entry_set_error ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
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
			$this->check_result = true;

			foreach ($this->form_cache as $f_form_id => $f_element_array)
			{
				if (($f_check)&&(isset ($f_element_array['error']))&&($f_element_array['error']))
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

				$f_return[$f_form_id] = $f_element_array;
			}

			$this->form_cache = array ();
		}

		return $f_return;
	}

	//f// direct_formbuilder->xml_form (&$f_xml)
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
	/*#ifndef(PHP4) */public /* #*/function xml_form (&$f_xml)
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->xml_form (+f_xml)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (is_string ($f_xml)) { $f_xml_array = $direct_classes['xml_bridge']->xml2array ($f_xml,true,false); }
		elseif (is_array ($f_xml)) { $f_xml_array =& $f_xml; }

		if ((is_array ($f_xml_array))&&(isset ($f_xml_array['fields']['xml.item'])))
		{
			$f_return = true;

			if (isset ($f_xml_array['fields']['field']['xml.mtree']))
			{
				$f_xml_array = $f_xml_array['fields']['field'];
				unset ($f_xml_array['xml.mtree']);
			}
			else
			{
				$f_xml_array = $f_xml_array['fields'];
				unset ($f_xml_array['xml.item']);
			}
		}

		if (is_array ($f_xml_array))
		{
			foreach ($f_xml_array as $f_xml_node_array)
			{
				if ($f_return)
				{
					if (isset ($f_xml_node_array['xml.item']))
					{
						$f_xml_translation_array = $f_xml_node_array;
						$f_xml_node_array = $f_xml_node_array['xml.item'];
					}
					else { $f_xml_translation_array = array (); }

					if (isset ($f_xml_node_array['value']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_xml_node_array['attributes']['type']))
					{
						if (isset ($f_xml_node_array['attributes']['value_translation'])) { $f_xml_node_array['value'] = direct_local_get_xml_translation ($f_xml_translation_array,"title",true,$direct_settings['lang']); }
						else { $f_xml_node_array['value'] = $f_xml_node_array['value']; }

						if (!isset ($f_xml_node_array['attributes']['required'])) { $f_xml_node_array['attributes']['required'] = false; }
						if (!isset ($f_xml_node_array['attributes']['field_size'])) { $f_xml_node_array['attributes']['field_size'] = "m"; }
						if (!isset ($f_xml_node_array['attributes']['min'])) { $f_xml_node_array['attributes']['min'] = 0; }
						if (!isset ($f_xml_node_array['attributes']['max'])) { $f_xml_node_array['attributes']['max'] = 0; }

						if (isset ($f_xml_node_array['attributes']['helper_translation'])) { $f_xml_node_array['attributes']['helper_text'] = direct_local_get_xml_translation ($f_xml_translation_array,"helper_text",true,$direct_settings['lang']); }
						elseif (isset ($f_xml_node_array['attributes']['helper_text'])) { $f_xml_node_array['attributes']['helper_text'] = direct_local_get ($f_xml_node_array['attributes']['helper_text']); }
						else { $f_xml_node_array['attributes']['helper_text'] = ""; }

						if (!isset ($f_xml_node_array['attributes']['helper_url'])) { $f_xml_node_array['attributes']['helper_url'] = ""; }

						if ((!isset ($f_xml_node_array['attributes']['helper_closing']))||($f_xml_node_array['attributes']['helper_closing'])) { $f_xml_node_array['attributes']['helper_closing'] = true; }
						else { $f_xml_node_array['attributes']['helper_closing'] = false; }

						$f_return = $this->xml_form_entry ($f_xml_node_array,$f_xml_translation_array);
					}
					else { $f_return = false; }
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->xml_form ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_formbuilder->xml_form_entry (&$f_xml_node_array,&$f_xml_translation_array)
/**
	* Checks a XML form entry definition and calls the corresponding method.
	*
	* @param  array &$f_xml_node_array XML form entry
	* @param  array &$f_xml_translation_array Array containing possible translation
	*         entries
	* @uses   direct_debug()
	* @uses   direct_local_get()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function xml_form_entry (&$f_xml_node_array,&$f_xml_translation_array)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formbuilder_class->xml_form_entry (+f_xml_node_array,+f_xml_translation_array)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if ((is_array ($f_xml_node_array))&&(is_array ($f_xml_translation_array)))
		{
			$f_formbuilder_function = "";
			$f_formbuilder_function_type = 1;
			$f_return = true;

			switch ($f_xml_node_array['attributes']['type'])
			{
			case "element":
			{
				if (isset ($f_xml_node_array['attributes']['name']))
				{
					$f_value = direct_local_get_xml_translation ($f_xml_translation_array,"data",true,$direct_settings['lang']);

					if (strlen ($f_value))
					{
						$direct_cachedata["i_".$f_xml_node_array['attributes']['name']] = $f_value;
						$this->entry_add ("element",$f_xml_node_array['attributes']['name'],$f_xml_node_array['value'],$f_xml_node_array['attributes']['required'],$f_xml_node_array['attributes']['helper_text'],$f_xml_node_array['attributes']['helper_url'],$f_xml_node_array['attributes']['helper_closing']);
					}
				}
				else { $f_return = false; }

				break 1;
			}
			case "email":
			{
				$f_formbuilder_function = "entry_add_email";
				break 1;
			}
			case "hidden":
			{
				if (isset ($f_xml_node_array['attributes']['name']))
				{
					$f_value = direct_local_get_xml_translation ($f_xml_translation_array,"content",true,$direct_settings['lang']);

					if (strlen ($f_value))
					{
						$direct_cachedata["i_".$f_xml_node_array['attributes']['name']] = $f_value;
						$this->entry_add ("hidden",$f_xml_node_array['attributes']['name'],$f_xml_node_array['value']);
					}
				}
				else { $f_return = false; }

				break 1;
			}
			case "info":
			{
				if (isset ($f_xml_node_array['attributes']['name']))
				{
					$f_value = direct_local_get_xml_translation ($f_xml_translation_array,"content",true,$direct_settings['lang']);

					if (strlen ($f_value))
					{
						$direct_cachedata["i_".$f_xml_node_array['attributes']['name']] = $f_value;
						$this->entry_add ("element",$f_xml_node_array['attributes']['name'],$f_xml_node_array['value'],$f_xml_node_array['attributes']['required'],$f_xml_node_array['attributes']['helper_text'],$f_xml_node_array['attributes']['helper_url'],$f_xml_node_array['attributes']['helper_closing']);
					}
				}
				else { $f_return = false; }

				break 1;
			}
			case "file_ftg":
			{
				if (isset ($f_xml_node_array['attributes']['name']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_xml_node_array['attributes']['file'])) { $this->entry_add_file_ftg ($f_xml_node_array['attributes']['name'],$f_xml_node_array['value'],$f_xml_node_array['attributes']['file'],$f_xml_node_array['attributes']['field_size']); }
				else { $f_return = false; }

				break 1;
			}
			case "jfield_text":
			{
				$f_formbuilder_function = "entry_add_jfield_text";
				break 1;
			}
			case "jfield_textarea":
			{
				$f_formbuilder_function = "entry_add_jfield_textarea";
				break 1;
			}
			case "multiselect":
			{
				$f_formbuilder_function = "entry_add_multiselect";
				$f_formbuilder_function_type = 2;
				break 1;
			}
			case "number":
			{
				$f_formbuilder_function = "entry_add_number";
				break 1;
			}
			case "password":
			{
				if (isset ($f_xml_node_array['attributes']['name']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_xml_node_array['attributes']['mode']))
				{
					if (!isset ($f_xml_node_array['attributes']['bytemix'])) { $f_xml_node_array['attributes']['bytemix'] = NULL; }
					$this->entry_add_password ($f_xml_node_array['attributes']['mode'],$f_xml_node_array['attributes']['name'],$f_xml_node_array['value'],$f_xml_node_array['attributes']['required'],$f_xml_node_array['attributes']['field_size'],$f_xml_node_array['attributes']['min'],$f_xml_node_array['attributes']['max'],$f_xml_node_array['attributes']['helper_text'],$f_xml_node_array['attributes']['helper_url'],$f_xml_node_array['attributes']['helper_closing'],$f_xml_node_array['attributes']['bytemix']);
				}
				else { $f_return = false; }

				break 1;
			}
			case "radio":
			{
				$f_formbuilder_function = "entry_add_radio";
				$f_formbuilder_function_type = 3;
				break 1;
			}
			case "select":
			{
				$f_formbuilder_function = "entry_add_select";
				$f_formbuilder_function_type = 2;
				break 1;
			}
			case "text":
			{
				$f_formbuilder_function = "entry_add_text";
				break 1;
			}
			case "textarea":
			{
				$f_formbuilder_function = "entry_add_textarea";
				break 1;
			}
			default: { $f_return = false; }
			}

			if ($f_formbuilder_function)
			{
				if (isset ($direct_cachedata["i_".$f_xml_node_array['attributes']['name']]))
				{
					if ($f_formbuilder_function_type > 1)
					{
						$f_value = direct_local_get_xml_translation ($f_xml_translation_array,"predefined",true,$direct_settings['lang']);
						$direct_cachedata["i_".$f_xml_node_array['attributes']['name']] = str_replace ("'","",$direct_cachedata["i_".$f_xml_node_array['attributes']['name']]);
						$direct_cachedata["i_".$f_xml_node_array['attributes']['name']] = str_replace ((array ("<selected value='1' />","<value value='".$direct_cachedata["i_".$f_xml_node_array['attributes']['name']]."' />")),(array ("","<value value='".$direct_cachedata["i_".$f_xml_node_array['attributes']['name']]."' /><selected value='1' />")),$f_value);
					}
				}
				else
				{
					$f_value = direct_local_get_xml_translation ($f_xml_translation_array,"predefined",true,$direct_settings['lang']);
					if (strlen ($f_value)) { $direct_cachedata["i_".$f_xml_node_array['attributes']['name']] = $f_value; }
				}

				if (isset ($f_xml_node_array['attributes']['name']))
				{
					if ($f_formbuilder_function_type == 3) { $this->{$f_formbuilder_function} ($f_xml_node_array['attributes']['name'],$f_xml_node_array['value'],$f_xml_node_array['attributes']['required'],$f_xml_node_array['attributes']['helper_text'],$f_xml_node_array['attributes']['helper_url'],$f_xml_node_array['attributes']['helper_closing']); }
					elseif ($f_formbuilder_function_type == 2) { $this->{$f_formbuilder_function} ($f_xml_node_array['attributes']['name'],$f_xml_node_array['value'],$f_xml_node_array['attributes']['required'],$f_xml_node_array['attributes']['field_size'],$f_xml_node_array['attributes']['helper_text'],$f_xml_node_array['attributes']['helper_url'],$f_xml_node_array['attributes']['helper_closing']); }
					else { $this->{$f_formbuilder_function} ($f_xml_node_array['attributes']['name'],$f_xml_node_array['value'],$f_xml_node_array['attributes']['required'],$f_xml_node_array['attributes']['field_size'],$f_xml_node_array['attributes']['min'],$f_xml_node_array['attributes']['max'],$f_xml_node_array['attributes']['helper_text'],$f_xml_node_array['attributes']['helper_url'],$f_xml_node_array['attributes']['helper_closing']); }
				}
				else { $f_return = false; }
			}
		}
		else { $f_return = false; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -formbuilder_class->xml_form_entry ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_classes['@names']['formbuilder'] = "direct_formbuilder";
define ("CLASS_direct_formbuilder",true);

if (!isset ($direct_cachedata['formbuilder_element_counter'])) { $direct_cachedata['formbuilder_element_counter'] = 0; }
if (!isset ($direct_settings['account_password_bytemix'])) { $direct_settings['account_password_bytemix'] = ($direct_settings['swg_id'] ^ (strrev ($direct_settings['swg_id']))); }
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
		$this->functions['entry_add_jfield_text'] = true;
		$this->functions['entry_add_jfield_textarea'] = true;
		$this->functions['entry_add_multiselect'] = true;
		$this->functions['entry_add_password'] = true;
		$this->functions['entry_add_password_2'] = true;
		$this->functions['entry_add_radio'] = true;
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
	* @uses   USE_debug_reporting
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entry_add_element ($f_data)
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_element (+f_data)- (#echo(__LINE__)#)"); }

		$f_return = "";

		if (!$f_data['title'])
		{
			if ($f_data['helper_text']) { $f_js_helper = "<br />\n<span style='font-size:8px'>&#0160;</span><br />\n".($direct_classes['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing'])); }
			else { $f_js_helper = ""; }

$f_return .= ("<tr>
<td colspan='2' align='center' class='pagebg' style='padding:$direct_settings[theme_form_td_padding]'>
<table cellspacing='0' summary=''>
<tbody><tr>
<td align='left'><div class='pagecontent'>$f_data[content]</div></td>
</tr></tbody>
</table>$f_js_helper</td>
</tr>");
		}
		else
		{
			if (strlen ($f_data['content']))
			{
				if ($f_data['helper_text']) { $f_js_helper = "<span style='font-size:8px'>&#0160;</span><br />\n".($direct_classes['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing'])); }
				else { $f_js_helper = ""; }

				$f_return .= "<tr>";

				if ($f_data['title'] == "-") { $f_return .= "\n<td valign='top' align='right' class='pageextrabg' style='width:25%'><span style='font-size:8px'>&#0160;</span></td>"; }
				else
				{
					$f_return .= "\n<td valign='top' align='right' class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding]'><span class='pageextracontent' style='font-weight:bold'>";
					if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }
					$f_return .= $f_data['title'].":</span></td>";
				}

$f_return .= ("\n<td valign='middle' align='center' class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding]'>
<table cellspacing='0' summary=''>
<tbody><tr>
<td align='left'><div class='pagecontent'>$f_data[content]</div></td>
</tr></tbody>
</table>$f_js_helper</td>
</tr>");
			}
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
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_embed (+f_data)- (#echo(__LINE__)#)"); }

		$f_embed_url_ajax = direct_linker ("url0",$f_data['content']."tid+{$f_data['id']}++dtheme+0",false);
		$f_embed_url_ajax_url0 = addslashes (direct_linker ("url0","[f_url]",false));
		$f_embed_url_iframe = direct_linker ("url0",$f_data['content']."tid+{$f_data['id']}++dtheme+2");
		$f_embed_url_error = direct_linker ("url0",$f_data['content']."tid+{$f_data['id']}++dtheme+1");

		if ($f_data['size'] == "s") { $f_height = 230; }
		elseif ($f_data['size'] == "m") { $f_height = 315; }
		else { $f_height = 400; }

		$f_css_values = ";height:{$f_height}px;overflow:auto";

		if ($f_data['helper_text']) { $f_js_helper = "<p class='pagecontent' style='font-size:8px'>".($direct_classes['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</p>"; }
		else { $f_js_helper = ""; }

		$f_return = "<tr>\n<td valign='top' align='right' class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding]'><span class='pageextracontent' style='font-weight:bold'>";
		if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }

$f_return .= ($f_data['title'].":</span></td>
<td valign='middle' align='center' class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding]'><div id='swgAJAX_formbuilder_embed_{$f_data['id']}_point'><span id='swg_formbuilder_{$f_data['id']}_point1' style='display:none'><!-- iPoint // --></span><script language='JavaScript1.5' type='text/javascript'><![CDATA[
if (!djs_swgAJAX) { djs_swgDOM_replace (\"<span class='pagecontent' style='font-size:10px'>[ <a href=\\\"javascript:djs_formbuilder_iframe_change_height('swg_formbuilder_$f_data[id]','-');\\\">-</a> ] [ <a href=\\\"javascript:djs_formbuilder_iframe_change_height('swg_formbuilder_$f_data[id]','230');\\\">230</a> ] [ <a href=\\\"javascript:djs_formbuilder_iframe_change_height('swg_formbuilder_$f_data[id]','315');\\\">315</a> ] [ <a href=\\\"javascript:djs_formbuilder_iframe_change_height('swg_formbuilder_$f_data[id]','400');\\\">400</a> ] [ <a href=\\\"javascript:djs_formbuilder_iframe_change_height('swg_formbuilder_$f_data[id]','+');\\\">+</a> ]<br />\\n</span>\",'swg_formbuilder_{$f_data['id']}_point'); }
]]></script><iframe src='$f_embed_url_iframe' id='swg_formbuilder_$f_data[id]' width='100%' height='$f_height' frameborder='0' scrolling='auto'><span class='pagecontent' style='font-weight:bold'>".(direct_local_get ("formbuilder_embed_unsupported_1"))."<a href='$f_embed_url_error' target='_blank'>".(direct_local_get ("formbuilder_embed_unsupported_2"))."</a>".(direct_local_get ("formbuilder_embed_unsupported_3"))."</span></iframe></div><input type='hidden' name='$f_data[name]' value='$f_data[id]' /><script language='JavaScript1.5' type='text/javascript'><![CDATA[
if ((djs_swgAJAX)&&(djs_swgDOM))
{
	function djs_dataport_{$f_data['id']}_call_url0 (f_url) { djs_swgAJAX_call ('formbuilder_embed_{$f_data['id']}_point',djs_formbuilder_embed_{$f_data['id']}_response,'GET',('$f_embed_url_ajax_url0'.replace (/\[f_url\]/g,f_url)),5000); }
	function djs_formbuilder_embed_{$f_data['id']}_call () { djs_swgAJAX_call ('formbuilder_embed_{$f_data['id']}_point',djs_formbuilder_embed_{$f_data['id']}_response,'GET','$f_embed_url_ajax',5000); }
	function djs_formbuilder_embed_{$f_data['id']}_response () { djs_swgAJAX_response_ripoint ('formbuilder_embed_{$f_data['id']}_point','swgAJAX_formbuilder_embed_{$f_data['id']}_point2',''); }\n\n");

	if ($f_data['size'] == "l") { $f_return .= "	djs_swgDOM_replace (\"<p id='swgAJAX_formbuilder_embed_{$f_data['id']}_point2' class='pagecontent'>".(direct_local_get ("core_loading","text"))."</p>\",'swgAJAX_formbuilder_embed_{$f_data['id']}_point');"; }
	else { $f_return .= "	djs_swgDOM_replace (\"<div><p class='pagecontent' style='font-size:10px'>[ <a href=\\\"javascript:djs_swgDOM_css_change_px('swgAJAX_formbuilder_embed_{$f_data['id']}_point1','height','-');\\\">-</a> ] [ <a href=\\\"javascript:djs_swgDOM_css_change_px('swgAJAX_formbuilder_embed_{$f_data['id']}_point1','height','230');\\\">230</a> ] [ <a href=\\\"javascript:djs_swgDOM_css_change_px('swgAJAX_formbuilder_embed_{$f_data['id']}_point1','height','315');\\\">315</a> ] [ <a href=\\\"javascript:djs_swgDOM_css_change_px('swgAJAX_formbuilder_embed_{$f_data['id']}_point1','height','400');\\\">400</a> ] [ <a href=\\\"javascript:djs_swgDOM_css_change_px('swgAJAX_formbuilder_embed_{$f_data['id']}_point1','height','+');\\\">+</a> ]</p><div id='swgAJAX_formbuilder_embed_{$f_data['id']}_point1' class='pagecontent' style='margin:auto;padding:1px 5px$f_css_values'><p id='swgAJAX_formbuilder_embed_{$f_data['id']}_point2' class='pagecontent'>".(direct_local_get ("core_loading","text"))."</p></div></div>\",'swgAJAX_formbuilder_embed_{$f_data['id']}_point');"; }

$f_return .= ("\n	djs_var['core_run_onload'].push ('djs_formbuilder_embed_{$f_data['id']}_call ()');
}
]]></script>$f_js_helper</td>
</tr>");

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
			if (strlen ($f_data['content']) > 575) { $f_css_values = ";height:275px;overflow:auto"; }
		}
		elseif ($f_data['size'] == "m")
		{
			if (strlen ($f_data['content']) > 675) { $f_css_values = ";height:320px;overflow:auto"; }
		}
		else
		{
			if (strlen ($f_data['content']) > 825) { $f_css_values = ";height:400px;overflow:auto"; }
		}

$f_return = ("<tr>
<td valign='top' align='right' class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding]'><span class='pageextracontent' style='font-weight:bold'>$f_data[title]:</span></td>
<td valign='middle' align='left' class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding]'><div class='pagecontent' style='margin:auto;padding:1px 5px$f_css_values'>$f_data[content]</div></td>
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
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_info (+f_data)- (#echo(__LINE__)#)"); }

		$f_return = "";

		if (!$f_data['title'])
		{
			if ($f_data['helper_text']) { $f_js_helper = "<br />\n<span style='font-size:8px'>&#0160;</span><br />\n".($direct_classes['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing'])); }
			else { $f_js_helper = ""; }

$f_return .= ("<tr>
<td colspan='2' align='center' class='pagebg' style='padding:$direct_settings[theme_form_td_padding]'><table cellspacing='0' summary=''>
<tbody><tr>
<td align='left'><div class='pagecontent' style='font-size:10px'>$f_data[content]</div></td>
</tr></tbody>
</table>$f_js_helper</td>
</tr>");
		}
		else
		{
			if (strlen ($f_data['content']))
			{
				if ($f_data['helper_text']) { $f_js_helper = "<span style='font-size:8px'>&#0160;</span><br />\n".($direct_classes['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing'])); }
				else { $f_js_helper = ""; }

				$f_return .= "<tr>";

				if ($f_data['title'] == "-") { $f_return .= "\n<td valign='top' align='right' class='pageextrabg' style='width:25%'><span style='font-size:8px'>&#0160;</span></td>"; }
				else
				{
					$f_return .= "\n<td valign='top' align='right' class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding]'><span class='pageextracontent' style='font-weight:bold'>";
					if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }
					$f_return .= $f_data['title'].":</span></td>";
				}

$f_return .= ("\n<td valign='middle' align='center' class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding]'>
<table cellspacing='0' summary=''>
<tbody><tr>
<td align='left'><div class='pagecontent'>$f_data[content]</div></td>
</tr></tbody>
</table>$f_js_helper</td>
</tr>");
			}
		}

		return $f_return;
	}

	//f// direct_output_formbuilder->entry_add_jfield_text ($f_data)
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
	/*#ifndef(PHP4) */public /* #*/function entry_add_jfield_text ($f_data)
	{
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_jfield_text (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		if ($f_data['helper_text']) { $f_js_helper = "<br />\n".($direct_classes['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing'])); }
		else { $f_js_helper = ""; }

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

		$f_return = "<tr>\n<td valign='top' align='right' class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding]'><span class='pageextracontent' style='font-weight:bold'>";
		if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }

$f_return .= ($f_data['title'].":</span></td>
<td valign='middle' align='center' class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding]'><div id='{$f_js_id}b'><input type='text' name='$f_data[name]' id='$f_js_id' value=\"$f_data[content]\" size='$f_width' class='pagecontentinputtextnpassword' style='width:$f_css_width' onfocus=\"djs_formbuilder_focused('$f_js_id');\" /><span id='{$f_js_id}_point' style='display:none'><!-- iPoint // --></span><script language='JavaScript1.5' type='text/javascript'><![CDATA[
if (djs_formbuilder_jfield_setup_input ('$f_js_id','$f_css_width')) { djs_swgDOM_replace (\"<span class='pagecontent' style='font-size:10px'><br />\\n<a href=\\\"javascript:djs_formbuilder_jfield_activate('$f_js_id');\\\">".(direct_local_get ("formbuilder_jfield_activate","text"))."</a></span>\",'{$f_js_id}_point'); }
djs_formbuilder_tabindex ('$f_js_id');
]]></script></div>$f_js_helper</td>
</tr>");

		return $f_return;
	}

	//f// direct_output_formbuilder->entry_add_jfield_textarea ($f_data)
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
	/*#ifndef(PHP4) */public /* #*/function entry_add_jfield_textarea ($f_data)
	{
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_jfield_textarea (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		if ($f_data['helper_text']) { $f_js_helper = "<br />\n".($direct_classes['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing'])); }
		else { $f_js_helper = ""; }

		if ($f_data['size'] == "s") { $f_rows = 5; }
		elseif ($f_data['size'] == "m") { $f_rows = 10; }
		else { $f_rows = 20; }

		$f_return = "<tr>\n<td valign='top' align='right' class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding]'><span class='pageextracontent' style='font-weight:bold'>";
		if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }

$f_return .= ($f_data['title'].":</span></td>
<td valign='middle' align='center' class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding]'><div id='{$f_js_id}b'><span id='{$f_js_id}_point1' style='display:none'><!-- iPoint // --></span><script language='JavaScript1.5' type='text/javascript'><![CDATA[
djs_swgDOM_replace (\"<span class='pagecontent' style='font-size:10px'>[ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_data[name]','-');\\\">-</a> ] [ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_data[name]','5');\\\">5</a> ] [ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_data[name]','10');\\\">10</a> ] [ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_data[name]','20');\\\">20</a> ] [ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_data[name]','+');\\\">+</a> ]<br />\\n</span>\",'{$f_js_id}_point1');
]]></script><textarea name='$f_data[name]' id='$f_js_id' cols='26' rows='$f_rows' class='pagecontenttextarea' style='width:80%' onfocus=\"djs_formbuilder_focused('$f_js_id');\">$f_data[content]</textarea><span id='{$f_js_id}_point2' style='display:none'><!-- iPoint // --></span><script language='JavaScript1.5' type='text/javascript'><![CDATA[
if (djs_formbuilder_jfield_setup_textarea ('$f_js_id','$f_rows')) { djs_swgDOM_replace (\"<span class='pagecontent' style='font-size:10px'><br />\\n<a href=\\\"javascript:djs_formbuilder_jfield_activate('$f_js_id');\\\">".(direct_local_get ("formbuilder_jfield_activate","text"))."</a></span>\",'{$f_js_id}_point2'); }
djs_formbuilder_tabindex ('$f_js_id');
]]></script></div>$f_js_helper</td>
</tr>");

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
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_multiselect (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		if ($f_data['helper_text']) { $f_js_helper = "<br />\n<span style='font-size:8px'>&#0160;</span><br />\n".($direct_classes['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing'])); }
		else { $f_js_helper = ""; }

		if ($f_data['size'] == "s") { $f_rows = 2; }
		elseif ($f_data['size'] == "m") { $f_rows = 5; }
		else { $f_rows = 10; }

		$f_return = "<tr>\n<td valign='top' align='right' class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding]'><span class='pageextracontent' style='font-weight:bold'>";
		if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }

$f_return .= ($f_data['title'].":</span></td>
<td valign='middle' align='center' class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding]'><span id='{$f_js_id}_point' style='display:none'><!-- iPoint // --></span><script language='JavaScript1.5' type='text/javascript'><![CDATA[
djs_swgDOM_replace (\"<span class='pagecontent' style='font-size:10px'>[ <a href=\\\"javascript:djs_formbuilder_select_change_size('{$f_data['name']}[]','-');\\\">-</a> ] [ <a href=\\\"javascript:djs_formbuilder_select_change_size('{$f_data['name']}[]','2');\\\">2</a> ] [ <a href=\\\"javascript:djs_formbuilder_select_change_size('{$f_data['name']}[]','5');\\\">5</a> ] [ <a href=\\\"javascript:djs_formbuilder_select_change_size('{$f_data['name']}[]','10');\\\">10</a> ] [ <a href=\\\"javascript:djs_formbuilder_select_change_size('{$f_data['name']}[]','+');\\\">+</a> ]<br />\\n</span>\",'{$f_js_id}_point');
]]></script><select name='{$f_data['name']}[]' id='$f_js_id' size='$f_rows' multiple='multiple' class='pagecontentselect' onfocus=\"djs_formbuilder_focused('$f_js_id');\">$f_data[content]</select><script language='JavaScript1.5' type='text/javascript'><![CDATA[
djs_formbuilder_tabindex ('$f_js_id');
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
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_password (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		if ($f_data['helper_text']) { $f_js_helper = "<br />\n<span style='font-size:8px'>&#0160;</span><br />\n".($direct_classes['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing'])); }
		else { $f_js_helper = ""; }

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

		$f_return = "<tr>\n<td valign='top' align='right' class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding]'><span class='pageextracontent' style='font-weight:bold'>";
		if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }

$f_return .= ($f_data['title'].":</span></td>
<td valign='middle' align='center' class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding]'><input type='password' name='$f_data[name]' id='$f_js_id' value='' size='$f_width' class='pagecontentinputtextnpassword' style='width:$f_css_width' onfocus=\"djs_formbuilder_focused('$f_js_id');\" /><script language='JavaScript1.5' type='text/javascript'><![CDATA[
djs_formbuilder_tabindex ('$f_js_id');
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
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_password_2 (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		if ($f_data['helper_text']) { $f_js_helper = $direct_classes['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']); }
		else { $f_js_helper = ""; }

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

		$f_return = "<tr>\n<td valign='top' align='right' class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding]'><span class='pageextracontent' style='font-weight:bold'>";
		if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }

$f_return .= ($f_data['title'].":</span></td>
<td valign='middle' align='center' class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding]'><p><input type='password' name='$f_data[name]' id='$f_js_id' value='' size='$f_width' class='pagecontentinputtextnpassword' style='width:$f_css_width' onfocus=\"djs_formbuilder_focused('$f_js_id');\" /></p>
<p class='pagecontent' style='font-size:10px'>".(direct_local_get ("formbuilder_form_password_repetition")).":<br />
<input type='password' name='{$f_data['name']}_repetition' id='{$f_js_id}r' value='' size='$f_width' class='pagecontentinputtextnpassword' style='width:$f_css_width' onfocus=\"djs_formbuilder_focused('{$f_js_id}r');\" /></p><script language='JavaScript1.5' type='text/javascript'><![CDATA[
djs_formbuilder_tabindex ('$f_js_id');
djs_formbuilder_tabindex ('{$f_js_id}r');
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
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_radio (+f_data)- (#echo(__LINE__)#)"); }

		if ($f_data['helper_text']) { $f_js_helper = "<span style='font-size:8px'>&nbsp;</span><br />\n".($direct_classes['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing'])); }
		else { $f_js_helper = ""; }

		$f_return = "<tr>\n<td valign='top' align='right' class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding]'><span class='pageextracontent' style='font-weight:bold'>";
		if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }

$f_return .= ($f_data['title'].":</span></td>
<td valign='middle' align='center' class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding]'>
<table cellspacing='0' summary=''>
<tbody><tr>
<td align='left'><div class='pagecontent'>$f_data[content]</div></td>
</tr></tbody>
</table>$f_js_helper</td>
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
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_select (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		if ($f_data['helper_text']) { $f_js_helper = "<br />\n<span style='font-size:8px'>&#0160;</span><br />\n".($direct_classes['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing'])); }
		else { $f_js_helper = ""; }

		if ($f_data['size'] == "s") { $f_rows = 1; }
		elseif ($f_data['size'] == "m") { $f_rows = 4; }
		else { $f_rows = 8; }

		$f_return = "<tr>\n<td valign='top' align='right' class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding]'><span class='pageextracontent' style='font-weight:bold'>";
		if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }

		$f_return .= $f_data['title'].":</span></td>\n<td valign='middle' align='center' class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding]'>";

		if ($f_rows > 1)
		{
$f_return .= ("<span id='{$f_js_id}_point' style='display:none'><!-- iPoint // --></span><script language='JavaScript1.5' type='text/javascript'><![CDATA[
djs_swgDOM_replace (\"<span class='pagecontent' style='font-size:10px'>[ <a href=\\\"javascript:djs_formbuilder_select_change_size('$f_data[name]','-');\\\">-</a> ] [ <a href=\\\"javascript:djs_formbuilder_select_change_size('$f_data[name]','1');\\\">1</a> ] [ <a href=\\\"javascript:djs_formbuilder_select_change_size('$f_data[name]','4');\\\">4</a> ] [ <a href=\\\"javascript:djs_formbuilder_select_change_size('$f_data[name]','8');\\\">8</a> ] [ <a href=\\\"javascript:djs_formbuilder_select_change_size('$f_data[name]','+');\\\">+</a> ]<br />\\n</span>\",'{$f_js_id}_point');
]]></script>");
		}

$f_return .= ("<select name='$f_data[name]' id='$f_js_id' size='$f_rows' class='pagecontentselect' onfocus=\"djs_formbuilder_focused('$f_js_id');\">$f_data[content]</select><script language='JavaScript1.5' type='text/javascript'><![CDATA[
djs_formbuilder_tabindex ('$f_js_id');
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

		return "<tr>\n<td colspan='2' align='center' class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding]'><span class='pagetitlecellcontent'>$f_data[title]</span></td>\n</tr>";
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
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_text (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		if ($f_data['helper_text']) { $f_js_helper = "<br />\n<span style='font-size:8px'>&#0160;</span><br />\n".($direct_classes['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing'])); }
		else { $f_js_helper = ""; }

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

		$f_return = "<tr>\n<td valign='top' align='right' class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding]'><span class='pageextracontent' style='font-weight:bold'>";
		if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }

$f_return .= ($f_data['title'].":</span></td>
<td valign='middle' align='center' class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding]'><input type='text' name='$f_data[name]' id='$f_js_id' value=\"$f_data[content]\" size='$f_width' class='pagecontentinputtextnpassword' style='width:$f_css_width' onfocus=\"djs_formbuilder_focused('$f_js_id');\" /><script language='JavaScript1.5' type='text/javascript'><![CDATA[
djs_formbuilder_tabindex ('$f_js_id');
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
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->entry_add_textarea (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		if ($f_data['helper_text']) { $f_js_helper = "<br />\n<span style='font-size:8px'>&#0160;</span><br />\n".($direct_classes['output']->js_helper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing'])); }
		else { $f_js_helper = ""; }

		if ($f_data['size'] == "s") { $f_rows = 5; }
		elseif ($f_data['size'] == "m") { $f_rows = 10; }
		else { $f_rows = 20; }

		$f_return = "<tr>\n<td valign='top' align='right' class='pageextrabg' style='width:25%;padding:$direct_settings[theme_form_td_padding]'><span class='pageextracontent' style='font-weight:bold'>";
		if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }

$f_return .= ($f_data['title'].":</span></td>
<td valign='middle' align='center' class='pagebg' style='width:75%;padding:$direct_settings[theme_form_td_padding]'><span id='{$f_js_id}_point' style='display:none'><!-- iPoint // --></span><script language='JavaScript1.5' type='text/javascript'><![CDATA[
djs_swgDOM_replace (\"<span class='pagecontent' style='font-size:10px'>[ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_data[name]','-');\\\">-</a> ] [ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_data[name]','5');\\\">5</a> ] [ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_data[name]','10');\\\">10</a> ] [ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_data[name]','20');\\\">20</a> ] [ <a href=\\\"javascript:djs_formbuilder_textarea_change_rows('$f_data[name]','+');\\\">+</a> ]<br />\\n</span>\",'{$f_js_id}_point');
]]></script><textarea name='$f_data[name]' id='$f_js_id' cols='26' rows='$f_rows' class='pagecontenttextarea' style='width:80%' onfocus=\"djs_formbuilder_focused('$f_js_id');\">$f_data[content]</textarea><script language='JavaScript1.5' type='text/javascript'><![CDATA[
djs_formbuilder_tabindex ('$f_js_id');
]]></script>$f_js_helper</td>
</tr>");

		return $f_return;
	}

	//f// direct_output_formbuilder->form_get ($f_data)
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
	/*#ifndef(PHP4) */public /* #*/function form_get ($f_data)
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_formbuilder_class->form_get (+f_data)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
Add additional HTML headers
------------------------------------------------------------------------- */

		$direct_classes['output']->header_elements ("<script language='JavaScript' src='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/swg_formbuilder.js++dbid+".$direct_settings['product_buildid'],true,false))."' type='text/javascript'><!-- // FormBuilder javascript functions // --></script>");

		if ($direct_settings['formbuilder_jfield_supported'])
		{
			$direct_classes['output']->header_elements ("<link rel='stylesheet' type='text/css' href='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+data/mmedia/swg_formbuilder_jfield.css",true,false))."' />");
			$direct_classes['output']->header_elements ("<script language='JavaScript1.5' src='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/swg_formbuilder_jfield.php.js++dbid+".$direct_settings['product_buildid'],true,false))."' type='text/javascript'><!-- // FormBuilder sWG JField specific javascript functions // --></script>");
		}

		$f_return = "";

		foreach ($f_data as $f_element_array)
		{
			if ((isset ($f_element_array['type']))&&(direct_class_function_check ($direct_classes['output_formbuilder'],"entry_add_".$f_element_array['type'])))
			{
				$f_output_function = "entry_add_".$f_element_array['type'];
				$f_output = $this->{$f_output_function} ($f_element_array);

				if ($f_output)
				{
					if ($f_return) { $f_return .= "\n"; }
					$f_return .= $f_output;

					if ((isset ($f_element_array['error']))&&($f_element_array['error']))
					{
$f_return .= ("\n<tr>
<td colspan='2' align='center' class='pagebg' style='padding:5px'><span class='pageerrorcontent'>{$f_element_array['error']}</span></td>
</tr>");
					}
				}
			}
		}

		return $f_return;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_classes['@names']['output_formbuilder'] = "direct_output_formbuilder";
define ("CLASS_direct_output_formbuilder",true);

//j// Script specific commands

if (!isset ($direct_cachedata['output_credits_information'])) { $direct_cachedata['output_credits_information'] = ""; }
if (!isset ($direct_cachedata['output_credits_payment_data'])) { $direct_cachedata['output_credits_payment_data'] = ""; }
if (!isset ($direct_settings['theme_td_padding'])) { $direct_settings['theme_td_padding'] = "5px"; }
if (!isset ($direct_settings['theme_form_td_padding'])) { $direct_settings['theme_form_td_padding'] = "3px"; }
}

//j// EOF
?>