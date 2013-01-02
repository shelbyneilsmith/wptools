<?php
class WPEditorBrowser {
  
  public static function getFilesAndFolders($dir, $contents, $type) {
    $slash = '/';
    if(WPWINDOWS) {
      $slash = '\\';
    }
    $output = array();
    if(is_dir($dir)) {
      if($handle = opendir($dir)) {
        $size_document_root = strlen($_SERVER['DOCUMENT_ROOT']);
        $pos = strrpos($dir, $slash);
        $topdir = substr($dir, 0, $pos + 1);
        $i = 0;
        while(false !== ($file = readdir($handle))) {
          if($file != '.' && $file != '..' && substr($file, 0, 1) != '.' && self::allowedFiles($dir, $file)) {
            $rows[$i]['data'] = $file;
            $rows[$i]['dir'] = is_dir($dir . $slash . $file);
            $i++;
          }
        }
        closedir($handle);
      }

      if(isset($rows)) {  
        $size = count($rows);
        $rows = self::sortRows($rows);
        for($i = 0; $i < $size; ++$i) {
          $topdir = $dir . $slash . $rows[$i]['data'];
          $output[$i]['name'] = $rows[$i]['data'];
          $output[$i]['path'] = $topdir;
          if($rows[$i]['dir']) {
            $output[$i]['filetype'] = 'folder';
            $output[$i]['extension'] = 'folder';
            $output[$i]['filesize'] = '';
          }
          else {
            $output[$i]['writable'] = false;
            if(is_writable($output[$i]['path'])) {
              $output[$i]['writable'] = true;
            }
            $output[$i]['filetype'] = 'file';
            $path = pathinfo($output[$i]['name']);
            if(isset($path['extension'])) {
              $output[$i]['extension'] = $path['extension'];
            }
            $output[$i]['filesize'] = '(' . round(filesize($topdir) * .0009765625, 2) . ' KB)';
            if($type == 'theme') {
              $output[$i]['file'] = str_replace(realpath(get_theme_root()) . $slash, '', $output[$i]['path']);
              $output[$i]['url'] = get_theme_root_uri() . $slash . $output[$i]['file'];
            }
            else {
              $output[$i]['file'] = str_replace(realpath(WP_PLUGIN_DIR) . $slash, '', $output[$i]['path']);
              $output[$i]['url'] = plugins_url() . $slash . $output[$i]['file'];
            }
          }
        }
      }
      else {
        $output[-1] = 'this folder has no contents';
      }
    }
    elseif(is_file($dir)) {
      if(isset($contents) && $contents == 1) {
        $output['name'] = basename($dir);
        $output['path'] = $dir;
        $output['filetype'] = 'file';
        $path = pathinfo($output['name']);
        if(isset($path['extension'])) {
          $output['extension'] = $path['extension'];
        }
        $output['content'] = file_get_contents($dir);
        $output['writable'] = false;
        if(is_writable($output['path'])) {
          $output['writable'] = true;
        }
        if($type == 'theme') {
          $output['file'] = str_replace(realpath(get_theme_root()) . $slash, '', $output['path']);
          $output['url'] = get_theme_root_uri() . $slash . $output['file'];
        }
        else {
          $output['file'] = str_replace(realpath(WP_PLUGIN_DIR) . $slash, '', $output['path']);
          $output['url'] = plugins_url() . $slash . $output['file'];
        }
      }
      else {
        $pos = strrpos($dir, $slash);
        $newdir = substr($dir, 0, $pos);
        if($handle = opendir($newdir)) {
          $size_document_root = strlen($_SERVER['DOCUMENT_ROOT']);
          $pos = strrpos($newdir, $slash);
          $topdir = substr($newdir, 0, $pos + 1);
          $i = 0;
          while(false !== ($file = readdir($handle))) {
            if($file != '.' && $file != '..' && substr($file, 0, 1) != '.' && WPEditorBrowser::allowedFiles($newdir, $file)) {
              $rows[$i]['data'] = $file;
              $rows[$i]['dir'] = is_dir($newdir . $slash . $file);
              $i++;
            }
          }
          closedir($handle);
        }
      
        if(isset($rows)) {
          $size = count($rows);
          $rows = self::sortRows($rows);
          for($i = 0; $i < $size; ++$i) {
            $topdir = $newdir . $slash . $rows[$i]['data'];
            $output[$i]['name'] = $rows[$i]['data'];
            $output[$i]['path'] = $topdir;
            if($rows[$i]['dir']) {
              $output[$i]['filetype'] = 'folder';
              $output[$i]['extension'] = 'folder';
              $output[$i]['filesize'] = '';
            }
            else {
              $output[$i]['writable'] = false;
              if(is_writable($output[$i]['path'])) {
                $output[$i]['writable'] = true;
              }
              $output[$i]['filetype'] = 'file';
              $path = pathinfo($rows[$i]['data']);
              if(isset($path['extension'])) {
                $output[$i]['extension'] = $path['extension'];
              }
              $output[$i]['filesize'] = '(' . round(filesize($topdir) * .0009765625, 2) . ' KB)';
            }
            if($output[$i]['path'] == $dir) {
              $output[$i]['content'] = file_get_contents($dir);
            }
            $output[$i]['writable'] = false;
            if(is_writable($output[$i]['path'])) {
              $output[$i]['writable'] = true;
            }
            if($type == 'theme') {
              $output[$i]['file'] = str_replace(realpath(get_theme_root()) . $slash, '', $output[$i]['path']);
              $output[$i]['url'] = get_theme_root_uri() . $slash . $output[$i]['file'];
            }
            else {
              $output[$i]['file'] = str_replace(realpath(WP_PLUGIN_DIR) . $slash, '', $output[$i]['path']);
              $output[$i]['url'] = plugins_url() . $slash . $output[$i]['file'];
            }
          }
        }
        else {
          $output[-1] = 'bad file or unable to open';
        }
      }
    }
    else {
      $output[-1] = 'bad file or unable to open';
    }
    return $output;
  }
  
