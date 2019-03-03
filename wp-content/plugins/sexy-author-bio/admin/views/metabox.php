<div class="metabox-holder" style="float:left;width:20%;">

		<div class="postbox">
			<h3 class="hndle"><span>WordPress Hosting</span></h3>

			<div class="inside" style="padding: 0 12px 0;">
				<ul style="list-style: inherit;padding-left: 21px;">
				<li style="list-style-image: url(http://www.siteground.com/img/favicon.ico);"><a target="_blank" href="https://penguinwp.com/refer/siteground/" style="font-size:18px;line-height: 18px;text-decoration:none;"><strong>60%</strong> Discount at SiteGround</a></li>
				</ul>
			</div>
		</div>

		<div class="meta-box-sortables">
			<div class="postbox">
			<h3 class="hndle"><span>Like this plugin?</span></h3>

			<div class="inside" style="padding: 0 12px 0;">
				<p>Why not do any or all of the following:</p><ul style="list-style: inherit;padding-left: 21px;"><li><a href="https://wordpress.org/plugins/sexy-author-bio/" target="_blank">Link to it so other folks can find out about it</a></li><li><a href="https://wordpress.org/support/view/plugin-reviews/sexy-author-bio" target="_blank">Give it a 5 star rating on WordPress.org</a></li><li><a href="https://wordpress.org/plugins/sexy-author-bio/" target="_blank">Let other people know that it works with your WordPress setup</a></li><li><a href="https://wordpress.org/support/plugin/sexy-author-bio" target="_blank">Suggest new features to add to the plugin</a></li></ul>				</div>
		</div>
			<div class="postbox">
			<h3 class="hndle"><span>Need Support?</span></h3>

			<div class="inside" style="padding: 0 12px 0;">
				<p>If you're in need of support with WP Author Bio, please visit the <a href="https://wordpress.org/support/plugin/sexy-author-bio" target="_blank">WP Author Bio Support</a> page.</p>				</div>
			</div>

			<div class="postbox">
				<h3 class="hndle"><span>Latest from Penguin Initiatives</span></h3>

			<div class="inside" style="padding: 0 12px 0;">
				<?php
				/**
				 * Box with latest from Penguin Initiatives for sidebar
				 */
				function pi_news() {
					$rss       = fetch_feed( 'http://penguininitiatives.com/feed/' );
					$rss_items = $rss->get_items( 0, $rss->get_item_quantity( 5 ) );

					$content = '<ul style="list-style: inherit;padding-left: 21px;">';
					if ( ! $rss_items ) {
						$content .= '<li>' . __( 'No news items, feed might be broken...', 'sexyauthorbio' ) . '</li>';
					} else {
						foreach ( $rss_items as $item ) {
							$url = preg_replace( '/#.*/', '', esc_url( $item->get_permalink(), $protocolls = null, 'display' ) );
							$content .= '<li>';
							$content .= '<a target="_blank" href="' . $url . '?utm_source=sexy%20author%20bio&utm_medium=sidebar%20feed&utm_campaign=wordpress%20plugin">' . esc_html( $item->get_title() ) . '</a> ';
							$content .= '</li>';
						}
					}
					$content .= '</ul>';
					echo $content;
				}
				pi_news();
				?>
			</div>

			</div>

		</div>
</div>