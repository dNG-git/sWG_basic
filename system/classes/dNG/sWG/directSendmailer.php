<?php
//j// BOF

/*n// NOTE
----------------------------------------------------------------------------
secured WebGine
net-based application engine
----------------------------------------------------------------------------
(C) direct Netware Group - All rights reserved
http://www.direct-netware.de/redirect.php?swg

This Source Code Form is subject to the terms of the Mozilla Public License,
v. 2.0. If a copy of the MPL was not distributed with this file, You can
obtain one at http://mozilla.org/MPL/2.0/.
----------------------------------------------------------------------------
http://www.direct-netware.de/redirect.php?licenses;mpl2
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
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
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

if (!defined ("CLASS_directSendmailer"))
{
/**
* This class allows you to send e-mails containing a unlimited number of
* attachements as long as the total size does not exceed the user set limit.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage extra_functions
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directSendmailer extends directBasicRfcFunctions
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

/**
	* Constructor (PHP5) __construct (directSendmailer)
	*
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer->__construct (directSendmailer)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['attachmentGet'] = true;
		$this->functions['attachmentSet'] = true;
		$this->functions['htmlGet'] = true;
		$this->functions['htmlSet'] = true;
		$this->functions['recipientsDefine'] = true;
		$this->functions['send'] = true;
		$this->functions['textGet'] = true;
		$this->functions['textSet'] = true;
		$this->functions['xhtmlGet'] = true;
		$this->functions['xhtmlSet'] = true;

/* -------------------------------------------------------------------------
Set up some variables
------------------------------------------------------------------------- */

		$this->data = array ();
		if ($direct_settings['swg_sendmailer_native_mode']) { $this->linesep = PHP_EOL; }
		$this->recipients = array ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directSendmailer
	*
	* @since v0.1.00
*\/
	function directSendmailer () { $this->__construct (); }
