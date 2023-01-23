=== WPMobile.App — Android and iOS Mobile Application ===
Contributors: amauric
Tags: mobile app, android app, ios app
Requires at least: 3.7.0
Tested up to: 6.1
Requires PHP: 5.6
Stable tag: trunk
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Android and iOS mobile application for any WordPress wesbite. Easy setup, free test.

== Changelog ==

= 11.14 =
* Add push for Better Messages
* Fix an XSS security issue (CVE-2023-22702)

= 11.13 =
* Translate the banner in Bulgarian

= 11.12 =
* Fix a bug with Peepso
* Load the icons for all themes

= 11.11 =
* Remove wpmobile CSS if the native theme is not used
* Improve the performance of the Notifications tab

= 11.10 =
* Add an option to disable stats

= 11.9 =
* Add an option to send a push to a specific role

= 11.8 =
* Fix a bug with some Peepso links
* Fix a scroll issue on WooCommerce product pages
* Force the refresh of the licence status

= 11.7 =
* Update how the Gravity Forms push are sent
* Peepso name instead of username on push

= 11.6 =
* Allow to change the status bar color for every theme
* Fix a null value
* Fix a bug with infinite scroll and Peepso

= 11.5.1 =
* Minor fixes

= 11.5 =
* Minor fixes

= 11.4 =
* Fix a bug on iOS scroll
* Fix a bug on Gravity forms notifications
* Fix a bug on Lazy load images

= 11.3 =
* Fix a bug on Android toolbar

= 11.2 =
* Made the fix automatic

= 11.1 =
* Better fix for ios status bar

= 11.0 =
* Warning Big change on how the status bar is handled on the iOS app
** If you see a problem on the layout of your app:
** * Enable the option from the wpmobile plugin to allow old status bar support
** * Update the app from the wpmobile plugin to get the new version
** * Disable the old status bar support when app is approved
* Fix the default cache level
* Fix the ios notification when title+text
* Fix gravity form notifications
* Fix links with hashtag
* Fix unclear alert when unread push
* Fix double tap needed on dialog form
* Fix positionning of alert on ios
* Fix title bar color and size

= 10.32 =
* Fix ios push with just title

= 10.31 =
* Fix ios push with just title

= 10.30 =
* Fix a bug on the loading animation

= 10.29 =
* Fix a bug on push link

= 10.28 =
* Add a default link on push
* Update DE translations

= 10.27 =
* Update NL translations

= 10.26 =
* New peepso link for push

= 10.25 =
* Fix: push registration

= 10.24 =
* Add an option to set a menu link external
* More information on the push history

= 10.23=
* Push speed and cron improvement
* Fix the "preview role" section

= 10.22 =
* Fix a php warning
* Fix the homepage on push
* Add right management for the preview
* Add link to the helpcenter

= 10.21 =
* Support tool

= 10.20 =
* Add Slovak translation

= 10.19 =
* Fix the home licence check

= 10.18 =
* Correctly strip CSS from push

= 10.17 =
* Fix a bug on the email recipients (Merci Arnaud AMBA :)
* Fix a bug on the reset pass email

= 10.16 =
* Fix a bug when there a quote in the app name

= 10.15 =
* Fix some bug with Peepso

= 10.14 =
* Fix a bug on the icon picker for the menu

= 10.13 =
* Add norwegian translation (partial)
* Option to select any theme with the native interface

= 10.12 =
* Update NL translation
* Fix a bug with social login menu icon

= 10.11 =
* Fix some PHP Notices
* Fix a problem with the start/stop loading animation

= 10.10 =
* Fix PHP8 error
* Remove the top bar on admin area and login form

= 10.9 =
* Important fix for stuck page after going back

= 10.8 =
* PHP notices fixes
* Remove double download bar on ios

= 10.7 =
* Fix push registration on some installation

= 10.6 =
* Fix apple store id for banner

= 10.5 =
* Bug fixes

