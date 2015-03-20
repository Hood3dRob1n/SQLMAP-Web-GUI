jQuery(function(){
  var $lis = $('.nav > li').click(function(){
    $lis.removeClass('active');
    $(this).addClass('active');
  });
})

function divHideAndSeek(divname, flip) {
  if(flip==1) {
    document.getElementById(divname).style.display="none";
  } else {
    document.getElementById(divname).style.display="block";
  }
}

function tabFlipper(tabNum) {
  if(tabNum==2) {
    divHideAndSeek("settings_basics_container", 1)
    divHideAndSeek("settings_idt_container", 0)
    divHideAndSeek("settings_idt2_container", 1)
    divHideAndSeek("settings_request_container", 1)
    divHideAndSeek("settings_enum_container", 1)
    divHideAndSeek("settings_access_container", 1)
  } else if(tabNum==3) {
    divHideAndSeek("settings_basics_container", 1)
    divHideAndSeek("settings_idt_container", 1)
    divHideAndSeek("settings_idt2_container", 1)
    divHideAndSeek("settings_request_container", 0)
    divHideAndSeek("settings_enum_container", 1)
    divHideAndSeek("settings_access_container", 1)
  } else if(tabNum==4) {
    divHideAndSeek("settings_basics_container", 1)
    divHideAndSeek("settings_idt_container", 1)
    divHideAndSeek("settings_idt2_container", 1)
    divHideAndSeek("settings_request_container", 1)
    divHideAndSeek("settings_enum_container", 0)
    divHideAndSeek("settings_access_container", 1)
  } else if(tabNum==5) {
    divHideAndSeek("settings_basics_container", 1)
    divHideAndSeek("settings_idt_container", 1)
    divHideAndSeek("settings_idt2_container", 1)
    divHideAndSeek("settings_request_container", 1)
    divHideAndSeek("settings_enum_container", 1)
    divHideAndSeek("settings_access_container", 0)
  } else if(tabNum==6) {
    divHideAndSeek("settings_basics_container", 1)
    divHideAndSeek("settings_idt_container", 1)
    divHideAndSeek("settings_idt2_container", 0)
    divHideAndSeek("settings_request_container", 1)
    divHideAndSeek("settings_enum_container", 1)
    divHideAndSeek("settings_access_container", 1)
  } else {
    divHideAndSeek("settings_basics_container", 0)
    divHideAndSeek("settings_idt_container", 1)
    divHideAndSeek("settings_idt2_container", 1)
    divHideAndSeek("settings_request_container", 1)
    divHideAndSeek("settings_enum_container", 1)
    divHideAndSeek("settings_access_container", 1)
  }
}

function techCheck() {
  var selected = [];
  var sel = document.getElementById('technique');
  for (var i=0, n=sel.options.length;i<n;i++) {
    if (sel.options[i].selected) {
      selected.push(sel.options[i].value);
    }
  }
  if ((selected.indexOf('U') > -1) || (selected.indexOf('A') > -1)) {
    divHideAndSeek('display_union_data_form', 0);
  } else {
    divHideAndSeek('display_union_data_form', 1);
  }
  if ((selected.indexOf('T') > -1) || (selected.indexOf('A') > -1)) {
    divHideAndSeek('display_time_based_data_form', 0);
  } else {
    divHideAndSeek('display_time_based_data_form', 1);
  }
}

function enumCheck() {
  var selected = [];
  var sel = document.getElementById('enum_options');
  for (var i=0, n=sel.options.length;i<n;i++) {
    if (sel.options[i].selected) {
      selected.push(sel.options[i].value);
    }
  }
}

function redirectHome() {
  window.location="/sqlmap/index.php";
}

function validateMarkerInjection() {
  var pattern = /\*/i;
  if(pattern.test(document.prep_form.target_url.value)) {
    return true;
  }
  if(pattern.test(document.prep_form.post_data.value)) {
    return true;
  }
  if(pattern.test(document.prep_form.user_agent.value)) {
    return true;
  }
  if(pattern.test(document.prep_form.cookie_str.value)) {
    return true;
  }
  if(pattern.test(document.prep_form.referer_str.value)) {
    return true;
  }
  if(pattern.test(document.prep_form.host_str.value)) {
    return true;
  }
  alert("* Marker Enabled, but NOT Found Anywhere!" );
  document.fuzzForm.target_url.focus();
  return false;
}

function validate() {
  return true;
}

function downloadScanResults(hostName) {
  window.location="/sqlmap/download.php?target=" + encodeURIComponent(hostName);
}

function scanKill(scanId) {
  window.location="/sqlmap/kill.php?id="+scanId;
}
