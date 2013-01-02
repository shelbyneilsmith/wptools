<?php get_header(); ?>
			
			<div id="container">
			
				<div id="content" class="wrap clearfix">

					<article id="post-not-found" class="hentry clearfix">
					
						<header class="article-header">
						
							<h2><?php _e("Epic 404 - Article Not Found", "bonestheme"); ?></h2>
					
						</header> <!-- end article header -->
				
						<section class="entry-content">
						
							<p><?php _e("The article you were looking for was not found, but maybe try looking again!", "bonestheme"); ?></p>
				
						</section> <!-- end article section -->

						<section class="search">
			
						    <p><?php get_search_form(); ?></p>
			
						</section> <!-- end search section -->
					
						<footer class="article-header">
						
						    <p><?php _e("This is the 404.php template.", "bonestheme"); ?></p>
						
						</footer> <!-- end article footer -->
				
					</article> <!-- end article -->

				</div> <!-- end #content -->
    
			</div> <!-- end #container -->

<?php get_footer(); ?>
