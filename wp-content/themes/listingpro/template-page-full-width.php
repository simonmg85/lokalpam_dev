<?php 

/**
 * Template name: Page without sidebar
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 */

get_header();
the_post();

	?>
	<!-- section-contianer open -->
	<div class="section-contianer">
		
			<div class="container page-container-five">
				<!-- page title close -->
				<div class="row">
					<!-- content open -->
					<div class="col-md-12 col-sm-12">
						<div class="blog-post clearfix">
						<div class="post-content blog-test-page">
						<?php the_content(); ?>
						</div>
						<?php wp_link_pages(); ?>
						<?php comments_template('', true); ?>
					</div>
					</div>
					<!-- content close -->
					 
					
				</div>
			</div>
		
	</div>
					
					
				
		
				
	

	<?php

get_footer(); ?>