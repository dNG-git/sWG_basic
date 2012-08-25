<?xml version='1.0' encoding='UTF-8' ?>
<swg_settings_file_v1 xmlns="urn:de-direct-netware-xmlns:swg.settings.v1">
<phpexit><![CDATA[<?php exit (); ?>]]></phpexit>

<administration>
 <email>
  <in><![CDATA["direct Netware Group Service Team" <service@direct-netware.de>]]></in>
  <out><![CDATA["direct Netware Group eMail-Manager" <noreply@direct-netware.de>]]></out>
 </email>
</administration>

<data><table value="swg_data" /></data>
<evars><archive><table value="swg_evars_archive" /></archive></evars>
<home><url value="http://www.direct-netware.de" /></home>
<log><table value="swg_log" /></log>

<swg>
 <auto><maintenance value="0" /></auto>
 <chmod>
  <dirs><change value="0755" /></dirs>
  <files><change value="0644" /></files>
 </chmod>

 <cookie>
  <name value="swg" />
  <path value="/" />
  <server value="localhost" />
 </cookie>

 <cron>
  <client value="" />
  <timeout><forced value="7200" /></timeout>
 </cron>

 <fontfamily value="sans-serif" />

 <fontsize>
  <min value="8" />
  <max value="36" />
 </fontsize>

 <id value="CVS" />
 <lang value="en" />
 <lastvisit><timeout value="900" /></lastvisit>

 <lineheight>
  <min value="8" />
  <max value="36" />
 </lineheight>

 <options><image value="1" /></options>
 <path><smilies value="data/mmedia/smilies/" /></path>
 <required><marker value="*" /></required>
 <sendmailer><use><names value="1" /></use></sendmailer>

 <service>
  <module value="" />
  <service value="sysm" />
  <action value="munconfigured" />
  <dsd value="" />
 </service>

 <theme value="swg">
  <oset value="default" />
 </theme>

 <title>
  <html><![CDATA[<em>direct</em> Netware Group - Initial Installation]]></html>
  <txt value="direct Netware Group - Initial Installation" />
 </title>
</swg>

<tmp><storage><table value="swg_tmp_storage" /></storage></tmp>

<users>
 <min value="3" />
 <password><min value="6" /></password>
 <registration><credits><onetime value="200" /></credits></registration>
 <table value="swg_users" />
 <tablecells_extras />
</users>

<uuids>
 <cookie value="swg_uuids" />
 <maxage>
  <inactivity value="604800" />
  <timeout value="86400" />
 </maxage>
 <passcode><timeout value="300" /></passcode>
 <path value="/" />
 <server value="localhost" />
 <setcookie value="1" />
 <table value="swg_uuids_list" />
</uuids>

<p3p><url /><cp /></p3p>

</swg_settings_file_v1>