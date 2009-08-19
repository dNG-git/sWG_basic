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
* account/swg_profile.php
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
* @subpackage account
* @uses       direct_product_iversion
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
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

//j// Script specific commands

if (!isset ($direct_settings['account_https_profile_edit'])) { $direct_settings['account_https_profile_edit'] = false; }
if (!isset ($direct_settings['account_https_profile_select'])) { $direct_settings['account_https_profile_select'] = false; }
if (!isset ($direct_settings['account_https_profile_view'])) { $direct_settings['account_https_profile_view'] = false; }
if (!isset ($direct_settings['account_profile_mods_support'])) { $direct_settings['account_profile_mods_support'] = false; }
if (!isset ($direct_settings['account_profile_username_change'])) { $direct_settings['account_profile_username_change'] = true; }
if (!isset ($direct_settings['serviceicon_account_email_change'])) { $direct_settings['serviceicon_account_email_change'] = "mini_default_option.png"; }
if (!isset ($direct_settings['serviceicon_account_password_change'])) { $direct_settings['serviceicon_account_password_change'] = "mini_default_option.png"; }
if (!isset ($direct_settings['serviceicon_account_profile_edit'])) { $direct_settings['serviceicon_account_profile_edit'] = "mini_default_option.png"; }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
if (!isset ($direct_settings['users_min'])) { $direct_settings['users_min'] = 3; }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGbasicVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "view"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// ($direct_settings['a'] == "edit")||($direct_settings['a'] == "edit-save")
case "edit":
case "edit-save":
{
	$g_mode_save = (($direct_settings['a'] == "edit-save") ? true : false);
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }

	$g_uid = (isset ($direct_settings['dsd']['auid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['auid'])) : "");
	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['source'])) : "");
	$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['target'])) : "");

	$g_source_url = ($g_source ? base64_decode ($g_source) : "m=account&a=services");

	if ($g_target) { $g_target_url = base64_decode ($g_target); }
	else
	{
		$g_target = $g_source;
		$g_target_url = $g_source_url;
	}

	if ($g_mode_save)
	{
		$direct_cachedata['page_this'] = "";
		$direct_cachedata['page_backlink'] = "m=account&s=profile&a=edit&dsd=auid+$g_uid++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_homelink'] = str_replace ("[oid]","",$g_source_url);
	}
	else
	{
		$direct_cachedata['page_this'] = "m=account&s=profile&a=edit&dsd=auid+$g_uid++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_backlink'] = str_replace ("[oid]","",$g_source_url);
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'] ;
	}

	if ($direct_classes['kernel']->service_init_default ())
	{
	if (empty ($g_uid)) { $g_uid = $direct_settings['user']['id']; }

	if ((($direct_settings['user']['type'] == "ex")||($direct_settings['user']['type'] == "gt"))||(($direct_settings['user']['id'] != $g_uid)&&($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type']) < 4)&&(!$direct_classes['kernel']->v_group_user_check_right ("account_profile_edit")))) { $direct_classes['error_functions']->error_page ("login","core_access_denied","sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }
	else
	{
	//j// BOA
	$g_user_array = $direct_classes['kernel']->v_user_get ($g_uid,"",true);

	if ($g_mode_save) { direct_output_related_manager ("account_profile_edit_{$g_user_array['ddbusers_type']}_{$g_uid}_form_save","pre_module_service_action"); }
	else
	{
		direct_output_related_manager ("account_profile_edit_{$g_user_array['ddbusers_type']}_{$g_uid}_form","pre_module_service_action");
		$direct_classes['kernel']->service_https ($direct_settings['account_https_profile_edit'],$direct_cachedata['page_this']);
	}

	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formbuilder.php");
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formtags.php");
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_mods_support.php");
	direct_local_integration ("account");

	direct_class_init ("formbuilder");
	direct_class_init ("formtags");
	direct_class_init ("output");
	$direct_classes['output']->servicemenu ("account");

	if ($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type']) < 4) { $direct_classes['output']->options_insert (1,"servicemenu","m=account&s=email_change",(direct_local_get ("account_email_change")),$direct_settings['serviceicon_account_email_change'],"url0"); }
	$direct_classes['output']->options_insert (1,"servicemenu","m=account&s=password_change",(direct_local_get ("account_password_change")),$direct_settings['serviceicon_account_password_change'],"url0");
	$direct_classes['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

	if ($g_mode_save)
	{
/* -------------------------------------------------------------------------
We should have input in save mode
------------------------------------------------------------------------- */

		if ($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type']) > 3)
		{
			$direct_cachedata['i_ausername'] = (isset ($GLOBALS['i_ausername']) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS['i_ausername'])) : "");
			$direct_cachedata['i_atitle'] = (isset ($GLOBALS['i_atitle']) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS['i_atitle'])) : "");
			$direct_cachedata['i_aemail'] = (isset ($GLOBALS['i_aemail']) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS['i_aemail'])) : "");
		}
		else
		{
			if ($direct_settings['account_profile_username_change']) { $direct_cachedata['i_ausername'] = (isset ($GLOBALS['i_ausername']) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS['i_ausername'])) : ""); }
			else { $direct_cachedata['i_ainfo_1'] = direct_html_encode_special ($g_user_array['ddbusers_name']); }

			$direct_cachedata['i_ainfo_2'] = direct_html_encode_special ($g_user_array['ddbusers_email']);
		}

		$direct_cachedata['i_aemail_public'] = (isset ($GLOBALS['i_aemail_public']) ? (str_replace ("'","",$GLOBALS['i_aemail_public'])) : $g_user_array['ddbusers_email_public']);
		$direct_cachedata['i_atimezone'] = $g_user_array['ddbusers_timezone'];
		$direct_cachedata['i_asignature'] = (isset ($GLOBALS['i_asignature']) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS['i_asignature'])) : "");

		if ($direct_settings['user']['id'] != $g_uid) { $direct_cachedata['i_alocked'] = (isset ($GLOBALS['i_alocked']) ? (str_replace ("'","",$GLOBALS['i_alocked'])) : $g_user_array['ddbusers_locked']); }
		else { $direct_cachedata['i_alocked'] = $g_user_array['ddbusers_locked']; }

		if ($direct_settings['user']['type'] == "ad")
		{
			$direct_cachedata['i_atype'] = (isset ($GLOBALS['i_atype']) ? (str_replace ("'","",$GLOBALS['i_atype'])) : $g_user_array['ddbusers_type']);
			$direct_cachedata['i_abanned'] = (isset ($GLOBALS['i_abanned']) ? (str_replace ("'","",$GLOBALS['i_abanned'])) : $g_user_array['ddbusers_banned']);
		}
		else
		{
			$direct_cachedata['i_atype'] = $g_user_array['ddbusers_type'];
			$direct_cachedata['i_abanned'] = $g_user_array['ddbusers_banned'];
		}
	}
	else
	{
		if ($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type']) > 3)
		{
			$direct_cachedata['i_ausername'] = $g_user_array['ddbusers_name'];
			$direct_cachedata['i_atitle'] = $g_user_array['ddbusers_title'];
			$direct_cachedata['i_aemail'] = $g_user_array['ddbusers_email'];
		}
		else
		{
			if ($direct_settings['account_profile_username_change']) { $direct_cachedata['i_ausername'] = $g_user_array['ddbusers_name']; }
			else { $direct_cachedata['i_ainfo_1'] = direct_html_encode_special ($g_user_array['ddbusers_name']); }

			$direct_cachedata['i_ainfo_2'] = direct_html_encode_special ($g_user_array['ddbusers_email']);
		}

		$direct_cachedata['i_aemail_public'] = $g_user_array['ddbusers_email_public'];
		$direct_cachedata['i_atimezone'] = $g_user_array['ddbusers_timezone'];
		$direct_cachedata['i_asignature'] = $direct_classes['formtags']->recode_newlines (direct_output_smiley_cleanup ($g_user_array['ddbusers_signature']),false);
		$direct_cachedata['i_atype'] = $g_user_array['ddbusers_type'];
		$direct_cachedata['i_alocked'] = $g_user_array['ddbusers_locked'];
		$direct_cachedata['i_abanned'] = $g_user_array['ddbusers_banned'];
	}

	$direct_cachedata['i_aemail_public'] = str_replace ("<value value='$direct_cachedata[i_aemail_public]' />","<value value='$direct_cachedata[i_aemail_public]' /><selected value='1' />","<evars><no><value value='0' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes></evars>");
/* TODO
$direct_cachedata['i_atimezone'] = str_replace ("<value value='$direct_cachedata[i_atimezone]' />","<value value='$direct_cachedata[i_atimezone]' /><selected value='1' />","<evars>
<h0><value value='-12' /></h0><h1><value value='-11' /></h1><h2><value value='-10' /></h2><h3><value value='-9' /></h3><h4><value value='-8' /></h4><h5><value value='-7' /></h5><h6><value value='-6' /></h6><h7><value value='-5' /></h7><h8><value value='-4' /></h8>
<h9><value value='-3' /></h9><h10><value value='-2' /></h10><h11><value value='-1' /></h11><h12><value value='0' /></h12><h13><value value='1' /><text value='+1' /></h13><h14><value value='2' /><text value='+2' /></h14><h15><value value='3' /><text value='+3' /></h15><h16><value value='4' /><text value='+4' /></h16>
<h17><value value='5' /><text value='+5' /></h17><h18><value value='6' /><text value='+6' /></h18><h19><value value='7' /><text value='+7' /></h19><h20><value value='8' /><text value='+8' /></h20><h21><value value='9' /><text value='+9' /></h21><h22><value value='10' /><text value='+10' /></h22><h23><value value='11' /><text value='+11' /></h23><h24><value value='12' /><text value='+12' /></h24>
</evars>");
*/

	if ($direct_settings['user']['id'] != $g_uid)
	{
		$direct_cachedata['i_alocked'] = str_replace ("<value value='$direct_cachedata[i_alocked]' />","<value value='$direct_cachedata[i_alocked]' /><selected value='1' />","<evars><no><value value='0' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes></evars>");

		if ($direct_settings['user']['type'] == "ad")
		{
			$direct_cachedata['i_atype'] = str_replace ("<value value='$direct_cachedata[i_atype]' />","<value value='$direct_cachedata[i_atype]' /><selected value='1' />","<evars><me><value value='me' /><text><![CDATA[".(direct_local_get ("core_usertype_member"))."]]></text></me><sm><value value='sm' /><text><![CDATA[".(direct_local_get ("core_usertype_member_special"))."]]></text></sm><mo><value value='mo' /><text><![CDATA[".(direct_local_get ("core_usertype_moderator"))."]]></text></mo><ma><value value='ma' /><text><![CDATA[".(direct_local_get ("core_usertype_main_moderator"))."]]></text></ma><ad><value value='ad' /><text><![CDATA[".(direct_local_get ("core_usertype_administrator"))."]]></text></ad></evars>");
			$direct_cachedata['i_abanned'] = str_replace ("<value value='$direct_cachedata[i_abanned]' />","<value value='$direct_cachedata[i_abanned]' /><selected value='1' />","<evars><no><value value='0' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes></evars>");
		}
	}

/* -------------------------------------------------------------------------
Build the form
------------------------------------------------------------------------- */

	$direct_classes['formbuilder']->entry_add ("subtitle","profile_edit_core",(direct_local_get ("account_profile_edit_core")));

	if ($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type']) > 3)
	{
		$direct_classes['formbuilder']->entry_add_text ("ausername",(direct_local_get ("core_username")),true,"l",$direct_settings['users_min'],100,((direct_local_get ("core_helper_username_1")).$direct_settings['users_min'].(direct_local_get ("core_helper_username_2"))),"",true);
		$direct_classes['formbuilder']->entry_add_jfield_text ("atitle",(direct_local_get ("account_usertitle")),false,"l",0,255);
		$direct_classes['formbuilder']->entry_add_email ("aemail",(direct_local_get ("account_email")),true,"l",5,255);
	}
	else
	{
		if ($direct_settings['account_profile_username_change']) { $direct_classes['formbuilder']->entry_add_text ("ausername",(direct_local_get ("core_username")),true,"l",$direct_settings['users_min'],100,((direct_local_get ("core_helper_username_1")).$direct_settings['users_min'].(direct_local_get ("core_helper_username_2"))),"",true); }
		else { $direct_classes['formbuilder']->entry_add ("info","ainfo_1",(direct_local_get ("core_username"))); }

		$direct_classes['formbuilder']->entry_add ("info","ainfo_2",(direct_local_get ("account_email")));
	}

	$direct_classes['formbuilder']->entry_add_select ("aemail_public",(direct_local_get ("account_email_public")),false,"s");
//	$direct_classes['formbuilder']->entry_add_select ("atimezone",(direct_local_get ("account_timezone")),false,"s");
	$direct_classes['formbuilder']->entry_add_jfield_textarea ("asignature",(direct_local_get ("account_signature")),false,"s",0,65535);

/* -------------------------------------------------------------------------
Call registered mods
------------------------------------------------------------------------- */

	if ($g_mode_save) { direct_mods_include ($direct_settings['account_profile_mods_support'],"account_profile","edit_check"); }
	else { direct_mods_include ($direct_settings['account_profile_mods_support'],"account_profile","edit",$g_user_array); }

	if ($direct_settings['user']['id'] != $g_uid)
	{
		$direct_classes['formbuilder']->entry_add ("subtitle","profile_edit_admin",(direct_local_get ("account_profile_edit_admin")));

		if ($direct_settings['user']['type'] == "ad") { $direct_classes['formbuilder']->entry_add_select ("atype",(direct_local_get ("core_usertype")),true,"s"); }
		$direct_classes['formbuilder']->entry_add_select ("alocked",(direct_local_get ("core_usertype_locked")),false,"s");
		if ($direct_settings['user']['type'] == "ad") { $direct_classes['formbuilder']->entry_add_select ("abanned",(direct_local_get ("core_usertype_banned")),false,"s"); }
	}

	$direct_cachedata['output_formelements'] = $direct_classes['formbuilder']->form_get (true);

	if (($g_mode_save)&&($direct_classes['formbuilder']->check_result))
	{
/* -------------------------------------------------------------------------
Save data edited
------------------------------------------------------------------------- */

		$direct_cachedata['i_aemail_public'] = ($direct_cachedata['i_aemail_public'] ? 1 : 0);
		$g_continue_check = true;
		$g_username_invalid_chars = preg_replace ("#[0-9a-zA-Z\!\$\%\&\/\(\)\{\[\]\}\?\@\*\~\#,\.\-\;_ ]#i","",$direct_cachedata['i_ausername']);

		if ($direct_settings['account_profile_username_change'])
		{
			if (($g_user_array['ddbusers_name'] != $direct_cachedata['i_ausername'])&&($direct_classes['kernel']->v_user_check ("",$direct_cachedata['i_ausername'],true))) { $g_continue_check = false; }
		}

		if ($g_username_invalid_chars) { $direct_classes['error_functions']->error_page ("standard","account_username_invalid","SERVICE ERROR:<br />Allowed characters are: 0-9, a-z, A-Z as well as !$%&/(){}[]?@*~#,.-;_ and space<br />sWG/#echo(__FILEPATH__)# _a=edit-save_ (#echo(__LINE__)#)"); }
		elseif ($g_continue_check)
		{
			if (($direct_settings['account_profile_username_change'])&&($g_user_array['ddbusers_name'] != $direct_cachedata['i_ausername']))
			{
				$g_user_array['ddbusers_name'] = $direct_cachedata['i_ausername'];
				$g_continue_check = true;
			}
			else { $g_continue_check = false; }

			$g_user_array['ddbusers_email_public'] = $direct_cachedata['i_aemail_public'];

			$g_user_array['ddbusers_signature'] = $direct_classes['formtags']->encode ($direct_cachedata['i_asignature']);
			$g_user_array['ddbusers_signature'] = direct_output_smiley_encode ($g_user_array['ddbusers_signature']);

			if ($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type']) > 3)
			{
				$g_user_array['ddbusers_title'] = $direct_classes['formtags']->encode ($direct_cachedata['i_atitle'],true);
				$g_user_array['ddbusers_title'] = direct_output_smiley_encode ($g_user_array['ddbusers_title']);

				$g_user_array['ddbusers_email'] = $direct_cachedata['i_aemail'];
			}

			if (direct_mods_include ($direct_settings['account_profile_mods_support'],"account_profile","test")) { $g_user_array = direct_mods_include (true,"account_profile","edit_save",$g_user_array); }

			if (isset ($g_user_array['ddbusers_id']))
			{
$g_log_array = array (
"source_userid" => $direct_settings['user']['id'],
"source_userip" => $direct_settings['user_ip'],
"target_userid" => $g_uid,
"target_userip" => "",
"sid" => "e268443e43d93dab7ebef303bbe9642f" // md5 ("account")
);

				$g_user_array['ddbusers_locked'] = $direct_cachedata['i_alocked'];

				if ($direct_cachedata['i_abanned'])
				{
					$g_log_array['identifier'] = "account_banned";
					direct_log_write ($g_log_array);

					$g_user_array['ddbusers_banned'] = 1;
					$g_user_array['ddbusers_locked'] = 0;
				}
				elseif ($g_user_array['ddbusers_banned'])
				{
					$g_log_array['identifier'] = "account_unbanned";
					direct_log_write ($g_log_array);

					$g_user_array['ddbusers_banned'] = 0;
				}
				elseif ($direct_settings['user']['id'] != $g_uid)
				{
					$g_log_array['identifier'] = "account_edit";
					direct_log_write ($g_log_array);
				}

				if ($direct_classes['kernel']->v_user_update ($g_user_array['ddbusers_id'],$g_user_array))
				{
					if ($g_continue_check)
					{
$g_uuid_array = array (
"userid" => $g_user_array['ddbusers_id'],
"username" => $g_user_array['ddbusers_name']
);

						$direct_classes['kernel']->v_uuid_write (direct_evars_write ($g_uuid_array));
						$direct_settings['user'] = array ("id" => $g_uid,"name" => $g_user_array['ddbusers_name'],"name_html" => (direct_html_encode_special ($g_user_array['ddbusers_name'])),"type" => $direct_settings['user']['type'],"timezone" => $direct_settings['user']['timezone'],"groups" => $direct_settings['user']['groups'],"rights" => $direct_settings['user']['rights'],"unread_pms" => $direct_settings['user']['unread_pms']);
						$direct_classes['kernel']->v_uuid_cookie_save ();
					}

					$direct_cachedata['output_job'] = direct_local_get ("account_profile_edit");
					$direct_cachedata['output_job_desc'] = direct_local_get ("account_done_profile_edit");

					if ($g_target_url)
					{
						$g_target_link = str_replace ("[oid]","auid+{$g_user_array['ddbusers_id']}++",$g_target_url);

						$direct_cachedata['output_jsjump'] = 2000;
						$direct_cachedata['output_pagetarget'] = str_replace ('"',"",(direct_linker ("url0",$g_target_link)));
						$direct_cachedata['output_scripttarget'] = str_replace ('"',"",(direct_linker ("url0",$g_target_link,false)));
					}
					else { $direct_cachedata['output_jsjump'] = 0; }

					direct_output_related_manager ("account_profile_edit_{$g_user_array['ddbusers_type']}_{$g_uid}_form_save","post_module_service_action");
					$direct_classes['output']->oset ("default","done");
					$direct_classes['output']->options_flush (true);
					$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
					$direct_classes['output']->page_show ($direct_cachedata['output_job']);
				}
				else { $direct_classes['error_functions']->error_page ("fatal","core_database_error","sWG/#echo(__FILEPATH__)# _a=edit-save_ (#echo(__LINE__)#)"); }
			}
			else { $direct_classes['error_functions']->error_page ("fatal","core_unknown_error","sWG/#echo(__FILEPATH__)# _a=edit-save_ (#echo(__LINE__)#)"); }
		}
		else { $direct_classes['error_functions']->error_page ("standard","account_username_exists","SERVICE ERROR:<br />&quot;$direct_cachedata[i_ausername]&quot; has already been registered<br />sWG/#echo(__FILEPATH__)# _a=edit-save_ (#echo(__LINE__)#)"); }
	}
	else
	{
/* -------------------------------------------------------------------------
View form
------------------------------------------------------------------------- */

		$direct_cachedata['output_formbutton'] = direct_local_get ("core_save");
		$direct_cachedata['output_formtarget'] = "m=account&s=profile&a=edit-save&dsd=auid+$g_uid++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['output_formtitle'] = direct_local_get ("account_profile_edit");

		direct_output_related_manager ("account_profile_edit_{$g_user_array['ddbusers_type']}_{$g_uid}_form","post_module_service_action");
		$direct_classes['output']->oset ("default","form");
		$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
		$direct_classes['output']->page_show ($direct_cachedata['output_formtitle']);
	}
	//j// EOA
	}
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// $direct_settings['a'] == "rname"
case "rname":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=rname_ (#echo(__LINE__)#)"); }

	$g_username = (isset ($direct_settings['dsd']['idata']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['idata'])) : "");

	$direct_cachedata['page_this'] = "m=account&s=profile&a=rname&dsd=idata+".(urlencode ($g_username));
	$direct_cachedata['page_backlink'] = "m=account&s=profile&a=select";
	$direct_cachedata['page_homelink'] = "m=account&s=profile&a=select";

	if ($direct_classes['kernel']->service_init_default ())
	{
	//j// BOA
	if ($g_username)
	{
		direct_class_init ("output");
		$g_user_array = $direct_classes['kernel']->v_user_get ("",$g_username,true);

		if (is_array ($g_user_array)) { $direct_classes['output']->redirect (direct_linker ("url1","m=account&s=profile&a=view&dsd=auid+".$g_user_array['ddbusers_id'],false)); }
		else { $direct_classes['error_functions']->error_page ("standard","core_username_unknown","sWG/#echo(__FILEPATH__)# _a=rname_ (#echo(__LINE__)#)"); }
	}
	else { $direct_classes['error_functions']->error_page ("standard","core_unsupported_command","sWG/#echo(__FILEPATH__)# _a=rname_ (#echo(__LINE__)#)"); }
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// $direct_settings['a'] == "select"
case "select":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=select_ (#echo(__LINE__)#)"); }

	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['source'])) : "");
	$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['target'])) : "");

	$g_source_url = ($g_source ? base64_decode ($g_source) : "m=account&a=services");
	$g_target_url = ($g_target ? base64_decode ($g_target) : "m=account&s=profile&a=view&dsd=[oid]");

	$direct_cachedata['page_this'] = "m=account&s=profile&a=select&dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
	$direct_cachedata['page_backlink'] = str_replace ("[oid]","",$g_source_url);
	$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'];

	if ($direct_classes['kernel']->service_init_default ())
	{
	//j// BOA
	$direct_classes['kernel']->service_https ($direct_settings['account_https_profile_select'],$direct_cachedata['page_this']);
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php");
	direct_local_integration ("account");

/* -------------------------------------------------------------------------
Make sure that also guests are able to use the advantages of uuIDs
------------------------------------------------------------------------- */

	if ($direct_settings['user']['type'] == "gt")
	{
		$g_uuid_string = $direct_classes['kernel']->v_uuid_get ("s");

		if (!$g_uuid_string)
		{
			$g_uuid_string = "<evars><userid /></evars>";
			$direct_classes['kernel']->v_uuid_write ($g_uuid_string);
			$direct_classes['kernel']->v_uuid_cookie_save ();
		}
	}

	$g_selector_id = uniqid ("");

$g_task_array = array (
"core_back_return" => $g_source_url,
"core_sid" => "e268443e43d93dab7ebef303bbe9642f",
// md5 ("account")
"account_marked_return" => $g_target_url,
"account_marker_return" => "m=account&s=profile&a=select-post&dsd=atid+".$g_selector_id,
"account_marker_title_0" => direct_local_get ("account_profile_select"),
"account_selection_done" => 0,
"account_selection_quantity" => 1,
"uuid" => $direct_settings['uuid']
);

	direct_tmp_storage_write ($g_task_array,$g_selector_id,"e268443e43d93dab7ebef303bbe9642f","task_cache","evars",$direct_cachedata['core_time'],($direct_cachedata['core_time'] + 900));
	// md5 ("account")
	direct_class_init ("output");
	$direct_classes['output']->redirect (direct_linker ("url1","m=dataport&s=swgap;account;selector&dsd=dtheme+1++tid+".$g_selector_id,false));
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// $direct_settings['a'] == "select-post"
case "select-post":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=select-post_ (#echo(__LINE__)#)"); }

	$g_tid = (isset ($direct_settings['dsd']['atid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['atid'])) : "");

	$direct_cachedata['page_this'] = "";
	$direct_cachedata['page_backlink'] = "m=account&s=profile&a=select";
	$direct_cachedata['page_homelink'] = "m=account&s=services";

	if ($direct_classes['kernel']->service_init_default ())
	{
	//j// BOA
	$direct_classes['kernel']->service_https ($direct_settings['account_https_profile_select'],"m=account&s=profile&a=select-post&dsd=atid+".$g_tid);
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php");

	if ($g_tid == "") { $g_tid = $direct_settings['uuid']; }
	$g_task_array = direct_tmp_storage_get ("evars",$g_tid,"","task_cache");

	if (($g_task_array)&&(isset ($g_task_array['uuid']))&&($g_task_array['uuid'] == $direct_settings['uuid']))
	{
		$g_back_link = "m=account&s=profile&a=select&dsd=source+".(urlencode (base64_encode ($g_task_array['core_back_return'])));
		if (isset ($g_task_array['account_marked_return'])) { $g_back_link .= "++target+".(urlencode (base64_encode ($g_task_array['account_marked_return']))); }

		$direct_cachedata['page_backlink'] = $g_back_link;
		$direct_cachedata['page_homelink'] = str_replace ("[oid]","",$g_task_array['core_back_return']);

		if (empty ($g_task_array['account_users_marked'])) { $direct_classes['error_functions']->error_page ("standard","core_tid_invalid","sWG/#echo(__FILEPATH__)# _a=select-post_ (#echo(__LINE__)#)"); }
		else
		{
			$g_userid = array_shift ($g_task_array['account_users_marked']);

			if ($direct_classes['kernel']->v_user_check ($g_userid,"",true))
			{
				direct_class_init ("output");
				$direct_classes['output']->redirect (direct_linker ("url1",(str_replace ("[oid]","auid+{$g_userid}++",$g_task_array['account_marked_return'])),false));
			}
			else { $direct_classes['error_functions']->error_page ("standard","core_username_unknown","sWG/#echo(__FILEPATH__)# _a=select-post_ (#echo(__LINE__)#)"); }
		}
	}
	else { $direct_classes['error_functions']->error_page ("standard","core_tid_invalid","sWG/#echo(__FILEPATH__)# _a=select-post_ (#echo(__LINE__)#)"); }
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// $direct_settings['a'] == "view"
case "view":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=view_ (#echo(__LINE__)#)"); }

	$g_uid_d = (isset ($direct_settings['dsd']['auid_d']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['auid_d'])) : "");
	$g_uid = (isset ($direct_settings['dsd']['auid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['auid'])) : $g_uid_d);

	$direct_cachedata['page_this'] = "m=account&s=profile&a=view&dsd=auid+".$g_uid;
	$direct_cachedata['page_backlink'] = "m=account&s=profile&a=select";
	$direct_cachedata['page_homelink'] = "m=account&a=services";

	if ($direct_classes['kernel']->service_init_default ())
	{
	//j// BOA
	if (empty ($g_uid)) { $g_uid = $direct_settings['user']['id']; }
	$g_user_array = $direct_classes['kernel']->v_user_get ($g_uid,"",true);

	direct_output_related_manager ("account_profile_view_{$g_user_array['ddbusers_type']}_".$g_uid,"pre_module_service_action");
	$direct_classes['kernel']->service_https ($direct_settings['account_https_profile_view'],$direct_cachedata['page_this']);
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formtags.php");
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_mods_support.php");
	direct_local_integration ("account");

	if ($g_user_array)
	{
		direct_class_init ("formtags");
		direct_class_init ("output");
		$direct_classes['output']->servicemenu ("account");
		$direct_classes['output']->options_insert (2,"servicemenu","m=account&a=services",(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

		if ($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type']))
		{
			if ($g_uid == $direct_settings['user']['id']) { $direct_classes['output']->options_insert (1,"servicemenu","m=account&s=profile&a=edit",(direct_local_get ("account_profile_edit")),$direct_settings['serviceicon_account_profile_edit'],"url0"); }
			elseif (($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type']) > 3)||($direct_classes['kernel']->v_group_user_check_right ("account_profile_edit"))) { $direct_classes['output']->options_insert (1,"servicemenu","m=account&s=profile&a=edit&dsd=auid+".$g_uid,(direct_local_get ("account_profile_edit")),$direct_settings['serviceicon_account_profile_edit'],"url0"); }
		}

		$g_user_parsed_array = $direct_classes['kernel']->v_user_parse ($g_uid);

		$direct_cachedata['output_usertype'] = $g_user_parsed_array['type'];
		$direct_cachedata['output_username'] = $g_user_parsed_array['name'];
		$direct_cachedata['output_usertitle'] = $g_user_parsed_array['title'];

		$direct_cachedata['output_email'] = $g_user_parsed_array['email'];
		$direct_cachedata['output_pageurl_email'] = $g_user_parsed_array['pageurl_email'];
		$direct_cachedata['output_useravatar_large'] = ($g_user_parsed_array['avatar_large'] ? $g_user_parsed_array['avatar_large'] : "");
		$direct_cachedata['output_useravatar_small'] = ($g_user_parsed_array['avatar_small'] ? $g_user_parsed_array['avatar_small'] : "");
		$direct_cachedata['output_signature'] = $g_user_parsed_array['signature'];

		if ($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type']) > 3) { $direct_cachedata['output_registration_ip'] = ((($g_user_array['ddbusers_registration_ip'])&&($g_user_array['ddbusers_registration_ip'] != "unknown")) ? direct_html_encode_special ($g_user_array['ddbusers_registration_ip']) : direct_local_get ("core_unknown")); }
		else { $direct_cachedata['output_registration_ip'] = ""; }

		$direct_cachedata['output_registration_time'] = ($g_user_array['ddbusers_registration_time'] ? $direct_classes['basic_functions']->datetime ("longdate&time",$g_user_array['ddbusers_registration_time'],$direct_settings['user']['timezone'],(direct_local_get ("datetime_dtconnect"))) : direct_local_get ("core_unknown"));

		if ($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type']) > 3) { $direct_cachedata['output_lastvisit_ip'] = ((($g_user_array['ddbusers_lastvisit_ip'])&&($g_user_array['ddbusers_lastvisit_ip'] != "unknown")) ? direct_html_encode_special ($g_user_array['ddbusers_lastvisit_ip']) : direct_local_get ("core_unknown")); }
		else { $direct_cachedata['output_lastvisit_ip'] = ""; }

		$direct_cachedata['output_lastvisit_time'] = ($g_user_array['ddbusers_lastvisit_time'] ? $direct_classes['basic_functions']->datetime ("longdate&time",$g_user_array['ddbusers_lastvisit_time'],$direct_settings['user']['timezone'],(direct_local_get ("datetime_dtconnect"))) : direct_local_get ("account_profile_never_online"));
		$direct_cachedata['output_rating'] = $g_user_parsed_array['rating'];

		$direct_cachedata['output_modstoview'] = direct_mods_include ($direct_settings['account_profile_mods_support'],"account_profile","view",$g_user_array);

		direct_output_related_manager ("account_profile_view_{$g_user_array['ddbusers_type']}_".$g_uid,"post_module_service_action");
		$direct_classes['output']->oset ("account","view");
		$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
		$direct_classes['output']->page_show (direct_local_get ("account_profile_view"));
	}
	else { $direct_classes['error_functions']->error_page ("standard","core_username_unknown","sWG/#echo(__FILEPATH__)# _a=view_ (#echo(__LINE__)#)"); }
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>