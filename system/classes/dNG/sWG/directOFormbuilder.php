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

if (!defined ("CLASS_directOFormbuilder"))
{
/**
* This is the extended output controller to create forms, their values and
* errors.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage formbuilder
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directOFormbuilder extends directVirtualClass
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directOFormbuilder)
	*
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->__construct (directOFormbuilder)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['entryAddElement'] = true;
		$this->functions['entryAddEMail'] = true;
		$this->functions['entryAddEmbed'] = true;
		$this->functions['entryAddFileFtg'] = true;
		$this->functions['entryAddHidden'] = true;
		$this->functions['entryAddInfo'] = true;
		$this->functions['entryAddMultiSelect'] = true;
		$this->functions['entryAddNumber'] = true;
		$this->functions['entryAddPassword'] = true;
		$this->functions['entryAddPassword2'] = true;
		$this->functions['entryAddRadio'] = true;
		$this->functions['entryAddRange'] = true;
		$this->functions['entryAddRcpText'] = true;
		$this->functions['entryAddRcpTextarea'] = true;
		$this->functions['entryAddSelect'] = true;
		$this->functions['entryAddSpacer'] = true;
		$this->functions['entryAddSubTitle'] = true;
		$this->functions['entryAddText'] = true;
		$this->functions['entryAddTextarea'] = true;
		$this->functions['formGet'] = true;
		$this->functions['formGetResults'] = true;
		$this->functions['formGetSection'] = true;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directOFormbuilder
	*
	* @since v0.1.00
*\/
	function directOFormbuilder () { $this->__construct (); }
:#*/
/**
	* Add an user space defined object. Everything must be handled by user space.
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddElement ($f_data)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->entryAddElement (+f_data)- (#echo(__LINE__)#)"); }

		$f_return = "";

		$f_js_helper = ($f_data['helper_text'] ? "\n<p class='pagehelperactivator'>".($direct_globals['output']->jsHelper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</p>" : "");

		if (!isset ($f_data['title']))
		{
$f_return = ("<tr>
<td colspan='2' class='pagebg pagecontent' style='padding:$direct_settings[theme_form_td_padding];text-align:center'><div class='pagecontent' style='display:inline-block;text-align:left'>$f_data[content]</div>$f_js_helper</td>
</tr>");
		}
		elseif (strlen ($f_data['content']))
		{
			$f_return = "<tr>";

			if ($f_data['title'] == "-") { $f_return .= "\n<td class='pageextrabg' style='width:25%;text-align:right;vertical-align:top;font-size:8px'>&#0160;</td>"; }
			else
			{
				$f_return .= "\n<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><strong>";
				if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }
				$f_return .= $f_data['title'].":</strong></td>";
			}

$f_return .= ("\n<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center'><div class='pagecontent' style='display:inline-block;text-align:left'>$f_data[content]</div>$f_js_helper</td>
</tr>");
		}

		return $f_return;
	}

/**
	* Format and return XHTML for a email input field.
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddEMail ($f_data) { return $this->entryAddText ($f_data); }

/**
	* Include an embedded page via iframe for additional and extended options.
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddEmbed ($f_data)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->entryAddEmbed (+f_data)- (#echo(__LINE__)#)"); }

		if (!$f_data['iframe_only']) { $f_embed_url_ajax = direct_linker ("asis","ajax_content;".$f_data['url']); }
		$f_embed_url_iframe = direct_linker ("url0","xhtml_embedded;".$f_data['url']);
		$f_embed_url_error = direct_linker ("url0",$f_data['url']);

		if ($f_data['size'] == "s") { $f_height = 230; }
		elseif ($f_data['size'] == "m") { $f_height = 315; }
		else { $f_height = 400; }

		$f_js_helper = ($f_data['helper_text'] ? "\n<p class='pagehelperactivator'>".($direct_globals['output']->jsHelper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</p>" : "");

		if (isset ($f_data['title']))
		{
			$f_return = "<tr>\n<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><strong>";
			if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }
			$f_return .= $f_data['title'].":</strong></td>\n<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];vertical-align:middle;text-align:center'>";
		}
		else { $f_return = "<tr>\n<td colspan='2' class='pagebg pagecontent' style='padding:$direct_settings[theme_form_td_padding];text-align:center'>"; }

		$f_embedded_code = (($f_data['size'] == "l") ? "<p id='swgAJAX_embed_{$f_data['content']}_point'>".(direct_local_get ("core_loading","text"))."</p>" : "<div id='swgAJAX_embed_box_{$f_data['content']}' class='pageembeddedborder{$direct_settings['theme_css_corners']} pageembeddedbg pageextracontent' style='margin:auto;height:{$f_height}px;overflow:auto'><p id='swgAJAX_embed_{$f_data['content']}_point'>".(direct_local_get ("core_loading","text"))."</p></div>");

		if ((!$f_data['iframe_only'])&&(isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']))) { $f_return .= $f_embedded_code; }
		else { $f_return .= "<iframe src='$f_embed_url_iframe' id='swgAJAX_embed_{$f_data['content']}_point' class='pageembeddedborder{$direct_settings['theme_css_corners']} pageembeddedbg pageextracontent' style='width:100%;height:{$f_height}px'><strong>".(direct_local_get ("formbuilder_embed_unsupported_1"))."<a href='$f_embed_url_error' target='_blank'>".(direct_local_get ("formbuilder_embed_unsupported_2"))."</a>".(direct_local_get ("formbuilder_embed_unsupported_3"))."</strong></iframe>"; }

		$f_return .= "<input type='hidden' name='{$f_data['name']}' value='{$f_data['content']}' /><script type='text/javascript'><![CDATA[\njQuery (function () { ";

		if ($f_data['iframe_only']) { $f_return .= "{$direct_settings['theme_form_js_init']} ({ id:'swgAJAX_embed_{$f_data['content']}_point',type:'resizeable' });"; }
		else
		{
			$f_return .= "djs_load_functions({ file:'swg_AJAX.php.js',block:'djs_swgAJAX_replace' }).done (function () { ";

			if (isset ($direct_settings['swg_clientsupport']['JSDOMManipulation'])) { $f_return .= "djs_swgAJAX_replace ({ id:'swgAJAX_embed_{$f_data['content']}_point',onReplaced:{ func:'{$direct_settings['theme_form_js_init']}',params: { id:'swgAJAX_embed_box_{$f_data['content']}',type:'resizeable' } },url0:'$f_embed_url_ajax' });"; }
			else { $f_return .= "djs_DOM_replace ({ data:\"".(str_replace (array ('"',"\n"),(array ('\"',"\" +\n\"")),$f_embedded_code))."\",id:'swgAJAX_embed_{$f_data['content']}_point',id_replaced:'swgAJAX_embed_box_{$f_data['content']}',onReplaced:{ func:'djs_swgAJAX_replace',params: { id:'swgAJAX_embed_{$f_data['content']}_point',onReplaced:{ func:'{$direct_settings['theme_form_js_init']}',params: { id:'swgAJAX_embed_box_{$f_data['content']}',type:'resizeable' } },url0:'$f_embed_url_ajax' } } });"; }

			$f_return .= " });";
		}

$f_return .= (" });
]]></script>$f_js_helper</td>
</tr>");

		return $f_return;
	}

/**
	* Format and return XHTML to show a FormTags formatted file.
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddFileFtg ($f_data)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->entryAddFileFtg (+f_data)- (#echo(__LINE__)#)"); }

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
<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><strong>$f_data[title]:</strong></td>
<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:left;vertical-align:middle'><div style='margin:auto;padding:1px 5px;overflow:auto$f_css_values'>$f_data[content]</div></td>
</tr>");

		return $f_return;
	}

/**
	* Include a hidden form field and its value.
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddHidden ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->entryAddHidden (+f_data)- (#echo(__LINE__)#)"); }
		return "<input type='hidden' name='$f_data[name]' value='$f_data[content]' />";
	}

/**
	* Format and return XHTML to show developer-defined information.
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddInfo ($f_data)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->entryAddInfo (+f_data)- (#echo(__LINE__)#)"); }

		$f_return = "";

		$f_js_helper = ($f_data['helper_text'] ? "\n<p class='pagehelperactivator'>".($direct_globals['output']->jsHelper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</p>" : "");

		if (!isset ($f_data['title']))
		{
$f_return .= ("<tr>
<td colspan='2' class='pagebg pagecontent' style='padding:$direct_settings[theme_form_td_padding];text-align:center'><div class='pagecontent' style='display:inline-block;text-align:left;font-size:10px'>$f_data[content]</div>$f_js_helper</td>
</tr>");
		}
		elseif (strlen ($f_data['content']))
		{
			$f_return .= "<tr>";

			if ($f_data['title'] == "-") { $f_return .= "\n<td class='pageextrabg' style='width:25%;text-align:right;vertical-align:top'><span style='font-size:8px'>&#0160;</span></td>"; }
			else
			{
				$f_return .= "\n<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><strong>";
				if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }
				$f_return .= $f_data['title'].":</strong></td>";
			}

			$f_return .= "\n<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center'><div class='pagecontent' style='display:inline-block;text-align:left'>$f_data[content]</div>$f_js_helper</td>\n</tr>";
		}

		return $f_return;
	}

/**
	* Format and return XHTML to create multiple choice select options.
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddMultiSelect ($f_data)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->entryAddMultiSelect (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		$f_js_helper = ($f_data['helper_text'] ? "\n<p class='pagehelperactivator'>".($direct_globals['output']->jsHelper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</p>" : "");

		if ($f_data['size'] == "s") { $f_rows = 2; }
		elseif ($f_data['size'] == "m") { $f_rows = 5; }
		else { $f_rows = 0; }

		$f_content = "";
		if ($f_choice_array['size'] == "l") { $f_input_required = ($f_data['required'] ? " required='required'" : ""); }

		foreach ($f_data['content'] as $f_choice_array)
		{
			if ($f_content) { $f_content .= (($f_choice_array['size'] == "l") ? "<br />\n" : "\n"); }

			if (isset ($f_choice_array['selected'])) { $f_content .= (($f_choice_array['size'] == "l") ? "<input type='checkbox' id='{$f_choice_array['choice_id']}' name=\"{$f_data['name']}[]\" value=\"{$f_choice_array['value']}\"$f_input_required checked='checked' /><label for='{$f_choice_array['choice_id']}'>{$f_choice_array['text']}</label>" : "<option value=\"{$f_choice_array['value']}\" selected='selected'>{$f_choice_array['text']}</option>"); }
			else { $f_content .= (($f_choice_array['size'] == "l") ? "<input type='checkbox' id='{$f_choice_array['choice_id']}' name=\"{$f_data['name']}[]\" value=\"{$f_choice_array['value']}\"$f_input_required /><label for='{$f_choice_array['choice_id']}'>{$f_choice_array['text']}</label>" : "<option value=\"{$f_choice_array['value']}\">{$f_choice_array['text']}</option>"); }

			if ($f_choice_array['size'] == "l")
			{
$f_content .= ("<script type='text/javascript'><![CDATA[
jQuery (function () { {$direct_settings['theme_form_js_init']} ({ id:'{$f_choice_array['choice_id']}' }); });
]]></script>");
			}
		}

		$f_return = "<tr>\n<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><strong>";

		if ($f_data['required'])
		{
			$f_required = " required='required'";
			$f_return .= $direct_settings['swg_required_marker']." ";
		}
		else { $f_required = ""; }

		$f_return .= $f_data['title'].":</strong></td>\n<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'>";

		if ($f_rows)
		{
$f_return .= ("<select name='{$f_data['name']}[]' id='$f_js_id'$f_required size='$f_rows' multiple='multiple' class='pagecontentselect'>$f_content</select><script type='text/javascript'><![CDATA[
jQuery (function () { {$direct_settings['theme_form_js_init']} ({ id:'$f_js_id',type:'resizeable' }); });
]]></script>");
		}
		else { $f_return .= "<div class='pagecontent' style='display:inline-block;text-align:left'>$f_content</div>"; }

		$f_return .= $f_js_helper."</td>\n</tr>";

		return $f_return;
	}

/**
	* Format and return XHTML for a number input field.
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddNumber ($f_data) { return $this->entryAddText ($f_data); }

/**
	* Format and return XHTML for a password field.
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddPassword ($f_data)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->entryAddPassword (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		$f_js_helper = ($f_data['helper_text'] ? "\n<p class='pagehelperactivator'>".($direct_globals['output']->jsHelper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</p>" : "");

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

		$f_return = "<tr>\n<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><strong>";

		if ($f_data['required'])
		{
			$f_required = " required='required'";
			$f_return .= $direct_settings['swg_required_marker']." ";
		}
		else { $f_required = ""; }

$f_return .= ($f_data['title'].":</strong></td>
<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'><input type='password' name='$f_data[name]' id='$f_js_id' value=''$f_required size='$f_width' class='pagecontentinputtextnpassword' style='width:$f_css_width' /><script type='text/javascript'><![CDATA[
jQuery (function () { {$direct_settings['theme_form_js_init']} ({ id:'$f_js_id' }); });
]]></script>$f_js_helper</td>
</tr>");

		return $f_return;
	}

/**
	* Format and return XHTML for a password and a confirmation field.
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddPassword2 ($f_data)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->entryAddPassword2 (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		$f_js_helper = ($f_data['helper_text'] ? "\n<p class='pagehelperactivator'>".($direct_globals['output']->jsHelper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</p>" : "");

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

		$f_return = "<tr>\n<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><strong>";

		if ($f_data['required'])
		{
			$f_required = " required='required'";
			$f_return .= $direct_settings['swg_required_marker']." ";
		}
		else { $f_required = ""; }

$f_return .= ($f_data['title'].":</strong></td>
<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'><p><input type='password' name='$f_data[name]' id='$f_js_id' value=''$f_required size='$f_width' class='pagecontentinputtextnpassword' style='width:$f_css_width' /></p>
<p style='font-size:10px'>".(direct_local_get ("formbuilder_form_password_repetition")).":<br />
<input type='password' name='{$f_data['name']}_repetition' id='{$f_js_id}r' value=''$f_required size='$f_width' class='pagecontentinputtextnpassword' style='width:$f_css_width' /></p><script type='text/javascript'><![CDATA[
jQuery (function ()
{
	{$direct_settings['theme_form_js_init']} ({ id:'$f_js_id' });
	{$direct_settings['theme_form_js_init']} ({ id:'{$f_js_id}r' });
});
]]></script>$f_js_helper</td>
</tr>");

		return $f_return;
	}

/**
	* Format and return XHTML to create radio options.
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddRadio ($f_data)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->entryAddRadio (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_helper = ($f_data['helper_text'] ? "\n<p class='pagehelperactivator'>".($direct_globals['output']->jsHelper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</p>" : "");

		$f_content = "";
		$f_input_required = ($f_data['required'] ? " required='required'" : "");

		foreach ($f_data['content'] as $f_choice_array)
		{
			if ($f_content) { $f_content .= "<br />\n"; }

			if (isset ($f_choice_array['selected'])) { $f_content .= "<input type='radio' name='{$f_data['name']}' id='{$f_choice_array['choice_id']}' value=\"{$f_choice_array['value']}\"$f_input_required checked='checked' /><label for='{$f_choice_array['choice_id']}'> {$f_choice_array['text']}</label>"; }
			else { $f_content .= "<input type='radio' name='{$f_data['name']}' id='{$f_choice_array['choice_id']}' value=\"{$f_choice_array['value']}\"$f_input_required /><label for='{$f_choice_array['choice_id']}'> {$f_choice_array['text']}</label>"; }

$f_content .= ("<script type='text/javascript'><![CDATA[
jQuery (function () { {$direct_settings['theme_form_js_init']} ({ id:'{$f_choice_array['choice_id']}' }); });
]]></script>");
		}

		$f_return = "<tr>\n<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><strong>";
		if ($f_data['required']) { $f_return .= $direct_settings['swg_required_marker']." "; }

$f_return .= ($f_data['title'].":</strong></td>
<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'><div class='pagecontent' style='display:inline-block;text-align:left'>$f_content</div>$f_js_helper</td>
</tr>");

		return $f_return;
	}

/**
	* Format and return XHTML to create a range input.
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddRange ($f_data)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->entryAddRange (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		$f_js_helper = ($f_data['helper_text'] ? "\n<p class='pagehelperactivator'>".($direct_globals['output']->jsHelper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</p>" : "");

		$f_return = "<tr>\n<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><strong>";

		if ($f_data['required'])
		{
			$f_required = " required='required'";
			$f_return .= $direct_settings['swg_required_marker']." ";
		}
		else { $f_required = ""; }

		$f_return .= $f_data['title'].":</strong></td>\n<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'>";

		if ($f_data['size'] == "s") { $f_css_width = "30%"; }
		elseif ($f_data['size'] == "m") { $f_css_width = "55%"; }
		else { $f_css_width = "80%"; }

		$f_unit = (isset ($f_data['unit']) ? "<br />\n<span style='font-size:10px'>($f_data[unit])</span>" : "");

$f_return .= ("<div class='pagecontent' style='width:$f_css_width;margin:auto;text-align:center'><input name='$f_data[name]' id='$f_js_id'$f_required type='range' min=\"$f_data[min]\" max=\"$f_data[max]\" value=\"$f_data[content]\" class='pagecontentinputtextnpassword' style='width:$f_css_width' />$f_unit<script type='text/javascript'><![CDATA[
jQuery (function () { {$direct_settings['theme_form_js_init']} ({ id:'$f_js_id',type:'range' }); });
]]></script></div>$f_js_helper</td>
</tr>");

		return $f_return;
	}

/**
	* Format and return XHTML for a text input field.
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddRcpText ($f_data)
	{
		$f_data['filter'] = "text";
		return $this->entryAddText ($f_data,true);
	}

/**
	* Format and return XHTML for a textarea input field.
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddRcpTextarea ($f_data) { return $this->entryAddTextarea ($f_data,true); }

/**
	* Format and return XHTML to create select options.
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddSelect ($f_data)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->entryAddSelect (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		$f_js_helper = ($f_data['helper_text'] ? "\n<p class='pagehelperactivator'>".($direct_globals['output']->jsHelper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</p>" : "");

		if ($f_data['size'] == "s") { $f_rows = 1; }
		elseif ($f_data['size'] == "m") { $f_rows = 4; }
		else { $f_rows = 8; }

		$f_content = "";

		foreach ($f_data['content'] as $f_choice_array)
		{
			if ($f_content) { $f_content .= "\n"; }

			if (isset ($f_choice_array['selected'])) { $f_content .= "<option value=\"{$f_choice_array['value']}\" selected='selected'>{$f_choice_array['text']}</option>"; }
			else { $f_content .= "<option value=\"{$f_choice_array['value']}\">{$f_choice_array['text']}</option>"; }
		}

		$f_return = "<tr>\n<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><strong>";

		if ($f_data['required'])
		{
			$f_required = " required='required'";
			$f_return .= $direct_settings['swg_required_marker']." ";
		}
		else { $f_required = ""; }

		$f_resizeable = (($f_rows > 1) ? ",type:'resizeable'" : "");

$f_return .= ($f_data['title'].":</strong></td>
<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'><select name='$f_data[name]' id='$f_js_id'$f_required size='$f_rows' class='pagecontentselect'>$f_content</select><script type='text/javascript'><![CDATA[
jQuery (function () { {$direct_settings['theme_form_js_init']} ({ id:'$f_js_id'$f_resizeable }); });
]]></script>$f_js_helper</td>
</tr>");

		return $f_return;
	}

/**
	* Format and return XHTML for a spacer.
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddSpacer ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->entryAddSpacer (+f_data)- (#echo(__LINE__)#)"); }
		return "<tr>\n<td colspan='2' class='pagebg' style='font-size:8px'>&#0160;</td>\n</tr>";
	}

/**
	* Add a title line (subtitle for the form).
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddSubTitle ($f_data)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->entryAddSubTitle (+f_data)- (#echo(__LINE__)#)"); }

		return "<tr>\n<td colspan='2' class='pagetitlecell' style='padding:$direct_settings[theme_td_padding];text-align:center'>$f_data[title]</td>\n</tr>";
	}

/**
	* Format and return XHTML for a text input field.
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddText ($f_data,$f_rcp_active = false)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->entryAddText (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		$f_js_helper = ($f_data['helper_text'] ? "\n<p class='pagehelperactivator'>".($direct_globals['output']->jsHelper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</p>" : "");

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

		$f_return = "<tr>\n<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><strong>";

		if ($f_data['required'])
		{
			$f_required = " required='required'";
			$f_return .= $direct_settings['swg_required_marker']." ";
		}
		else { $f_required = ""; }

		$f_return .= ($f_data['title'].":</strong></td>\n<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'><input type='{$f_data['filter']}' name='$f_data[name]' id='$f_js_id' value=\"$f_data[content]\"$f_required size='$f_width' class='pagecontentinputtextnpassword' style='width:$f_css_width' /><script type='text/javascript'><![CDATA[\n");

$f_return .= ($f_rcp_active ? ("jQuery (function () {
	djs_load_functions({ file:'swg_formbuilder_rcp.php.js' }).done (function () { djs_formbuilder_rcp_init ({ id:'$f_js_id' }); });
});") : "jQuery (function () { {$direct_settings['theme_form_js_init']} ({ id:'$f_js_id',type:'{$f_data['filter']}' }); });");

		$f_return .= "\n]]></script>$f_js_helper</td>\n</tr>";

		return $f_return;
	}

/**
	* Format and return XHTML for a textarea input field.
	*
	* @param  array $f_data Array containing information about the form field
	* @return string Valid XHTML form field definition
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function entryAddTextarea ($f_data,$f_rcp_active = false)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->entryAddTextarea (+f_data)- (#echo(__LINE__)#)"); }

		$f_js_id = "swg_formbuilder_".$direct_cachedata['formbuilder_element_counter'];
		$direct_cachedata['formbuilder_element_counter']++;

		$f_js_helper = ($f_data['helper_text'] ? "\n<p class='pagehelperactivator'>".($direct_globals['output']->jsHelper ($f_data['helper_text'],$f_data['helper_url'],$f_data['helper_closing']))."</p>" : "");

		if ($f_data['size'] == "s") { $f_rows = 5; }
		elseif ($f_data['size'] == "m") { $f_rows = 10; }
		else { $f_rows = 20; }

		$f_return = "<tr>\n<td class='pageextrabg pageextracontent' style='width:25%;padding:$direct_settings[theme_form_td_padding];text-align:right;vertical-align:top'><strong>";

		if ($f_data['required'])
		{
			$f_required = " required='required'";
			$f_return .= $direct_settings['swg_required_marker']." ";
		}
		else { $f_required = ""; }

		$f_return .= ($f_data['title'].":</strong></td>\n<td class='pagebg pagecontent' style='width:75%;padding:$direct_settings[theme_form_td_padding];text-align:center;vertical-align:middle'><textarea name='$f_data[name]' id='$f_js_id'$f_required cols='26' rows='$f_rows' class='pagecontenttextarea' style='width:80%'>$f_data[content]</textarea><script type='text/javascript'><![CDATA[\n");

$f_return .= ($f_rcp_active ? ("jQuery (function () {
	djs_load_functions({ file:'swg_formbuilder_rcp.php.js' }).done (function () { djs_formbuilder_rcp_init ({ id:'$f_js_id' }); });
});") : "jQuery (function () { {$direct_settings['theme_form_js_init']} ({ id:'$f_js_id',type:'resizeable' }); });");

		$f_return .= "\n]]></script>$f_js_helper</td>\n</tr>";

		return $f_return;
	}

/**
	* Reads an array of form elements and calls the corresponding function to get
	* valid XHTML for output.
	*
	* @param  array $f_data Array containing information about form fields
	* @return string Valid XHTML form
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function formGet ($f_data,$f_form_id = NULL)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->formGet (+f_data,+f_form_id)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
Add additional HTML headers
------------------------------------------------------------------------- */

		$direct_globals['output']->headerElements ("<script src='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_mmedia]/swg_formbuilder.php.js++dbid+".$direct_settings['product_buildid'],true,false))."' type='text/javascript'></script><!-- // FormBuilder javascript functions // -->","script_formbuilder");
		#if ($direct_settings['formbuilder_rcp_supported']) { $direct_globals['output']->headerElements ("<link rel='stylesheet' type='text/css' href='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+data/mmedia/swg_formbuilder_rcp.css",true,false))."' />"); }

		if (isset ($f_data['']))
		{
			if (count ($f_data) > 1)
			{
				if (!isset ($f_form_id)) { $f_form_id = uniqid ('swg_form_'); }
				$f_return = "<div id='{$f_form_id}_sections'>".($this->formGetSection ($f_data[''],(direct_local_get ("formbuilder_section_general"))));
			}
			else { $f_return = $this->formGetSection ($f_data['']); }

			unset ($f_data['']);
		}
		else { $f_return = ""; }

		if (!empty ($f_data))
		{
			if (!isset ($f_form_id)) { $f_form_id = uniqid ('swg_form_'); }

			if (!$f_return) { $f_return .= "<div id='{$f_form_id}_sections'>"; }
			foreach ($f_data as $f_section => $f_elements_array) { $f_return .= $this->formGetSection ($f_elements_array,$f_section); }
			$f_return .= "</div><script type='text/javascript'><![CDATA[\njQuery (function () { {$direct_settings['theme_form_js_init']} ({ id:'{$f_form_id}_sections',type:'form_sections' }); });\n]]></script>";
		}

		return $f_return;
	}

