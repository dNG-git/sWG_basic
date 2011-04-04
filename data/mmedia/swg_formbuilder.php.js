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

<?php
$g_block = (isset ($direct_settings['dsd']['dblock']) ? $direct_settings['dsd']['dblock'] : "");
$g_lang_js = substr ($direct_settings['lang'],0,2);

if ($g_block == "djs_formbuilder_datetime") {
?>
function djs_formbuilder_datetime (f_params)
{
	if (typeof (f_params['panel']) == "undefined") { f_params['panel'] = true; }

	var f_options = { altField:"#" + f_params.id + "i",altFormat:"@",changeMonth:true,changeYear:true,dateFormat:"yy-mm-dd",showButtonPanel:f_params.panel,showAnim:"fadeIn" };
	if (typeof (f_params['months']) != "undefined") { f_options['numberOfMonths'] = f_params.months; }

	var f_jquery_object = $("#" + f_params.id).datepicker(f_options).bind ("change",function () { djs_formbuilder_datetime_select (f_params); });
	if ((f_params.lang != "<?php echo $g_lang_js; ?>")&&(typeof ($.datepicker.regional[f_params.lang]) != "undefined")) { f_jquery_object.datepicker ("option",$.datepicker.regional[f_params.lang]); }
	f_jquery_object.datepicker ("setDate",f_params.date);

	djs_formbuilder_datetime_select (f_params);
}

function djs_formbuilder_datetime_select (f_params)
{
	f_jquery_object = $("#" + f_params.id + "i");
	var f_timestamp = f_jquery_object.val ();
	f_jquery_object.val (f_timestamp.substring (0,(f_timestamp.length - 3)));
}
<?php } ?>

<?php if ($g_block == "djs_formbuilder_iframe_change_height") { ?>
function djs_formbuilder_iframe_change_height (f_id,f_height) { djs_swgDOM_css_change_px (f_id,"height",f_height); }
djs_load_functions ({ file:"swg_DOM.php.js",block:"djs_swgDOM_css_change_px" });
<?php } ?>

