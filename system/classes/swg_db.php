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
* We need a unified interface for communication with SQL-compatible database
* servers. This is the abstract interface.
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
* @subpackage db
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

$g_continue_check = ((defined ("CLASS_direct_db")) ? false : true);
if (!defined ("CLASS_direct_data_handler")) { $g_continue_check = false; }

if ($g_continue_check)
{
//c// direct_db
/**
* This is the abstract interface to communicate with SQL servers.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage db
* @uses       CLASS_direct_data_handler
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_db extends direct_data_handler
{
/**
	* @var resource $db_driver Database layer
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $db_driver;
/**
	* @var string $db_driver_name Database layer name
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $db_driver_name;
/**
	* @var array $query_attributes SQL query attributes
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_attributes;
/**
	* @var integer $query_element Counter for the element tags
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_element;
/**
	* @var array $query_grouping SQL query GROUP BY
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_grouping;
/**
	* @var array $query_joins SQL query JOIN
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_joins;
/**
	* @var array $query_limit SQL query LIMIT
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_limit;
/**
	* @var array $query_offset SQL query OFFSET
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_offset;
/**
	* @var array $query_ordering SQL query ORDER BY
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_ordering;
/**
	* @var array $query_row_conditions SQL query WHERE
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_row_conditions;
/**
	* @var array $query_search_conditions SQL query search conditions
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_search_conditions;
/**
	* @var array $query_set_attributes SQL query SET
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_set_attributes;
/**
	* @var array $query_table SQL query FROM
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_table;
/**
	* @var array $query_type SQL query type
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_type;
/**
	* @var array $query_values SQL query VALUES
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_values;
/**
	* @var array $query_values_keys SQL query KEYS
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_values_keys;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_db->__construct () and direct_db->direct_db ()
/**
	* Constructor (PHP5) __construct (direct_db)
	*
	* @param boolean $f_peristent True to establish a persistent connection
	* @uses  direct_basic_functions::include_file()
	* @uses  direct_basic_functions::settings_get()
	* @uses  direct_class_init()
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ($f_peristent = false)
	{
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->__construct (direct_db)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['define_attributes'] = true;
		$this->functions['define_grouping'] = true;
		$this->functions['define_join'] = true;
		$this->functions['define_limit'] = true;
		$this->functions['define_offset'] = true;
		$this->functions['define_ordering'] = true;
		$this->functions['define_row_conditions'] = true;
		$this->functions['define_row_conditions_encode'] = false;
		$this->functions['define_search_conditions'] = true;
		$this->functions['define_set_attributes'] = true;
		$this->functions['define_set_attributes_encode'] = false;
		$this->functions['define_values'] = true;
		$this->functions['define_values_encode'] = false;
		$this->functions['define_values_keys'] = true;
		$this->functions['init_delete'] = false;
		$this->functions['init_insert'] = false;
		$this->functions['init_replace'] = false;
		$this->functions['init_select'] = false;
		$this->functions['init_update'] = false;
		$this->functions['optimize_random'] = false;
		$this->functions['query_exec'] = false;
		$this->functions['v_close'] = array ();
		$this->functions['v_connect'] = array ();
		$this->functions['v_optimize'] = array ();
		$this->functions['v_query_build'] = array ();
		$this->functions['v_query_exec'] = array ();
		$this->functions['v_secure'] = array ();
		$this->functions['v_transaction_begin'] = array ();
		$this->functions['v_transaction_commit'] = array ();
		$this->functions['v_transaction_rollback'] = array ();

		if (file_exists ($direct_settings['path_data']."/settings/swg_db.php"))
		{
			$direct_classes['basic_functions']->settings_get ($direct_settings['path_data']."/settings/swg_db.php");

			$this->db_driver_name = ((isset ($direct_settings['db_driver'])) ? $direct_settings['db_driver'] : "mysql");
			if (!isset ($direct_settings['db_dbprefix'])) { $direct_settings['db_dbprefix'] = "swg_"; }

			if ($f_peristent) { $direct_settings['db_peristent'] = true; }
			elseif (!isset ($direct_settings['db_peristent'])) { $direct_settings['db_peristent'] = $f_peristent; }
			else { $direct_settings['db_peristent'] = false; }

			if ($direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_dbraw_".$this->db_driver_name.".php",1))
			{
				$f_dbraw_class = "direct_dbraw_".$this->db_driver_name;
				if (class_exists ($f_dbraw_class,/*#ifndef(PHP4) */false/* #*/)) { $this->db_driver = new $f_dbraw_class (); }

				if (is_object ($this->db_driver))
				{
					$this->functions['define_row_conditions_encode'] = true;
					$this->functions['define_set_attributes_encode'] = true;
					$this->functions['define_values_encode'] = true;
					$this->functions['init_delete'] = true;
					$this->functions['init_insert'] = true;
					$this->functions['init_replace'] = true;
					$this->functions['init_select'] = true;
					$this->functions['init_update'] = true;
					$this->functions['optimize_random'] = true;
					$this->functions['query_exec'] = true;

/* -------------------------------------------------------------------------
Connect to the database abstraction layer
------------------------------------------------------------------------- */

					$this->v_call_set ("v_connect",$this->db_driver,"connect");
					$this->v_call_set ("v_disconnect",$this->db_driver,"disconnect");
					$this->v_call_set ("v_optimize",$this->db_driver,"optimize");
					$this->v_call_set ("v_query_build",$this->db_driver,"query_build");
					$this->v_call_set ("v_query_exec",$this->db_driver,"query_exec");
					$this->v_call_set ("v_secure",$this->db_driver,"secure");
					$this->v_call_set ("v_transaction_begin",$this->db_driver,"transaction_begin");
					$this->v_call_set ("v_transaction_commit",$this->db_driver,"transaction_commit");
					$this->v_call_set ("v_transaction_rollback",$this->db_driver,"transaction_rollback");
				}
			}
			else { trigger_error ("sWG/#echo(__FILEPATH__)# -db_class->__construct (direct_db)- (#echo(__LINE__)#) reporting: Fatal error while loading the raw SQL handler",E_USER_ERROR); }
		}
		else { trigger_error ("sWG/#echo(__FILEPATH__)# -db_class->__construct (direct_db)- (#echo(__LINE__)#) reporting: Fatal error while loading database settings",E_USER_ERROR); }

