<!doctype html>
<?php
require('pos_functions.php');
html_head("POS Update User");
require('pos_header.php');
require('pos_usr_sidebar.php');
require('pos_values.php');

# Point Of Sale Project

# Get the Users by user id
if (!isset($_POST['submit']))
{
  $user_id =$_GET['id'];
  echo "record id is: ".$user_id;
  print "<h2>POS User Update</h2>";

  try
  {
    //open the database and find product
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //check for duplicate on any product upc

    $query = "SELECT * from users WHERE users.id = $user_id";
    $result = $db->query($query)->fetch(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e)
  {
    echo 'Exception : '.$e->getMessage();
    echo "<br/>";
    $db = NULL;
  }

?>
  <form action="pos_usr_update.php" method="post">
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
        <td>First</td>
        <td align="left"><input type="text" name="first" value= <?php print "$result[first]";?> size="30" maxlength="30"></td>
      </tr>
      <tr>
        <td>Last</td>
        <td align="left"><input type="text" name="last" value= <?php print "$result[last]";?> size="30" maxlength="30"></td>
      </tr>
      <tr>
        <td>Email</td>
        <td align="left"><input type="text" name="email" value= <?php print "$result[email]";?> size="30" maxlength="30"></td>
      </tr>
      <tr>
        <td>Password</td>
        <td align="left"><input type="text" name="password" value=<?php print "$result[password]";?> size="32" maxlength="32"></td>
      </tr>

      <tr>
          <input type="hidden" name="id" value="<?php echo $user_id; ?>">
          <td colspan="2" align="right"><input type="submit" name="submit" value="Update User"></td>
      </tr>
    </table>
  </form>
<?php
} else{
  # Process the information from the form displayed

  $user_id =$_POST['id'];
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

    //update User data...
    $sql_query = "UPDATE users
                  SET
                    first = '$first',
                    last = '$last',
                    email = '$email',
                    password = '$password'
                  WHERE id = $user_id;";
    $db->exec($sql_query);

    //now output the data from the insert to a simple html table...
    print "<h2>User Updated</h2>";
    print "<table border=4  CELLSPACING=4 CELLPADDING=4>";
    print "<tr>";
    print '<td BGCOLOR="#C0C0C0", align="center">Id</td>';
    print '<td BGCOLOR="#C0C0C0", align="center">First</td>';
    print '<td BGCOLOR="#C0C0C0", align="center">Last</td>';
    print '<td BGCOLOR="#C0C0C0", align="center">Email</td>';
    print '<td BGCOLOR="#C0C0C0", align="center">Password</td>';
    print "</tr>";

    // get updated record
    $result = $db->query("SELECT * FROM users where id = '$user_id'")->fetch(PDO::FETCH_ASSOC);

    // output inserted record


    // display table
    print "<tr>";
    print '<td align="center">'.$result['id']."</td>";
    print '<td align="left">'.$result['first']."</td>";
    print '<td align="left">'.$result['last']."</td>";
    print '<td align="center">'.$result['email']."</td>";
    print '<td align="center">'.$result['password']."</td>";
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