<?php if ($g_block == "") { ?>
djs_var['basic_formbuilder_accordion_ready'] = false;
djs_var['basic_formbuilder_button_ready'] = false;
djs_var['basic_formbuilder_datetime_ready'] = false;
djs_var['basic_formbuilder_form_ready'] = false;
if (typeof (djs_var['basic_formbuilder_focused_class']) == "undefined") { djs_var['basic_formbuilder_focused_class'] = "pagecontentinputfocused"; }
if (typeof (djs_var['basic_formbuilder_focused_timeout']) == "undefined") { djs_var['basic_formbuilder_focused_timeout'] = 750; }
djs_var['basic_formbuilder_range_ready'] = false;

function djs_formbuilder_focus (f_id,f_duration)
{
	if (f_duration == null) { f_duration = djs_var.basic_formbuilder_focused_timeout; }
	if ($("#" + f_id).addClass (djs_var.basic_formbuilder_focused_class) != null) { self.setTimeout ("djs_formbuilder_unfocus ('" + f_id + "','')",f_duration); }
}

function djs_formbuilder_init (f_params)
{
	if ((typeof (f_params['id']) == "undefined")||(typeof (f_params['type']) == "undefined")) { var f_type = null; }
	else { var f_type = f_params.type; }

	if ((f_type != "datepicker")&&(f_type != "form")&&(f_type != "form_sections")&&(f_type != "range")&&(f_type != "timepicker")&&($("#" + f_params.id).bind ("focus",function () { djs_formbuilder_focus (f_params.id); }))) { djs_formbuilder_tabindex (f_params); }

	if (f_type == "button")
	{
		if (!djs_var.basic_formbuilder_button_ready)
		{
			djs_load_functions ({ file:"ext_jquery/jquery.ui.core.min.js" });
			djs_load_functions ({ file:"ext_jquery/jquery.ui.widget.min.js" });
			djs_load_functions ({ file:"ext_jquery/jquery.ui.button.min.js" });
			djs_var.basic_formbuilder_button_ready = true;
		}

		$("#" + f_params.id).button ();
	}

	if (f_type == "datepicker")
	{
		var f_data = $("#" + f_params.id + "i5");

		if (typeof (f_data.get(0)['valueAsDate']) == "undefined")
		{
			if (!djs_var.basic_formbuilder_datetime_ready)
			{
				djs_load_functions ({ file:"swg_formbuilder.php.js",block:"djs_formbuilder_datetime" });
				djs_load_functions ({ file:"ext_jquery/jquery.ui.core.min.js" });
				djs_load_functions ({ file:"ext_jquery/jquery.ui.datepicker.min.js" });
<?php if (file_exists ($direct_settings['path_mmedia']."/ext_jquery/jquery.ui.datepicker.$g_lang_js.min.js")) { echo "djs_load_functions ({ file:'ext_jquery/jquery.ui.datepicker.$g_lang_js.min.js' });"; } ?>
				djs_var.basic_formbuilder_datetime_ready = true;
			}

			var f_datepicker_params = { date:f_params.value,id:f_params.id,lang:"<?php echo $g_lang_js; ?>" };
			if (typeof (f_params['months']) != "undefined") { f_datepicker_params['months'] = f_params.months; }
			f_data = "<div><input type='hidden' name='" + f_params.name + "' value=\"\" id='" + f_params.id + "i' /></div>";

			djs_swgDOM_replace ({ data:f_data,id:f_params.id,onReplace:{ func:"djs_formbuilder_datetime",params:f_datepicker_params } });
		}
		else
		{
			f_data.attr("id",f_params.id + "p").attr("name","p_" + f_params.name).css ("display","block");

			f_data = f_data.bind("change",function ()
			{
				var f_timestamp = String ($(this).get(0).valueAsNumber);
				$("#" + f_params.id + "i").val (f_timestamp.substring (0,(f_timestamp.length - 3)));
			}).wrap("<div>").parent ();

			var f_timestamp = String (f_data.get(0).valueAsNumber);
			f_data.append ("<input type='hidden' name='" + f_params.name + "' value=\"" + (f_timestamp.substring (0,(f_timestamp.length - 3))) + "\" id='" + f_params.id + "i' />");

			djs_swgDOM_replace ({ data:f_data,id:f_params.id,onReplace:{ func:"djs_formbuilder_init",params:{ id:f_params.id + "p" } } });
		}
	}

	if (f_type == "form")
	{
		if (!djs_var.basic_formbuilder_form_ready)
		{
			djs_load_functions ({ file:"swg_AJAX.php.js",block:"djs_swgAJAX_insert" });
			djs_load_functions ({ file:"swg_formbuilder.php.js",block:"djs_formbuilder_submit" });
			djs_load_functions ({ file:"ext_jquery/jquery.effects.core.min.js" });
			djs_load_functions ({ file:"ext_jquery/jquery.effects.transfer.min.js" });
			djs_var.basic_formbuilder_form_ready = true;
		}

		if (typeof (f_params['id_button']) == "undefined") { f_params['id_button'] = null; }
		if (typeof (f_params['url']) == "undefined") { f_params['url'] = null; }
		$("#" + f_params.id).bind ("submit",function () { return djs_formbuilder_submit (f_params.id,f_params.url,f_params.id_button); });
	}

	if (f_type == "form_sections")
	{
		if (!djs_var.basic_formbuilder_accordion_ready)
		{
			djs_load_functions ({ file:"ext_jquery/jquery.ui.core.min.js" });
			djs_load_functions ({ file:"ext_jquery/jquery.ui.widget.min.js" });
			djs_load_functions ({ file:"ext_jquery/jquery.ui.accordion.min.js" });
			djs_var.basic_formbuilder_accordion_ready = true;
		}

		$("#" + f_params.id + " > .ui-accordion-header").removeClass ("pagecontenttitle");
		$("#" + f_params.id).accordion({ autoHeight: false,header: ".ui-accordion-header",navigation: true }).bind ("accordionchange",function (f_event,f_ui) { f_ui.newContent.find(":input").first().trigger ("focus"); });
	}

	if (f_type == "range")
	{
		var f_data = $("#" + f_params.id + "i");

		if (typeof (f_data.get(0)['valueAsDate']) == "undefined")
		{
			f_data.remove ();

			if (!djs_var.basic_formbuilder_range_ready)
			{
				djs_load_functions ({ file:"swg_formbuilder.php.js",block:"djs_formbuilder_range" });
				djs_load_functions ({ file:"ext_jquery/jquery.ui.core.min.js" });
				djs_load_functions ({ file:"ext_jquery/jquery.ui.widget.min.js" });
				djs_load_functions ({ file:"ext_jquery/jquery.ui.mouse.min.js" });
				djs_load_functions ({ file:"ext_jquery/jquery.ui.slider.min.js" });

				djs_var.basic_formbuilder_range_ready = true;
			}

			var f_range_params = { id:f_params.id,max:f_params.max,min:f_params.min,value:f_data.val () };
			f_data = "<div><div id='" + f_params.id + "s'></div><input type='hidden' name='" + f_params.name + "' value=\"" + f_range_params.value + "\" id='" + f_params.id + "i' /><span id='" + f_params.id + "o'>" + f_range_params.value + "</span></div>";

			djs_swgDOM_replace ({ data:f_data,id:f_params.id,onReplace:{ func:"djs_formbuilder_range",params:f_range_params } });
		}
		else
		{
			$("#" + f_params.id).removeAttr ("name");

			f_data.attr ("name",f_params.name);
			djs_swgDOM_replace ({ data:f_data,id:f_params.id,onReplace:{ func:"djs_formbuilder_init",params:{ id:f_params.id } } });
		}
	}

	if (f_type == "timepicker")
	{
		var f_data = $("#" + f_params.id + "i5");

		if (typeof (f_data.get(0)['valueAsDate']) != "undefined")
		{
			f_data.attr("id",f_params.id + "p").attr("name","p_" + f_params.name).css ("display","block");

			f_data = f_data.bind("change",function ()
			{
				var f_timestamp = String ($(this).get(0).valueAsNumber);
				$("#" + f_params.id + "i").val (f_timestamp.substring (0,(f_timestamp.length - 3)));
			}).wrap("<div>").parent ();

			var f_timestamp = String (f_data.get(0).valueAsNumber);
			f_data.append ("<input type='hidden' name='" + f_params.name + "' value=\"" + (f_timestamp.substring (0,(f_timestamp.length - 3))) + "\" id='" + f_params.id + "i' />");

			djs_swgDOM_replace ({ data:f_data,id:f_params.id });
		}
	}
}
<?php } ?>