= 10.4 =
* Attempt to fix wrong url for push

= 10.3 =
* Attempt to fix wrong url scheme 

= 10.2 =
* Fix push for some installations

= 10.1 =
* New Apple push system

= 10.0 =
* IMPORTANT: POST FIRE UPDATE, DO IT ASAP

= 9.0.117 =
* Fix DIVI header with "DIVI + Native Interface" theme

= 9.0.116 =
* Minor elementor fixes

= 9.0.115 =
* Fix a bug with GeoDir
* Fix a bug with PHP8
* Use excerpt for auto push from post
* Add zh locale

= 9.0.114 =
* Fix ASCII char

= 9.0.113 =
* Fix a bug on 9.0.112 on some links

= 9.0.112 =
* Add anti cache to dynamically added links
* Fix undefined js value
* Better integration with gd-rating
* Fix the form to select more than 100 list items
* Add the action wpmobile_after_login after the login form
* Update de_DE translation

= 9.0.111 =
* Trigger the notifications faster

= 9.0.110 =
* Allow to use all theme on a network installation
* Some fixes for Elementor
* Add a link for Peepso notifications
* Update FR and IT translations

= 9.0.109 =
* Fix a bug on some link with anchors

= 9.0.108 =
* Fix a bug on some link with anchors

= 9.0.107 =
* Fix buddypress comment bug

= 9.0.106 =
* Fix push redirecting to homepage
* Option to add 100 - 900 items on list
* Fix a 404 on some push notifications
* Better anchor management
* Fix Canadian name

= 9.0.105 =
* Fix a bug when changing icon on the menu
* Fix a bug with Adsense

= 9.0.104 =
* Add peepso username on notification
* Add an option to delete push for the last 30-90-365 days
* Test to speed up push notification send

= 9.0.103 =
* Fix Tetun locale

= 9.0.102 =
* Add an alert with the error message on login

= 9.0.101 =
* Fix some bugs

= 9.0.100 =
* Set a default locale on first app load

= 9.0.99 =
* Fix a bug with manual translation and login redirection

= 9.0.98 =
* Redirect to homepage if no translation on manual mode

= 9.0.97 =
* Fix a bug with some hash in url

= 9.0.96 =
* Fix gravity forms

= 9.0.95 =
* Add Peepso auto push
* Add Gravity Form auto push

= 9.0.94 =
* Performance improvment

= 9.0.93 =
* hot fix .92

= 9.0.92 =
* fix a bug with contact form 7
* better comment display

= 9.0.91 =
* add turkish translation
* add post type on the list card
* fix a bug on the login redirect and manual translation
* fix a bug with the no cache option
* fix a bug where the app theme can be show on website
* fix the link in the logo for logged in users

= 9.0.90 =
* Change how cache are handled. Better performance.
* Be sure to "disable all cache" from Options > Cache if you have some trouble

= 9.0.89 =
* Fix a select2 issue
* Fix an elementor issue
* Translate the OK/Cancel popup button
* Add Czech and Chinese locale name in the lang switcher

= 9.0.88 =
* Add order by "menu"
* Fix homepage and manual translation

= 9.0.87 =
* Translate the notification alert

= 9.0.86 =
* Fix a bug on cache settings
* Redirect to the custom page after logout
* Add an option to disable vibrate effect

= 9.0.85 =
* Fix a bug on the cache settings
* Remove <script> <style> from push notifications
* Fix a bug on avatar upload
* Correctly trigger the custom qrcode event

= 9.0.84 =
* New QRCode reader
* New option to never turn off the screen
* Properly disconnect the push notification if the user is logged out
* Fix a bug with Weglot

= 9.0.83 =
* New shortcode for the number of comment
* Clarify the cache options
* Decrease the wpmobile.app options size
* Add an option to delete partially the stats
* Add an option to delete an auto detected language
* No more send push to disconnect user account

