<!doctype html>
<?php
require('pos_functions.php');
html_head("Add Customer");
require('pos_header.php');
require('pos_cust_sidebar.php');
require('pos_values.php');
require('state_drop_down.php');

# POS Project add user functionality
# Code for your web page follows

if (!isset($_POST['submit']))
{
?>
  <!-- Display a form to capture information -->
  <h2>Add Customer</h2>
  <form action="pos_cust_add.php" method="post">
    <table border="0">
      <tr bgcolor="#cccccc">
        <td width="100">Field</td>
        <td width="300">Value</td>
      </tr>
      <tr>
        <td>Name</td>
        <td align="left"><input type="text" name="name" size="40" maxlength="40"></td>
      </tr>
      <tr>
        <td>Phone</td>
        <td align="left"><input type="text" name="phone" size="14" maxlength="14"></td>
      </tr>
      <tr>
        <td>Email</td>
        <td align="left"><input type="text" name="email" size="32" maxlength="32"></td>
      </tr>
      <tr>
        <td>State Code</td>
        <td align="left">
             <select name="state_code"><?php echo StateDropdown('CA', 'abbrev'); ?></select>
        </td>
      </tr>

    <tr>
        <td colspan="2" align="center"><input type="submit" name="submit" value="Add Customer"></td>
    </tr>

    </table>
  </form>
<?php
} else {

  # Process the information from the form displayed
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $state_code = $_POST['state_code'];
    //clean up and validate data

  if ( empty($name )) {
    try_again("Customer Name field must be entered.");
  }
  $phone = trim($phone);
  if ( empty($phone) ) {
    try_again("Phone number field must be entered.");
  }
  $email = trim($email);
  if ( empty($email) ) {
    try_again("Email field must be entered.");
  }
  $state_code = trim($state_code);
  if ( empty($state_code) ) {
    try_again("State code field must be entered.");
  }

  try
  {
    //open the database
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "$name";

    //insert product data...
    $db->exec("INSERT INTO customers (name, phone, email, state_code)
                                VALUES ('$name', '$phone', '$email', '$state_code');");

    //get the last id value inserted into the table
    $last_id = $db->lastInsertId();

    //now output the data from the insert to a simple html table...
    print "<h2>Customer Added</h2>";
    print "<table border=4  CELLSPACING=4 CELLPADDING=4>";
    print "<tr>";
    print '<td BGCOLOR="#C0C0C0", align="center">Id</td>';
    print '<td BGCOLOR="#C0C0C0", align="center">Name</td>';
    print '<td BGCOLOR="#C0C0C0", align="center">Phone</td>';
    print '<td BGCOLOR="#C0C0C0", align="center">Email</td>';
    print '<td BGCOLOR="#C0C0C0", align="center">State Code</td>';
    print "</tr>";

    // get inserted record
    $row = $db->query("SELECT * FROM customers where id = '$last_id'")->fetch(PDO::FETCH_ASSOC);

    // output inserted record
    print "<tr>";
    print '<td align="center">'.$row['id']."</td>";
    print '<td align="left">'.$row['name']."</td>";
    print '<td align="left">'.$row['phone']."</td>";
    print '<td align="center">'.$row['email']."</td>";
    print '<td align="center">'.$row['state_code']."</td>";
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
