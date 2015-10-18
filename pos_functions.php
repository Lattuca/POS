<?php
# mysqli_bind_param standard functions
function html_head($title) {
  echo '<html lang="en">';
  echo '<head>';
  echo '<meta charset="utf-8">';
  echo "<title>$title</title>";
  echo '<link rel="stylesheet" href="pos.css">';
  echo '</head>';
  echo '<body>';
}

function try_again($str) {
  echo $str;
  echo "<br/>";
  //the following emulates pressing the back button on a browser
  echo '<a href="#" onclick="history.back(); return false;">Try Again</a>';
  require('pos_footer.php');
  exit;
}

function yes_no($input)
{ if ($input=="1"){
  return "Yes";
  }
else {
  return  "No";
  }
}
 
function cvt_yes_no($input)
  { if ($input =="Yes") {
    return "1";
  }else{
    return "0";
  }
}
?>
