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
* account/swg_index.php
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

if (!isset ($direct_settings['account_users_actives'])) { $direct_settings['account_users_actives'] = true; }
if (!isset ($direct_settings['account_users_actives_timeshifts'])) { $direct_settings['account_users_actives_timeshifts'] = array (15,30,45,60,120,1440); }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGbasicVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "services"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "actives"
case "actives":
{
	$g_mode_atom = (($direct_settings['ohandler'] == "atom") ? true : false);
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=actives_ (#echo(__LINE__)#)"); }

	$direct_cachedata['output_minutes'] = (isset ($direct_settings['dsd']['aminutes']) ? ($direct_globals['basic_functions']->inputfilter_number ($direct_settings['dsd']['aminutes'])) : 15);
	if (!in_array ($direct_cachedata['output_minutes'],$direct_settings['account_users_actives_timeshifts'])) { $direct_cachedata['output_minutes'] = 15; }

	$direct_cachedata['page_this'] = $direct_settings['ohandler'].";m=account;a=actives;dsd=aminutes+".$direct_cachedata['output_minutes'];
	$direct_cachedata['page_backlink'] = "";
	$direct_cachedata['page_homelink'] = "m=account;a=services";

	if ($direct_globals['kernel']->service_init_default ())
	{
	if ($direct_settings['account_users_actives'])
	{
	//j// BOA
	if (!$g_mode_atom) { $direct_globals['output']->related_manager ("account_index_actives","pre_module_service_action"); }
	direct_local_integration ("account");

	if (!$g_mode_atom)
	{
		$direct_globals['output']->servicemenu ("account");
		$direct_globals['output']->options_insert (2,"servicemenu","m=account;a=services",(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");
	}

	$direct_cachedata['output_users'] = array ();

	$direct_globals['db']->init_select ($direct_settings['users_table']);
	$direct_globals['db']->define_attributes ("*");

	$g_actives_timeout = $direct_cachedata['core_time'] - ($direct_cachedata['output_minutes'] * 60);

	$direct_globals['db']->define_row_conditions ("<sqlconditions>".($direct_globals['db']->define_row_conditions_encode ("ddbusers_lastvisit_time",$g_actives_timeout,"number",">"))."</sqlconditions>");
	$direct_globals['db']->define_ordering ("<sqlordering><element1 attribute='ddbusers_lastvisit_time' type='desc' /></sqlordering>");

	$g_users_array = $direct_globals['db']->query_exec ("ma");

	if ($g_mode_atom)
	{
$direct_globals['output']->output_content = ("<subtitle type='xhtml'>".($direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "div","value" => (direct_local_get ("account_actives_1","text")).$direct_cachedata['output_minutes'].(direct_local_get ("account_actives_2","text")),"attributes" => array ("xmlns" => "http://www.w3.org/1999/xhtml"))))."</subtitle>
".($direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "link","attributes" => array ("href" => (direct_linker_dynamic ("url1","atom;m=account;a=actives;dsd=aminutes+".$direct_cachedata['output_minutes'],false,false)),"rel" => "self","type" => "application/atom+xml"))))."
".($direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "link","attributes" => array ("href" => (direct_linker_dynamic ("url1","m=account;a=actives;dsd=aminutes+".$direct_cachedata['output_minutes'],false,false)),"rel" => "alternate","type" => "application/xhtml+xml"))))."
".($direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "updated","value" => gmdate ("c",$direct_cachedata['core_time']))))."
".($direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "id","value" => "urn:de.direct-netware.xmlns:atom.parameters:m=account;a=actives;dsd=aminutes+".$direct_cachedata['output_minutes']))));
	}

	if ((is_array ($g_users_array))&&(!empty ($g_users_array)))
	{
		foreach ($g_users_array as $g_user_array)
		{
			$g_user_parsed_array = $direct_globals['kernel']->v_user_parse ("",$g_user_array);

			if ($g_mode_atom)
			{
$direct_globals['output']->output_content .= ("<entry>
<title type='xhtml'><div xmlns='http://www.w3.org/1999/xhtml'>{$g_user_parsed_array['name']}</div></title>
<author><div xmlns='http://www.w3.org/1999/xhtml'>{$g_user_parsed_array['name']}</div>
".($direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "uri","value" => direct_linker ("url1","m=account;s=profile;a=view;dsd=auid+".$g_user_array['ddbusers_id'],false,false))))."
</author>
<content type='application/xml'>
<person xmlns='http://ns.opensocial.org/2008/opensocial'>
".($direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "id","value" => $g_user_array['ddbusers_id'])))."
".($direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "nickname","value" => $g_user_parsed_array['name'])))."
".($direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "profile_url","value" => direct_linker_dynamic ("url1","m=account;s=profile;a=view;dsd=auid+".$g_user_array['ddbusers_id'],false,false))))."
".($direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "network_presence","value" => (direct_local_get ("account_online","text")),"attributes" => array ("key" => "ONLINE"))))."
</person>
</content>
".($direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "updated","value" => gmdate ("c",$g_user_array['ddbusers_lastvisit_time']))))."
".($direct_globals['xml_bridge']->array2xml_item_encoder (array ("tag" => "id","value" => "urn:de.direct-netware.xmlns:atom.id:".$g_user_array['ddbusers_id'])))."
</entry>");
			}
			else { $direct_cachedata['output_users'][] = $g_user_parsed_array; }
		}
	}

	$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);

	if (!$g_mode_atom)
	{
		$direct_globals['output']->header_elements ("<link rel='alternate' type='application/atom+xml' href='".(direct_linker_dynamic ("url1","atom;m=account;a=actives;dsd=aminutes+".$direct_cachedata['output_minutes'],true,false))."' title=\"".(direct_local_get ("account_actives"))."\" />");
		$direct_globals['output']->related_manager ("account_index_actives","post_module_service_action");
		$direct_globals['output']->oset ("account","actives");
	}

	$direct_globals['output']->output_send (direct_local_get ("account_actives"));
	//j// EOA
	}
	else { $direct_globals['output']->output_send_error ("standard","core_service_inactive","","sWG/#echo(__FILEPATH__)# _a=actives_ (#echo(__LINE__)#)"); }
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// $direct_settings['a'] == "services"
case "services":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=services_ (#echo(__LINE__)#)"); }

	$direct_cachedata['output_page'] = (isset ($direct_settings['dsd']['page']) ? ($direct_globals['basic_functions']->inputfilter_number ($direct_settings['dsd']['page'])) : 1);

	$direct_cachedata['page_this'] = "m=account;a=services;dsd=page+".$direct_cachedata['output_page'];
	$direct_cachedata['page_backlink'] = "";
	$direct_cachedata['page_homelink'] = "";

	if ($direct_globals['kernel']->service_init_default ())
	{
	//j// BOA
	$direct_globals['output']->related_manager ("account_index_services","pre_module_service_action");
	$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formtags.php");
	$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_service_list.php");
	$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php");
	direct_local_integration ("account");

	direct_class_init ("formtags");

	$g_uuid = $direct_globals['input']->uuid_get ();

	$direct_cachedata['output_filter_fid'] = "account_services";
	$direct_cachedata['output_filter_source'] = urlencode (base64_encode ($direct_cachedata['page_this']));
	$direct_cachedata['output_filter_text'] = "";
	$direct_cachedata['output_filter_tid'] = (($direct_settings['user']['type'] == "gt") ? "" : $g_uuid);

	$g_task_array = direct_tmp_storage_get ("evars",$g_uuid,"","task_cache");

	if (($g_task_array)&&(isset ($g_task_array['core_filter_account_services']))&&($g_task_array['uuid'] == $g_uuid))
	{
		$direct_cachedata['output_filter_text'] = $direct_globals['formtags']->decode ($g_task_array['core_filter_account_services']);
		$g_services_array = direct_service_list_search ("account",$direct_cachedata['output_filter_text'],"title-desc_preg",$direct_cachedata['output_page']);
	}
	else { $g_services_array = direct_service_list ("account",$direct_cachedata['output_page']); }

	$direct_cachedata['output_services'] = $g_services_array['list'];

	$direct_cachedata['output_page'] = $g_services_array['data']['page'];
	$direct_cachedata['output_page_url'] = "m=account;a=services;dsd=";
	$direct_cachedata['output_pages'] = $g_services_array['data']['pages'];
	$direct_cachedata['output_services_title'] = direct_local_get ("account_service_list");

	$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
	$direct_globals['output']->related_manager ("account_index_services","post_module_service_action");
	$direct_globals['output']->oset ("default","service_list");
	$direct_globals['output']->output_send (direct_local_get ("account_center"));
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>