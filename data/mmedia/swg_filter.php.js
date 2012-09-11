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

<?php
$direct_settings['theme_css_corners'] = (isset ($direct_settings['theme_css_corners_class']) ? " ".$direct_settings['theme_css_corners_class'] : " ui-corner-all");
if (!isset ($direct_settings['theme_css_default_filter_class'])) { $direct_settings['theme_css_default_filter_class'] = "ui-widget-header"; }
if (!isset ($direct_settings['theme_td_padding'])) { $direct_settings['theme_td_padding'] = "5px"; }
?>
function djs_default_filter_init (f_params)
{
	if ("id" in f_params)
	{
		var f_jquery_object = jQuery ("#" + f_params.id);
		if ((!("border" in f_params))||(f_params.border)) { f_jquery_object.addClass ('<?php echo $direct_settings['theme_css_default_filter_class'].$direct_settings['theme_css_corners']; ?>'); }
		if (("margin" in f_params)&&(f_params.margin)) { f_jquery_object.css ('margin','<?php echo $direct_settings['theme_td_padding']; ?>'); }

		djs_formbuilder_init ({ id:f_params.id + "i" });
		djs_formbuilder_init ({ id:f_params.id + "b",type:'button' });
		if ("tid" in f_params) { djs_tid_keepalive (f_params.tid); }

		var f_js_function = null;

		if ("ajax_url0" in f_params)
		{
			if ("ajax_id" in f_params) { f_jquery_object.data ('ajax_id',f_params.ajax_id); }
			else { f_jquery_object.data ('ajax_id',f_id); }

			f_jquery_object.data ('url0',f_params.ajax_url0);
			f_js_function = djs_default_filter_process_ajax_url;
		}
		else if ("url" in f_params)
		{
			f_jquery_object.data ('url',f_params.url);
			f_js_function = djs_default_filter_process_url;
		}

		if (f_js_function !== null)
		{
			jQuery("#" + f_params.id + "b").data('id',f_params.id).on ({ click:f_js_function,keypress:f_js_function });
			jQuery("#" + f_params.id + "i").data('id',f_params.id).on ('keypress',f_js_function);
		}
	}
}

function djs_default_filter_process_ajax_url (f_event)
{
	if ((f_event.type != 'keypress')||(f_event.which == 13))
	{
		f_event.preventDefault ();

		var f_id = jQuery.data (this,'id');
		var f_jquery_object = jQuery ("#" + f_id);
		djs_swgAJAX_replace_url0 (f_jquery_object.data ("ajax_id"),(f_jquery_object.data("url0").replace (/\[text\]/g,(encodeURIComponent (jQuery("#" + f_id + "i").val ())))));
	}
}

function djs_default_filter_process_url (f_event)
{
	if ((f_event.type != 'keypress')||(f_event.which == 13))
	{
		f_event.preventDefault ();
		var f_id = jQuery.data (this,"id");
		self.location.replace (jQuery("#" + f_id).data("url").replace (/\[text\]/g,(encodeURIComponent (jQuery("#" + f_id + "i").val ()))));
	}
}

//j// EOF