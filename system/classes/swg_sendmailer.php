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
* It's always a good idea to use a custom API for sending e-Mails. This allows
* us to change the backend (PHP's mail () / SMTP via socket / ...) without
* rewriting our programs.
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
* @subpackage extra_functions
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

$g_continue_check = true;
if (defined ("CLASS_direct_sendmailer")) { $g_continue_check = false; }
if (!defined ("CLASS_direct_basic_rfc_functions")) { $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_basic_rfc_functions.php"); }
if (!defined ("CLASS_direct_basic_rfc_functions")) { $g_continue_check = false; }

if ($g_continue_check)
{
//c// direct_sendmailer
/**
* This class allows you to send e-mails containing a unlimited number of
* attachements as long as the total size does not exceed the user set limit.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage extra_functions
* @uses       CLASS_direct_basic_rfc_functions
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_sendmailer extends direct_basic_rfc_functions
{
/**
	* @var array $data Array for message related data
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $data;
/**
	* @var array $recipients Array with recipients
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $recipients;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_sendmailer->__construct () and direct_sendmailer->direct_sendmailer ()
/**
	* Constructor (PHP5) __construct (direct_sendmailer)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer_class->__construct (direct_sendmailer)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['attachment_get'] = true;
		$this->functions['attachment_set'] = true;
		$this->functions['html_get'] = true;
		$this->functions['html_set'] = true;
		$this->functions['recipients_define'] = true;
		$this->functions['send'] = true;
		$this->functions['text_get'] = true;
		$this->functions['text_set'] = true;
		$this->functions['xhtml_get'] = true;
		$this->functions['xhtml_set'] = true;

/* -------------------------------------------------------------------------
Set up some variables
------------------------------------------------------------------------- */

		$this->data = array ();
		$this->linesep = "\n";
		$this->recipients = array ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_sendmailer (direct_sendmailer)
	*
	* @since v0.1.00
*\/
	function direct_sendmailer () { $this->__construct (); }
:#*/
	//f// direct_sendmailer->attachment_get ($f_name)
/**
	* Returns a defined attachement.
	*
	* @param  string $f_name Attachement name (usually the filename)
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return array Attachement data array
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function attachment_get ($f_name)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer_class->attachment_get ($f_name)- (#echo(__LINE__)#)"); }

		if (isset ($this->data[$f_name])) { return $this->data[$f_name]; }
		else { return false; }
	}

	//f// direct_sendmailer->attachment_set ($f_name,$f_mimetype,$f_data,$f_encoding = "")
/**
	* This method adds a new attachement with the defined parameters to the mail.
	*
	* @param  string $f_name Attachement name (usually the filename)
	* @param  string $f_mimetype Mimetype of the attachement
	* @param  string $f_data Attachement data
	* @param  string $f_encoding Charset encoding if applicable
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function attachment_set ($f_name,$f_mimetype,$f_data,$f_encoding = "")
	{
		global $direct_local;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer_class->attachment_set ($f_name,$f_mimetype,+f_data,$f_encoding)- (#echo(__LINE__)#)"); }

		if (!strlen ($f_encoding)) { $f_encoding = $direct_local['lang_charset']; }
		$this->data[$f_name] = array ("mimetype" => $f_mimetype,"encoding" => $f_encoding,"data" => $f_data);
	}

	//f// direct_sendmailer->html_get ()
/**
	* A wrapper for "xhtml_get ()". Returns the (X)HTML email body.
	*
	* @uses   direct_sendmailer::xhtml_get()
	* @return string (X)HTML email body
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function html_get () { return xhtml_get (); }

	//f// direct_sendmailer->html_set ($f_encoding,$f_data)
/**
	* Sets a new (X)HTML email body (replacing the old one).
	*
	* @param  string $f_encoding HTML content encoding
	* @param  string $f_data HTML document
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function html_set ($f_encoding,$f_data)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer_class->html_set ($f_encoding,+f_data)- (#echo(__LINE__)#)"); }
		$this->data['@mhtml'] = array ("mimetype" => "text/html","encoding" => $f_encoding,"data" => $f_data);
	}

	//f// direct_sendmailer->recipient_parse ($f_recipient)
/**
	* Parses a string for a valid RFC822 address.
	*
	* @param  string $f_recipient Recipient definition
	* @uses   direct_basic_functions::inputfilter_email()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return array Array containing address -> name values; empty one on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function recipient_parse ($f_recipient)
	{
		global $direct_classes;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer_class->recipient_parse (+f_recipient)- (#echo(__LINE__)#)"); }

		$f_return = array ();

		if (is_string ($f_recipient))
		{
			if (preg_match ("#^(.+?) <(.+?)>$#i",$f_recipient,$f_result_array))
			{
				$f_continue_check = true;
				$f_recipient_name = trim ($f_result_array[1]);
				$f_recipient_address = $direct_classes['basic_functions']->inputfilter_email ($f_result_array[2]);

				if ((strlen ($f_recipient_name))&&(strlen ($f_recipient_address)))
				{
					if ($f_recipient_name[0] == "\"")
					{
						if ((strlen ($f_recipient_name) > 1)&&($f_recipient_name[(strlen ($f_recipient_name) - 1)] == "\"")&&($f_recipient_name[(strlen ($f_recipient_name) - 2)] != "\\"))
						{
							$f_result_array = explode ("\"",$f_recipient_name);

							if (count ($f_result_array) > 3)
							{
								unset ($f_result_array[0]);
								unset ($f_result_array[(count ($f_result_array) - 1)]);

								foreach ($f_result_array as $f_part)
								{
									if ($f_continue_check)
									{
										if ($f_part[(strlen ($f_part) - 1)] == "\\")
										{
											if (!preg_match ("#^[\\x00-\\x0c\\x0e-\\x7f]+$#",$f_part)) { $f_continue_check = false; }
										}
										else { $f_continue_check = false; }
									}
								}
							}
						}
						else { $f_continue_check = false; }

						$f_recipient_name = substr ($f_recipient_name,1,-1);
					}
					elseif (preg_match ("#[\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]#",$f_recipient_name)) { $f_continue_check = false; }

					if ($f_continue_check)
					{
						$f_return[] = $f_recipient_name;
						$f_return[] = $f_recipient_address;
					}
				}
			}
			else
			{
				$f_recipient_address = $direct_classes['basic_functions']->inputfilter_email ($f_recipient);

				if (strlen ($f_recipient_address))
				{
					$f_return[] = "";
					$f_return[] = $f_recipient_address;
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -sendmailer_class->recipient_parse ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_sendmailer->recipients_define ($f_recipients)
/**
	* Adds recipients to the list.
	*
	* @param  mixed $f_recipients Recipient(s) as string (one) or array (multiple)
	* @uses   direct_debug()
	* @uses   direct_sendmailer::recipient_parse()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function recipients_define ($f_recipients)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer_class->recipients_define (+f_recipients)- (#echo(__LINE__)#)"); }

		$f_return = true;

		if (is_string ($f_recipients))
		{
			$f_recipient_array = $this->recipient_parse ($f_recipients);

			if (empty ($f_recipient_array)) { $f_return = false; }
			else { $this->recipients[$f_recipient_array[1]] = ""; }
		}
		else
		{
			foreach ($f_recipients as $f_recipient_address => $f_recipient_name)
			{
				if ($f_return)
				{
					if (!strlen ($f_recipient_name)) { $f_recipients_array = $this->recipient_parse ($f_recipient_address); }
					elseif (is_int ($f_recipient_address)) { $f_recipients_array = $this->recipient_parse ($f_recipient_name); }
					else
					{
						$f_recipient = ("\"".(str_replace ("\"","\\\"",$f_recipient_name))."\" <$f_recipient_address>");
						$f_recipients_array = $this->recipient_parse ($f_recipient);
					}

					if (empty ($f_recipients_array)) { $f_return = false; }
					else { $this->recipients[$f_recipients_array[1]] = $f_recipients_array[0]; }
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -sendmailer_class->recipients_define ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_sendmailer->send ($f_type,$f_from,$f_subject)
/**
	* This method will send the email. It will return false if this fails.
	*
	* @param  string $f_type Send eMail in default or BCC mode ("single" or "bcc")
	* @param  string $f_from Sender information
	* @param  string $f_subject Title of the eMail
	* @uses   direct_debug()
	* @uses   direct_basic_rfc_functions::header_align()
	* @uses   direct_basic_rfc_functions::multipart_body_alternative_footer()
	* @uses   direct_basic_rfc_functions::multipart_body_alternative_header()
	* @uses   direct_basic_rfc_functions::multipart_body()
	* @uses   direct_basic_rfc_functions::multipart_footer()
	* @uses   direct_basic_rfc_functions::multipart_header()
	* @uses   direct_basic_rfc_functions::quoted_printable_encode()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function send ($f_type,$f_from,$f_subject)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer_class->send ($f_type,$f_from,$f_subject)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if ((($direct_cachedata['core_time'] + $direct_settings['timeout'] + $direct_settings['timeout_core']) > (time ()))&&((isset ($this->data['@text']))||(isset ($this->data['@mhtml'])))&&(count ($this->recipients)))
		{
			$f_email_headers = "";
			$f_recipients = "";

			foreach ($this->recipients as $f_recipient_address => $f_recipient_name)
			{
				if (($direct_settings['swg_sendmailer_use_names'])&&(strlen ($f_recipient_name)))
				{
					if ($f_recipients) { $f_recipients .= ", "; }
					$f_recipient_name = preg_replace ("#\r|\n#","",(str_replace ('"','\"',$f_recipient_name)));
					$f_recipients .= "\"$f_recipient_name\" <$f_recipient_address>";
				}
				else
				{
					if ($f_recipients) { $f_recipients .= ", "; }
					$f_recipients .= $f_recipient_address;
				}
			}

			$f_from = preg_replace ("#\r|\n#","",$f_from);
			$f_sender_address = preg_replace ("#\"(.*?)\" <(.*?)>#i","\\2",$f_from);
			if (!$direct_settings['swg_sendmailer_use_names']) { $f_from = $f_sender_address; }

			$f_email_headers .= (($this->header_align ("Return-Path: ".$f_from))."\r\n");
			$f_email_headers .= (($this->header_align ("From: ".$f_from))."\r\n");

			if ($f_type == "bcc")
			{
				$f_email_headers .= (($this->header_align ("Bcc: ".$f_recipients))."\r\n");

				if ($direct_settings['swg_sendmailer_use_names']) { $f_recipients = $direct_settings['swg_sendmailer_bcc_recipient']; }
				else { $f_recipients = preg_replace ("#\"(.*?)\" <(.*?)>#i","\\2",$direct_settings['swg_sendmailer_bcc_recipient']); }
			}

			$f_email_headers .= (($this->header_align ("Reply-To: ".$f_from))."\r\n");
			$f_email_headers .= "User-Agent: direct SendMailer/1.1.0 (PHP-mail) [direct Netware Group]\r\n";
			$f_email_headers .= (($this->header_align ("X-Sender: ".$f_from))."\r\n");
			$f_email_headers .= "X-Mailer: direct SendMailer/1.1.0 (PHP-mail) [direct Netware Group]\r\n";
			$f_email_headers .= "MIME-Version: 1.0\r\n";

			if ((count ($this->data)) == 1)
			{
				if (isset ($this->data['@text'])) { $f_email_content = "@text"; }
				else { $f_email_content = "@mhtml"; }

				$f_email_headers .= (($this->header_align ("Content-Type: ".$this->data[$f_email_content]['mimetype']."; charset=".$this->data[$f_email_content]['encoding']))."\n");
				$f_email_headers .= $this->header_align ("Content-Transfer-Encoding: quoted-printable");
				if ($direct_settings['swg_sendmailer_unixheader']) { $f_email_headers = str_replace ("\r\n","\n",$f_email_headers); }
				$f_email_content = $this->quoted_printable_encode ($this->data[$f_email_content]['data']);

				if ((PHP_VERSION > "4.0.4")&&($direct_settings['swg_sendmailer_senderrewrite'])) { $f_return = mail ($f_recipients,$f_subject,$f_email_content,$f_email_headers,"-f".$f_sender_address); }
				else { $f_return = mail ($f_recipients,$f_subject,$f_email_content,$f_email_headers); }
			}
			else
			{
				$f_email_headers .= $this->multipart_header ("multipart/mixed");
				if ($direct_settings['swg_sendmailer_unixheader']) { $f_email_headers = str_replace ("\r\n","\n",$f_email_headers); }
				$f_email_content = "";

				if (isset ($this->data['@text']))
				{
					if (isset ($this->data['@mhtml'])) { $f_email_content .= (($this->multipart_body_alternative_header (1))."\n\n".($this->multipart_body ("@text",$this->data['@text'],1))); }
					else { $f_email_content .= $this->multipart_body ("@text",$this->data['@text']); }
				}

				if (isset ($this->data['@mhtml']))
				{
					if ($f_email_content) { $f_email_content .= "\n"; }

					if (isset ($this->data['@text'])) { $f_email_content .= (($this->multipart_body ("@mhtml",$this->data['@mhtml'],1))."\n".($this->multipart_body_alternative_footer (1))); }
					else { $f_email_content .= $this->multipart_body ("@mhtml",$this->data['@mhtml']); }
				}

				foreach ($this->data as $f_email_content_type => $f_email_content_array)
				{
					if (strpos ($f_email_content_type,"@") === false)
					{
						if ($f_email_content) { $f_email_content .= "\n"; }
						$f_email_content .= $this->multipart_body ($f_email_content_type,$f_email_content_array);
					}
				}

				if ($f_email_content) { $f_email_content .= "\n"; }
				$f_email_content .= $this->multipart_footer ();

				if ((PHP_VERSION > "4.0.4")&&($direct_settings['swg_sendmailer_senderrewrite'])) { $f_return = mail ($f_recipients,($this->quoted_printable_encode ($f_subject,true)),$f_email_content,$f_email_headers,"-f".$f_sender_address); }
				else { $f_return = mail ($f_recipients,($this->quoted_printable_encode ($f_subject,true)),$f_email_content,$f_email_headers); }
			}
		}
		else { trigger_error ("sWG/#echo(__FILEPATH__)# -sendmailer_class->send ()- (#echo(__LINE__)#) reporting: Error while preparing e-mail delivery",E_USER_WARNING); }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -sendmailer_class->send ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_sendmailer->text_get ()
/**
	* Returns the text email body.
	*
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Text email body
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function text_get ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer_class->text_get ()- (#echo(__LINE__)#)"); }

		if (isset ($this->data['@text'])) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -sendmailer_class->text_get ()- (#echo(__LINE__)#)",:#*/$this->data['@text']/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -sendmailer_class->text_get ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_sendmailer->text_set ($f_encoding,$f_data)
/**
	* Sets a new text email body (replacing the old one).
	*
	* @param  string $f_encoding Text encoding
	* @param  string $f_data eMail text
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function text_set ($f_encoding,$f_data)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer_class->text_set ($f_encoding,+f_data)- (#echo(__LINE__)#)"); }
		$this->data['@text'] = array ("mimetype" => "text/plain","encoding" => $f_encoding,"data" => $f_data);
	}

	//f// direct_sendmailer->xhtml_get ()
/**
	* Returns the (X)HTML email body.
	*
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string (X)HTML email body
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function xhtml_get ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer_class->xhtml_get ()- (#echo(__LINE__)#)"); }

		if (isset ($this->data['@mhtml'])) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -sendmailer_class->xhtml_get ()- (#echo(__LINE__)#)",:#*/$this->data['@mhtml']/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -sendmailer_class->xhtml_get ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_sendmailer->xhtml_set ($f_encoding,$f_data)
/**
	* Sets a new (X)HTML email body (replacing the old one).
	*
	* @param  string $f_encoding HTML content encoding
	* @param  string $f_data HTML document
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function xhtml_set ($f_encoding,$f_data)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer_class->xhtml_set ($f_encoding,+f_data)- (#echo(__LINE__)#)"); }

		if ($direct_settings['swg_sendmailer_use_xhtml_mime']) { $this->data['@mhtml'] = array ("mimetype" => "application/xhtml+xml","encoding" => $f_encoding,"data" => $f_data); }
		else
		{
			$f_data = preg_replace ("#<meta(.+?)application/xhtml\+xml(.+?)>#si","<meta\\1text/html\\2>",$f_data);
			$f_data = preg_replace ("#<(script|style)(.*?)><\!\[CDATA\[(.*?)\]\]><\/(script|style)>#si","<\\1\\2><!--\\3// --></\\4>",$f_data);
			$this->data['@mhtml'] = array ("mimetype" => "text/html","encoding" => $f_encoding,"data" => $f_data);
		}
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_direct_sendmailer",true);

//j// Script specific commands

if (!isset ($direct_settings['swg_sendmailer_bcc_recipient'])) { $direct_settings['swg_sendmailer_bcc_recipient'] = $direct_settings['administration_email_out']; }
if (!isset ($direct_settings['swg_sendmailer_senderrewrite'])) { $direct_settings['swg_sendmailer_senderrewrite'] = true; }
if (!isset ($direct_settings['swg_sendmailer_unixheader'])) { $direct_settings['swg_sendmailer_unixheader'] = true; }
if (!isset ($direct_settings['swg_sendmailer_use_names'])) { $direct_settings['swg_sendmailer_use_names'] = true; }
if (!isset ($direct_settings['swg_sendmailer_use_xhtml_mime'])) { $direct_settings['swg_sendmailer_use_xhtml_mime'] = false; }
}

//j// EOF
?>