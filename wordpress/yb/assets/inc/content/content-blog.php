<div class="content-post content-blog clearfix">

  <?php if (has_post_thumbnail()): ?>
    <div class="post-image">
      <a href="<?php the_permalink(); ?>" title="Permalink to <?php echo the_title_attribute('echo=0'); ?>" rel="bookmark">

        <?php 
        $blog_layout_classes = yb_blog_layout_class();
        if (in_array('blog-fullwidth', $blog_layout_classes)) {
          $thumbnail_size = 'large';
        } else {
          $thumbnail_size = 'medium';
        }

        the_post_thumbnail($thumbnail_size);
        ?>

      </a>
    </div>
  <?php endif ?>

  <!-- <a href="#" class="post-icon standard"></a> -->

  <div class="post-content">
    <h2 class="post-title">
      <a href="<?php the_permalink(); ?>" title="Permalink to <?php echo the_title_attribute('echo=0'); ?>" rel="bookmark">
        <?php the_title(); ?>
      </a>
    </h2>

    <div class="post-excerpt">
      <?php the_excerpt(); ?>
    </div>

  </div>

  <div class="post-meta">
    <?php get_template_part( 'assets/inc/partial/partial', 'meta' ); ?>
  </div>
</div>