= 9.0.82 =
* Fix a bug on some homepage

= 9.0.81 =
* Add the list top and bottom widget on the recent post shortcode
* Fix a bug on the buddypress members page
* Fix a bug with the auto push feature and woocommerce notes
* Fix a bug with AMP for WP

= 9.0.79 =
* New logo
* Hide the iOS download banner

= 9.0.78 =
* Fix a bug with AMP for WP
* Remove html tag on buddypress push
* Update locales

= 9.0.77 =
* Add a message to help the app logo update
* Open external links in the browser when links are ajax loaded

= 9.0.76 =
* Do not send old push when the cron is broken
* Fix a scroll bug

= 9.0.75 =
* New shortcode [wpapp_title_main] to show the main page title

= 9.0.74 =
* Fix a bug with some menu
* Ability to add the title in the navabr

= 9.0.73 =
* Fix a bug with # link without hash

= 9.0.72 =
* Fix undefined app

= 9.0.71 =
* Limit the number of submitted options in the setting page
* Fix a bug with the select2 customize

= 9.0.70 =
* Fix a bug with anchor links

= 9.0.69 =
* Support of #hash in the url
* Remove the wpmobile parameter from the share link
* Bug fixes (a lot 🍻)

= 9.0.68 =
* Add the qrcode reader in the widgets list
* Improve the preview render
* Remove the Read link if not needed in push
* Open the custom login redirect page when the app start
* Add a visual effect in login fail

= 9.0.67 =
* User interface enhancement

= 9.0.66 =
* Fix some bugs on the stats panel
* Fix some visual bug

= 9.0.65 =
* Add a link to download the wpmobile preview app
* Add an option for faster support

= 9.0.64 =
* Fix a bug with the status bar and hybride theme
* Fix a bug when a logged in page is set

= 9.0.63 =
* Add an option to set a login redirection page
* Fix encoding in the password reset mail

= 9.0.62 =
* Fix a bug with some woocommerce links

= 9.0.61 =
* Link are now opened after a click on the push (need app update)
* Enable high priority iOS push
* Bring back the metabox to send a push when you publish a post
* Fix a bug with woocommerce ajax links
* Fix a bug preventing to click on a post of the list

= 9.0.60 =
* Trying to fix the double notification bug

= 9.0.59 =
* Dont push pages

= 9.0.58 =
* Fix the button to open the push config
* Fix a bug when push on update

= 9.0.57 =
* Allow to open internal pages in the external browser
* Fix push sended multiples times
* Mise à jour des traductions FR

= 9.0.56 =
* Fix a bug on the /post.php page when push are enabled

= 9.0.55 =
* Fix a bug with the "open in a new tab" button on the preview
* Fix a bug on the share link when there is a parameter in the url
* Fix a bug with the iOS menu size
* Add the link to the author archive page on the author shortcode
* Update German translations

= 9.0.54 =
* Fix a bug on with some post type

= 9.0.53 =
* Add an auto push option for post updates
* Fix the inversion of text/description in push messages
* Fix a bug on some old installation preventing push to being sent
* Use the excluded tags for all lists

= 9.0.52 =
* Remove unnecessary script

= 9.0.51 =
* Fix a bug at login after the registration

= 9.0.50 =
* Update the qrcode scanner shortcode

= 9.0.49 =
* Adjust the push alert UI
* Reverse the infinite load on post pages
* Add number of pages view in the chart
* Update es translations

= 9.0.48 =
* Fix a bug on the notification popup (again)

= 9.0.47 =
* Fix a bug on the notification popup

= 9.0.46 =
* Do not load the wpmobile interface when a post is embeded

= 9.0.45 =
* Fix a Javascript error

= 9.0.44 =
* Show a global alert if there is more than 1 unread push
* Translate the woocommerce order status in push

= 9.0.43 =
* Fix a bug with the qrcode scanner if loaded multiple times

