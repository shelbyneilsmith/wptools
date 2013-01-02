<?php
  $tab = 'overview';
  if(WPEditorSetting::getValue('settings_tab')) {
    $tab = WPEditorSetting::getValue('settings_tab');
  }
  if(!WPEditorSetting::getValue('run_overview')) {
    $tab = 'overview';
  }
  WPEditorSetting::setValue('run_overview', 1);
  $success_message = '';
?>

<div class="wrap">
  <div id="icon-wpeditor" class="icon32"></div>
  <h2><?php _e('WP Editor Settings', 'wpeditor'); ?></h2>
  <div id="settings-main">
    <div id="settings-main-wrap">
      <div id="settings-back"></div>
      <div id="save-result"></div>
      <div id="settings-columns">
        <div class="settings-tabs">
          <ul>
            <li id="settings-main-settings-tab"><a id="settings-link-main-settings" href="javascript:void(0)"><?php _e('Main Settings', 'wpeditor'); ?></a></li>
            <li id="settings-themes-tab"><a id="settings-link-themes" href="javascript:void(0)"><?php _e('Theme Editor', 'wpeditor'); ?></a></li>
            <li id="settings-plugins-tab"><a id="settings-link-plugins" href="javascript:void(0)"><?php _e('Plugin Editor', 'wpeditor'); ?></a></li>
            <li id="settings-posts-tab"><a id="settings-link-posts" href="javascript:void(0)"><?php _e('Post Editor', 'wpeditor'); ?></a></li>
            <li id="settings-overview-tab"><a id="settings-link-overview" href="javascript:void(0)"><?php _e('Overview', 'wpeditor'); ?></a></li>
          </ul>
        </div>
        <div id="settings-loading">
          <h2><?php _e('loading...', 'wpeditor'); ?></h2>
        </div>
        <div id="settings-main-settings" class="settings-body">
          <form action="" method="post" class="ajax-settings-form" id="settings-form">
            <input type="hidden" name="action" value="save_wpeditor_settings" />
            <input type="hidden" name="_success" value="Your main settings have been saved." />
            <input type="hidden" name="_tab" value="main-settings" />
            <div id="replace-plugin-edit-links" class="section">
              <div class="section-header">
                <h3><?php _e('Plugin Edit Links', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="replace_plugin_edit_links"><?php _e('Replace Default Plugin Edit Links:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input type="radio" name="replace_plugin_edit_links" value="1" <?php echo (WPEditorSetting::getValue('replace_plugin_edit_links') == 1) ? 'checked="checked"' : ''; ?>> <?php _e('Yes', 'wpeditor'); ?>
                    <input type="radio" name="replace_plugin_edit_links" value="0" <?php echo (WPEditorSetting::getValue('replace_plugin_edit_links') != 1) ? 'checked="checked"' : ''; ?>> <?php _e('No', 'wpeditor'); ?>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will replace the default edit links on the Installed Plugins page with WP Editor links.<br />Default: Yes", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="hide-default-editors" class="section">
              <div class="section-header">
                <h3><?php _e('Hide Default Editors', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="hide_default_plugin_editor"><?php _e('Hide Default Plugin Editor:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input type="radio" name="hide_default_plugin_editor" value="1" <?php echo (WPEditorSetting::getValue('hide_default_plugin_editor') == 1) ? 'checked="checked"' : ''; ?>> <?php _e('Yes', 'wpeditor'); ?>
                    <input type="radio" name="hide_default_plugin_editor" value="0" <?php echo (WPEditorSetting::getValue('hide_default_plugin_editor') != 1) ? 'checked="checked"' : ''; ?>> <?php _e('No', 'wpeditor'); ?>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will hide the default Edit submenu for the plugins page.<br />Default: Yes", 'wpeditor'); ?></p>
                  </li>
                  <li>
                    <label for="hide_default_theme_editor"><?php _e('Hide Default Theme Editor:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input type="radio" name="hide_default_theme_editor" value="1" <?php echo (WPEditorSetting::getValue('hide_default_theme_editor') == 1) ? 'checked="checked"' : ''; ?>> <?php _e('Yes', 'wpeditor'); ?>
                    <input type="radio" name="hide_default_theme_editor" value="0" <?php echo (WPEditorSetting::getValue('hide_default_theme_editor') != 1) ? 'checked="checked"' : ''; ?>> <?php _e('No', 'wpeditor'); ?>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will hide the default Edit submenu for the themes page.<br />Default: Yes", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="logging" class="section">
              <div class="section-header">
                <h3><?php _e('Logging', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="wpeditor_logging"><?php _e('Enable Logging:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input type="radio" name="wpeditor_logging" value="1" <?php echo (WPEditorSetting::getValue('wpeditor_logging') == 1) ? 'checked="checked"' : ''; ?>> <?php _e('Yes', 'wpeditor'); ?>
                    <input type="radio" name="wpeditor_logging" value="0" <?php echo (WPEditorSetting::getValue('wpeditor_logging') != 1) ? 'checked="checked"' : ''; ?>> <?php _e('No', 'wpeditor'); ?>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will enable diagnostic logging on the site.  WARNING: This file grows quickly so please only enable if you are troubleshooting.<br />Default: No", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="menu-location" class="section">
              <div class="section-header">
                <h3><?php _e('WP Editor Menu Location', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="hide_wpeditor_menu"><?php _e('Hide WP Editor Icon:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input type="radio" name="hide_wpeditor_menu" value="1" <?php echo (WPEditorSetting::getValue('hide_wpeditor_menu') == 1) ? 'checked="checked"' : ''; ?>> <?php _e('Yes', 'wpeditor'); ?>
                    <input type="radio" name="hide_wpeditor_menu" value="0" <?php echo (WPEditorSetting::getValue('hide_wpeditor_menu') != 1) ? 'checked="checked"' : ''; ?>> <?php _e('No', 'wpeditor'); ?>
                  </li>
                  <li class="indent description">
                    <p><?php _e("If set to yes, this will hide the WP Editor icon from the menu on the left. You will be able to access this settings page from the main Settings drop down instead.<br />Default: No", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="save-settings">
              <ul>
                <li>
                  <input type='submit' name='submit' class="button-primary" value="<?php _e('Save Settings', 'wpeditor'); ?>" />
                </li>
              </ul>
            </div>
          </form>
        </div>
        <div id="settings-themes" class="settings-body">
          <form action="" method="post" class="ajax-settings-form" id="theme-settings-form">
            <input type="hidden" name="action" value="save_wpeditor_settings" />
            <input type="hidden" name="_success" value="Your theme settings have been saved." />
            <input type="hidden" name="_tab" value="themes" />
            <div id="theme-editor-theme" class="section">
              <div class="section-header">
                <h3><?php _e('Editor Theme', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="theme_editor_theme"><?php _e('Theme:', 'wpeditor'); ?></label>
                    <select id="theme_editor_theme" name="theme_editor_theme">
                      <?php
                      $theme = 'default';
                      if(WPEditorSetting::getValue('theme_editor_theme')) {
                        $theme = WPEditorSetting::getValue('theme_editor_theme');
                      }
                      ?>
                      <option value="default" <?php echo ($theme == 'default') ? 'selected="selected"' : '' ?>><?php _e('Default', 'wpeditor'); ?></option>
                      <option value="ambiance" <?php echo ($theme == 'ambiance') ? 'selected="selected"' : '' ?>><?php _e('Ambiance', 'wpeditor'); ?></option>
                      <option value="blackboard" <?php echo ($theme == 'blackboard') ? 'selected="selected"' : '' ?>><?php _e('Blackboard', 'wpeditor'); ?></option>
                      <option value="cobalt" <?php echo ($theme == 'cobalt') ? 'selected="selected"' : '' ?>><?php _e('Cobalt', 'wpeditor'); ?></option>
                      <option value="eclipse" <?php echo ($theme == 'eclipse') ? 'selected="selected"' : '' ?>><?php _e('Eclipse', 'wpeditor'); ?></option>
                      <option value="elegant" <?php echo ($theme == 'elegant') ? 'selected="selected"' : '' ?>><?php _e('Elegant', 'wpeditor'); ?></option>
                      <option value="lesser-dark" <?php echo ($theme == 'lesser-dark') ? 'selected="selected"' : '' ?>><?php _e('Lesser Dark', 'wpeditor'); ?></option>
                      <option value="monokai" <?php echo ($theme == 'monokai') ? 'selected="selected"' : '' ?>><?php _e('Monokai', 'wpeditor'); ?></option>
                      <option value="neat" <?php echo ($theme == 'neat') ? 'selected="selected"' : '' ?>><?php _e('Neat', 'wpeditor'); ?></option>
                      <option value="night" <?php echo ($theme == 'night') ? 'selected="selected"' : '' ?>><?php _e('Night', 'wpeditor'); ?></option>
                      <option value="rubyblue" <?php echo ($theme == 'rubyblue') ? 'selected="selected"' : '' ?>><?php _e('Ruby Blue', 'wpeditor'); ?></option>
                      <option value="vibrant-ink" <?php echo ($theme == 'vibrant-ink') ? 'selected="selected"' : '' ?>><?php _e('Vibrant Ink', 'wpeditor'); ?></option>
                      <option value="xq-dark" <?php echo ($theme == 'xq-dark') ? 'selected="selected"' : '' ?>><?php _e('XQ-Dark', 'wpeditor'); ?></option>
                    </select>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This allows you to select the theme for the theme editor.<br />Default: Default", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="theme-editor-extensions" class="section">
              <div class="section-header">
                <h3><?php _e('Extensions', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="theme_editor_allowed_extensions"><?php _e('Allowed Extensions:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <?php
                    $allowed_extensions = WPEditorSetting::getValue('theme_editor_allowed_extensions');
                    if($allowed_extensions) {
                      $allowed_extensions = explode('~', $allowed_extensions);
                    }
                    else {
                      $allowed_extensions = array();
                    }
                    ?>
                    <input type="checkbox" name="theme_editor_allowed_extensions[]" value="php" <?php echo in_array('php', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.php', 'wpeditor'); ?></label>
                    <input type="checkbox" name="theme_editor_allowed_extensions[]" value="js" <?php echo in_array('js', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.js', 'wpeditor'); ?></label>
                    <input type="checkbox" name="theme_editor_allowed_extensions[]" value="css" <?php echo in_array('css', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.css', 'wpeditor'); ?></label>
                    <input type="checkbox" name="theme_editor_allowed_extensions[]" value="txt" <?php echo in_array('txt', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.txt', 'wpeditor'); ?></label>
                    <input type="checkbox" name="theme_editor_allowed_extensions[]" value="htm" <?php echo in_array('htm', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.htm', 'wpeditor'); ?></label>
                    <input type="checkbox" name="theme_editor_allowed_extensions[]" value="html" <?php echo in_array('html', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.html', 'wpeditor'); ?></label>
                    <input type="checkbox" name="theme_editor_allowed_extensions[]" value="jpg" <?php echo in_array('jpg', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.jpg', 'wpeditor'); ?></label>
                    <input type="checkbox" name="theme_editor_allowed_extensions[]" value="jpeg" <?php echo in_array('jpeg', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.jpeg', 'wpeditor'); ?></label>
                    <input type="checkbox" name="theme_editor_allowed_extensions[]" value="png" <?php echo in_array('png', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.png', 'wpeditor'); ?></label>
                    <input type="checkbox" name="theme_editor_allowed_extensions[]" value="gif" <?php echo in_array('gif', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.gif', 'wpeditor'); ?></label>
                    <input type="checkbox" name="theme_editor_allowed_extensions[]" value="sql" <?php echo in_array('sql', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.sql', 'wpeditor'); ?></label>
                    <input type="checkbox" name="theme_editor_allowed_extensions[]" value="po" <?php echo in_array('po', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.po', 'wpeditor'); ?></label>
                    <input type="checkbox" name="theme_editor_allowed_extensions[]" value="pot" <?php echo in_array('pot', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.pot', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent description">
                    <p><?php _e('Select which extensions you would like the theme editor browser to be able to access.', 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="enable-theme-line-numbers" class="section">
              <div class="section-header">
                <h3><?php _e('Line Numbers', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="enable_theme_line_numbers"><?php _e('Enable Line Numbers:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input type="radio" name="enable_theme_line_numbers" value="1" <?php echo (WPEditorSetting::getValue('enable_theme_line_numbers') == 1) ? 'checked="checked"' : ''; ?>> <?php _e('Yes', 'wpeditor'); ?>
                    <input type="radio" name="enable_theme_line_numbers" value="0" <?php echo (WPEditorSetting::getValue('enable_theme_line_numbers') != 1) ? 'checked="checked"' : ''; ?>> <?php _e('No', 'wpeditor'); ?>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will enable line numbers for the theme editor.<br />Default: Yes", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="enable-theme-line-wrapping" class="section">
              <div class="section-header">
                <h3><?php _e('Line Wrapping', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="enable_theme_line_wrapping"><?php _e('Enable Line Wrapping:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input type="radio" name="enable_theme_line_wrapping" value="1" <?php echo (WPEditorSetting::getValue('enable_theme_line_wrapping') == 1) ? 'checked="checked"' : ''; ?>> <?php _e('Yes', 'wpeditor'); ?>
                    <input type="radio" name="enable_theme_line_wrapping" value="0" <?php echo (WPEditorSetting::getValue('enable_theme_line_wrapping') != 1) ? 'checked="checked"' : ''; ?>> <?php _e('No', 'wpeditor'); ?>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will enable line wrapping for the theme editor.<br />Default: Yes", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="enable-theme-active-line" class="section">
              <div class="section-header">
                <h3><?php _e('Active Line Highlighting', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="enable_theme_active_line"><?php _e('Highlight Active Line:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input type="radio" name="enable_theme_active_line" value="1" <?php echo (WPEditorSetting::getValue('enable_theme_active_line') == 1) ? 'checked="checked"' : ''; ?>> <?php _e('Yes', 'wpeditor'); ?>
                    <input type="radio" name="enable_theme_active_line" value="0" <?php echo (WPEditorSetting::getValue('enable_theme_active_line') != 1) ? 'checked="checked"' : ''; ?>> <?php _e('No', 'wpeditor'); ?>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will enable highlighting of the active line for the theme editor.<br />Default: Yes", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="enable-theme-tab-characters" class="section">
              <div class="section-header">
                <h3><?php _e('Tab Characters', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="enable_theme_tab_characters"><?php _e('Tab Characters:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <select name="enable_theme_tab_characters">
                      <option value="spaces"<?php echo WPEditorSetting::getValue('enable_theme_tab_characters') == 'spaces' ? ' selected="selected"' : ''; ?>><?php _e('Spaces', 'wpeditor'); ?></option>
                      <option value="tabs"<?php echo WPEditorSetting::getValue('enable_theme_tab_characters') == 'tabs' ? ' selected="selected"' : ''; ?>><?php _e('Tabs', 'wpeditor'); ?></option>
                    </select>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will set the tab character for the theme editor.<br />Default: Spaces", 'wpeditor'); ?></p>
                  </li>
                  <li>
                    <label for="enable_theme_tab_size"><?php _e('Tab Size:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input class="small-text" name="enable_theme_tab_size" value="<?php echo WPEditorSetting::getValue('enable_theme_tab_size') ? WPEditorSetting::getValue('enable_theme_tab_size') : 2; ?>" />
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will set the tab size for the theme editor.<br />Default: 2", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="enable-theme-editor-height" class="section">
              <div class="section-header">
                <h3><?php _e('Tab Characters', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="enable_theme_editor_height"><?php _e('Editor Height:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input class="small-text" name="enable_theme_editor_height" value="<?php echo WPEditorSetting::getValue('enable_theme_editor_height') ? WPEditorSetting::getValue('enable_theme_editor_height') : 450; ?>" />
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will set the height in pixels for the theme editor.<br />Default: 450", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="enable-theme-file-upload" class="section">
              <div class="section-header">
                <h3><?php _e('File Upload', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="theme_file_upload"><?php _e('Enable File Upload:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input type="radio" name="theme_file_upload" value="1" <?php echo (WPEditorSetting::getValue('theme_file_upload') == 1) ? 'checked="checked"' : ''; ?>> <?php _e('Yes', 'wpeditor'); ?>
                    <input type="radio" name="theme_file_upload" value="0" <?php echo (WPEditorSetting::getValue('theme_file_upload') != 1) ? 'checked="checked"' : ''; ?>> <?php _e('No', 'wpeditor'); ?>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will enable a file upload option for the theme editor.<br />Default: Yes", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="save-settings">
              <ul>
                <li>
                  <input type='submit' name='submit' class="button-primary" value="<?php _e('Save Settings', 'wpeditor'); ?>" />
                </li>
              </ul>
            </div>
          </form>
        </div>
        <div id="settings-plugins" class="settings-body">
          <form action="" method="post" class="ajax-settings-form" id="plugin-settings-form">
            <input type="hidden" name="action" value="save_wpeditor_settings" />
            <input type="hidden" name="_success" value="Your plugin settings have been saved." />
            <input type="hidden" name="_tab" value="plugins" />
            <div id="plugin-editor-theme" class="section">
              <div class="section-header">
                <h3><?php _e('Editor Theme', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="plugin_editor_theme"><?php _e('Theme:', 'wpeditor'); ?></label>
                    <select id="plugin_editor_theme" name="plugin_editor_theme">
                      <?php
                      $theme = 'default';
                      if(WPEditorSetting::getValue('plugin_editor_theme')) {
                        $theme = WPEditorSetting::getValue('plugin_editor_theme');
                      }
                      ?>
                      <option value="default" <?php echo ($theme == 'default') ? 'selected="selected"' : '' ?>><?php _e('Default', 'wpeditor'); ?></option>
                      <option value="ambiance" <?php echo ($theme == 'ambiance') ? 'selected="selected"' : '' ?>><?php _e('Ambiance', 'wpeditor'); ?></option>
                      <option value="blackboard" <?php echo ($theme == 'blackboard') ? 'selected="selected"' : '' ?>><?php _e('Blackboard', 'wpeditor'); ?></option>
                      <option value="cobalt" <?php echo ($theme == 'cobalt') ? 'selected="selected"' : '' ?>><?php _e('Cobalt', 'wpeditor'); ?></option>
                      <option value="eclipse" <?php echo ($theme == 'eclipse') ? 'selected="selected"' : '' ?>><?php _e('Eclipse', 'wpeditor'); ?></option>
                      <option value="elegant" <?php echo ($theme == 'elegant') ? 'selected="selected"' : '' ?>><?php _e('Elegant', 'wpeditor'); ?></option>
                      <option value="lesser-dark" <?php echo ($theme == 'lesser-dark') ? 'selected="selected"' : '' ?>><?php _e('Lesser Dark', 'wpeditor'); ?></option>
                      <option value="monokai" <?php echo ($theme == 'monokai') ? 'selected="selected"' : '' ?>><?php _e('Monokai', 'wpeditor'); ?></option>
                      <option value="neat" <?php echo ($theme == 'neat') ? 'selected="selected"' : '' ?>><?php _e('Neat', 'wpeditor'); ?></option>
                      <option value="night" <?php echo ($theme == 'night') ? 'selected="selected"' : '' ?>><?php _e('Night', 'wpeditor'); ?></option>
                      <option value="rubyblue" <?php echo ($theme == 'rubyblue') ? 'selected="selected"' : '' ?>><?php _e('Ruby Blue', 'wpeditor'); ?></option>
                      <option value="vibrant-ink" <?php echo ($theme == 'vibrant-ink') ? 'selected="selected"' : '' ?>><?php _e('Vibrant Ink', 'wpeditor'); ?></option>
                      <option value="xq-dark" <?php echo ($theme == 'xq-dark') ? 'selected="selected"' : '' ?>><?php _e('XQ-Dark', 'wpeditor'); ?></option>
                    </select>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This allows you to select the theme for the plugin editor.<br />Default: Default", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="plugin-editor-extensions" class="section">
              <div class="section-header">
                <h3><?php _e('Extensions', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="plugin_editor_allowed_extensions"><?php _e('Allowed Extensions:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <?php
                    $allowed_extensions = WPEditorSetting::getValue('plugin_editor_allowed_extensions');
                    if($allowed_extensions) {
                      $allowed_extensions = explode('~', $allowed_extensions);
                    }
                    else {
                      $allowed_extensions = array();
                    }
                    ?>
                    <input type="checkbox" name="plugin_editor_allowed_extensions[]" value="php" <?php echo in_array('php', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.php', 'wpeditor'); ?></label>
                    <input type="checkbox" name="plugin_editor_allowed_extensions[]" value="js" <?php echo in_array('js', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.js', 'wpeditor'); ?></label>
                    <input type="checkbox" name="plugin_editor_allowed_extensions[]" value="css" <?php echo in_array('css', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.css', 'wpeditor'); ?></label>
                    <input type="checkbox" name="plugin_editor_allowed_extensions[]" value="txt" <?php echo in_array('txt', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.txt', 'wpeditor'); ?></label>
                    <input type="checkbox" name="plugin_editor_allowed_extensions[]" value="htm" <?php echo in_array('htm', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.htm', 'wpeditor'); ?></label>
                    <input type="checkbox" name="plugin_editor_allowed_extensions[]" value="html" <?php echo in_array('html', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.html', 'wpeditor'); ?></label>
                    <input type="checkbox" name="plugin_editor_allowed_extensions[]" value="jpg" <?php echo in_array('jpg', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.jpg', 'wpeditor'); ?></label>
                    <input type="checkbox" name="plugin_editor_allowed_extensions[]" value="jpeg" <?php echo in_array('jpeg', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.jpeg', 'wpeditor'); ?></label>
                    <input type="checkbox" name="plugin_editor_allowed_extensions[]" value="png" <?php echo in_array('png', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.png', 'wpeditor'); ?></label>
                    <input type="checkbox" name="plugin_editor_allowed_extensions[]" value="gif" <?php echo in_array('gif', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.gif', 'wpeditor'); ?></label>
                    <input type="checkbox" name="plugin_editor_allowed_extensions[]" value="sql" <?php echo in_array('sql', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.sql', 'wpeditor'); ?></label>
                    <input type="checkbox" name="plugin_editor_allowed_extensions[]" value="po" <?php echo in_array('po', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.po', 'wpeditor'); ?></label>
                    <input type="checkbox" name="plugin_editor_allowed_extensions[]" value="pot" <?php echo in_array('pot', $allowed_extensions) ? 'checked="checked"' : '' ?>>
                    <label class="checkbox_label"><?php _e('.pot', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent description">
                    <p><?php _e('Select which extensions you would like the plugin editor browser to be able to access.', 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="enable-plugin-line-numbers" class="section">
              <div class="section-header">
                <h3><?php _e('Line Numbers', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="enable_plugin_line_numbers"><?php _e('Enable Line Numbers:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input type="radio" name="enable_plugin_line_numbers" value="1" <?php echo (WPEditorSetting::getValue('enable_plugin_line_numbers') == 1) ? 'checked="checked"' : ''; ?>> <?php _e('Yes', 'wpeditor'); ?>
                    <input type="radio" name="enable_plugin_line_numbers" value="0" <?php echo (WPEditorSetting::getValue('enable_plugin_line_numbers') != 1) ? 'checked="checked"' : ''; ?>> <?php _e('No', 'wpeditor'); ?>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will enable line numbers for the plugin editor.<br />Default: Yes", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="enable-plugin-line-wrapping" class="section">
              <div class="section-header">
                <h3><?php _e('Line Wrapping', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="enable_plugin_line_wrapping"><?php _e('Enable Line Wrapping:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input type="radio" name="enable_plugin_line_wrapping" value="1" <?php echo (WPEditorSetting::getValue('enable_plugin_line_wrapping') == 1) ? 'checked="checked"' : ''; ?>> <?php _e('Yes', 'wpeditor'); ?>
                    <input type="radio" name="enable_plugin_line_wrapping" value="0" <?php echo (WPEditorSetting::getValue('enable_plugin_line_wrapping') != 1) ? 'checked="checked"' : ''; ?>> <?php _e('No', 'wpeditor'); ?>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will enable line wrapping for the plugin editor.<br />Default: Yes", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="enable-plugin-active-line" class="section">
              <div class="section-header">
                <h3><?php _e('Active Line Highlighting', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="enable_plugin_active_line"><?php _e('Highlight Active Line:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input type="radio" name="enable_plugin_active_line" value="1" <?php echo (WPEditorSetting::getValue('enable_plugin_active_line') == 1) ? 'checked="checked"' : ''; ?>> <?php _e('Yes', 'wpeditor'); ?>
                    <input type="radio" name="enable_plugin_active_line" value="0" <?php echo (WPEditorSetting::getValue('enable_plugin_active_line') != 1) ? 'checked="checked"' : ''; ?>> <?php _e('No', 'wpeditor'); ?>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will enable highlighting of the active line for the plugin editor.<br />Default: Yes", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="enable-plugin-tab-characters" class="section">
              <div class="section-header">
                <h3><?php _e('Tab Characters', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="enable_plugin_tab_characters"><?php _e('Tab Characters:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <select name="enable_plugin_tab_characters">
                      <option value="spaces"<?php echo WPEditorSetting::getValue('enable_plugin_tab_characters') == 'spaces' ? ' selected="selected"' : ''; ?>><?php _e('Spaces', 'wpeditor'); ?></option>
                      <option value="tabs"<?php echo WPEditorSetting::getValue('enable_plugin_tab_characters') == 'tabs' ? ' selected="selected"' : ''; ?>><?php _e('Tabs', 'wpeditor'); ?></option>
                    </select>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will set the tab character for the plugin editor.<br />Default: Spaces", 'wpeditor'); ?></p>
                  </li>
                  <li>
                    <label for="enable_plugin_tab_size"><?php _e('Tab Size:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input class="small-text" name="enable_plugin_tab_size" value="<?php echo WPEditorSetting::getValue('enable_plugin_tab_size') ? WPEditorSetting::getValue('enable_plugin_tab_size') : 2; ?>" />
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will set the tab size for the plugin editor.<br />Default: 2", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="enable-plugin-editor-height" class="section">
              <div class="section-header">
                <h3><?php _e('Tab Characters', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="enable_plugin_editor_height"><?php _e('Editor Height:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input class="small-text" name="enable_plugin_editor_height" value="<?php echo WPEditorSetting::getValue('enable_plugin_editor_height') ? WPEditorSetting::getValue('enable_plugin_editor_height') : 450; ?>" />
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will set the height in pixels for the plugin editor.<br />Default: 450", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="enable-plugin-file-upload" class="section">
              <div class="section-header">
                <h3><?php _e('File Upload', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="plugin_file_upload"><?php _e('Enable File Upload:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input type="radio" name="plugin_file_upload" value="1" <?php echo (WPEditorSetting::getValue('plugin_file_upload') == 1) ? 'checked="checked"' : ''; ?>> <?php _e('Yes', 'wpeditor'); ?>
                    <input type="radio" name="plugin_file_upload" value="0" <?php echo (WPEditorSetting::getValue('plugin_file_upload') != 1) ? 'checked="checked"' : ''; ?>> <?php _e('No', 'wpeditor'); ?>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will enable a file upload option for the plugin editor.<br />Default: Yes", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="save-settings">
              <ul>
                <li>
                  <input type='submit' name='submit' class="button-primary" value="<?php _e('Save Settings', 'wpeditor'); ?>" />
                </li>
              </ul>
            </div>
          </form>
        </div>
        <div id="settings-posts" class="settings-body">
          <form action="" method="post" class="ajax-settings-form" id="post-settings-form">
            <input type="hidden" name="action" value="save_wpeditor_settings" />
            <input type="hidden" name="_success" value="Your post editor settings have been saved." />
            <input type="hidden" name="_tab" value="posts" />
            <div id="enable-post-editor" class="section">
              <div class="section-header">
                <h3><?php _e('Enable Post Editor', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="enable_post_editor"><?php _e('Enable the Posts Editor:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input type="radio" name="enable_post_editor" value="1" <?php echo (WPEditorSetting::getValue('enable_post_editor') == 1) ? 'checked="checked"' : ''; ?>> <?php _e('Yes', 'wpeditor'); ?>
                    <input type="radio" name="enable_post_editor" value="0" <?php echo (WPEditorSetting::getValue('enable_post_editor') != 1) ? 'checked="checked"' : ''; ?>> <?php _e('No', 'wpeditor'); ?>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will enable/disable the post editor.<br />Default: Yes", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="post-editor-theme" class="section">
              <div class="section-header">
                <h3><?php _e('Editor Theme', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="post_editor_theme"><?php _e('Theme:', 'wpeditor'); ?></label>
                    <select id="post_editor_theme" name="post_editor_theme">
                      <?php
                      $theme = 'default';
                      if(WPEditorSetting::getValue('post_editor_theme')) {
                        $theme = WPEditorSetting::getValue('post_editor_theme');
                      }
                      ?>
                      <option value="default" <?php echo ($theme == 'default') ? 'selected="selected"' : '' ?>><?php _e('Default', 'wpeditor'); ?></option>
                      <option value="ambiance" <?php echo ($theme == 'ambiance') ? 'selected="selected"' : '' ?>><?php _e('Ambiance', 'wpeditor'); ?></option>
                      <option value="blackboard" <?php echo ($theme == 'blackboard') ? 'selected="selected"' : '' ?>><?php _e('Blackboard', 'wpeditor'); ?></option>
                      <option value="cobalt" <?php echo ($theme == 'cobalt') ? 'selected="selected"' : '' ?>><?php _e('Cobalt', 'wpeditor'); ?></option>
                      <option value="eclipse" <?php echo ($theme == 'eclipse') ? 'selected="selected"' : '' ?>><?php _e('Eclipse', 'wpeditor'); ?></option>
                      <option value="elegant" <?php echo ($theme == 'elegant') ? 'selected="selected"' : '' ?>><?php _e('Elegant', 'wpeditor'); ?></option>
                      <option value="lesser-dark" <?php echo ($theme == 'lesser-dark') ? 'selected="selected"' : '' ?>><?php _e('Lesser Dark', 'wpeditor'); ?></option>
                      <option value="monokai" <?php echo ($theme == 'monokai') ? 'selected="selected"' : '' ?>><?php _e('Monokai', 'wpeditor'); ?></option>
                      <option value="neat" <?php echo ($theme == 'neat') ? 'selected="selected"' : '' ?>><?php _e('Neat', 'wpeditor'); ?></option>
                      <option value="night" <?php echo ($theme == 'night') ? 'selected="selected"' : '' ?>><?php _e('Night', 'wpeditor'); ?></option>
                      <option value="rubyblue" <?php echo ($theme == 'rubyblue') ? 'selected="selected"' : '' ?>><?php _e('Ruby Blue', 'wpeditor'); ?></option>
                      <option value="vibrant-ink" <?php echo ($theme == 'vibrant-ink') ? 'selected="selected"' : '' ?>><?php _e('Vibrant Ink', 'wpeditor'); ?></option>
                      <option value="xq-dark" <?php echo ($theme == 'xq-dark') ? 'selected="selected"' : '' ?>><?php _e('XQ-Dark', 'wpeditor'); ?></option>
                    </select>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This allows you to select the theme for the post editor.<br />Default: Default", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="enable-post-line-numbers" class="section">
              <div class="section-header">
                <h3><?php _e('Line Numbers', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="enable_post_line_numbers"><?php _e('Enable Line Numbers:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input type="radio" name="enable_post_line_numbers" value="1" <?php echo (WPEditorSetting::getValue('enable_post_line_numbers') == 1) ? 'checked="checked"' : ''; ?>> <?php _e('Yes', 'wpeditor'); ?>
                    <input type="radio" name="enable_post_line_numbers" value="0" <?php echo (WPEditorSetting::getValue('enable_post_line_numbers') != 1) ? 'checked="checked"' : ''; ?>> <?php _e('No', 'wpeditor'); ?>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will enable line numbers for the post editor.<br />Default: Yes", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="enable-post-line-wrapping" class="section">
              <div class="section-header">
                <h3><?php _e('Line Wrapping', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="enable_post_line_wrapping"><?php _e('Enable Line Wrapping:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input type="radio" name="enable_post_line_wrapping" value="1" <?php echo (WPEditorSetting::getValue('enable_post_line_wrapping') == 1) ? 'checked="checked"' : ''; ?>> <?php _e('Yes', 'wpeditor'); ?>
                    <input type="radio" name="enable_post_line_wrapping" value="0" <?php echo (WPEditorSetting::getValue('enable_post_line_wrapping') != 1) ? 'checked="checked"' : ''; ?>> <?php _e('No', 'wpeditor'); ?>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will enable line wrapping for the post editor.<br />Default: Yes", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="enable-post-active-line" class="section">
              <div class="section-header">
                <h3><?php _e('Active Line Highlighting', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="enable_post_active_line"><?php _e('Highlight Active Line:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input type="radio" name="enable_post_active_line" value="1" <?php echo (WPEditorSetting::getValue('enable_post_active_line') == 1) ? 'checked="checked"' : ''; ?>> <?php _e('Yes', 'wpeditor'); ?>
                    <input type="radio" name="enable_post_active_line" value="0" <?php echo (WPEditorSetting::getValue('enable_post_active_line') != 1) ? 'checked="checked"' : ''; ?>> <?php _e('No', 'wpeditor'); ?>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will enable highlighting of the active line for the post editor.<br />Default: Yes", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="enable-post-tab-characters" class="section">
              <div class="section-header">
                <h3><?php _e('Tab Characters', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="enable_post_tab_characters"><?php _e('Tab Characters:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <select name="enable_post_tab_characters">
                      <option value="spaces"<?php echo WPEditorSetting::getValue('enable_post_tab_characters') == 'spaces' ? ' selected="selected"' : ''; ?>><?php _e('Spaces', 'wpeditor'); ?></option>
                      <option value="tabs"<?php echo WPEditorSetting::getValue('enable_post_tab_characters') == 'tabs' ? ' selected="selected"' : ''; ?>><?php _e('Tabs', 'wpeditor'); ?></option>
                    </select>
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will set the tab character for the post editor.<br />Default: Spaces", 'wpeditor'); ?></p>
                  </li>
                  <li>
                    <label for="enable_post_tab_size"><?php _e('Tab Size:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input class="small-text" name="enable_post_tab_size" value="<?php echo WPEditorSetting::getValue('enable_post_tab_size') ? WPEditorSetting::getValue('enable_post_tab_size') : 2; ?>" />
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will set the tab size for the post editor.<br />Default: 2", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="enable-post-editor-height" class="section">
              <div class="section-header">
                <h3><?php _e('Tab Characters', 'wpeditor'); ?></h3>
              </div>
              <div class="section-body">
                <ul>
                  <li>
                    <label for="enable_post_editor_height"><?php _e('Editor Height:', 'wpeditor'); ?></label>
                  </li>
                  <li class="indent">
                    <input class="small-text" name="enable_post_editor_height" value="<?php echo WPEditorSetting::getValue('enable_post_editor_height') ? WPEditorSetting::getValue('enable_post_editor_height') : 450; ?>" />
                  </li>
                  <li class="indent description">
                    <p><?php _e("This will set the height in pixels for the post editor.<br />Default: 450", 'wpeditor'); ?></p>
                  </li>
                </ul>
              </div>
            </div>
            <div id="save-settings">
              <ul>
                <li>
                  <input type='submit' name='submit' class="button-primary" value="<?php _e('Save Settings', 'wpeditor'); ?>" />
                </li>
              </ul>
            </div>
          </form>
        </div>
        <div id="settings-overview" class="settings-body">
          <div id="wpeditor-overview" class="section">
            <div class="section-header">
              <h3><?php _e('WP Editor Overview', 'wpeditor'); ?></h3>
            </div>
            <div class="section-body">
              <ul>
                <li>
                  <p><strong><?php _e('What is WP Editor?', 'wpeditor'); ?></strong></p>
                </li>
                <li class="indent">
                  <p><?php _e('WP Editor is a plugin for WordPress that replaces the default plugin and theme editors.  Using integrations with <a href="http://codemirror.net" target="_blank">CodeMirror</a> and <a href="http://fancybox.net" target="_blank">FancyBox</a> to create a feature rich environment, WP Editor completely reworks the default WordPress file editing capabilities.  Using Asynchronous Javascript and XML (AJAX) to retrieve files and folders, WP Editor sets a new standard for speed and reliability in a web-based editing atmosphere.', 'wpeditor'); ?></p>
                </li>
                <li>
                  <br />
                  <p><strong><?php _e('Features', 'wpeditor'); ?></strong></p>
                </li>
                <li class="indent">
                  <ul class="normal_list">
                    <li><strong><a href="http://codemirror.net" target="_blank"><?php _e('CodeMirror', 'wpeditor'); ?></a></strong></li>
                    <ul class="normal_list">
                      <li><?php _e('Active Line Highlighting', 'wpeditor'); ?></li>
                      <li><?php _e('Line Numbers', 'wpeditor'); ?></li>
                      <li><?php _e('Line Wrapping', 'wpeditor'); ?></li>
                      <li><?php _e('Eight Editor Themes with Syntax Highlighting', 'wpeditor'); ?></li>
                      <li><?php _e('Fullscreen Editing (ESC, F11)', 'wpeditor'); ?></li>
                      <li><?php _e('Text Search (CMD + F, CTRL + F)', 'wpeditor'); ?></li>
                      <li><?php _e('Individual Settings for Each Editor', 'wpeditor'); ?></li>
                    </ul>
                    <li><<?php _e('strong><a href="http://fancybox.net" target="_blank">FancyBox</a> for image viewing', 'wpeditor'); ?></strong></li>
                    <li><strong><?php _e('AJAX File Browser', 'wpeditor'); ?></strong></li>
                    <li><strong><?php _e('Allowed Extensions List', 'wpeditor'); ?></strong></li>
                    <li><strong><?php _e('Easy to use Settings Section', 'wpeditor'); ?></strong></li>
                  </ul>
                </li>
                <li>
                  <br />
                  <p><strong><?php _e('The Future of WP Editor', 'wpeditor'); ?></strong></p>
                </li>
                <li class="indent">
                  <p><?php _e('WP Editor is brand new! This means that there is a lot more work that will be going into the plugin to make it better. Since it is currently in Beta mode, we would appreciate all the feedback you can give to make this a better product.  Please visit <a href="http://wpeditor.net/beta">http://wpeditor.net/beta</a> to give feedback, request features or just to leave a comment for the developers.  We would appreciate any input you can give!', 'wpeditor'); ?></p>
                  <p><?php _e('That being said, please be patient with us as we are working on this project in our spare time. While we hope that WP Editor can remain free, it does cost us to continue to develop and maintain it. If you feel so inclined, we would appreciate any donation that you might give to enable us to spend more time developing the plugin and keeping this great product up to date! Use the Donate button below to keep WP Editor free!', 'wpeditor'); ?></p>
                  <p>
                    <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=DCFRQLH3DMMS4" target="_blank" class="donate">Donate Today!</a>
                  </p>
                </li>
                <li>
                  <br />
                  <p><strong><?php _e('Support', 'wpeditor'); ?></strong></p>
                </li>
                <li class="indent">
                  <p><?php _e('Support for WP Editor is provided on a first-come, first-serve basis. You can however, get to the top of the queue by paying a per-incident fee based on what you feel your ticket is worth.  The more you pay, the faster we will get to your ticket. Following are a few examples:', 'wpeditor'); ?></p>
                  <ul class="normal_list">
                    <li><?php _e('$1.00+ - We will answer your inquiry before we answer anyone who hasn\'t paid yet', 'wpeditor'); ?></li>
                    <li><?php _e('$5.00+ - We will answer your inquiry before the $1.00 inquiries', 'wpeditor'); ?></li>
                    <li><?php _e('$50.00+ - We will answer your inquiry within a 24 hour period', 'wpeditor'); ?></li>
                    <li><?php _e('$100.00+ - We will answer your inquiry within a 12 hour period', 'wpeditor'); ?></li>
                    <li><?php _e('$1000.00+ - We will stop what we are doing to answer your inquiry', 'wpeditor'); ?></li>
                    <li><?php _e('$100,000.00+ - We will consider quitting our day jobs to make sure your issue is resolved', 'wpeditor'); ?></li>
                  </ul>
                  <p><?php _e('To get support, please visit <a href="http://wpeditor.net/support" target="_blank">http://wpeditor.net/support</a>. If you want paid support, create your support request and then click on the button below to make a payment and put the text you entered in the "brief description" into the "Add special instructions to the seller" box of the payment form.', 'wpeditor'); ?></p>
                  <p>
                    <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YEPC72BPT73PC" target="_blank" class="support">Pay for Support</a>
                  </p>
                </li>
                <li class="indent description">
                  <br />
                  <p><?php _e('To learn more, please visit <a href="http://wpeditor.net" target="_blank">http://wpeditor.net</a>', 'wpeditor'); ?></p>
                </li>
              </ul>
            </div>
        </div>
      </div>
      <br clear="both" />
    </div>
  </div>
</div>
<script type="text/javascript">
  (function($){
    $(document).ready(function(){
      settingsTabs('<?php echo $tab; ?>');
    })
  })(jQuery);
</script>