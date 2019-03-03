=== WP Author Bio ===
Contributors: penguininitiatives
Tags: wp, author, bio, sexy, biography, authors, profile, user, social icons, contact, Facebook, fast, flickr, github, google, google plus, image, instagram, linkedin, pinterest, post author, profiles, rel author, responsive, rss, schema, sexy author bio, shortcode, sidebar, signature, social profiles, structured data, stumbleupon, tumblr, twitter, vimeo, widget, wordpress, yahoo, youtube
Requires at least: 3.8
Tested up to: 4.7
Stable tag: 1.5.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A WordPress author bio plugin that adds an extremeley flexible, custom about the author box below your posts for single and multiple authors.

== Description ==

WP Author Bio is a WordPress author bio plugin that supports single and multiple authors with [Co-Authors Plus](https://wordpress.org/plugins/co-authors-plus/). It offers tons of options to customize the box after WordPress posts about the author(s).

The author bio box is responsive and includes five sexy social icon sets to choose from, with support for all the following social networks: Behance, Blogger, Delicious, DeviantArt, Dribbble, Facebook, Flickr, GitHub, Google+, Instagram, LinkedIn, MySpace, Pinterest, RSS, StumbleUpon, Tumblr, Twitter, Vimeo, WordPress, Yahoo! & YouTube.

= Credits =

* Plugin built and maintained by [Andy Forsberg](http://andyforsberg.com/).
* The included [Geekly](https://www.behance.net/gallery/Geekly-40-Flat-Icons/10357351) circular social icons are complements of [@Abdo_Ba](https://twitter.com/Abdo_Ba).
* This is a derivative work of the [Author Bio Box WordPress Plugin](http://wordpress.org/plugins/author-bio-box/), which was authored by [Claudio Sanches](http://profiles.wordpress.org/claudiosanches/).

= Latest =
* [200+ Digital Marketing Tools for Fueling Your WordPress Growth](https://penguinwp.com/digital-toolkit/)
* [How To Force Two Factor Authentication in WordPress with Jetpack](https://penguinwp.com/how-to-force-two-factor-authentication-in-wordpress-with-jetpack/)
* [7 Common Google Analytics UTM URL Tracking Mistakes To Avoid](https://penguinwp.com/common-utm-campaign-url-tracking-mistakes-to-avoid/)

= WP Author Bio Box Shortcode =
`
[sexy_author_bio]
`

= PHP Functions & Variables =

<strong>The following should always work:</strong>

`
<?php 
	if ( function_exists( 'get_Sexy_Author_Bio' ) ) {
	    echo get_Sexy_Author_Bio();
	}
?>

`
<strong>The following works only when co-authors plus is not in use:</strong>

`
<?php
	//Author Name:
	echo get_the_author();

	//Job Title:
	echo get_the_author_meta('job-title');

	//Company Name:
	echo get_the_author_meta('company');

	//Company Website URL:
	echo get_the_author_meta('company-website-url');

	//Social Network URLs:
	echo get_the_author_meta( 'sabbehance' );
	echo get_the_author_meta( 'sabblogger' );
	echo get_the_author_meta( 'sabdelicious' );
	echo get_the_author_meta( 'sabdeviantart' );
	echo get_the_author_meta( 'sabdribbble' );
	echo get_the_author_meta( 'sabemail' );
	echo get_the_author_meta( 'sabfacebook' );
	echo get_the_author_meta( 'sabflickr' );
	echo get_the_author_meta( 'sabgithub' );
	echo get_the_author_meta( 'sabgoogle' );
	echo get_the_author_meta( 'sabinstagram' );
	echo get_the_author_meta( 'sablinkedin' );
	echo get_the_author_meta( 'sabmyspace' );
	echo get_the_author_meta( 'sabpinterest' );
	echo get_the_author_meta( 'sabrss' );
	echo get_the_author_meta( 'sabstumbleupon' );
	echo get_the_author_meta( 'sabtumblr' );
	echo get_the_author_meta( 'sabtwitter' );
	echo get_the_author_meta( 'sabvimeo' );
	echo get_the_author_meta( 'sabwordpress' );
	echo get_the_author_meta( 'sabyahoo' );
	echo get_the_author_meta( 'sabyoutube' );
?>
` 

== Installation ==

* Upload plugin files to your plugins folder, or install using WordPress built-in Add New Plugin installer;
* Activate the plugin;
* Navigate to Author Bio -> Settings in order to customize any settings.
* Navigate to Users -> Your Profile and fill in the Contact Info, About Yourself & Author Signature Info fields. Do this for all authors on your website that have made posts (if you want this information to show up in their WP Author Bio).

= Add the box directly =

Use this shortcode:

	[sexy_author_bio]

...or this function:

	<?php 
		if ( function_exists( 'get_Sexy_Author_Bio' ) ) {
			echo get_Sexy_Author_Bio();
		}
	?>

== Frequently Asked Questions ==

= How do I customize the look and feel of WP Author Bio? =

* Once you've installed it simply go to your WordPress Admin Dashboard and then go to Settings > WP Author Bio

= How do I customize a user's WP Author Bio? =

* Once you've installed it simply go to your WordPress Admin Dashboard and then edit the user for which you want to customize the WP Author Bio. You'll see a section called "Author Signature Info" that contains WP Author Bio's customization options for the user.

= How do I allow the use of HTML in the user profile description field? =

* You can tell WordPress to allow HTML in user profile description fields by adding the following line of code to your active WordPress theme's function.php file:

	remove_filter('pre_user_description', 'wp_filter_kses');

== Screenshots ==

1. Example WP Author Bio Front-End Display #1
2. Example WP Author Bio User Settings
3. Example WP Author Bio Display & Design Settings

= How do I disable Gravatar Hovercards? =

* In the WordPress Admin Dashboard go to Settings > Discussion and then under the Avatars section uncheck Gravatar Hovercards "View people’s profiles when you mouse over their Gravatars" and then save your changes.

= What is the plugin license? =

* This plugin is released under a GPL license.

== Changelog ==

= 1.5.5 1/8/2017 =
* WP Author Bio now auto-hides on Google AMP pages

= 1.5.4 1/7/2017 =
* Fixed bug with seperator showing up without company or title
* Cleaned up social icon alt attribute output
* Updated profile field labels from "SAB" to "Author Bio"

= 1.5.3 1/7/2017 =
* Fixed a few social icon linking bugs

= 1.5.2 12/23/2016 =
* Integrated WP Author Bio with Freemius

= 1.5.1 11/27/2016 =
* Removed TGM Plugin Activation because it was causing problems

= 1.5.0 11/27/2016 =
* Began transition to new name "WP Author Bio"
* Adjusted order of social icons to alphabetical
* Adjusted some minor default CSS and plugin settings
* Updated image assets

= 1.4.7 11/27/2016 =
* Fixed email social link bug
* Changed default link target to "_blank"
* Added CSS to avoid potential box shadows issues

= 1.4.6 11/27/2016 =
* Fixed Undefined variable PHP notice
* Added logic to ensure the email social link always links properly
* Added logic to better handle social profile links
* Added option to hide company field and only show Job Title without seperator

= 1.4.5 11/11/2015 =
* Commented out line of new code that wasn't supposed to come in the 1.4.4 update

= 1.4.4 11/11/2015 =
* Fixed legacy "Settings" link in Plugins index page

= 1.4.3 10/26/2015 =
* Patched urgent bug impacting non-English WordPress websites related to "Your Bio" link by removing it for the time being

= 1.4.2 10/25/2015 =
* Moved WP Author Bio out of Settings and into it's own top-level menu item, as well as added an About page to the admin side and a link to "Your Bio" to make it more clear to users where to go to edit their Author Bio
* Added CSS to hide default author bio class for the Twenty Fifteen theme
* Updated plugin's metabox content

= 1.4.1 10/21/2015 =
* WARNING: UNFORTUNATELY AFTER UPDATING TO VERSION 1.4.1 YOU WILL NEED TO RE-ENTER YOUR SOCIAL PROFILE URLS DUE TO THE VARIABLE NAME CHANGES NECESSARY TO FIX THE BUG IN THIS UPDATE!!!
* Added "SAB" label before all user social profile fields to make it obvious which fields impact WP Author Bio and noted that you need to fill in the full URL to get the author's social links working properly
* Appended "sab" to all social network variables so the WordPress core doesn't overwrite some of the social network's field labels, which caused confusion for users
* Adjusted the social icon spacing to apply to the top, right and bottom margin instead of just the left margin, so icons don't touch if you are using enough to wrap to two rows

= 1.4.0 9/1/2015 =
* WP Author Bio now [includes your author's social profiles in Google's search results](https://developers.google.com/structured-data/customize/social-profiles) by generating [Person schemas](http://schema.org/Person) for authors - test your website's schemas by entering any URL that includes a WP Author Bio box with Google's [Structured Data Testing Tool](https://developers.google.com/structured-data/testing-tool/)

= 1.3.9 8/18/2015 =
* Disabled TGM Plugin Activation Integration due to "Dismiss Notice" issues in TGM and uncommon fatal errors

= 1.3.8 8/18/2015 =
* Added TGM Plugin Activation with recommendation to install Co-Authors Plus with WP Author Bio
* Optimized all plugin image assets with [Optimizilla](http://optimizilla.com/) for faster loading
* Co-Author Plus bios are now hidden by default unless they have entered Biographical Info about themselves in their WordPress User Profile Settings

= 1.3.7 8/10/2015 =
* Added "Icon Position" setting that allows you to display icons at the top or bottom of your bio
* Fixed "Display Avatar on Smartphones" setting bug
* Cleaned up the styles further to allow more flexibility and better responsiveness
* Disabled the resetting of WP Author Bio's settings upon deactivation of the plugin

= 1.3.6 2/15/2015 =
* Added "Nofollow Links" option in WP Author Bio settings
* Added alt attribute to all WP Author Bio images

= 1.3.5 2/14/2015 =
* Added "Remove links from author avatar and name" option in WP Author Bio settings
* Adjusted company name so it still displays with or without the entry of a company URL
* Added "Allow Access For" option for setting WP Author Bio user fields access by WordPress User Roles

= 1.3.4 1/5/2015 =
* Added support for carriage returns in the user profile bio description field to accommodate paragraphs

= 1.3.3 1/4/2015 =
* Fixed Hide Signature option bug and replaced with a checkbox
* Added Hide Job Title checkbox option in user profile settings

= 1.3.2 12/24/2014 =
* Added link to GitHub repo.

= 1.3.1 12/24/2014 =
* Added email icon and email field to user profiles.
* Optimized all social icon images.

= 1.3 12/9/2014 =
* [Co-Authors Plus](https://wordpress.org/plugins/co-authors-plus/) Compatibility so long as the co-authors are standard WordPress Users (does not fully support Guest Authors)
* Added the following new customization options: Author Name Line Height, Author Name Font Weight, Author Byline Font Size, Author Byline Line Height, Author Byline Font, Author Byline Font Weight, Author Byline Capitalization, Author Byline Decoration, Author Biography Font Size, Author Biography Line Height, Author Biography Font, Author Biography Font Weight, Byline color & Icon Hover Effect
* Minor security tweaks

= 1.2 11/24/2014 =
* Added five new social icon sets to choose from, all with icons for all the following social networks: Behance, Blogger, Delicious, DeviantArt, Dribbble, Facebook, Flickr, GitHub, Google+, Instagram, LinkedIn, MySpace, Pinterest, RSS, StumbleUpon, Tumblr, Twitter, Vimeo, WordPress, Yahoo! & YouTube
* Added options to set icon size and icon spacing for social icons
* Added option to set border size for top, right, bottom and left separately
* Added option for users to set a custom Avatar URL
* Added Author's name as CSS Class to make it easy to use CSS to customize WP Author Bio for specific authors

= 1.1.1 11/24/2014 =
* Margin CSS Fix

= 1.1 11/23/2014 =
* Tons of CSS & HTML cleanup
* Added option to customize "Job Title Company Separator"
* Added fields to easily customize CSS in the plugin: Global Custom CSS, Desktop 1,200px +, IPAD LANDSCAPE 1019 - 1199px, IPAD PORTRAIT 768 - 1018px & SMARTPHONES
0 - 767px.
* Fixed issue with shortcode not working in widgets & listed shortcode in admin settings page
* Added basic WP Author Bio widget

= 1.0.4.1 11/15/2014 =
* Added help sidebar in WP Author Bio Admin Settings page

= 1.0.4 11/15/2014 =
* Added Author Links options: "Users set the link" or "Author avatar and name link to author page"
* Added Circle Social Icons Set
* Added rel="author"
* Added Settings link in the WordPress Installed Plugins page
* Updated Screenshots
* Updated Plugin Description and Tags

= 1.0.31 9/29/2014 =
* Added Shortcode
* Added Screenshots

= 1.0.3 6/11/2014 =

* Added Author Name Font Size options
* Added Author Name Font options
* Added Author Name Capitalization options
* Added Author Name Decoration options
* Added option to hide display of WP Author Bio for specific users
* Added a couple of FAQ's to make it more clear how to use the plugin

= 1.0.2 1/31/2014 =

* Cleaned up the styles.

= 1.0.1 12/26/2013 =

* Made it so WP Author Bio only shows up on posts of type post & adjusted margin above author names.

= 1.0.0 12/22/2013 =

* Initial version.

== License ==

WP Author Bio is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

WP Author Bio is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with WP Author Bio. If not, see <http://www.gnu.org/licenses/>.