  public static function sortRows($data) {
    $size = count($data);

    for($i = 0; $i < $size; ++$i) {
      $row_num = self::findSmallest($i, $size, $data);
      $tmp = $data[$row_num];
      $data[$row_num] = $data[$i];
      $data[$i] = $tmp;
    }

    return $data;
  }

  public static function findSmallest($i, $end, $data) {
    $min['pos'] = $i;
    $min['value'] = $data[$i]['data'];
    $min['dir'] = $data[$i]['dir'];
    for(; $i < $end; ++$i) {
      if($data[$i]['dir']) {
        if($min['dir']) {
          if($data[$i]['data'] < $min['value']) {
            $min['value'] = $data[$i]['data'];
            $min['dir'] = $data[$i]['dir'];
            $min['pos'] = $i;
          }
        }
        else {
          $min['value'] = $data[$i]['data'];
          $min['dir'] = $data[$i]['dir'];
          $min['pos'] = $i;
        }
      }
      else {
        if(!$min['dir'] && $data[$i]['data'] < $min['value']) {
          $min['value'] = $data[$i]['data'];
          $min['dir'] = $data[$i]['dir'];
          $min['pos'] = $i;
        }
      }
    }
    return $min['pos'];
  }
  
  public static function allowedFiles($dir, $file) {
    $slash = '/';
    if(WPWINDOWS) {
      $slash = '\\';
    }
    $output = true;
    $allowed_extensions = explode('~', WPEditorSetting::getValue('plugin_editor_allowed_extensions'));
    
    if(is_dir($dir . $slash . $file)) {
      $output = true;
    }
    else {
      $file = pathinfo($file);
      if(isset($file['extension']) && in_array($file['extension'], $allowed_extensions)) {
        $output = true;
      }
      else {
        $output = false;
      }
    }
    return $output;
  }
  
