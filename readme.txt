------------------------------------------------------
InaneCoding Piwik OpenCart Ecommerce VQmod
------------------------------------------------------
Author:		Kevin Bibby / InaneCoding.co.uk
Version:	0.1
Release Date:	2012-10-20
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

3. Only tested on OpenCart 5.3.1 , VQmod 2.1.6 , and Piwik 1.84
(may well work on others - please tell me what you find out!)



LIMITATIONS
-----------
This is an early pre-release v0.1 and is not finished. It is functional at a basic level.

1. There is no admin back-end. You MUST open the piwik.php file and customise your settings at the top of the file.

2. There is no functionality (yet) to report/track the category during page views / cart updates / orders. This will be added in a later version.



VERSION HISTORY
---------------

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
 - kevin@inanecoding.co.uk

If you find the mod helpful donations are of course appreciated! Paypal to st@icpla.net :)
