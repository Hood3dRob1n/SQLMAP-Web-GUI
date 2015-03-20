
            <br />
            <div class="row">
              <div class="col-md-1"></div>
              <div class="col-md-3">
                <label for="select_comaprison_text_only">Text Only Page Comparisons:</label>
                <select class="form-control" id="select_comaprison_text_only" name="textOnly">
                  <option value="" selected="selected">Disabled</option>
                  <option value="enabled">Enabled</option>
                </select><br />

                <label for="select_comaprison_title_only">Page Title Only Comparisons:</label>
                <select class="form-control" id="select_comaprison_title_only" name="titles">
                  <option value="" selected="selected">Disabled</option>
                  <option value="enabled">Enabled</option>
                </select><br />

                <label for="select_comaprison_code">Match HTTP Status Code on True:</label>
                <select class="form-control" id="select_comaprison_code" name="comaprison_code">
                  <option value="" selected="selected" onClick="divHideAndSeek('display_comaprison_code_data_form', 1)">Disabled</option>
                  <option value="enabled" onClick="divHideAndSeek('display_comaprison_code_data_form', 0)">Enabled</option>
                </select>
                <div id="display_comaprison_code_data_form" align="central" style="display: none">
                  <br />
                  <label for="request_comaprison_code">HTTP Status Code to Match:</label>
                  <select class="form-control" id="request_comaprison_code" name="request_comaprison_code">
                    <option value="100"> 100 </option>
                    <option value="101"> 101 </option>
                    <option value="200" selected="selected"> 200 </option>
                    <option value="201"> 201 </option>
                    <option value="202"> 202 </option>
                    <option value="203"> 203 </option>
                    <option value="204"> 204 </option>
                    <option value="205"> 205 </option>
                    <option value="206"> 206 </option>
                    <option value="300"> 300 </option>
                    <option value="301"> 301 </option>
                    <option value="302"> 302 </option>
                    <option value="303"> 303 </option>
                    <option value="304"> 304 </option>
                    <option value="305"> 305 </option>
                    <option value="306"> 306 </option>
                    <option value="307"> 307 </option>
                    <option value="400"> 400 </option>
                    <option value="401"> 401 </option>
                    <option value="402"> 402 </option>
                    <option value="403"> 403 </option>
                    <option value="404"> 404 </option>
                    <option value="405"> 405 </option>
                    <option value="406"> 406 </option>
                    <option value="407"> 407 </option>
                    <option value="408"> 408 </option>
                    <option value="409"> 409 </option>
                    <option value="410"> 410 </option>
                    <option value="411"> 411 </option>
                    <option value="412"> 412 </option>
                    <option value="413"> 413 </option>
                    <option value="414"> 414 </option>
                    <option value="415"> 415 </option>
                    <option value="416"> 416 </option>
                    <option value="417"> 417 </option>
                    <option value="500"> 500 </option>
                    <option value="501"> 501 </option>
                    <option value="502"> 502 </option>
                    <option value="503"> 503 </option>
                    <option value="504"> 504 </option>
                    <option value="505"> 505 </option>
                  </select>
                  <br />
                </div><br />
              </div>
              <div class="col-md-2"></div>
              <div class="col-md-5">
                <label for="select_comaprison_str">Set Custom String to Match on True:</label>
                <select class="form-control" id="select_comaprison_str" name="comaprison_str">
                  <option value="" selected="selected" onClick="divHideAndSeek('display_comaprison_str_data_form', 1)">Disabled</option>
                  <option value="enabled" onClick="divHideAndSeek('display_comaprison_str_data_form', 0)">Enabled</option>
                </select>
                <div id="display_comaprison_str_data_form" align="central" style="display: none">
                  <br />
                  <label for="request_comaprison_str">String to Match on True:</label>
                  <input type="text" class="form-control" id="request_comaprison_str" name="request_comaprison_str" placeholder="i.e. string present on original and True pages, but NOT on False ">
                </div><br />

                <label for="select_comaprison_not_str">Set Custom String to Match on False:</label>
                <select class="form-control" id="select_comaprison_not_str" name="comaprison_not_str">
                  <option value="" selected="selected" onClick="divHideAndSeek('display_comaprison_not_str_data_form', 1)">Disabled</option>
                  <option value="enabled" onClick="divHideAndSeek('display_comaprison_not_str_data_form', 0)">Enabled</option>
                </select>
                <div id="display_comaprison_not_str_data_form" align="central" style="display: none">
                  <br />
                  <label for="request_comaprison_not_str">String to Match on False:</label>
                  <input type="text" class="form-control" id="request_comaprison_not_str" name="request_comaprison_not_str" placeholder="i.e. string NOT present on original or True pages, but is on False ">
                </div><br />

                <label for="select_comaprison_regex">Set Custom Regex Pattern to Match on True:</label>
                <select class="form-control" id="select_comaprison_regex" name="comaprison_regex">
                  <option value="" selected="selected" onClick="divHideAndSeek('display_comaprison_regex_data_form', 1)">Disabled</option>
                  <option value="enabled" onClick="divHideAndSeek('display_comaprison_regex_data_form', 0)">Enabled</option>
                </select>
                <div id="display_comaprison_regex_data_form" align="central" style="display: none">
                  <br />
                  <label for="request_comaprison_regex_str">Regex Pattern to Match on True:</label>
                  <input type="text" class="form-control" id="request_comaprison_regex_str" name="request_comaprison_regex_str" placeholder="i.e. pattern to match on original and true pages, not on false ">
                </div><br />


              </div>
              <div class="col-md-1"></div>
            </div>

