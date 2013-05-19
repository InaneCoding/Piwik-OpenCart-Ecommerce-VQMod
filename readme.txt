------------------------------------------------------
InaneCoding Piwik OpenCart Ecommerce VQmod
------------------------------------------------------
Author:			Kevin Bibby / InaneCoding.co.uk
Version:		0.3
Release Date:	2013-05-16
License:		GNU General Public License (GPL) version 3
------------------------------------------------------


DESCRIPTION
-----------
Implements Piwik Ecommerce tracking for Opencart;
> Tracks regular page views
> Tracks Ecommerce product views (category views not yet implemented)
> Tracks Ecommerce cart add/update/delete
> Tracks Ecommerce orders
> OpenCart admin backend for modifying settings.
> Fully VQmod'ed up! Does NOT overwrite any core files.



INSTALLATION
------------
1) Upload the contents of the 'Upload' directory to the root of your OpenCart site.
2) Login to your OpenCart admin, go to the Extensions -> Modules page, and click 'Install' next to 'Piwik'.
3) After install, click 'Edit' next to 'Piwik', and on the settings page enter the details about your site and Piwik installation.
4) READ the 'Important' section below! (more steps required).



IMPORTANT
---------
1. Requires VQmod installed (Highly recommended - https://code.google.com/p/vqmod/ ).

2. Requires Piwik installed.

2. The default install assumes that Piwik is installed to the '/piwik/' folder at the root of your OpenCartsite.
If you have used a custom install path then please move the 'PiwikTracker.php' file from '/piwik/PiwikTracker.php' to your custom Piwik folder.

3. The default install assumes that your OpenCart Admin directory is in the '/admin/' folder at the root of your OpenCart site.
If you have used a custom Admin path then please place all files from '/upload/admin/' to your custom OpenCart Admin folder.

4. Only tested on OpenCart 1.5.3.1 & 1.5.4.1, VQmod 2.1.6 & 2.1.7 , and Piwik 1.84 & 1.91
(may well work on others - please tell me what you find out!)



LIMITATIONS
-----------
This is an early pre-release and is functional, but still needs the finishing touches. Please report any bugs found.
1) There is no functionality (yet) to report/track the category during page views / cart updates / orders. This will be added in a later version.



VERSION HISTORY
---------------

v0.3 - 2013/05/16
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
There is a bug with PiwikTracker.php and OpenCart due to 'HTTP_REFERRER' being used without checking if it is defined or not. This code has an '@' symbol to suppress the error but for some reason this doesn't always work.
The symptom is text at the top of your site which is similar to "Notice: Undefined index: HTTP_REFERER in ????/PiwikTracker.php on line 84".
To turn off the display of the error on your site, go to your opencart admin. Go to System > Settings , click 'edit' by your site, then click the 'Server' tab. At the bottom change "Display Errors:" from 'yes' to 'no'. That will stop it displaying.



SUPPORT
-------
I'm happy to help if you have any problems (though can't promise large amounts of time).
I'm also keen to get your feedback (dont be afraid to be critical if I've done something wrong!).
It would be great to hear of your experiences and what could be improved.
 - kevin@inanecoding.co.uk

If you find the mod helpful donations are of course appreciated! Paypal to st@icpla.net :)



WITH THANKS TO
--------------
Gordon Downie - for his brilliant code contribution to add the opencart admin backend.
