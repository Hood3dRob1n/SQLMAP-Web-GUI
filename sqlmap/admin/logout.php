<?php
  // De-Auth the User Session to be on safe side
  if(isset($_SESSION['authenticated'])){ 
    $_SESSION['authenticated'] = false;
  }

  // Next we remove any session cookies from user stash
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]);
  }

  // Then remove any other variables tied to our user session
  session_unset();

  // Finally we can now destroy the session
  session_destroy();

  // All done, redirect user back to login
  header("location: /sqlmap/admin/login.php");
?>
