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
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
/*#ifdef(PHP5n) */

namespace dNG\sWG;
/* #*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

if (!defined ("CLASS_directFormtags"))
{
/**
* This FormTags class provides all important functions to decode, encode and
* filter FormTags. Furthermore it's extendible.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_basic
* @subpackage formtags
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directFormtags extends directVirtualClass
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directFormtags)
	*
				* @since v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->__construct (directFormtags)- (#echo(__LINE__)#)"); }

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
		$this->functions['parser'] = true;
		$this->functions['parserCleanupContentform'] = true;
		$this->functions['parserCleanupFont'] = true;
		$this->functions['parserCleanupImg'] = true;
		$this->functions['parserCleanupList'] = true;
		$this->functions['parserCleanupQuote'] = true;
		$this->functions['parserCleanupRewrite'] = true;
		$this->functions['parserCleanupSourcecode'] = true;
		$this->functions['parserCleanupSources'] = true;
		$this->functions['parserCleanupTitle'] = true;
		$this->functions['parserCleanupUrl'] = true;
		$this->functions['parserDecodeContentform'] = true;
		$this->functions['parserDecodeFont'] = true;
		$this->functions['parserDecodeImg'] = true;
		$this->functions['parserDecodeList'] = true;
		$this->functions['parserDecodeQuote'] = true;
		$this->functions['parserDecodeRewrite'] = true;
		$this->functions['parserDecodeSourcecode'] = true;
		$this->functions['parserDecodeSources'] = true;
		$this->functions['parserDecodeTitle'] = true;
		$this->functions['parserDecodeUrl'] = true;
		$this->functions['parserTagEndFindPosition'] = true;
		$this->functions['parserTagFindEndPosition'] = true;
		$this->functions['parserTagParse'] = true;
		$this->functions['preCleanup'] = true;
		$this->functions['preDecode'] = true;
		$this->functions['recodeNewlines'] = true;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directFormtags (directFormtags)
	*
	* @since v0.1.00
*\/
	function directFormtags () { $this->__construct (); }
:#*/
/**
	* Removes FormTags from a given string.
	*
	* @param  string $f_data Input string containing FormTags
	* @param  boolean $f_break_urls True for changing URLs to be shorter (but not
	*         usable anymore)
	* @param  boolean $f_withnewline False to remove multiple lines
	* @return string Filtered string
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function cleanup ($f_data,$f_break_urls = false,$f_withnewline = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->cleanup (+f_data,+f_break_urls,+f_newline_mode)- (#echo(__LINE__)#)"); }

		if ($f_withnewline) { $f_data = str_replace (array ("\r","\n"),"",$f_data); }
		else { $f_data = str_replace (array ("[br]","[hr]","[newline]","\r","\n"),"",$f_data); }

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[hr]") !== false) { $f_data = str_replace ("[hr]","---\n",$f_data); }

		$this->parser ($f_data,"sourcecode_cleanup");

		if ($f_break_urls)
		{
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[img") !== false) { $f_data = preg_replace ("#\[img(.*?)\](.+?)\[\/img\]#si"," *".(direct_local_get ("formtags_image","text"))."* ",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[quote") !== false) { $f_data = preg_replace ("#\[quote(.*?)\](.+?)\[\/quote\]#si","[quote]\\2[/quote]",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[url") !== false) { $f_data = preg_replace ("#\[url(.*?)\](.+?)\[\/url\]#i"," *".(direct_local_get ("formtags_url","text"))."* ",$f_data); }
		}

		if ($f_withnewline) { $f_data = str_replace (array ("[br]","[newline]"),(array ("\n","\n")),$f_data); }
		$this->parser ($f_data,"cleanup");
		$f_data = trim (str_replace ((array ("&lt;","&gt;","&quot;")),(array ("<",">",'"')),$f_data));

		return $f_data;
	}

/**
	* Converts all FormTags into valid XHTML 1.0 code.
	*
	* @param  string $f_data Input string containing FormTags
	* @param  boolean $f_withnewline False to remove multiple lines
	* @return string Filtered string containing XHTML code
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function decode ($f_data,$f_withnewline = true)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->decode (+f_data,+f_newline_mode)- (#echo(__LINE__)#)"); }

		$f_data = direct_html_encode_special ($f_data);

		if ($f_withnewline) { $f_data = str_replace (array ("\r","\n"),"",$f_data); }
		else { $f_data = str_replace (array ("[br]","[hr]","[newline]","\r","\n"),"",$f_data); }

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[hr]") !== false) { $f_data = str_replace ("[hr]","<div class='pagehr' style='$direct_settings[theme_hr_style]'><img src='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_mmedia]/spacer.png",true,false))."' width='1' height='1' alt='' title='' style='float:left' /></div><nobr />",$f_data); }

		$this->parser ($f_data,"sourcecode_decode");
		if ($f_withnewline) { $f_data = str_replace (array ("[br]","[newline]"),(array ("<br />\n","<br />\n")),$f_data); }
		$this->parser ($f_data,"decode");

		if (preg_match_all ("#(\[|\])(\w{3,5})\:\/\/(.+?)(\[|\])#i",$f_data,$f_result_array,PREG_SET_ORDER))
		{
			foreach ($f_result_array as $f_url_array) { $f_data = str_replace ($f_url_array[0],($f_url_array[1]."<a href=\"{$f_url_array[2]}://{$f_url_array[3]}\" target='_blank' rel='nofollow'>".(direct_linker ("optical",$f_url_array[2]."://".$f_url_array[3]))."</a>".$f_url_array[4]),$f_data); }
		}

		$f_data = str_replace (array ("&lt;","&gt;"),(array ("<",">")),$f_data);
		$f_data = preg_replace ("#\&amp;(\w{2,4});#i","&\\1;",$f_data);

		return trim (preg_replace ("#<nobr />(<br />\n){0,1}#","\n",$f_data));
	}

/**
	* Converts BBCode to FormTags and filters HTML and or simple HTML statements
	* for links or images.
	*
	* @param  string $f_data Input string
	* @param  boolean $f_withhtml True to not remove HTML tags
	* @param  boolean $f_withftg True for allowing FormTags in the input string
	* @return string Filtered string containing FormTags
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function encode ($f_data,$f_withhtml = false,$f_withftg = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->encode (+f_data,+f_withhtml,+f_withftg)- (#echo(__LINE__)#)"); }

		$f_data = direct_html_encode_special ($f_data);
		$f_data = str_replace ((array ("[newline]","\r","&amp;")),(array ("\n","","&")),$f_data);

		if (($f_withhtml)||($f_withftg))
		{
			$f_data = str_replace ((array ("&lt;","&gt;","&quot;")),(array ("<",">",'"')),$f_data);

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[#") !== false) { $f_data = preg_replace ("/\[#(.+?)\]/i","[url:anchor]\\1[/url]",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[b]") !== false) { $f_data = preg_replace ("#\[b\](.+?)\[\/b\]#si","[font:bold]\\1[/font]",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[code") !== false) { $f_data = preg_replace (array ("#\[code\](.+?)\[\/code\]#si","#\[code=(.+?)\](.+?)\[\/code\]#si"),(array ("[sourcecode]\\1[/sourcecode]","[sourcecode:\\1]\\2[/sourcecode]")),$f_data); }

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[color=") !== false)
			{
$f_data = preg_replace (array ("#\[color\=black\](.+?)\[\/color\]#si","#\[color\=gray\](.+?)\[\/color\]#si","#\[color\=maroon\](.+?)\[\/color\]#si","#\[color\=red\](.+?)\[\/color\]#si","#\[color\=green\](.+?)\[\/color\]#si","#\[color\=lime\](.+?)\[\/color\]#si","#\[color\=olive\](.+?)\[\/color\]#si","#\[color\=yellow\](.+?)\[\/color\]#si",
"#\[color\=navy\](.+?)\[\/color\]#si","#\[color\=blue\](.+?)\[\/color\]#si","#\[color\=purple\](.+?)\[\/color\]#si","#\[color\=fuchsia\](.+?)\[\/color\]#si","#\[color\=teal\](.+?)\[\/color\]#si","#\[color\=aqua\](.+?)\[\/color\]#si","#\[color\=silver\](.+?)\[\/color\]#si","#\[color\=white\](.+?)\[\/color\]#si","#\[color\=\#(\w{6})\](.+?)\[\/color\]#si"),
(array ("[font:color:000000]\\1[/font]","[font:color:808080]\\1[/font]","[font:color:800000]\\1[/font]","[font:color:FF0000]\\1[/font]","[font:color:008000]\\1[/font]","[font:color:00FF00]\\1[/font]","[font:color:808000]\\1[/font]","[font:color:FFFF00]\\1[/font]","[font:color:000080]\\1[/font]","[font:color:0000FF]\\1[/font]",
"[font:color:800080]\\1[/font]","[font:color:FF00FF]\\1[/font]","[font:color:008080]\\1[/font]","[font:color:00FFFF]\\1[/font]","[font:color:C0C0C0]\\1[/font]","[font:color:FFFFFF]\\1[/font]","[font:color:\\1]\\2[/font]")),$f_data);
			}

			$f_data = str_replace ((array ("[font:b]","[font:i]","[font:o]","[font:s]","[font:u]")),(array ("[font:bold]","[font:italic]","[font:overline]","[font:strike]","[font:underline]")),$f_data);

			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[hidden]") !== false) { $f_data = preg_replace ("#\[hidden=(.+?)\](.+?)\[\/hidden\]#si","[contentform:hidden:\\1]\\2[/contentform]",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[highlight]") !== false) { $f_data = preg_replace ("#\[highlight\](.+?)\[\/highlight\]#si","[contentform:highlight]\\1[/contentform]",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[i]") !== false) { $f_data = preg_replace ("#\[i\](.+?)\[\/i\]#si","[font:italic]\\1[/font]",$f_data); }
			if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_data,"[sc") !== false) { $f_data = preg_replace ("#\[sc(.*?)\](.+?)\[\/sc\]#si","[sourcecode\\1]\\2[/sourcecode]",$f_data); }
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
					if (preg_match ("#src=(\"|\')(.+?)(\"|\')#i",$f_img_array[1],$f_url_array)) { $f_data = ((preg_match ("#(alt|title)=(\"|\')(.+?)(\"|\')#i",$f_img_array[1],$f_title_result_array)) ? str_replace ($f_img_array[0],("[img][img:title]{$f_title_result_array[2]}[/img:title]{$f_url_array[2]}[/img]"),$f_data) : str_replace ($f_img_array[0],("[img]{$f_url_array[2]}[/img]"),$f_data)); }
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
				$f_data = str_replace ((array ("[-&lt;]","[-&lt;&lt;]","[-&gt;]","[-&gt;&gt;]","[/-&lt;]","[/-&lt;&lt;]","[/-&gt;]","[/-&gt;&gt;]")),(array ("[-<]","[-<<]","[->]","[->>]","[/-<]","[/-<<]","[/->]","[/->>]")),$f_data);
			}
		}

		$f_data = str_replace ("\n","[newline]",$f_data);
		$f_data = trim ($f_data);

		return $f_data;
	}

/**
	* Converts FormTags using specified convert string into valid XHTML 1.0 code.
	*
	* @param  string &$f_data String that contains convertable data
	* @param  string $f_mode Parser mode
	* @param  string $f_data_position Current parser position
	* @param  string $f_nested_tag Nested tag
	* @param  string $f_nested_tag_end_position End position for nested tags
	* @return boolean True if replacements happened
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parser (&$f_data,$f_mode = "",$f_data_position = 0,$f_nested_tag = NULL,$f_nested_tag_end_position = NULL)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parser (+f_data,$f_mode)- (#echo(__LINE__)#)"); }
		$f_return = false;

		$f_mode_cleanup = ((($f_mode == "cleanup")||($f_mode == "pre_cleanup")) ? true : false);
		$f_mode_decode = ((($f_mode == "decode")||($f_mode == "pre_decode")) ? true : false);
		$f_mode_precode = ((($f_mode == "pre_cleanup")||($f_mode == "pre_decode")) ? true : false);
		$f_mode_sourcecode = ((($f_mode == "sourcecode_cleanup")||($f_mode == "sourcecode_decode")) ? true : false);

		if ((!$f_mode_precode)&&(!$f_mode_sourcecode)) { $f_function_base = "parser".(ucfirst ($f_mode)); }
		elseif ($f_mode_cleanup) { $f_function_base = "parserCleanup"; }
		else { $f_function_base = "parserDecode"; }

		if ($f_mode_sourcecode)
		{
			$f_tags_array = array ("[sourcecode");
			$f_tags_identifier = "[sourcecode";
		}
		elseif ($f_mode_precode)
		{
			$f_tags_array = array ("[rewrite");
			$f_tags_identifier = "[rewrite";
		}
		else
		{
			$f_tags_array = array ("[-","[img","[url","[font","[quote","[title","[rewrite","[sources","[contentform");
			$f_tags_identifier = "[";
		}

		if (isset ($f_nested_tag_end_position))
		{
			$f_data_position = mb_strpos ($f_data,$f_tags_identifier,$f_data_position);
			if ($f_data_position >= $f_nested_tag_end_position) { $f_data_position = false; }
			$f_nested_check = true;
		}
		else
		{
			$f_data_position = mb_strpos ($f_data,$f_tags_identifier,$f_data_position);
			$f_nested_check = false;
		}

		if ($f_data_position !== false) { $f_tags_count = count ($f_tags_array); }

		while ($f_data_position !== false)
		{
			$f_tag = "";
			$f_tag_length = 0;

			for ($f_i = 0;((($f_tag_length == 0)||(!in_array ($f_tag,$f_tags_array)))&&($f_i < $f_tags_count));$f_i++)
			{
				$f_tag_i_length = strlen ($f_tags_array[$f_i]);

				if ($f_tag_length < $f_tag_i_length)
				{
					$f_tag_i_diff = ($f_tag_i_length - $f_tag_length);
					$f_tag_diff = mb_substr ($f_data,($f_data_position + $f_tag_length),$f_tag_i_diff);

					if ((($f_tag_length == 0)&&(strpos ($f_tag_diff,"[",1) === false))||(strpos ($f_tag_diff,"[") === false))
					{
						$f_tag .= $f_tag_diff;
						$f_tag_length += $f_tag_i_diff;
					}
					else
					{
						$f_data_position += (($f_tag_length > 0) ? $f_tag_length : 2);
						$f_i = 0;
						$f_tag = "";
						$f_tag_length = 0;
					}
				}
			}

			$f_function = NULL;
			$f_tag_start_end_position = NULL;

			if (in_array ($f_tag,$f_tags_array))
			{
				switch ($f_tag)
				{
				case "[-":
				{
					$f_tag_start_end_position = $this->parserTagFindEndPosition ($f_data,($f_data_position + $f_tag_length));
					$f_list_symbol = mb_substr ($f_data,($f_data_position + 2),($f_tag_start_end_position - $f_data_position - 3));

					$f_tag_name = "list";
					$f_tag_end = "[/-$f_list_symbol]";
					break 1;
				}
				case "[img":
				{
					$f_tag_name = "img";
					break 1;
				}
				case "[url":
				{
					$f_tag_name = "url";
					break 1;
				}
				case "[font":
				{
					$f_tag_name = "font";
					break 1;
				}
				case "[quote":
				{
					$f_tag_name = "quote";
					break 1;
				}
				case "[title":
				{
					$f_tag_name = "title";
					break 1;
				}
				case "[rewrite":
				{
					$f_tag_name = "rewrite";
					break 1;
				}
				case "[sources":
				{
					$f_tag_name = "sources";
					break 1;
				}
				case "[sourcecode":
				{
					$f_tag_name = "sourcecode";
					break 1;
				}
				case "[contentform":
				{
					$f_tag_name = "contentform";
					break 1;
				}
				}

				if (!isset ($f_tag_start_end_position))
				{
					$f_tag_start_end_position = $this->parserTagFindEndPosition ($f_data,($f_data_position + $f_tag_length));
					$f_tag_end = "[/$f_tag_name]";
				}

				if ($f_tag_start_end_position)
				{
					$f_tag_end_position = $this->parserTagEndFindPosition ($f_data,$f_tag_start_end_position,$f_tag_end);

					while (($f_tag_end_position)&&($this->parser ($f_data,$f_mode,($f_data_position + $f_tag_length + 1),$f_tag,$f_tag_end_position)))
					{
						$f_tag_start_end_position = $this->parserTagFindEndPosition ($f_data,($f_data_position + $f_tag_length));
						$f_tag_end_position = ($f_tag_start_end_position ? $this->parserTagEndFindPosition ($f_data,$f_tag_start_end_position,$f_tag_end) : false);
					}
				}
				else { $f_tag_end_position = false; }

				if ($f_tag_end_position)
				{
					$f_tag_array = $this->parserTagParse ($f_data,$f_data_position,$f_tag_start_end_position);
					$f_function = $f_function_base.(ucfirst ($f_tag_name));
				}
			}

			if ($f_function)
			{
				$f_nested_tag_check = ((($f_nested_check)&&($f_nested_tag == $f_tag)) ? true : false);
				$f_return = true;
				$this->{$f_function} ($f_data,$f_tag_array,$f_data_position,$f_tag_start_end_position,$f_tag_end_position,$f_nested_tag_check);
			}
			else { $f_data_position += $f_tag_length; }

			if ($f_nested_check)
			{
				if ($f_return) { $f_data_position = false; }
				else
				{
					$f_data_position = mb_strpos ($f_data,$f_tags_identifier,$f_data_position);
					if ($f_data_position >= $f_nested_tag_end_position) { $f_data_position = false; }
				}
			}
			else { $f_data_position = mb_strpos ($f_data,$f_tags_identifier,$f_data_position); }
		}

		return $f_return;
	}

/**
	* Clean [contentform] tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserCleanupContentform (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserCleanupContentform (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_data_closed = mb_substr ($f_data,($f_tag_end_position + 14));
		$f_tag_content = mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position));
		$f_data = ((mb_substr ($f_data,0,$f_tag_start_position)).$f_tag_content.$f_data_closed);
	}

/**
	* Clean [font] tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserCleanupFont (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserCleanupFont (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_data_closed = mb_substr ($f_data,($f_tag_end_position + 7));
		$f_tag_content = mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position));
		$f_data = ((mb_substr ($f_data,0,$f_tag_start_position)).$f_tag_content.$f_data_closed);
	}

/**
	* Clean [img] tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserCleanupImg (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserCleanupImg (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_data_closed = mb_substr ($f_data,($f_tag_end_position + 6));
		$f_tag_content = mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position));
		$f_data = ((mb_substr ($f_data,0,$f_tag_start_position)).$f_tag_content.$f_data_closed);
	}

/**
	* Clean [- list tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserCleanupList (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserCleanupList (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_list_symbol = mb_substr ($f_tag_array[0],1);
		$f_data_closed = mb_substr ($f_data,(mb_strlen ($f_list_symbol) + $f_tag_end_position + 4));
		$f_tag_content = mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position));

		$f_data = ((mb_substr ($f_data,0,$f_tag_start_position))."\n$f_list_symbol ".$f_tag_content.$f_data_closed);
	}

/**
	* Clean [quote] tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserCleanupQuote (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserCleanupQuote (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_data_closed = mb_substr ($f_data,($f_tag_end_position + 8));
		$f_tag_content = mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position));

		$f_data = mb_substr ($f_data,0,$f_tag_start_position);

		if (isset ($f_tag_array[1]))
		{
			$f_data .= "\n* ".(direct_local_get ("formtags_quote_2_1","text"));
			$f_data .= ((isset ($f_tag_array[2])) ? $f_tag_array[2]." ({$f_tag_array[1]})".(direct_local_get ("formtags_quote_2_2","text"))." ".(direct_local_get ("formtags_quote_2_3","text")) : $f_tag_array[1].(direct_local_get ("formtags_quote_2_2","text"))).":\n$f_tag_content\n*\n";
		}
		else { $f_data .= "\n* ".(direct_local_get ("formtags_quote_1","text")).":\n$f_tag_content\n*\n"; }

		$f_data .= $f_data_closed;
	}

/**
	* Clean [rewrite] tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserCleanupRewrite (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserCleanupRewrite (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_data_closed = mb_substr ($f_data,($f_tag_end_position + 10));
		$f_invalid_check = false;
		$f_tag_content = mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position));

		$f_data = mb_substr ($f_data,0,$f_tag_start_position);

		if ((!isset ($f_tag_array[1]))||(($f_tag_array[1] != "data")&&($f_tag_array[1] != "edit")&&($f_tag_array[1] != "elink")&&($f_tag_array[1] != "ilink")&&($f_tag_array[1] != "local")&&($f_tag_array[1] != "related"))) { $f_invalid_check = true; }
		elseif (($f_tag_array[1] == "edit")&&(!isset ($f_tag_array[2],$f_tag_array[3]))) { $f_invalid_check = true; }

		if ($f_invalid_check) { $f_data .= $f_tag_content; }
		else
		{
			switch ($f_tag_array[1])
			{
			case "data":
			{
				$f_data .= ((isset ($direct_cachedata["output_formtags_".$f_tag_content])) ? direct_html_encode_special ($direct_cachedata["output_formtags_".$f_tag_content]) : direct_local_get ("core_unknown","text"));
				break 1;
			}
			case "edit":
			{
				$f_datetime = $direct_globals['basic_functions']->datetime ("shortdate&time",$f_tag_array[2],$direct_settings['user']['timezone'],(direct_local_get ("formtags_edit_2","text")));
				$f_data .= "\n* ".(direct_local_get ("formtags_edit_1","text")).$f_datetime.(direct_local_get ("formtags_edit_3","text")).$f_tag_content." ($f_tag_array[3])".(direct_local_get ("formtags_edit_4","text"))." *\n";

				break 1;
			}
			case "elink":
			case "ilink":
			{
				if ($f_tag_array[1] == "elink") { $f_data .= direct_linker_dynamic ("url1",$f_tag_content,false,false); }
				else { $f_data .= direct_linker_dynamic ("url0",$f_tag_content,false); }

				break 1;
			}
			case "local":
			{
				$f_data .= direct_local_get ($f_tag_content,"text");
				break 1;
			}
			case "related":
			{
				$direct_cachedata['formtags_related_data'] = NULL;
				$f_tag_content = $direct_globals['basic_functions']->inputfilterFilePath ($f_tag_content);
				if (($direct_globals['output']->relatedManager ($f_tag_content,"formtags_cleanup_action",true))&&($direct_cachedata['formtags_related_data'] !== NULL)) { $f_data .= $direct_cachedata['formtags_related_data']; }

				break 1;
			}
			}
		}

		$f_data .= $f_data_closed;
	}

/**
	* Clean [sourcecode] tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserCleanupSourcecode (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserCleanupSourcecode (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_data_closed = mb_substr ($f_data,($f_tag_end_position + 13));
		$f_tag_content = mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position));

		if ($f_nested) { $f_data = ((mb_substr ($f_data,0,$f_tag_start_position))."&#91;sourcecode&#93;$f_tag_content&#91;/sourcecode&#93;".$f_data_closed); }
		else
		{
			$f_tag_content = str_replace (array ("[","]"),(array ("&#91;","&#93;")),$f_tag_content);
			$f_data = ((mb_substr ($f_data,0,$f_tag_start_position))."\n* ".(direct_local_get ("formtags_sourcecode","text")).":\n$f_tag_content\n*\n".$f_data_closed);
		}
	}

/**
	* Clean [sources] tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserCleanupSources (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserCleanupSources (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_data_closed = mb_substr ($f_data,($f_tag_end_position + 10));
		$f_tag_content = mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position));
		$f_data = ((mb_substr ($f_data,0,$f_tag_start_position)).(direct_local_get ("formtags_sources","text")).":\n$f_tag_content\n*\n".$f_data_closed);
	}

/**
	* Clean [title] tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserCleanupTitle (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserCleanupTitle (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_data_closed = mb_substr ($f_data,($f_tag_end_position + 8));
		$f_tag_content = mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position));
		$f_data = ((mb_substr ($f_data,0,$f_tag_start_position)).$f_tag_content.$f_data_closed);
	}

/**
	* Clean [url] tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserCleanupUrl (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserCleanupUrl (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_data_closed = mb_substr ($f_data,($f_tag_end_position + 6));
		$f_tag_content = mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position));

		$f_data = mb_substr ($f_data,0,$f_tag_start_position);

		if ($f_nested) { $f_data .= $f_tag_content; }
		else
		{
			$f_href_content = "";

			if (isset ($f_tag_array[1]))
			{
				if ($f_tag_array[1] != "anchor")
				{
					$f_tag_array[0] = substr ($f_tag_array[0],1);
					if (strlen ($f_tag_array[0])) { $f_href_content = ($direct_settings['swg_url_sbcheck'] ? direct_url_sbcheck ($f_tag_array[0],"text") : $f_tag_array[0]); }
				}
			}
			else { $f_href_content = ($direct_settings['swg_url_sbcheck'] ? direct_url_sbcheck ($f_tag_content,"text") : $f_tag_content); }

			if ($f_href_content)
			{
				$f_href_content = str_replace (array ("<",">","&#60;","&#62;","&lt;","&gt;"),"",$f_href_content);
				$f_data .= (($f_href_content == $f_tag_content) ? $f_href_content : $f_tag_content." ($f_href_content)");
			}
		}

		$f_data .= $f_data_closed;
	}

/**
	* Decode [contentform] tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserDecodeContentform (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserDecodeContentform (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_data_closed = mb_substr ($f_data,($f_tag_end_position + 14));
		$f_invalid_check = false;
		$f_tag_content = mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position));

		$f_data = mb_substr ($f_data,0,$f_tag_start_position);

		if ((!isset ($f_tag_array[1]))||(($f_tag_array[1] != "align")&&($f_tag_array[1] != "box")&&($f_tag_array[1] != "colorbox")&&($f_tag_array[1] != "css")&&($f_tag_array[1] != "hidden")&&($f_tag_array[1] != "highlight")&&($f_tag_array[1] != "linehight")&&($f_tag_array[1] != "spacerbox")&&($f_tag_array[1] != "textindent"))) { $f_invalid_check = true; }
		else
		{
			if (($f_tag_array[1] == "align")&&((!isset ($f_tag_array[2]))||(($f_tag_array[2] != "left")&&($f_tag_array[2] != "center")&&($f_tag_array[2] != "right")&&($f_tag_array[2] != "block")))) { $f_invalid_check = true; }
			elseif ((($f_tag_array[1] == "box")||($f_tag_array[1] == "css"))&&(!isset ($f_tag_array[2]))) { $f_invalid_check = true; }
			elseif ($f_tag_array[1] == "lineheight")
			{
				if (!isset ($f_tag_array[2])) { $f_invalid_check = true; }
				elseif ($f_tag_array[2] < $direct_settings['swg_lineheight_min']) { $f_tag_array[2] = $direct_settings['swg_lineheight_min']; }
				elseif ($f_tag_array[2] > $direct_settings['swg_lineheight_max']) { $f_tag_array[2] = $direct_settings['swg_lineheight_max']; }
			}
			elseif (($f_tag_array[1] == "spacerbox")&&(!isset ($f_tag_array[2]))) { $f_invalid_check = true; }
			elseif ($f_tag_array[1] == "textindent")
			{
				if (!isset ($f_tag_array[2])) { $f_invalid_check = true; }
				elseif ($f_tag_array[2] < $direct_settings['swg_textindent_min']) { $f_tag_array[2] = $direct_settings['swg_textindent_min']; }
				elseif ($f_tag_array[2] > $direct_settings['swg_textindent_max']) { $f_tag_array[2] = $direct_settings['swg_textindent_max']; }
			}
		}

		if ($f_invalid_check) { $f_data .= $f_tag_content; }
		else
		{
			switch ($f_tag_array[1])
			{
			case "align":
			{
				if ($f_tag_array[2] == "block") { $f_tag_array[2] = "justify"; }
				$f_data .= "<div style='text-align:{$f_tag_array[2]}'>$f_tag_content</div><nobr />";
				break 1;
			}
			case "box":
			{
				if ($f_tag_array[2] == "left") { $f_css = "float:left"; }
				elseif ($f_tag_array[2] == "right") { $f_css = "float:right"; }
				elseif ($f_tag_array[2] == "br") { $f_css = "clear:both"; }
				else { $f_css = ""; }

				if ((isset ($f_tag_array[3]))&&(preg_match ("#^(\d{1,3})$#i",$f_tag_array[3],$f_percentage_array))&&($f_percentage_array[1] > 0)&&($f_percentage_array[1] < 101)) { $f_css .= ($f_css ? ";width:{$f_percentage_array[1]}%" : "width:{$f_percentage_array[1]}%"); }

				if (isset ($f_tag_array[4]))
				{
					if ($f_tag_array[2] == "left") { $f_css = ";clear:left"; }
					elseif ($f_tag_array[2] == "right") { $f_css = ";clear:right"; }
				}

				$f_data .= "<div style='$f_css'>$f_tag_content</div><nobr />";
				break 1;
			}
			case "colorbox":
			{
				$f_data .= "<div class='pageborder{$direct_settings['theme_css_corners']}' style=\"padding:2px".(((isset ($f_tag_array[2]))&&(preg_match ("#^(\w{6})$#i",$f_tag_array[2],$f_color_result_array))) ? ";background-color:#{$f_color_result_array[1]}" : "")."\">$f_tag_content</div><nobr />";
				break 1;
			}
			case "css":
			{
				$f_data .= "<div class=\"".(str_replace ('"','\"',$f_tag_array[2]))."\">$f_tag_content</div><nobr />";
				break 1;
			}
			case "hidden":
			{
/*
						$f_hidden_code = "<span style='font-weight:bold'><a href=\"javascript:djs_iblock_switch('swgformtags_hidden_{$f_hidden_id}_point')\">".$f_result_array[($f_i - 1)]."</a></span><div id='swgformtags_hidden_{$f_hidden_id}_point' style='display:none'><div class='pagehr' style='$direct_settings[theme_hr_style]'><img src='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_mmedia]/spacer.png",true,false))."' width='1' height='1' alt='' title='' style='float:left' /></div>$f_tag_content</div>";
						$f_hidden_id = uniqid ("");

$f_data_array[($f_i - 1)] .= (isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']) ? $f_hidden_code : ("<div id='swgformtags_hidden_{$f_hidden_id}_point'><span style='font-weight:bold'>".$f_result_array[($f_i - 1)]."</span><div class='pagehr' style='$direct_settings[theme_hr_style]'><img src='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_mmedia]/spacer.png",true,false))."' width='1' height='1' alt='' title='' style='float:left' /></div>$f_tag_content</div><script type='text/javascript'><![CDATA[
djs_DOM_replace (\"".(str_replace ('"','\"',$f_hidden_code))."\",'swgformtags_hidden_{$f_hidden_id}_point');
]]></script>"));

						$f_data_array[($f_i - 1)] .= "".$f_data_closed;
*/
				$f_data .= $f_tag_content;
				break 1;
			}
			case "highlight":
			{
				$f_data .= "<div class='pagehighlightborder{$direct_settings['theme_css_corners']} pagehighlightbg pageextracontent'>$f_tag_content</div><nobr />";
				break 1;
			}
			case "lineheight":
			{
				$f_data .= "<div style='line-height:{$f_tag_array[2]}px'>$f_tag_content</div><nobr />";
				break 1;
			}
			case "spacerbox":
			{
				$f_values_start = 3;

				if ($f_tag_array[2] == "left") { $f_css = "padding-right:"; }
				elseif ($f_tag_array[2] == "right") { $f_css = "padding-left:"; }
				else
				{
					$f_css = "padding:";
					$f_values_start = 2;
				}

				if ((isset ($f_tag_array[($f_values_start + 1)]))&&(preg_match ("#^(\d+)$#",$f_tag_array[($f_values_start + 1)])))
				{
					$f_css .= (($f_tag_array[($f_values_start + 1)] < 0) ? "0px" : $f_tag_array[($f_values_start + 1)]."px");
					$f_css .= (($f_tag_array[$f_values_start] < 1) ? ";margin:1px" : ";margin:".$f_tag_array[$f_values_start]."px");
				}
				else { $f_css .= (((isset ($f_tag_array[$f_values_start]))&&(is_numeric ($f_tag_array[$f_values_start]))&&($f_tag_array[$f_values_start] > 0)) ? $f_tag_array[$f_values_start]."px" : "1px"); }

				$f_data .= "<div style='$f_css'>$f_tag_content</div><nobr />";
				break 1;
			}
			case "textindent":
			{
				$f_data .= "<div style='margin-left:{$f_tag_array[2]}px'>$f_tag_content</div><nobr />";
				break 1;
			}
			}
		}

		$f_data .= $f_data_closed;
	}

