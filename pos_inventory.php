<!doctype html>
<?php
require('pos_functions.php');
html_head("POS status");
require('pos_header.php');
require('pos_sidebar.php');
require('pos_values.php');

# Code for your web page follows
# Point Of Sale Poroject

try
{
  //open the database
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<br>
<br>
<br>
<br>
<h2>POS Inventory</h2>
<!-- display all equipment -->

<table border=1>
  <tr>
    <td>Title</td><td>Author</td><td>Type</td><td>Description</td><td>User</td><td>Reserved Till</td>
  </tr>

<?php
  $query = "SELECT * from media WHERE status = 'active'";
  $result = $db->query($query);
  foreach($result as $row) {
    print "<tr>";
    print "<td>".$row['title']."</td>";
    print "<td>".$row['author']."</td>";
    print "<td>".$row['type']."</td>";
    print "<td>".$row['description']."</td>";
    $user_id = $row['user_id'];
    if ($user_id > 0){
    $result = $db->query("SELECT * FROM users where id = $user_id")->fetch();
              $user_name = $result['first']." ".$result['last'];
              $date_in = $row['date_in'];
            } else {
              $user_name = "available";
              $date_in = "not reserved";
            }
            print "<td>".$user_name."</td>";
            print "<td>".$date_in."</td>";
            print "</tr>";
  }
  print "</table>";

  // close the database connection
  $db = NULL;
}

catch(PDOException $e)
{
  echo 'Exception : '.$e->getMessage();
  echo "<br/>";
  $db = NULL;
}

require('mlib_footer.php');

?>
