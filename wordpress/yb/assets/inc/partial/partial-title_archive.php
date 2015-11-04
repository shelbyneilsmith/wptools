<?php global $ybwp_data; ?>

<?php
  if (is_category()) {
    $page_title = __('Category: ', 'yb') . single_cat_title('', false);
  } 
  elseif( is_tag() ) {
    $page_title = __('Tag: ', 'yb') . '&#8216;' . single_tag_title() . '&#8217;';
  } 
  elseif (is_day()) {
    $page_title = __('Daily Archive: ', 'yb') . the_time('F jS, Y');
  } 
  elseif (is_month()) {
    $page_title = __('Monthly Archive: ', 'yb') . the_time('F, Y');
  } 
  elseif (is_year()) {
    $page_title = __('Yearly Archive: ', 'yb') . the_time('Y');
  } 
  elseif (is_author()) {
    $author = get_user_by('slug', get_query_var('author_name'));
    $author = get_the_author_meta('display_name', $author->ID);
    $page_title = __('Author Archive: ', 'yb') . $author;
  } 
  elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
    $page_title = __('Blog Archives', 'yb');
  } 
  elseif (is_shop()) {
    $page_title = woocommerce_page_title();
  }
  elseif ( is_post_type_archive( get_post_type() ) ) {
    $post_type_object = get_post_type_object( get_post_type() );
    $page_title = $post_type_object->labels->name;
  }

  /* Prefix blog archives with custom blog name */
  if (!empty($ybwp_data['opt-checkbox-showblogtitlearchives']) && !is_post_type_archive( get_post_type() ) ) {
    $page_title = $ybwp_data['opt-text-blogtitle'] . ' | ' . $page_title;
  }
?>

<div id="title">
  <div class="container">
    <div class="sixteen columns">
      <h1 class="page-title archive-title blog-title"><?php echo $page_title; ?></h1>

      <?php get_template_part('assets/inc/partial/partial', 'breadcrumbs'); ?>
    </div>
  </div>
</div>