= 9.0.42 =
* Fix a bug with the translation returning empty result
* Fix a bug with some custom category in the push settings
* Fix a bug with the link on the push alert

= 9.0.41 =
* Fix a bug with the manual translation
* Fix a bug on the search results title

= 9.0.40 =
* Fix manual translation on menu group
* Fix PHP notices

= 9.0.39 =
* Fix a bug with the notification in app not showing

= 9.0.38 =
* Fix the qrcode shortcode

= 9.0.37 =
* Lower the ajax interval
* Fix a bug with some ajax request on buddypress

= 9.0.36 =
* Fix a bug on the ajax request for push

= 9.0.35 =
* Fix a stupid bug with the new qrcode reader

= 9.0.34 =
* Fixes on the new push system

= 9.0.33 =
* Improve the notification system
* New QRCode reader
* Fix the status bar color

= 9.0.32 =
* Strip off parameters of the share shortcode
* Fix an incompatibility with WordPress <4.5

= 9.0.31 =
* Fix a bug with offline on iOS
* Fix a bug with the XS header margin

= 9.0.30 =
* Fix a bug with AIT themes

= 9.0.29 =
* Fix the broken margin in iphone X*

= 9.0.28 =
* Fix the topbar for the iphone XS Max
* Fix a bug with AMP theme

= 9.0.27 =
* Fix a bug if no homepage

= 9.0.26 =
* Fix registration to push for android users

= 9.0.25 =
* Fix registration to push for android users

= 9.0.24 =
* Less agressive push banner
* Fix a bug with the menu groups

= 9.0.23 =
* New UI for the Lang switcher widget
* Better preview of the app from the plugin

= 9.0.22 =
* Add an option to display 5 items on list
* Fix a Javascript error blocking the app load

= 9.0.20 =
* Android SDK 2019 is ready

= 9.0.19 =
* Remove slashes on notification history
* Fix a bug with auto push send

= 9.0.18 =
* New SDK: problem with external link is fixed

= 9.0.17 =
* Added +100 new icons for the menu
* Update the icons design
* Fix few color issues

= 9.0.16 =
* Send notification by role
* Reset the notification badge in iOS

= 9.0.15 =
* Fix a Javascript error that can break lazy load and animations

= 9.0.14 =
* Fix a bug with notification registration process

= 9.0.13 =
* Prepare the plugin for the 2019 sdk

= 9.0.12 =
* Warning: AdBuddiz, AdMob, Google Analytics, Hybrid Theme will be deprecated with the 2019 SDK. You can continue to use these features but will not be able to update the app framework.
* Buddypress: Notifications are now synched with the app
* Add a password lost link in the login widget
* Add a splashscreen preview

= 9.0.11 =
* New UI for the push history
* New UX for the FAB menu if only 1 item
* Fix a Javascript undefined error

= 9.0.10 =
* Add visual effect for read/unread notifications
* Add a new shortcode to display a push notification icon: [wpmobile_notification_badge]
* Fix the dialog not closing when clicking on the backdrop

= 9.0.9 =
* Fix a bug on the service worker
* Fix a bug on the ios push title not including the message
* Faster menu editor page
* Attempt to fix the loader

= 9.0.8 =
* Fix a bug on the service worker
* Add the number of push in the menu

= 9.0.7 =
* Fix the share link
* Fix a bug on the API

= 9.0.6 =
* Faster push on Android
* Better login error handler

= 9.0.5 =
* Fix the title if this is a search
* Fix the loader
* Show all options to all theme

= 9.0.4 =
* Fix the crazy laoder (add a wait when this is an ajax request)

= 9.0.3 =
* Add a maxlength on the push title input
* Add a loader on all theme
* Fix a bug on the old simple theme
* Release the cron lock faster
* Remove the local website warning

= 9.0.2 =
* Fix a bug with the SecuPress compatibility
* Redirect to the push setting page after restart if modification

