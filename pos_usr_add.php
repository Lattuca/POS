<!doctype html>
<?php
require('pos_functions.php');
html_head("Add User");
require('pos_header.php');
require('pos_usr_sidebar.php');
require('pos_values.php');

# POS Project add user functionality
# Code for your web page follows

if (!isset($_POST['submit']))
{
?>
  <!-- Display a form to capture information -->
  <h2>Add User</h2>
  <form action="pos_usr_add.php" method="post">
    <table border="0">
      <tr bgcolor="#cccccc">
        <td width="100">Field</td>
        <td width="300">Value</td>
      </tr>
      <tr>
        <td>First</td>
        <td align="left"><input type="text" name="first" size="20" maxlength="20"></td>
      </tr>
      <tr>
        <td>Last</td>
        <td align="left"><input type="text" name="last" size="20" maxlength="20"></td>
      </tr>
      <tr>
        <td>Email</td>
        <td align="left"><input type="text" name="email" size="32" maxlength="32"></td>
      </tr>
      <tr>
        <td>Password</td>
        <td align="left"><input type="text" name="password" size="20" maxlength="20"></td>
      </tr>

    <tr>
        <td colspan="2" align="center"><input type="submit" name="submit" value="Add User"></td>
    </tr>

    </table>
  </form>
<?php
} else {

  # Process the information from the form displayed
  $first = $_POST['first'];
  $last = $_POST['last'];
  $email = $_POST['email'];
  $password = $_POST['password'];
    //clean up and validate data

  $first = trim($first);
  if ( empty($first )) {
    try_again("First Name field must be entered.");
  }
  $last = trim($last);
  if ( empty($last) ) {
    try_again("Last name field must be entered.");
  }
  $email = trim($email);
  if ( empty($email) ) {
    try_again("Email field must be entered.");
  }
  $password = trim($password);
  if ( empty($password) ) {
    try_again("Password field must be entered.");
  }

  try
  {
    //open the database
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "$last";

    //insert product data...
    $db->exec("INSERT INTO users (first, last, email, password)
                                VALUES ('$first', '$last', '$email', '$password');");

    //get the last id value inserted into the table
    $last_id = $db->lastInsertId();

    //now output the data from the insert to a simple html table...
    print "<h2>User Added</h2>";
    print "<table border=4  CELLSPACING=4 CELLPADDING=4>";
    print "<tr>";
    print '<td BGCOLOR="#C0C0C0", align="center">Id</td>';
    print '<td BGCOLOR="#C0C0C0", align="center">First</td>';
    print '<td BGCOLOR="#C0C0C0", align="center">Last</td>';
    print '<td BGCOLOR="#C0C0C0", align="center">Email</td>';
    print '<td BGCOLOR="#C0C0C0", align="center">Password</td>';
    print "</tr>";

    // get inserted record
    $row = $db->query("SELECT * FROM users where id = '$last_id'")->fetch(PDO::FETCH_ASSOC);

    // output inserted record
    print "<tr>";
    print '<td align="center">'.$row['id']."</td>";
    print '<td align="left">'.$row['first']."</td>";
    print '<td align="left">'.$row['last']."</td>";
    print '<td align="center">'.$row['email']."</td>";
    print '<td align="center">'.$row['password']."</td>";
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
