------------------------------------------------------
InaneCoding Piwik OpenCart Ecommerce VQmod
------------------------------------------------------
Source Repository:	https://github.com/InaneCoding/Piwik-OpenCart-Ecommerce-VQMod
Author:				Kevin Bibby / InaneCoding.co.uk
Version:			0.4
Release Date:		2013-09-16
License:			GNU General Public License (GPL) version 3
------------------------------------------------------


DESCRIPTION
-----------
Implements Piwik Ecommerce tracking for OpenCart;
> Tracks regular page views
> Tracks Ecommerce product views (category views not yet implemented)
> Tracks Ecommerce cart add/update/delete
> Tracks Ecommerce orders
OpenCart admin backend for modifying settings.
Option to use Piwik Proxy Hide Url script to obfuscate the URL in the javascript code.
Fully VQmod'ed up! Does NOT overwrite any core files.



INSTALLATION
------------
1) Upload the contents of the 'Upload' directory to the root of your OpenCart site.
2) Login to your OpenCart admin, go to the Extensions -> Modules page, and click 'Install' next to 'Piwik'.
3) After install, click 'Edit' next to 'Piwik', and on the settings page enter the details about your site and the Piwik installation;

a) "Piwik installation URL" - This is the full url to your Piwik installation (including 'http://'). e.g. "http://www.example.com/piwik/". This MUST include the trailing '/' on the end!
b) "Piwik installation URL (https)" - Same as above, but for secure https. e.g. "https://www.example.com/piwik/". This MUST include the trailing '/' on the end!
c) "Full path to the PiwikTracker.php file" - As the name says, this is your server filepath to your PiwikTracker.php file in your Piwik folder - commonly this will be "/home/~user/public_html/piwik/PiwikTracker.php", where '~user' is replaced by your website hosting username. However this can vary depending on the server configuration.
d) "Piwik auth token" - This is your secret Piwik authorisation token. Get this from the 'API' tab on your Piwik admin panel.
e) "Piwik Site ID" - This is the ID used in your Piwik install for the site you want to track, usually this is '1' but can vary if you have multiple sites or a custom setup. Consult the 'Website Management' page on your Piwik admin panel for this setting (under Settings -> Websites).
f) "Ecommerce tracking" - Set this to 'Enabled' to allow tracking of Ecommerce actions such as product views, cart operations and orders. Set this to 'Disabled' if you only wish to track regular page views.
g) "Piwik Proxy Script" - Set this to 'Enabled' to route all Piwik tracking requests through the Piwik Proxy script at the root of your site; useful if the "Piwik Installation URL" is at another URL/server which you don't want to make public.
h) "Piwik SKU" - Select what product field you would like to use when reporting the SKU (Stock Keeping Unit) in an Ecommerce operation. This can use either OpenCarts 'Model' product field, or the 'SKU' product field.
i) "Piwik Tracking" - Global 'Enabled' / 'Disabled' setting for the Piwik OpenCart mod (functionality not yet implemented!).


UPGRADE
-------
To upgrade from a previous version simply upload the files from the new version as described in step 1) of the installation.
There should be no need to re-install anything or change any settings as I've tried to pay attention to backwards compatbility during development.
Please get in touch if you experience any issues.


IMPORTANT
---------
1. Requires VQmod installed (Highly recommended - https://code.google.com/p/vqmod/ ).

2. Requires Piwik installed.

3. The default install assumes that Piwik is installed to the '/piwik/' folder at the root of your OpenCart site.
If you have used a custom install path then please place the 'PiwikTracker.php' file from '/upload/piwik/PiwikTracker.php' to your custom Piwik folder.

4. The default install assumes that your OpenCart Admin directory is in the '/admin/' folder at the root of your OpenCart site.
If you have used a custom Admin path then please place all files from '/upload/admin/' to your custom OpenCart Admin folder.

5. Only tested on OpenCart 1.5.3.1 & 1.5.4.1, VQmod 2.1.6 & 2.1.7, and Piwik 1.8.4, 1.9.1 & 1.11.1.
(may well work on others - please tell me what you find out!)



LIMITATIONS
-----------
This is functional but by no means a final release and would still benefit from further testing. Please report any bugs found!
1) There is no functionality (yet) to track the category during page views / cart updates / orders.
2) The "Piwik Tracking" global enable/disable setting on the mod settings page is not yet functional.



VERSION HISTORY
---------------

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



KNOWN BUGS
----------
No known bugs.



SUPPORT
-------
I'm happy to help if you have any problems (though can't promise large amounts of time).
I'm also keen to get your feedback (dont be afraid to be critical if I've done something wrong!).
It would be great to hear of your experiences and what could be improved.
 - kevin@inanecoding.co.uk

If you find the mod helpful donations are of course appreciated! Paypal to st@icpla.net :)



WITH THANKS TO
--------------
Gordon Downie - for his brilliant code contribution to add the install and settings functionality to OpenCart admin.
