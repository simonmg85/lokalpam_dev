<?php
/**
 * Social Shares Butoons
 *
 */
if(!function_exists('listingpro_social_sharing_buttons')){	
	function listingpro_social_sharing_buttons($name) {
		global $post;
		if(is_singular( 'listing' ) || is_singular( 'post' ) || is_singular( 'events' )){
			$listingURL = urlencode(get_permalink());
			$listingTitle = str_replace( ' ', '%20', get_the_title());
			$listingThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			$twitterURL = 'https://twitter.com/intent/tweet?text='.$listingTitle.'&amp;url='.$listingURL.'';
			$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$listingURL;
			$googleURL = 'https://plus.google.com/share?url='.$listingURL;
			$pinterest = 'https://pinterest.com/pin/create/button/?url='.$listingURL;
			$linkedin = 'http://www.linkedin.com/shareArticle?mini=true&url='.$listingURL;
			$reddit = 'https://www.reddit.com/login?dest=https%3A%2F%2Fwww.reddit.com%2Fsubmit%3Ftitle%3D'.$listingTitle.'%26url%3D'.$listingURL;
			$stumbleupon = 'https://www.stumbleupon.com/submit?title='.$listingTitle.'&url='.$listingURL;
			$del = 'https://del.icio.us/login?log=out&provider=sharethis&title='.$listingTitle.'&url='.$listingURL.'&v=5';
			if($name =='facebook'){
				return $facebookURL;
			}
			if($name =='twitter'){
				return $twitterURL;
			}
			if($name =='gplus'){
				return $googleURL;
			}
			if($name =='pinterest'){
				return $pinterest;
			}
			if($name =='linkedin'){
				return $linkedin;
			}
			if($name =='reddit'){
				return $reddit;
			}
			if($name =='stumbleupon'){
				return $stumbleupon;
			}
			if($name =='del'){
				return $del;
			}
		}
	}
}