/**
	* Decode [font] tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserDecodeFont (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserDecodeFont (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_data_closed = mb_substr ($f_data,($f_tag_end_position + 7));
		$f_invalid_check = false;
		$f_tag_content = mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position));

		$f_data = mb_substr ($f_data,0,$f_tag_start_position);

		if ((!isset ($f_tag_array[1]))||(($f_tag_array[1] != "bold")&&($f_tag_array[1] != "color")&&($f_tag_array[1] != "face")&&($f_tag_array[1] != "italic")&&($f_tag_array[1] != "overline")&&($f_tag_array[1] != "size")&&($f_tag_array[1] != "strike")&&($f_tag_array[1] != "underline"))) { $f_invalid_check = true; }
		else
		{
			if ((($f_tag_array[1] == "color")||($f_tag_array[1] == "face"))&&(!isset ($f_tag_array[2]))) { $f_invalid_check = true; }
			elseif ($f_tag_array[1] == "size")
			{
				if (!isset ($f_tag_array[2])) { $f_invalid_check = true; }
				elseif ($f_tag_array[2] < $direct_settings['swg_fontsize_min']) { $f_tag_array[2] = $direct_settings['swg_fontsize_min']; }
				elseif ($f_tag_array[2] > $direct_settings['swg_fontsize_max']) { $f_tag_array[2] = $direct_settings['swg_fontsize_max']; }
			}
		}

		if ($f_invalid_check) { $f_data .= $f_tag_content; }
		else
		{
			$f_tag = "span";

			switch ($f_tag_array[1])
			{
			case "bold":
			{
				$f_data .= "<b>";
				$f_tag = "b";
				break 1;
			}
			case "color":
			{
				$f_data .= "<span style=\"color:#$f_tag_array[2]\">";
				break 1;
			}
			case "face":
			{
				$f_tag_array[2] = preg_replace ("#^(.+?) (.+?)$#im","'\\1 \\2'",(str_replace (",","\n",$f_tag_array[2])));
				$f_tag_array[2] = trim (str_replace ("\n",",",$f_tag_array[2]));
				if ($direct_settings['swg_fontfamily']) { $f_tag_array[2] .= ",".$direct_settings['swg_fontfamily']; }

				$f_data .= "<span style=\"font-family:$f_tag_array[2]\">";
				break 1;
			}
			case "italic":
			{
				$f_data .= "<i>";
				$f_tag = "i";
				break 1;
			}
			case "overline":
			{
				$f_data .= "<span style='text-decoration:overline'>";
				break 1;
			}
			case "size":
			{
				$f_data .= "<span style='font-size:$f_tag_array[2]px'>";
				break 1;
			}
			case "strike":
			{
				$f_data .= "<span style='text-decoration:line-through'>";
				break 1;
			}
			case "underline":
			{
				$f_data .= "<span style='text-decoration:underline'>";
				break 1;
			}
			}

			$f_data .= $f_tag_content."</$f_tag>";
		}

		$f_data .= $f_data_closed;
	}

/**
	* Decode [img] tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserDecodeImg (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserDecodeImg (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_data_closed = mb_substr ($f_data,($f_tag_end_position + 6));

		if ($f_nested) { $f_data = (mb_substr ($f_data,0,$f_tag_start_position)); }
		else
		{
			$f_tag_content = mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position));

			$f_data = mb_substr ($f_data,0,$f_tag_start_position);

			if (preg_match ("#^(.*?)\[title:(.+?)\](.*?)$#i",$f_tag_content,$f_result_array))
			{
				if (($f_tag_array[0] == ":right")||($f_tag_array[0] == ":right:nobox")) { $f_data .= "<div class='pageborder{$direct_settings['theme_css_corners']}' style='overflow:auto;margin-bottom:{$direct_settings['theme_form_td_padding']};margin-left:{$direct_settings['theme_form_td_padding']};float:right;clear:right;text-align:center'><img src=\"".$f_result_array[1].$f_result_array[3]."\" alt='' title='' /><br />\n".$f_result_array[2]."</div><nobr />"; }
				elseif (($f_tag_array[0] == ":left")||($f_tag_array[0] == ":left:nobox")) { $f_data .= "<div class='pageborder{$direct_settings['theme_css_corners']}' style='overflow:auto;margin-bottom:{$direct_settings['theme_form_td_padding']};margin-right:{$direct_settings['theme_form_td_padding']};float:left;clear:left;text-align:center'><img src=\"".$f_result_array[1].$f_result_array[3]."\" alt='' title='' /><br />\n".$f_result_array[2]."</div><nobr />"; }
				else { $f_data .= "<div class='pageborder{$direct_settings['theme_css_corners']}' style='overflow:auto;margin:{$direct_settings['theme_form_td_padding']};text-align:center'><img src=\"".$f_result_array[1].$f_result_array[3]."\" alt='' title='' /><br />\n".$f_result_array[2]."</div><nobr />"; }
			}
			elseif ($f_tag_array)
			{
				$f_box_check = true;

				switch ($f_tag_array[0])
				{
				case ":right:nobox":
				{
					$f_box_check = false;
					$f_data .= "<span style='overflow:auto;float:right;clear:right'>";
					break 1;
				}
				case ":right":
				{
					$f_data .= "<div class='pageborder{$direct_settings['theme_css_corners']}' style='overflow:auto;margin-bottom:{$direct_settings['theme_form_td_padding']};margin-left:{$direct_settings['theme_form_td_padding']};line-height:0px;float:right;clear:right'>";
					break 1;
				}
				case ":left:nobox":
				{
					$f_box_check = false;
					$f_data .= "<span style='overflow:auto;float:left;clear:left'>";
					break 1;
				}
				case ":left":
				{
					$f_data .= "<div class='pageborder{$direct_settings['theme_css_corners']}' style='overflow:auto;margin-bottom:{$direct_settings['theme_form_td_padding']};margin-right:{$direct_settings['theme_form_td_padding']};line-height:0px;float:left;clear:left'>";
					break 1;
				}
				default: { $f_data .= "<div class='pageborder{$direct_settings['theme_css_corners']}' style='overflow:auto;margin:{$direct_settings['theme_form_td_padding']};line-height:0px;text-align:center'>"; }
				}

				$f_data .= "<img src=\"$f_tag_content\" alt='' title='' />";
				$f_data .= ($f_box_check ? "</div><nobr />" : "</span>");
			}
			else { $f_data .= "<span style='overflow:auto'><img src=\"$f_tag_content\" alt='' title='' /></span>"; }
		}

		$f_data .= $f_data_closed;
	}

/**
	* Decode [- list tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserDecodeList (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserDecodeList (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_list_symbol = mb_substr ($f_tag_array[0],1);

		switch ($f_list_symbol)
		{
		case "<":
		{
			$f_list_symbol = "&#0060;";
			break 1;
		}
		case "<<":
		{
			$f_list_symbol = "&#0171;";
			break 1;
		}
		case ">":
		{
			$f_list_symbol = "&#0062;";
			break 1;
		}
		case ">>":
		{
			$f_list_symbol = "&#0187;";
			break 1;
		}
		case "o":
		{
			$f_list_symbol = "&#0176;";
			break 1;
		}
		}

		$f_data_closed = mb_substr ($f_data,(mb_strlen ($f_list_symbol) + $f_tag_end_position + 4));
		$f_tag_content = mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position));

		$f_data = (mb_substr ($f_data,0,$f_tag_start_position));
		$f_data .= "<div style='$direct_settings[formtags_list_item_style]'>$f_list_symbol</div><div style='$direct_settings[formtags_list_content_style]'>$f_tag_content</div><nobr />".$f_data_closed;
	}

/**
	* Decode [quote] tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserDecodeQuote (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserDecodeQuote (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_data_closed = mb_substr ($f_data,($f_tag_end_position + 8));
		$f_tag_content = $direct_globals['output']->smileyCleanup (mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position)));

		$f_data = mb_substr ($f_data,0,$f_tag_start_position);

		if (isset ($f_tag_array[1]))
		{
			$f_data .= "<div style='margin:0px 20px;text-align:left'><span class='pagecontent' style='$direct_settings[formtags_quote_style]'>".(direct_local_get ("formtags_quote_2_1","text"));
			$f_data .= ((isset ($f_tag_array[2])) ? "<a href='".(direct_linker ("url0","m=account;s=profile;a=view;dsd=auid+".$f_tag_array[1]))."' target='_blank'>$f_tag_array[2]</a>".(direct_local_get ("formtags_quote_2_2","text")).": </span><span class='pagecontent' style='$direct_settings[formtags_quote_notice_style]'>".(direct_local_get ("formtags_quote_2_3","text")) : $f_tag_array[1].(direct_local_get ("formtags_quote_2_2","text")).":")."</span></div>";
			$f_data .= "<div class='pageborder{$direct_settings['theme_css_corners']}' style='margin:0px 20px;text-align:left'>$f_tag_content</div><nobr />";
		}
		else { $f_data .= "<div style='margin:0px 20px;text-align:left;$direct_settings[formtags_quote_style]'><span class='pagecontent'>".(direct_local_get ("formtags_quote_1","text")).":</span></div><div class='pageborder{$direct_settings['theme_css_corners']}' style='margin:0px 20px;text-align:left'>$f_tag_content</div><nobr />"; }

		$f_data .= $f_data_closed;
	}

/**
	* Decode [rewrite] tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserDecodeRewrite (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserDecodeRewrite (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_data_closed = mb_substr ($f_data,($f_tag_end_position + 10));
		$f_invalid_check = false;
		$f_tag_content = mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position));

		$f_data = mb_substr ($f_data,0,$f_tag_start_position);

		if ((!isset ($f_tag_array[1]))||(($f_tag_array[1] != "data")&&($f_tag_array[1] != "edit")&&($f_tag_array[1] != "elink")&&($f_tag_array[1] != "ilink")&&($f_tag_array[1] != "local")&&($f_tag_array[1] != "related"))) { $f_invalid_check = true; }
		elseif (($f_tag_array[1] == "edit")&&(!isset ($f_tag_array[2],$f_tag_array[3]))) { $f_invalid_check = true; }

		if ($f_invalid_check) { $f_data .= $f_tag_content; }
		else
		{
			switch ($f_tag_array[1])
			{
			case "data":
			{
				$f_data .= ((isset ($direct_cachedata["output_formtags_".$f_tag_content])) ? direct_html_encode_special ($direct_cachedata["output_formtags_".$f_tag_content]) : direct_local_get ("core_unknown"));
				break 1;
			}
			case "edit":
			{
				$f_datetime = $direct_globals['basic_functions']->datetime ("shortdate&time",$f_tag_array[2],$direct_settings['user']['timezone'],(direct_local_get ("formtags_edit_2")));
				$f_user_profile = direct_linker ("url1","m=account;s=profile;a=view;dsd=auid+".$f_tag_array[3]);
				$f_data .= ("<br /><span style='$direct_settings[formtags_edit_style]'>".(direct_local_get ("formtags_edit_1")).$f_datetime.(direct_local_get ("formtags_edit_3"))."<a href='$f_user_profile' target='_self'>".(direct_html_encode_special ($f_tag_content))."</a>".(direct_local_get ("formtags_edit_4"))."</span>");

				break 1;
			}
			case "elink":
			case "ilink":
			{
				if ($f_tag_array[1] == "elink") { $f_data .= direct_linker_dynamic ("url1",$f_tag_content,true,false); }
				else { $f_data .= direct_linker_dynamic ("url0",$f_tag_content); }

				break 1;
			}
			case "local":
			{
				$f_data .= direct_local_get ($f_tag_content);
				break 1;
			}
			case "related":
			{
				$direct_cachedata['formtags_related_data'] = NULL;
				$f_tag_content = $direct_globals['basic_functions']->inputfilterFilePath ($f_tag_content);
				if (($direct_globals['output']->relatedManager ($f_tag_content,"formtags_decode_action",true))&&($direct_cachedata['formtags_related_data'] !== NULL)) { $f_data .= $direct_cachedata['formtags_related_data']; }

				break 1;
			}
			}
		}

		$f_data .= $f_data_closed;
	}

/**
	* Decode [sourcecode] tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserDecodeSourcecode (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserDecodeSourcecode (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_data_closed = mb_substr ($f_data,($f_tag_end_position + 13));
		$f_tag_content = mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position));

		if ($f_nested) { $f_data = ((mb_substr ($f_data,0,$f_tag_start_position))."&#91;sourcecode&#93;$f_tag_content&#91;/sourcecode&#93;".$f_data_closed); }
		else
		{
			$f_tag_content = $direct_globals['output']->smileyCleanup ($f_tag_content);
			$f_tag_content = str_replace (array ("[br]","[newline]","[","]"),(array ("\n","\n","&#91;","&#93;")),$f_tag_content);
			$f_data = ((mb_substr ($f_data,0,$f_tag_start_position))."<div class='pageborder{$direct_settings['theme_css_corners']}' style='overflow:auto;padding:5px'><code class='pageextracontent' style='text-align:left;white-space:pre;font-family:\"Courier New\",Courier,mono'>$f_tag_content</code></div><nobr />".$f_data_closed);
		}
	}

/**
	* Decode [sources] tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserDecodeSources (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserDecodeSources (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_data_closed = mb_substr ($f_data,($f_tag_end_position + 10));
		$f_tag_content = $direct_globals['output']->smileyCleanup (mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position)));

		$f_data = mb_substr ($f_data,0,$f_tag_start_position);
		$f_data .= ("<div style='$direct_settings[formtags_sources_style]'><span class='pagecontent'><span style='$direct_settings[formtags_sources_title_style]'>".(direct_local_get ("formtags_sources")).":</span> $f_tag_content</span></div><nobr />".$f_data_closed);
	}

/**
	* Decode [title] tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserDecodeTitle (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserDecodeTitle (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_data_closed = mb_substr ($f_data,($f_tag_end_position + 8));
		$f_invalid_check = false;
		$f_tag_content = mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position));

		$f_data = mb_substr ($f_data,0,$f_tag_start_position);

		if ((isset ($f_tag_array[1]))&&(is_numeric ($f_tag_array[1]))&&($f_tag_array[1] > 0)) { $f_title_heading = ((int)$f_tag_array[1] + $direct_settings['theme_title_min']); }
		else { $f_title_heading = (1 + $direct_settings['theme_title_min']); }

		if ($f_title_heading > 6) { $f_title_heading = 6; }
		$f_title_css = ($direct_settings['theme_css_title'] ? " class='{$direct_settings['theme_css_title']}'" : "");

		$f_data .= "<h".$f_title_heading.$f_title_css.">$f_tag_content</h$f_title_heading><nobr />".$f_data_closed;
	}

/**
	* Decode [url] tags.
	*
	* @param string &$f_data String that contains convertable data
	* @param array $f_tag_array Tag for starting a FormTag
	* @param integer $f_tag_start_position Position where the starting tag has
	*        been found
	* @param integer $f_tag_content_position Position where the content is
	*        starting
	* @param integer $f_tag_end_position Position where the content is ending
	* @param boolean $f_nested True for nested items
	* @param string $f_end_cresult HTML code that should be used
	* @since v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserDecodeUrl (&$f_data,$f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,$f_nested = false)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserDecodeUrl (+f_data,+f_tag_array,$f_tag_start_position,$f_tag_content_position,$f_tag_end_position,+f_nested)- (#echo(__LINE__)#)"); }

		$f_data_closed = mb_substr ($f_data,($f_tag_end_position + 6));
		$f_tag_content = mb_substr ($f_data,$f_tag_content_position,($f_tag_end_position - $f_tag_content_position));

		$f_data = mb_substr ($f_data,0,$f_tag_start_position);

		if ($f_nested) { $f_data .= $f_tag_content; }
		else
		{
			$f_href_content = "";

			if (isset ($f_tag_array[1]))
			{
				if ($f_tag_array[1] == "anchor")
				{
					if (strpos ("\n",$f_tag_content) === false) { $f_data .= "<a id=\"$f_tag_content\" name=\"$f_tag_content\"></a>"; }
					else { $f_data .= $f_tag_content; }
				}
				else { $f_href_content = substr ($f_tag_array[0],1); }
			}
			else { $f_href_content = $f_tag_content; }

			if ($f_href_content)
			{
				$f_href_content = str_replace (array ("<",">","&#60;","&#62;","&lt;","&gt;"),"",$f_href_content);
				$f_href_settings = (preg_match ("#^(\w+)\:\/\/#i",$f_href_content) ? " target='_blank' rel='nofollow'" : "");

				$f_data .= "<a href=".((($direct_settings['swg_url_sbcheck'])&&($f_href_settings)) ? "\"".(direct_url_sbcheck ($f_href_content))."\"".$f_href_settings : "\"$f_href_content\"").">$f_tag_content</a>";
			}
		}

		$f_data .= $f_data_closed;
	}

/**
	* Find the starting position of the closing tag.
	*
	* @param  string &$f_data String that contains convertable data
	* @param  string $f_data_position Current parser position
	* @param  string $f_tag_end Closing tag to be searched for
	* @return mixed Integer position on success; false if not found
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserTagEndFindPosition (&$f_data,$f_data_position,$f_tag_end)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserTagEndFindPosition (+f_data,$f_data_position)- (#echo(__LINE__)#)"); }

		do
		{
			$f_return = mb_strpos ($f_data,$f_tag_end,$f_data_position);
			if ($f_return !== false) { $f_data_position = $f_return; }
		}
		while (($f_return !== false)&&(mb_substr ($f_data,($f_return - 1),1) == "\\"));

		return $f_return;
	}

/**
	* Find the starting position of the enclosing content.
	*
	* @param  string &$f_data String that contains convertable data
	* @param  string $f_data_position Current parser position
	* @return mixed Integer position on success; false if not found
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserTagFindEndPosition (&$f_data,$f_data_position)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserTagFindEndPosition (+f_data,$f_data_position)- (#echo(__LINE__)#)"); }

		do
		{
			$f_return = mb_strpos ($f_data,"]",$f_data_position);
			if ($f_return !== false) { $f_data_position = $f_return; }
		}
		while (($f_return !== false)&&(mb_substr ($f_data,($f_return - 1),1) == "\\"));

		if ($f_return !== false) { $f_return = (1 + $f_return); }
		return $f_return;
	}

/**
	* Parse the tag definition (":" is separator)
	*
	* @param  string &$f_data String that contains convertable data
	* @param  string $f_start_position Tag start position
	* @param  string $f_end_position Tag end position
	* @return array Tag data array
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */protected /* #*/function parserTagParse (&$f_data,$f_start_position,$f_end_position)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->parserTagParse (+f_data,$f_start_position,$f_end_position)- (#echo(__LINE__)#)"); }

		$f_tag_content = mb_substr ($f_data,($f_start_position + 1),($f_end_position - $f_start_position - 2));
		$f_tag_array = explode (":",$f_tag_content);
		if (count ($f_tag_array) > 1) { $f_tag_array[0] = mb_substr ($f_tag_content,(mb_strlen ($f_tag_array[0]))); }

		return $f_tag_array;
	}

