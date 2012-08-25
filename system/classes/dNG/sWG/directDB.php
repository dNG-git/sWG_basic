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
/*#ifdef(PHP5n) */

namespace dNG\sWG;
/* #*/
/*#use(direct_use) */
use dNG\sWG\directDataHandler;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

if (!defined ("CLASS_directDB"))
{
/**
* This is the abstract interface to communicate with SQL servers.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage db
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class directDB extends directDataHandler
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
	* @var integer $query_limit SQL query LIMIT
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_limit;
/**
	* @var integer $query_offset SQL query OFFSET
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_offset;
/**
	* @var string $query_ordering SQL query ORDER BY
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_ordering;
/**
	* @var string $query_row_conditions SQL query WHERE
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_row_conditions;
/**
	* @var string $query_search_conditions SQL query search conditions
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_search_conditions;
/**
	* @var array $query_set_attributes SQL query SET
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_set_attributes;
/**
	* @var string $query_table SQL query FROM
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_table;
/**
	* @var string $query_type SQL query type
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_type;
/**
	* @var string $query_values SQL query VALUES
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_values;
/**
	* @var array $query_values_keys SQL query KEYS
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $query_values_keys;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directDB)
	*
	* @param boolean $f_peristent True to establish a persistent connection
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ($f_peristent = false)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->__construct (directDB)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['defineAttributes'] = true;
		$this->functions['defineGrouping'] = true;
		$this->functions['defineJoin'] = true;
		$this->functions['defineLimit'] = true;
		$this->functions['defineOffset'] = true;
		$this->functions['defineOrdering'] = true;
		$this->functions['defineRowConditions'] = true;
		$this->functions['defineRowConditionsEncode'] = false;
		$this->functions['defineSearchConditions'] = true;
		$this->functions['defineSearchConditionsTerm'] = true;
		$this->functions['defineSetAttributes'] = true;
		$this->functions['defineSetAttributesEncode'] = false;
		$this->functions['defineValues'] = true;
		$this->functions['defineValuesEncode'] = false;
		$this->functions['defineValuesKeys'] = true;
		$this->functions['initDelete'] = false;
		$this->functions['initInsert'] = false;
		$this->functions['initReplace'] = false;
		$this->functions['initSelect'] = false;
		$this->functions['initUpdate'] = false;
		$this->functions['optimizeRandom'] = false;
		$this->functions['queryExec'] = false;
		$this->functions['queryGet'] = false;
		$this->functions['querySet'] = false;
		$this->functions['vConnect'] = array ();
		$this->functions['vDisconnect'] = array ();
		$this->functions['vOptimize'] = array ();
		$this->functions['vQueryBuild'] = array ();
		$this->functions['vQueryExec'] = array ();
		$this->functions['vSecure'] = array ();
		$this->functions['vTransactionBegin'] = array ();
		$this->functions['vTransactionCommit'] = array ();
		$this->functions['vTransactionRollback'] = array ();

		if (file_exists ($direct_settings['path_data']."/settings/swg_db.php"))
		{
			$direct_globals['basic_functions']->settingsGet ($direct_settings['path_data']."/settings/swg_db.php");

			$this->db_driver_name = 'dNG\sWG\dbraw\direct'.((isset ($direct_settings['db_driver'])) ? ucfirst ($direct_settings['db_driver']) : "Mysql");
			if (!isset ($direct_settings['db_dbprefix'])) { $direct_settings['db_dbprefix'] = "swg_"; }

			if ($f_peristent) { $direct_settings['db_peristent'] = true; }
			elseif (!isset ($direct_settings['db_peristent'])) { $direct_settings['db_peristent'] = $f_peristent; }
			else { $direct_settings['db_peristent'] = false; }

			if (direct_autoload ($this->db_driver_name))
			{
				$this->db_driver = new $this->db_driver_name ();

				if (is_object ($this->db_driver))
				{
					$this->functions['defineRowConditionsEncode'] = true;
					$this->functions['defineSetAttributesEncode'] = true;
					$this->functions['defineValuesEncode'] = true;
					$this->functions['initDelete'] = true;
					$this->functions['initInsert'] = true;
					$this->functions['initReplace'] = true;
					$this->functions['initSelect'] = true;
					$this->functions['initUpdate'] = true;
					$this->functions['optimizeRandom'] = true;
					$this->functions['queryExec'] = true;

/* -------------------------------------------------------------------------
Connect to the database abstraction layer
------------------------------------------------------------------------- */

					$this->vCallSet ("vConnect",$this->db_driver,"connect");
					$this->vCallSet ("vDisconnect",$this->db_driver,"disconnect");
					$this->vCallSet ("vOptimize",$this->db_driver,"optimize");
					$this->vCallSet ("vQueryBuild",$this->db_driver,"queryBuild");
					$this->vCallSet ("vQueryExec",$this->db_driver,"queryExec");
					$this->vCallSet ("vSecure",$this->db_driver,"secure");
					$this->vCallSet ("vTransactionBegin",$this->db_driver,"transactionBegin");
					$this->vCallSet ("vTransactionCommit",$this->db_driver,"transactionCommit");
					$this->vCallSet ("vTransactionRollback",$this->db_driver,"transactionRollback");
				}
			}
			else { trigger_error ("sWG/#echo(__FILEPATH__)# -db->__construct (directDB)- (#echo(__LINE__)#) reporting: Fatal error while loading the raw SQL handler",E_USER_ERROR); }
		}
		else { trigger_error ("sWG/#echo(__FILEPATH__)# -db->__construct (directDB)- (#echo(__LINE__)#) reporting: Fatal error while loading database settings",E_USER_ERROR); }

