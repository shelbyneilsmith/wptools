<div class="content-post content-custom_type clearfix">

  <div class="post-image">

    <a href="<?php the_permalink(); ?>" title="Permalink to <?php echo the_title_attribute('echo=0'); ?>" rel="bookmark">

      <?php 
      if ( has_post_thumbnail() ) { the_post_thumbnail($thumbnail_size); } 
      else { echo '<div class="no-post-image"></div>'; }
      ?>

    </a>

  </div>

  <a href="#" class="post-icon standard"></a>

  <div class="post-content">

    <div class="post-title">
      <h2>
        <a href="<?php the_permalink(); ?>" title="Permalink to <?php echo the_title_attribute('echo=0'); ?>" rel="bookmark">
          <?php the_title(); ?>
        </a>
      </h2>
    </div>
    <div class="post-excerpt">
      <?php the_excerpt(); ?>
    </div>
  </div>

</div><!-- .post -->