<?php if ($g_block == "djs_formbuilder_range") { ?>
function djs_formbuilder_range (f_params) { f_jquery_object = $("#" + f_params.id + "s").slider(f_params).bind ("slide",function (f_event,f_ui) { djs_formbuilder_range_slide (f_params,f_ui.value); }); }

function djs_formbuilder_range_slide (f_params,f_value)
{
	$("#" + f_params.id + "i").val (f_value);
	$("#" + f_params.id + "o").text (f_value);
}
<?php } ?>

<?php if ($g_block == "djs_formbuilder_select_change_size") { ?>
function djs_formbuilder_select_change_size (f_id,f_size)
{
	if (f_size == "+")
	{
		f_size = parseInt ($("#" + f_id).attr ("size"));
		if (f_size) { f_size += 1; }
	}
	else if (f_size == "-")
	{
		f_size = parseInt ($("#" + f_id).attr ("size"));
		if ((f_size)&&(f_size > 2)) { f_size -= 1; }
	}
	else { f_size = parseInt (f_size); }

	if (f_size) { djs_swgDOM_attr_change_int (f_id,"size",f_size); }
}

djs_load_functions ({ file:"swg_DOM.php.js",block:"djs_swgDOM_attr_change_int" });
<?php } ?>

<?php if ($g_block == "djs_formbuilder_submit") { ?>
function djs_formbuilder_submit (f_id,f_url,f_id_button)
{
	if ((f_url == null)||(f_url == "")) { f_url = "<?php echo $direct_settings['iscript']."?ajax_dialog"; ?>"; }
	djs_swgAJAX_insert_after ({ data:($("#" + f_id).serialize ()),id:f_id,id_inserted:f_id + "d",id_transfer_source:f_id_button,onInserted:{ func:"djs_dialog_init",params:{ id:f_id + "d" } },type:"POST",url:f_url });
	return false;
}
<?php } ?>

<?php if ($g_block == "") { ?>
djs_var['basic_formbuilder_tabindex'] = 1;

function djs_formbuilder_tabindex (f_params)
{
	if (typeof (f_params['id']) != "undefined")
	{
		var f_jquery_object = $("#" + f_params.id);
		var f_jquery_tabindex = f_jquery_object.attr ("tabindex");
		if (((f_jquery_tabindex == null)||(f_jquery_tabindex == ""))&&(f_jquery_object.attr ("tabindex",djs_var.basic_formbuilder_tabindex) != null)) { djs_var.basic_formbuilder_tabindex++; }
	}
}
<?php } ?>

<?php if ($g_block == "djs_formbuilder_textarea_change_rows") { ?>
function djs_formbuilder_textarea_change_rows (f_id,f_rows)
{
	if (f_rows == "+")
	{
		f_rows = parseInt ($("#" + f_id).attr ("rows"));
		if (f_rows) { f_rows += 1; }
	}
	else if (f_rows == "-")
	{
		f_rows = parseInt ($("#" + f_id).attr ("rows"));
		if ((f_rows)&&(f_rows > 1)) { f_rows -= 1; }
	}
	else { f_rows = parseInt (f_rows); }

	if (f_rows) { djs_swgDOM_attr_change_int (f_id,"rows",f_rows); }
}

djs_load_functions ({ file:"swg_DOM.php.js",block:"djs_swgDOM_attr_change_int" });
<?php } ?>

<?php if ($g_block == "") { ?>
function djs_formbuilder_unfocus (f_id) { $("#" + f_id).removeClass (djs_var.basic_formbuilder_focused_class); }
<?php } ?>

//j// EOF