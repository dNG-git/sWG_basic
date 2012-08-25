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

<?php $direct_globals['basic_functions']->includeFile ($direct_settings['path_mmedia']."/ext_djs/djs_storage.min.js"); ?>

if (djs_storage_handler != null)
{
	djs_var['core_swgStorage_lastvisit'] = djs_storage_get ('core_lastvisit');
	if ((djs_var.core_swgStorage_lastvisit != null)&&(djs_var.core_swgStorage_lastvisit != "<?php echo $direct_cachedata['kernel_lastvisit']; ?>")) { djs_storage_delete_all (); }
	djs_storage_set ("core_lastvisit","<?php echo $direct_cachedata['kernel_lastvisit']; ?>");
}

function djs_storage_new_check (f_id,f_id_parent,f_value)
{
	djs_var["swg_storage_new_" + f_id] = djs_storage_get ("swg_storage_new_" + f_id);
	var f_return = false;

	if ((djs_var["swg_storage_new_" + f_id] == null)||((djs_var["swg_storage_new_" + f_id] != "0")&&(djs_var["swg_storage_new_" + f_id] != f_value)))
	{
		if (djs_var["swg_storage_new_" + f_id] != "-1")
		{
			if (f_id_parent != null)
			{
				djs_var["swg_storage_new_" + f_id_parent +"_unread"] = djs_storage_get ("swg_storage_new_" + f_id_parent + "_unread");

				if (djs_var["swg_storage_new_" + f_id_parent +"_unread"] == null) { djs_storage_set ("swg_storage_new_" + f_id_parent +"_unread",'1'); }
				else
				{
					djs_var["swg_storage_new_" + f_id_parent +"_unread"] = parseInt (djs_var["swg_storage_new_" + f_id_parent +"_unread"]);
					djs_var["swg_storage_new_" + f_id_parent +"_unread"]++;
					djs_storage_set ("swg_storage_new_" + f_id_parent +"_unread",(djs_var["swg_storage_new_" + f_id_parent +"_unread"].toString ()));
				}
			}

			djs_storage_set ("swg_storage_new_" + f_id,"-1");
		}

		f_return = true;
	}

	return f_return;
}

function djs_storage_new_read (f_id,f_id_parent,f_value)
{
	djs_var["swg_storage_new_" + f_id] = djs_storage_get ("swg_storage_new_" + f_id);

	if ((djs_var["swg_storage_new_" + f_id] == null)||(djs_var["swg_storage_new_" + f_id] != f_value)) { var f_continue_check = true; }
	else { var f_continue_check = false; }

	if (f_continue_check)
	{
		if (f_id_parent != null)
		{
			if (djs_var["swg_storage_new_" + f_id] == "-1")
			{
				djs_var["swg_storage_new_" + f_id_parent +"_unread"] = djs_storage_get ("swg_storage_new_" + f_id_parent + "_unread");

				if (djs_var["swg_storage_new_" + f_id_parent +"_unread"] != null)
				{
					djs_var["swg_storage_new_" + f_id_parent +"_unread"] = parseInt (djs_var["swg_storage_new_" + f_id_parent +"_unread"]);
					djs_var["swg_storage_new_" + f_id_parent +"_unread"]--;
					if (djs_var["swg_storage_new_" + f_id_parent +"_unread"] < 0) { djs_var["swg_storage_new_" + f_id_parent +"_unread"] = 0; }
					djs_storage_set ("swg_storage_new_" + f_id_parent +"_unread",(djs_var["swg_storage_new_" + f_id_parent +"_unread"].toString ()));
				}
				else { djs_storage_set ("swg_storage_new_" + f_id +"_unread","0"); }
			}
			else if (djs_var["swg_storage_new_" + f_id] != null)
			{
				djs_var["swg_storage_new_" + f_id_parent] = djs_storage_get ("swg_storage_new_" + f_id_parent);

				if ((djs_var["swg_storage_new_" + f_id_parent] != null)&&(djs_var["swg_storage_new_" + f_id_parent] != "-1"))
				{
					djs_var["swg_storage_new_" + f_id_parent] = parseInt (djs_var["swg_storage_new_" + f_id_parent]);
					djs_var["swg_storage_new_" + f_id_parent] += (f_value - (parseInt (djs_var["swg_storage_new_" + f_id])));
					djs_storage_set ("swg_storage_new_" + f_id_parent,(djs_var["swg_storage_new_" + f_id_parent].toString ()));
				}
			}
		}

		djs_storage_set ("swg_storage_new_" + f_id,f_value);
	}
}

function djs_storage_new_unread_check (f_id,f_unread_counter,f_value)
{
	djs_var["swg_storage_new_" + f_id] = djs_storage_get ("swg_storage_new_" + f_id);

	if (f_unread_counter) { djs_var["swg_storage_new_" + f_id + "_unread"] = djs_storage_get ("swg_storage_new_" + f_id + "_unread"); }

	if ((!f_unread_counter)||(djs_var["swg_storage_new_" + f_id + "_unread"] == null)) { f_unread_counter = "0"; }
	else { f_unread_counter = djs_var["swg_storage_new_" + f_id + "_unread"]; }

	if (djs_var["swg_storage_new_" + f_id] == null)
	{
		if ((djs_var["swg_storage_new_" + f_id + "_unread"] != null)&&(djs_var["swg_storage_new_" + f_id + "_unread"] != "0"))
		{
			f_value -= parseInt (djs_var["swg_storage_new_" + f_id + "_unread"]);
			if (f_value < 0) { f_value = 0; }
			f_value = f_value.toString ();
		}

		djs_storage_set ("swg_storage_new_" + f_id,f_value);
		djs_var["swg_storage_new_" + f_id] = "0";
	}

	if ((djs_var["swg_storage_new_" + f_id] != f_value)||(f_unread_counter != "0")) { return true; }
	else { return false; }
}

//j// EOF