<?php
class WPEditorThemes {
  
  public static function addThemesPage() {
    if(!current_user_can('edit_themes')) {
      wp_die('<p>' . __('You do not have sufficient permissions to edit templates for this site.', 'wpeditor') . '</p>');
    }
    
    if(WP_34) {
      $themes = wp_get_themes();
    }
    else {
      $themes = get_themes();
    }
    
    if(empty($themes)) {
      wp_die('<p>' . __('There are no themes installed on this site.', 'wpeditor') . '</p>');
    }
    
    if(isset($_REQUEST['theme'])) {
      $theme = stripslashes($_REQUEST['theme']);
    }
    if(isset($_REQUEST['file'])) {
      $file = stripslashes($_REQUEST['file']);
    }
    
    if(empty($theme)) {
      if(WP_34) {
        $theme = wp_get_theme();
      }
      else {
        $theme = get_current_theme();
      }
    }
    
    $stylesheet = '';
    if($theme && WP_34) {
      $stylesheet = urldecode($theme);
      if(is_object($theme)) {
        $stylesheet = urldecode($theme->stylesheet);
      }
    }
    elseif(WP_34) {
      $stylesheet = get_stylesheet();
    }
    
    if(WP_34) {
      $wp_theme = wp_get_theme($stylesheet);
    }
    else {
      $wp_theme = '';
    }
    
    if(empty($file)) {
      if(WP_34) {
        $file = basename($wp_theme['Stylesheet Dir']) . '/style.css';
      }
      else {
        $file = basename($themes[$theme]['Stylesheet Dir']) . '/style.css';
      }
    }
    else {
      $file = stripslashes($file);
    }
    
    if(WP_34) {
      $tf = WPEditorBrowser::getFilesAndFolders((WPWINDOWS) ? str_replace("/", "\\", $wp_theme['Theme Root'] . '/' . $file) : $wp_theme['Theme Root'] . '/' . $file, 0, 'theme');
    }
    else {
      $tf = WPEditorBrowser::getFilesAndFolders((WPWINDOWS) ? str_replace("/", "\\", $themes[$theme]['Theme Root'] . '/' . $file) : $themes[$theme]['Theme Root'] . '/' . $file, 0, 'theme');
    }
    
    foreach($tf as $theme_file) {
      foreach($theme_file as $k => $t) {
        if($k == 'file') {
          $theme_files[] = $t;
        }
      }
    }
    
    $file = validate_file_to_edit((WPWINDOWS) ? str_replace("/", "\\", $file) : $file, $theme_files);
    if(WP_34) {
      $current_theme_root = $wp_theme['Theme Root'] . '/' . dirname($file) . '/';
    }
    else {
      $current_theme_root = $themes[$theme]['Theme Root'] . '/' . dirname($file) . '/';
    }
    $real_file = $current_theme_root . basename($file);
        
    if(isset($_POST['new-content']) && file_exists($real_file) && is_writable($real_file)) {
      $new_content = stripslashes($_POST['new-content']);
      if(file_get_contents($real_file) === $new_content) {
        WPEditorLog::log('[' . basename(__FILE__) . ' - line ' . __LINE__ . "] Contents are the same");
      }
      else {
        $f = fopen($real_file, 'w+');
        fwrite($f, $new_content);
        fclose($f);
        WPEditorLog::log('[' . basename(__FILE__) . ' - line ' . __LINE__ . "] just wrote to $real_file");
      }
    }
    
    $content = file_get_contents($real_file);

    $content = esc_textarea($content);
    
    $scroll_to = isset($_REQUEST['scroll_to']) ? (int) $_REQUEST['scroll_to'] : 0;
    
    $data = array(
      'themes' => $themes,
      'theme' => $theme,
      'wp_theme' => $wp_theme,
      'stylesheet' => $stylesheet,
      'theme_files' => $theme_files,
      'current_theme_root' => $current_theme_root,
      'real_file' => $real_file,
      'content' => $content,
      'scroll_to' => $scroll_to,
      'file' => $file,
      'content-type' => 'theme'
    );
    echo WPEditor::getView('views/theme-editor.php', $data);
  }
  
