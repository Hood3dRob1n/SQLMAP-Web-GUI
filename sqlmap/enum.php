
            <br />
            <div class="row">
              <div class="col-md-1"></div>
              <div class="col-md-4">
                <div id="display_enum_db_data_form" align="central">
                  <label for="enum_db">Database(s) to Dump or Enumerate:</label>
                  <input type="text" class="form-control" id="enum_db" name="db" placeholder="i.e. database,names,here ">
                  <br />
                </div>

                <div id="display_enum_table_data_form" align="central">
                  <br />
                  <label for="enum_table">Table(s) to Dump or Enumerate:</label>
                  <input type="text" class="form-control" id="enum_table" name="tbl" placeholder="i.e. table,names,here ">
                  <br />
                </div>

                <div id="display_enum_column_data_form" align="central">
                  <br />
                  <label for="enum_column">Column(s) to Dump or Enumerate:</label>
                  <input type="text" class="form-control" id="enum_column" name="col" placeholder="i.e. juicy,columns,here ">
                  <br />
                </div>

                <div id="display_enum_not_column_data_form" align="central">
                  <br />
                  <label for="enum_exclude_column">Column(s) to Exclude or NOT Enumerate:</label>
                  <input type="text" class="form-control" id="enum_exclude_column" name="excludeCol" placeholder="i.e. useless,columns,here ">
                  <br />
                </div>

                <div id="display_enum_db_user_data_form" align="central">
                  <br />
                  <label for="enum_db_user">Specific Database User to Enumerate:</label>
                  <input type="text" class="form-control" id="enum_db_user" name="user" placeholder="i.e. username ">
                  <br />
                </div>

                <div id="display_enum_where_data_form" align="central">
                  <br />
                  <label for="enum_where">Where Condition to Filter Dump Results:</label>
                  <input type="text" class="form-control" id="enum_where" name="dumpWhere" placeholder="i.e. group='admin' ">
                  <br />
                </div>

              </div>
              <div class="col-md-1"></div>
              <div class="col-md-4">
                <label for="select_enum_options">Select Enumeration Options to Enable:</label>
                <select class="form-control" id="enum_options" name="enum_options[]" size="19" onchange="enumCheck()" multiple>
                  <option value="getAll">Enumerate ALL the Things!</option>
                  <option value="getBanner" selected="selected">Version or Banner Info</option>
                  <option value="extensiveFp">Extensive DBMS Fingerprint</option>
                  <option value="getHostname">Database Server Hostname</option>
                  <option value="getCurrentDb">Current Active Database</option>
                  <option value="getDbs">All Available Databases</option>
                  <option value="getCurrentUser">Current Database User</option>
                  <option value="getUsers">All Database Users</option>
                  <option value="getSchema">Dump Database & Table Schema</option>
                  <option value="isDba">Check if User Is DBA</option>
                  <option value="getPasswordHashes">Dump Database User Passwords</option>
                  <option value="getPrivileges">Check Database User Privileges</option>
                  <option value="getRoles">Check Database User Roles</option>
                  <option value="getCount">Identify Count</option>
                  <option value="getTables">Identify Tables</option>
                  <option value="getColumns">Identify Columns</option>
                  <option value="search">Search for DB, Table or Column Name</option>
                  <option value="commonTables">Bruteforce Common Tables</option>
                  <option value="commonColumns">Bruteforce Common Columns</option>
                  <option value="dumpTable">Dump Data</option>
                  <option value="dumpAll">Dump All the Things!</option>
                  <option value="excludeSysDbs">Exclude Default System Databases</option>


                </select><br />
                <div class="col-md-1"></div>
                <div class="col-md-4">
                  <label for="select_row_start">Row Start:</label>
                  <select class="form-control" id="select_row_start" name="limitStart">
                    <option value="" selected="selected"> Disabled </option>
                    <?php
                      foreach(range(1, 1000) as $number) {
                        echo "                  <option value=\"$number\"> $number </option>";
                      }
                    ?>
                  </select><br />
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                  <label for="select_row_stop">Row Stop:</label>
                  <select class="form-control" id="select_row_stop" name="limitStop">
                    <option value="" selected="selected"> Disabled </option>
                    <?php
                      foreach(range(1, 1000) as $number) {
                        echo "                  <option value=\"$number\"> $number </option>";
                      }
                    ?>
                  </select><br />
                </div>
                <div class="col-md-1"></div>

                <div class="col-md-12">
                  <div id="display_enum_sql_query_data_form" align="central">
                    <br />
                    <label for="enum_sql_query">SQL Statement to Execute:</label>
                    <input type="text" class="form-control" id="enum_sql_query" name="enum_sql_query" placeholder="i.e. SELECT version() ">
                    <br />
                  </div>
                </div>
              </div>
              <div class="col-md-1"></div>
            </div>

