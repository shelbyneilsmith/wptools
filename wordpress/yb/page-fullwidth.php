<?php 
/*
*
* Template Name: Fullwidth Template
*
*/
?>

<?php get_header(); ?>

<div id="page-wrap" <?php post_class('full-width'); ?>>

  <?php get_template_part('assets/inc/partial/partial', 'title_page'); ?>

  <div id="page-inner" class="container">

    <div id="content" class="">

      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <?php the_content(); ?>

        <?php get_template_part('assets/inc/partial/partial', 'comments'); ?>

      <?php endwhile; endif; ?>

    </div> <!-- #content -->

    <?php get_sidebar(); ?>

  </div><!-- #page-inner -->
  
</div><!-- #page-wrap -->

<?php get_footer(); ?>