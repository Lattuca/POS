<!doctype html>
<?php
require('pos_functions.php');
html_head("POS Delete");
require('pos_header.php');
require('pos_usr_sidebar.php');
require('pos_values.php');
#require('pos_confirm.php');

# Code for your web page follows
# Point Of Sale Project

if (!isset($_POST['submit']))
{
  $user_id =$_GET['id'];
  echo "record id: ".$user_id;
  print "<h2>POS User Delete</h2>";

try
{
  //open the database
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //Load and display

  $query = "SELECT * from users WHERE users.id = $user_id";
  $result = $db->query($query)->fetch(PDO::FETCH_ASSOC);

  // Display the data to confirm

  //now output the data from the insert to a simple html table...
  print "<table border=4  CELLSPACING=4 CELLPADDING=4>";
  print "<tr>";
  print '<td BGCOLOR="#C0C0C0", align="center">User Id</td>';
  print '<td BGCOLOR="#C0C0C0", align="center">First</td>';
  print '<td BGCOLOR="#C0C0C0", align="center">Last</td>';
  print '<td BGCOLOR="#C0C0C0", align="center">Email</td>';
  print "</tr>";


  print "<tr>";
  print '<td align="center">'.$result['id']."</td>";
  print '<td align="left">'.$result['first']."</td>";
  print '<td align="left">'.$result['last']."</td>";
  print '<td align="center">'.$result['email']."</td>";
    print "</tr>";
  print "</table>";


  print "<br/><br/><br/><br/><br/><br/>";
  echo'<td class="style2"><a href="pos_usr_del_user.php?id='.$user_id.'"onclick="javascript:return confirm(\'Are you sure you want to delete this User?\')">Confirm Delete</a>';"</td></tr>";


}
catch(PDOException $e)
{
  echo 'Exception : '.$e->getMessage();
  echo "<br/>";
  $db = NULL;
}

}
?>
