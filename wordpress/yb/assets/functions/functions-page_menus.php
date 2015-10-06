<?php

/* add menus meta box to page edit screen */
/* page menus meta box */
function yb_page_menus_add_meta_box( $post_type ) {
  add_meta_box(
    'yb_page_menus-meta-box', /* id, used as the html id att */
    __('Add to Menus', 'yb'), /* meta box title, like "Page Attributes" */
    'yb_page_menus_meta_box_cb', /* callback function, spits out the content */
    'page', /* post type or page. We'll add this to pages only */
    'side', /* context (where on the screen */
      'core' /* priority, where should this go in the context? */
      );
}
add_action( 'add_meta_boxes', 'yb_page_menus_add_meta_box' );

/* check if page is in menu */
function checkMenuForPage( $menuID, $pageID ) {
  global $wpdb;

  $menu_items = wp_get_nav_menu_items( $menuID );
  foreach( $menu_items as $menu_item) {
    $item_id = get_post_meta( $menu_item->ID, '_menu_item_object_id', true );
    if( $item_id == $pageID ) {
      return $menu_item->ID;
    }
  }
}

/* callback function for our meta box. echos out the content */
function yb_page_menus_meta_box_cb( $post ) {
  global $post;

  wp_nonce_field( 'yb_page_menus_nonce', 'meta_box_nonce' );

  $menus = wp_get_nav_menus();
  echo "<p><strong>Add this page to the following menus:</strong></p>";

  foreach ( $menus as $menu ) {
    $checked = '';
    if ( checkMenuForPage($menu->term_id, $post->ID) ) {
      $checked = 'checked="checked"'; 
    }

    echo "<input type='checkbox' name='nav-menu-group[]' value='" . $menu->name . "' " . $checked . " />" . $menu->name . "<br />";
  }
}

/* save our custom field value */
function yb_page_menus_save_post( $post_id, $post_object ) {
  if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
  if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'yb_page_menus_nonce' ) ) return;

  /* If this is just a revision, don't save in menu */
  if ( wp_is_post_revision( $post_id ) ) return;

  /* save the data with update_post_meta */
  $all_menus = wp_get_nav_menus();

  /* save the data with update_post_meta */
  foreach ( $all_menus as $menu ) {
    $menuID = (int) $menu->term_id;
    if (isset($_POST['nav-menu-group']) && in_array($menu->name, $_POST['nav-menu-group'])) {
      if ( !checkMenuForPage($menuID, $post_id) ) {
        $itemData = array(
          'menu-item-object-id' => $post_id,
          'menu-item-title' => __(get_the_title($post_id)),
          'menu-item-url' => get_permalink($post_id),
          'menu-item-object' => 'page',
          'menu-item-position' => $post_object->menu_order,
          'menu-item-type' => 'post_type',
          'menu-item-status' => 'publish'
          );
        remove_action( 'save_post', 'yb_page_menus_save_post', 13, 2 );
        wp_update_nav_menu_item( $menuID, 0, $itemData );
        add_action( 'save_post', 'yb_page_menus_save_post', 13, 2 );
      }
    } else {
      $isInMenu = checkMenuForPage($menuID, $post_id);
      if ( $isInMenu ) {
        wp_delete_post($isInMenu);
      }
    }
  }
}
add_action('pre_post_update', 'yb_page_menus_save_post', 13, 2 );

?>