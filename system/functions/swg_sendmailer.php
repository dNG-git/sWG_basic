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
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/

/*#use(direct_use) */
use dNG\sWG\directSendmailer;
/* #\n*/

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
* @return boolean True on success
* @since  v0.1.00
*/
function direct_sendmail ($f_type,$f_from,$f_target,$f_subject,$f_msg)
{
	global $direct_local;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_sendmail ($f_type,$f_from,$f_target,$f_subject,+f_msg)- (#echo(__LINE__)#)"); }

	$f_return = true;
	$f_sendmailer_object = new directSendmailer ();
	$f_target_array = explode (",",$f_target);

	foreach ($f_target_array as $f_target)
	{
		if ($f_return) { $f_return = $f_sendmailer_object->recipientsDefine ($f_target); }
	}

	if ($f_return)
	{
		$f_sendmailer_object->textSet ($direct_local['lang_charset'],$f_msg);
		$f_return = $f_sendmailer_object->send ($f_type,$f_from,$f_subject);
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_sendmail ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// EOF
?>