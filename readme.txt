------------------------------------------------------
InaneCoding Piwik OpenCart Ecommerce VQmod
------------------------------------------------------
Source Repository:	https://github.com/InaneCoding/Piwik-OpenCart-Ecommerce-VQMod
Author:				Kevin Bibby / InaneCoding.co.uk
Version:			1.1
Release Date:		2014-06-25
License:			GNU General Public License (GPL) version 3
------------------------------------------------------



DONATE
------
I DO do this in my spare time for the good of other people - I have released this mod for free in the spirit of the Open Source community, so anything you give to support me would be most appreciated and give me that little extra push to do more features and updates for you guys :)
Please donate if you use this mod and are able to give something:
http://inanecoding.co.uk/donate/ :)



DESCRIPTION
-----------
Implements Piwik Ecommerce tracking for OpenCart;
> Tracks regular page views
> Tracks Ecommerce product views (category views not yet implemented)
> Tracks Ecommerce cart add/update/delete
> Tracks Ecommerce orders
> Tracks Site Searches
OpenCart admin backend for modifying settings.
Option to use Piwik Proxy Hide Url script to obfuscate the URL in the javascript code.
Fully VQmod'ed up! Does NOT overwrite any core files.



IMPORTANT
---------
1. Requires VQmod installed (Highly recommended - https://code.google.com/p/vqmod/ ).

2. Requires Piwik installed.

3. The default install assumes that Piwik is installed to the '/piwik/' folder at the root of your OpenCart site.
If you have used a custom install path then please place the 'PiwikTracker.php' file from '/upload/piwik/PiwikTracker.php' to your custom Piwik folder.

4. The default install assumes that your OpenCart Admin directory is in the '/admin/' folder at the root of your OpenCart site.
If you have used a custom Admin path then please place all files from '/upload/admin/' to your custom OpenCart Admin folder.

5. Only tested on OpenCart 1.5.1.3, 1.5.3.1 & 1.5.4.1, 1.5.6.4 VQmod 2.1.6 & 2.1.7, and Piwik 1.12 & Piwik 2.30 (though think works down to ~1.9 ish).
(may well work on others - please tell me what you find out!)



INSTALL
-------
1) Upload the contents of the 'Upload' directory to the root of your OpenCart site.
2) Login to your OpenCart admin, go to the Extensions -> Modules page, and click 'Install' next to 'Piwik OpenCart Ecommerce mod'.
3) After install, click 'Edit' next to 'Piwik', and on the settings page enter the details about your site and the Piwik installation;

a) "Piwik installation URL" - This is the full url to your Piwik installation (without 'http://'). e.g. "www.example.com/piwik/".
b) "Full path to the PiwikTracker.php file" - As the name says, this is your server filepath to your PiwikTracker.php file in your Piwik folder - commonly this will be "/home/~user/public_html/piwik/PiwikTracker.php", where '~user' is replaced by your website hosting username. However this can vary depending on the server configuration.
c) "Piwik auth token" - This is your secret Piwik authorisation token. Get this from the 'API' tab on your Piwik admin panel.
d) "Piwik Site ID" - This is the ID used in your Piwik install for the site you want to track, usually this is '1' but can vary if you have multiple sites or a custom setup. Consult the 'Website Management' page on your Piwik admin panel for this setting (under Settings -> Websites).
e) "Piwik Tracking" - Global 'Enabled' / 'Disabled' setting for the Piwik OpenCart mod.
f) "Ecommerce tracking" - Set this to 'Enabled' to allow tracking of Ecommerce actions such as product views, cart operations and orders. Set this to 'Disabled' if you only wish to track regular page views.
g) "Piwik Proxy Script" - Set this to 'Enabled' to route all Piwik tracking requests through the Piwik Proxy script at the root of your site; useful if the "Piwik Installation URL" is at another URL/server which you don't want to make public.
h) "Piwik SKU" - Select what product field you would like to use when reporting the SKU (Stock Keeping Unit) in an Ecommerce operation. This can use either the 'Model' or 'SKU' fields which every product in OpenCart has.



UPGRADE
-------
To upgrade from a previous version simply upload the files from the new version as described in step 1) of the installation.
There should be no need to re-install anything else or change/restore any settings as I've tried to pay attention to backwards compatibility during development.
Please get in touch if you experience any issues.



UNINSTALL
---------
In OpenCart admin, go to the Extensions -> Modules page, and simply click 'Uninstall' next to 'Piwik OpenCart Ecommerce mod'.
This will ensure the configuration settings are deleted and that none of the main functions of the mod will run.
Some files will still remain - however these should be perfectly safe and not affect anything but to fully remove please delete all files which you uploaded during the install.



LIMITATIONS
-----------
This is one of the first widespread release but would still benefit from further feedback. Please report any bugs found!
1) There is no functionality (yet) to track the category during page views / cart updates / orders.
2) Some small limitations to site search; OC 1.5.5 or newer doesn't track the search category, OC older than 1.5.5 does track the category but displays site search separate to the page view in the visitor log.



VERSION HISTORY
---------------

v1.1 - 2014/06/25
Fix error messages for undefined variables; checks GET values and other array elements are set before using.
Fixed 'mod disabled' footer comment so it doesn't get included in visible HTML (thanks github user glennw!).
Fixed minor error in Readme Install HTTP/HTTPS instructions.

v1.0 - 2014/02/17
First version to be listed on opencart.com extension store (jump to v1.0).
Order tracking now called from success page (fixes issue with order attributed to payment processor).
Global enable/disable setting on admin page now implemented.
New search tracking feature!
Added checks; avoids some common admin settings errors and improves uninstall.
Other minor changes (see github for full commit list).

v0.4 - 2013/09/16
Fixed bug 'HTTP_REFERRER' undefined index error.
Added option to use Piwik Proxy Hide Url script to obfuscate the URL in the javascript code.
Modified VQmod XML file so will now play nicely with custom themes.

v0.3 - 2013/05/28
First release of admin backend feature.
Arranged source files in an opencart folder structure for easy uploading.
PiwikTracker.php file now included for easier install.

v0.2 - 2012/11/04
Fixed a bug where the ecommerce action would sometimes not get attributed to the correct visitorID.
Improved Installation Instructions.

v0.1 - 2012/10/20
First pre-release version.
Basic Ecommerce functionality.
No category reporting.
No admin back-end



SUPPORT
-------
I'm happy to help if you have any problems (though can't promise large amounts of time).
I'm also keen to get your feedback (dont be afraid to be critical if I've done something wrong!).
It would be great to hear of your experiences and what could be improved.
You can contact me using the form on http://inanecoding.co.uk/contact/

You can see the current bugs/features being worked on at https://github.com/InaneCoding/Piwik-OpenCart-Ecommerce-VQMod/issues
Feel free to raise new issues if you find anything which could be improved (or even better, contribute some code!).



DONATE
------
I DO do this in my spare time for the good of other people - I have released this mod for free in the spirit of the Open Source community, so anything you give to support me would be most appreciated and give me that little extra push to do more features and updates for you guys :)
Please donate if you use this mod and are able to give something:
http://inanecoding.co.uk/donate/ :)



WITH THANKS TO
--------------
Gordon Downie - for his brilliant code contribution to add the install and settings functionality to OpenCart admin.
Github User glennw - for his bug report and fix for 'mod disabled' footer comment.

