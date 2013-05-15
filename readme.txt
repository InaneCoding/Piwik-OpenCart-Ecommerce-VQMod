------------------------------------------------------
InaneCoding Piwik OpenCart Ecommerce VQmod
------------------------------------------------------
Author:		Kevin Bibby / InaneCoding.co.uk
Version:	0.2
Release Date:	2012-11-04
License:	GNU General Public License (GPL) version 3
------------------------------------------------------


DESCRIPTION
-----------
Implements Piwik Ecommerce tracking for Opencart;
> Tracks regular page views
> Tracks Ecommerce product views (category views not yet implemented)
> Tracks Ecommerce cart add/update/delete
> Tracks Ecommerce orders



FILES
-----
piwik.php - Upload to your /catalog/model/tool/ directory.
piwik.xml - Upload to your /vqmod/xml/ directory.

Fully VQmod'ed up! Mod does NOT change any core files.
READ everything below to finish the setup (more steps required).



IMPORTANT
---------
1. Requires VQmod installed.

2. Requires Piwik installed.

2. You must have the piwiktracker.php file in your Piwik directory
Go to http://piwik.org/docs/tracking-api/ and look for the 'Click here to download the file PiwikTracker.php' link.

3. Only tested on OpenCart 1.5.3.1 & 1.5.4.1, VQmod 2.1.6 & 2.1.7 , and Piwik 1.84 & 1.91
(may well work on others - please tell me what you find out!)



LIMITATIONS
-----------
This is an early pre-release v0.2 and is not finished. It is functional at a basic level.

1. There is no admin back-end. You MUST open the piwik.php file and customise your settings at the top of the file.

a) Replace "https://yoursite.com/piwik/" and the "http://yoursite.com/piwik/" with your Piwik URL - be sure to leave the 's' in https on the first 	line and don't forget the trailing '/'. (without the ' in both cases)

b) Replace the site ID with the Piwik ID for your website. To find this, login to your Piwik admin, go to 'Settings' and then click in the 'Websites' tab. Your site id is listed in the first column.

c). Replace the ??.. with your Piwik auth code. To find this in your Piwik admin, go to 'API' and copy the series of characters in the blue box after &token_auth=. Do not include &token_auth in the auth code line.

d). Replace the /home/~user/public_html/piwik/PiwikTracker.php with the location of your PiwikTracker.php file (you did remember to download it from Piwiks site, didn't you?). In most cases this just requires replacing '~user' with your hosting username. You can often work out this location by looking at the directory structure when logged in via FTP, or if using CPanel, by looking at the directory path in the file manager.


2. There is no functionality (yet) to report/track the category during page views / cart updates / orders. This will be added in a later version.



VERSION HISTORY
---------------

v0.2 - 2012/11/04
Fixed a bug where the ecommerce action would sometimes not get attributed to the correct visitorID.
Improved Installation Instructions

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
