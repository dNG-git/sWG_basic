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
* This class provides functions to handle server based communication for
* downloading or uploading content.
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
* @subpackage web_functions
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
/*#ifdef(PHP5n) */

namespace dNG\sWG;
/* #*/
/*#use(direct_use) */
use dNG\sWG\directBasicRfcFunctions;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

if (!defined ("CLASS_directWebFunctions"))
{
/**
* This support is a basic one. You can use fopen as well as GET and POST
* commands (depending on the "socket" constant).
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage web_functions
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class directWebFunctions extends directBasicRfcFunctions
{
/**
	* @var string $content_type Content typRequest c
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $content_type;
/**
	* @var array $data_http_headers Cached headers of a "http ()" call
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $data_http_headers;
/**
	* @var string $data_http_result_code The result code of a
	*      "http ()" call
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $data_http_result_code;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directWebFunctions)
	*
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -webFunctions->__construct (directWebFunctions)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['defineContentType'] = false;
		$this->functions['getContent'] = true;
		$this->functions['getContentSize'] = true;
		$this->functions['getContentType'] = false;
		$this->functions['getHeaders'] = false;
		$this->functions['getResultCode'] = false;
		$this->functions['httpCurlGet'] = false;
		$this->functions['httpCurlPost'] = false;
		$this->functions['httpCurlRange'] = false;
		$this->functions['httpGet'] = true;
		$this->functions['httpQueryParse'] = true;
		$this->functions['httpPost'] = false;
		$this->functions['httpRange'] = true;
		$this->functions['httpResponseParse'] = true;
		$this->functions['httpSocketGet'] = false;
		$this->functions['httpSocketPost'] = false;
		$this->functions['httpSocketRange'] = false;

		if (USE_socket)
		{
			$this->functions['defineContentType'] = true;
			$this->functions['getContentType'] = true;
			$this->functions['httpPost'] = true;
			$this->functions['httpSocketGet'] = true;
			$this->functions['httpSocketPost'] = true;
			$this->functions['httpSocketRange'] = true;
		}
		elseif (function_exists ("curl_init"))
		{
			$this->functions['defineContentType'] = true;
			$this->functions['getContentType'] = true;
			$this->functions['httpCurlGet'] = true;
			$this->functions['httpCurlPost'] = true;
			$this->functions['httpCurlRange'] = true;
			$this->functions['httpPost'] = true;
		}

/* -------------------------------------------------------------------------
Add some more variables
------------------------------------------------------------------------- */

		$this->content_type = NULL;
		$this->data = "";
		$this->data_http_headers = array ();
		$this->data_http_result_code = "";
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directWebFunctions
	*
	* @since v0.1.00
*\/
	function directWebFunctions () { $this->__construct (); }
:#*/
/**
	* Sets a custom Content-Type header for requests. Use NULL to reset it.
	*
	* @param  mixed $f_type Mime-Type to be used or NULL for reset
	* @since  v0.1.00
*/
	public function defineContentType ($f_type = NULL)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -webFunctions->defineContentType (+f_type)- (#echo(__LINE__)#)"); }
		$this->content_type = $f_type;
	}

/**
	* "getContent" is a wrapper for "get".
	*
	* @return string HTTP content
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function getContent ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -webFunctions->getContent ()- (#echo(__LINE__)#)"); }
		return $this->get ();
	}

/**
	* Returns the size of the HTTP content.
	*
	* @return string HTTP content length value; false if undefined
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function getContentSize ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -webFunctions->getContentSize ()- (#echo(__LINE__)#)"); }
		$f_return = strlen ($this->data);

		if (!$f_return)
		{
			$f_return = false;
			if (isset ($this->data_http_headers['content-length'])) { $f_return = preg_replace ("#(\D+)#","",$this->data_http_headers['content-length']); }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -webFunctions->getContentSize ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Returns the type of the HTTP content (given by the web server).
	*
	* @return string HTTP content type value; false if undefined
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function getContentType ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -webFunctions->getContentType ()- (#echo(__LINE__)#)"); }
		$f_return = false;

		if ($this->data_http_headers)
		{
			if (isset ($this->data_http_headers['content-type'])) { $f_return = trim (preg_replace ("#^(.+?);(.*?)$#s","\\1",$this->data_http_headers['content-type'])); }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -webFunctions->getContentType ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Returns the HTTP headers of the last call.
	*
	* @return array Found HTTP headers
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function getHeaders ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -webFunctions->getHeaders ()- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -webFunctions->getHeaders ()- (#echo(__LINE__)#)",:#*/$this->data_http_headers/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Returns the HTTP result code of the last call.
	*
	* @return mixed Returned HTTP result code ("200") or error string
	*         "error:403:Forbidden"
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function getResultCode ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -webFunctions->getResultCode ()- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -webFunctions->getResultCode ()- (#echo(__LINE__)#)",:#*/$this->data_http_result_code/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Reads headers and HTTP content using CURL.
	*
	* @param  string $f_server Server name or IP address of target
	* @param  integer $f_port The target port
	* @param  string $f_path The absolute address to the remote resource
	* @param  mixed $f_data Variables that should be transfered to the remote
	*         server (empty string for none)
	* @param  boolean $f_header_only Only receive the header
	* @return mixed Remote content on success; false on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function httpCurlGet ($f_server,$f_port = 80,$f_path = "",$f_data = "",$f_header_only = false)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -webFunctions->httpCurlGet ($f_server,$f_port,$f_path,+f_data,+f_header_only)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (preg_match ("#^http(s|):\/\/(.+?)$#i",$f_server,$f_result_array))
		{
			$f_query = $this->httpQueryParse ($f_data);
			if ($f_query) { $f_query = "?".$f_query; }

			$f_curl_pointer = curl_init ($f_server.":".$f_port.$f_path.$f_query);

			if (($f_curl_pointer)&&(defined ("CURLOPT_BINARYTRANSFER"))&&(defined ("CURLOPT_CONNECTTIMEOUT"))&&(defined ("CURLOPT_HEADER"))&&(defined ("CURLOPT_HTTPGET"))&&(defined ("CURLOPT_HTTPHEADER"))&&(defined ("CURLOPT_NOBODY"))&&(defined ("CURLOPT_NOPROGRESS"))&&(defined ("CURLOPT_RETURNTRANSFER"))&&(defined ("CURLOPT_TIMEOUT")))
			{
				curl_setopt ($f_curl_pointer,CURLOPT_BINARYTRANSFER,true);
				curl_setopt ($f_curl_pointer,CURLOPT_CONNECTTIMEOUT,$direct_settings['swg_web_socket_timeout']);
				curl_setopt ($f_curl_pointer,CURLOPT_HEADER,true);

				if (($f_header_only)&&(defined ("CURLOPT_CUSTOMREQUEST"))) { curl_setopt ($f_curl_pointer,CURLOPT_CUSTOMREQUEST,"HEAD"); }
				else { curl_setopt ($f_curl_pointer,CURLOPT_HTTPGET,true); }

				curl_setopt ($f_curl_pointer,CURLOPT_HTTPHEADER,(array ("Connection: close")));
				if ($f_header_only) { curl_setopt ($f_curl_pointer,CURLOPT_NOBODY,true); }
				curl_setopt ($f_curl_pointer,CURLOPT_NOPROGRESS,true);
				curl_setopt ($f_curl_pointer,CURLOPT_RETURNTRANSFER,true);
				curl_setopt ($f_curl_pointer,CURLOPT_TIMEOUT,$direct_settings['swg_web_socket_timeout']);
				if (defined ("CURLOPT_FILETIME")) { curl_setopt ($f_curl_pointer,CURLOPT_FILETIME,false); }
				if (defined ("CURLOPT_FOLLOWLOCATION")) { curl_setopt ($f_curl_pointer,CURLOPT_FOLLOWLOCATION,true); }
				if (defined ("CURLOPT_MAXREDIRS")) { curl_setopt ($f_curl_pointer,CURLOPT_MAXREDIRS,5); }
				if (defined ("CURLOPT_UNRESTRICTED_AUTH")) { curl_setopt ($f_curl_pointer,CURLOPT_UNRESTRICTED_AUTH,false); }
				if (defined ("CURLOPT_USERAGENT")) { curl_setopt ($f_curl_pointer,CURLOPT_USERAGENT,"$direct_settings[product_lcode_txt]/$direct_settings[product_version]"); }

				$f_response = curl_exec ($f_curl_pointer);
				$f_error = curl_error ($f_curl_pointer);
				curl_close ($f_curl_pointer);

				if (strlen ($f_error))
				{
					$this->data = "";
					$this->data_http_headers = array ();
					$this->data_http_result_code = "error::".$f_error;
				}
				else { $f_return = $this->httpResponseParse ($f_response); }
			}
			else
			{
				$this->data = "";
				$this->data_http_headers = array ();
				$this->data_http_result_code = "error::invalid request";
			}
		}
		else
		{
			$this->data = "";
			$this->data_http_headers = array ();
			$this->data_http_result_code = "error::invalid request";
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -webFunctions->httpCurlGet ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Sending a POST request and reading headers and HTTP content using CURL.
	*
	* @param  string $f_server Server name or IP address of target
	* @param  integer $f_port The target port
	* @param  string $f_path The absolute address to the remote resource
	* @param  mixed $f_data Variables that should be transfered to the remote
	*         server (empty string for none)
	* @param  boolean $f_parse True to parse $f_data for encoding
	* @return mixed Remote content on success; false on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function httpCurlPost ($f_server,$f_port = 80,$f_path = "",$f_data = "",$f_parse = true)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -webFunctions->httpCurlPost ($f_server,$f_port,$f_path,+f_data,+f_parse)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (preg_match ("#^http(s|):\/\/(.+?)$#i",$f_server,$f_result_array))
		{
			$f_query = $this->httpQueryParse ($f_data);
			if ($f_query) { $f_query = "?".$f_query; }

			$f_curl_pointer = curl_init ($f_server.":".$f_port.$f_path.$f_query);

			if (($f_curl_pointer)&&(defined ("CURLOPT_BINARYTRANSFER"))&&(defined ("CURLOPT_CONNECTTIMEOUT"))&&(defined ("CURLOPT_HEADER"))&&(defined ("CURLOPT_HTTPHEADER"))&&(defined ("CURLOPT_NOPROGRESS"))&&(defined ("CURLOPT_POST"))&&(defined ("CURLOPT_POSTFIELDS"))&&(defined ("CURLOPT_RETURNTRANSFER"))&&(defined ("CURLOPT_TIMEOUT")))
			{
				curl_setopt ($f_curl_pointer,CURLOPT_BINARYTRANSFER,true);
				curl_setopt ($f_curl_pointer,CURLOPT_CONNECTTIMEOUT,$direct_settings['swg_web_socket_timeout']);
				curl_setopt ($f_curl_pointer,CURLOPT_HEADER,true);
				curl_setopt ($f_curl_pointer,CURLOPT_NOPROGRESS,true);
				curl_setopt ($f_curl_pointer,CURLOPT_POST,true);
				curl_setopt ($f_curl_pointer,CURLOPT_RETURNTRANSFER,true);
				curl_setopt ($f_curl_pointer,CURLOPT_TIMEOUT,$direct_settings['swg_web_socket_timeout']);

				if ((is_string ($f_data))&&(!$f_parse))
				{
					$f_query = $f_data;

					if (strpos ($f_data,"\r\n\r\n") !== false) { $f_query_header = ""; }
					elseif (isset ($this->content_type)) { $f_query_header = "Content-Type: ".$this->content_type."\r\n\r\n"; }
					else { $f_query_header = "Content-Type: application/x-www-form-urlencoded\r\n\r\n"; }
				}
				else
				{
					$f_query_header = ($this->multipart_header ("multipart/form-data"))."\r\n\r\n";
					$f_query = $this->httpQueryParse ($f_data,true);
					$f_query .= "\r\n".$this->multipart_footer ();
				}

				$f_query_header = trim (preg_replace ("#\r\n(\\x09|\\x20)#","\\1",$f_query_header));
				$f_headers_array = explode ("\r\n",$f_query_header);
				array_unshift ($f_headers_array,"Connection: close","Content-Length: ".(strlen ($f_query)));

				curl_setopt ($f_curl_pointer,CURLOPT_HTTPHEADER,$f_headers_array);
				curl_setopt ($f_curl_pointer,CURLOPT_POSTFIELDS,$f_query);

				if (defined ("CURLOPT_FILETIME")) { curl_setopt ($f_curl_pointer,CURLOPT_FILETIME,false); }
				if (defined ("CURLOPT_FOLLOWLOCATION")) { curl_setopt ($f_curl_pointer,CURLOPT_FOLLOWLOCATION,true); }
				if (defined ("CURLOPT_MAXREDIRS")) { curl_setopt ($f_curl_pointer,CURLOPT_MAXREDIRS,5); }
				if (defined ("CURLOPT_UNRESTRICTED_AUTH")) { curl_setopt ($f_curl_pointer,CURLOPT_UNRESTRICTED_AUTH,false); }
				if (defined ("CURLOPT_USERAGENT")) { curl_setopt ($f_curl_pointer,CURLOPT_USERAGENT,"$direct_settings[product_lcode_txt]/$direct_settings[product_version]"); }

				$f_response = curl_exec ($f_curl_pointer);
				$f_error = curl_error ($f_curl_pointer);
				curl_close ($f_curl_pointer);

				if (strlen ($f_error))
				{
					$this->data = "";
					$this->data_http_headers = array ();
					$this->data_http_result_code = "error::".$f_error;
				}
				else { $f_return = $this->httpResponseParse ($f_response); }
			}
			else
			{
				$this->data = "";
				$this->data_http_headers = array ();
				$this->data_http_result_code = "error::invalid request";
			}
		}
		else
		{
			$this->data = "";
			$this->data_http_headers = array ();
			$this->data_http_result_code = "error::invalid request";
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -webFunctions->httpCurlPost ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Reads a byte range of HTTP content using CURL. Servers MAY return 200
	* (whole content) instead of the selected range. If partial content is
	* provided the HTTP Response Code is 206. Make sure that the partial content
	* has the requested size and content.
	*
	* @param  string $f_server Server name or IP address of target
	* @param  integer $f_port The target port
	* @param  string $f_path The absolute address to the remote resource
	* @param  mixed $f_data Variables that should be transfered to the remote
	*         server (empty string for none)
	* @param  integer $f_byte_first First byte to be read
	* @param  mixed $f_byte_last Last byte to be read (empty for EOF)
	* @return mixed Remote content on success; false on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function httpCurlRange ($f_server,$f_port = 80,$f_path = "",$f_data = "",$f_byte_first = 0,$f_byte_last = "")
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -webFunctions->httpCurlRange ($f_server,$f_port,$f_path,+f_data,$f_byte_first,$f_byte_last)- (#echo(__LINE__)#)"); }

		$f_continue_check = true;
		$f_return = false;

		if (is_int ($f_byte_first))
		{
			if (is_int ($f_byte_last))
			{
				if (($f_byte_first >= 0)&&($f_byte_first < $f_byte_last)) { $f_range = $f_byte_first."-".$f_byte_last; }
				else { $f_continue_check = false; }
			}
			elseif (($f_byte_first >= 0)&&(empty ($f_byte_last))) { $f_range = $f_byte_first."-"; }
			else { $f_continue_check = false; }
		}
		else { $f_continue_check = false; }

		if ($f_continue_check)
		{
			if (preg_match ("#^http(s|):\/\/(.+?)$#i",$f_server,$f_result_array))
			{
				$f_query = $this->httpQueryParse ($f_data);
				if ($f_query) { $f_query = "?".$f_query; }

				$f_curl_pointer = curl_init ($f_server.":".$f_port.$f_path.$f_query);

				if (($f_curl_pointer)&&(defined ("CURLOPT_BINARYTRANSFER"))&&(defined ("CURLOPT_CONNECTTIMEOUT"))&&(defined ("CURLOPT_HEADER"))&&(defined ("CURLOPT_HTTPGET"))&&(defined ("CURLOPT_HTTPHEADER"))&&(defined ("CURLOPT_NOPROGRESS"))&&(defined ("CURLOPT_RANGE"))&&(defined ("CURLOPT_RETURNTRANSFER"))&&(defined ("CURLOPT_TIMEOUT")))
				{
					curl_setopt ($f_curl_pointer,CURLOPT_BINARYTRANSFER,true);
					curl_setopt ($f_curl_pointer,CURLOPT_CONNECTTIMEOUT,$direct_settings['swg_web_socket_timeout']);
					curl_setopt ($f_curl_pointer,CURLOPT_HEADER,true);
					curl_setopt ($f_curl_pointer,CURLOPT_HTTPGET,true);
					curl_setopt ($f_curl_pointer,CURLOPT_HTTPHEADER,(array ("Connection: close")));
					curl_setopt ($f_curl_pointer,CURLOPT_NOPROGRESS,true);
					curl_setopt ($f_curl_pointer,CURLOPT_RANGE,$f_range);
					curl_setopt ($f_curl_pointer,CURLOPT_RETURNTRANSFER,true);
					curl_setopt ($f_curl_pointer,CURLOPT_TIMEOUT,$direct_settings['swg_web_socket_timeout']);
					if (defined ("CURLOPT_FILETIME")) { curl_setopt ($f_curl_pointer,CURLOPT_FILETIME,false); }
					if (defined ("CURLOPT_FOLLOWLOCATION")) { curl_setopt ($f_curl_pointer,CURLOPT_FOLLOWLOCATION,true); }
					if (defined ("CURLOPT_MAXREDIRS")) { curl_setopt ($f_curl_pointer,CURLOPT_MAXREDIRS,5); }
					if (defined ("CURLOPT_UNRESTRICTED_AUTH")) { curl_setopt ($f_curl_pointer,CURLOPT_UNRESTRICTED_AUTH,false); }
					if (defined ("CURLOPT_USERAGENT")) { curl_setopt ($f_curl_pointer,CURLOPT_USERAGENT,"$direct_settings[product_lcode_txt]/$direct_settings[product_version]"); }

					$f_response = curl_exec ($f_curl_pointer);
					$f_error = curl_error ($f_curl_pointer);
					curl_close ($f_curl_pointer);

					if (strlen ($f_error))
					{
						$this->data = "";
						$this->data_http_headers = array ();
						$this->data_http_result_code = "error::".$f_error;
					}
					else { $f_return = $this->httpResponseParse ($f_response); }
				}
				else
				{
					$this->data = "";
					$this->data_http_headers = array ();
					$this->data_http_result_code = "error::invalid request";
				}
			}
			else
			{
				$this->data = "";
				$this->data_http_headers = array ();
				$this->data_http_result_code = "error::invalid request";
			}
		}
		else
		{
			$this->data = "";
			$this->data_http_headers = array ();
			$this->data_http_result_code = "error::invalid range";
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -webFunctions->httpCurlRange ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* This function provides a unified interface for the socket, CURL and fopen
	* GET method for getting HTTP content.
	*
	* @param  string $f_server Server name or IP address of target
	* @param  integer $f_port The target port
	* @param  string $f_path The absolute address to the remote resource
	* @param  mixed $f_data Variables that should be transfered to the remote
	*         server (empty string for none)
	* @param  boolean $f_header_only Only receive the header
	* @return mixed Remote content on success; false on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function httpGet ($f_server,$f_port = 80,$f_path = "",$f_data = "",$f_header_only = false)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -webFunctions->httpGet ($f_server,$f_port,$f_path,+f_data,+f_header_only)- (#echo(__LINE__)#)"); }

		$f_return = false;

		$this->data = "";
		$this->data_http_headers = array ();
		$this->data_http_result_code = "";

		if (USE_socket) { $f_return = $this->httpSocketGet ($f_server,$f_port,$f_path,$f_data,$f_header_only); }
		elseif ($this->functions['httpCurlGet']) { $f_return = $this->httpCurlGet ($f_server,$f_port,$f_path,$f_data,$f_header_only); }
		elseif (@get_cfg_var ("allow_url_fopen"))
		{
			if (preg_match ("#^http(s|):\/\/#i",$f_server))
			{
				$f_query = $this->httpQueryParse ($f_data);
				if ($f_query) { $f_query = "?".$f_query; }

				$f_file_pointer = fopen ($f_server.":".$f_port.$f_path.$f_query,"rb");

				if ($f_file_pointer)
				{
					@stream_set_timeout ($f_file_pointer,$direct_settings['swg_web_socket_timeout']);
					$f_response = "";

					if ($f_header_only)
					{
						if (!feof ($f_file_pointer)) { $f_return = $this->httpResponseParse ("",false); }
						else
						{
							$this->data = "";
							$this->data_http_headers = array ();
							$this->data_http_result_code = "error::timeout";
						}
					}
					else
					{
						$f_timeout_time = ($direct_cachedata['core_time'] + $direct_settings['swg_web_socket_timeout']);
						while ((!feof ($f_file_pointer))&&($f_timeout_time > (time ()))) { $f_response .= fread ($f_file_pointer,4096); }

						if (feof ($f_file_pointer)) { $f_return = $this->httpResponseParse ($f_response,false); }
						else
						{
							$this->data = "";
							$this->data_http_headers = array ();
							$this->data_http_result_code = "error::timeout";
						}
					}

					fclose ($f_file_pointer);
				}
				else
				{
					$this->data = "";
					$this->data_http_headers = array ();
					$this->data_http_result_code = "error::no response";
				}
			}
			else
			{
				$this->data = "";
				$this->data_http_headers = array ();
				$this->data_http_result_code = "error::invalid request";
			}
		}
		else { trigger_error ("sWG/#echo(__FILEPATH__)# -webFunctions->httpGet ()- (#echo(__LINE__)#) reporting: PHP provides no possibility for opening remote content",E_USER_ERROR); }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -webFunctions->httpGet ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* This function provides a unified interface for the socket and the CURL
	* POST method for getting HTTP content.
	*
	* @param  string $f_server Server name or IP address of target
	* @param  integer $f_port The target port
	* @param  string $f_path The absolute address to the remote resource
	* @param  mixed $f_data Variables that should be transfered to the remote
	*         server (empty string for none)
	* @param  boolean $f_parse Only receive the header
	* @return mixed Remote content on success; false on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function httpPost ($f_server,$f_port = 80,$f_path = "",$f_data = "",$f_parse = true)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -webFunctions->httpPost ($f_server,$f_port,$f_path,+f_data,+f_parse)- (#echo(__LINE__)#)"); }
		$f_return = false;

		$this->data = "";
		$this->data_http_headers = array ();
		$this->data_http_result_code = "";

		if (USE_socket) { $f_return = $this->httpSocketPost ($f_server,$f_port,$f_path,$f_data,$f_parse); }
		elseif ($this->functions['httpCurlGet']) { $f_return = $this->httpCurlPost ($f_server,$f_port,$f_path,$f_data,$f_parse); }
		else { trigger_error ("sWG/#echo(__FILEPATH__)# -webFunctions->httpPost ()- (#echo(__LINE__)#) reporting: PHP provides no possibility for opening remote content",E_USER_ERROR); }

		return $f_return;
	}

/**
	* Converts an array of key => value pairs into an URL-encoded string.
	*
	* @param  array $f_data Input array
	* @param  boolean $f_form_data True to use multipart/form-data as data
	*         transfer mechanism 
	* @return string URL-encoded string of $f_data
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function httpQueryParse ($f_data,$f_form_data = false)
	{
		global $direct_local;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -webFunctions->httpQueryParse (+f_data,+f_form_data)- (#echo(__LINE__)#)"); }

		$f_return = "";

		if (is_string ($f_data))
		{
			$f_data = str_replace ((array ("\r","\n")),"",$f_data);
			if (!empty ($f_data)) { parse_str ($f_data,$f_data); }
		}

		if ((is_array ($f_data))&&(!empty ($f_data)))
		{
			foreach ($f_data as $f_key => $f_value)
			{
				if ($f_form_data)
				{
					$f_continue_check = true;

					if (is_array ($f_value))
					{
						if (isset ($f_value['value']))
						{
							if ((isset ($f_value['type']))&&($f_value['type'] == "file"))
							{
								if ($f_return) { $f_return .= "\r\n"; }

								$f_multipart_array = array ("mimetype" => $f_value['mimetype'],"disposition" => "form-data","data" => $f_value['value']);
								if (isset ($f_value['encoding'])) { $f_multipart_array['encoding'] = $f_value['encoding']; }

								$f_continue_check = false;
								$f_return .= $this->multipart_body ((rawurlencode ($f_key)),$f_multipart_array);
							}
							else { $f_value = $f_value['value']; }
						}
						else { $f_value = implode ("\n",$f_value); }
/* -------------------------------------------------------------------------
The behaviour above might change for images in the future.
(multipart/alternative)
------------------------------------------------------------------------- */

					}

					if (($f_continue_check)&&(trim ($f_key))&&(trim ($f_value)))
					{
						if ($f_return) { $f_return .= "\r\n"; }

						$f_multipart_array = array ("mimetype" => "text/plain","disposition" => "form-data","encoding" => $direct_local['lang_charset'],"data" => $f_value);
						$f_return .= $this->multipart_body ((rawurlencode ($f_key)),$f_multipart_array);
					}
				}
				else
				{
					if (is_array ($f_value)) { $f_value = (((isset ($f_value['value']))&&((isset ($f_value['type']))&&($f_value['type'] != "file"))||(!isset ($f_value['type']))) ? $f_value['value'] : implode ("\n",$f_value)); }

					if ((trim ($f_key))&&(trim ($f_value)))
					{
						if ($f_return != "") { $f_return .= "&"; }
						$f_return .= ((rawurlencode ($f_key))."=".(rawurlencode ($f_value)));
					}
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -webFunctions->httpQueryParse ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* This function provides a unified interface for the socket and the CURL
	* GET method to request a data range via HTTP.
	*
	* @param  string $f_server Server name or IP address of target
	* @param  integer $f_port The target port
	* @param  string $f_path The absolute address to the remote resource
	* @param  mixed $f_data Variables that should be transfered to the remote
	*         server (empty string for none)
	* @param  integer $f_byte_first First byte to be read
	* @param  mixed $f_byte_last Last byte to be read (empty for EOF)
	* @return mixed Remote content on success; false on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function httpRange ($f_server,$f_port = 80,$f_path = "",$f_data = "",$f_byte_first = 0,$f_byte_last = "")
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -webFunctions->httpRange ($f_server,$f_port,$f_path,+f_data,$f_byte_first,$f_byte_last)- (#echo(__LINE__)#)"); }
		$f_return = false;

		$this->data = "";
		$this->data_http_headers = array ();
		$this->data_http_result_code = "";

		if (USE_socket) { $f_return = $this->httpSocketRange ($f_server,$f_port,$f_path,$f_data,$f_byte_first,$f_byte_last); }
		elseif ($this->functions['httpCurlRange']) { $f_return = $this->httpCurlRange ($f_server,$f_port,$f_path,$f_data,$f_byte_first,$f_byte_last); }
		else { trigger_error ("sWG/#echo(__FILEPATH__)# -webFunctions->httpRange ()- (#echo(__LINE__)#) reporting: PHP provides no possibility for opening remote content",E_USER_ERROR); }

		return $f_return;
	}

/**
	* Parses responses to filter headers.
	*
	* @param  string $f_data Remote response
	* @param  boolean $f_headers_supported False if headers are not given in
	*         $f_data.
	* @return string Content given by remote resource
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function httpResponseParse ($f_data,$f_headers_supported = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -webFunctions->httpResponseParse (+f_data,+f_headers_supported)- (#echo(__LINE__)#)"); }

		if ($f_headers_supported)
		{
			$f_continue_check = true;
			$f_validation_check = true;
			$f_response_array = explode ("\r\n\r\n",$f_data,2);

			$f_response_array[0] = $this->header_parse ($f_response_array[0]);
			if (is_array ($f_response_array[0])) { $this->data_http_headers = array_merge ($this->data_http_headers,$f_response_array[0]); }

			if ((isset ($this->data_http_headers['transfer-encoding']))&&(/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($this->data_http_headers['transfer-encoding'],"chunked") === 0))
			{
				$this->data = "";
				$f_data = $f_response_array[1];

				while (($f_validation_check)&&($f_continue_check)&&(strlen ($f_data) > 0))
				{
					if (preg_match ("#^(\w+)(|(;| ;)(.+?))\r\n#i",$f_data,$f_result_array))
					{
						$f_data = substr ($f_data,(strlen ($f_result_array[0])));
						$f_size_octet = hexdec ($f_result_array[1]);

						if (($f_size_octet == 0)&&(isset ($this->data_http_headers['trailer'])))
						{
							$f_headers_array = $this->header_parse ($f_data);
							$f_continue_check = false;

							if (is_array ($f_headers_array)) { $this->data_http_headers = array_merge ($this->data_http_headers,$f_headers_array); }
						}
						elseif (strlen ($f_data) > $f_size_octet)
						{
							$this->data .= substr ($f_data,0,$f_size_octet);
							$f_data = substr ($f_data,($f_size_octet + 2));
						}
						else { $f_validation_check = false; }
					}
					elseif (!preg_match ("#^0(|(;| ;)(.+?))\r\n#i",$f_data))
					{
						$this->data .= $f_data;
						$f_continue_check = false;
					}
					else { $f_validation_check = false; }
				}
			}
			else { $this->data = $f_response_array[1]; }

			if ($f_validation_check) { $this->data_http_result_code = ((preg_match ("#^HTTP/(\d).(\d) (\d{1,3})(.*?)$#im",$this->data_http_headers['@untagged'],$f_result_array)) ? $f_result_array[3] : "error::malformed response"); }
			else
			{
				$this->data = "";
				$this->data_http_result_code = "error::malformed response";
			}
		}
		else
		{
			$this->data = $f_data;
			$this->data_http_headers = array ("x-error" => "unsupported");
			$this->data_http_result_code = 200;
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -webFunctions->httpResponseParse ()- (#echo(__LINE__)#)",:#*/$this->data/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Reads headers and HTTP content using fsockopen.
	*
	* @param  string $f_server Server name or IP address of target
	* @param  integer $f_port The target port
	* @param  string $f_path The absolute address to the remote resource
	* @param  mixed $f_data Variables that should be transfered to the remote
	*         server (empty string for none)
	* @param  boolean $f_header_only Only receive the header
	* @return mixed Remote content on success; false on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function httpSocketGet ($f_server,$f_port = 80,$f_path = "",$f_data = "",$f_header_only = false)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -webFunctions->httpSocketGet ($f_server,$f_port,$f_path,+f_data,+f_header_only)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (preg_match ("#^http(s|):\/\/(.+?)$#i",$f_server,$f_result_array))
		{
			$f_socket_pointer = fsockopen ($f_result_array[2],$f_port,$f_error_code,$f_error,$direct_settings['swg_web_socket_timeout']);

			if (($f_error_code)||($f_error))
			{
				$this->data = "";
				$this->data_http_headers = array ();
				$this->data_http_result_code = "error:$f_error_code:".$f_error;
			}
			elseif ($f_socket_pointer)
			{
				@stream_set_blocking ($f_socket_pointer,0);
				@stream_set_timeout ($f_socket_pointer,$direct_settings['swg_web_socket_timeout']);

				$f_query = $this->httpQueryParse ($f_data);
				if ($f_query) { $f_query = "?".$f_query; }

				$f_headers = "Host: {$f_result_array[2]}\r\nUser-Agent: $direct_settings[product_lcode_txt]/$direct_settings[product_version]\r\nAccept: */*\r\nAccept-Encoding: \r\nConnection: close";

				if ($f_header_only) { fwrite ($f_socket_pointer,"HEAD $f_path$f_query HTTP/1.1\r\n$f_headers\r\n\r\n"); }
				else { fwrite ($f_socket_pointer,"GET $f_path$f_query HTTP/1.1\r\n$f_headers\r\n\r\n"); }

				if (!@feof ($f_socket_pointer))
				{
					$f_response = "";
					if (function_exists ("socket_select")) { $f_socket_check = array ($f_socket_pointer); }
					$f_socket_ignored = NULL;
					$f_timeout_time = ($direct_cachedata['core_time'] + $direct_settings['swg_web_socket_timeout']);

					if ($f_header_only)
					{
						while ((!feof ($f_socket_pointer))&&(strstr ($f_response,"\r\n\r\n") < 1)&&($f_timeout_time > (time ())))
						{
							if (isset ($f_socket_check)) { socket_select ($f_socket_check,$f_socket_ignored,$f_socket_ignored,$direct_settings['swg_web_socket_timeout']); }
							$f_response .= fread ($f_socket_pointer,1024);
						}

						if ($f_timeout_time > (time ()))
						{
							$f_response = preg_replace ("#\r\n\r\n(.*?)$#","",$f_response);
							$f_return = $this->httpResponseParse ($f_response);
						}
						else
						{
							$this->data = "";
							$this->data_http_headers = array ();
							$this->data_http_result_code = "error::timeout";
						}
					}
					else
					{
						while ((!feof ($f_socket_pointer))&&($f_timeout_time > (time ())))
						{
							if (isset ($f_socket_check)) { socket_select ($f_socket_check,$f_socket_ignored,$f_socket_ignored,$direct_settings['swg_web_socket_timeout']); }
							$f_response .= fread ($f_socket_pointer,4096);
						}

						if (feof ($f_socket_pointer)) { $f_return = $this->httpResponseParse ($f_response); }
						else
						{
							$this->data = "";
							$this->data_http_headers = array ();
							$this->data_http_result_code = "error::timeout";
						}
					}

					fclose ($f_socket_pointer);
				}
				else
				{
					$this->data = "";
					$this->data_http_headers = array ();
					$this->data_http_result_code = "error::no response";
				}
			}
		}
		else
		{
			$this->data = "";
			$this->data_http_headers = array ();
			$this->data_http_result_code = "error::invalid request";
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -webFunctions->httpSocketGet ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Sending a POST request and reading headers and HTTP content using
	* fsockopen.
	*
	* @param  string $f_server Server name or IP address of target
	* @param  integer $f_port The target port
	* @param  string $f_path The absolute address to the remote resource
	* @param  mixed $f_data Variables that should be transfered to the remote
	*         server (empty string for none)
	* @param  boolean $f_parse True to parse $f_data for encoding
	* @return mixed Remote content on success; false on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function httpSocketPost ($f_server,$f_port = 80,$f_path = "",$f_data = "",$f_parse = true)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -webFunctions->httpSocketPost ($f_server,$f_port,$f_path,+f_data,+f_parse)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (preg_match ("#^http(s|):\/\/(.+?)$#i",$f_server,$f_result_array))
		{
			$f_socket_pointer = fsockopen ($f_result_array[2],$f_port,$f_error_code,$f_error,$direct_settings['swg_web_socket_timeout']);

			if (($f_error_code)||($f_error))
			{
				$this->data = "";
				$this->data_http_headers = array ();
				$this->data_http_result_code = "error:$f_error_code:".$f_error;
			}
			elseif ($f_socket_pointer)
			{
				@stream_set_blocking ($f_socket_pointer,0);
				@stream_set_timeout ($f_socket_pointer,$direct_settings['swg_web_socket_timeout']);

				if ((is_string ($f_data))&&(!$f_parse))
				{
					$f_query = $f_data;

					if (strpos ($f_data,"\r\n\r\n") !== false) { $f_query_header = ""; }
					elseif (isset ($this->content_type)) { $f_query_header = "Content-Type: ".$this->content_type."\r\n\r\n"; }
					else { $f_query_header = "Content-Type: application/x-www-form-urlencoded\r\n\r\n"; }
				}
				else
				{
					$f_query_header = ($this->multipart_header ("multipart/form-data"))."\r\n\r\n";
					$f_query = $this->httpQueryParse ($f_data,true);
					$f_query .= "\r\n".$this->multipart_footer ();
				}

				fwrite ($f_socket_pointer,"POST $f_path HTTP/1.1\r\nHost: {$f_result_array[2]}\r\nUser-Agent: $direct_settings[product_lcode_txt]/$direct_settings[product_version]\r\nContent-Length: ".(strlen ($f_query))."\r\nConnection: close\r\n".$f_query_header.$f_query);

				if (!@feof ($f_socket_pointer))
				{
					$f_response = "";
					if (function_exists ("socket_select")) { $f_socket_check = array ($f_socket_pointer); }
					$f_socket_ignored = NULL;
					$f_timeout_time = ($direct_cachedata['core_time'] + $direct_settings['swg_web_socket_timeout']);

					while ((!feof ($f_socket_pointer))&&($f_timeout_time > (time ())))
					{
						if (isset ($f_socket_check)) { socket_select ($f_socket_check,$f_socket_ignored,$f_socket_ignored,$direct_settings['swg_web_socket_timeout']); }
						$f_response .= fread ($f_socket_pointer,4096);
					}

					if (feof ($f_socket_pointer)) { $f_return = $this->httpResponseParse ($f_response); }
					else
					{
						$this->data = "";
						$this->data_http_headers = array ();
						$this->data_http_result_code = "error::timeout";
					}

					fclose ($f_socket_pointer);
				}
				else
				{
					$this->data = "";
					$this->data_http_headers = array ();
					$this->data_http_result_code = "error::no response";
				}
			}
		}
		else
		{
			$this->data = "";
			$this->data_http_headers = array ();
			$this->data_http_result_code = "error::invalid request";
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -webFunctions->httpSocketPost ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Reads a byte range of HTTP content using fsockopen. Servers MAY return 200
	* (whole content) instead of the selected range. If partial content is
	* provided the HTTP Response Code is 206. Make sure that the partial content
	* has the requested size and content.
	*
	* @param  string $f_server Server name or IP address of target
	* @param  integer $f_port The target port
	* @param  string $f_path The absolute address to the remote resource
	* @param  mixed $f_data Variables that should be transfered to the remote
	*         server (empty string for none)
	* @param  integer $f_byte_first First byte to be read
	* @param  mixed $f_byte_last Last byte to be read (empty for EOF)
	* @return mixed Remote content on success; false on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function httpSocketRange ($f_server,$f_port = 80,$f_path = "",$f_data = "",$f_byte_first = 0,$f_byte_last = "")
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -webFunctions->httpSocketRange ($f_server,$f_port,$f_path,+f_data,$f_byte_first,$f_byte_last)- (#echo(__LINE__)#)"); }

		$f_continue_check = true;
		$f_return = false;

		if (is_int ($f_byte_first))
		{
			if (is_int ($f_byte_last))
			{
				if (($f_byte_first >= 0)&&($f_byte_first < $f_byte_last)) { $f_range = $f_byte_first."-".$f_byte_last; }
				else { $f_continue_check = false; }
			}
			elseif (($f_byte_first >= 0)&&(empty ($f_byte_last))) { $f_range = $f_byte_first."-"; }
			else { $f_continue_check = false; }
		}
		else { $f_continue_check = false; }

		if ($f_continue_check)
		{
			if (preg_match ("#^http(s|):\/\/(.+?)$#i",$f_server,$f_result_array))
			{
				$f_socket_pointer = fsockopen ($f_result_array[2],$f_port,$f_error_code,$f_error,$direct_settings['swg_web_socket_timeout']);

				if (($f_error_code)||($f_error))
				{
					$this->data = "";
					$this->data_http_headers = array ();
					$this->data_http_result_code = "error:$f_error_code:".$f_error;
				}
				elseif ($f_socket_pointer)
				{
					@stream_set_blocking ($f_socket_pointer,0);
					@stream_set_timeout ($f_socket_pointer,$direct_settings['swg_web_socket_timeout']);

					$f_query = $this->httpQueryParse ($f_data);
					if ($f_query) { $f_query = "?".$f_query; }

					fwrite ($f_socket_pointer,"GET $f_path$f_query HTTP/1.1\r\nHost: {$f_result_array[2]}\r\nUser-Agent: $direct_settings[product_lcode_txt]/$direct_settings[product_version]\r\nAccept: */*\r\nAccept-Encoding: \r\nRange: bytes=$f_range\r\nConnection: close\r\n\r\n");

					if (!@feof ($f_socket_pointer))
					{
						$f_response = "";
						if (function_exists ("socket_select")) { $f_socket_check = array ($f_socket_pointer); }
						$f_socket_ignored = NULL;
						$f_timeout_time = ($direct_cachedata['core_time'] + $direct_settings['swg_web_socket_timeout']);

						while ((!feof ($f_socket_pointer))&&($f_timeout_time > (time ())))
						{
							if (isset ($f_socket_check)) { socket_select ($f_socket_check,$f_socket_ignored,$f_socket_ignored,$direct_settings['swg_web_socket_timeout']); }
							$f_response .= fread ($f_socket_pointer,4096);
						}

						if (feof ($f_socket_pointer)) { $f_return = $this->httpResponseParse ($f_response); }
						else
						{
							$this->data = "";
							$this->data_http_headers = array ();
							$this->data_http_result_code = "error::timeout";
						}

						fclose ($f_socket_pointer);
					}
					else
					{
						$this->data = "";
						$this->data_http_headers = array ();
						$this->data_http_result_code = "error::no response";
					}
				}
			}
			else
			{
				$this->data = "";
				$this->data_http_headers = array ();
				$this->data_http_result_code = "error::invalid request";
			}
		}
		else
		{
			$this->data = "";
			$this->data_http_headers = array ();
			$this->data_http_result_code = "error::invalid range";
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -webFunctions->httpSocketRange ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directWebFunctions",true);

//j// Script specific commands

global $direct_globals,$direct_settings;
$direct_globals['@names']['web_functions'] = 'dNG\sWG\directWebFunctions';

if (!isset ($direct_settings['swg_web_socket_timeout'])) { $direct_settings['swg_web_socket_timeout'] = $direct_settings['timeout_core']; }
}

//j// EOF
?>