/**
	* Cleans and replaces data that are session specific.
	*
	* @param  string $f_data Input string containing FormTags
	* @return string Filtered string
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function preCleanup ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->preCleanup (+f_data)- (#echo(__LINE__)#)"); }

		$this->parser ($f_data,"pre_cleanup");
		return $f_data;
	}

/**
	* Formats and replaces data that are session specific.
	*
	* @param  string $f_data Input string containing FormTags
	* @return string Filtered string containing XHTML code
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function preDecode ($f_data)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->preDecode (+f_data)- (#echo(__LINE__)#)"); }

		$this->parser ($f_data,"pre_decode");
		return $f_data;
	}

/**
	* Converts newline tags ("[newline]" and "[br]") into "br" tags or "\n".
	*
	* @param  string $f_data Input string
	* @param  boolean $f_withhtml True for using the HTML "<br />" tag
	* @return string Filtered string
	* @since  v0.1.00
*/
	/*#ifndef(PHP4) */public /* #*/function recodeNewlines ($f_data,$f_brmode = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -formtags->recodeNewlines (+f_data,$f_brmode)- (#echo(__LINE__)#)"); }

		$f_newline = ($f_brmode ? "<br />\n" : "\n");
		$f_data = trim (str_replace ("[newline]",$f_newline,$f_data));
		return $f_data;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directFormtags",true);

//j// Script specific commands

global $direct_globals,$direct_settings;
$direct_globals['@names']['formtags'] = 'dNG\sWG\directFormtags';

if (!isset ($direct_settings['formtags_edit_style'])) { $direct_settings['formtags_edit_style'] = "font-size:10px;font-style:italic"; }
if (!isset ($direct_settings['formtags_list_item_style'])) { $direct_settings['formtags_list_item_style'] = "padding-right:0.5em;float:left;clear:left"; }
if (!isset ($direct_settings['formtags_list_content_style'])) { $direct_settings['formtags_list_content_style'] = "padding-left:1.2em"; }
if (!isset ($direct_settings['formtags_quote_style'])) { $direct_settings['formtags_quote_style'] = "font-size:11px;font-weight:bold"; }
if (!isset ($direct_settings['formtags_quote_notice_style'])) { $direct_settings['formtags_quote_notice_style'] = "font-size:10px"; }
if (!isset ($direct_settings['formtags_sources_style'])) { $direct_settings['formtags_sources_style'] = "margin:0px 20px;text-align:left;font-size:10px"; }
if (!isset ($direct_settings['formtags_sources_title_style'])) { $direct_settings['formtags_sources_title_style'] = "font-size:11px;font-weight:bold"; }
if (!isset ($direct_settings['swg_fontfamily'])) { $direct_settings['swg_fontfamily'] = "sans-serif"; }
if (!isset ($direct_settings['swg_fontsize_min'])) { $direct_settings['swg_fontsize_min'] = 8; }
if (!isset ($direct_settings['swg_fontsize_max'])) { $direct_settings['swg_fontsize_max'] = 36; }
if (!isset ($direct_settings['swg_lineheight_min'])) { $direct_settings['swg_lineheight_min'] = 8; }
if (!isset ($direct_settings['swg_lineheight_max'])) { $direct_settings['swg_lineheight_max'] = 36; }
if (!isset ($direct_settings['swg_textindent_min'])) { $direct_settings['swg_textindent_min'] = 4; }
if (!isset ($direct_settings['swg_textindent_max'])) { $direct_settings['swg_textindent_max'] = 160; }
if (!isset ($direct_settings['swg_url_sbcheck'])) { $direct_settings['swg_url_sbcheck'] = false; }
if ($direct_settings['swg_url_sbcheck']) { $direct_settings['swg_url_sbcheck'] = $direct_globals['basic_functions']->includeFile ($direct_settings['path_system']."/functions/swg_link_sbcheck.php",1); }
$direct_settings['theme_css_corners'] = (isset ($direct_settings['theme_css_corners_class']) ? " ".$direct_settings['theme_css_corners_class'] : " ui-corner-all");
if (!isset ($direct_settings['theme_css_title'])) { $direct_settings['theme_css_title'] = ""; }
if (!isset ($direct_settings['theme_form_td_padding'])) { $direct_settings['theme_form_td_padding'] = "3px"; }
if (!isset ($direct_settings['theme_hr_style'])) { $direct_settings['theme_hr_style'] = "height:1px;overflow:hidden"; }
if (!isset ($direct_settings['theme_title_min'])) { $direct_settings['theme_title_min'] = 1; }
}

//j// EOF
?>