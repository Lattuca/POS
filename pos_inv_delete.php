<!doctype html>
<?php
require('pos_functions.php');
html_head("POS Delete");
require('pos_header.php');
require('pos_sidebar.php');
require('pos_values.php');
#require('pos_confirm.php');

# Code for your web page follows
# Point Of Sale Project

if (!isset($_POST['submit']))
{
  $product_id =$_GET['id'];
  echo "record id: ".$product_id;
  print "<h2>POS Inventory Delete</h2>";

try
{
  //open the database
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //Load and display

  $query = "SELECT * from inventories WHERE inventories.id = $product_id";
  $result = $db->query($query)->fetch(PDO::FETCH_ASSOC);

  // Display the data to confirm

  //now output the data from the insert to a simple html table...
  print "<h2>Product to Delete </h2>";
  print "<table border=4  CELLSPACING=4 CELLPADDING=4>";
  print "<tr>";
  print '<td BGCOLOR="#C0C0C0", align="center">Product Code</td>';
  print '<td BGCOLOR="#C0C0C0", align="center">Description</td>';
  print '<td BGCOLOR="#C0C0C0", align="center">Notes</td>';
  print '<td BGCOLOR="#C0C0C0", align="center">Category</td>';
  print '<td BGCOLOR="#C0C0C0", align="center">Qty</td>';
  print '<td BGCOLOR="#C0C0C0", align="center">Price</td>';
  print '<td BGCOLOR="#C0C0C0", align="center">Cost</td>';
  print '<td BGCOLOR="#C0C0C0", align="center">Available</td>';
  print "</tr>";

  $available = yes_no($result['available']);
  $number_price = money_format("%.2n",$result['price']);
  $number_cost = money_format("%.2n",$result['cost']);

  print "<tr>";
  print '<td align="center">'.$result['product_upc']."</td>";
  print '<td align="center">'.$result['product_desc']."</td>";
  print '<td><textarea readonly rows="4" cols="40">'.$result['product_notes'].'</textarea></td>';
  print '<td align="center">'.$result['category']."</td>";
  print '<td align="center">'.$result['qty']."</td>";
  print '<td align="right">'.$number_price."</td>";
  print '<td align="right">'.$number_cost."</td>";
  print '<td align="center">'.$available."</td>";
  print "</tr>";
  print "</table>";


  print "<br/><br/><br/><br/><br/><br/>";
  #print '<input type="button" value="Delete Product" onclick="return confirm("Are you sure?")">';
  #print '<input type="button" value="Delete Products" onclick="delete_product()">';
  #print '<input type="submit" name="submit" value="Delete Product">';

  #print '<input type="button" name="confirm" id="confirm"  onClick="return confirm("do you really want this")" value="Delete Product">';
  echo'<td class="style2"><a href="pos_inv_del_product.php?id='.$product_id.'"onclick="javascript:return confirm(\'Are you sure you want to delete this product?\')">Confirm Delete</a>';"</td></tr>";


}
catch(PDOException $e)
{
  echo 'Exception : '.$e->getMessage();
  echo "<br/>";
  $db = NULL;
}

}
?>
