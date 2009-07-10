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
* developer/swg_sqlsource.php
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
* @subpackage developer
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

if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGbasicVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "decode"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "decode"
case "decode":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=decode_ (#echo(__LINE__)#)"); }

	$direct_cachedata['output_page'] = $direct_classes['basic_functions']->inputfilter_number ($direct_settings['dsd']['page']);

	$direct_cachedata['page_this'] = "m=developer&s=sqlsource";
	$direct_cachedata['page_backlink'] = "m=developer&a=services";
	$direct_cachedata['page_homelink'] = "m=developer&a=services";

	if ($direct_classes['kernel']->service_init_default ())
	{
	//j// BOA
	direct_output_related_manager ("developer_sqlsource_decode","pre_module_service_action");
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formbuilder.php");
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/developer/swg_sqlsource.php");
	direct_local_integration ("developer");

	direct_class_init ("formbuilder");
	direct_class_init ("output");
	$direct_classes['output']->options_insert (1,"servicemenu","m=developer&a=services",(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

	$direct_cachedata['i_dinput'] = (isset ($GLOBALS['i_dinput']) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS['i_dinput'])) : "");
	$direct_classes['formbuilder']->entry_add_textarea ("dinput",(direct_local_get ("developer_input")),false,"s",1);

	$direct_cachedata['output_sql_source'] = "";
	$direct_cachedata['output_sql_result'] = "";
	$g_sql_word_position = 0;

	if ($direct_cachedata['i_dinput'])
	{
		$direct_cachedata['i_dinput'] = str_replace ("\n"," ",$direct_cachedata['i_dinput']);
		$direct_cachedata['i_dinput'] = str_replace ("\r","",$direct_cachedata['i_dinput']);

		$direct_cachedata['i_dinput'] = preg_replace ("#(\w)(\W{0,})\=#i","\\1 \\2= ",$direct_cachedata['i_dinput']);
		$direct_cachedata['i_dinput'] = str_replace (","," , ",$direct_cachedata['i_dinput']);
		$direct_cachedata['i_dinput'] = str_replace ("("," ( ",$direct_cachedata['i_dinput']);
		$direct_cachedata['i_dinput'] = str_replace (")"," ) ",$direct_cachedata['i_dinput']);

		$direct_cachedata['i_dinput'] = preg_replace ("#([ ]+)#i"," ",$direct_cachedata['i_dinput']);

		$g_sql_word_array = explode (" ",$direct_cachedata['i_dinput']);

		switch (strtolower ($g_sql_word_array[0]))
		{
		case "delete":
		{
			$g_sql_word_position = 2;

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[($g_sql_word_position + 1)],"as") === false)
			{
				$direct_cachedata['output_sql_source'] = "\$direct_classes['db']->init_delete ({$g_sql_word_array[$g_sql_word_position]});\n\n";
				$direct_classes['db']->init_delete ($g_sql_word_array[$g_sql_word_position]);
				$g_sql_word_position++;
			}
			else
			{
				$direct_cachedata['output_sql_source'] = "\$direct_classes['db']->init_delete ({$g_sql_word_array[$g_sql_word_position]} AS {$g_sql_word_array[($g_sql_word_position + 2)]});\n\n";
				$direct_classes['db']->init_delete ($g_sql_word_array[$g_sql_word_position]." AS ".$g_sql_word_array[($g_sql_word_position + 2)]);
				$g_sql_word_position += 3;
			}

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"where") !== false)
			{
				$g_sql_word_position++;

$direct_cachedata['output_sql_source'] .= ("\$g_conditions = (\"&lt;sqlconditions&gt;
".(direct_html_encode_special (direct_developer_sqlsource_get_row_conditions ($g_sql_word_array,$g_sql_word_position)))."
&lt;/sqlconditions&gt;\");

\$direct_classes['db']->define_row_conditions (\$g_conditions);\n\n");

				$direct_classes['db']->define_row_conditions ("<sqlconditions><element1 attribute='attribute' value='value' type='string' /></sqlconditions>");
			}

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"order") !== false)
			{
				$g_sql_word_position += 2;

$direct_cachedata['output_sql_source'] .= ("\$g_ordering = (\"&lt;sqlordering&gt;
".(direct_html_encode_special (direct_developer_sqlsource_get_ordering ($g_sql_word_array,$g_sql_word_position)))."
&lt;/sqlordering&gt;\");

\$direct_classes['db']->define_ordering (\$g_ordering);\n\n");

				$direct_classes['db']->define_ordering ("<sqlordering><element1 attribute='attribute' type='asc' /></sqlordering>");
			}

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"limit") !== false)
			{
				$g_sql_word_position++;

				$direct_cachedata['output_sql_source'] .= ("\$direct_classes['db']->define_limit ({$g_sql_word_array[$g_sql_word_position]});\n\n");
				$direct_classes['db']->define_limit ($g_sql_word_array[$g_sql_word_position]);

				$g_sql_word_position++;
			}

			$direct_cachedata['output_sql_source'] = str_replace ("''","'",$direct_cachedata['output_sql_source']);
			$direct_cachedata['output_sql_source'] .= "\$direct_classes['db']->query_exec (\"co\");";

			break 1;
		}
		case "insert":
		{
			$g_continue_check = true;
			$g_sql_word_position = 1;
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"into") !== false) { $g_sql_word_position++; }

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[($g_sql_word_position + 1)],"as") === false)
			{
				$direct_cachedata['output_sql_source'] = "\$direct_classes['db']->init_insert ({$g_sql_word_array[$g_sql_word_position]});\n\n";
				$direct_classes['db']->init_insert ($g_sql_word_array[$g_sql_word_position]);
				$g_sql_word_position++;
			}
			else
			{
				$direct_cachedata['output_sql_source'] = "\$direct_classes['db']->init_insert ({$g_sql_word_array[$g_sql_word_position]} AS {$g_sql_word_array[($g_sql_word_position + 2)]});\n\n";
				$direct_classes['db']->init_insert ($g_sql_word_array[$g_sql_word_position]." AS ".$g_sql_word_array[($g_sql_word_position + 2)]);
				$g_sql_word_position += 3;
			}

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"set") !== false)
			{
$direct_cachedata['output_sql_source'] .= ("\$g_attributes = (\"&lt;sqlvalues&gt;
".(direct_html_encode_special (direct_developer_sqlsource_get_set_attributes ($g_sql_word_array,$g_sql_word_position)))."
&lt;/sqlvalues&gt;\");

\$direct_classes['db']->define_set_attributes (\$g_attributes);\n\n");

				$direct_classes['db']->define_set_attributes ("<sqlvalues><element1 attribute='attribute' value='value' type='string' /></sqlvalues>");
				$g_continue_check = false;
			}

			if (($g_continue_check)&&($g_sql_word_array[$g_sql_word_position] == "("))
			{
				$g_sql_word_position++;

$direct_cachedata['output_sql_source'] .= ("\$g_keys = array (".(direct_html_encode_special (direct_developer_sqlsource_get_values_keys ($g_sql_word_array,$g_sql_word_position))).");
\$direct_classes['db']->define_values_keys (\$g_keys);\n\n");

				$direct_classes['db']->define_values_keys (array ("attribute"));
				$g_sql_word_position++;
			}

			if (($g_continue_check)&&(/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"values") !== false))
			{
				$g_sql_word_position += 2;

$direct_cachedata['output_sql_source'] .= ("\$g_values = (\"&lt;sqlvalues&gt;
".(direct_html_encode_special (direct_developer_sqlsource_get_values ($g_sql_word_array,$g_sql_word_position)))."
&lt;/sqlvalues&gt;\");

\$direct_classes['db']->define_values (\$g_values);\n\n");

				$direct_classes['db']->define_values ("<sqlvalues><element1 value='value' type='string' /></sqlvalues>");
				$g_sql_word_position++;
			}

			$direct_cachedata['output_sql_source'] = str_replace ("''","'",$direct_cachedata['output_sql_source']);
			$direct_cachedata['output_sql_source'] .= "\$direct_classes['db']->query_exec (\"co\");";

			break 1;
		}
		case "replace":
		{
			$g_continue_check = true;
			$g_sql_word_position = 1;
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"into") !== false) { $g_sql_word_position++; }

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[($g_sql_word_position + 1)],"as") === false)
			{
				$direct_cachedata['output_sql_source'] = "\$direct_classes['db']->init_replace ({$g_sql_word_array[$g_sql_word_position]});\n\n";
				$direct_classes['db']->init_replace ($g_sql_word_array[$g_sql_word_position]);
				$g_sql_word_position++;
			}
			else
			{
				$direct_cachedata['output_sql_source'] = "\$direct_classes['db']->init_replace ({$g_sql_word_array[$g_sql_word_position]} AS {$g_sql_word_array[($g_sql_word_position + 2)]});\n\n";
				$direct_classes['db']->init_replace ($g_sql_word_array[$g_sql_word_position]." AS ".$g_sql_word_array[($g_sql_word_position + 2)]);
				$g_sql_word_position += 3;
			}

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"set") !== false)
			{
$direct_cachedata['output_sql_source'] .= ("\$g_attributes = (\"&lt;sqlvalues&gt;
".(direct_html_encode_special (direct_developer_sqlsource_get_set_attributes ($g_sql_word_array,$g_sql_word_position)))."
&lt;/sqlvalues&gt;\");

\$direct_classes['db']->define_set_attributes (\$g_attributes);\n\n");

				$direct_classes['db']->define_set_attributes ("<sqlvalues><element1 attribute='attribute' value='value' type='string' /></sqlvalues>");
				$g_continue_check = false;
			}

			if (($g_continue_check)&&($g_sql_word_array[$g_sql_word_position] == "("))
			{
				$g_sql_word_position++;

$direct_cachedata['output_sql_source'] .= ("\$g_keys = array (".(direct_html_encode_special (direct_developer_sqlsource_get_values_keys ($g_sql_word_array,$g_sql_word_position))).");
\$direct_classes['db']->define_values_keys (\$g_keys);\n\n");

				$direct_classes['db']->define_values_keys (array ("attribute"));
				$g_sql_word_position++;
			}

			if (($g_continue_check)&&(/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"values") !== false))
			{
				$g_sql_word_position += 2;

$direct_cachedata['output_sql_source'] .= ("\$g_values = (\"&lt;sqlvalues&gt;
".(direct_html_encode_special (direct_developer_sqlsource_get_values ($g_sql_word_array,$g_sql_word_position)))."
&lt;/sqlvalues&gt;\");

\$direct_classes['db']->define_values (\$g_values);\n\n");

				$direct_classes['db']->define_values ("<sqlvalues><element1 value='value' type='string' /></sqlvalues>");
				$g_sql_word_position++;
			}

			$direct_cachedata['output_sql_source'] = str_replace ("''","'",$direct_cachedata['output_sql_source']);
			$direct_cachedata['output_sql_source'] .= "\$direct_classes['db']->query_exec (\"co\");";

			break 1;
		}
		case "select":
		{
			$g_sql_word_position = 1;

			if ($g_sql_word_array[$g_sql_word_position] == "*")
			{
				$g_attributes_code = "\$direct_classes['db']->define_attributes (\"*\");\n\n";
				$g_sql_word_position++;
			}
			else
			{
				$g_attributes_code = "\$g_attributes = array (";
				$g_comma_check = false;
				$g_continue_check = true;

				do
				{
					if ($g_comma_check) { $g_attributes_code .= ","; }
					else { $g_comma_check = true; }

					switch (strtolower ($g_sql_word_array[($g_sql_word_position + 1)]))
					{
					case "(":
					{
						if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"count") !== false) { $g_attributes_code .= "\"count-rows({$g_sql_word_array[($g_sql_word_position + 2)]})\""; }
						elseif (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"sum") !== false) { $g_attributes_code .= "\"sum-rows({$g_sql_word_array[($g_sql_word_position + 2)]})\""; }
						else { $g_attributes_code .= "\"{$g_sql_word_array[$g_sql_word_position]}({$g_sql_word_array[($g_sql_word_position + 2)]})\""; }

						$g_sql_word_position += 3;
						break 1;
					}
					case "as":
					{
						$g_attributes_code .= "\"{$g_sql_word_array[$g_sql_word_position]} AS {$g_sql_word_array[($g_sql_word_position + 2)]}\"";
						$g_sql_word_position += 2;
						break 1;
					}
					default: { $g_attributes_code .= "\"{$g_sql_word_array[$g_sql_word_position]}\""; }
					}

					$g_sql_word_position++;

					if ($g_sql_word_array[$g_sql_word_position] == ",") { $g_sql_word_position++; }
					else { $g_continue_check = false; }
				}
				while ($g_continue_check);

				$g_attributes_code .= ");\n\$direct_classes['db']->define_attributes (\$g_attributes);\n\n";
			}

			$g_sql_word_position++;

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[($g_sql_word_position + 1)],"as") === false)
			{
				$direct_cachedata['output_sql_source'] = "\$direct_classes['db']->init_select ({$g_sql_word_array[$g_sql_word_position]});\n\n".$g_attributes_code;
				$direct_classes['db']->init_select ($g_sql_word_array[$g_sql_word_position]);
				$g_sql_word_position++;
			}
			else
			{
				$direct_cachedata['output_sql_source'] = "\$direct_classes['db']->init_select ({$g_sql_word_array[$g_sql_word_position]} AS {$g_sql_word_array[($g_sql_word_position + 2)]});\n\n".$g_attributes_code;
				$direct_classes['db']->init_select ($g_sql_word_array[$g_sql_word_position]." AS ".$g_sql_word_array[($g_sql_word_position + 2)]);
				$g_sql_word_position += 3;
			}

			$direct_classes['db']->define_attributes (array ("attributes"));

			$g_continue_check = true;

			do
			{
				switch (strtolower ($g_sql_word_array[$g_sql_word_position]))
				{
				case "cross":
				{
					$g_sql_word_position += 2;
					break 1;
				}
				case "inner":
				{
					$g_sql_word_position += 2;
					break 1;
				}
				case "left":
				{
					$g_sql_word_position++;
					if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"outer") !== false) { $g_sql_word_position++; }
					$g_sql_word_position++;

					$g_attribute = $g_sql_word_array[$g_sql_word_position];
					$g_sql_word_position++;

					if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"AS") !== false)
					{
						$g_sql_word_position++;
						$g_attribute .= " AS ".$g_sql_word_array[$g_sql_word_position];
						$g_sql_word_position++;
					}

					if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"on") !== false) { $g_sql_word_position++; }

