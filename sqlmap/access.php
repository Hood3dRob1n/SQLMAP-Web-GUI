
            <br />
            <div class="row">
              <div class="col-md-3"></div>
              <div class="col-md-6">
                <label for="select_file_privs">File System Options:</label>
                <select class="form-control" id="file_privs" name="file_privs">
                  <option value="" selected="selected" onClick="divHideAndSeek('display_file_read_data_form', 1); divHideAndSeek('display_file_write_data_form', 1);">None</option>
                  <option value="r" onClick="divHideAndSeek('display_file_read_data_form', 0); divHideAndSeek('display_file_write_data_form', 1);">Read Files from DB Server</option>
                  <option value="w" onClick="divHideAndSeek('display_file_write_data_form', 0); divHideAndSeek('display_file_read_data_form', 1);">Write Payload Files to Target DB Server</option>
                </select>
                <div id="display_file_read_data_form" align="central" style="display: none">
                  <br />
                  <label for="file_read">File to Read:</label>
                  <input type="text" class="form-control" id="file_read" name="rFile" placeholder="i.e. /etc/passwd or c:/windows/win.ini ">
                  <br />
                </div>
                <div id="display_file_write_data_form" align="central" style="display: none">
                  <br />
                  <label for="file_write">File to Write:</label>
                  <select class="form-control" id="file_write" name="file_write">
                    <option value="cmdShell" selected="selected" onClick="divHideAndSeek('display_file_write_revShell_data_form', 1);">Basic Web Based Command Shell</option>
                    <option value="uploader" onClick="divHideAndSeek('display_file_write_revShell_data_form', 1);">Basic File Uploader</option>
                    <option value="revShell" onClick="divHideAndSeek('display_file_write_revShell_data_form', 0);" disabled>Reverse Shell Script</option>
                  </select>
                  <br />
                  <div id="display_file_write_cmdShell_data_form" align="central" style="display: block">
                    <label for="dFile">Full Path & Filename to Write on Target:</label>
                    <input type="text" class="form-control" id="dFile" name="dFile" placeholder="i.e. /var/www/writeable/customFile.fileType ">
                    <br />
                    <label for="cmdShellLang">Command Shell Language Type to Use:</label>
                    <select class="form-control" id="cmdShellLang" name="cmdShellLang">
                      <option value="1">ASP</option>
                      <option value="2">ASPX</option>
                      <option value="3">JSP</option>
                      <option value="4" selected="selected">PHP</option>
                    </select>
                    <br />
                    <div id="display_file_write_revShell_data_form" align="central" style="display: none">
                      <label for="revShell_ip">Reverse Shell IP:</label>
                      <input type="text" class="form-control" id="revShell_ip" name="revShell_ip" placeholder="i.e. 10.10.10.10 ">
                      <br />
                      <label for="revShell_port">Reverse Shell Port:</label>
                      <input type="text" class="form-control" id="revShell_port" name="revShell_port" placeholder="i.e. 31337 ">
                    </div>
                  </div>
                </div><br />

                <label for="select_os_privs">Operating System Options:</label>
                <select class="form-control" id="os_privs" name="os_privs">
                  <option value="" selected="selected" onClick="divHideAndSeek('display_os_cmd_data_form', 1); divHideAndSeek('display_osPwn_revShell_data_form', 1)">None</option>
                  <option value="r" onClick="divHideAndSeek('display_os_cmd_data_form', 0); divHideAndSeek('display_osPwn_revShell_data_form', 1)">OS Cmd - Run OS Command on Target</option>
                  <option value="p" onClick="divHideAndSeek('display_osPwn_revShell_data_form', 1); divHideAndSeek('display_osPwn_revShell_data_form', 0)" disabled>OS Pwn - Spawn Meterpreter Reverse Shell</option>


                </select>
                <div id="display_os_cmd_data_form" align="central" style="display: none">
                  <br />
                  <label for="os_cmd">OS Command to Run:</label>
                  <input type="text" class="form-control" id="os_cmd" name="osCmd" placeholder="i.e. whoami ">
                  <br />
                  <label for="cmdShellLang">(Optional) Command Shell Language Type to Use:</label>
                  <select class="form-control" id="cmdShellLang" name="cmdShellLang">
                    <option value="1">ASP</option>
                    <option value="2">ASPX</option>
                    <option value="3">JSP</option>
                    <option value="4" selected="selected">PHP</option>
                  </select>
                  <br />
                  <label for="os_cmd_dFile">(Optional) Writeable File Path to Try on Target:</label>
                  <input type="text" class="form-control" id="os_cmd_dFile" name="os_cmd_dFile" placeholder="i.e. /var/www/html/writeable/ ">
                  <br />
                </div><br />
                <div id="display_osPwn_revShell_data_form" align="central" style="display: none">
                  <label for="meterpreter_type">Meterpreter Reverse Payload Type to Use:</label>
                  <select class="form-control" id="meterpreter_type" name="meterpreter_type">
                    <option value="1" selected="selected">TCP - meterpreter/reverse_tcp</option>
             <!--   <option value="2">TCP Any Port</option> -->
                    <option value="3">HTTP - meterpreter/reverse_http</option>
                    <option value="4">HTTPS - meterpreter/reverse_https</option>
                  </select>
                  <br />
                  <label for="osPwn_tmpPath">(Optional) Temp Path on Target</label>
                  <input type="text" class="form-control" id="osPwn_tmpPath" name="osPwn_tmpPath" placeholder="i.e. C:\\CUSTOM\\TEMP\\ ">
                  <br />
                  <label for="revShell_ip">Meterpreter Listener IP:</label>
                  <input type="text" class="form-control" id="osPwn_ip" name="osPwn_ip" placeholder="i.e. 10.10.10.10 ">
                  <br />
                  <label for="revShell_port">Meterpreter Listener Port:</label>
                  <input type="text" class="form-control" id="osPwn_port" name="osPwn_port" placeholder="i.e. 4444 ">
                  <br /><br />
                </div>
                <label for="select_win_reg">Windows Registry Options:</label>
                <select class="form-control" id="win_reg" name="win_reg">
                  <option value="" selected="selected" onClick="divHideAndSeek('display_win_reg_data_form', 1)">None</option>
                  <option value="r" onClick="divHideAndSeek('display_win_reg_data_form', 0)">Read Windows Registry Key Value</option>
                  <option value="a" onClick="divHideAndSeek('display_win_reg_data_form', 0)">Add Windows Registry Key Value Data</option>
                  <option value="d" onClick="divHideAndSeek('display_win_reg_data_form', 0)">Delete Windows Registry Key Value</option>
                </select><br />
                <br />
               </div>
              <div class="col-md-3"></div>
            </div>

            <div class="row">
              <div id="display_win_reg_data_form" align="central" style="display: none">
                <br />
                <div class="col-md-2"></div>
                <div class="col-md-4">
                  <label for="win_reg_key">Windows Registry Key:</label>
                  <input type="text" class="form-control" id="win_reg_key" name="regKey" placeholder="i.e. HKEY_LOCAL_MACHINE\SOFTWARE\sqlmap ">
                  <br />
                  <label for="win_reg_value">Windows Registry Value:</label>
                  <input type="text" class="form-control" id="win_reg_value" name="regVal" placeholder="i.e. Test ">
                  <br />
                </div>
                <div class="col-md-4">
                  <label for="win_reg_type">Windows Registry Type:</label>
                  <input type="text" class="form-control" id="win_reg_type" name="regType" placeholder="i.e. REG_SZ ">
                  <br />
                  <label for="win_reg_data">Windows Registry Data:</label>
                  <input type="text" class="form-control" id="win_reg_data" name="regData" placeholder="i.e. 1 ">
                  <br />
                </div>
                <div class="col-md-2"></div>
              </div>
            </div>

