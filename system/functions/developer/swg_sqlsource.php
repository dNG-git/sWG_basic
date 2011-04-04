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

//j// Functions and classes

//f// direct_developer_sqlsource_get_row_conditions ()
/**
* Build valid XML database request code for row conditions.
*
* @param  array $f_array SQL ANSI words
* @param  array $f_position Current word position in array
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return boolean XML and PHP code for defining row conditions
* @since  v0.1.00
*/
function direct_developer_sqlsource_get_row_conditions (&$f_array,&$f_position)
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_developer_sqlsource_get_row_conditions (+f_array,$f_position)- (#echo(__LINE__)#)"); }

	$f_condition = "and";
	$f_continue_check = true;
	$f_element_counter = 0;
	$f_sub_counter = 0;
	$f_subs_array = array ();
	$f_subs_level = 0;
	$f_return = "";

	do
	{
		if ($f_return) { $f_return .= "\n";	}

		if ($f_array[$f_position] == "(")
		{
			$f_sub_counter++;
			$f_subs_level++;
			$f_subs_array[$f_subs_level] = $f_sub_counter;

			$f_return .= "<sub$f_sub_counter type='sublevel' condition='$f_condition'>\n";
			$f_position++;
		}

		$f_key = $f_array[$f_position];
		$f_position++;

		$f_logical_operator = $f_array[$f_position];
		if ($f_logical_operator == "=") { $f_logical_operator = "=="; }

		$f_position++;

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_array[$f_position],"\$") !== false) { $f_return .= "\".(\$direct_globals['db']->define_row_conditions_encode (\"$f_key\",\"{$f_array[$f_position]}\",\"string\",\"$f_logical_operator\",\"$f_condition\")).\""; }
		else
		{
			$f_element_counter++;
			$f_return .= "<element$f_element_counter attribute='$f_key' value='$f_array[$f_position]' type='string' operator='$f_logical_operator' condition='$f_condition' />";
		}

		$f_position++;

		if ($f_array[$f_position] == ")")
		{
			do
			{
				if ($f_subs_level > 0)
				{
					$f_return .= "\n</sub{$f_subs_array[$f_subs_level]}>";
					$f_subs_level--;
				}

				$f_position++;
			}
			while ($f_array[$f_position] == ")");
		}

		switch (strtolower ($f_array[$f_position]))
		{
		case "and":
		{
			$f_condition = "and";
			$f_position++;

			break 1;
		}
		case "or":
		{
			$f_condition = "or";
			$f_position++;

			break 1;
		}
		default: { $f_continue_check = false; }
		}
	}
	while ($f_continue_check);

	return $f_return;
}

//f// direct_developer_sqlsource_get_set_attributes ()
/**
* Build valid XML database request code to "SET" attributes.
*
* @param  array $f_array SQL ANSI words
* @param  array $f_position Current word position in array
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return boolean XML and PHP code for defining SET attributes
* @since  v0.1.00
*/
function direct_developer_sqlsource_get_set_attributes (&$f_array,&$f_position)
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_developer_sqlsource_get_set_attributes (+f_array,$f_position)- (#echo(__LINE__)#)"); }

	$f_continue_check = true;
	$f_element_counter = 0;
	$f_return = "";

	do
	{
		if ($f_return) { $f_return .= "\n"; }

		$f_attribute = $f_array[$f_position];
		$f_position += 2;

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_array[$f_position],"\$") === false)
		{
			$f_element_counter++;
			$f_return .= "<element$f_element_counter attribute='$f_attribute' value='$f_array[$f_position]' type='string' />";
		}
		else { $f_return .= "\".(\$direct_globals['db']->define_set_attributes_encode (\"$f_attribute\",\"{$f_array[$f_position]}\",\"string\")).\""; }

		$f_position++;

		if ($f_array[$f_position] == ",") { $f_position++; }
		else { $f_continue_check = false; }
	}
	while ($f_continue_check);

	return $f_return;
}