$direct_cachedata['output_sql_source'] .= ("\$g_conditions = (\"&lt;sqlconditions&gt;
".(direct_html_encode_special (direct_developer_sqlsource_get_row_conditions ($g_sql_word_array,$g_sql_word_position)))."
&lt;/sqlconditions&gt;\");

\$direct_classes['db']->define_join (\"left-outer-join\",\"$g_attribute\",\$g_conditions);\n\n");

					$direct_classes['db']->define_join ("left-outer-join",$g_attribute,"<sqlconditions><element1 attribute='attribute' value='value' type='string' /></sqlconditions>");
					break 1;
				}
				case "natural":
				{
					$g_sql_word_position++;
					if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"right") !== false) { $g_sql_word_position++; }
					if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"outer") !== false) { $g_sql_word_position++; }
					$g_sql_word_position++;

					break 1;
				}
				case "right":
				{
					$g_sql_word_position++;
					if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"outer") !== false) { $g_sql_word_position++; }
					$g_sql_word_position++;

					$g_attribute = $g_sql_word_array[$g_sql_word_position];
					$g_sql_word_position++;

					if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"AS") !== false)
					{
						$g_sql_word_position++;
						$g_attribute .= " AS ".$g_sql_word_array[$g_sql_word_position];
						$g_sql_word_position++;
					}

					if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"on") !== false) { $g_sql_word_position++; }

