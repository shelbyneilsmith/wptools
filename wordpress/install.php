<?php
  function wp_install_defaults() {
    global $wpdb;
    // Default category
    $cat_name = esc_sql(__('Uncategorized'));
    $cat_slug = sanitize_title(__('Uncategorized|Default category slug'));
    $wpdb->query("INSERT INTO $wpdb->terms (name, slug, term_group) VALUES ('$cat_name', '$cat_slug', '0')");
    $wpdb->query("INSERT INTO $wpdb->term_taxonomy (term_id, taxonomy, description, parent, count) VALUES ('1', 'category', '', '0', '1')");
    }
?>