= 9.0.1 =
* Add an option to send a push to all Members
* Fix a bug with demo admob banner for apple reviewers
* Fix a bug with list with more than 10 posts

= 9.0 =
* New light dashboard
* Push when a mail is sent
* Push when a WooCommerce order change
* Push when a post is published
* Compatibility fix for AIT themes and plugin
* Compatibility fix for Autoptimize
* Compatibility fix for SecuPress
* Compatibility fix for WPSpamShield
* Multiples fixes on the push notifications
* Multiples fixes on the stats

== Frequently Asked Questions ==

[Common questions and support documentation](https://support.wpmobile.app/?lang=en)

== Description ==

**WPMobile.App build the Android and iPhone-iPad native mobile application of your WordPress site and allow you to publish it on Google Play and Apple Store.**

= Our Android and iOS mobile app offer =

* 💳 **VERY AFFORDABLE PRICE** - We only sell lifetime licences, no subscription, no hidden fees.

Android 79€ // iOS 79€ // Android + iOS 149€

* 🎉 **FREE TEST** - You can test your mobile app [with the Android and iOS demo app](https://support.wpmobile.app/article/62-can-i-test-my-android-and-ios-mobile-app?lang=en). The only thing you need to do is install this plugin and then you can view your mobile app as it will be in its final version.

* 🖌 **CUSTOMIZATION** - The mobile app of your site will look like your site, you will be able to choose the name, the logo and the theme of your mobile app. No mention of our brand or advertisement, the mobile app is white-labeled.

* 📲 **GREAT COMPATIBILITY** - Our mobile apps are compatible with smartphones and tablets, require only Android 4.1 minimum and iOS 8, this represents the vast majority of the smartphone market.

* 👌 **VERY EASY PUBLISH** - We take care of all the technical work, no software to download or complicated manipulation to do. We have automated the entire compilation process and are able to send you your application in 20 minutes!

* 💬 **SUPPORT TEAM** - We are here to help you and answer all your requests as quickly as possible. We'll try to answer all your questions ASAP.

* ⚙ **NATIVE MOBILE APP** - Fast and 100% adapted to all smartphones, screen sizes, software and networks native applications are the top of mobile applications, whether for Android or iOS.

= What do you get with WPMobile.App, the mobile app creator? =

* 👍 **AUTOMATIC APP UPDATE** - When new content is posted on your site, the application is automatically updated, you have absolutely nothing to do. The mobile app is able to display all the contents present on your site, at any time.

* 📢 **NOTIFICATIONS** - With unlimited push notification, you can talk with your users, with an amazing open rate. Manually or when a page or article is published users of your mobile app receive a notification that directly opens the right page on the mobile app.

* 📈 **REAL-TIME STATISTICS** - From the WordPress panel you can access to 12 stats about the mobile app usage. Number of installations, graphical evolution of traffic, actions on the mobile app, geolocation, content view, language, browsing history, ... All statistics are real-time and hosted on your site.

* 🔎 **SEARCH ENGINE** - Users can search for your content directly from the mobile app. Directly from the app the users will be able to access all your content in just a few clicks, exploiting the power of the wordpress search engine.

* 👋 **SOCIAL SHARING** - The users of your mobile app will be able to share your pages and your articles in 1 click by using all the applications installed on their smartphone (Twitter, Facebook, Linkedin, messaging, SMS, ...).

* ✍ **COMMENTS** - If comments are enabled on the page being read, the user can read all the comments and access a form to leave a comment. We use the native WordPress system and the mobile app passes most anti-spam systems.


== Installation ==

= WordPress Admin Method =
1. Go to you administration area in WordPress `Plugins > Add`
2. Look for `WPMobile.App` (use search form)
3. Click on Install and activate the plugin
4. Find the settings page through `Settings > WPMobile.App`

= FTP Method =
1. Upload the complete `wpappninja` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Find the settings page through the `WPMobile.App` menu on the toolbar