$direct_cachedata['output_sql_source'] .= ("\$g_conditions = (\"&lt;sqlconditions&gt;
".(direct_html_encode_special (direct_developer_sqlsource_get_row_conditions ($g_sql_word_array,$g_sql_word_position)))."
&lt;/sqlconditions&gt;\");

\$direct_classes['db']->define_join (\"right-outer-join\",\"$g_attribute\",\$g_conditions);\n\n");

					$direct_classes['db']->define_join ("right-outer-join",$g_attribute,"<sqlconditions><element1 attribute='attribute' value='value' type='string' /></sqlconditions>");
					break 1;
				}
				default: { $g_continue_check = false; }
				}
			}
			while ($g_continue_check);

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"where") !== false)
			{
				$g_sql_word_position++;

$direct_cachedata['output_sql_source'] .= ("\$g_conditions = (\"&lt;sqlconditions&gt;
".(direct_html_encode_special (direct_developer_sqlsource_get_row_conditions ($g_sql_word_array,$g_sql_word_position)))."
&lt;/sqlconditions&gt;\");

\$direct_classes['db']->define_row_conditions (\$g_conditions);\n\n");

				$direct_classes['db']->define_row_conditions ("<sqlconditions><element1 attribute='attribute' value='value' type='string' /></sqlconditions>");
			}

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"order") !== false)
			{
				$g_sql_word_position += 2;

$direct_cachedata['output_sql_source'] .= ("\$g_ordering = (\"&lt;sqlordering&gt;
".(direct_html_encode_special (direct_developer_sqlsource_get_ordering ($g_sql_word_array,$g_sql_word_position)))."
&lt;/sqlordering&gt;\");

\$direct_classes['db']->define_ordering (\$g_ordering);\n\n");

				$direct_classes['db']->define_ordering ("<sqlordering><element1 attribute='attribute' type='asc' /></sqlordering>");
			}

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"limit") !== false)
			{
				$g_sql_word_position++;

				$direct_cachedata['output_sql_source'] .= ("\$direct_classes['db']->define_limit ({$g_sql_word_array[$g_sql_word_position]});\n\n");
				$direct_classes['db']->define_limit ($g_sql_word_array[$g_sql_word_position]);

				$g_sql_word_position++;
			}

			if (($g_sql_word_array[$g_sql_word_position] == ",")||(/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"offset") !== false))
			{
				$g_sql_word_position++;

				$direct_cachedata['output_sql_source'] .= ("\$direct_classes['db']->define_offset ({$g_sql_word_array[$g_sql_word_position]});\n\n");
				$direct_classes['db']->define_offset ($g_sql_word_array[$g_sql_word_position]);

				$g_sql_word_position++;
			}

			$direct_cachedata['output_sql_source'] = str_replace ("''","'",$direct_cachedata['output_sql_source']);
			$direct_cachedata['output_sql_source'] .= "\$direct_classes['db']->query_exec (\"co\");";

			break 1;
		}
		case "update":
		{
			$g_sql_word_position = 1;

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[($g_sql_word_position + 1)],"as") === false)
			{
				$direct_cachedata['output_sql_source'] = "\$direct_classes['db']->init_update ({$g_sql_word_array[$g_sql_word_position]});\n\n";
				$direct_classes['db']->init_update ($g_sql_word_array[$g_sql_word_position]);
				$g_sql_word_position++;
			}
			else
			{
				$direct_cachedata['output_sql_source'] = "\$direct_classes['db']->init_update ({$g_sql_word_array[$g_sql_word_position]} AS {$g_sql_word_array[($g_sql_word_position + 2)]});\n\n";
				$direct_classes['db']->init_update ($g_sql_word_array[$g_sql_word_position]." AS ".$g_sql_word_array[($g_sql_word_position + 2)]);
				$g_sql_word_position += 3;
			}

			$g_sql_word_position++;