:#*/
/**
	* Returns a defined attachement.
	*
	* @param  string $f_name Attachement name (usually the filename)
	* @return array Attachement data array
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function attachmentGet ($f_name)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer->attachmentGet ($f_name)- (#echo(__LINE__)#)"); }

		if (isset ($this->data[$f_name])) { return $this->data[$f_name]; }
		else { return false; }
	}

/**
	* This method adds a new attachement with the defined parameters to the mail.
	*
	* @param  string $f_name Attachement name (usually the filename)
	* @param  string $f_mimetype Mimetype of the attachement
	* @param  string $f_data Attachement data
	* @param  string $f_encoding Charset encoding if applicable
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function attachmentSet ($f_name,$f_mimetype,$f_data,$f_encoding = "")
	{
		global $direct_local;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer->attachmentSet ($f_name,$f_mimetype,+f_data,$f_encoding)- (#echo(__LINE__)#)"); }

		if (!strlen ($f_encoding)) { $f_encoding = $direct_local['lang_charset']; }
		$this->data[$f_name] = array ("mimetype" => $f_mimetype,"encoding" => $f_encoding,"data" => $f_data);
	}

/**
	* A wrapper for "xhtmlGet ()". Returns the (X)HTML email body.
	*
	* @return string (X)HTML email body
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function htmlGet () { return xhtmlGet (); }

/**
	* Sets a new (X)HTML email body (replacing the old one).
	*
	* @param  string $f_encoding HTML content encoding
	* @param  string $f_data HTML document
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function htmlSet ($f_encoding,$f_data) { $this->data['@mhtml'] = array ("mimetype" => "text/html","encoding" => $f_encoding,"data" => $f_data); }

/**
	* Parses a string for a valid RFC822 address.
	*
	* @param  string $f_recipient Recipient definition
	* @return array Array containing address -> name values; empty one on error
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function recipientParse ($f_recipient)
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer->recipientParse (+f_recipient)- (#echo(__LINE__)#)"); }

		$f_return = array ();

		if (is_string ($f_recipient))
		{
			if (preg_match ("#^(.+?) <(.+?)>$#i",$f_recipient,$f_result_array))
			{
				$f_continue_check = true;
				$f_recipient_name = trim ($f_result_array[1]);
				$f_recipient_address = $direct_globals['basic_functions']->inputfilterEMail ($f_result_array[2]);

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
				$f_recipient_address = $direct_globals['basic_functions']->inputfilterEMail ($f_recipient);

				if (strlen ($f_recipient_address))
				{
					$f_return[] = "";
					$f_return[] = $f_recipient_address;
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -sendmailer->recipientParse ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Adds recipients to the list.
	*
	* @param  mixed $f_recipients Recipient(s) as string (one) or array (multiple)
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function recipientsDefine ($f_recipients)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer->recipientsDefine (+f_recipients)- (#echo(__LINE__)#)"); }
		$f_return = true;

		if (is_string ($f_recipients))
		{
			$f_recipient_array = $this->recipientParse ($f_recipients);

			if (empty ($f_recipient_array)) { $f_return = false; }
			else { $this->recipients[$f_recipient_array[1]] = ""; }
		}
		else
		{
			foreach ($f_recipients as $f_recipient_address => $f_recipient_name)
			{
				if ($f_return)
				{
					if (!strlen ($f_recipient_name)) { $f_recipients_array = $this->recipientParse ($f_recipient_address); }
					elseif (is_int ($f_recipient_address)) { $f_recipients_array = $this->recipientParse ($f_recipient_name); }
					else
					{
						$f_recipient = ("\"".(str_replace ("\"","\\\"",$f_recipient_name))."\" <$f_recipient_address>");
						$f_recipients_array = $this->recipientParse ($f_recipient);
					}

					if (empty ($f_recipients_array)) { $f_return = false; }
					else { $this->recipients[$f_recipients_array[1]] = $f_recipients_array[0]; }
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -sendmailer->recipientsDefine ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* This method will send the email. It will return false if this fails.
	*
	* @param  string $f_type Send eMail in default or BCC mode ("single" or "bcc")
	* @param  string $f_from Sender information
	* @param  string $f_subject Title of the eMail
	* @return boolean True on success
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function send ($f_type,$f_from,$f_subject)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer->send ($f_type,$f_from,$f_subject)- (#echo(__LINE__)#)"); }

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
			$f_subject = $this->quotedPrintableEncode ($f_subject,true);

			$f_email_headers .= ($this->headerAlign ("From: ".$f_from)).$this->linesep;

			if ($f_type == "bcc")
			{
				$f_email_headers .= ($this->headerAlign ("Bcc: ".$f_recipients)).$this->linesep;

				if ($direct_settings['swg_sendmailer_use_names']) { $f_recipients = $direct_settings['swg_sendmailer_bcc_recipient']; }
				else { $f_recipients = preg_replace ("#\"(.*?)\" <(.*?)>#i","\\2",$direct_settings['swg_sendmailer_bcc_recipient']); }
			}

			$f_email_headers .= ($this->headerAlign ("Reply-To: ".$f_from)).$this->linesep;
			$f_email_headers .= "User-Agent: direct SendMailer/1.1.0 (PHP-mail) [direct Netware Group]".$this->linesep;
			$f_email_headers .= ($this->headerAlign ("X-Sender: ".$f_from)).$this->linesep;
			$f_email_headers .= "X-Mailer: direct SendMailer/1.1.0 (PHP-mail) [direct Netware Group]".$this->linesep;
			$f_email_headers .= "MIME-Version: 1.0".$this->linesep;

			if ((count ($this->data)) == 1)
			{
				$f_email_content = ((isset ($this->data['@text'])) ? "@text" : "@mhtml");
				$f_email_headers .= ($this->headerAlign ("Content-Type: ".$this->data[$f_email_content]['mimetype']."; charset=".$this->data[$f_email_content]['encoding'])).$this->linesep;
				$f_email_headers .= "Content-Transfer-Encoding: quoted-printable";

				$f_email_content = $this->quotedPrintableEncode ($this->data[$f_email_content]['data']);

				$f_return = ($direct_settings['swg_sendmailer_senderrewrite'] ? mail ($f_recipients,$f_subject,$f_email_content,$f_email_headers,"-f".$f_sender_address) : mail ($f_recipients,$f_subject,$f_email_content,$f_email_headers));
			}
			else
			{
				$f_email_headers .= $this->multipartHeader ("multipart/mixed");

				$f_email_content = "";
				if (isset ($this->data['@text'])) { $f_email_content .= ((isset ($this->data['@mhtml'])) ? (($this->multipartBodyAlternativeHeader (1)).$this->linesep.$this->linesep.($this->multipartBody ("@text",$this->data['@text'],1))) : $this->multipartBody ("@text",$this->data['@text'])); }

				if (isset ($this->data['@mhtml']))
				{
					if ($f_email_content) { $f_email_content .= $this->linesep; }
					$f_email_content .= ((isset ($this->data['@text'])) ? (($this->multipartBody ("@mhtml",$this->data['@mhtml'],1)).$this->linesep.($this->multipartBodyAlternativeFooter (1))) : $this->multipartBody ("@mhtml",$this->data['@mhtml']));
				}

				foreach ($this->data as $f_email_content_type => $f_email_content_array)
				{
					if (strpos ($f_email_content_type,"@") === false)
					{
						if ($f_email_content) { $f_email_content .= $this->linesep; }
						$f_email_content .= $this->multipartBody ($f_email_content_type,$f_email_content_array);
					}
				}

				if ($f_email_content) { $f_email_content .= $this->linesep; }
				$f_email_content .= $this->multipartFooter ();

				$f_return = ($direct_settings['swg_sendmailer_senderrewrite'] ? mail ($f_recipients,$f_subject,$f_email_content,$f_email_headers,"-f".$f_sender_address) : mail ($f_recipients,$f_subject,$f_email_content,$f_email_headers));
			}
		}
		else { trigger_error ("sWG/#echo(__FILEPATH__)# -sendmailer->send ()- (#echo(__LINE__)#) reporting: Error while preparing e-mail delivery",E_USER_WARNING); }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -sendmailer->send ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Returns the text email body.
	*
	* @return string Text email body
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function textGet ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer->textGet ()- (#echo(__LINE__)#)"); }

		if (isset ($this->data['@text'])) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -sendmailer->textGet ()- (#echo(__LINE__)#)",:#*/$this->data['@text']/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -sendmailer->textGet ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Sets a new text email body (replacing the old one).
	*
	* @param  string $f_encoding Text encoding
	* @param  string $f_data eMail text
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function textSet ($f_encoding,$f_data)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer->textSet ($f_encoding,+f_data)- (#echo(__LINE__)#)"); }
		$this->data['@text'] = array ("mimetype" => "text/plain","encoding" => $f_encoding,"data" => $f_data);
	}

