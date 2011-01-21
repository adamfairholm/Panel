Panel v0.9.1 Beta
=====================
by Addict Add-ons
addictaddons.com
=====================

Welcome to Panel! This is your README.txt file. Looks like you are good at following things files command you to do.

Installation
============

Drop the 'panel' folder into system/expressionengine/third_party. Install via the Add-Ons -> Modules page. Make sure to install the extension and the module.

Usage
=====

You start by creating a new "panel" and then adding settings to it. Your panel settings can be accessed like global variables. So, for instance, if you have a Twitter handle setting and you named it twitter_handle, then that would be available as {twitter_handle} in your layouts.

For entry settings, the variable returns the id of the entry, so you can use it in a channel entry tag loop:

{exp:channel:entries channel="blog_posts" entry_id="{featured_post}"}

	<h2>{title}</h2>

{/exp:channel:entries}

For On/Off, Yes/No settings, the setting returns 'on' or 'off'/'yes' or 'no' in your layouts.