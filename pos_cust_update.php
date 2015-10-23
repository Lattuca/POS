<!doctype html>
<?php
require('pos_functions.php');
html_head("POS Update Customer");
require('pos_header.php');
require('pos_cust_sidebar.php');
require('pos_values.php');
require('state_drop_down.php');

# Point Of Sale Project

# Get the customers by customer id
if (!isset($_POST['submit']))
{
  $customer_id =$_GET['id'];
  echo "record id is: ".$customer_id;
  print "<h2>POS Customer Update</h2>";

  try
  {
    //open the database and find product
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //check for duplicate on any product upc

    $query = "SELECT * from customers WHERE customers.id = $customer_id";
    $result = $db->query($query)->fetch(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e)
  {
    echo 'Exception : '.$e->getMessage();
    echo "<br/>";
    $db = NULL;
  }

?>
  <form action="pos_cust_update.php" method="post">
    <table border="0">
      <tr bgcolor="#cccccc">
        <td width="150">Field</td>
        <td width="300">Value</td>
      </tr>
      <tr>
        <td>Id</td>
        <td align="left"><input type="text" readonly name="id" value= <?php print "$result[id]";?> size="6" maxlength="6"></td>
      </tr>
      <tr>
        <td>Name</td>
        <td align="left"><input type="text" name="name" value= <?php print "$result[name]";?> size="30" maxlength="30"></td>
      </tr>
      <tr>
        <td>Phone</td>
        <td align="left"><input type="text" name="phone" value= <?php print "$result[phone]";?> size="30" maxlength="30"></td>
      </tr>
      <tr>
        <td>Email</td>
        <td align="left"><input type="text" name="email" value= <?php print "$result[email]";?> size="30" maxlength="30"></td>
      </tr>
      <tr>
        <td>State Code</td>
        <td align="left">
             <select name="state_code"><?php echo StateDropdown("$result[state_code]", 'abbrev'); ?></select>
        </td>
      </tr>
      <tr>
          <input type="hidden" name="id" value="<?php echo $customer_id; ?>">
          <td colspan="2" align="right"><input type="submit" name="submit" value="Update Customer"></td>
      </tr>
    </table>
  </form>
<?php
} else {
  # Process the information from the form displayed

  $customer_id =$_POST['id'];
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
    try_again("State Code field must be entered and valid.");
  }

  try
  {
    //open the database
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //update User data...
    $sql_query = "UPDATE customers
                  SET
                    name = '$name',
                    phone = '$phone',
                    email = '$email',
                    state_code = '$state_code'
                  WHERE id = $customer_id;";
    $db->exec($sql_query);

    //now output the data from the insert to a simple html table...
    print "<h2>Customer Updated</h2>";
    print "<table border=4  CELLSPACING=4 CELLPADDING=4>";
    print "<tr>";
    print '<td BGCOLOR="#C0C0C0", align="center">Id</td>';
    print '<td BGCOLOR="#C0C0C0", align="center">Name</td>';
    print '<td BGCOLOR="#C0C0C0", align="center">Phone</td>';
    print '<td BGCOLOR="#C0C0C0", align="center">Email</td>';
    print '<td BGCOLOR="#C0C0C0", align="center">State Code</td>';
    print "</tr>";

    // get updated record
    $result = $db->query("SELECT * FROM customers where id = '$customer_id'")->fetch(PDO::FETCH_ASSOC);

    // output inserted record


    // display table
    print "<tr>";
    print '<td align="center">'.$result['id']."</td>";
    print '<td align="center">'.$result['name']."</td>";
    print '<td align="left">'.$result['phone']."</td>";
    print '<td align="left">'.$result['email']."</td>";
    print '<td align="center">'.$result['state_code']."</td>";
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
require('pos_footer.php');
}
?>
