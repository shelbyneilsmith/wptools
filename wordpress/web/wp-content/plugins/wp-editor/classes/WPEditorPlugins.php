<?php
class WPEditorPlugins {
  
  public static function addPluginsPage() {
    if(!current_user_can('edit_plugins')) {
      wp_die('<p>' . __('You do not have sufficient permissions to edit plugins for this site.', 'wpeditor') . '</p>');
    }
    
    $plugins = get_plugins();

    if(empty($plugins)) {
      wp_die('<p>' . __('There are no plugins installed on this site.', 'wpeditor') . '</p>');
    }
    
    if(isset($_REQUEST['plugin'])) {
      $plugin = stripslashes($_REQUEST['plugin']);
    }
    if(isset($_REQUEST['file'])) {
      $file = stripslashes($_REQUEST['file']);
    }

    if(empty($plugin)) {
      $plugin = array_keys($plugins);
      $plugin = $plugin[0];
    }
    $plugin_files[] = $plugin;
    
    if(empty($file)) {
      $file = $plugin_files[0];
    }
    else {
      $file = stripslashes($file);
      $plugin = $file;
    }
    $pf = WPEditorBrowser::getFilesAndFolders((WPWINDOWS) ? str_replace("/", "\\", WP_PLUGIN_DIR . '/' . $file) : WP_PLUGIN_DIR . '/' . $file, 0, 'plugin');
    foreach($pf as $plugin_file) {
      foreach($plugin_file as $k => $p) {
        if($k == 'file') {
          $plugin_files[] = $p;
        }
      }
    }
    
    $file = validate_file_to_edit((WPWINDOWS) ? str_replace("/", "\\", $file) : $file, $plugin_files);
    $current_plugin_root = WP_PLUGIN_DIR . '/' . dirname($file);
    $real_file = WP_PLUGIN_DIR . '/' . $plugin;
    
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
      'plugins' => $plugins,
      'plugin' => $plugin,
      'plugin_files' => $plugin_files,
      'current_plugin_root' => $current_plugin_root,
      'real_file' => $real_file,
      'content' => $content,
      'scroll_to' => $scroll_to,
      'file' => $file,
      'content-type' => 'plugin'
    );
    echo WPEditor::getView('views/plugin-editor.php', $data);
  }
  
  public function pluginsHelpTab() {
    global $wpeditor_plugin;
    $screen = get_current_screen();
    if(function_exists('add_help_tab')) {
      $screen->add_help_tab(array(
        'id' => 'overview',
        'title' => __('Overview'),
        'content' => '<p>' . __('You can use the editor to make changes to any of your plugins&#8217; individual PHP files. Be aware that if you make changes, plugins updates will overwrite your customizations.', 'wpeditor') . '</p>' . '<p>' . __('Choose a plugin to edit from the menu in the upper right and click the Select button. Click once on any file name to load it in the editor, and make your changes. Don&#8217;t forget to save your changes (Update File) when you&#8217;re finished.', 'wpeditor') . '</p>' . '<p>' . __('The Documentation menu below the editor lists the PHP functions recognized in the plugin file. Clicking Lookup takes you to a web page about that particular function.', 'wpeditor') . '</p>' . '<p>' . __('If you want to make changes but don&#8217;t want them to be overwritten when the plugin is updated, you may be ready to think about writing your own plugin. For information on how to edit plugins, write your own from scratch, or just better understand their anatomy, check out the links below.', 'wpeditor') . '</p>' . (is_network_admin() ? '<p>' . __('Any edits to files from this screen will be reflected on all sites in the network.', 'wpeditor') . '</p>' : '' )
      ));
      $screen->set_help_sidebar(
        '<p><strong>' . __('For more information:', 'wpeditor') . '</strong></p>' . '<p>' . __('<a href="http://codex.wordpress.org/Plugins_Editor_Screen" target="_blank">Documentation on Editing Plugins</a>', 'wpeditor') . '</p>' . '<p>' . __('<a href="http://codex.wordpress.org/Writing_a_Plugin" target="_blank">Documentation on Writing Plugins</a>', 'wpeditor') . '</p>' . '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>', 'wpeditor') . '</p>'
      );
    }
    elseif(version_compare(get_bloginfo('version'), '3.3', '<')) {
      $help = '<p>' . __('You can use the editor to make changes to any of your plugins&#8217; individual PHP files. Be aware that if you make changes, plugins updates will overwrite your customizations.') . '</p>';
      $help .= '<p>' . __('Choose a plugin to edit from the menu in the upper right and click the Select button. Click once on any file name to load it in the editor, and make your changes. Don&#8217;t forget to save your changes (Update File) when you&#8217;re finished.') . '</p>';
      $help .= '<p>' . __('The Documentation menu below the editor lists the PHP functions recognized in the plugin file. Clicking Lookup takes you to a web page about that particular function.') . '</p>';
      $help .= '<p>' . __('If you want to make changes but don&#8217;t want them to be overwritten when the plugin is updated, you may be ready to think about writing your own plugin. For information on how to edit plugins, write your own from scratch, or just better understand their anatomy, check out the links below.') . '</p>';
      if(is_network_admin()) {
        $help .= '<p>' . __('Any edits to files from this screen will be reflected on all sites in the network.') . '</p>';
      }
      $help .= '<p><strong>' . __('For more information:') . '</strong></p>';
      $help .= '<p>' . __('<a href="http://codex.wordpress.org/Plugins_Editor_Screen" target="_blank">Documentation on Editing Plugins</a>') . '</p>';
      $help .= '<p>' . __('<a href="http://codex.wordpress.org/Writing_a_Plugin" target="_blank">Documentation on Writing Plugins</a>') . '</p>';
      $help .= '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>') . '</p>';
      add_contextual_help($screen, $help);
    }
  }
  
}