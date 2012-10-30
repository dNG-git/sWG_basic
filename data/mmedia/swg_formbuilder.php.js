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
if (!isset ($direct_settings['theme_form_td_padding'])) { $direct_settings['theme_form_td_padding'] = "3px"; }

$g_block = (isset ($direct_settings['dsd']['dblock']) ? $direct_settings['dsd']['dblock'] : "");
$g_lang_js = substr ($direct_settings['lang'],0,2);
?>
djs_var['basic_formbuilder_accordion_ready'] = false;
djs_var['basic_formbuilder_button_ready'] = false;
djs_var['basic_formbuilder_form_ready'] = false;
if (!('basic_formbuilder_focused_class' in djs_var)) { djs_var['basic_formbuilder_focused_class'] = 'pagecontentinputfocused'; }
if (!('basic_formbuilder_focused_timeout' in djs_var)) { djs_var['basic_formbuilder_focused_timeout'] = 750; }
djs_var['basic_formbuilder_range_ready'] = false;
djs_var['basic_formbuilder_resizeable_ready'] = false;

function djs_formbuilder_focus (f_id,f_duration)
{
	if (f_duration == null) { f_duration = djs_var.basic_formbuilder_focused_timeout; }
	if (jQuery("#" + f_id).addClass (djs_var.basic_formbuilder_focused_class) != null) { self.setTimeout ("djs_formbuilder_unfocus ('" + f_id + "','')",f_duration); }
}

function djs_formbuilder_init (f_params)
{
	if ((!('id' in f_params))||(!('type' in f_params))) { var f_type = null; }
	else { var f_type = f_params.type; }

	if ((f_type != 'datepicker')&&(f_type != 'form')&&(f_type != 'form_sections')&&(f_type != 'range')&&(f_type != 'timepicker')&&(jQuery("#" + f_params.id).on ('focus',function () { djs_formbuilder_focus (f_params.id); }))) { djs_formbuilder_tabindex (f_params); }

	if (f_type == 'button')
	{
		if (djs_var.basic_formbuilder_button_ready) { jQuery("#" + f_params.id).button (); }
		else
		{
djs_load_functions ([
 { file:'ext_jquery/jquery.ui.core.min.js' },
 { file:'ext_jquery/jquery.ui.widget.min.js' },
 { file:'ext_jquery/jquery.ui.button.min.js' }
]).done (function ()
{
	djs_var.basic_formbuilder_button_ready = true;
	djs_formbuilder_init (f_params);
});
		}
	}

	if (f_type == 'datepicker')
	{
		djs_load_functions([ { file:'ext_djs/djs_html5_datetime.min.js' } ]).done (function ()
		{
			if (!('css_classes' in f_params)) { f_params['css_classes'] = null; }
			if (!('css_classes_replaced' in f_params)) { f_params['css_classes_replaced'] = null; }
			djs_html5_datetime ({ datetime_lang:"<?php echo $direct_local['lang_iso_domain']; ?>",id:f_params.id,onCompleted:{ func:'djs_formbuilder_set_select_css',params:f_params } });
		});
	}

	if (f_type == 'form')
	{
		if (djs_var.basic_formbuilder_form_ready)
		{
			if (!('id_button' in f_params)) { f_params['id_button'] = null; }
			if (!('url' in f_params)) { f_params['url'] = null; }
			jQuery("#" + f_params.id).on ('submit',function () { return djs_formbuilder_submit (f_params.id,f_params.url,f_params.id_button); });
		}
		else
		{
djs_load_functions ([
 { file:'swg_AJAX.php.js',block:'djs_swgAJAX_insert' },
 { file:'ext_jquery/jquery.ui.core.min.js' },
 { file:'ext_jquery/jquery.ui.effect.min.js' },
 { file:'ext_jquery/jquery.ui.effect-transfer.min.js' }
]).done (function ()
{
	djs_var.basic_formbuilder_form_ready = true;
	djs_formbuilder_init (f_params);
});
		}
	}

	if (f_type == 'form_sections')
	{
		if (djs_var.basic_formbuilder_accordion_ready)
		{
			jQuery("#" + f_params.id + " > .ui-accordion-header").removeClass ('pagecontenttitle');
			jQuery("#" + f_params.id).accordion({ header:'.ui-accordion-header',heightStyle:'content' }).on ('activate',function (f_event,f_ui) { f_ui.newPanel.find(':input').first().trigger ('focus'); });
		}
		else
		{
djs_load_functions ([
 { file:'ext_jquery/jquery.ui.core.min.js' },
 { file:'ext_jquery/jquery.ui.widget.min.js' },
 { file:'ext_jquery/jquery.ui.accordion.min.js' }
]).done (function ()
{
	djs_var.basic_formbuilder_accordion_ready = true;
	djs_formbuilder_init (f_params);
});
		}
	}

	if (f_type == 'email')
	{
		var f_data = jQuery ("#" + f_params.id);
		if (!('formNoValidate' in f_data.get (0))) { djs_DOM_replace ({ animate:false,data:(f_data.clone().attr ('type','text')),id:f_params.id,onReplace:{ func:'djs_formbuilder_init',params:{ id:f_params.id } } }); }
	}

	if (f_type == 'range')
	{
		var f_data = jQuery ("#" + f_params.id);

		if (!('stepUp' in f_data.get (0)))
		{
			if (!djs_var.basic_formbuilder_range_ready)
			{
				djs_load_functions ({ file:'swg_formbuilder.php.js',block:'djs_formbuilder_range' });
				djs_load_functions ({ file:'ext_jquery/jquery.ui.core.min.js' });
				djs_load_functions ({ file:'ext_jquery/jquery.ui.widget.min.js' });
				djs_load_functions ({ file:'ext_jquery/jquery.ui.mouse.min.js' });
				djs_load_functions ({ file:'ext_jquery/jquery.ui.slider.min.js' });

				djs_var.basic_formbuilder_range_ready = true;
			}

			f_data.next('br').remove ();

			var f_range_params = { id:f_params.id,max:(parseFloat (f_data.attr ('max'))),min:(parseFloat (f_data.attr ('min'))),value:f_data.val () };
			if (f_range_params.value == '') { f_range_params.value = f_range_params.min; }
			f_data = "<div><div id='" + f_params.id + "s'></div><input type='hidden' name='" + (f_data.attr ("name")) + "' value=\"" + f_range_params.value + "\" id='" + f_params.id + "i' /><b><span id='" + f_params.id + "o'>" + f_range_params.value + "</span></b></div>";

			djs_DOM_replace ({ data:f_data,id:f_params.id,onReplace:{ func:'djs_formbuilder_range',params:f_range_params } });
		}
	}

	if (f_type == 'resizeable')
	{
		if (djs_var.basic_formbuilder_resizeable_ready) { jQuery("#" + f_params.id).wrap("<div style='padding:<?php echo $direct_settings['theme_form_td_padding']; ?>' />").parent().resizable ({ alsoResize:"#" + f_params.id }); }
		else
		{
djs_load_functions ([
 { file:'ext_jquery/jquery.ui.core.min.js' },
 { file:'ext_jquery/jquery.ui.widget.min.js' },
 { file:'ext_jquery/jquery.ui.mouse.min.js' },
 { file:'ext_jquery/jquery.ui.resizable.min.js' }
]).done (function ()
{
	djs_var.basic_formbuilder_resizeable_ready = true;
	djs_formbuilder_init (f_params);
});
		}
	}

	if (f_type == 'search')
	{
		var f_data = jQuery ("#" + f_params.id);
		if (!('formNoValidate' in f_data.get (0))) { djs_DOM_replace ({ animate:false,data:(f_data.clone().attr ('type','text')),id:f_params.id,onReplace:{ func:'djs_formbuilder_init',params:{ id:f_params.id } } }); }
	}

	if (f_type == 'tel')
	{
		var f_data = jQuery ("#" + f_params.id);
		if (!('formNoValidate' in f_data.get (0))) { djs_DOM_replace ({ animate:false,data:(f_data.clone().attr ('type','text')),id:f_params.id,onReplace:{ func:'djs_formbuilder_init',params:{ id:f_params.id } } }); }
	}

	if (f_type == 'timepicker')
	{
		djs_load_functions([ { file:'ext_djs/djs_html5_datetime.min.js' } ]).done (function ()
		{
			if (!('css_classes' in f_params)) { f_params['css_classes'] = null; }
			if (!('css_classes_replaced' in f_params)) { f_params['css_classes_replaced'] = null; }
			djs_html5_datetime ({ datetime_lang:"<?php echo $direct_local['lang_iso_domain']; ?>",id:f_params.id,onCompleted:{ func:'djs_formbuilder_set_select_css',params:f_params } });
		});
	}

	if (f_type == 'url')
	{
		var f_data = jQuery ("#" + f_params.id);
		if (!('formNoValidate' in f_data.get (0))) { djs_DOM_replace ({ animate:false,data:(f_data.clone().attr ('type','text')),id:f_params.id,onReplace:{ func:'djs_formbuilder_init',params:{ id:f_params.id } } }); }
	}
}

