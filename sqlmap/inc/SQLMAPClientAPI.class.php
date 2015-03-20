<?php

  include("config.php");

  /*
     Ghetto Check if file is binary or ascii
     This way we can determine if we can print the contents in textarea or not
     Returns True if file is ascii, False otherwise
  */
  function is_ascii($sourcefile) {
    if (is_file($sourcefile)) {
      $content = str_replace(array("\n", "\r", "\t", "\v", "\b"), '', file_get_contents($sourcefile));
      return ctype_print($content);
    } else {
      return false;
    }
  }

  /*
     Check if array is a associated (hash) array vs a simple list array
     Returns True when array is an associative array (key:value pairings)
        Returns False otherwise

     Borrowed from stackoverflow discussion:
       http://stackoverflow.com/questions/5996749/determine-whether-an-array-is-associative-hash-or-not
  */
  function is_assoc(array $array) {
    $keys = array_keys($array); // Keys of the array
    return array_keys($keys) !== $keys;
  }


  // SQLMAP Rest API Client Communicator Class
  class SQLMAPClientAPI {
    private $api = API_URL;                         // REST API Server Address
    public $task_id;                                // Task ID to track against

    /*
      Initialize our Class Object
      Set the task id for new instance
    */
    public function __construct() {
// Commented out to avoid spinning up unneccary tasks for admin
// Manually call the generateNewTaskID() function to set...
//      $this->task_id = $this->generateNewTaskID();
    }


    /*
       Start up a new Task
       Returns the new task id on success, false otherwise
    */
    public function generateNewTaskID() {
      $json = json_decode(file_get_contents($this->api . "task/new"), true);
      if(($json['success'] == "true") && (trim($json['taskid']) != "")) {
        return trim($json['taskid']);
      }
      return NULL;
    }


    /*
       Delete an Active Task by ID
       Returns true on success, false otherwise
    */
    public function deleteTaskID($id) {
      $json = json_decode(file_get_contents($this->api . "task/" . $id . "/delete"), true);
      if($json['success'] == "true") {
        return true;
      }
      return false;
    }


    /*
       Lists current tasks with ADMIN ID, NOT task id
       Returns associative array on success, false otherwise
          array(
            'tasks_num' => int,
            'tasks' => array('1eb32c498dd90fb3','e398810ea2603520',...)
          )'
    */
    public function adminListTasks($adminid) {
      $json = json_decode(file_get_contents($this->api . "admin/" . $adminid . "/list"), true);
      if($json['success'] == "true") {
        return array('tasks_num' => $json['tasks_num'], 'tasks' => $json['tasks']);
      }
      return false;
    }


    /*
       Flush all tasks with ADMIN ID, NOT task id
       Returns true on success, false otherwise
    */
    public function adminFlushTasks($adminid) {
      $json = json_decode(file_get_contents($this->api . "admin/" . $adminid . "/flush"), true);
      if($json['success'] == "true") {
        return true;
      }
      return false;
    }


    /*
       List the currently set options under particular task ID
       Returns an associative array on success, false otherwise
	{
	    "options": {
		"taskid": "e398810ea2603520",
		"agent": null,
		"alert": null,
		"answers": null,
		"api": true,
		"authCred": null, 
		"authPrivate": null, 
		"authType": null,
		"batch": true, 
		"beep": false,
		"binaryFields": null,
		"bulkFile": null,
		"charset": null,
		"checkTor": false,
		"cleanup": false,
		"code": null,
		"col": null,
		"commonColumns": false,
		"commonTables": false,
		"configFile": null, 
		"cookie": null,
		"cookieDel": null,
		"cpuThrottle": 5,
		"crawlDepth": null,
		"csrfToken": null,
		"csrfUrl": null,
		"csvDel": ",",
		"data": null,
		"database": "/tmp/sqlmapipc-rA0QdN",
		"db": null,
		"dbms": null,
		"dbmsCred": null, 
		"delay": 0,
		"dependencies": false,
		"dFile": null,
		"direct": null,
		"disableColoring": true,
		"dnsName": null,
		"dropSetCookie": false,
		"dummy": false,
		"dumpAll": false,
		"dumpFormat": "CSV",
		"dumpTable": false,
		"dumpWhere": null,
		"eta": false,
		"excludeCol": null,
		"excludeSysDbs": false,
		"extensiveFp": false,
		"evalCode": null,
		"firstChar": null,
		"flushSession": false,
		"forceDns": false,
		"forceSSL": false,
		"forms": false,
		"freshQueries": false,
		"getAll": false,
		"getBanner": false,
		"getColumns": false,
		"getComments": false,
		"getCount": false,
		"getCurrentDb": false,
		"getCurrentUser": false,
		"getDbs": false,
		"getHostname": false,
		"getPasswordHashes": false,
		"getPrivileges": false,
		"getRoles": false,
		"getSchema": false,
		"getTables": false,
		"getUsers": false,
		"googleDork": null,
		"googlePage": 1,
		"headers": null,
		"hexConvert": false,
		"host": null,
		"hpp": false,
		"identifyWaf": false,
		"ignore401": false,
		"ignoreProxy": false,
		"invalidBignum": false,
		"invalidLogical": false,
		"invalidString": false,
		"isDba": false,
		"keepAlive": false,
		"lastChar": null,
		"level": 1,
		"limitStart": null,
		"limitStop": null,
		"liveTest": false,
		"loadCookies": null,
		"logFile": null,
		"method": null,
		"mnemonics": null,
		"mobile": false,
		"msfPath": null,
		"noCast": false,
		"noEscape": false,
		"notString": null,
		"nullConnection": false,
		"optimize": false,
		"outputDir": null,
		"os": null,
		"osBof": false,
		"osCmd": null,
		"osPwn": false, 
		"osShell": false,
		"osSmb": false,
		"pageRank": false,
		"paramDel": null,
		"parseErrors": false,
		"pivotColumn": null,
		"predictOutput": false,
		"prefix": null,
		"privEsc": false,
		"profile": false,
		"proxy": null,
		"proxyCred": null,
		"proxyFile": null,
		"purgeOutput": false,
		"query": null,
		"randomAgent": false,
		"referer": null,
		"regexp": null,
		"regAdd": false,
		"regData": null,
		"regDel": false,
		"regKey": null,
		"regRead": false,
		"regType": null,
		"regVal": null,
		"requestFile": null,
		"retries": 3,
		"risk": 1,
		"rFile": null,
		"rParam": null,
		"runCase": null,
		"safUrl": null,
		"saFreq": 0,
		"saveCmdline": false, 
		"scope": null, 
		"search": false,
		"secondOrder": null,
		"sessionFile": null,
		"shLib": null,
		"sitemapUrl": null,
		"skip": null,
		"skipUrlEncode": false,
		"smart": false,
		"smokeTest": false, 
		"sqlFile": null,
		"sqlShell": false,
		"stopFail": false,
		"string": null,
		"suffix": null,
		"tamper": null,
		"tbl": null,
		"tech": "BEUSTQ",
		"testFilter": null,
		"testParameter": null,
		"textOnly": false,
		"threads": 1,
		"timeout": 30,
		"timeSec": 5,
		"titles": false,
		"tmpPath": null,
		"tor": false,
		"torPort": null,
		"torType": "HTTP",
		"trafficFile": null,
		"uChar": null,
		"uCols": null,
		"udfInject": false,  
		"uFrom": null,
		"updateAll": false,
		"url": null,
		"user": null,
		"verbose": 1,
		"wizard": false,
		"wFile": null
	    }, 
	    "success": true
	}
    */
    public function listOptions($taskid) {
      $json = json_decode(file_get_contents($this->api . "option/" . $taskid . "/list"), true);
      if($json['success'] == "true") {
        return $json;
      }
      return false;
    }


    /*
       Get SQLMAP Configuration Option Value under specific task ID
       Returns the option value as string on success, false otherwise
         $taskid = your user level task id to look under
         $optstr = the SQLMAP configuration option string
            NOTE: It's case sensitive, so reference list example above if stuck
    */
    public function getOptionValue($taskid, $optstr) {
      // Sorry, not going to pass through code to be eval'd in setter so not going to bother trying to return value...
      if((strtolower(trim($optstr)) != "evalcode") && (strtolower(trim($optstr)) != "eval")) {
        $opts = array(
          'http'=> array(
            'method'=>"POST",
            'header'=>"Content-Type: application/json\r\n",
            'content' => '{"option":"' . trim($optstr) . '"}',
            'timeout' => 60
          )
        );
        $context = stream_context_create($opts);
        $json = json_decode(file_get_contents($this->api . "option/" . $taskid . "/get", false, $context), true);
        if($json['success'] == "true") {
          return $json[$optstr];
        }
      }
      return false;
    }


    /*
       Set SQLMAP Configuration Option Value under specific task ID
       Returns true on success, false otherwise
         $taskid = your user level task id to look under
         $optstr = the SQLMAP configuration option we want to set value for (case sensitive)
         $optvalue = the value to set for configuration option above ($optstr)
    */
    public function setOptionValue($taskid, $optstr, $optvalue, $integer=false) {
      // Sorry, not going to pass through code to be eval'd here...
      if((strtolower(trim($optstr)) != "evalcode") && (strtolower(trim($optstr)) != "eval")) {
        if(!$integer) {
          $opts = array(
            'http'=> array(
              'method'=>"POST",
              'header'=>"Content-Type: application/json\r\n",
              'content' => '{"' . trim($optstr) . '":"' . trim($optvalue) . '"}',
              'timeout' => 60
            )
          );
        } else {
          $opts = array(
            'http'=> array(
              'method'=>"POST",
              'header'=>"Content-Type: application/json\r\n",
              'content' => '{"' . trim($optstr) . '":' . trim($optvalue) . '}',
              'timeout' => 60
            )
          );
        }
        $context = stream_context_create($opts);
        $json = json_decode(file_get_contents($this->api . "option/" . $taskid . "/set", false, $context), true);
        if($json['success'] == "true") {
          return true;
        }
      }
      return false;
    }


    /*
       Start SQLMAP Scan using all configured options under user level task ID
       Returns the scan engine id for tracking status and results on success, false otherwise
         $taskid = your user level task id to track scan under
    */
    public function startScan($taskid) {
      $opts = array(
        'http'=> array(
          'method'=>"POST",
          'header'=>"Content-Type: application/json\r\n",
          'content' => '{ "url":"' . trim($this->getOptionValue($taskid, "url")) . '"}',
          'timeout' => 60
        )
      );
      $context = stream_context_create($opts);
      $json = json_decode(file_get_contents($this->api . "scan/" . $taskid . "/start", false, $context), true);
      if($json['success'] == 1) {
        return $json['engineid'];
      }
      return false;
    }


    /*
       Gracefully Stop a SQLMAP Scan, identified by user level task ID
       Returns true on success, false otherwise
         $taskid = your user level task id to stop scan for
    */
    public function stopScan($taskid) {
      $json = json_decode(file_get_contents($this->api . "scan/" . $taskid . "/stop"), true);
      if($json['success'] == 1) {
        return true;
      }
      return false;
    }


    /*
       Forcefully KILL a SQLMAP Scan, identified by user level task ID
       Returns true on success, false otherwise
         $taskid = your user level task id to kill scan for
    */
    public function killScan($taskid) {
      $json = json_decode(file_get_contents($this->api . "scan/" . $taskid . "/kill"), true);
      if($json['success'] == 1) {
        return true;
      }
      return false;
    }


    /*
       Check Status for a SQLMAP Scan, identified by user level task ID
       Returns associative array on success, false otherwise
           array(
             "status" => "running|terminated|not running",
             "code" => (int) "Process Polling Return Code, Status Percent?"
           );

         $taskid = your user level task id to check scan status for
    */
    public function checkScanStatus($taskid) {
      $json = json_decode(file_get_contents($this->api . "scan/" . $taskid . "/status"), true);
      if($json['success'] == 1) {
        return array("status" => $json['status'], "code" => $json['returncode']);
      }
      return false;
    }


    /*
       Fetch the Scan Data from finished SQLMAP scan, identified by user level task ID
       Returns associative array on success, false otherwise
           array(
             "data"  => array(
                "status" => "stats",
                "type" => "content_type",
                "value" => "some value"
                ),
             "error" => array("error msg", "error msg2", ...)
           );

         $taskid = your user level task id  to get scan data for
    */
    public function getScanData($taskid) {
      $json = json_decode(file_get_contents($this->api . "scan/" . $taskid . "/data"), true);
      if($json['success'] == 1) {
        return array("data" => $json['data'], "error" => $json['error']);
      }
      return false;
    }


    /*
       Review a subset of the SQLMAP scan log messages
       Message subset is based on start and end points provided by user
       Returns associative array on success, false otherwise
           array(
             "log"  => array(
               array(
                 "message" => "testing connection to the target URL", 
                 "level" => "INFO",
                 "time" => "19:44:23"
               ),
               array(
                 "message" => "testing if the target URL is stable. This can take a couple of seconds", 
                 "level" => "INFO",
                 "time" => "19:44:24"
               ), 
               array(...)
           );

         $taskid = your user level task id to get scan log for
          $start = the log entry index to start on
            $end = the log entry index to end on
    */
    public function reviewScanLogPartial($taskid, $start, $end) {
      $json = json_decode(file_get_contents($this->api . "scan/" . $taskid . "/log/" . $start . "/" . $end), true);
      if($json['success'] == 1) {
        return $json['log'];
      }
      return false;
    }


    /*
       Review the FULL set of SQLMAP scan log messages
       Returns associative array on success, false otherwise
           array(
             "log"  => array(
               array(
                 "message" => "testing connection to the target URL", 
                 "level" => "INFO",
                 "time" => "19:44:23"
               ),
               array(
                 "message" => "testing if the target URL is stable. This can take a couple of seconds", 
                 "level" => "INFO",
                 "time" => "19:44:24"
               ), 
               array(...)
           );

         $taskid = your user level task id to get scan log for
    */
    public function reviewScanLogFull($taskid) {
      $json = json_decode(file_get_contents($this->api . "scan/" . $taskid . "/log"), true);
      if($json['success'] == 1) {
        return $json['log'];
      }
      return false;
    }


    /*
       Download a Scan Result File for a Particular Target under Task ID
       Returns $filename's content as base64 encoded string on success, false otherwise

         $taskid = your user level task id to find results under
         $target = ip or domain from scan
            NOTE: This is what SQLMAP will create folder under in output directory on scan initialization
              i.e. 10.10.10.10, domain.com, sub.domain.com or www.domain.com
         $filename = the file you wish to download
            NOTE: filename should include path (relative to sqlmap/output/target/ folder)
              i.e. dump/dbname/tblname.csv
              i.e. dump/ipbf_db/ipbf_members.csv
              i.e. files/filename
              i.e. files/_etc_passwd
    */
    public function downloadTargetFile($taskid, $target, $filename) {
      if((!preg_match("#..|%2e%2e|\x2e\x2e|0x2e0x2e#", $target)) && (!preg_match("#..|%2e%2e|\x2e\x2e|0x2e0x2e#", $filename))) {
        $json = json_decode(file_get_contents($this->api . "download/" . $taskid . "/" . $target . "/" . $filename), true);
        if($json['success'] == "true") {
          return $json['file'];
        }
      }
      return false;
    }
  }

?>
