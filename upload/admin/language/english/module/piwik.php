<?php
// Heading
$_['heading_title']       = 'Piwik OpenCart Ecommerce mod';

// Text
$_['text_module']         = 'Modules';
$_['text_success']        = 'Success: You have modified the Piwik OpenCart Ecommerce module!';

$_['text_sku_sku'] = 'Opencart \'SKU\'';
$_['text_sku_model'] = 'Opencart \'Model\'';

$_['entry_piwik_url'] = 'Piwik installation URL:<br /><span class="help">The full URL to your Piwik installation,<br />e.g. "www.example.com/piwik/".</span>';
$_['entry_tracker_location'] = 'Full path to the PiwikTracker.php file:<br /><span class="help">Commonly this may be;<br />"/home/~user/public_html/piwik/PiwikTracker.php"<br />(with \'~user\' as your hosting username).<br />May vary with server configuration.</span>';
$_['entry_token_auth'] = 'Piwik auth token:<br /><span class="help">Your secret Piwik authorisation token.<br />Get this from your Piwik Admin \'API\' page.<br />e.g. abcde0123456789a0b1c2d3e41234567</span>';
$_['entry_site_id'] = 'Piwik Site ID:<br /><span class="help">The ID used in your Piwik install,<br />for the site you want to track.<br />Get this from Piwik Admin (Settings -> Websites).</span>';
$_['entry_ec_enable'] = 'Ecommerce tracking:<br /><span class="help">Enabled - track Ecommerce operations.<br />Disabled - only track page views.</span>';
$_['entry_proxy_enable'] = 'Piwik Proxy Script:<br /><span class="help">Enabled - use the proxy script.<br />Disabled - use regular tracking.<br />Unsure? Set this to Disabled!<br />See the readme file for info.</span>';
$_['entry_use_sku'] = 'Piwik SKU:<br /><span class="help">Choose which OpenCart product field to use<br />when reporting Ecommerce product operations.</span>';
$_['entry_enable'] = 'Piwik Tracking:<br /><span class="help">Global enable/disable setting for the mod.</span>';

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify the Piwik OpenCart Ecommerce module!';
$_['error_piwik_url'] = 'URL required - must not be empty, include the \'http(s)://\' at the start, or include any whitespace characters.';
$_['error_location_invalid'] = 'Location invalid - must end in \'/PiwikTracker.php\' and not contain any whitespace characters.';
$_['error_location_unreadable'] = 'File unreadable - the path entered is not a valid readable file location.';
$_['error_token'] = 'Invalid token - must be a 32 character alphanumeric.';
$_['error_site_id'] = 'Invalid site ID - must be a number.';
?>