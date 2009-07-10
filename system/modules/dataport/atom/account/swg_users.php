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
* dataport/atom/account/swg_users.php
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

if (!isset ($direct_settings['account_users_actives_timeshifts'])) { $direct_settings['account_users_actives_timeshifts'] = array (15,30,45,60,120,1440); }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGbasicVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "actives"
case "actives":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=actives_ (#echo(__LINE__)#)"); }

	$direct_classes['basic_functions']->settings_get ($direct_settings['path_data']."/settings/swg_account.php");

	if ($direct_classes['kernel']->service_init_rboolean ())
	{
	if ($direct_settings['account_actives'])
	{
	//j// BOA
	$g_minutes = (isset ($direct_settings['dsd']['aminutes']) ? ($direct_classes['basic_functions']->inputfilter_number ($direct_settings['dsd']['aminutes'])) : 15);
	if (!in_array ($g_minutes,$direct_settings['account_users_actives_timeshifts'])) { $g_minutes = 15; }

	direct_local_integration ("account");
	direct_class_init ("output");

	$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
	header ("Content-type: application/atom+xml; charset=".$direct_local['lang_charset']);

echo ("<?xml version='1.0' encoding='$direct_local[lang_charset]' ?><feed xmlns='http://www.w3.org/2005/Atom'><generator>$direct_settings[product_lcode_txt] by the direct Netware Group</generator>
<title type='xhtml'>".($direct_classes['xml_bridge']->array2xml_item_encoder (array ("tag" => "div","value" => (direct_local_get ("account_actives")),"attributes" => array ("xmlns" => "http://www.w3.org/1999/xhtml"))))."</title>
<subtitle type='xhtml'>".($direct_classes['xml_bridge']->array2xml_item_encoder (array ("tag" => "div","value" => (direct_local_get ("account_actives_1")).$g_minutes.(direct_local_get ("account_actives_2")),"attributes" => array ("xmlns" => "http://www.w3.org/1999/xhtml"))))."</subtitle>
".($direct_classes['xml_bridge']->array2xml_item_encoder (array ("tag" => "link","attributes" => array ("href" => (direct_linker_dynamic ("url1","m=account&a=actives&dsd=aminutes+".$g_minutes,false,false)),"rel" => "alternate","type" => "application/xhtml+xml"))))."
".($direct_classes['xml_bridge']->array2xml_item_encoder (array ("tag" => "link","attributes" => array ("href" => (direct_linker_dynamic ("url1","m=dataport&s=atom;account;users&a=actives&dsd=aminutes+".$g_minutes,false,false)),"rel" => "self","type" => "application/atom+xml"))))."
".($direct_classes['xml_bridge']->array2xml_item_encoder (array ("tag" => "updated","value" => gmdate ("c",$direct_cachedata['core_time']))))."
".($direct_classes['xml_bridge']->array2xml_item_encoder (array ("tag" => "id","value" => direct_linker_dynamic ("url1","m=dataport&s=atom;account;users&a=actives&dsd=aminutes+".$g_minutes,false,false)))));

	$direct_cachedata['output_users'] = array ();

	$direct_classes['db']->init_select ($direct_settings['users_table']);
	$direct_classes['db']->define_attributes ("*");

	$g_actives_timeout = $direct_cachedata['core_time'] - ($g_minutes * 60);

	$direct_classes['db']->define_row_conditions ("<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ("ddbusers_lastvisit_time",$g_actives_timeout,"number",">"))."</sqlconditions>");
	$direct_classes['db']->define_ordering ("<sqlordering><element1 attribute='ddbusers_lastvisit_time' type='desc' /></sqlordering>");

	$g_users_array = $direct_classes['db']->query_exec ("ma");

	if ((is_array ($g_users_array))&&(!empty ($g_users_array)))
	{
		foreach ($g_users_array as $g_user_array)
		{
			$g_user_parsed_array = $direct_classes['kernel']->v_user_parse ("",$g_user_array);

echo ("<entry>
<title type='xhtml'>".($direct_classes['xml_bridge']->array2xml_item_encoder (array ("tag" => "div","value" => $g_user_parsed_array['name'],"attributes" => array ("xmlns" => "http://www.w3.org/1999/xhtml"))))."</title>
<author>
".($direct_classes['xml_bridge']->array2xml_item_encoder (array ("tag" => "name","value" => $g_user_parsed_array['name'])))."
".($direct_classes['xml_bridge']->array2xml_item_encoder (array ("tag" => "uri","value" => direct_linker ("url1","m=account&s=profile&a=view&dsd=auid+".$g_user_array['ddbusers_id'],false,false))))."
</author>
<content type='application/xml'>
<person xmlns='http://ns.opensocial.org/2008/opensocial'>
".($direct_classes['xml_bridge']->array2xml_item_encoder (array ("tag" => "id","value" => $g_user_array['ddbusers_id'])))."
".($direct_classes['xml_bridge']->array2xml_item_encoder (array ("tag" => "nickname","value" => $g_user_parsed_array['name'])))."
".($direct_classes['xml_bridge']->array2xml_item_encoder (array ("tag" => "profile_url","value" => direct_linker_dynamic ("url1","m=account&s=profile&a=view&dsd=auid+".$g_user_array['ddbusers_id'],false,false))))."
".($direct_classes['xml_bridge']->array2xml_item_encoder (array ("tag" => "network_presence","value" => (direct_local_get ("account_online")),"attributes" => array ("key" => "ONLINE"))))."
</person>
</content>
".($direct_classes['xml_bridge']->array2xml_item_encoder (array ("tag" => "updated","value" => gmdate ("c",$g_user_array['ddbusers_lastvisit_time']))))."
".($direct_classes['xml_bridge']->array2xml_item_encoder (array ("tag" => "id","value" => direct_linker_dynamic ("url1","m=account&s=profile&a=view&dsd=auid+".$g_user_array['ddbusers_id'],false,false))))."
</entry>");
		}
	}

	echo "</feed>";
	//j// EOA
	}
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>