$direct_cachedata['output_sql_source'] .= ("\$g_attributes = (\"&lt;sqlvalues&gt;
".(direct_html_encode_special (direct_developer_sqlsource_get_set_attributes ($g_sql_word_array,$g_sql_word_position)))."
&lt;/sqlvalues&gt;\");

\$direct_classes['db']->define_set_attributes (\$g_attributes);\n\n");

			$direct_classes['db']->define_set_attributes ("<sqlvalues><element1 attribute='attribute' value='value' type='string' /></sqlvalues>");

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"where") !== false)
			{
				$g_sql_word_position++;

$direct_cachedata['output_sql_source'] .= ("\$g_conditions = (\"&lt;sqlconditions&gt;
".(direct_html_encode_special (direct_developer_sqlsource_get_row_conditions ($g_sql_word_array,$g_sql_word_position)))."
&lt;/sqlconditions&gt;\");

\$direct_classes['db']->define_row_conditions (\$g_conditions);\n\n");

				$direct_classes['db']->define_row_conditions ("<sqlconditions><element1 attribute='attribute' value='value' type='string' /></sqlconditions>");
			}

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"order") !== false)
			{
				$g_sql_word_position += 2;

$direct_cachedata['output_sql_source'] .= ("\$g_ordering = (\"&lt;sqlordering&gt;
".(direct_html_encode_special (direct_developer_sqlsource_get_ordering ($g_sql_word_array,$g_sql_word_position)))."
&lt;/sqlordering&gt;\");

\$direct_classes['db']->define_ordering (\$g_ordering);\n\n");

				$direct_classes['db']->define_ordering ("<sqlordering><element1 attribute='attribute' type='asc' /></sqlordering>");
			}

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($g_sql_word_array[$g_sql_word_position],"limit") !== false)
			{
				$g_sql_word_position++;

				$direct_cachedata['output_sql_source'] .= ("\$direct_classes['db']->define_limit ({$g_sql_word_array[$g_sql_word_position]});\n\n");
				$direct_classes['db']->define_limit ($g_sql_word_array[$g_sql_word_position]);

				$g_sql_word_position++;
			}

			$direct_cachedata['output_sql_source'] = str_replace ("''","'",$direct_cachedata['output_sql_source']);
			$direct_cachedata['output_sql_source'] .= "\$direct_classes['db']->query_exec (\"co\");";

			break 1;
		}
		}

		$direct_cachedata['output_sql_result'] = $direct_classes['db']->query_exec ("sql");
	}

	$direct_cachedata['output_preview_function_file'] = "swgi_developer";
	$direct_cachedata['output_preview_function'] = "oset_developer_sqlsource_decode";

	$direct_cachedata['output_formbutton'] = direct_local_get ("core_continue");
	$direct_cachedata['output_formelements'] = $direct_classes['formbuilder']->form_get (true);
	$direct_cachedata['output_formtarget'] = "m=developer&s=sqlsource";
	$direct_cachedata['output_formtitle'] = direct_local_get ("developer_sqlsource_decode");

	direct_output_related_manager ("developer_sqlsource_decode","post_module_service_action");
	$direct_classes['output']->oset ("default","form_preview");
	$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
	$direct_classes['output']->page_show ($direct_cachedata['output_formtitle']);
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>