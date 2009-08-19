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
* account/swg_forgotten_password.php
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

if (!isset ($direct_settings['account_https_forgotten_password'])) { $direct_settings['account_https_forgotten_password'] = false; }
if (!isset ($direct_settings['account_password_bytemix'])) { $direct_settings['account_password_bytemix'] = ($direct_settings['swg_id'] ^ (strrev ($direct_settings['swg_id']))); }
if (!isset ($direct_settings['account_secid_bytemix'])) { $direct_settings['account_secid_bytemix'] = $direct_settings['account_password_bytemix']; }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
if (!isset ($direct_settings['users_min'])) { $direct_settings['users_min'] = 3; }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGbasicVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "form"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// ($direct_settings['a'] == "form")||($direct_settings['a'] == "form-save")
case "form":
case "form-save":
{
	$g_mode_save = (($direct_settings['a'] == "form-save") ? true : false);
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }

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
		$direct_cachedata['page_backlink'] = "m=account&s=forgotten_password&a=form&dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_homelink'] = str_replace ("[oid]","",$g_source_url);
	}
	else
	{
		$direct_cachedata['page_this'] = "m=account&s=forgotten_password&a=form&dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_backlink'] = str_replace ("[oid]","",$g_source_url);
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'] ;
	}

	if ($direct_classes['kernel']->service_init_default ())
	{
	//j// BOA
	if ($direct_settings['user']['type'] == "gt")
	{
		if ($g_mode_save) { direct_output_related_manager ("account_forgotten_password_form_save","pre_module_service_action"); }
		else
		{
			direct_output_related_manager ("account_forgotten_password_form","pre_module_service_action");
			$direct_classes['kernel']->service_https ($direct_settings['account_https_forgotten_password'],$direct_cachedata['page_this']);
		}

		$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formbuilder.php");
		direct_local_integration ("account");

		if ($g_mode_save)
		{
			$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_sendmailer_formtags.php");
			$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_log_storager.php");
		}

		direct_class_init ("formbuilder");
		direct_class_init ("output");
		$direct_classes['output']->servicemenu ("account");
		$direct_classes['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

		if ($g_mode_save)
		{
/* -------------------------------------------------------------------------
We should have input in save mode
------------------------------------------------------------------------- */

			$direct_cachedata['i_ausername'] = (isset ($GLOBALS['i_ausername']) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS['i_ausername'])) : "");
			$direct_cachedata['i_asecid'] = (isset ($GLOBALS['i_asecid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS['i_asecid'])) : "");
		}
		else
		{
			$direct_cachedata['i_ausername'] = "";
			$direct_cachedata['i_asecid'] = "";
		}

/* -------------------------------------------------------------------------
Build the form
------------------------------------------------------------------------- */

		$direct_classes['formbuilder']->entry_add_text ("ausername",(direct_local_get ("core_username")),true,"l",$direct_settings['users_min'],100,((direct_local_get ("core_helper_username_1")).$direct_settings['users_min'].(direct_local_get ("core_helper_username_2"))),"",true);
		$direct_classes['formbuilder']->entry_add_password ("","asecid",(direct_local_get ("account_secid")),true,"m",96,96,(direct_local_get ("account_helper_secid")),"",false);

		$direct_cachedata['output_formelements'] = $direct_classes['formbuilder']->form_get ($g_mode_save);

		if (($g_mode_save)&&($direct_classes['formbuilder']->check_result))
		{
			$g_user_array = $direct_classes['kernel']->v_user_get ("",$direct_cachedata['i_ausername']);

			if ($g_user_array)
			{
				if ($g_user_array['ddbusers_banned']) { $direct_classes['error_functions']->error_page ("standard","account_username_banned","SECURITY ERROR:<br />&quot;$direct_cachedata[i_ausername]&quot; has been banned<br />sWG/#echo(__FILEPATH__)# _a=login-save_ (#echo(__LINE__)#)"); }
				elseif ($g_user_array['ddbusers_deleted']) { $direct_classes['error_functions']->error_page ("standard","core_username_unknown","SECURITY ERROR:<br />&quot;$direct_cachedata[i_ausername]&quot; was deleted<br />sWG/#echo(__FILEPATH__)# _a=login-save_ (#echo(__LINE__)#)"); }
				elseif ($g_user_array['ddbusers_locked']) { $direct_classes['error_functions']->error_page ("standard","account_username_locked","SECURITY ERROR:<br />&quot;$direct_cachedata[i_ausername]&quot; has been locked by the administration or the system<br />sWG/#echo(__FILEPATH__)# _a=login-save_ (#echo(__LINE__)#)"); }
				elseif (($g_user_array['ddbusers_secid'])&&($direct_cachedata['i_asecid'] == $g_user_array['ddbusers_secid']))
				{
					$g_password_base = md5 (uniqid (""));
					$g_password_offset = mt_rand (0,21);
					$g_password = substr ($g_password_base,$g_password_offset,10);
					$g_user_array['ddbusers_password'] = $direct_classes['basic_functions']->tmd5 ($g_password,$direct_settings['account_password_bytemix']);
					$g_user_array['ddbusers_secid'] = $direct_classes['basic_functions']->tmd5 ($g_password_base."_{$direct_cachedata['core_time']}_{$direct_cachedata['i_ausername']}_{$g_user_array['ddbusers_email']}_".$g_password,$direct_settings['account_secid_bytemix']);

					if ($direct_classes['kernel']->v_user_update ($g_user_array['ddbusers_id'],$g_user_array))
					{
						$g_sendmailer_object = new direct_sendmailer_formtags ();
						$g_sendmailer_object->recipients_define (array ($g_user_array['ddbusers_email'] => $direct_cachedata['i_ausername']));

$g_message = ("[contentform:highlight]".(direct_local_get ("core_message_by_request","text"))."

[font:bold]".(direct_local_get ("core_message_to","text")).":[/font] $direct_cachedata[i_ausername] ({$g_user_array['ddbusers_email']})[/contentform]
".(direct_local_get ("account_forgotten_password","text"))."

".(direct_local_get ("core_username","text")).": {$g_user_array['ddbusers_name']}
".(direct_local_get ("core_password","text")).": $g_password

".(direct_local_get ("account_password_reset_recommendation","text"))."

".(direct_local_get ("account_secid_howto","text"))."

".(direct_local_get ("account_secid","text")).":
".(wordwrap ($g_user_array['ddbusers_secid'],32,"\n",1))."

[hr]
(C) $direct_settings[swg_title_txt] ([url]{$direct_settings['home_url']}[/url])
All rights reserved");

						$g_sendmailer_object->message_set ($g_message);
						$g_sendmailer_object->send ("single",$direct_settings['administration_email_out'],$direct_settings['swg_title_txt']." - ".(direct_local_get ("account_title_secid","text")));

$g_log_array = array (
"source_user_id" => $g_user_array['ddbusers_id'],
"source_user_ip" => $direct_settings['user_ip'],
"sid" => "e268443e43d93dab7ebef303bbe9642f",
// md5 ("account")
"identifier" => "account_secid"
);

						direct_log_write ($g_log_array);

						$direct_cachedata['output_job'] = direct_local_get ("core_forgotten_password");
						$direct_cachedata['output_job_desc'] = direct_local_get ("account_done_forgotten_password");
						$direct_cachedata['output_jsjump'] = 0;

						if ($g_target_url)
						{
							$direct_cachedata['output_pagetarget'] = str_replace ("[oid]","",$g_target_url);
							$direct_cachedata['output_pagetarget'] = str_replace ('"',"",(direct_linker ("url0",$direct_cachedata['output_pagetarget'])));
						}
						else { $direct_cachedata['output_jsjump'] = 0; }

						direct_output_related_manager ("account_forgotten_password_form_save","post_module_service_action");
						$direct_classes['output']->oset ("default","done");
						$direct_classes['output']->options_flush (true);
						$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
						$direct_classes['output']->page_show ($direct_cachedata['output_job']);
					}
					else { $direct_classes['error_functions']->error_page ("fatal","core_database_error","sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }
				}
				else { $direct_classes['error_functions']->error_page ("standard","account_secid_invalid","sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }
			}
			else { $direct_classes['error_functions']->error_page ("standard","core_username_unknown","sWG/#echo(__FILEPATH__)# _a=form-save_ (#echo(__LINE__)#)"); }
		}
		else
		{
			$direct_cachedata['output_formbutton'] = direct_local_get ("core_continue");
			$direct_cachedata['output_formtarget'] = "m=account&s=forgotten_password&a=form-save&dsd=source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
			$direct_cachedata['output_formtitle'] = direct_local_get ("core_forgotten_password");

			direct_output_related_manager ("account_forgotten_password_form","post_module_service_action");
			$direct_classes['output']->oset ("default","form");
			$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_classes['output']->page_show ($direct_cachedata['output_formtitle']);
		}
	}
	else { $direct_classes['output']->redirect (direct_linker ("url1",$direct_cachedata['page_backlink'],false)); }
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>