function djs_formbuilder_range (f_params) { f_jquery_object = jQuery("#" + f_params.id + "s").slider(f_params).on ('slide',function (f_event,f_ui) { djs_formbuilder_range_slide (f_params,f_ui.value); }); }

function djs_formbuilder_range_slide (f_params,f_value)
{
	jQuery("#" + f_params.id + "i").val (f_value);
	jQuery("#" + f_params.id + "o").text (f_value);
}

function djs_formbuilder_set_select_css (f_params)
{
	if (('css_classes' in f_params)&&('css_classes_replaced' in f_params)&&('id' in f_params)&&(f_params.css_classes !== null)&&(f_params.css_classes_replaced !== null))
	{
		var f_jquery_object = jQuery ("#" + f_params.id);

		if (f_jquery_object.data ('djsHtml5Replaced') == true) { f_jquery_object.find("select").filter(':visible').addClass (f_params.css_classes_replaced); }
		else
		{
			f_jquery_object.addClass (f_params.css_classes);
			djs_formbuilder_tabindex (f_params);
		}
	}
}

function djs_formbuilder_submit (f_id,f_url,f_id_button)
{
	var f_jquery_object = jQuery ("#" + f_id);
	if ((f_url == null)||(f_url == '')) { f_url = (f_jquery_object.attr ('action') + "?ajax_dialog"); }
	djs_swgAJAX_insert_after ({ data:(f_jquery_object.serialize ()),id:f_id,id_inserted:f_id + "d",id_transfer_source:f_id_button,onInsert:{ func:'djs_dialog_init',params:{ id:f_id + "d" } },type:'POST',url:f_url });

	return false;
}

djs_var['basic_formbuilder_tabindex'] = 1;

function djs_formbuilder_tabindex (f_params)
{
	if ('id' in f_params)
	{
		var f_jquery_object = jQuery ("#" + f_params.id);
		var f_jquery_tabindex = f_jquery_object.attr ('tabindex');
		if (((f_jquery_tabindex == null)||(f_jquery_tabindex == ''))&&(f_jquery_object.attr ('tabindex',djs_var.basic_formbuilder_tabindex) != null)) { djs_var.basic_formbuilder_tabindex++; }
	}
}

function djs_formbuilder_unfocus (f_id) { jQuery("#" + f_id).removeClass (djs_var.basic_formbuilder_focused_class); }

//j// EOF