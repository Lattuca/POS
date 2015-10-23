<!doctype html>
<?php
require('pos_functions.php');
html_head("POS Customer");
require('pos_header.php');
require('pos_cust_sidebar.php');
require('pos_values.php');

# Code for your web page follows
# Point Of Sale Project

try
{
  //open the database
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<h2>Current Customer List</h2>
<br/>
<br/>


<table border=4  CELLSPACING=0 CELLPADDING=0>
  <tr>
    <td BGCOLOR="#C0C0C0", align="center">Id</td>
    <td BGCOLOR="#C0C0C0", align="center">Name</td>
    <td BGCOLOR="#C0C0C0", align="center">Phone</td>>
    <td BGCOLOR="#C0C0C0", align="center">Email</td>
    <td BGCOLOR="#C0C0C0", align="center">State Code</td>
    <td BGCOLOR="#C0C0C0", align="center">Last Update</td>
    <td BGCOLOR="#C0C0C0", align="center" colspan="2">Select Options</td>
  </tr>


<?php
  echo "chi fa";
  $query = "SELECT * from customers Order BY name";
  $result = $db->query($query);
  foreach($result as $row) {
    print "<tr>";
    print '<td align="left">'.$row['id']."</td>";
    print "<td>".$row['name']."</td>";
    print '<td align="center">'.$row['phone']."</td>";
    print '<td align="center">'.$row['email']."</td>";
    print '<td align="center">'.$row['state_code']."</td>";
    print '<td align="center">'.$row['last_update']."</td>";
    print "<td align='center'><a href='pos_cust_update.php?id=" . $row['id']  . "'>edit</a></td>";
    print "<td align='center'><a href='pos_cust_delete.php?id=" . $row['id'] . "'>delete</a></td>";
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

require('pos_footer.php');

?>
