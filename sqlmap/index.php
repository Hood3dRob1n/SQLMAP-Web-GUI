<?php

  /*
     SQLMAP - REST Client & Web Operator
       Coded by: Hood3dRob1n

     Beta: http://uppit.com/ol1jc0jdrzpf/sqlmap_web_edition.zip

  */

  @session_start();                           // Start a new Session, if not already created (tracking later?)
  @set_time_limit(0);                         // May run long at times, remove time limits on script execution time
  $sess = session_id();                       // Current Session ID, use tbd...
  $salt = "!SQL!";                            // Salt for form token hash generation
  $token = sha1(mt_rand(1, 1000000) . $salt); // Generate CSRF Token Hash
  $_SESSION['token'] = $token;                // Set CSRF Token for Form Submit Verification

  include_once("header.php");                 // Bring in our Page Header Content
  ?>


    <div class="container">

      <div class="jumbotron" id="jumbotron">
        <p style="font-size=18px; font-weight: bold;">
          Welcome to the SQLMAP Web GUI!
        </p>
        <p style="font-size=12px;">
          Use the tabs below to configure your scan settings,<br />
          Then simply click on the button at the bottom when done to launch a new scan!<br />
        </p>
      </div>

      <form class="form-horizontal" role="form" id="myForm" action="/sqlmap/scans.php" method="POST" target="_blank">
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <div class="settings" id="settings">
          <div class="nav_wrap" id="nav_wrap">
            <ul class="nav nav-tabs nav-justified" role="tablist">
              <li class="active"><a href="#" onClick="tabFlipper(1);" style="font-size=14px; font-weight: bold;">Basic</a></li>
              <li><a href="#" onClick="tabFlipper(3);" style="font-size=14px; font-weight: bold;">Request</a></li>
              <li><a href="#" onClick="tabFlipper(2);" style="font-size=14px; font-weight: bold;">Injection & Technique</a></li>
              <li><a href="#" onClick="tabFlipper(6);" style="font-size=14px; font-weight: bold;">Detection</a></li>
              <li><a href="#" onClick="tabFlipper(4);" style="font-size=14px; font-weight: bold;">Enumeration</a></li>
              <li><a href="#" onClick="tabFlipper(5);" style="font-size=14px; font-weight: bold;">Access</a></li>
            </ul>
          </div>
          <br />

          <div class="settings_basics_container" id="settings_basics_container">
            <?php include("basics.php"); ?>
          </div>

          <div class="settings_request_container" id="settings_request_container">
            <?php include("request.php"); ?>
          </div>

          <div class="settings_idt_container" id="settings_idt_container">
            <?php include("idt.php"); ?>
          </div>

          <div class="settings_idt2_container" id="settings_idt2_container">
            <?php include("idt2.php"); ?>
          </div>

          <div class="settings_enum_container" id="settings_enum_container">
            <?php include("enum.php"); ?>
          </div>

          <div class="settings_access_container" id="settings_access_container">
            <?php include("access.php"); ?>
          </div>
        </div>

        <br /><br />
        <input type="submit" class="btn" name="submit" value="Run SQLMAP Web Scan"/>
        <br /><br />
      </form>
    </div>


  <?php
  include_once("footer.php");                  // Bring in our Page Footer Content


  /*
    End of File
  */
?>

