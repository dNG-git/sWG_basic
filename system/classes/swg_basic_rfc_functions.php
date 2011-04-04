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
* This class provides basic functions described in different RFCs.
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
* @subpackage basic_rfc_functions
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

$g_continue_check = ((defined ("CLASS_direct_basic_rfc_functions")) ? false : true);
if (!defined ("CLASS_direct_data_handler")) { $g_continue_check = false; }

if ($g_continue_check)
{
//c// direct_basic_rfc_functions
/**
* This class is extended by sendmailer and web_functions to provide some RFC
* defined methods.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage basic_rfc_functions
* @uses       CLASS_direct_data_handler
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_basic_rfc_functions extends direct_data_handler
{
/**
	* @var string $data_boundary Boundary string for this message
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $data_boundary;
/**
	* @var string $linesep Line separator (\r\n or \n)
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $linesep;
/**
	* @var boolean $PHP_mb_encode_mimeheader True if the PHP function
	*      "mb_encode_mimeheader () " is supported.
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $PHP_mb_encode_mimeheader;
/**
	* @var boolean $PHP_quoted_printable_encode True if the PHP function
	*      "quoted_printable_encode () " is supported.
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $PHP_quoted_printable_encode;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_basic_rfc_functions->__construct () and direct_basic_rfc_functions->direct_basic_rfc_functions ()
/**
	* Constructor (PHP5) __construct (direct_basic_rfc_functions)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @uses  USE_socket
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basic_rfc_functions->__construct (direct_basic_rfc_functions)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['header_align'] = true;
		$this->functions['header_parse'] = true;
		$this->functions['multipart_body_alternative_header'] = true;
		$this->functions['multipart_body_alternative_footer'] = true;
		$this->functions['multipart_body'] = true;
		$this->functions['multipart_footer'] = true;
		$this->functions['multipart_header'] = true;
		$this->functions['quoted_printable_encode'] = true;

/* -------------------------------------------------------------------------
Add a variable for the current boundary
------------------------------------------------------------------------- */

		$this->data_boundary = "";
		$this->linesep = "\r\n";
		$this->PHP_mb_encode_mimeheader = function_exists ("mb_encode_mimeheader");
		$this->PHP_quoted_printable_encode = function_exists ("quoted_printable_encode");
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_basic_rfc_functions (direct_basic_rfc_functions)
	*
	* @since v0.1.00
*\/
	function direct_basic_rfc_functions () { $this->__construct (); }
:#*/
	//f// direct_basic_rfc_functions->header_align ($f_data)
/**
	* Aligns the header to the line size limit using folding.
	*
	* @param  string $f_header Input header string
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Aligned header (maximum 76 characters)
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function header_align ($f_header)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basic_rfc_functions->header_align (+f_header)- (#echo(__LINE__)#)"); }

		if (strlen ($f_header) > 76)
		{
			$f_length = 0;
			$f_words_array = explode (" ",$f_header);
			$f_return = "";

			foreach ($f_words_array as $f_word)
			{
				$f_length += strlen ($f_word);

				if ($f_length > 76)
				{
					$f_return .= $this->linesep." ";
					$f_length = (strlen ($f_word) + 1);
				}
				elseif ($f_return)
				{
					$f_length++;
					$f_return .= " ";
				}

				$f_return .= $f_word;
			}
		}
		else { $f_return = $f_header; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basic_rfc_functions->header_align ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_basic_rfc_functions->header_parse ($f_headers)
/**
	* Parses a string of headers.
	*
	* @param  string $f_headers Input header string
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return mixed Array with parsed headers; false on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function header_parse ($f_headers)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basic_rfc_functions->header_parse (+f_headers)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if ((is_string ($f_headers))&&(strlen ($f_headers)))
		{
			$f_headers = trim (preg_replace ("#\r\n((\\x09)(\\x09)*|(\\x20)(\\x20)*)(\S)#","\\2\\4\\6",$f_headers));
			$f_return = array ();

			$f_header_array = explode ("\r\n",$f_headers);

			foreach ($f_header_array as $f_header)
			{
				$f_header_array = explode (":",$f_header,2);

				if (count ($f_header_array) == 2)
				{
					$f_header_name = strtolower ($f_header_array[0]);
					$f_header_array[1] = trim ($f_header_array[1]);

					if (isset ($f_return[$f_header_name]))
					{
						if (is_array ($f_return[$f_header_name])) { $f_return[$f_header_name][] = $f_header_array[1]; }
						else { $f_return[$f_header_name] = array ($f_return[$f_header_name],$f_header_array[1]); }
					}
					else { $f_return[$f_header_name] = $f_header_array[1]; }
				}
				elseif (strlen ($f_header_array[0]))
				{
					if (isset ($f_return['@untagged'])) { $f_return['@untagged'] .= "\n".(trim ($f_header_array[0])); }
					else { $f_return['@untagged'] = trim ($f_header_array[0]); }
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basic_rfc_functions->header_parse ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_basic_rfc_functions->multipart_body ($f_name,$f_data,$f_alternative_id = "")
/**
	* Returns a multipart body header.
	*
	* @param  string $f_name Content file name if applicable
	* @param  array $f_data Attachement data array
	* @param  string $f_alternative_id Multipart ID for alternative body data
	* @uses   direct_debug()
	* @uses   direct_basic_rfc_functions::header_align()
	* @uses   direct_basic_rfc_functions::quoted_printable_encode()
	* @return string Multipart body header
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function multipart_body ($f_name,$f_data,$f_alternative_id = "")
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basic_rfc_functions->multipart_body ($f_name,+f_data,$f_alternative_id)- (#echo(__LINE__)#)"); }

		$f_return = ($f_alternative_id ? "--".$this->data_boundary."_".$f_alternative_id.$this->linesep : "--".$this->data_boundary.$this->linesep);

		if (strpos ($f_name,"@") === false)
		{
			$f_name = preg_replace ("#[;\/\\\?:@\=\"\&\']#","_",$f_name);

			$f_return .= ($f_data['encoding'] ? (($this->header_align ("Content-Type: ".$f_data['mimetype']."; name=\"$f_name\"; charset=".$f_data['encoding'])).$this->linesep) : (($this->header_align ("Content-Type: ".$f_data['mimetype']."; name=\"$f_name\"")).$this->linesep));
			$f_disposition = ((isset ($f_data['disposition'])) ? $f_data['disposition'] : "attachment");

			if (strlen ($f_name)) { $f_disposition_fields = (($f_disposition == "attachment") ? "; filename=\"$f_name\"" : "; name=\"$f_name\""); }
			else { $f_disposition_fields = ""; }

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data['mimetype'],"text/") === false)
			{
				$f_return .= (($this->header_align ("Content-Transfer-Encoding: base64")).$this->linesep);
				$f_return .= (($this->header_align ("Content-Disposition: ".$f_disposition.$f_disposition_fields)).$this->linesep.$this->linesep);
				$f_return .= wordwrap ((base64_encode ($f_data['data'])),76,$this->linesep,1);
			}
			else
			{
				$f_return .= (($this->header_align ("Content-Transfer-Encoding: quoted-printable")).$this->linesep);
				$f_return .= (($this->header_align ("Content-Disposition: ".$f_disposition.$f_disposition_fields)).$this->linesep.$this->linesep);
				$f_return .= $this->quoted_printable_encode ($f_data['data']);
			}
		}
		else
		{
			$f_return .= (($this->header_align ("Content-Type: ".$f_data['mimetype']."; charset=".$f_data['encoding'])).$this->linesep);
			$f_return .= (($this->header_align ("Content-Transfer-Encoding: quoted-printable")).$this->linesep.$this->linesep);
			$f_return .= $this->quoted_printable_encode ($f_data['data']);
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basic_rfc_functions->multipart_body ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_basic_rfc_functions->multipart_body_alternative_footer ($f_id)
/**
	* Returns a multipart body alternative footer.
	*
	* @param  string $f_id Multipart alternative ID
	* @return string Multipart alternative footer
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function multipart_body_alternative_footer ($f_id) { return "--".$this->data_boundary."_".$f_id."--"; }

	//f// direct_basic_rfc_functions->multipart_body_alternative_header ($f_id)
/**
	* Returns a multipart body alternative header.
	*
	* @param  string $f_id Multipart alternative ID
	* @return string Multipart alternative header
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function multipart_body_alternative_header ($f_id) { return "--".$this->data_boundary.$this->linesep.($this->header_align ("Content-Type: multipart/alternative; boundary=\"".$this->data_boundary."_$f_id\"")); }

	//f// direct_basic_rfc_functions->multipart_footer ()
/**
	* Returns a multipart body footer.
	*
	* @return string Multipart footer
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function multipart_footer () { return "--".$this->data_boundary."--"; }

	//f// direct_basic_rfc_functions->multipart_header ($f_header_content_type = "multipart/related")
/**
	* Adds the unique multipart header to the message.
	*
	* @param  string Content type of this multipart element
	* @uses   direct_basic_rfc_functions::header_align()
	* @return string Multipart header declaration (including boundary)
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function multipart_header ($f_header_content_type = "multipart/related")
	{
		global $direct_cachedata,$direct_settings;

		$this->data_boundary = ("=_direct-mime_".$direct_cachedata['core_time']."_".$direct_settings['swg_id'].(uniqid ("")));
		return $this->header_align ("Content-Type: $f_header_content_type; boundary=\"".$this->data_boundary."\"");
	}

	//f// direct_basic_rfc_functions->quoted_printable_encode ($f_data,$f_rfc2047 = false)
/**
	* Formats a given string and returns a valid Quoted Printable one.
	*
	* @param  string $f_data Input string
	* @param  boolean $f_rfc2047 Encode data according to RFC 2047
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Formatted output string; empty on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function quoted_printable_encode ($f_data,$f_rfc2047 = false)
	{
		global $direct_local;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basic_rfc_functions->quoted_printable_encode (+f_data,+f_rfc2047)- (#echo(__LINE__)#)"); }

		$f_n_check = true;
		$f_r_check = false;

		if ($f_rfc2047)
		{
			if ($this->PHP_mb_encode_mimeheader)
			{
				$f_return = mb_encode_mimeheader ($f_data);
				if ($this->linesep != "\r\n") { $f_return = str_replace ("\r\n",$this->linesep,$f_return); }
			}
			else
			{
				$f_return = "=?$direct_local[lang_charset]?Q?";
				$f_rfc2047_length = strlen ($f_return);

				$f_length = $f_rfc2047_length;
				$f_words_array = explode (" ",$f_data);
			}
		}
		elseif ($this->PHP_quoted_printable_encode)
		{
			$f_return = quoted_printable_encode ($f_data);
			if ($this->linesep != "\r\n") { $f_return = str_replace ("\r\n",$this->linesep,$f_return); }
		}
		else
		{
			$f_length = 0;
			$f_words_array = explode (" ",$f_data);
		}

		if (isset ($f_words_array))
		{
			foreach ($f_words_array as $f_word)
			{
				if (strlen ($f_word))
				{
					$f_word_filtered = "";
					$f_word_length = strlen ($f_word);

					for ($f_char_number = 0;$f_char_number < $f_word_length;$f_char_number++)
					{
						$f_char = ord ($f_word[$f_char_number]);

						if (((32 < $f_char)&&($f_char < 61))||((61 < $f_char)&&($f_char < 127)))
						{
							if ($f_r_check) { $f_r_check = false; }
							if ($f_n_check) { $f_n_check = false; }
							$f_length++;
							$f_word_filtered .= $f_word[$f_char_number];
						}
						else
						{
							switch ($f_char)
							{
							case 9:
							{
								if ($f_n_check)
								{
									$f_length += 3;
									$f_word_filtered .= "=09";
								}
								else
								{
									$f_length++;
									$f_word_filtered .= $f_word[$f_char_number];
								}

								break 1;
							}
							case 10:
							{
								if (!$f_r_check)
								{
									if ($f_rfc2047)
									{
										$f_length = (1 + $f_rfc2047_length);
										$f_word_filtered .= "?={$this->linesep} =?$direct_local[lang_charset]?Q?";
									}
									else
									{
										$f_length = strlen ($this->linesep);
										$f_word_filtered .= $this->linesep;
									}
								}

								$f_r_check = false;
								$f_n_check = true;
								break 1;
							}
							case 13:
							{
								$f_r_check = true;
								$f_n_check = true;

								if ($f_rfc2047)
								{
									$f_length = (1 + $f_rfc2047_length);
									$f_word_filtered .= "?={$this->linesep} =?$direct_local[lang_charset]?Q?";
								}
								else
								{
									$f_length = strlen ($this->linesep);
									$f_word_filtered .= $this->linesep;
								}

								break 1;
							}
							default:
							{
								if ($f_r_check) { $f_r_check = false; }
								if ($f_n_check) { $f_n_check = false; }
								$f_length += 3;
								$f_word_filtered .= "=".(strtoupper (dechex ($f_char)));
							}
							}
						}

						if ($f_length > 72)
						{
							if (strlen ($f_word_filtered) < 73)
							{
								if ($f_rfc2047)
								{
									$f_length = (strlen ($f_word_filtered) + 1 + $f_rfc2047_length);
									$f_word_filtered = "?={$this->linesep} =?$direct_local[lang_charset]?Q?".$f_word_filtered;
								}
								else
								{
									$f_length = strlen ($f_word_filtered);
									$f_word_filtered = "=".$this->linesep.$f_word_filtered;
								}
							}
							else
							{
								$f_r_check = true;
								$f_n_check = true;

								if ($f_rfc2047)
								{
									$f_length = (1 + $f_rfc2047_length);
									$f_word_filtered .= "?={$this->linesep} =?$direct_local[lang_charset]?Q?";
								}
								else
								{
									$f_length = 0;
									$f_word_filtered .= "=".$this->linesep;
								}
							}
						}
					}

					if (($f_n_check)||($f_rfc2047))
					{
						$f_return .= $f_word_filtered."=20";
						$f_length += 3;
					}
					else
					{
						$f_return .= $f_word_filtered." ";
						$f_length++;
					}
				}
				else
				{
					if ($f_length > 72)
					{
						$f_n_check = true;

						if ($f_rfc2047)
						{
							$f_length = (1 + $f_rfc2047_length);
							$f_return .= "?={$this->linesep} =?$direct_local[lang_charset]?Q?";
						}
						else
						{
							$f_length = 0;
							$f_return .= "=".$this->linesep;
						}
					}

					if (($f_n_check)||($f_rfc2047))
					{
						$f_length += 3;
						$f_return .= "=20";
					}
					else
					{
						$f_length++;
						$f_return .= " ";
					}
				}
			}

			$f_return = ($f_rfc2047 ? preg_replace ("#(=20)*\?=({$this->linesep} =\?".(preg_quote ($direct_local['lang_charset']))."\?Q\?(=20)+\?=)*$#s","?=",$f_return."?=") : rtrim ($f_return));
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basic_rfc_functions->quoted_printable_encode ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_direct_basic_rfc_functions",true);
}

//j// EOF
?>