  public function themesHelpTab() {
    global $wpeditor_themes;
    $screen = get_current_screen();
    if(function_exists('add_help_tab') && function_exists('set_help_sidebar')) {
      $screen->add_help_tab(array(
        'id' => 'overview',
        'title' => __('Overview', 'wpeditor'),
        'content' => '<p>' . __('You can use the Theme Editor to edit the individual files which make up your theme.', 'wpeditor') . '</p>' . '<p>' . __('Begin by choosing a theme to edit from the dropdown menu and clicking Select. A list then appears of all the template files. Clicking once on any file name causes the file to appear in the large Editor box.', 'wpeditor') . '</p>' . '<p>' . __('After typing in your edits, click Update File.', 'wpeditor') . '</p>' . '<p>' . __('<strong>Advice:</strong> think very carefully about your site crashing if you are live-editing the theme currently in use.', 'wpeditor') . '</p>' . '<p>' . __('Upgrading to a newer version of the same theme will override changes made here. To avoid this, consider creating a <a href="http://codex.wordpress.org/Child_Themes" target="_blank">child theme</a> instead.', 'wpeditor') . '</p>' . (is_network_admin() ? '<p>' . __('Any edits to files from this screen will be reflected on all sites in the network.', 'wpeditor') . '</p>' : '')
      ));
      $screen->set_help_sidebar(
        '<p><strong>' . __('For more information:', 'wpeditor') . '</strong></p>' . '<p>' . __('<a href="http://codex.wordpress.org/Theme_Development" target="_blank">Documentation on Theme Development</a>', 'wpeditor') . '</p>' . '<p>' . __('<a href="http://codex.wordpress.org/Using_Themes" target="_blank">Documentation on Using Themes</a>', 'wpeditor') . '</p>' . '<p>' . __('<a href="http://codex.wordpress.org/Editing_Files" target="_blank">Documentation on Editing Files</a>', 'wpeditor') . '</p>' . '<p>' . __('<a href="http://codex.wordpress.org/Template_Tags" target="_blank">Documentation on Template Tags</a>', 'wpeditor') . '</p>' . '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>', 'wpeditor') . '</p>'
      );
    }
    elseif(version_compare(get_bloginfo('version'), '3.3', '<')) {
      $help = '<p>' . __('You can use the Theme Editor to edit the individual files which make up your theme.') . '</p>';
      $help .= '<p>' . __('Begin by choosing a theme to edit from the dropdown menu and clicking Select. A list then appears of all the template files. Clicking once on any file name causes the file to appear in the large Editor box.') . '</p>';
      $help .= '<p>' . __('After typing in your edits, click Update File.') . '</p>';
      $help .= '<p>' . __('<strong>Advice:</strong> think very carefully about your site crashing if you are live-editing the theme currently in use.') . '</p>';
      $help .= '<p>' . __('Upgrading to a newer version of the same theme will override changes made here. To avoid this, consider creating a <a href="http://codex.wordpress.org/Child_Themes" target="_blank">child theme</a> instead.') . '</p>';
      if(is_network_admin()) {
        $help .= '<p>' . __('Any edits to files from this screen will be reflected on all sites in the network.') . '</p>';
      }
      $help .= '<p><strong>' . __('For more information:') . '</strong></p>';
      $help .= '<p>' . __('<a href="http://codex.wordpress.org/Theme_Development" target="_blank">Documentation on Theme Development</a>') . '</p>';
      $help .= '<p>' . __('<a href="http://codex.wordpress.org/Using_Themes" target="_blank">Documentation on Using Themes</a>') . '</p>';
      $help .= '<p>' . __('<a href="http://codex.wordpress.org/Editing_Files" target="_blank">Documentation on Editing Files</a>') . '</p>';
      $help .= '<p>' . __('<a href="http://codex.wordpress.org/Template_Tags" target="_blank">Documentation on Template Tags</a>') . '</p>';
      $help .= '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>') . '</p>';
      add_contextual_help($screen, $help);
    }
  }

}