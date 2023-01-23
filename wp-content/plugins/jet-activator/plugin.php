<?php
/*
Plugin Name: JetActivator
Description: License activator for JetPlugins
Version: 1.0
Author: Null Market Team
Author URI: https://null.market
*/

/*
CNANGELOG

Version 1.0 - 13.07.2018
- Initial Release

*/

$jet_license_data = get_option( 'jet-license-data', [] );
if( empty( $jet_license_data[ 'license-list' ] )) { 
	$jet_license_data[ 'license-list' ] = [];
}
$jet_license_data['license-list']['licensekey'] = [
	'licenseStatus' => 'active',
	'licenseKey' => 'licensekey',
	'licenseDetails' => [ 
		'type' => 'crocoblock',
		'product_name' => 'Crocoblock license',
		'expire' => 'lifetime',
		/*'sites' => [],*/
		'plugins' => [
			'jet-blocks/jet-blocks.php'                             => [ 'slug' => 'jet-blocks',               'name' => 'JetBlocks' ],
			'jet-popup/jet-popup.php'                               => [ 'slug' => 'jet-popup',                'name' => 'JetPopup' ],
			'jet-tricks/jet-tricks.php'                             => [ 'slug' => 'jet-tricks',               'name' => 'JetTricks' ],
			'jet-blog/jet-blog.php'                                 => [ 'slug' => 'jet-blog',                 'name' => 'JetBlog' ],
			'jet-elements/jet-elements.php'                         => [ 'slug' => 'jet-elements',             'name' => 'JetElements' ],
			'jet-engine/jet-engine.php'                             => [ 'slug' => 'jet-engine',               'name' => 'JetEngine' ],
			'jet-menu/jet-menu.php'                                 => [ 'slug' => 'jet-menu',                 'name' => 'JetMenu' ],
			'jet-tabs/jet-tabs.php'                                 => [ 'slug' => 'jet-tabs',                 'name' => 'JetTabs' ],
			'jet-woo-builder/jet-woo-builder.php'                   => [ 'slug' => 'jet-woo-builder',          'name' => 'JetWooBuilder' ],
			'jet-woo-product-gallery/jet-woo-product-gallery.php'   => [ 'slug' => 'jet-woo-product-gallery',  'name' => 'JetProductGallery' ],
			'jet-smart-filters/jet-smart-filters.php'               => [ 'slug' => 'jet-smart-filters',        'name' => 'JetSmartFilters' ],
			'jet-compare-wishlist/jet-cw.php'                       => [ 'slug' => 'jet-cw',                   'name' => 'JetCompare&Wishlist' ],
			'jet-theme-core/jet-theme-core.php'                     => [ 'slug' => 'jet-theme-core',           'name' => 'JetThemeCore' ],
			'jet-search/jet-search.php'                             => [ 'slug' => 'jet-search',               'name' => 'JetSearch' ],
			'jet-appointments-booking/jet-appointments-booking.php' => [ 'slug' => 'jet-appointments-booking', 'name' => 'JetAppointment' ],
			'jet-booking/jet-booking.php'                           => [ 'slug' => 'jet-booking',              'name' => 'JetBooking' ],
			'jet-style-manager/jet-style-manager.php'               => [ 'slug' => 'jet-style-manager',        'name' => 'JetStyleManager' ],
			'jet-reviews/jet-reviews.php'                           => [ 'slug' => 'jet-reviews',              'name' => 'JetReviews' ],
		],
	],
];
update_option( 'jet-license-data', $jet_license_data );
