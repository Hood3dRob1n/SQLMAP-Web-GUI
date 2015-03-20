
            <br />
            <div class="row">
              <div class="col-md-6">
                <label for="url">Target URL:</label>
                <input type="text" class="form-control" id="url" name="url" placeholder="http://site.com/vuln.php?id=1">
              </div>
              <div class="col-md-2">
                <label for="select_method">HTTP Method:</label>
                <select class="form-control" id="select_method" name="method">
                  <option value="GET" selected="selected" onClick="divHideAndSeek('display_post_data_form', 1)">Default (GET)</option>
                  <option value="OPTIONS" onClick="divHideAndSeek('display_post_data_form', 1)">OPTIONS</option>
                  <option value="HEAD" onClick="divHideAndSeek('display_post_data_form', 1)">HEAD</option>
                  <option value="POST" onClick="divHideAndSeek('display_post_data_form', 0)">POST</option>
                  <option value="PUT" onClick="divHideAndSeek('display_post_data_form', 0)">PUT</option>
                </select><br />
              </div>
              <div class="col-md-3">
                <label for="select_method">Flush Any Existing Session Info:</label>
                <select class="form-control" id="select_method" name="flushSession">
                  <option value="n" selected="selected">No</option>
                  <option value="y">Yes</option>
                </select><br />
              </div>
              <div class="col-md-1"></div>
            </div>

            <div class="row">
              <div class="col-md-3"></div>
              <div class="col-md-6">
                <div id="display_post_data_form" align="central" style="display: none">
                  <label for="post_data">Request Data String:</label>
                  <input type="text" class="form-control" id="post_data" name="data" placeholder="i.e. username=foo&password=bar&submit=Submit">
                </div><br />
              </div>
              <div class="col-md-3"></div>
            </div>


            <div class="row">
              <div class="col-md-1"></div>
              <div class="col-md-2">
                <label class="radio-inline">
                  <input type="radio" name="identifier" value="marker" onClick="divHideAndSeek('display_identifier_data_form', 1); divHideAndSeek('display_skip_data_form', 1);">* Marking Injection
                </label>
              </div>
              <div class="col-md-3">
                <label class="radio-inline">
                  <input type="radio" name="identifier" value="parameter" onClick="divHideAndSeek('display_identifier_data_form', 0); divHideAndSeek('display_skip_data_form', 1);">Known Vulnerable Parameter
                </label>
              </div>
              <div class="col-md-3">
                <label class="radio-inline">
                  <input type="radio" name="identifier" checked="checked" value="fuzz" onClick="divHideAndSeek('display_identifier_data_form', 1); divHideAndSeek('display_skip_data_form', 0);">Unknown, Fuzz All Parameters!
                </label>
              </div>
              <div class="col-md-3">
                <label class="radio-inline">
                  <input type="radio" name="identifier" value="forms" onClick="divHideAndSeek('display_identifier_data_form', 1); divHideAndSeek('display_skip_data_form', 0);">Unknown, Fuzz Forms on Page
                </label>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3"></div>
              <div class="col-md-5">
                <br /><br />
                <div id="display_identifier_data_form" align="central" style="display: none">
                  <label for="testParameter">Vulnerable Parameter Name:</label>
                  <input type="text" class="form-control" id="testParameter" name="testParameter" placeholder="i.e. paramName">
                  <br />
                </div>
                <div id="display_skip_data_form" align="central" style="display: block">
                  <label for="vuln_param">Optional Parameter Name(s) to Skip:</label>
                  <input type="text" class="form-control" id="skip_param" name="skip" placeholder="i.e. paramName,to,skip">
                  <br />
                </div>
              </div>
              <div class="col-md-4"></div>
            </div>



