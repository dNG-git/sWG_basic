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
$Id: swg_formtags.php,v 1.6 2008/12/20 11:23:19 s4u Exp $
#echo(sWGbasicVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* FormTags are an enhanced form of BBCodes.
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
* @subpackage formtags
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
if (defined ("CLASS_direct_formtags")) { $g_continue_check = false; }
if (!defined ("CLASS_direct_virtual_class")) { $g_continue_check = false; }

if ($g_continue_check)
{
//c// direct_formtags
/**
* This FormTags class provides all important functions to decode, encode and
* filter FormTags. Furthermore it's extendible.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage formtags
* @uses       CLASS_direct_virtual_class
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_formtags extends direct_virtual_class
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_formtags->__construct () and direct_formtags->direct_formtags ()
/**
	* Constructor (PHP5) __construct (direct_formtags)
	*
	* @uses  direct_debug()
	* @uses  direct_local_integration()
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags_class->__construct (direct_formtags)- (#echo(__LINE__)#)"); }

		direct_local_integration ("formtags");

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['cleanup'] = true;
		$this->functions['decode'] = true;
		$this->functions['encode'] = true;
		$this->functions['recode_newlines'] = true;
		$this->functions['tree_changer_simple'] = true;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_formtags (direct_formtags)
	*
	* @since v0.1.00
*\/
	function direct_formtags () { $this->__construct (); }
:#*/
	//f// direct_formtags->cleanup ($f_data,$f_break_urls = false)
/**
	* Removes FormTags from a given string.
	*
	* @param  string $f_data Input string containing FormTags
	* @param  boolean $f_break_urls True for changing URLs to be shorter (but not
	*                 usable anymore)
	* @uses   direct_debug()
	* @uses   direct_formtags::tree_changer_rule_based()
	* @uses   direct_local_get()
	* @uses   USE_debug_reporting
	* @return string Filtered string
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function cleanup ($f_data,$f_break_urls = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags_class->cleanup (+f_data,+f_break_urls)- (#echo(__LINE__)#)"); }

		$f_return =& $f_data;
		$f_data = str_replace ((array ("\r","\n")),"",$f_data);

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[sourcecode]") !== false) { $this->tree_changer_rule_based ($f_data,"cleanup:sourcecode"); }

		$f_data = str_replace ("[br]","\n",$f_data);
		$f_data = str_replace ("[newline]","\n",$f_data);

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[contentform") !== false)
		{
			$f_data = preg_replace ("#\[contentform(.*?)\]#i","",$f_data);
			$f_data = str_replace ("[/contentform]","\n",$f_data);
		}

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[font") !== false)
		{
			$f_data = preg_replace ("#\[font(.*?)\]#i","",$f_data);
			$f_data = str_replace ("[/font]","",$f_data);
		}

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[hr]") !== false) { $f_data = str_replace ("[hr]","---\n",$f_data); }

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[quote") !== false)
		{
			if ($f_break_urls) { $f_data = preg_replace ("#\[quote(.*?)\](.+?)\[\/quote\]#si","\n* ".(direct_local_get ("formtags_quote_1","text")).":\n\\2\n*\n",$f_data); }
			else { $this->tree_changer_rule_based ($f_data,"cleanup:quote"); }
		}

		$this->tree_changer_simple ($f_data,"[sources]","\n* ".(direct_local_get ("formtags_sources","text")).":\n","[/sources]","\n*\n");

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[rewrite") !== false) { $this->tree_changer_rule_based ($f_data,"cleanup:rewrite"); }

		if ($f_break_urls)
		{
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[img") !== false) { $f_data = preg_replace ("#\[img(.*?)\](.+?)\[\/img\]#si"," *".(direct_local_get ("formtags_image","text"))."* ",$f_data); }

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[url:anchor:") !== false) { $f_data = preg_replace ("#\[url\:anchor\:(.+?)\]#i","",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[url") !== false) { $f_data = preg_replace ("#\[url(.*?)\](.+?)\[\/url\]#i"," *".(direct_local_get ("formtags_url","text"))."* ",$f_data); }
		}
		else
		{
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[img") !== false) { $f_data = preg_replace ("#\[img(.*?)\](.+?)\[\/img\]#si","\n* ".(direct_local_get ("formtags_image","text")).":\n\\1\n*\n",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[url") !== false) { $this->tree_changer_rule_based ($f_data,"cleanup:url"); }
		}

		$f_data = str_replace ((array ("&lt;","&gt;","&quot;")),(array ("<",">",'"')),$f_data);
		$f_data = trim ($f_data);

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[-") !== false) { $this->tree_changer_rule_based ($f_data,"cleanup:lists"); }

		return $f_return;
	}

	//f// direct_formtags->decode ($f_data)
/**
	* Converts all FormTags into valid XHTML 1.0 code.
	*
	* @param  string $f_data Input string containing FormTags
	* @uses   direct_debug()
	* @uses   direct_formtags::tree_changer_rule_based()
	* @uses   direct_formtags::tree_changer_simple()
	* @uses   direct_html_get()
	* @uses   USE_debug_reporting
	* @return string Filtered string containing XHTML code
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function decode ($f_data)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags_class->decode (+f_data)- (#echo(__LINE__)#)"); }

		$f_return =& $f_data;
		$f_data = direct_html_encode_special ($f_data);

		$f_data = str_replace ((array ("\r","\n")),"",$f_data);

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[sourcecode]") !== false) { $this->tree_changer_rule_based ($f_data,"decode:sourcecode"); }

		$this->tree_changer_simple ($f_data,"[contentform:align:left]","<span style='display:block;text-align:left'>","[/contentform]","</span>");
		$this->tree_changer_simple ($f_data,"[contentform:align:center]","<span style='display:block;text-align:center'>","[/contentform]","</span>");
		$this->tree_changer_simple ($f_data,"[contentform:align:right]","<span style='display:block;text-align:right'>","[/contentform]","</span>");
		$this->tree_changer_simple ($f_data,"[contentform:align:block]","<span style='display:block;text-align:justify'>","[/contentform]","</span>");
		$this->tree_changer_simple ($f_data,"[contentform:highlight]","<span class='pagehighlightborder2' style='display:block'><span class='pagecontent'>","[/contentform]","</span></span>");
		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[contentform:box:") !== false) { $this->tree_changer_rule_based ($f_data,"decode:contentform:box"); }
		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[contentform:colorbox:") !== false) { $this->tree_changer_rule_based ($f_data,"decode:contentform:colorbox"); }
		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[contentform:hidden:") !== false) { $this->tree_changer_rule_based ($f_data,"decode:contentform:hidden"); }
		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[contentform:lineheight:") !== false) { $this->tree_changer_rule_based ($f_data,"decode:contentform:lineheight"); }
		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[contentform:spacerbox:") !== false) { $this->tree_changer_rule_based ($f_data,"decode:contentform:spacerbox"); }
		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[contentform:textindent:") !== false) { $this->tree_changer_rule_based ($f_data,"decode:contentform:textindent"); }

		$this->tree_changer_simple ($f_data,"[font:bold]","<span style='font-weight:bold'>","[/font]","</span>");
		$this->tree_changer_simple ($f_data,"[font:italic]","<span style='font-style:italic'>","[/font]","</span>");
		$this->tree_changer_simple ($f_data,"[font:overline]","<span style='text-decoration:overline'>","[/font]","</span>");
		$this->tree_changer_simple ($f_data,"[font:strike]","<span style='text-decoration:line-through'>","[/font]","</span>");
		$this->tree_changer_simple ($f_data,"[font:underline]","<span style='text-decoration:underline'>","[/font]","</span>");
		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[font:color:") !== false) { $this->tree_changer_rule_based ($f_data,"decode:font:color"); }
		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[font:face:") !== false) { $this->tree_changer_rule_based ($f_data,"decode:font:face"); }
		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[font:size:") !== false) { $this->tree_changer_rule_based ($f_data,"decode:font:size"); }

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[hr]") !== false) { $f_data = str_replace ("[hr]","<span class='pagehr' style='display:block;$direct_settings[theme_hr_style]'><img src='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/spacer.png",true,false))."' width='1' height='1' alt='' title='' style='float:left' /></span>",$f_data); }

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[img") !== false) { $this->tree_changer_rule_based ($f_data,"decode:img"); }

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[quote") !== false) { $this->tree_changer_rule_based ($f_data,"decode:quote"); }
		$this->tree_changer_simple ($f_data,"[sources]","<span style='$direct_settings[formtags_sources_style]'><span class='pagecontent'><span style='$direct_settings[formtags_sources_title_style]'>".(direct_html_encode_special (direct_local_get ("formtags_sources","text"))).":</span> ","[/sources]","</span></span>");

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[rewrite") !== false) { $this->tree_changer_rule_based ($f_data,"decode:rewrite"); }
		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[url") !== false) { $this->tree_changer_rule_based ($f_data,"decode:url"); }

		if (preg_match_all ("#(\[|\])(\w{3,5})\:\/\/(.+?)(\[|\])#i",$f_data,$f_result_array,PREG_SET_ORDER))
		{
			foreach ($f_result_array as $f_url_array) { $f_data = str_replace ($f_url_array[0],($f_url_array[1]."<a href=\"{$f_url_array[2]}://{$f_url_array[3]}\" target='_blank' rel='nofollow'>".(direct_linker ("optical",$f_url_array[2]."://".$f_url_array[3]))."</a>".$f_url_array[4]),$f_data); }
		}

		$f_data = str_replace ("&lt;","<",$f_data);
		$f_data = str_replace ("&gt;",">",$f_data);
		$f_data = preg_replace ("#\&amp;(\w{2,4});#i","&\\1;",$f_data);

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[-") !== false)
		{
			$this->tree_changer_simple ($f_data,"[--]","<span style='$direct_settings[formtags_list_item_style]'>-</span><span style='$direct_settings[formtags_list_content_style]'>","[/--]","</span>");
			$this->tree_changer_simple ($f_data,"[-<]","<span style='$direct_settings[formtags_list_item_style]'>&#0060;</span><span style='$direct_settings[formtags_list_content_style]'>","[/-<]","</span>");
			$this->tree_changer_simple ($f_data,"[-<<]","<span style='$direct_settings[formtags_list_item_style]'>&#0171;</span><span style='$direct_settings[formtags_list_content_style]'>","[/-<<]","</span>");
			$this->tree_changer_simple ($f_data,"[->]","<span style='$direct_settings[formtags_list_item_style]'>&#0062;</span><span style='$direct_settings[formtags_list_content_style]'>","[/->]","</span>");
			$this->tree_changer_simple ($f_data,"[->>]","<span style='$direct_settings[formtags_list_item_style]'>&#0187;</span><span style='$direct_settings[formtags_list_content_style]'>","[/->>]","</span>");
			$this->tree_changer_simple ($f_data,"[-o]","<span style='$direct_settings[formtags_list_item_style]'>&#0176;</span><span style='$direct_settings[formtags_list_content_style]'>","[/-o]","</span>");
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[-+") !== false) { $this->tree_changer_rule_based ($f_data,"decode:varlist"); }
		}

		$f_data = str_replace ("[br]","<br />\n",$f_data);
		$f_data = str_replace ("[newline]","<br />\n",$f_data);

		$f_data = trim ($f_data);

		return $f_return;
	}

	//f// direct_formtags->encode ($f_data,$f_withhtml = false,$f_withftg = true)
/**
	* Converts BBCode to FormTags and filters HTML and or simple HTML statements
	* for links or images.
	*
	* @param  string $f_data Input string
	* @param  boolean $f_withhtml True to not remove HTML tags
	* @param  boolean $f_withftg True for allowing FormTags in the input string
	* @uses   direct_debug()
	* @uses   direct_html_encode_special()
	* @uses   USE_debug_reporting
	* @return string Filtered string containing FormTags
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function encode ($f_data,$f_withhtml = false,$f_withftg = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags_class->encode (+f_data,+f_withhtml,+f_withftg)- (#echo(__LINE__)#)"); }

		$f_return =& $f_data;
		$f_data = direct_html_encode_special ($f_data);

		$f_data = str_replace ((array ("[newline]","\r","&amp;")),(array ("\n","","&")),$f_data);

		if (($f_withhtml)||($f_withftg))
		{
			$f_data = str_replace ((array ("&lt;","&gt;","&quot;")),(array ("<",">",'"')),$f_data);

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[b]") !== false) { $f_data = preg_replace ("#\[b\](.+?)\[\/b\]#si","[font:bold]\\1[/font]",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[code]") !== false) { $f_data = preg_replace ("#\[code\](.+?)\[\/code\]#si","[sourcecode]\\1[/sourcecode]",$f_data); }

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[color=") !== false)
			{
				$f_data = preg_replace ("#\[color\=black\](.+?)\[\/color\]#si","[font:color:000000]\\1[/font]",$f_data);
				$f_data = preg_replace ("#\[color\=gray\](.+?)\[\/color\]#si","[font:color:808080]\\1[/font]",$f_data);
				$f_data = preg_replace ("#\[color\=maroon\](.+?)\[\/color\]#si","[font:color:800000]\\1[/font]",$f_data);
				$f_data = preg_replace ("#\[color\=red\](.+?)\[\/color\]#si","[font:color:FF0000]\\1[/font]",$f_data);
				$f_data = preg_replace ("#\[color\=green\](.+?)\[\/color\]#si","[font:color:008000]\\1[/font]",$f_data);
				$f_data = preg_replace ("#\[color\=lime\](.+?)\[\/color\]#si","[font:color:00FF00]\\1[/font]",$f_data);
				$f_data = preg_replace ("#\[color\=olive\](.+?)\[\/color\]#si","[font:color:808000]\\1[/font]",$f_data);
				$f_data = preg_replace ("#\[color\=yellow\](.+?)\[\/color\]#si","[font:color:FFFF00]\\1[/font]",$f_data);
				$f_data = preg_replace ("#\[color\=navy\](.+?)\[\/color\]#si","[font:color:000080]\\1[/font]",$f_data);
				$f_data = preg_replace ("#\[color\=blue\](.+?)\[\/color\]#si","[font:color:0000FF]\\1[/font]",$f_data);
				$f_data = preg_replace ("#\[color\=purple\](.+?)\[\/color\]#si","[font:color:800080]\\1[/font]",$f_data);
				$f_data = preg_replace ("#\[color\=fuchsia\](.+?)\[\/color\]#si","[font:color:FF00FF]\\1[/font]",$f_data);
				$f_data = preg_replace ("#\[color\=teal\](.+?)\[\/color\]#si","[font:color:008080]\\1[/font]",$f_data);
				$f_data = preg_replace ("#\[color\=aqua\](.+?)\[\/color\]#si","[font:color:00FFFF]\\1[/font]",$f_data);
				$f_data = preg_replace ("#\[color\=silver\](.+?)\[\/color\]#si","[font:color:C0C0C0]\\1[/font]",$f_data);
				$f_data = preg_replace ("#\[color\=white\](.+?)\[\/color\]#si","[font:color:FFFFFF]\\1[/font]",$f_data);

				$f_data = preg_replace ("#\[color\=\#(\w{6})\](.+?)\[\/color\]#si","[font:color:\\1]\\2[/font]",$f_data);
			}

			$f_data = str_replace ((array ("[font:b]","[font:i]","[font:o]","[font:s]","[font:u]")),(array ("[font:bold]","[font:italic]","[font:overline]","[font:strike]","[font:underline]")),$f_data);
		
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[hidden]") !== false) { $f_data = preg_replace ("#\[hidden=(.+?)\](.+?)\[\/hidden\]#si","[contentform:hidden:\\1]\\2[/contentform]",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[highlight]") !== false) { $f_data = preg_replace ("#\[highlight\](.+?)\[\/highlight\]#si","[contentform:highlight]\\1[/contentform]",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[i]") !== false) { $f_data = preg_replace ("#\[i\](.+?)\[\/i\]#si","[font:italic]\\1[/font]",$f_data); }

			$f_data = str_replace ("[sc]","[sourcecode]",$f_data);
			$f_data = str_replace ("[/sc]","[/sourcecode]",$f_data);

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[size=") !== false) { $f_data = preg_replace ("#\[size\=(\d{1,3})\](.+?)\[\/size\]#si","[font:size:\\1]\\2[/font]",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[u]") !== false) { $f_data = preg_replace ("#\[u\](.+?)\[\/u\]#si","[font:underline]\\1[/font]",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[url]") !== false) { $f_data = preg_replace ("#\[url\](.+?)\[\/url\]#i","\\1",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[url=") !== false) { $f_data = preg_replace ("#\[url\=(.+?)\]#si","[url:\\1]",$f_data); }

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"<a ") !== false) { $f_data = preg_replace ("#\<a(.*?)href=(\"|\')(\w{3,5})\:\/\/(.+?)(\"|\')(.*?)\>(.+?)\<\/a\>#si","[url:\\3://\\4]\\7[/url]",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"<b>") !== false) { $f_data = preg_replace ("#\<b\>(.+?)\<\/b\>#si","[font:bold]\\1[/font]",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"<br") !== false) { $f_data = preg_replace ("#\<br([ \/]{0,2})\>#si","[br]",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"<i>") !== false) { $f_data = preg_replace ("#\<i\>(.+?)\<\/i\>#si","[font:italic]\\1[/font]",$f_data); }

			if (preg_match_all ("#\<img (.*?)\>#i",$f_data,$f_result_array,PREG_SET_ORDER))
			{
				foreach ($f_result_array as $f_img_array)
				{
					if (preg_match ("#src=(\"|\')(.+?)(\"|\')#i",$f_img_array[1],$f_url_array))
					{
						if (preg_match ("#(alt|title)=(\"|\')(.+?)(\"|\')#i",$f_img_array[1],$f_title_result_array)) { $f_data = str_replace ($f_img_array[0],("[img][img:title]{$f_title_result_array[2]}[/img:title]{$f_url_array[2]}[/img]"),$f_data); }
						else { $f_data = str_replace ($f_img_array[0],("[img]{$f_url_array[2]}[/img]"),$f_data); }
					}
				}
			}

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"<p") !== false) { $f_data = preg_replace ("#\<p(.*?)>(.+?)</p>#si","[newline][newline]\\2",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"<s>") !== false) { $f_data = preg_replace ("#\<s\>(.+?)\<\/s\>#si","[font:strike]\\1[/font]",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"<u>") !== false) { $f_data = preg_replace ("#\<u\>(.+?)\<\/u\>#si","[font:underline]\\1[/font]",$f_data); }

			if (preg_match_all ("#( |\(|\)|;|,|^)(\w{3,5})\:\/\/(.+?)( |\(|\)|\[|\]|,|$)#im",$f_data,$f_result_array,PREG_SET_ORDER))
			{
				foreach ($f_result_array as $f_url_array) { $f_data = str_replace ($f_url_array[0],($f_url_array[1]."[url:{$f_url_array[2]}://{$f_url_array[3]}]".(direct_linker ("optical",$f_url_array[2]."://".$f_url_array[3]))."[/url]".$f_url_array[4]),$f_data); }
			}

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[url:javascript:") !== false) { $f_data = preg_replace ("#\[url:javascript:(.+?)\](.+?)\[\/url\]#si","\\2",$f_data); }

			if (!$f_withhtml)
			{
				$f_data = str_replace ((array ("<",">")),(array ("&lt;","&gt;")),$f_data);
				$f_data = str_replace ((array ("[-&lt;]","[-&lt;&lt;]","[-&gt;]","[-&gt;&gt;]")),(array ("[-<]","[-<<]","[->]","[->>]")),$f_data);
			}
		}

		$f_data = str_replace ("\n","[newline]",$f_data);
		$f_data = trim ($f_data);

		return $f_return;
	}

	//f// direct_formtags->recode_newlines ($f_data,$f_brmode = true)
/**
	* Converts newline tags ("[newline]" and "[br]") into "br" tags or "\n".
	*
	* @param  string $f_data Input string
	* @param  boolean $f_withhtml True for using the HTML "<br />" tag
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Filtered string
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function recode_newlines ($f_data,$f_brmode = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags_class->recode_newlines (+f_data,$f_brmode)- (#echo(__LINE__)#)"); }

		$f_return =& $f_data;

		if ($f_brmode) { $f_newline = "<br />\n"; }
		else { $f_newline = "\n"; }

		$f_data = str_replace ("[newline]",$f_newline,$f_data);
		$f_data = trim ($f_data);

		return $f_return;
	}

	//f// direct_formtags->tree_changer_rule_based (&$f_data,$f_rule)
/**
	* Converts FormTags rule-based into valid XHTML 1.0 code.
	*
	* @param string &$f_data String that contains convertable data
	* @param string $f_rule Name of the rule that should be used
	* @uses  direct_basic_functions::datetime()
	* @uses  direct_debug()
	* @uses  direct_linker_get()
	* @uses  direct_local_get()
	* @uses  USE_debug_reporting
	* @link  http://www.direct-netware.de/redirect.php?swg;handbooks;dev;formtagrules
	*        Click here to get a list of available rules
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function tree_changer_rule_based (&$f_data,$f_rule)
	{
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags_class->tree_changer_rule_based (+f_data,$f_rule)- (#echo(__LINE__)#)"); }

		$f_tag_start = "";
		$f_tag_end = "";

		switch ($f_rule)
		{
		case "cleanup:lists":
		{
			$f_tag_start = "\[-(.+?)\]";
			$f_tag_end = "[/-(.+?)]";
			break 1;
		}
		case "cleanup:quote":
		{
			$f_tag_start = "\[quote(.*?)\]";
			$f_tag_end = "[/quote]";
			break 1;
		}
		case "cleanup:rewrite":
		{
			if (preg_match_all ("#\[rewrite\:edit\:(.+?)\:(.+?)\:(.+?)\]#i",$f_data,$f_result_array,PREG_SET_ORDER))
			{
				foreach ($f_result_array as $f_result_item_array)
				{
					$f_datetime = $direct_classes['basic_functions']->datetime ("shortdate&time",$f_result_item_array[1],$direct_settings['user']['timezone'],(direct_local_get ("formtags_edit_2","text")));
					$f_data = str_replace ($f_result_item_array[0],"\n* ".(direct_local_get ("formtags_edit_1","text")).$f_datetime.(direct_local_get ("formtags_edit_3","text")).$f_result_item_array[3]." ({$f_result_item_array[2]})".(direct_local_get ("formtags_edit_4","text"))." *\n",$f_data);
				}
			}

			if (preg_match_all ("#\[rewrite\:elink\:(.+?)\]#i",$f_data,$f_result_array,PREG_SET_ORDER))
			{
				foreach ($f_result_array as $f_result_item_array) { $f_data = str_replace ($f_result_item_array[0],(direct_linker ("url1",$f_result_item_array[1],false,false)),$f_data); }
			}

			if (preg_match_all ("#\[rewrite\:ilink\:(.+?)\]#i",$f_data,$f_result_array,PREG_SET_ORDER))
			{
				foreach ($f_result_array as $f_result_item_array) { $f_data = str_replace ($f_result_item_array[0],(direct_linker ("url0",$f_result_item_array[1],false)),$f_data); }
			}

			if (preg_match_all ("#\[rewrite\:local\:(.+?)\]#i",$f_data,$f_result_array,PREG_SET_ORDER))
			{
				foreach ($f_result_array as $f_result_item_array) { $f_data = str_replace ($f_result_item_array[0],(direct_local_get ($f_result_item_array[1],"text")),$f_data); }
			}

			if (preg_match_all ("#\[rewrite\:related\:(.+?)\]#i",$f_data,$f_result_array,PREG_SET_ORDER))
			{
				foreach ($f_result_array as $f_result_item_array)
				{
					$f_result_item_array[1] = $direct_classes['basic_functions']->inputfilter_filepath ($f_result_item_array[1]);

					$direct_cachedata['formtags_related_data'] = NULL;
					if ((direct_output_related_manager ($f_result_item_array[1],"formtags_cleanup_action",true))&&($direct_cachedata['formtags_related_data'] !== NULL)) { $f_data = str_replace ($f_result_item_array[0],$direct_cachedata['formtags_related_data'],$f_data); }
				}
			}

			$f_data = preg_replace ("#\[rewrite\:(.+?)\]#i","",$f_data);

			break 1;
		}
		case "cleanup:sourcecode":
		{
			$f_data_array = explode ("[sourcecode]",$f_data);
			$f_occurrences = (count ($f_data_array) - 1);

			for ($f_i = $f_occurrences;$f_i > 0;$f_i--)
			{
				$f_data_closed_array = explode ("[/sourcecode]",$f_data_array[$f_i],3);
				unset ($f_data_array[$f_i]);

				$f_data_closed_elements = (count ($f_data_closed_array) - 1);

				if ($f_data_closed_elements == 1)
				{
					$f_tag_content = $f_data_closed_array[0];
					$f_tag_content = str_replace ("[","&#91;",$f_tag_content);
					$f_tag_content = str_replace ("]","&#93;",$f_tag_content);
					$f_tag_content = str_replace ("&#91;br&#93;","\n",$f_tag_content);
					$f_tag_content = str_replace ("&#91;newline&#93;","\n",$f_tag_content);

					$f_data_closed = $f_data_closed_array[1];

					$f_data_array[($f_i - 1)] .= "\n* ".(direct_local_get ("formtags_sourcecode","text")).":\n$f_tag_content\n*\n".$f_data_closed;
				}
				elseif ($f_data_closed_elements)
				{
					$f_tag_content = $f_data_closed_array[0];
					unset ($f_data_closed_array[0]);
					$f_data_array[($f_i - 1)] .= "&#91;sourcecode&#93;$f_tag_content&#91;/sourcecode&#93;".(implode ("[/sourcecode]",$f_data_closed_array));
				}
				else { $f_data_array[($f_i - 1)] .= $f_data_closed_array[0]; }
			}

			$f_data = $f_data_array[0];
			break 1;
		}
		case "cleanup:url":
		{
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[url:anchor:") !== false) { $f_data = preg_replace ("#\[url:anchor:(.+?)\]#i","",$f_data); }

			$f_tag_start = "\[url(.*?)\]";
			$f_tag_end = "[/url]";
			break 1;
		}
		case "decode:contentform:box":
		{
			$f_tag_start = "\[contentform:box:(.+?)\]";
			$f_tag_end = "[/contentform]";
			break 1;
		}
		case "decode:contentform:colorbox":
		{
			$f_tag_start = "\[contentform:colorbox(.*?)\]";
			$f_tag_end = "[/contentform]";
			break 1;
		}
		case "decode:contentform:hidden":
		{
			$f_tag_start = "\[contentform:hidden:(.+?)\]";
			$f_tag_end = "[/contentform]";
			break 1;
		}
		case "decode:contentform:lineheight":
		{
			$f_tag_start = "\[contentform:lineheight:(\d{1,3})\]";
			$f_tag_end = "[/contentform]";
			break 1;
		}
		case "decode:contentform:spacerbox":
		{
			$f_tag_start = "\[contentform:spacerbox:(.+?)\]";
			$f_tag_end = "[/contentform]";
			break 1;
		}
		case "decode:contentform:textindent":
		{
			$f_tag_start = "\[contentform:textindent:(\d{1,3})\]";
			$f_tag_end = "[/contentform]";
			break 1;
		}
		case "decode:font:color":
		{
			$f_tag_start = "\[font:color:(\w{6})\]";
			$f_tag_end = "[/font]";
			break 1;
		}
		case "decode:font:face":
		{
			$f_tag_start = "\[font:face:([a-zA-Z0-9 ,]+)\]";
			$f_tag_end = "[/font]";
			break 1;
		}
		case "decode:font:size":
		{
			$f_tag_start = "\[font:size:(\d{1,3})\]";
			$f_tag_end = "[/font]";
			break 1;
		}
		case "decode:img":
		{
			$f_tag_start = "\[img(.*?)\]";
			$f_tag_end = "[/img]";
			break 1;
		}
		case "decode:quote":
		{
			$f_tag_start = "\[quote(.*?)\]";
			$f_tag_end = "[/quote]";
			break 1;
		}
		case "decode:rewrite":
		{
			if (preg_match_all ("#\[rewrite\:edit\:(.+?)\:(.+?)\:(.+?)\]#i",$f_data,$f_result_array,PREG_SET_ORDER))
			{
				foreach ($f_result_array as $f_result_item_array)
				{
					$f_datetime = $direct_classes['basic_functions']->datetime ("shortdate&time",$f_result_item_array[1],$direct_settings['user']['timezone'],(direct_local_get ("formtags_edit_2","text")));
					$f_user_profile = direct_linker ("url1","m=account&s=profile&a=view&dsd=auid+".$f_result_item_array[2]);
					$f_data = str_replace ($f_result_item_array[0],("<br /><span style='$direct_settings[formtags_edit_style]'>".(direct_local_get ("formtags_edit_1","text")).$f_datetime.(direct_local_get ("formtags_edit_3","text"))."<a href='$f_user_profile' target='_self'>{$f_result_item_array[3]}</a>".(direct_local_get ("formtags_edit_4","text"))."</span>"),$f_data);
				}
			}

			if (preg_match_all ("#\[rewrite\:elink\:(.+?)\]#i",$f_data,$f_result_array,PREG_SET_ORDER))
			{
				foreach ($f_result_array as $f_result_item_array) { $f_data = str_replace ($f_result_item_array[0],(direct_linker ("url1",$f_result_item_array[1],true,false)),$f_data); }
			}

			if (preg_match_all ("#\[rewrite\:ilink\:(.+?)\]#i",$f_data,$f_result_array,PREG_SET_ORDER))
			{
				foreach ($f_result_array as $f_result_item_array) { $f_data = str_replace ($f_result_item_array[0],(direct_linker ("url0",$f_result_item_array[1])),$f_data); }
			}

			if (preg_match_all ("#\[rewrite\:local\:(.+?)\]#i",$f_data,$f_result_array,PREG_SET_ORDER))
			{
				foreach ($f_result_array as $f_result_item_array) { $f_data = str_replace ($f_result_item_array[0],(direct_local_get ($f_result_item_array[1],"text")),$f_data); }
			}

			if (preg_match_all ("#\[rewrite\:related\:(.+?)\]#i",$f_data,$f_result_array,PREG_SET_ORDER))
			{
				foreach ($f_result_array as $f_result_item_array)
				{
					$f_result_item_array[1] = $direct_classes['basic_functions']->inputfilter_filepath ($f_result_item_array[1]);

					$direct_cachedata['formtags_related_data'] = NULL;
					if ((direct_output_related_manager ($f_result_item_array[1],"formtags_decode_action",true))&&($direct_cachedata['formtags_related_data'] !== NULL)) { $f_data = str_replace ($f_result_item_array[0],$direct_cachedata['formtags_related_data'],$f_data); }
				}
			}

			break 1;
		}
		case "decode:sourcecode":
		{
			$f_data_array = explode ("[sourcecode]",$f_data);
			$f_occurrences = (count ($f_data_array) - 1);

			for ($f_i = $f_occurrences;$f_i > 0;$f_i--)
			{
				$f_data_closed_array = explode ("[/sourcecode]",$f_data_array[$f_i],3);
				unset ($f_data_array[$f_i]);

				$f_data_closed_elements = (count ($f_data_closed_array) - 1);

				if ($f_data_closed_elements == 1)
				{
					$f_tag_content = $f_data_closed_array[0];
					$f_tag_content = str_replace ("[","&#91;",$f_tag_content);
					$f_tag_content = str_replace ("]","&#93;",$f_tag_content);
					$f_tag_content = str_replace ("&#91;br&#93;","\n",$f_tag_content);
					$f_tag_content = str_replace ("&#91;newline&#93;","\n",$f_tag_content);

					$f_data_closed = $f_data_closed_array[1];

					$f_data_array[($f_i - 1)] .= "<span style='display:block;overflow:auto;padding:5px;text-align:left;white-space:pre' class='pageborder2'><span class='pagecontent' style='font-family:\"Courier New\",Courier,mono'>$f_tag_content</span></span>".$f_data_closed;
				}
				elseif ($f_data_closed_elements)
				{
					$f_tag_content = $f_data_closed_array[0];
					unset ($f_data_closed_array[0]);
					$f_data_array[($f_i - 1)] .= "&#91;sourcecode&#93;$f_tag_content&#91;/sourcecode&#93;".(implode ("[/sourcecode]",$f_data_closed_array));
				}
				else { $f_data_array[($f_i - 1)] .= $f_data_closed_array[0]; }
			}

			$f_data = $f_data_array[0];
			break 1;
		}
		case "decode:url":
		{
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[url:anchor:") !== false) { $f_data = preg_replace ("#\[url:anchor:(.+?)\]#i","<a id=\"\\1\" name=\"\\1\"></a>",$f_data); }

			$f_tag_start = "\[url(.*?)\]";
			$f_tag_end = "[/url]";
			break 1;
		}
		case "decode:varlist":
		{
			$f_tag_start = "\[-\+(.*?)\]";
			$f_tag_end = "[/-+]";
			break 1;
		}
		}

		if (($f_tag_start)&&($f_tag_end))
		{
			preg_match_all ("#$f_tag_start#i",$f_data,$f_result_array,PREG_PATTERN_ORDER);
			$f_result_array = $f_result_array[1];

			$f_data_array = preg_split ("#$f_tag_start#i",$f_data);
			$f_occurrences = (count ($f_data_array) - 1);

			for ($f_i = $f_occurrences;$f_i > 0;$f_i--)
			{
				$f_data_closed_elements = explode ($f_tag_end,$f_data_array[$f_i],2);
				unset ($f_data_array[$f_i]);

				if (count ($f_data_closed_elements) > 1)
				{
					$f_tag_content = $f_data_closed_elements[0];
					unset ($f_data_closed_elements[0]);
					$f_data_closed = implode ($f_tag_end,$f_data_closed_elements);

					switch ($f_rule)
					{
					case "cleanup:lists":
					{
						$f_data_array[($f_i - 1)] .= "\n- ".$f_tag_content.$f_data_closed;
						break 1;
					}
					case "cleanup:quote":
					{
						if ($f_result_array[($f_i - 1)])
						{
							$f_quote_result_array = explode (":",$f_result_array[($f_i - 1)],3);

							if ($f_quote_result_array[2]) { $f_data_array[($f_i - 1)] .= "\n* ".(direct_local_get ("formtags_quote_2_1","text")).$f_quote_result_array[2]." ({$f_quote_result_array[1]})".(direct_local_get ("formtags_quote_2_2","text")).": ".(direct_local_get ("formtags_quote_2_3","text"))."\n$f_tag_content\n*\n".$f_data_closed; }
							else { $f_data_array[($f_i - 1)] .= "\n* ".(direct_local_get ("formtags_quote_2_1","text"))."".$f_quote_result_array[1]."".(direct_local_get ("formtags_quote_2_2","text")).":\n$f_tag_content\n*\n".$f_data_closed; }
						}
						else { $f_data_array[($f_i - 1)] .= "\n* ".(direct_local_get ("formtags_quote_1","text")).":\n$f_tag_content\n*\n".$f_data_closed; }

						break 1;
					}
					case "cleanup:url":
					{
						if ($f_result_array[($f_i - 1)])
						{
							if (preg_match ("#^\[#",$f_result_array[($f_i - 1)])) { $f_data_array[($f_i - 1)] .= "[url:".$f_result_array[($f_i - 1)]."]{$f_tag_content}[/url]".$f_data_closed; }
							else
							{
								$f_result_array[($f_i - 1)] = substr ($f_result_array[($f_i - 1)],1);
								if ($direct_settings['swg_url_sbcheck']) { $f_result_array[($f_i - 1)] = direct_url_sbcheck ($f_result_array[($f_i - 1)],"text"); }

								if ($f_result_array[($f_i - 1)] == $f_tag_content) { $f_data_array[($f_i - 1)] .= $f_result_array[($f_i - 1)].$f_data_closed; }
								else { $f_data_array[($f_i - 1)] .= $f_result_array[($f_i - 1)]." (".$f_result_array[($f_i - 1)].")".$f_data_closed; }
							}
						}
						else
						{
							if ($direct_settings['swg_url_sbcheck']) { $f_data_array[($f_i - 1)] .= (direct_url_sbcheck ($f_tag_content,"text")).$f_data_closed; }
							else { $f_data_array[($f_i - 1)] .= $f_tag_content.$f_data_closed; }
						}

						break 1;
					}
					case "decode:contentform:box":
					{
						$f_box_result_array = explode (":",$f_result_array[($f_i - 1)]);

						if (preg_match ("#^(\d{1,3})$#i",$f_box_result_array[1],$f_percentage_array))
						{
							if (($f_percentage_array[1] > 0)&&($f_percentage_array[1] < 101)) { $f_box_result_array[1] = ";width:{$f_box_result_array[1]}%"; }
							else { $f_box_result_array[1] = ""; }
						}
						else { $f_box_result_array[1] = ""; }

						if (isset ($f_box_result_array[2]))
						{
							if (($f_box_result_array[0] == "left")&&($f_box_result_array[2] == "br")) { $f_box_result_array[2] = ";clear:left"; }
							elseif (($f_box_result_array[0] == "right")&&($f_box_result_array[2] == "br")) { $f_box_result_array[2] = ";clear:right"; }
							elseif ($f_box_result_array[2] == "br") { $f_box_result_array[2] = ";clear:both"; }
							else { $f_box_result_array[2] = ""; }
						}
						else { $f_box_result_array[2] = ""; }

						if ($f_box_result_array[0] == "left") { $f_data_array[($f_i - 1)] .= "<span style='display:block;float:left{$f_box_result_array[1]}{$f_box_result_array[2]}'>$f_tag_content</span>".$f_data_closed; }
						elseif ($f_box_result_array[0] == "right") { $f_data_array[($f_i - 1)] .= "<span style='display:block;float:right{$f_box_result_array[1]}{$f_box_result_array[2]}'>$f_tag_content</span>".$f_data_closed; }
						else
						{
							if ($f_box_result_array[0] == "br") { $f_data_array[($f_i - 1)] .= "<span style='display:block;clear:both'>$f_tag_content</span>".$f_data_closed; }
							else { $f_data_array[($f_i - 1)] .= "<span style='display:block{$f_box_result_array[1]}{$f_box_result_array[2]}'>$f_tag_content</span>".$f_data_closed; }
						}

						break 1;
					}
					case "decode:contentform:colorbox":
					{
						if (preg_match ("#^\:(\w{6})$#i",$f_result_array[($f_i - 1)],$f_color_result_array)) { $f_data_array[($f_i - 1)] .= "<span style=\"display:block;padding:2px;background-color:#{$f_color_result_array[1]}\">$f_tag_content</span>".$f_data_closed; }
						else { $f_data_array[($f_i - 1)] .= "<span class='pageborder2' style=\"display:block;margin:5px\"><span class='pageextracontent'>$f_tag_content</span></span>".$f_data_closed; }

						break 1;
					}
					case "decode:contentform:hidden":
					{
						$f_hidden_id = uniqid ("");

$f_data_array[($f_i - 1)] .= "<span class='pageborder2' style=\"display:block;margin:5px\"><span id='swgformtags_hidden_{$f_hidden_id}_point' class='pageextracontent'><span style='font-weight:bold'>".$f_result_array[($f_i - 1)]."</span><br /><img src='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/spacer.png",true,false))."' width='100%' height='1' alt='' title='' class='pagehr' style='$direct_settings[theme_hr_style]' />$f_tag_content</span></span><script language='JavaScript1.5' type='text/javascript'><![CDATA[
djs_swgDOM_replace (\"<span class='pageextracontent'><span style='font-weight:bold'><a href=\\\"javascript:djs_iblock_switch('swgformtags_hidden_{$f_hidden_id}_point')\\\">".$f_result_array[($f_i - 1)]."</a></span><span style='display:block'><span id='swgformtags_hidden_{$f_hidden_id}_point' style='display:none'><img src='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/spacer.png",true,false))."' width='100%' height='1' alt='' title='' class='pagehr' style='$direct_settings[theme_hr_style]' />$f_tag_content</span></span></span>\",'swgformtags_hidden_{$f_hidden_id}_point');
]]></script>".$f_data_closed;

						break 1;
					}
					case "decode:contentform:lineheight":
					{
						if ($f_result_array[($f_i - 1)] < $direct_settings['swg_lineheight_min']) { $f_result_array[($f_i - 1)] = $direct_settings['swg_lineheight_min']; }
						if ($f_result_array[($f_i - 1)] > $direct_settings['swg_lineheight_max']) { $f_result_array[($f_i - 1)] = $direct_settings['swg_lineheight_max']; }

						$f_data_array[($f_i - 1)] .= "<span style='line-height:".$f_result_array[($f_i - 1)]."px'>$f_tag_content</span>".$f_data_closed;
						break 1;
					}
					case "decode:contentform:spacerbox":
					{
						$f_box_result_array = explode (":",$f_result_array[($f_i - 1)]);

						if ((isset ($f_box_result_array[1]))&&(preg_match ("#^(\d+)$#",$f_box_result_array[1])))
						{
							if (preg_match ("#^(\d+)$#",$f_box_result_array[0]))
							{
								if ($f_box_result_array[0] < 1) { $f_box_result_array[0] = "margin:1px;"; }
								else { $f_box_result_array[0] = "margin:{$f_box_result_array[0]}px;"; }
							}
							else { $f_box_result_array[0] = ""; }

							if ($f_box_result_array[1] < 0) { $f_box_result_array[1] = "padding:0px"; }
							else { $f_box_result_array[1] = "padding:{$f_box_result_array[1]}px"; }
						}
						elseif (preg_match ("#^(\d+)$#",$f_box_result_array[0]))
						{
							if ($f_box_result_array[0] < 1) { $f_box_result_array[0] = "padding:1px;"; }
							else { $f_box_result_array[0] = "padding:{$f_box_result_array[0]}px;"; }

							$f_box_result_array[1] = "";
						}
						else { $f_box_result_array = array ("",""); }

						$f_data_array[($f_i - 1)] .= "<span style='display:block;{$f_box_result_array[0]}{$f_box_result_array[1]}'>$f_tag_content</span>".$f_data_closed;
						break 1;
					}
					case "decode:contentform:textindent":
					{
						if ($f_result_array[($f_i - 1)] < $direct_settings['swg_textindent_min']) { $f_result_array[($f_i - 1)] = $direct_settings['swg_textindent_min']; }
						if ($f_result_array[($f_i - 1)] > $direct_settings['swg_textindent_max']) { $f_result_array[($f_i - 1)] = $direct_settings['swg_textindent_max']; }

						$f_data_array[($f_i - 1)] .= "<span style='display:block;margin-left:".$f_result_array[($f_i - 1)]."px'>$f_tag_content</span>".$f_data_closed;
						break 1;
					}
					case "decode:font:color":
					{
						$f_data_array[($f_i - 1)] .= "<span style=\"color:#".$f_result_array[($f_i - 1)]."\">$f_tag_content</span>".$f_data_closed;
						break 1;
					}
					case "decode:font:face":
					{
						$f_result_array[($f_i - 1)] = preg_replace ("#^(.+?) (.+?)$#im","'\\1 \\2'",(str_replace (",","\n",$f_result_array[($f_i - 1)])));
						$f_result_array[($f_i - 1)] = trim (str_replace ("\n",",",$f_result_array[($f_i - 1)]));
						if ($direct_settings['swg_fontfamily']) { $f_result_array[($f_i - 1)] .= ",".$direct_settings['swg_fontfamily']; }

						$f_data_array[($f_i - 1)] .= "<span style=\"font-family:".$f_result_array[($f_i - 1)]."\">$f_tag_content</span>".$f_data_closed;
						break 1;
					}
					case "decode:font:size":
					{
						if ($f_result_array[($f_i - 1)] < $direct_settings['swg_fontsize_min']) { $f_result_array[($f_i - 1)] = $direct_settings['swg_fontsize_min']; }
						if ($f_result_array[($f_i - 1)] > $direct_settings['swg_fontsize_max']) { $f_result_array[($f_i - 1)] = $direct_settings['swg_fontsize_max']; }

						$f_data_array[($f_i - 1)] .= "<span style='font-size:".$f_result_array[($f_i - 1)]."px'>$f_tag_content</span>".$f_data_closed;
						break 1;
					}
					case "decode:img":
					{
						if (preg_match ("#^(.*?)\[title:(.+?)\](.*?)$#i",$f_tag_content,$f_title_result_array))
						{
							if (($f_result_array[($f_i - 1)] == ":right")||($f_result_array[($f_i - 1)] == ":right:nobox")) { $f_data_array[($f_i - 1)] .= "<span class='pageborder2' style='overflow:auto;margin:5px;float:right;clear:right;text-align:center'><img src=\"".$f_title_result_array[1].$f_title_result_array[3]."\" alt='' title='' /><br />\n<span class='pageextracontent'>".$f_title_result_array[2]."</span></span>".$f_data_closed; }
							elseif (($f_result_array[($f_i - 1)] == ":left")||($f_result_array[($f_i - 1)] == ":left:nobox")) { $f_data_array[($f_i - 1)] .= "<span class='pageborder2' style='overflow:auto;margin:5px;float:left;clear:left;text-align:center'><img src=\"".$f_title_result_array[1].$f_title_result_array[3]."\" alt='' title='' /><br />\n<span class='pageextracontent'>".$f_title_result_array[2]."</span></span>".$f_data_closed; }
							else { $f_data_array[($f_i - 1)] .= "<span class='pageborder2' style='display:block;overflow:auto;margin:5px;text-align:center'><img src=\"".$f_title_result_array[1].$f_title_result_array[3]."\" alt='' title='' /><br />\n<span class='pageextracontent'>".$f_title_result_array[2]."</span></span>".$f_data_closed; }
						}
						elseif ($f_result_array[($f_i - 1)])
						{
							if ($f_result_array[($f_i - 1)] == ":right:nobox") { $f_result_array[($f_i - 1)] = "<span style='overflow:auto;float:right;clear:right'>"; }
							elseif ($f_result_array[($f_i - 1)] == ":right") { $f_result_array[($f_i - 1)] = "<span class='pageborder2' style='overflow:auto;margin:5px;float:right;clear:right'>"; }
							elseif ($f_result_array[($f_i - 1)] == ":left:nobox") { $f_result_array[($f_i - 1)] = "<span style='overflow:auto;float:left;clear:left'>"; }
							elseif ($f_result_array[($f_i - 1)] == ":left") { $f_result_array[($f_i - 1)] = "<span class='pageborder2' style='overflow:auto;margin:5px;float:left;clear:left'>"; }
							else { $f_result_array[($f_i - 1)] = "<span class='pageborder2' style='display:block;overflow:auto;margin:5px;text-align:center'>"; }

							$f_data_array[($f_i - 1)] .= $f_result_array[($f_i - 1)]."<img src=\"$f_tag_content\" alt='' title='' /></span>".$f_data_closed;
						}
						else { $f_data_array[($f_i - 1)] .= "<span style='overflow:auto'><img src=\"$f_tag_content\" alt='' title='' /></span>".$f_data_closed; }

						break 1;
					}
					case "decode:quote":
					{
						if ($f_result_array[($f_i - 1)])
						{
							$f_quote_result_array = explode (":",$f_result_array[($f_i - 1)],3);

							if ($f_quote_result_array[2]) { $f_data_array[($f_i - 1)] .= "<span style='display:block;margin:0px 20px;text-align:left'><span class='pagecontent' style='$direct_settings[formtags_quote_style]'>".(direct_local_get ("formtags_quote_2_1","text"))."<a href='".(direct_linker ("url0","m=account&s=profile&a=view&dsd=auid+".$f_quote_result_array[1]))."' target='_blank'>{$f_quote_result_array[2]}</a>".(direct_local_get ("formtags_quote_2_2","text")).": </span><span class='pagecontent' style='$direct_settings[formtags_quote_notice_style]'>".(direct_local_get ("formtags_quote_2_3","text"))."</span></span><span class='pageborder2' style='display:block;margin:0px 20px;text-align:left'><span class='pageextracontent'>$f_tag_content</span></span>".$f_data_closed; }
							else { $f_data_array[($f_i - 1)] .= "<span style='display:block;margin:0px 20px;text-align:left'><span class='pagecontent' style='$direct_settings[formtags_quote_style]'>".(direct_local_get ("formtags_quote_2_1","text")).$f_quote_result_array[1].(direct_local_get ("formtags_quote_2_2","text")).":</span></span><span class='pageborder2' style='display:block;margin:0px 20px;text-align:left'><span class='pageextracontent'>$f_tag_content</span></span>".$f_data_closed; }
						}
						else { $f_data_array[($f_i - 1)] .= "<span style='display:block;margin:0px 20px;text-align:left;$direct_settings[formtags_quote_style]'><span class='pagecontent'>".(direct_local_get ("formtags_quote_1","text")).":</span></span><span class='pageborder2' style='display:block;margin:0px 20px;text-align:left'><span class='pageextracontent'>$f_tag_content</span></span>".$f_data_closed; }

						break 1;
					}
					case "decode:url":
					{
						if ($f_result_array[($f_i - 1)])
						{
							$f_result_array[($f_i - 1)] = substr ($f_result_array[($f_i - 1)],1);
							if ($direct_settings['swg_url_sbcheck']) { $f_result_array[($f_i - 1)] = direct_url_sbcheck ($f_result_array[($f_i - 1)]); }

							if (preg_match ("#^(\w{3,5})\:\/\/#i",$f_result_array[($f_i - 1)])) { $f_data_array[($f_i - 1)] .= "<a href=\"".$f_result_array[($f_i - 1)]."\" target='_blank' rel='nofollow'>$f_tag_content</a>".$f_data_closed; }
							elseif (!preg_match ("#^\[#",$f_result_array[($f_i - 1)])) { $f_data_array[($f_i - 1)] .= "<a href=\"".$f_result_array[($f_i - 1)]."\">$f_tag_content</a>".$f_data_closed; }
							else { $f_data_array[($f_i - 1)] .= "[url:".$f_result_array[($f_i - 1)]."]{$f_tag_content}[/url]".$f_data_closed; }
						}
						else
						{
							if ($direct_settings['swg_url_sbcheck']) { $f_data_array[($f_i - 1)] .= "<a href=\"".(direct_url_sbcheck ($f_tag_content))."\">$f_tag_content</a>".$f_data_closed; }
							else { $f_data_array[($f_i - 1)] .= "<a href=\"$f_tag_content\">$f_tag_content</a>".$f_data_closed; }
						}

						break 1;
					}
					case "decode:varlist":
					{
						$f_data_array[($f_i - 1)] .= "<span style='$direct_settings[formtags_list_item_style]'>".$f_result_array[($f_i - 1)]."</span><span style='$direct_settings[formtags_list_content_style]'>$f_tag_content</span>".$f_data_closed;
						break 1;
					}
					}
				}
				else { $f_data_array[($f_i - 1)] .= $f_data_closed_elements[0]; }
			}

			$f_data = $f_data_array[0];
		}
	}

	//f// direct_formtags->tree_changer_simple (&$f_data,$f_start_tag,$f_start_cresult = "",$f_end_tag = "",$f_end_cresult = "")
/**
	* Converts FormTags using specified convert string into valid XHTML 1.0 code.
	*
	* @param string &$f_data String that contains convertable data
	* @param string $f_start_tag Tag for starting a FormTag
	* @param string $f_start_cresult HTML code that should be used instead of the
	*        FormTag
	* @param string $f_end_tag Ending delimiter
	* @param string $f_end_cresult HTML code that should be used
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function tree_changer_simple (&$f_data,$f_start_tag,$f_start_cresult = "",$f_end_tag = "",$f_end_cresult = "")
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags_class->tree_changer_simple (+f_data,$f_start_tag,$f_start_cresult,$f_end_tag,$f_end_cresult)- (#echo(__LINE__)#)"); }

		$f_data_array = explode ($f_start_tag,$f_data);
		$f_occurrences = (count ($f_data_array) - 1);

		for ($f_i = $f_occurrences;$f_i > 0;$f_i--)
		{
			$f_data_closed_array = explode ($f_end_tag,$f_data_array[$f_i],2);
			unset ($f_data_array[$f_i]);

			if (count ($f_data_closed_array) > 1)
			{
				$f_tag_content = $f_data_closed_array[0];
				unset ($f_data_closed_array[0]);
				$f_data_array[($f_i - 1)] .= $f_start_cresult.$f_tag_content.$f_end_cresult.(implode ($f_end_tag,$f_data_closed_array));
			}
			else { $f_data_array[($f_i - 1)] .= $f_data_closed_array[0]; }
		}

		$f_data = $f_data_array[0];
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_classes['@names']['formtags'] = "direct_formtags";
define ("CLASS_direct_formtags",true);

//j// Script specific commands

if (!isset ($direct_settings['formtags_edit_style'])) { $direct_settings['formtags_edit_style'] = "font-size:10px;font-style:italic"; }
if (!isset ($direct_settings['formtags_list_item_style'])) { $direct_settings['formtags_list_item_style'] = "display:block;float:left;clear:left;padding-right:0.5em"; }
if (!isset ($direct_settings['formtags_list_content_style'])) { $direct_settings['formtags_list_content_style'] = "display:block;padding-left:1.2em"; }
if (!isset ($direct_settings['formtags_quote_style'])) { $direct_settings['formtags_quote_style'] = "font-size:11px;font-weight:bold"; }
if (!isset ($direct_settings['formtags_quote_notice_style'])) { $direct_settings['formtags_quote_notice_style'] = "font-size:10px"; }
if (!isset ($direct_settings['formtags_sources_style'])) { $direct_settings['formtags_sources_style'] = "display:block;margin:0px 20px;text-align:left;font-size:10px"; }
if (!isset ($direct_settings['formtags_sources_title_style'])) { $direct_settings['formtags_sources_title_style'] = "font-size:11px;font-weight:bold"; }
if (!isset ($direct_settings['swg_fontfamily'])) { $direct_settings['swg_fontfamily'] = "sans-serif"; }
if (!isset ($direct_settings['swg_fontsize_min'])) { $direct_settings['swg_fontsize_min'] = 8; }
if (!isset ($direct_settings['swg_fontsize_max'])) { $direct_settings['swg_fontsize_max'] = 36; }
if (!isset ($direct_settings['swg_lineheight_min'])) { $direct_settings['swg_lineheight_min'] = 8; }
if (!isset ($direct_settings['swg_lineheight_max'])) { $direct_settings['swg_lineheight_max'] = 36; }
if (!isset ($direct_settings['swg_textindent_min'])) { $direct_settings['swg_textindent_min'] = 4; }
if (!isset ($direct_settings['swg_textindent_max'])) { $direct_settings['swg_textindent_max'] = 160; }
if (!isset ($direct_settings['swg_url_sbcheck'])) { $direct_settings['swg_url_sbcheck'] = false; }
if ($direct_settings['swg_url_sbcheck']) { $direct_settings['swg_url_sbcheck'] = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_link_sbcheck.php",1); }
if (!isset ($direct_settings['theme_hr_style'])) { $direct_settings['theme_hr_style'] = "display:block;height:1px;overflow:hidden"; }
}

//j// EOF
?>