//f// direct_developer_sqlsource_get_ordering ()
/**
* Build valid XML database request code for the ORDER SQL definition.
*
* @param  array $f_array SQL ANSI words
* @param  array $f_position Current word position in array
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return boolean XML and PHP code to define ORDER SQL code
* @since  v0.1.00
*/
function direct_developer_sqlsource_get_ordering (&$f_array,&$f_position)
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_developer_sqlsource_get_ordering (+f_array,$f_position)- (#echo(__LINE__)#)"); }

	$f_continue_check = true;
	$f_element_counter = 0;
	$f_return = "";

	do
	{
		if ($f_return) { $f_return .= "\n";	}

		$f_attribute = $f_array[$f_position];
		$f_position++;

		if ((/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_array[$f_position],"asc") === false)&&(/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_array[$f_position],"desc") === false)) { $f_sort_mode = "asc"; }
		else
		{
			$f_sort_mode = strtolower ($f_array[$f_position]);
			$f_position++;
		}

		$f_element_counter++;
		$f_return .= "<element$f_element_counter attribute='$f_attribute' type='$f_sort_mode' />";

		if ($f_array[$f_position] == ",") { $f_position++; }
		else { $f_continue_check = false; }
	}
	while ($f_continue_check);

	return $f_return;
}

//f// direct_developer_sqlsource_get_values ()
/**
* Build valid XML database request code for VALUES.
*
* @param  array $f_array SQL ANSI words
* @param  array $f_position Current word position in array
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return boolean XML and PHP code for defining VALUES
* @since  v0.1.00
*/
function direct_developer_sqlsource_get_values (&$f_array,&$f_position)
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_developer_sqlsource_get_values (+f_array,$f_position)- (#echo(__LINE__)#)"); }

	$f_continue_check = true;
	$f_element_counter = 0;
	$f_result = "";
	$f_return = "";
	$f_value_counter = 0;

	do
	{
		if ($f_result) { $f_result .= "\n";	}

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_array[$f_position],"\$") === false)
		{
			$f_element_counter++;
			$f_result .= "<element$f_element_counter value='$f_array[$f_position]' type='string' />";
		}
		else { $f_result .= "\".(\$direct_globals['db']->define_values_encode ({$f_array[$f_position]},\"string\")).\""; }

		$f_position++;

		if (!isset ($f_array[$f_position])) { $f_continue_check = false; }
		elseif ($f_array[$f_position] == ",") { $f_position++; }
		elseif ($f_array[$f_position] == ")")
		{
			if ($f_array[($f_position + 1)] == ",")
			{
				$f_position += 3;

				$f_value_counter++;
				$f_return .= "<value$f_value_counter type='newrow'>\n$f_result\n</value$f_value_counter>\n";
				$f_result = "";
			}
			else
			{
				if ($f_value_counter)
				{
					$f_value_counter++;
					$f_return .= "<value$f_value_counter type='newrow'>\n$f_result\n</value$f_value_counter>";
				}
				else { $f_return .= $f_result; }

				$f_result = "";
			}
		}
		else { $f_continue_check = false; }
	}
	while ($f_continue_check);

	return $f_return;
}

//f// direct_developer_sqlsource_get_values_keys ()
/**
* Build valid XML database request code for the VALUES attributes.
*
* @param  array $f_array SQL ANSI words
* @param  array $f_position Current word position in array
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return boolean XML and PHP code for defining the VALUES attributes
* @since  v0.1.00
*/
function direct_developer_sqlsource_get_values_keys (&$f_array,&$f_position)
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_developer_sqlsource_get_values_keys (+f_array,$f_position)- (#echo(__LINE__)#)"); }

	$f_continue_check = true;
	$f_return = "";

	do
	{
		if ($f_return) { $f_return .= ","; }
		$f_return .= "\"$f_array[$f_position]\"";

		$f_position++;

		if ((isset ($f_array[$f_position]))&&($f_array[$f_position] == ",")) { $f_position++; }
		else { $f_continue_check = false; }
	}
	while ($f_array[$f_position]);

	return $f_return;
}

//j// EOF
?>