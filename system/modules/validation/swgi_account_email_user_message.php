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
$Id: swgi_account_email_user_message.php,v 1.1 2008/12/20 13:38:33 s4u Exp $
#echo(sWGbasicVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* validation/swgi_account_email_user_message.php
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
* @subpackage account
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

$direct_settings['additional_copyright'][] = array ("Module basic #echo(sWGbasicVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if (USE_debug_reporting) { direct_debug (2,"sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }

$g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_sendmailer_formtags.php");

if ($g_continue_check)
{
	direct_local_integration ("account");

	$f_sendmailer_object = new direct_sendmailer_formtags ();
	$f_sendmailer_object->recipients_define (array ($direct_cachedata['validation_data']['recipient_address'] => $direct_cachedata['validation_data']['recipient_name']));

$g_message = ("[contentform:highlight]".(direct_local_get ("core_message_by_user","text"))."

[font:bold]".(direct_local_get ("core_message_from","text")).":[/font] {$direct_cachedata['validation_data']['source_address']}
[font:bold]".(direct_local_get ("core_message_to","text")).":[/font] {$direct_cachedata['validation_data']['recipient_name']} ({$direct_cachedata['validation_data']['recipient_address']})[/contentform]
[font:bold]".(direct_local_get ("core_message","text")).":[/font]

[hr]
{$direct_cachedata['validation_data']['message']}

[hr]
(C) $direct_settings[swg_title_txt] ([url]{$direct_settings['home_url']}[/url])
All rights reserved");

	$f_sendmailer_object->message_set ($g_message);
	$g_continue_check = $f_sendmailer_object->send ("single",$direct_settings['administration_email_out'],$direct_settings['swg_title_txt']." - ".(direct_local_get ("account_email_user_message","text")));
}

if (!$g_continue_check) { $direct_cachedata['validation_error'] = array ("core_unknown_error","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }

//j// EOF
?>