/* -------------------------------------------------------------------------
Set up some variables
------------------------------------------------------------------------- */

		$this->query_attributes = array ("*");
		$this->query_element = 0;
		$this->query_grouping = array ();
		$this->query_joins = array ();
		$this->query_limit = 0;
		$this->query_offset = 0;
		$this->query_ordering = "";
		$this->query_row_conditions = "";
		$this->query_search_conditions = "";
		$this->query_set_attributes = array ();
		$this->query_table = "";
		$this->query_type = "";
		$this->query_values = "";
		$this->query_values_keys = array ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directDB (directDB)
	*
	* @param boolean $f_peristent True to establish a persistent connection
	* @since v0.1.00
*\/
	function directDB ($f_peristent = false) { $this->__construct ($f_peristent = false); }
:#\n*/
/**
	* Destructor (PHP5) __destruct (directDB)
	* Closes the database connection on destruction.
	*
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __destruct () { $this->vDisconnect (); }

/**
	* Defines SQL attributes. (Only supported for SQL SELECT)
	*
	* @param  mixed $f_attribute_list Requested attributes (including AS
	*         definition) as array or a string for "*"
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function defineAttributes ($f_attribute_list)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->defineAttributes (+f_attribute_list)- (#echo(__LINE__)#)"); }

		if ($this->query_type == "select")
		{
			$this->query_attributes = ((is_array ($f_attribute_list)) ? $f_attribute_list : array ($f_attribute_list));
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineAttributes ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineAttributes ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Defines the SQL GROUP BY clause. (Only supported for SQL SELECT)
	*
	* @param  mixed $f_attribute_list Requested grouping (including AS
	*         definition) as array or a string (for a single attribute)
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function defineGrouping ($f_attribute_list)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->defineGrouping (+f_attribute_list)- (#echo(__LINE__)#)"); }

		if ($this->query_type == "select")
		{
			$this->query_grouping = ((is_array ($f_attribute_list)) ? $f_attribute_list : array ($f_attribute_list));
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineGrouping ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineGrouping ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Defines the SQL JOIN clause. (Only supported for SQL SELECT)
	*
	* @param  string $f_type Type of JOIN
	* @param  string $f_table Name of the table (" AS Name" is valid)
	* @param  string $f_requirements ON definitions given as an array
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function defineJoin ($f_type,$f_table,$f_requirements)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->defineJoin ($f_type,$f_table,+f_requirements)- (#echo(__LINE__)#)"); }

		if (($this->query_type == "select")&&((is_string ($f_requirements))||($f_type == "cross-join")))
		{
			$this->query_joins[] = array ("type" => $f_type,"table" => $f_table,"requirements" => $f_requirements);
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineJoin ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineJoin ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Defines a row limit for queries.
	*
	* @param  integer $f_limit Limit for the query
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function defineLimit ($f_limit)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->defineLimit ($f_limit)- (#echo(__LINE__)#)"); }

		if (($this->query_type == "delete")||($this->query_type == "select")||($this->query_type == "update"))
		{
			$this->query_limit = $f_limit;
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineLimit ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineLimit ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Defines an offset for queries.
	*
	* @param  integer $f_offset Offset for the query (0 for none)
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function defineOffset ($f_offset)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->defineOffset ($f_offset)- (#echo(__LINE__)#)"); }

		if ($this->query_type == "select")
		{
			$this->query_offset = $f_offset;
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineOffset ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineOffset ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Defines the SQL ORDER BY items.
	*
	* @param  string $f_ordering_list XML-encoded elements how to order the list
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function defineOrdering ($f_ordering_list)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->defineOrdering (+f_ordering_list)- (#echo(__LINE__)#)"); }

		if (($this->query_type == "select")&&(is_string ($f_ordering_list)))
		{
			$this->query_ordering = $f_ordering_list;
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineOrdering ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineOrdering ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Defines the SQL WHERE clause.
	*
	* @param  string $f_requirements WHERE definitions given as an array
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function defineRowConditions ($f_requirements)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->defineRowConditions (+f_requirements)- (#echo(__LINE__)#)"); }

		if ((($this->query_type == "delete")||($this->query_type == "select")||($this->query_type == "update"))&&(is_string ($f_requirements)))
		{
			$this->query_row_conditions = $f_requirements;
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineRowConditions ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineRowConditions ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Returns valid XML sqlbox code for WHERE. Useful to secure values of
	* attributes against SQL injection.
	*
	* @param  string $f_attribute Attribute
	* @param  string $f_value Value of the attribute
	* @param  string $f_type Value type (attribute, number, string)
	* @param  string $f_logical_operator Logical operator
	* @param  string $f_condition_mode Condition of this element
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function defineRowConditionsEncode ($f_attribute,$f_value,$f_type,$f_logical_operator = "==",$f_condition_mode = "and")
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->defineRowConditionsEncode ($f_attribute,$f_value,$f_type,$f_logical_operator,$f_condition_mode)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (isset ($direct_globals['xml_bridge']))
		{
			switch ($f_type)
			{
			case "attribute":
			{
				$f_value = preg_replace ("#\s#","",$f_value);
				break 1;
			}
			case "number":
			{
				$f_value = ((is_numeric ($f_value)) ? (float)$f_value : NULL);
				break 1;
			}
			case "sublevel": { break 1; }
			default:
			{
				$f_type = "string";
				if ($f_value !== NULL) { $this->vSecure ($f_value); }
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
			$f_return = $direct_globals['xml_bridge']->array2xmlItemEncoder ($f_xml_node_array,true,false);
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineRowConditionsEncode ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Defines search conditions for the database.
	*
	* @param  string $f_conditions Conditions to search for
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function defineSearchConditions ($f_conditions)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->defineSearchConditions (+f_conditions)- (#echo(__LINE__)#)"); }

		if (($this->query_type == "select")&&(is_string ($f_conditions)))
		{
			$this->query_search_conditions = $f_conditions;
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineSearchConditions ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineSearchConditions ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Creates the search term definition XML code for the given term.
	*
	* @param  string $f_term Term to search for
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function defineSearchConditionsTerm ($f_term)
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->defineSearchConditionsTerm (+f_term)- (#echo(__LINE__)#)"); }

		$f_return = ((isset ($direct_globals['xml_bridge'])) ? $direct_globals['xml_bridge']->array2xmlItemEncoder (array ("tag" => "searchterm","value" => $f_term),true,false) : false);
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineSearchConditionsTerm ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Defines the SQL SET clause.
	*
	* @param  string $f_attribute_list Attributes to set
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function defineSetAttributes ($f_attribute_list)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->defineSetAttributes (+f_attribute_list)- (#echo(__LINE__)#)"); }

		$f_continue_check = true;
		if (($this->query_type != "insert")&&($this->query_type != "replace")&&($this->query_type != "update")) { $f_continue_check = false; }
		if (!empty ($this->query_values)) { $f_continue_check = false; }

		if (($f_continue_check)&&(is_string ($f_attribute_list)))
		{
			$this->query_set_attributes = $f_attribute_list;
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineSetAttributes ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineSetAttributes ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Returns valid XML sqlbox code for SET. Useful to secure values against SQL
	* injection.
	*
	* @param  string $f_attribute Attribute
	* @param  string $f_value Value string
	* @param  string $f_type Value type (attribute, number, string)
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function defineSetAttributesEncode ($f_attribute,$f_value,$f_type)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->defineSetAttributesEncode ($f_attribute,$f_value,$f_type)- (#echo(__LINE__)#)"); }

		$f_return = False;

		if (isset ($direct_globals['xml_bridge']))
		{
			switch ($f_type)
			{
			case "attribute":
			{
				$f_value = preg_replace ("#\s#","",$f_value);
				break 1;
			}
			case "number":
			{
				$f_value = ((is_numeric ($f_value)) ? (float)$f_value : NULL);
				break 1;
			}
			default:
			{
				$f_type = "string";
				if ($f_value !== NULL) { $this->vSecure ($f_value); }
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
			$f_return = $direct_globals['xml_bridge']->array2xmlItemEncoder ($f_xml_node_array,true,false);
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineSetAttributesEncode ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Defines the SQL VALUES element.
	*
	* @param  string $f_values WHERE definitions given as an array
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function defineValues ($f_values)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->defineValues (+f_values)- (#echo(__LINE__)#)"); }

		$f_continue_check = true;
		if (($this->query_type != "insert")&&($this->query_type != "replace")) { $f_continue_check = false; }
		if (!empty ($this->query_set_attributes)) { $f_continue_check = false; }

		if (($f_continue_check)&&(is_string ($f_values)))
		{
			$this->query_values = $f_values;
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineValues ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineValues ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Returns valid XML sqlbox code for VALUES. Useful to secure values against
	* SQL injection.
	*
	* @param  string $f_value Value string
	* @param  string $f_type Value type (attribute, number, string)
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function defineValuesEncode ($f_value,$f_type)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->defineValuesEncode ($f_value,$f_type)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (isset ($direct_globals['xml_bridge']))
		{
			switch ($f_type)
			{
			case "attribute":
			{
				$f_value = preg_replace ("#\s#","",$f_value);
				break 1;
			}
			case "number":
			{
				$f_value = ((is_numeric ($f_value)) ? (float)$f_value : NULL);
				break 1;
			}
			case "newrow": { break 1; }
			default:
			{
				$f_type = "string";
				if ($f_value !== NULL) { $this->vSecure ($f_value); }
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
			$f_return = $direct_globals['xml_bridge']->array2xmlItemEncoder ($f_xml_node_array,true,false);
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineValuesEncode ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Defines the key list for the SQL VALUES statement.
	*
	* @param  array $f_keys_list Key list for VALUES
	* @return boolean False if query is empty or on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function defineValuesKeys ($f_keys_list)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->defineValuesKeys (+f_keys_list)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if ((($this->query_type == "insert")||($this->query_type == "replace"))&&(is_array ($f_keys_list)))
		{
			$this->query_values_keys = $f_keys_list;
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineValuesKeys ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->defineValuesKeys ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Initiates a DELETE request.
	*
	* @param  string $f_table Name of the table (" AS Name" is valid)
	* @return boolean False if query cache is not empty (Query not executed?)
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function initDelete ($f_table)
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->initDelete ($f_table)- (#echo(__LINE__)#)"); }

		if ((direct_class_function_check ($direct_globals['db'],"vQueryBuild"))&&(!$this->query_type))
		{
			$this->data = "";
			$this->query_attributes = array ("*");
			$this->query_grouping = array ();
			$this->query_joins = array ();
			$this->query_limit = 0;
			$this->query_offset = 0;
			$this->query_ordering = "";
			$this->query_row_conditions = "";
			$this->query_search_conditions = "";
			$this->query_set_attributes = array ();
			$this->query_table = $f_table;
			$this->query_type = "delete";
			$this->query_values = "";
			$this->query_values_keys = array ();

			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->initDelete ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->initDelete ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Initiates a INSERT request.
	*
	* @param  string $f_table Name of the table (" AS Name" is valid)
	* @return boolean False if query cache is not empty (Query not executed?)
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function initInsert ($f_table)
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->initInsert ($f_table)- (#echo(__LINE__)#)"); }

		if ((direct_class_function_check ($direct_globals['db'],"vQueryBuild"))&&(!$this->query_type))
		{
			$this->data = "";
			$this->query_attributes = array ("*");
			$this->query_grouping = array ();
			$this->query_joins = array ();
			$this->query_limit = 0;
			$this->query_offset = 0;
			$this->query_ordering = "";
			$this->query_row_conditions = "";
			$this->query_search_conditions = "";
			$this->query_set_attributes = array ();
			$this->query_table = $f_table;
			$this->query_type = "insert";
			$this->query_values = "";
			$this->query_values_keys = array ();

			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->initInsert ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->initInsert ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Initiates a REPLACE request.
	*
	* @param  string $f_table Name of the table (" AS Name" is valid)
	* @return boolean False if query cache is not empty (Query not executed?)
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function initReplace ($f_table)
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->initReplace ($f_table)- (#echo(__LINE__)#)"); }

		if ((direct_class_function_check ($direct_globals['db'],"vQueryBuild"))&&(!$this->query_type))
		{
			$this->data = "";
			$this->query_attributes = array ("*");
			$this->query_grouping = array ();
			$this->query_joins = array ();
			$this->query_limit = 0;
			$this->query_offset = 0;
			$this->query_ordering = "";
			$this->query_row_conditions = "";
			$this->query_search_conditions = "";
			$this->query_set_attributes = array ();
			$this->query_table = $f_table;
			$this->query_type = "replace";
			$this->query_values = "";
			$this->query_values_keys = array ();

			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->initReplace ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->initReplace ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Initiates a SELECT request.
	*
	* @param  string $f_table Name of the table (" AS Name" is valid)
	* @return boolean False if query cache is not empty (Query not executed?)
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function initSelect ($f_table)
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->initSelect ($f_table)- (#echo(__LINE__)#)"); }

		if ((direct_class_function_check ($direct_globals['db'],"vQueryBuild"))&&(!$this->query_type))
		{
			$this->data = "";
			$this->query_attributes = array ("*");
			$this->query_grouping = array ();
			$this->query_joins = array ();
			$this->query_limit = 0;
			$this->query_offset = 0;
			$this->query_ordering = "";
			$this->query_row_conditions = "";
			$this->query_search_conditions = "";
			$this->query_set_attributes = array ();
			$this->query_table = $f_table;
			$this->query_type = "select";
			$this->query_values = "";
			$this->query_values_keys = array ();

			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->initSelect ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->initSelect ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Initiates a UPDATE request.
	*
	* @param  string $f_table Name of the table (" AS Name" is valid)
	* @return boolean False if query cache is not empty (Query not executed?)
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function initUpdate ($f_table)
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->initUpdate ($f_table)- (#echo(__LINE__)#)"); }

		if ((direct_class_function_check ($direct_globals['db'],"vQueryBuild"))&&(!$this->query_type))
		{
			$this->data = "";
			$this->query_attributes = array ("*");
			$this->query_grouping = array ();
			$this->query_joins = array ();
			$this->query_limit = 0;
			$this->query_offset = 0;
			$this->query_ordering = "";
			$this->query_row_conditions = "";
			$this->query_search_conditions = "";
			$this->query_set_attributes = array ();
			$this->query_table = $f_table;
			$this->query_type = "update";
			$this->query_values = "";
			$this->query_values_keys = array ();

			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->initUpdate ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->initUpdate ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Optimizes a given table randomly (1/3).
	*
	* @param  string $f_table Name of the table
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function optimizeRandom ($f_table)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -db->optimizeRandom ($f_table)- (#echo(__LINE__)#)"); }

		if (mt_rand (0,30) > 20) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->optimizeRandom ()- (#echo(__LINE__)#)",(:#*/$this->vOptimize ($f_table)/*#ifdef(DEBUG):),true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -directDB->optimizeRandom ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Transmits defined data to the SQL builder and returns the result in a
	* developer specified format via $f_answer.
	*
	* @param  string $f_answer Defines the requested type that should be returned
	*         The following types are supported: "ar", "co", "ma", "ms", "nr",
	*         "sa" or "ss".
	* @return mixed Result returned by the server in the specified format
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function queryExec ($f_answer = "sa")
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db->queryExec ($f_answer)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (direct_class_function_check ($direct_globals['db'],"vQueryBuild"))
		{
			$f_data = $this->queryGet ();
			$f_data['answer'] = $f_answer;

			$this->data = $this->vQueryBuild ($f_data);
			$f_return = $this->data;
		}

		return /*#ifdef(DEBUG):direct_debug (9,"sWG/#echo(__FILEPATH__)# -directDB->queryExec ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Returns the query definition.
	*
	* @param  boolean $f_reset Reset class cache
	* @return mixed Query array; false on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function queryGet ($f_reset = true)
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db->queryGet (+f_reset)- (#echo(__LINE__)#)"); }

$f_return = array (
"attributes" => $this->query_attributes,
"grouping" => $this->query_grouping,
"joins" => $this->query_joins,
"limit" => $this->query_limit,
"offset" => $this->query_offset,
"ordering" => $this->query_ordering,
"row_conditions" => $this->query_row_conditions,
"search_conditions" => $this->query_search_conditions,
"set_attributes" => $this->query_set_attributes,
"table" => $this->query_table,
"type" => $this->query_type,
"values" => $this->query_values,
"values_keys" => $this->query_values_keys
);

		if ($f_reset)
		{
			$this->query_attributes = array ("*");
			$this->query_grouping = array ();
			$this->query_joins = array ();
			$this->query_limit = 0;
			$this->query_offset = 0;
			$this->query_ordering = "";
			$this->query_row_conditions = "";
			$this->query_search_conditions = "";
			$this->query_set_attributes = array ();
			$this->query_table = "";
			$this->query_type = "";
			$this->query_values = "";
			$this->query_values_keys = array ();
		}

		return /*#ifdef(DEBUG):direct_debug (9,"sWG/#echo(__FILEPATH__)# -directDB->queryGet ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Sets the given query definition for execution.
	*
	* @param  array $f_query Query array
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function querySet ($f_query)
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db->querySet (+f_reset)- (#echo(__LINE__)#)"); }

		if ((is_array ($f_query)) and (isset ($f_query['attributes'],$f_query['grouping'],$f_query['joins'],$f_query['limit'],$f_query['offset'],$f_query['ordering'],$f_query['row_conditions'],$f_query['search_conditions'],$f_query['set_attributes'],$f_query['table'],$f_query['type'],$f_query['values'],$f_query['values_keys'])))
		{
			$f_return = true;
			$this->query_attributes = $f_query['attributes'];
			$this->query_grouping = $f_query['grouping'];
			$this->query_joins = $f_query['joins'];
			$this->query_limit = $f_query['limit'];
			$this->query_offset = $f_query['offset'];
			$this->query_ordering = $f_query['ordering'];
			$this->query_row_conditions = $f_query['row_conditions'];
			$this->query_search_conditions = $f_query['search_conditions'];
			$this->query_set_attributes = $f_query['set_attributes'];
			$this->query_table = $f_query['table'];
			$this->query_type = $f_query['type'];
			$this->query_values = $f_query['values'];
			$this->query_values_keys = $f_query['values_keys'];
		}
		else { $f_return = false; }

		return /*#ifdef(DEBUG):direct_debug (9,"sWG/#echo(__FILEPATH__)# -directDB->querySet ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Opens the connection to a database server and selects a database.
	*
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function vConnect ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db->vConnect ()- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vConnect");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}

/**
	* Closes an active database connection to the server.
	*
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function vDisconnect ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db->vDisconnect ()- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vDisconnect");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}

/**
	* Optimizes a given table.
	*
	* @param  string $f_table Name of the table
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function vOptimize ($f_table)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db->vOptimize ($f_table)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vOptimize");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_table) : false);
	}

/**
	* Builds and runs the SQL statement using the connected database specific
	* layer.
	*
	* @param  array $f_data Array containing query specific information.
	* @return mixed Result returned by the server in the specified format
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function vQueryBuild ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db->vQueryBuild (+f_query)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vQueryBuild");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_data) : false);
	}

/**
	* Transmits an SQL query and returns the result in a developer specified
	* format via $f_answer.
	*
	* @param  string $f_answer Defines the requested type that should be returned
	*         The following types are supported: "ar", "co", "ma", "ms", "nr",
	*         "sa" or "ss".
	* @param  string $f_query Valid SQL query
	* @return mixed Result returned by the server in the specified format
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function vQueryExec ($f_answer,$f_query)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db->vQueryExec ($f_answer,+f_query)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vQueryExec");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_answer,$f_query) : false);
	}

/**
	* Secures a given string to protect against SQL injections.
	*
	* @param  mixed &$f_data Input array or string
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function vSecure (&$f_data)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db->vSecure (+f_data)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vSecure");
		if ($f_call) { $f_call[0]->{$f_call[1]} ($f_data); }
	}

/**
	* Starts a transaction.
	*
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function vTransactionBegin ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db->vTransactionBegin ()- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vTransactionBegin");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}

/**
	* Commits all transaction statements.
	*
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function vTransactionCommit ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db->vTransactionCommit ()- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vTransactionCommit");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}

/**
	* Calls the ROLLBACK statement.
	*
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function vTransactionRollback ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -db->vTransactionRollback ()- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vTransactionRollback");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directDB",true);

//j// Script specific commands

global $direct_globals;
$direct_globals['@names']['db'] = 'dNG\sWG\directDB';
}

//j// EOF
?>