/**
	* Returns the (X)HTML email body.
	*
	* @return string (X)HTML email body
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function xhtmlGet ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer->xhtmlGet ()- (#echo(__LINE__)#)"); }

		if (isset ($this->data['@mhtml'])) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -sendmailer->xhtmlGet ()- (#echo(__LINE__)#)",:#*/$this->data['@mhtml']/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -sendmailer->xhtmlGet ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Sets a new (X)HTML email body (replacing the old one).
	*
	* @param string $f_encoding HTML content encoding
	* @param string $f_data HTML document
	* @param string $f_content_type Content type for $f_data
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function xhtmlSet ($f_encoding,$f_data,$f_content_type = NULL)
	{
		global $direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -sendmailer->xhtmlSet ($f_encoding,+f_data,+f_content_type)- (#echo(__LINE__)#)"); }

		if ($direct_settings['swg_sendmailer_use_xhtml_mime']) { $this->data['@mhtml'] = array ("mimetype" => "application/xhtml+xml","encoding" => $f_encoding,"data" => $f_data); }
		else
		{
			if (!isset ($f_content_type)) { $f_content_type = "application/xhtml+xml; charset=".$direct_local['lang_charset']; }
			direct_outputenc_xhtml_cleanup ($f_data,$f_content_type);
			$this->data['@mhtml'] = array ("mimetype" => "text/html","encoding" => $f_encoding,"data" => $f_data);
		}
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directSendmailer",true);

//j// Script specific commands

global $direct_settings;
if (!isset ($direct_settings['swg_sendmailer_bcc_recipient'])) { $direct_settings['swg_sendmailer_bcc_recipient'] = $direct_settings['administration_email_out']; }
if (!isset ($direct_settings['swg_sendmailer_native_mode'])) { $direct_settings['swg_sendmailer_native_mode'] = false; }
if (!isset ($direct_settings['swg_sendmailer_senderrewrite'])) { $direct_settings['swg_sendmailer_senderrewrite'] = true; }
if (!isset ($direct_settings['swg_sendmailer_use_names'])) { $direct_settings['swg_sendmailer_use_names'] = true; }
if (!isset ($direct_settings['swg_sendmailer_use_xhtml_mime'])) { $direct_settings['swg_sendmailer_use_xhtml_mime'] = false; }
}

//j// EOF
?>