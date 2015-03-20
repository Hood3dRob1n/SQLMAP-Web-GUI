<?php

  include("./inc/config.php");


  /* 

    Extension to the ZipArchive to allow recursive directory zipping
    Define if you want to include base directory in zip or not
    You can also select files to ignore
    Returns True on success, false otherwise...

    Ex: 
      zipIt('/path/to/folder', '/path/to/compressed.zip', false, array('.DS_Store'));

    ref:
      http://stackoverflow.com/questions/1334613/how-to-recursively-zip-a-directory-in-php
  */
  function zipIt($source, $destination, $include_dir = false, $additionalIgnoreFiles = array()) {
    // Ignore "." and ".." folders by default
    $defaultIgnoreFiles = array('.', '..');

    // include more files to ignore
    $ignoreFiles = array_merge($defaultIgnoreFiles, $additionalIgnoreFiles);

    if (!extension_loaded('zip') || !file_exists($source)) {
      return false;
    }

    if (file_exists($destination)) {
      unlink ($destination);
    }

    $zip = new ZipArchive();
      if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
      }
    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true) {
      $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
      if ($include_dir) {
        $arr = explode("/",$source);
        $maindir = $arr[count($arr)- 1];
        $source = "";
        for ($i=0; $i < count($arr) - 1; $i++) { 
          $source .= '/' . $arr[$i];
        }
        $source = substr($source, 1);
        $zip->addEmptyDir($maindir);
      }
      foreach ($files as $file) {
        $file = str_replace('\\', '/', $file);

        // purposely ignore files that are irrelevant
        if( in_array(substr($file, strrpos($file, '/')+1), $ignoreFiles) ) {
          continue;
        }
        $file = realpath($file);

        if (is_dir($file) === true) {
          $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
        } else if (is_file($file) === true) {
          $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
        }
      }
    } else if (is_file($source) === true) {
      $zip->addFromString(basename($source), file_get_contents($source));
    }
    return $zip->close();
  }



  if((isset($_GET['target'])) && (!preg_match("#\.\./|\.\.%2f|\.\.%25%5c|\.\.%5c|\.\.%bg%qf|\.\.%u2215|\.\.%c0%9v|\.\.%u2216|%2e%2e/#i", $_GET['target']))) {
    // Check SQLMAP output dir for matching directory
    // If exists, zip directory contents and everything inside
    // Provide zip archive file as download attachment to user

    $dir_contents = array_diff(glob(preg_replace("#/$#", "", SQLMAP_OUTPUT_PATH) . "/**"), array('.', '..'));
    $hdc = array();
    foreach($dir_contents as $dir) {
      $dc = explode("/", $dir);
      $hdc[] = $dc[sizeof($dc)-1];
    }
    if(in_array($_GET['target'], $hdc)) {
      $dl_file = TMP_PATH . uniqid('sqlmap_') .'_scan_results.zip'; // This doesnt work for unique filenames?, need to find better way (maybe pass in task/scanID)...
      if(zipIt(SQLMAP_OUTPUT_PATH . $_GET['target'], $dl_file, true)) {
        // Include custom scan log from web panel since API usage wipes the normal log file....
        if(file_exists(TMP_PATH .  $_GET['target'] . "/api_scan.log")) {
          $zip = new ZipArchive;
          if ($zip->open($dl_file) === TRUE) {
            $zip->addFile(TMP_PATH .  $_GET['target'] . "/api_scan.log", $_GET['target'] . '/api_scan.log');
            $zip->close();
          }
        }
        header("Content-Type: application/octet-stream");
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"sqlmap_scan_results.zip\""); 
        echo readfile($dl_file);
      }
      @unlink($dl_file);
    } else {
      echo '<div class="epic_fail" id="epic_fail">';
      echo "Problem Downloading Results Directory for Target!<br />";
      echo "</div>";
      echo "<script>setTimeout('redirectHome()', 5000);</script>";
    }
  } else {
    header("Location: /sqlmap/index.php");
  }
  
?>
