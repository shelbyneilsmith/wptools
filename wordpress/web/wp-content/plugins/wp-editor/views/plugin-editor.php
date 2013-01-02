<div id="save-result"></div>
<div class="wrap">
  <?php screen_icon(); ?>
  <h2><?php _e('Edit Plugins', 'wpeditor'); ?></h2>
  <?php if(in_array($data['file'], (array) get_option('active_plugins', array()))) { ?>
    <div class="updated">
      <p><?php _e('<strong>This plugin is currently activated!<br />Warning:</strong> Making changes to active plugins is not recommended.  If your changes cause a fatal error, the plugin will be automatically deactivated.', 'wpeditor'); ?></p>
    </div>
  <?php } ?>
  <div class="fileedit-sub">
    <div class="alignleft">
      <h3>
        <?php
          if(is_plugin_active($data['plugin'])) {
            if(is_writable($data['real_file'])) {
              echo __('Editing <span class="current_file">', 'wpeditor') . $data['file'] . __('</span> (active)', 'wpeditor');
            }
            else {
              echo __('Browsing <span class="current_file">', 'wpeditor') . $data['file'] . __('</span> (active)', 'wpeditor');
            }
          } else {
            if (is_writable($data['real_file'])) {
              echo __('Editing <span class="current_file">', 'wpeditor') . $data['file'] . __('</span> (inactive)', 'wpeditor');
            }
            else {
              echo __('Browsing <span class="current_file">', 'wpeditor') . $data['file'] . __('</span> (inactive)', 'wpeditor');
            }
          }
        ?>
      </h3>
    </div>
    <div class="alignright">
      <form action="plugins.php?page=wpeditor_plugin" method="post">
        <strong><label for="plugin"><?php _e('Select plugin to edit:', 'wpeditor'); ?></label></strong>
        <select name="plugin" id="plugin">
          <?php
            foreach($data['plugins'] as $plugin_key => $a_plugin) {
              $plugin_name = $a_plugin['Name'];
              if($plugin_key == $data['plugin']) {
                $selected = ' selected="selected"';
              }
              else {
                $selected = '';
              }
              $plugin_name = esc_attr($plugin_name);
              $plugin_key = esc_attr($plugin_key); ?>
              <option value="<?php echo $plugin_key; ?>" <?php echo $selected; ?>><?php echo $plugin_name; ?></option>
            <?php
            }
          ?>
        </select>
        <input type='submit' name='submit' class="button-secondary" value="<?php _e('Select', 'wpeditor'); ?>" />
      </form>
    </div>
    <br class="clear" />
  </div>

  <div id="templateside">
    <?php if(WPEditorSetting::getValue('plugin_file_upload')): ?>
      <h3><?php _e('Upload Files', 'wpeditor'); ?></h3>
      <div id="plugin-upload-files">
        <?php if(is_writable($data['real_file'])): ?>
          <form enctype="multipart/form-data" id="plugin_upload_form" method="POST">
              <!-- MAX_FILE_SIZE must precede the file input field -->
              <!--input type="hidden" name="MAX_FILE_SIZE" value="30000" /-->
              <p class="description">
                <?php _e('To', 'wpeditor'); ?>: <?php echo basename(dirname($data['current_plugin_root'])) . '/' . basename($data['current_plugin_root']) . '/'; ?>
              </p>
              <input type="hidden" name="current_plugin_root" value="<?php echo $data['current_plugin_root']; ?>" id="current_plugin_root" />
              <input type="text" name="directory" id="file_directory" style="width:190px" placeholder="<?php _e('Optional: Sub-Directory', 'wpeditor'); ?>" />
              <!-- Name of input element determines name in $_FILES array -->
              <input name="file" type="file" id="upload_file" style="width:180px" />
              <div class="ajax-button-loader">
                <?php submit_button(__('Upload File', 'wpeditor'), 'primary', 'submit', false); ?>
                <div class="ajax-loader"></div>
              </div>
          </form>
        <?php else: ?>
          <p>
            <em><?php _e('You need to make this folder writable before you can upload any files. See <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">the Codex</a> for more information.'); ?></em>
          </p>
        <?php endif; ?>
      </div>
      <div id="upload_message"></div>
    <?php endif; ?>
    
    <h3><?php _e('Plugin Files', 'wpeditor'); ?></h3>
    <div id="plugin-editor-files">
      <ul id="plugin-folders" class="plugin-folders"></ul>
    </div>
  </div>
  
  <form name="template" id="template_form" action="" method="post" class="ajax-editor-update" style="float:left width:auto;overflow:hidden;position:relative;">
    <?php wp_nonce_field('edit-plugin_' . $data['real_file']); ?>
    <div>
      <textarea cols="70" rows="25" name="new-content" id="new-content" tabindex="1"><?php echo $data['content'] ?></textarea>
      <input type="hidden" name="action" value="save_files" />
      <input type="hidden" name="_success" id="_success" value="<?php _e('The file has been updated successfully.', 'wpeditor'); ?>" />
      <input type="hidden" id="file" name="file" value="<?php echo esc_attr($data['file']); ?>" />
      <input type="hidden" id="plugin-dirname" name="plugin" value="<?php echo esc_attr($data['plugin']); ?>" />
      <input type="hidden" id="path" name="path" value="<?php echo esc_attr($data['real_file']); ?>" />
      <input type="hidden" name="scroll_to" id="scroll_to" value="<?php echo $data['scroll_to']; ?>" />
      <input type="hidden" name="content-type" id="content-type" value="<?php echo $data['content-type']; ?>" />
      <?php
        $pathinfo = pathinfo($data['plugin']);
      ?>
      <input type="hidden" name="extension" id="extension" value="<?php echo $pathinfo['extension']; ?>" />
    </div>
    <?php if(is_writable($data['real_file'])): ?>
      <p class="submit">
        <?php
          if(isset($_GET['phperror'])) {
            echo '<input type="hidden" name="phperror" value="1" />'; ?>
            <input type="submit" name="submit" class="button-primary" value="<?php _e('Update File and Attempt to Reactivate', 'wpeditor'); ?>" />
          <?php } else { ?>
            <input type="submit" name='submit' class="button-primary" value="<?php _e('Update File', 'wpeditor'); ?>" />
          <?php
          }
        ?>
      </p>
      <div class="error writable-error" style="display:none;">
        <p>
          <em><?php _e('You need to make this file writable before you can save your changes. See <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">the Codex</a> for more information.'); ?></em>
        </p>
      </div>
    <?php else: ?>
      <p class="submit" style="display:none;">
        <?php
          if(isset($_GET['phperror'])) {
            echo '<input type="hidden" name="phperror" value="1" />'; ?>
            <input type="submit" name="submit" class="button-primary" value="<?php _e('Update File and Attempt to Reactivate', 'wpeditor'); ?>" />
          <?php } else { ?>
            <input type="submit" name='submit' class="button-primary" value="<?php _e('Update File', 'wpeditor'); ?>" />
          <?php
          }
        ?>
      </p>
      <div class="error writable-error">
        <p>
          <em><?php _e('You need to make this file writable before you can save your changes. See <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">the Codex</a> for more information.'); ?></em>
        </p>
      </div>
    <?php endif; ?>
  </form>
  <script type="text/javascript">
    (function($){
      $(document).ready(function(){
        $('#template_form').submit(function(){ 
          $('#scroll-to').val( $('#new-content').scrollTop() ); 
        });
        $('#new-content').scrollTop($('#scroll-to').val());
        enablePluginAjaxBrowser('<?php echo urlencode((WPWINDOWS) ? str_replace("/", "\\", $data["real_file"]) : $data["real_file"]); ?>');
        runCodeMirror('<?php echo $pathinfo["extension"]; ?>');
        $('.ajax-loader').hide();
        $('#plugin_upload_form').submit(function() {
          $('.ajax-loader').show();
          var directory = $('#file_directory').val();
          var current_plugin_root = $('#current_plugin_root').val();
          var data = new FormData();
          $.each($('input[type=file]')[0].files, function(i, file) {
            data.append('file-'+i, file);
          });
          data.append('action', 'upload_files');
          data.append('current_plugin_root', current_plugin_root);
          data.append('directory', directory);
          $.ajax({
            type: "POST",
            url: ajaxurl,
            data: data,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(result) {
              if(result.error[0] === 0) {
                enablePluginAjaxBrowser('<?php echo urlencode((WPWINDOWS) ? str_replace("/", "\\", $data["real_file"]) : $data["real_file"]); ?>');
                $('#upload_message').html('<p class="WPEditorAjaxSuccess" style="padding:5px;">' + result.success + '</p>');
              }
              if(result.error[0] === -2) {
                $('#upload_message').html('<p class="WPEditorAjaxError" style="padding:5px;">' + result.error[1] + '</p>');
              }
              else if(result.error[0] === -1) {
                $('#upload_message').html('<p class="WPEditorAjaxError" style="padding:5px;">' + result.error[1] + '</p>');
              }
              $('.ajax-loader').hide();
            }
          });
          return false;
        });
      })
    })(jQuery);
    function runCodeMirror(extension) {
      if(extension === 'php') {
        var mode = 'application/x-httpd-php';
      }
      else if(extension === 'css') {
        var mode = 'css';
      }
      else if(extension === 'js') {
        var mode = 'javascript';
      }
      else if(extension === 'html' || extension === 'htm') {
        var mode = 'text/html';
      }
      else if(extension === 'xml') {
        var mode = 'application/xml';
      }
      <?php
      if(WPEditorSetting::getValue('plugin_editor_theme')) { ?>
        var theme = '<?php echo WPEditorSetting::getValue("plugin_editor_theme"); ?>';
      <?php }
      else { ?>
        var theme = 'default';
      <?php } ?>
      var activeLine = false;
      <?php if(WPEditorSetting::getValue('enable_plugin_active_line')) { ?>
        var activeLine = 'activeline-' + theme;
      <?php } ?>
      editor = CodeMirror.fromTextArea(document.getElementById('new-content'), {
        mode: mode,
        theme: theme,
        <?php
        if(WPEditorSetting::getValue('enable_plugin_line_numbers')) { ?>
          lineNumbers: true,
        <?php } 
        if(WPEditorSetting::getValue('enable_plugin_line_wrapping')) { ?>
          lineWrapping: true,
        <?php }
        if(WPEditorSetting::getValue('enable_plugin_tab_characters') && WPEditorSetting::getValue('enable_plugin_tab_characters') == 'tabs') { ?>
          indentWithTabs: true,
        <?php }
        if(WPEditorSetting::getValue('enable_plugin_tab_size')) { ?>
          tabSize: <?php echo WPEditorSetting::getValue('enable_plugin_tab_size'); ?>,
        <?php } else { ?>
          tabSize: 2,
        <?php } ?>
        onCursorActivity: function() {
          if(activeLine) {
            editor.setLineClass(hlLine, null, null);
            hlLine = editor.setLineClass(editor.getCursor().line, null, activeLine);
          }
        },
        onChange: function() {
          changeTrue();
        },
        extraKeys: {
          'F11': toggleFullscreenEditing, 
          'Esc': toggleFullscreenEditing
        } // set fullscreen options here
      });
      if(activeLine) {
        var hlLine = editor.setLineClass(0, activeLine);
      }
      <?php if(WPEditorSetting::getValue('enable_plugin_editor_height')) { ?>
        $jq = jQuery.noConflict();
        $jq('.CodeMirror-scroll, .CodeMirror').height('<?php echo WPEditorSetting::getValue("enable_plugin_editor_height"); ?>px');
        var scrollDivHeight = $jq('.CodeMirror-scroll div:first-child').height();
        var editorDivHeight = $jq('.CodeMirror').height();
        if(scrollDivHeight > editorDivHeight) {
          $jq('.CodeMirror-gutter').height(scrollDivHeight);
        }
      <?php } ?>
      if(!$jq('.CodeMirror .quicktags-toolbar').length) {
        $jq('.CodeMirror').prepend('<div class="quicktags-toolbar">' + 
          '<a href="#" class="button-primary editor-button" id="plugin_save">save</a>&nbsp;' + 
          '<a href="#" class="button-secondary editor-button" id="plugin_undo">undo</a>&nbsp;' + 
          '<a href="#" class="button-secondary editor-button" id="plugin_redo">redo</a>&nbsp;' + 
          '<a href="#" class="button-secondary editor-button" id="plugin_search">search</a>&nbsp;' + 
          '<a href="#" class="button-secondary editor-button" id="plugin_find_prev">find prev</a>&nbsp;' + 
          '<a href="#" class="button-secondary editor-button" id="plugin_find_next">find next</a>&nbsp;' + 
          '<a href="#" class="button-secondary editor-button" id="plugin_replace">replace</a>&nbsp;' + 
          '<a href="#" class="button-secondary editor-button" id="plugin_replace_all">replace all</a>&nbsp;' + 
          '<a href="#" class="button-secondary editor-button" id="plugin_fullscreen">fullscreen</a>&nbsp;' + 
          '</div>'
        );
        $jq('.CodeMirror-scroll').height($jq('.CodeMirror-scroll').height() - 33);
        editor.focus();
      }
      $jq('#plugin_fullscreen').live("click", function() {
        toggleFullscreenEditing();
        editor.focus();
      })
      $jq('#plugin_save').live("click", function() {
        $jq('.ajax-editor-update').submit();
        editor.focus();
      })
      $jq('#plugin_undo').live("click", function() {
        editor.undo();
        editor.focus();
      })
      $jq('#plugin_redo').live("click", function() {
        editor.redo();
        editor.focus();
      })
      $jq('#plugin_search').live("click", function() {
        CodeMirror.commands.find(editor);
        return false;
      })
      $jq('#plugin_find_next').live("click", function() {
        CodeMirror.commands.findNext(editor);
        return false;
      })
      $jq('#plugin_find_prev').live("click", function() {
        CodeMirror.commands.findPrev(editor);
        return false;
      })
      $jq('#plugin_replace').live("click", function() {
        CodeMirror.commands.replace(editor);
        return false;
      })
      $jq('#plugin_replace_all').live("click", function() {
        CodeMirror.commands.replaceAll(editor);
        return false;
      })
    }
  </script> 
</div>
<div class="alignright">
</div>
<br class="clear" />