/**
	* Reads an array of form elements and calls the corresponding function to get
	* valid XHTML for output.
	*
	* @param  array $f_data Array containing information about form fields
	* @return string Valid XHTML form
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function formGetResults ($f_data,$f_show_all = false,$f_types_hidden = NULL)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->formGetResults (+f_data,+f_show_all,+f_types_hidden)- (#echo(__LINE__)#)"); }

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
				if ((isset ($f_element_array['filter']))&&($f_element_array['filter'] != "hidden")&&($f_element_array['filter'] != "element")&&($f_element_array['filter'] != "info")&&($f_element_array['filter'] != "spacer")&&($f_element_array['filter'] != "subtitle")&&((direct_class_function_check ($direct_globals['output_formbuilder'],"entry_add_".$f_element_array['filter']))||(is_callable ($f_element_array['filter']))))
				{
					if ($f_return_all) { $f_return_all .= (($f_element_array['filter'] == "spacer") ? "</p>\n<p>" : "<br />\n"); }
					else { $f_return_all = "<p>"; }

					$f_return_all .= "<strong>";
					if ($f_element_array['required']) { $f_return_all .= $direct_settings['swg_required_marker']." "; }
					$f_return_all .= $f_element_array['title'].":</strong> ";

					if ((isset ($f_element_array['error']))&&($f_element_array['error']))
					{
						$f_return_all .= $f_element_array['error'];

						if (!$f_show_all)
						{
							if ($f_return) { $f_return .= (($f_element_array['filter'] == "spacer") ? "</p>\n<p>" : "<br />\n"); }
							else { $f_return = "<p>"; }

							$f_return .= "<strong>{$f_element_array['title']}:</strong> ".$f_element_array['error'];
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

/**
	* Reads an array of form elements and calls the corresponding function to get
	* valid XHTML for output.
	*
	* @param  array $f_data Array containing information about form fields
	* @return string Valid XHTML form
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function formGetSection ($f_data,$f_section = NULL)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -outputFormbuilder->formGetSection (+f_data,+f_section)- (#echo(__LINE__)#)"); }

$f_return = ((isset ($f_section) ? "<p class='pagecontenttitle ui-accordion-header'><a href='#swg_form_".(md5 ($f_section))."'>".(direct_html_encode_special ($f_section))."</a></p><div>" : "")."
<table class='pagetable' style='width:100%;table-layout:auto'>
<tbody>");

		foreach ($f_data as $f_element_array)
		{
			$f_output = NULL;

			if (isset ($f_element_array['filter']))
			{
				$f_filter = ucfirst ($f_element_array['filter']);

				if (direct_class_function_check ($direct_globals['output_formbuilder'],"entryAdd".$f_filter))
				{
					$f_output_function = "entryAdd".$f_filter;
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
<td colspan='2' class='pagebg pageerrorcontent' style='padding:5px;text-align:center'>{$f_element_array['error']}</td>
</tr>");
				}
			}
			else
			{
$f_return .= ("<tr>
<td colspan='2' class='pagebg pageerrorcontent' style='padding:5px;text-align:center'>".(direct_local_get ("formbuilder_error"))."</td>
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

define ("CLASS_directOFormbuilder",true);

//j// Script specific commands

global $direct_cachedata,$direct_globals,$direct_settings;
$direct_globals['@names']['output_formbuilder'] = 'dNG\sWG\directOFormbuilder';

if (!isset ($direct_cachedata['output_credits_information'])) { $direct_cachedata['output_credits_information'] = ""; }
if (!isset ($direct_cachedata['output_credits_payment_data'])) { $direct_cachedata['output_credits_payment_data'] = ""; }
$direct_settings['theme_css_corners'] = (isset ($direct_settings['theme_css_corners_class']) ? " ".$direct_settings['theme_css_corners_class'] : " ui-corner-all");
if (!isset ($direct_settings['theme_form_js_init'])) { $direct_settings['theme_form_js_init'] = "djs_formbuilder_init"; }
if (!isset ($direct_settings['theme_form_td_padding'])) { $direct_settings['theme_form_td_padding'] = "3px"; }
if (!isset ($direct_settings['theme_td_padding'])) { $direct_settings['theme_td_padding'] = "5px"; }
}

//j// EOF
?>