<?php
// Heading
$_['heading_title']       = 'Piwik OpenCart Ecommerce mod';

// Text
$_['text_module']         = 'Modules';
$_['text_success']        = 'Success: You have modified the Piwik OpenCart Ecommerce module!';

$_['text_sku_sku'] = 'Opencart \'SKU\'';
$_['text_sku_model'] = 'Opencart \'Model\'';

// Entry Name Text
$_['entry_enable'] = 'Piwik Tracking';
$_['entry_analytics_url'] = 'Piwik installation URL';
$_['entry_tracker_location'] = 'Full path to PiwikTracker.php';
$_['entry_token_auth'] = 'Piwik auth token';
$_['entry_site_id'] = 'Piwik Site ID';
$_['entry_ec_enable'] = 'Ecommerce tracking';
$_['entry_proxy_enable'] = 'Piwik Proxy Script';
$_['entry_use_sku'] = 'Piwik SKU';

// Entry Help Text #1 (tooltip on hover)
$_['help_enable'] = 'Global on/off setting for the mod.';
$_['help_analytics_url1'] = 'The full URL to your Piwik installation.';
$_['help_tracker_location1'] = 'Will vary with server configuration, see example of common path (replace \'~user\' with hosting username)';
$_['help_token_auth1'] = 'Your secret Piwik authorisation token. Get this from your Piwik Admin \'API\' page.';
$_['help_site_id1'] = 'The ID used in your Piwik install, for the site you want to track. Get this from Piwik Admin (Settings -> Websites).';
$_['help_ec_enable'] = 'Enabled - track Ecommerce.<br />Disabled - only track page views.';
$_['help_proxy_enable'] = 'Enabled - use the proxy script.<br />Disabled - use regular tracking.<br />Unsure? Set this to Disabled! See the readme file for info.';
$_['help_use_sku'] = 'Choose which OpenCart product field to use when reporting Ecommerce product operations.';

// Entry Help Text #2 (placeholder text in box)
$_['help_analytics_url2'] = 'e.g. www.example.com/piwik/';
$_['help_tracker_location2'] = 'e.g. /home/~user/public_html/piwik/PiwikTracker.php';
$_['help_token_auth2'] = 'e.g. abcde0123456789a0b1c2d3e41234567';
$_['help_site_id2'] = 'e.g. 1';

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify the Piwik OpenCart Ecommerce module!';
$_['error_analytics_url'] = 'URL required - must not be empty, must not include the \'http(s)://\' at the start, and must not include any whitespace characters.';
$_['error_location_invalid'] = 'Location invalid - must end in \'/PiwikTracker.php\' and not contain any whitespace characters.';
$_['error_location_unreadable'] = 'File unreadable - the path entered is not a valid readable file location.';
$_['error_token_auth'] = 'Invalid token - must be a 32 character alphanumeric.';
$_['error_site_id'] = 'Invalid site ID - must be a number.';
?>