  public static function uploadThemeFiles() {
    // Theme file upload
    $slash = '/';
    if(WPWINDOWS) {
      $slash = '\\';
    }
    if(isset($_FILES["file-0"]) && isset($_POST['current_theme_root'])) {
      $error = $_FILES["file-0"]["error"];
      $error_message = __('No Errors', 'wpeditor');
      $success = __('Unsuccessful', 'wpeditor');
      $current_theme_root = $_POST['current_theme_root'];
      $directory = '';
      if(isset($_POST['directory'])) {
        $directory = $_POST['directory'];
        $dir = substr($directory, -1);
        if($dir != $slash) {
          $directory = $directory . $slash;
        }
        $dir = substr($directory, 0, 1);
        if($dir == $slash) {
          $directory = substr($directory, 1);
        }
      }
      $complete_directory = $current_theme_root . $directory;
      if(!is_dir($complete_directory)) {
        mkdir($complete_directory, 0777, true);
      }
      
      if($_FILES["file-0"]["error"] > 0) {
        $error_message = __('Return Code', 'wpeditor') . ": " . $_FILES["file-0"]["error"];
      }
      else {
        //$result = "Upload: " . $_FILES["file-0"]["name"] . "<br />";
        //$result .= "Type: " . $_FILES["file-0"]["type"] . "<br />";
        //$result .= "Size: " . ($_FILES["file-0"]["size"] / 1024) . " Kb<br />";
        //$result .= "Temp file: " . $_FILES["file-0"]["tmp_name"] . "<br />";

        if(file_exists($complete_directory . $_FILES["file-0"]["name"])) {
          $error = -1;
          $error_message = $_FILES["file-0"]["name"] . __(' already exists', 'wpeditor');
        }
        else {
          move_uploaded_file($_FILES["file-0"]["tmp_name"], $current_theme_root . $directory . $_FILES["file-0"]["name"]);
          $success = "Stored in: " . basename($complete_directory) . $slash . $_FILES["file-0"]["name"];
        }
      }
    }
    else {
      $error = -2;
      $error_message = __('No File Selected', 'wpeditor');
      $success = __('Unsuccessful', 'wpeditor');
    }
    $result = array(
      'error' => array(
        $error,
        $error_message
      ),
      'success' => $success
    );
    return $result;
  }
  
  public static function uploadPluginFiles() {
    // Plugin file upload
    $slash = '/';
    if(WPWINDOWS) {
      $slash = '\\';
    }
    if(isset($_FILES["file-0"]) && isset($_POST['current_plugin_root'])) {
      $error = $_FILES["file-0"]["error"];
      $error_message = __('No Errors', 'wpeditor');
      $success = __('Unsuccessful', 'wpeditor');
      $current_plugin_root = $_POST['current_plugin_root'];
      $directory = '';
      if(isset($_POST['directory'])) {
        $directory = $_POST['directory'];
        $dir = substr($directory, -1);
        if($dir != $slash) {
          $directory = $directory . $slash;
        }
        $dir = substr($directory, 0, 1);
        if($dir == $slash) {
          $directory = substr($directory, 1);
        }
      }
      $complete_directory = $current_plugin_root . $slash . $directory;
      if(!is_dir($complete_directory)) {
        mkdir($complete_directory, 0777, true);
      }
      
      if($_FILES["file-0"]["error"] > 0) {
        $error_message = __('Return Code', 'wpeditor') . ": " . $_FILES["file-0"]["error"];
      }
      else {
        //$result = "Upload: " . $_FILES["file-0"]["name"] . "<br />";
        //$result .= "Type: " . $_FILES["file-0"]["type"] . "<br />";
        //$result .= "Size: " . ($_FILES["file-0"]["size"] / 1024) . " Kb<br />";
        //$result .= "Temp file: " . $_FILES["file-0"]["tmp_name"] . "<br />";

        if(file_exists($complete_directory . $_FILES["file-0"]["name"])) {
          $error = -1;
          $error_message = $_FILES["file-0"]["name"] . __(' already exists', 'wpeditor');
        }
        else {
          move_uploaded_file($_FILES["file-0"]["tmp_name"], $complete_directory . $_FILES["file-0"]["name"]);
          $success = "Stored in: " . basename($complete_directory) . $slash . $_FILES["file-0"]["name"];
        }
      }
    }
    else {
      $error = -2;
      $error_message = __('No File Selected', 'wpeditor');
      $success = __('Unsuccessful', 'wpeditor');
    }
    $result = array(
      'error' => array(
        $error,
        $error_message
      ),
      'success' => $success
    );
    return $result;
  }
  
}