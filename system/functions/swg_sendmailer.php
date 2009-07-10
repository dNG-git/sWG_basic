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
* It's always a good idea to use a custom API for sending e-Mails. This is the
* older, function based implementation (now using the class interface).
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

//j// Functions and classes

/* -------------------------------------------------------------------------
Function to send plain text e-Mails without attachments.
------------------------------------------------------------------------- */

//f// direct_sendmail ($f_type,$f_from,$f_target,$f_subject,$f_msg)
/**
* Function to send plain text e-Mails without attachments.
*
* @param  string $f_type Informs the mailer if this should be an BCC message
*         or not. The following types are supported: "bcc" and "to"
*         (standard).
* @param  string $f_from Valid from string (e-Mail address or "Name" <e-Mail>)
* @param  string $f_target Valid target string (comma seperated BCC or single
*         address).
* @param  string $f_subject Subject for the e-Mail
* @param  string $f_msg Content of the e-Mail
* @uses   USE_debug_reporting
* @return boolean True on success
* @since  v0.1.00
*/
function direct_sendmail ($f_type,$f_from,$f_target,$f_subject,$f_msg)
{
	global $direct_local;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_sendmail ($f_type,$f_from,$f_target,$f_subject,+f_msg)- (#echo(__LINE__)#)"); }

	$f_return = true;
	$f_sendmailer_object = new direct_sendmailer ();
	$f_target_array = explode (",",$f_target);

	foreach ($f_target_array as $f_target)
	{
		if ($f_return) { $f_return = $f_sendmailer_object->recipients_define ($f_target); }
	}

	if ($f_return)
	{
		$f_sendmailer_object->text_set ($direct_local['lang_charset'],$f_msg);
		$f_return = $f_sendmailer_object->send ($f_type,$f_from,$f_subject);
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_sendmail ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// Script specific commands

$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_sendmailer.php");

//j// EOF
?>