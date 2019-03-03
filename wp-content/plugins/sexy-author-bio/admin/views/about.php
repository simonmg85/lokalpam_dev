<?php
/**
 * Plugin about view.
 *
 * @package   WP_Author_Bio
 * @author    Andy Forsberg <andy@penguinwp.com>
 * @license   GPL-2.0+
 * @copyright 2017 Penguin Initiatives
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="wrap">
<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
<div style="float:left;width:80%;">
<div>
<h3>Tweet About WP Author Bio</h3>
<div><a href="https://twitter.com/share" class="twitter-share-button" data-url="https://wordpress.org/plugins/sexy-author-bio/" data-text="I use the WP Author Bio WordPress Plugin" data-via="andyforsberg" data-size="large" data-hashtags="WordPress">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></div>
<h3>Shortcode</h3>
<p>Use the following shortcode to render WP Author Bio wherever shortcodes are supported:</p>
<pre style="margin: 0;display: inline-block;background: #fff;border: 1px solid #dedee3;padding: 11px;font-size: 12px;line-height: 1.3em;overflow: auto;">
[sexy_author_bio]
</pre>
</div>
<div>
<h3>PHP Function</h3>
<p>Use the following PHP code to render WP Author Bio wherever PHP is supported:</p>
<pre style="display: inline-block;background: #fff;border: 1px solid #dedee3;padding: 11px;font-size: 12px;line-height: 1.3em;overflow: auto;">
if ( function_exists( 'get_Sexy_Author_Bio' ) ) {
    echo get_Sexy_Author_Bio();
}
</pre>
<h3>PHP Variables</h3>
<p>Use the following PHP variables to render specific WP Author Bio data (currently only works when co-authors plus is not in use):</p>
<pre style="display: inline-block;background: #fff;border: 1px solid #dedee3;padding: 11px;font-size: 12px;line-height: 1.3em;overflow: auto;">
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
</pre>
</div>
</div>
<?php include 'metabox.php'; ?>
</div>