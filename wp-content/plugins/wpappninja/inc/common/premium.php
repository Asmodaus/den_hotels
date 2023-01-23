<?php
defined( 'ABSPATH' ) or die( 'Cheatin\' uh?' );

/**
 * Check if it's a premium account
 */
function wpappninja_is_premium($bypass = false) {
    
    return true;
	
	// old account
	if (!get_option('wpappninja_start_premium_feature') && current_time( 'timestamp' ) < 1481756400 && !$bypass) {
		return true;
	}

	// free account are not premium
	if (wpappninja_get_allowed_install() <= 100) {
		return false;
	}

	return true;
}

/**
 * Show alert for old account.
 */
function wpappninja_alert_old_basic() {
    
    return false;
	
	// old account
	if (!get_option('wpappninja_start_premium_feature') && wpappninja_get_allowed_install() <= 100 && current_time( 'timestamp' ) < 1481756400) {
		return true;
	}

	return false;
}

/**
 * Check if it's a premium account
 */
function wpappninja_has_adserver() {
    
    return true;

	if (wpappninja_get_allowed_install() < 50000) {
		return false;
	}

	return true;
}
