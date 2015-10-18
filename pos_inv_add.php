<!doctype html>
<?php
require('pos_functions.php');
html_head("Add Inventory");
require('pos_header.php');
require('pos_sidebar.php');
require('pos_values.php');

# POS Project
# Code for your web page follows.

if (!isset($_POST['submit']))
{
?>
  <!-- Display a form to capture information -->
  <h2>Add Inventory</h2>
  <form action="pos_inv_add.php" method="post">
    <table border="0">
      <tr bgcolor="#cccccc">
        <td width="100">Field</td>
        <td width="300">Value</td>
      </tr>
      <tr>
        <td>Product UPC</td>
        <td align="left"><input type="text" name="product_upc" size="35" maxlength="35"></td>
      </tr>
      <tr>
        <td>Description</td>
        <td align="left"><input type="text" name="product_desc" size="35" maxlength="35"></td>
      </tr>
      <tr>
        <td>Notes</td>
        <td> <textarea name="product_notes" rows="4" cols="80"></textarea> </td>

      </tr>
      <tr>
        <td>Quantity on Hand</td>
        <td align="left"><input type="integer" name="qty" value="<?php print 0;?>" size="5" maxlength="5"></td>
      </tr>
      <tr>
        <td>Price</td>
        <td align="left"><input type="float" name="price" value="<?php print money_format('%.2n', 0);?>" size="10" maxlength="5"></td>
      </tr>
      <tr>
        <td>Cost</td>
       <td align="left"><input type="float" name="cost" value="<?php print money_format('%.2n', 0);?>" size="10" maxlength="5"></td>
      </tr>
      <tr>
        <td>Available</td>
          <td align="left"><input type="checkbox" name="available" value = "1" checked> </td>
      </tr>
      <tr>
        <td>Category</td>
        <td align="left">
           <select name='category'>
               <option value='Consumable'>Consumable
               <option value='Durable'>Durable
               <option value='Electronics'>Electonics
               <option value='Food'>Food
               <option value='Other'>Other
          </select>
        </td>
    </tr>

    <tr>
        <td colspan="2" align="right"><input type="submit" name="submit" value="Submit"></td>
    </tr>

    </table>
  </form>
<?php
} else {

  # Process the information from the form displayed
  $product_upc = $_POST['product_upc'];
  $product_desc = $_POST['product_desc'];
  $product_notes = $_POST['product_notes'];
  $qty = $_POST['qty'];
  $price = $_POST['price'];
  $cost = $_POST['cost'];
  #$available = $_POST['available'];
  $available = isset($_POST['available']) && $_POST['available']  ? "1" : "0";
  $category = $_POST['category'];


  //clean up and validate data

  $product_upc = trim($product_upc);
  if ( empty($product_upc) ) {
    try_again("Product UPC field must be entered.");
  }
  $product_desc = trim($product_desc);
  if ( empty($product_desc) ) {
    try_again("Product Description field must have a description.");
  }
  if ( $qty <0 ) {
    try_again("Qty field cannot be negative.");
  }
  if ( $price < 0 ) {
    try_again("Price field cannot be negative.");
  }
  if ( $cost < 0 ) {
    try_again("Cost field cannot be negative.");
  }
  try
  {
    //open the database
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo '$product_upc';
    //check for duplicate title name
    $sql = "SELECT COUNT(*) FROM inventories WHERE product_upc = '$product_upc'";
    $result = $db->query($sql)->fetch(); //count the number of entries with the tool name
    if ( $result[0] > 0) {
      try_again($product_upc." is not unique. Product UPC must be unique.");
    }

    //insert product data...
    $db->exec("INSERT INTO inventories (product_upc, product_desc, product_notes, category, qty, price, cost, available)
                                VALUES ('$product_upc', '$product_desc', '$product_notes', '$category', '$qty', '$price','$cost', '$available');");

    //get the last id value inserted into the table
    $last_id = $db->lastInsertId();

    //now output the data from the insert to a simple html table...
    print "<h2>Product Added</h2>";
    #print "<table border=1>";
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

    #print "<tr>";
    #print "<td>Product UPC</td><td>Description</td><td>Notes</td><td>Category</td><td>Qty</td><td>Price</td><td>Cost</td><td>Available</td>";
    #print "</tr>";

    // get inserted record
    $row = $db->query("SELECT * FROM inventories where id = '$last_id'")->fetch(PDO::FETCH_ASSOC);

    // output inserted record
    $available = yes_no($row['available']);
    #setlocale(LC_MONETARY, 'en_US.UTF-8'); # show currency in USD
    $number_price = money_format("%.2n",$row['price']);
    $number_cost = money_format("%.2n",$row['cost']);

    print "<tr>";
      print '<td align="center">'.$row['product_upc']."</td>";
      print '<td align="center">'.$row['product_desc']."</td>";
      print "<td>".$row['product_notes']."</td>";
      print '<td align="center">'.$row['category']."</td>";
      print '<td align="center">'.$row['qty']."</td>";
      print '<td align="right">'.$number_price."</td>";
      print '<td align="right">'.$number_cost."</td>";
      print '<td align="center">'.$available."</td>";
    print "</tr>";
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
}
require('pos_footer.php');
?>
