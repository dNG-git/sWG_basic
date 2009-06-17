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
$Id: swg_formbuilder.js,v 1.2 2009/03/16 08:08:57 s4u Exp $
----------------------------------------------------------------------------
NOTE_END //n*/

function djs_formbuilder_iframe_change_height (f_id,f_height)
{
	if (djs_swgDOM)
	{
	// Only continue if the basic test had been completed successfully
	if (djs_swgDOM_elements_editable)
	{
		var f_height_temp = 0;

		if (f_height == '+')
		{
			f_height_temp = parseInt (self.document.getElementById(f_id).getAttribute ('height'));
			if (f_height_temp) { self.document.getElementById(f_id).setAttribute ('height',(f_height_temp + 17)); }
		}
		else if (f_height == '-')
		{
			f_height_temp = parseInt (self.document.getElementById(f_id).getAttribute ('height'));

			if (f_height_temp)
			{
				if (f_height_temp > 111) { self.document.getElementById(f_id).setAttribute ('height',(f_height_temp - 17)); }
			}
		}
		else
		{
			f_height_temp = parseInt (f_height);
			if (f_height_temp) { self.document.getElementById(f_id).setAttribute ('height',f_height_temp); }
		}
	}
	}
}

djs_var['formbuilder_focused'] = new Array ();
if (typeof (djs_var['formbuilder_focused_color']) == 'undefined') { djs_var['formbuilder_focused_color'] = '#FF0000'; }
if (typeof (djs_var['formbuilder_focused_timeout']) == 'undefined') { djs_var['formbuilder_focused_timeout'] = 750; }

function djs_formbuilder_focused (f_id)
{
	if (djs_swgDOM)
	{
	// Only continue if the basic test had been completed successfully
	if (djs_swgDOM_elements_editable)
	{
		if (typeof (self.document.getElementById(f_id).style.borderColor) == 'string')
		{
			var f_focused = true;

			if (typeof (djs_var['formbuilder_focused'][f_id]) == 'undefined') { f_focused = false; }
			else if (djs_var['formbuilder_focused'][f_id] == '') { f_focused = false; }

			if (f_focused)
			{
				if (djs_var['formbuilder_focused'][f_id] == 'undefined') { self.document.getElementById(f_id).style.borderColor = ''; }
				else { self.document.getElementById(f_id).style.borderColor = djs_var['formbuilder_focused'][f_id]; }

				djs_var['formbuilder_focused'][f_id] = '';
			}
			else
			{
				djs_var['formbuilder_focused'][f_id] = self.document.getElementById(f_id).style.borderColor;
				if (djs_var['formbuilder_focused'][f_id] == '') { djs_var['formbuilder_focused'][f_id] = 'undefined'; }

				self.document.getElementById(f_id).style.borderColor = djs_var['formbuilder_focused_color'];
				self.setTimeout ('djs_formbuilder_focused (\'' + f_id + '\')',djs_var['formbuilder_focused_timeout']);
			}
		}
	}
	}
}

function djs_formbuilder_select_change_size (f_name,f_size)
{
	if (djs_swgDOM)
	{
	// Only continue if the basic test had been completed successfully
	if (djs_swgDOM_elements_editable)
	{
		var f_temp_size = 0;

		if (f_size == '+')
		{
			f_temp_size = parseInt (self.document.getElementsByName(f_name)[0].getAttribute ('size'));
			if (f_temp_size) { self.document.getElementsByName(f_name)[0].setAttribute ('size',(f_temp_size + 1)); }
		}
		else if (f_size == '-')
		{
			f_temp_size = parseInt (self.document.getElementsByName(f_name)[0].getAttribute ('size'));

			if (f_temp_size)
			{
				if (f_temp_size > 1) { self.document.getElementsByName(f_name)[0].setAttribute ('size',(f_temp_size - 1)); }
			}
		}
		else
		{
			f_temp_size = parseInt (f_size);
			if (f_temp_size) { self.document.getElementsByName(f_name)[0].setAttribute ('size',f_temp_size); }
		}
	}
	}
}

djs_var['formbuilder_run_onsubmit'] = new Array ();

function djs_formbuilder_submit (f_id)
{
	var f_return = true;

	if (djs_var['formbuilder_run_onsubmit'][0])
	{
		for (var f_i = 0;f_i < djs_var['formbuilder_run_onsubmit'].length;f_i++)
		{
			if (f_return) { f_return = eval (djs_var['formbuilder_run_onsubmit'][f_i] + ';'); }
			else { eval (djs_var['formbuilder_run_onsubmit'][f_i] + ';'); }
		}
	}

	return f_return;
}

djs_var['formbuilder_tabindex'] = 0;

function djs_formbuilder_tabindex (f_id)
{
	if (djs_swgDOM)
	{
	// Only continue if the basic test had been completed successfully
	if (djs_swgDOM_elements_editable)
	{
		if (typeof (self.document.getElementById(f_id).getAttribute) == 'function')
		{
			djs_var['formbuilder_tabindex']++;
			if (typeof (self.document.getElementById(f_id).tabIndex) != 'undefined') { self.document.getElementById(f_id).tabIndex = djs_var['formbuilder_tabindex']; }
			else { self.document.getElementById(f_id).setAttribute ('tabindex',djs_var['formbuilder_tabindex']); }
		}
	}
	}
}

function djs_formbuilder_textarea_change_rows (f_name,f_size)
{
	if (djs_swgDOM)
	{
	// Only continue if the basic test had been completed successfully
	if (djs_swgDOM_elements_editable)
	{
		var f_temp_size = 0;

		if (f_size == '+')
		{
			f_temp_size = parseInt (self.document.getElementsByName(f_name)[0].getAttribute ('rows'));
			if (f_temp_size) { self.document.getElementsByName(f_name)[0].setAttribute ('rows',(f_temp_size + 1)); }
		}
		else if (f_size == '-')
		{
			f_temp_size = parseInt (self.document.getElementsByName(f_name)[0].getAttribute ('rows'));

			if (f_temp_size)
			{
				if (f_temp_size > 1) { self.document.getElementsByName(f_name)[0].setAttribute ('rows',(f_temp_size - 1)); }
			}
		}
		else
		{
			f_temp_size = parseInt (f_size);
			if (f_temp_size) { self.document.getElementsByName(f_name)[0].setAttribute ('rows',f_temp_size); }
		}
	}
	}
}

//j// EOF