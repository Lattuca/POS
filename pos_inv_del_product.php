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

    $query = "DELETE FROM inventories WHERE inventories.id = $product_id";
    $result = $db->query($query);
    print "Product Deleted............................<br/>";
  }
  catch(PDOException $e)
  {
    echo 'Exception : '.$e->getMessage();
    echo "<br/>";
    $db = NULL;
  }

}
?>