/* -------------------------------------------------------------------------
Set up some variables
------------------------------------------------------------------------- */

		$this->query_attributes = "";
		$this->query_element = 0;
		$this->query_grouping = "";
		$this->query_joins = array ();
		$this->query_limit = 0;
		$this->query_offset = 0;
		$this->query_ordering = "";
		$this->query_row_conditions = "";
		$this->query_search_conditions = array ();
		$this->query_set_attributes = array ();
		$this->query_table = "";
		$this->query_type = "";
		$this->query_values = "";
		$this->query_values_keys = array ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_db (direct_db)
	*
	* @param boolean $f_peristent True to establish a persistent connection
	* @since v0.1.00
*\/
	function direct_db ($f_peristent = false) { $this->__construct ($f_peristent = false); }
:#\n*/
	//f// direct_db->__destruct ()
/**
	* Destructor (PHP5) __destruct (direct_db)
	* Closes the database connection on destruction.
	*
	* @uses  direct_dbraw_*::disconnect()
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __destruct () { $this->v_disconnect (); }

	//f// direct_db->define_attributes ($f_attribute_list)
/**
	* Defines SQL attributes. (Only supported for SQL SELECT)
	*
	* @param  mixed $f_attribute_list Requested attributes (including AS
	*         definition) as array or a string for "*"
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function define_attributes ($f_attribute_list)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->define_attributes (+f_attribute_list)- (#echo(__LINE__)#)"); }

		if ($this->query_type == "select")
		{
			$this->query_attributes = ((is_array ($f_attribute_list)) ? $f_attribute_list : array ("*"));
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_attributes ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_attributes ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_db->define_grouping ($f_attribute_list)
/**
	* Defines the SQL GROUP BY clause. (Only supported for SQL SELECT)
	*
	* @param  mixed $f_attribute_list Requested grouping (including AS
	*         definition) as array or a string (for a single attribute)
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function define_grouping ($f_attribute_list)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->define_grouping (+f_attribute_list)- (#echo(__LINE__)#)"); }

		if ($this->query_type == "select")
		{
			$this->query_grouping = ((is_array ($f_attribute_list)) ? $f_attribute_list : array ($f_attribute_list));
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_grouping ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_grouping ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_db->define_join ($f_requirements)
/**
	* Defines the SQL JOIN clause. (Only supported for SQL SELECT)
	*
	* @param  string $f_type Type of JOIN
	* @param  string $f_table Name of the table (" AS Name" is valid)
	* @param  string $f_requirements ON definitions given as an array
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function define_join ($f_type,$f_table,$f_requirements)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->define_join ($f_type,$f_table,+f_requirements)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if ($this->query_type == "select")
		{
			if ((is_string ($f_requirements))||($f_type == "cross-join"))
			{
				$this->query_joins[] = array ("type" => $f_type,"table" => $f_table,"requirements" => $f_requirements);
				$f_return = true;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_join ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_db->define_limit ($f_limit)
/**
	* Defines a row limit for queries.
	*
	* @param  integer $f_limit Limit for the query
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function define_limit ($f_limit)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->define_limit ($f_limit)- (#echo(__LINE__)#)"); }

		if (($this->query_type == "delete")||($this->query_type == "select")||($this->query_type == "update"))
		{
			$this->query_limit = $f_limit;
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_limit ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_limit ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_db->define_offset ($f_offset)
/**
	* Defines an offset for queries.
	*
	* @param  integer $f_offset Offset for the query (0 for none)
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function define_offset ($f_offset)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->define_offset ($f_offset)- (#echo(__LINE__)#)"); }

		if ($this->query_type == "select")
		{
			$this->query_offset = $f_offset;
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_offset ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_offset ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_db->define_ordering ($f_ordering_list)
/**
	* Defines the SQL ORDER BY items.
	*
	* @param  string $f_ordering_list XML-encoded elements how to order the list
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function define_ordering ($f_ordering_list)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->define_ordering (+f_ordering_list)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if ($this->query_type == "select")
		{
			if (is_string ($f_ordering_list))
			{
				$this->query_ordering = $f_ordering_list;
				$f_return = true;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_ordering ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_db->define_row_conditions ($f_requirements)
/**
	* Defines the SQL WHERE clause.
	*
	* @param  string $f_requirements WHERE definitions given as an array
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function define_row_conditions ($f_requirements)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->define_row_conditions (+f_requirements)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if (($this->query_type == "delete")||($this->query_type == "select")||($this->query_type == "update"))
		{
			if (is_string ($f_requirements))
			{
				$this->query_row_conditions = $f_requirements;
				$f_return = true;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_row_conditions ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_db->define_row_conditions_encode ($f_attribute,$f_value,$f_type,$f_logical_operator = "==",$f_condition_mode = "and")
/**
	* Returns valid XML sqlbox code for WHERE. Useful to secure values of
	* attributes against SQL injection.
	*
	* @param  string $f_attribute Attribute
	* @param  string $f_value Value of the attribute
	* @param  string $f_type Value type (attribute, number, string)
	* @param  string $f_logical_operator Logical operator
	* @param  string $f_condition_mode Condition of this element
	* @uses   direct_db::v_secure()
	* @uses   direct_debug()
	* @uses   direct_xml_bridge::array2xml_item_encoder()
	* @uses   USE_debug_reporting
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function define_row_conditions_encode ($f_attribute,$f_value,$f_type,$f_logical_operator = "==",$f_condition_mode = "and")
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->define_row_conditions_encode ($f_attribute,$f_value,$f_type,$f_logical_operator,$f_condition_mode)- (#echo(__LINE__)#)"); }

		$f_return = "";

		if (isset ($direct_classes['xml_bridge']))
		{
			switch ($f_type)
			{
			case "attribute":
			{
				$f_value = preg_replace ("#\W#","",$f_value);
				break 1;
			}
			case "number":
			{
				preg_match ("#^(-|)(\d+)$#i",$f_value,$f_result_array);
				if (!empty ($f_result_array)) { $f_value = $f_result_array[0]; }

				break 1;
			}
			case "sublevel": { break 1; }
			default:
			{
				$f_type = "string";
				if ($f_value !== NULL) { $this->v_secure ($f_value); }
			}
			}

			if ($f_condition_mode != "or") { $f_condition_mode = "and"; }

			switch ($f_logical_operator)
			{
			case "!=": { break 1; }
			case "<": { break 1; }
			case "<=": { break 1; }
			case ">": { break 1; }
			case ">=": { break 1; }
			default: { $f_logical_operator = "=="; }
			}

$f_xml_node_array = array (
"tag" => "element".$direct_settings['swg_id'].$this->query_element,
"attributes" => array ("attribute" => $f_attribute,"condition" => $f_condition_mode,"operator" => $f_logical_operator,"type" => $f_type)
);

			if ($f_value === NULL)
			{
				$f_xml_node_array['attributes']['null'] = 1;
				$f_xml_node_array['value'] = "";
			}
			else { $f_xml_node_array['value'] = $f_value; }

			$this->query_element++;
			$f_return = $direct_classes['xml_bridge']->array2xml_item_encoder ($f_xml_node_array,true,false);
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_row_conditions_encode ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_db->define_search_conditions ($f_list)
/**
	* Defines search conditions for the database.
	*
	* @param  string $f_conditions Conditions to search for
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function define_search_conditions ($f_conditions)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->define_search_conditions (+f_conditions)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if ($this->query_type == "select")
		{
			if (is_string ($f_conditions))
			{
				$this->query_search_conditions = $f_conditions;
				$f_return = true;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_search_conditions ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_db->define_search_conditions_term ($f_term)
/**
	* Creates the search term definition XML code for the given term.
	*
	* @param  string $f_term Term to search for
	* @uses   direct_db::v_secure()
	* @uses   direct_debug()
	* @uses   direct_xml_bridge::array2xml_item_encoder()
	* @uses   USE_debug_reporting
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function define_search_conditions_term ($f_term)
	{
		global $direct_classes;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->define_search_conditions_term (+f_term)- (#echo(__LINE__)#)"); }

		$f_return = "";

		if (isset ($direct_classes['xml_bridge']))
		{
$f_xml_node_array = array (
"tag" => "searchterm",
"value" => $f_term
);

			$f_return = $direct_classes['xml_bridge']->array2xml_item_encoder ($f_xml_node_array,true,false);
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_search_conditions_term ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_db->define_set_attributes ($f_attribute_list)
/**
	* Defines the SQL SET clause.
	*
	* @param  string $f_attribute_list Attributes to set
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function define_set_attributes ($f_attribute_list)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->define_set_attributes (+f_attribute_list)- (#echo(__LINE__)#)"); }

		$f_continue_check = true;
		$f_return = false;

		if (($this->query_type != "insert")&&($this->query_type != "replace")&&($this->query_type != "update")) { $f_continue_check = false; }
		if (!empty ($this->query_values)) { $f_continue_check = false; }

		if ($f_continue_check)
		{
			if (is_string ($f_attribute_list))
			{
				$this->query_set_attributes = $f_attribute_list;
				$f_return = true;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_set_attributes ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_db->define_set_attributes_encode ($f_attribute,$f_value,$f_type)
/**
	* Returns valid XML sqlbox code for SET. Useful to secure values against SQL
	* injection.
	*
	* @param  string $f_attribute Attribute
	* @param  string $f_value Value string
	* @param  string $f_type Value type (attribute, number, string)
	* @uses   direct_db::v_secure()
	* @uses   direct_debug()
	* @uses   direct_xml_bridge::array2xml_item_encoder()
	* @uses   USE_debug_reporting
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function define_set_attributes_encode ($f_attribute,$f_value,$f_type)
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->define_set_attributes_encode ($f_attribute,$f_value,$f_type)- (#echo(__LINE__)#)"); }

		$f_return = "";

		if (isset ($direct_classes['xml_bridge']))
		{
			switch ($f_type)
			{
			case "attribute":
			{
				$f_value = preg_replace ("#\W#","",$f_value);
				break 1;
			}
			case "number":
			{
				preg_match ("#^(-|)(\d+)$#i",$f_value,$f_result_array);
				if (!empty ($f_result_array)) { $f_value = $f_result_array[0]; }

				break 1;
			}
			default:
			{
				$f_type = "string";
				if ($f_value !== NULL) { $this->v_secure ($f_value); }
			}
			}

$f_xml_node_array = array (
"tag" => "element".$direct_settings['swg_id'].$this->query_element,
"attributes" => array ("attribute" => $f_attribute,"type" => $f_type)
);

			if ($f_value === NULL)
			{
				$f_xml_node_array['attributes']['null'] = 1;
				$f_xml_node_array['value'] = "";
			}
			else { $f_xml_node_array['value'] = $f_value; }

			$this->query_element++;
			$f_return = $direct_classes['xml_bridge']->array2xml_item_encoder ($f_xml_node_array,true,false);
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_set_attributes_encode ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_db->define_values ($f_requirements)
/**
	* Defines the SQL VALUES element.
	*
	* @param  string $f_values WHERE definitions given as an array
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function define_values ($f_values)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->define_values (+f_values)- (#echo(__LINE__)#)"); }

		$f_return = false;
		$f_continue_check = true;

		if (($this->query_type != "insert")&&($this->query_type != "replace")) { $f_continue_check = false; }
		if (!empty ($this->query_set_attributes)) { $f_continue_check = false; }

		if ($f_continue_check)
		{
			if (is_string ($f_values))
			{
				$this->query_values = $f_values;
				$f_return = true;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_values ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_db->define_values_encode ($f_value,$f_type)
/**
	* Returns valid XML sqlbox code for VALUES. Useful to secure values against
	* SQL injection.
	*
	* @param  string $f_value Value string
	* @param  string $f_type Value type (attribute, number, string)
	* @uses   direct_db::v_secure()
	* @uses   direct_debug()
	* @uses   direct_xml_bridge::array2xml_item_encoder()
	* @uses   USE_debug_reporting
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function define_values_encode ($f_value,$f_type)
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->define_values_encode ($f_value,$f_type)- (#echo(__LINE__)#)"); }

		$f_return = "";

		if (isset ($direct_classes['xml_bridge']))
		{
			switch ($f_type)
			{
			case "attribute":
			{
				$f_value = preg_replace ("#\W#","",$f_value);
				break 1;
			}
			case "number":
			{
				preg_match ("#^(-|)(\d+)$#i",$f_value,$f_result_array);
				if (!empty ($f_result_array)) { $f_value = $f_result_array[0]; }

				break 1;
			}
			case "newrow": { break 1; }
			default:
			{
				$f_type = "string";
				if ($f_value !== NULL) { $this->v_secure ($f_value); }
			}
			}

$f_xml_node_array = array (
"tag" => "element".$direct_settings['swg_id'].$this->query_element,
"attributes" => array ("type" => $f_type)
);

			if ($f_value === NULL)
			{
				$f_xml_node_array['attributes']['null'] = 1;
				$f_xml_node_array['value'] = "";
			}
			else { $f_xml_node_array['value'] = $f_value; }

			$this->query_element++;
			$f_return = $direct_classes['xml_bridge']->array2xml_item_encoder ($f_xml_node_array,true,false);
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_values_encode ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_db->define_values_keys ($f_offset)
/**
	* Defines the key list for the SQL VALUES statement.
	*
	* @param  array $f_keys_list Key list for VALUES
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function define_values_keys ($f_keys_list)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->define_values_keys (+f_keys_list)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if (($this->query_type == "insert")||($this->query_type == "replace"))
		{
			if (is_array ($f_keys_list))
			{
				$this->query_values_keys = $f_keys_list;
				$f_return = true;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->define_values_keys ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_db->init_delete ($f_table)
/**
	* Initiates a DELETE request.
	*
	* @param  string $f_table Name of the table (" AS Name" is valid)
	* @uses   direct_class_function_check()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if query cache is not empty (Query not executed?)
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function init_delete ($f_table)
	{
		global $direct_classes;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->init_delete ($f_table)- (#echo(__LINE__)#)"); }

		if ((direct_class_function_check ($direct_classes['db'],"v_query_build"))&&(!$this->query_type))
		{
			$this->data = "";
			$this->query_attributes = array ("*");
			$this->query_grouping = "";
			$this->query_joins = array ();
			$this->query_limit = 0;
			$this->query_offset = 0;
			$this->query_ordering = "";
			$this->query_row_conditions = "";
			$this->query_search_conditions = array ();
			$this->query_set_attributes = array ();
			$this->query_table = $f_table;
			$this->query_type = "delete";
			$this->query_values = "";
			$this->query_values_keys = array ();

			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->init_delete ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->init_delete ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_db->init_insert ($f_table)
/**
	* Initiates a INSERT request.
	*
	* @param  string $f_table Name of the table (" AS Name" is valid)
	* @uses   direct_class_function_check()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if query cache is not empty (Query not executed?)
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function init_insert ($f_table)
	{
		global $direct_classes;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->init_insert ($f_table)- (#echo(__LINE__)#)"); }

		if ((direct_class_function_check ($direct_classes['db'],"v_query_build"))&&(!$this->query_type))
		{
			$this->data = "";
			$this->query_attributes = array ("*");
			$this->query_grouping = "";
			$this->query_joins = array ();
			$this->query_limit = 0;
			$this->query_offset = 0;
			$this->query_ordering = "";
			$this->query_row_conditions = "";
			$this->query_search_conditions = array ();
			$this->query_set_attributes = array ();
			$this->query_table = $f_table;
			$this->query_type = "insert";
			$this->query_values = "";
			$this->query_values_keys = array ();

			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->init_insert ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->init_insert ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_db->init_replace ($f_table)
/**
	* Initiates a REPLACE request.
	*
	* @param  string $f_table Name of the table (" AS Name" is valid)
	* @uses   direct_class_function_check()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if query cache is not empty (Query not executed?)
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function init_replace ($f_table)
	{
		global $direct_classes;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->init_replace ($f_table)- (#echo(__LINE__)#)"); }

		if ((direct_class_function_check ($direct_classes['db'],"v_query_build"))&&(!$this->query_type))
		{
			$this->data = "";
			$this->query_attributes = array ("*");
			$this->query_grouping = "";
			$this->query_joins = array ();
			$this->query_limit = 0;
			$this->query_offset = 0;
			$this->query_ordering = "";
			$this->query_row_conditions = "";
			$this->query_search_conditions = array ();
			$this->query_set_attributes = array ();
			$this->query_table = $f_table;
			$this->query_type = "replace";
			$this->query_values = "";
			$this->query_values_keys = array ();

			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->init_replace ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->init_replace ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_db->init_select ($f_table)
/**
	* Initiates a SELECT request.
	*
	* @param  string $f_table Name of the table (" AS Name" is valid)
	* @uses   direct_class_function_check()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if query cache is not empty (Query not executed?)
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function init_select ($f_table)
	{
		global $direct_classes;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->init_select ($f_table)- (#echo(__LINE__)#)"); }

		if ((direct_class_function_check ($direct_classes['db'],"v_query_build"))&&(!$this->query_type))
		{
			$this->data = "";
			$this->query_attributes = array ("*");
			$this->query_grouping = "";
			$this->query_joins = array ();
			$this->query_limit = 0;
			$this->query_offset = 0;
			$this->query_ordering = "";
			$this->query_row_conditions = "";
			$this->query_search_conditions = array ();
			$this->query_set_attributes = array ();
			$this->query_table = $f_table;
			$this->query_type = "select";
			$this->query_values = "";
			$this->query_values_keys = array ();

			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->init_select ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->init_select ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_db->init_update ($f_table)
/**
	* Initiates a UPDATE request.
	*
	* @param  string $f_table Name of the table (" AS Name" is valid)
	* @uses   direct_class_function_check()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False if query cache is not empty (Query not executed?)
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function init_update ($f_table)
	{
		global $direct_classes;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->init_update ($f_table)- (#echo(__LINE__)#)"); }

		if ((direct_class_function_check ($direct_classes['db'],"v_query_build"))&&(!$this->query_type))
		{
			$this->data = "";
			$this->query_attributes = array ("*");
			$this->query_grouping = "";
			$this->query_joins = array ();
			$this->query_limit = 0;
			$this->query_offset = 0;
			$this->query_ordering = "";
			$this->query_row_conditions = "";
			$this->query_search_conditions = array ();
			$this->query_set_attributes = array ();
			$this->query_table = $f_table;
			$this->query_type = "update";
			$this->query_values = "";
			$this->query_values_keys = array ();

			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->init_update ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->init_update ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_db->optimize_random ($f_table)
/**
	* Optimizes a given table randomly (1/3).
	*
	* @param  string $f_table Name of the table
	* @uses   direct_db::v_optimize()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function optimize_random ($f_table)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db_class->optimize_random ($f_table)- (#echo(__LINE__)#)"); }

		if ((mt_rand (0,30)) > 20) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->optimize_random ()- (#echo(__LINE__)#)",(:#*/$this->v_optimize ($f_table)/*#ifdef(DEBUG):),true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_db->optimize_random ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_db->query_exec ($f_answer)
/**
	* Transmits defined data to the SQL builder and returns the result in a
	* developer specified format via $f_answer.
	*
	* @param  string $f_answer Defines the requested type that should be returned
    *         The following types are supported: "ar", "co", "ma", "ms", "nr",
    *         "sa" or "ss".
	* @uses   direct_class_function_check()
	* @uses   direct_dbraw_*::query_build()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return mixed Result returned by the server in the specified format
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function query_exec ($f_answer = "sa")
	{
		global $direct_classes;
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db_class->query_exec ($f_answer)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (direct_class_function_check ($direct_classes['db'],"v_query_build"))
		{
			$f_data = array ();
			$f_data['answer'] = $f_answer;

			$f_data['attributes'] = $this->query_attributes;
			$this->query_attributes = "";

			$f_data['grouping'] = $this->query_grouping;
			$this->query_grouping = "";

			$f_data['limit'] = $this->query_limit;
			$this->query_limit = "";

			$f_data['offset'] = $this->query_offset;
			$this->query_offset = "";

			$f_data['ordering'] = $this->query_ordering;
			$this->query_ordering = "";

			$f_data['joins'] = $this->query_joins;
			$this->query_joins = array ();

			$f_data['row_conditions'] = $this->query_row_conditions;
			$this->query_row_conditions = "";

			$f_data['search_conditions'] = $this->query_search_conditions;
			$this->query_search_conditions = array ();

			$f_data['set_attributes'] = $this->query_set_attributes;
			$this->query_set_attributes = array ();

			$f_data['table'] = $this->query_table;
			$this->query_table = "";

			$f_data['type'] = $this->query_type;
			$this->query_type = "";

			$f_data['values'] = $this->query_values;
			$this->query_values = "";

			$f_data['values_keys'] = $this->query_values_keys;
			$this->query_values_keys = array ();

			$this->data = $this->v_query_build ($f_data);
			$f_return = $this->data;
		}

		return /*#ifdef(DEBUG):direct_debug (9,"sWG/#echo(__FILEPATH__)# -direct_db->query_exec ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_db->v_connect ()
/**
	* Opens the connection to a database server and selects a database.
	*
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function v_connect ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db_class->v_connect ()- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_connect");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}

	//f// direct_db->v_disconnect ()
/**
	* Closes an active database connection to the server.
	*
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function v_disconnect ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db_class->v_disconnect ()- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_disconnect");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}

	//f// direct_db->v_optimize ($f_table)
/**
	* Optimizes a given table.
	*
	* @param  string $f_table Name of the table
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function v_optimize ($f_table)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db_class->v_optimize ($f_table)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_optimize");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_table) : false);
	}

	//f// direct_db->v_query_build ($f_data)
/**
	* Builds and runs the SQL statement using the connected database specific
	* layer.
	*
	* @param  array $f_data Array containing query specific information.
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return mixed Result returned by the server in the specified format
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function v_query_build ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db_class->v_query_build (+f_query)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_query_build");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_data) : false);
	}

	//f// direct_db->v_query_exec ($f_answer,$f_query)
/**
	* Transmits an SQL query and returns the result in a developer specified
	* format via $f_answer.
	*
	* @param  string $f_answer Defines the requested type that should be returned
    *         The following types are supported: "ar", "co", "ma", "ms", "nr",
    *         "sa" or "ss".
	* @param  string $f_query Valid SQL query
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return mixed Result returned by the server in the specified format
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function v_query_exec ($f_answer,$f_query)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db_class->v_query_exec ($f_answer,+f_query)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_query_exec");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_answer,$f_query) : false);
	}

	//f// direct_db_mysql->v_secure (&$f_data)
/**
	* Secures a given string to protect against SQL injections.
	*
	* @param  mixed &$f_data Input array or string
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function v_secure (&$f_data)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db_class->v_secure (+f_data)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_secure");
		if ($f_call) { $f_call[0]->{$f_call[1]} ($f_data); }
	}

	//f// direct_db_mysql->v_transaction_begin ()
/**
	* Starts a transaction.
	*
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function v_transaction_begin ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db_class->v_transaction_begin ()- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_transaction_begin");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}

	//f// direct_db_mysql->v_transaction_commit ()
/**
	* Commits all transaction statements.
	*
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function v_transaction_commit ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db_class->v_transaction_commit ()- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_transaction_commit");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}

	//f// direct_db_mysql->v_transaction_rollback ()
/**
	* Calls the ROLLBACK statement.
	*
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function v_transaction_rollback ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db_class->v_transaction_rollback ()- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_transaction_rollback");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_classes['@names']['db'] = "direct_db";
define ("CLASS_direct_db",true);
}

//j// EOF
?>