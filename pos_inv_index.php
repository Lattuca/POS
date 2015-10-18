<!doctype html>
<?php
require('pos_functions.php');
html_head("POS status");
require('pos_header.php');
require('pos_sidebar.php');
require('pos_values.php');

# Code for your web page follows
# Point Of Sale Project

try
{
  //open the database
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<h2>Current Inventory List</h2>
<br/>
<br/>


<table border=4  CELLSPACING=0 CELLPADDING=0>
  <tr>
    <td BGCOLOR="#C0C0C0", align="center">Product Code</td>
    <td BGCOLOR="#C0C0C0", align="center">Description</td>
    <td BGCOLOR="#C0C0C0", align="center">Category</td>>
    <td BGCOLOR="#C0C0C0", align="center">Available Qty</td>
    <td BGCOLOR="#C0C0C0", align="center">Price</td>
    <td BGCOLOR="#C0C0C0", align="center">Available</td>
    <td BGCOLOR="#C0C0C0", align="center">Last Update</td>
    <td BGCOLOR="#C0C0C0", align="center" colspan="2">Select Options</td>
  </tr>


<?php
  echo "chi fa";
  setlocale(LC_MONETARY, 'en_US.UTF-8'); # show currency in USD
  $query = "SELECT * from inventories Order BY product_upc";
  $result = $db->query($query);
  foreach($result as $row) {
    print "<tr>";
    $number = $row['price'];
    $available = yes_no($row['available']);
    print '<td align="left">'.$row['product_upc']."</td>";
    print "<td>".$row['product_desc']."</td>";
    print '<td align="center">'.$row['category']."</td>";
    print '<td align="center">'.$row['qty']."</td>";
    print '<td align="right">'.money_format('%.2n', $number)."</td>";
    print '<td align="center">'.$available."</td>";
    print '<td align="center">'.$row['last_update']."</td>";
    print "<td align='center'><a href='pos_inv_update.php?id=" . $row['id']  . "'>edit</a></td>";
    print "<td align='center'><a href='pos_inv_delete.php?id=" . $row['id'] . "'>delete</a></td>";
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
