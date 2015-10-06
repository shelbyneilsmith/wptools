<title>
  <?php
  $page_title = '';

  if (!is_front_page()) {
    $page_title .= wp_title('');
  }
  else {
    $page_title .= get_bloginfo('name');
    $page_title .= " - ";
    $page_title .= get_bloginfo('description');
  }

  echo $page_title;
  ?>
</title>