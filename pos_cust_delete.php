<!doctype html>
<?php
require('pos_functions.php');
html_head("POS Delete Customer");
require('pos_header.php');
require('pos_cust_sidebar.php');
require('pos_values.php');
#require('pos_confirm.php');

# Code for your web page follows
# Point Of Sale Project

if (!isset($_POST['submit']))
{
  $customer_id =$_GET['id'];
  echo "record id: ".$customer_id;
  print "<h2>POS Customer Delete</h2>";

try
{
  //open the database
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //Load and display

  $query = "SELECT * from customers WHERE customers.id = $customer_id";
  $result = $db->query($query)->fetch(PDO::FETCH_ASSOC);

  // Display the data to confirm

  //now output the data from the insert to a simple html table...
  print "<table border=4  CELLSPACING=4 CELLPADDING=4>";
  print "<tr>";
  print '<td BGCOLOR="#C0C0C0", align="center">Customer Id</td>';
  print '<td BGCOLOR="#C0C0C0", align="center">Name</td>';
  print '<td BGCOLOR="#C0C0C0", align="center">Phone</td>';
  print '<td BGCOLOR="#C0C0C0", align="center">Email</td>';
  print "</tr>";


  print "<tr>";
  print '<td align="center">'.$result['id']."</td>";
  print '<td align="left">'.$result['name']."</td>";
  print '<td align="left">'.$result['phone']."</td>";
  print '<td align="center">'.$result['email']."</td>";
    print "</tr>";
  print "</table>";


  print "<br/><br/><br/><br/><br/><br/>";
  echo'<td class="style2"><a href="pos_cust_del_customer.php?id='.$customer_id.'"onclick="javascript:return confirm(\'Are you sure you want to delete this customer?\')">Confirm Delete</a>';"</td></tr>";


}
catch(PDOException $e)
{
  echo 'Exception : '.$e->getMessage();
  echo "<br/>";
  $db = NULL;
}

}
?>
