<?php
  // SQLMAP Scan Task Killer
  @set_time_limit(0);
  @session_start();
  $sess = session_id();
  if(!$sess) {
    header("Location: /sqlmap/index.php");
  }
  include_once("header.php"); 

  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    include("./inc/SQLMAPClientAPI.class.php");
    $sqlmap = new SQLMAPClientAPI();
    if(!$sqlmap->stopScan($id)) {
      if(!$sqlmap->killScan($id)) {
        // Problem Stopping/Killing Scan Task, bad id maybe?
?>

        <div class="epic_fail" align="center">
          <p style="font-size:26px">Epic Failure Stopping Scan!</p><br />
          <p style="font-size:20px">
            Unknown problem encountered trying to kill ScanID#<?php echo htmlentities($id, ENT_QUOTES, 'UTF-8'); ?>!<br />
            Please follow up with the admin for further assistance....
            <br /><br />
          </p>
          <p style="font-size:16px">
            Redirecting back to form so you can try again....<br />
          </p>
        </div>

<?php

      } else {
        // Scan Forcefully Killed
?>

        <div class="epic_fail" align="center">
          <p style="font-size:26px">Scan Forcefully Killed!</p><br />
          <p style="font-size:16px">
            Redirecting back to form so you can try again....<br />
          </p>
        </div>

<?php
      }
    } else {
      // Scan Gracefully Stopped
?>

        <div class="epic_fail" align="center">
          <p style="font-size:26px">Scan Gracefully Stopped!</p><br />
          <p style="font-size:16px">
            Redirecting back to form so you can try again....<br />
          </p>
        </div>

<?php
    }
  }
  echo "<script>setTimeout('redirectHome()', 5000);</script>";

  include_once("footer.php");
?>
