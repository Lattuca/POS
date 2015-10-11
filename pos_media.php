<!doctype html>
<?php
require('mlib_functions.php');
html_head("Add Media");
require('mlib_header.php');
require('mlib_sidebar.php');
require('mlib_values.php');

#mlib assignment 7
# Code for your web page follows.

if (!isset($_POST['submit']))
{
?>
  <!-- Display a form to capture information -->
  <h2>Add Media</h2>
  <form action="mlib_media.php" method="post">
    <table border="0">
      <tr bgcolor="#cccccc">
        <td width="100">Field</td>
        <td width="300">Value</td>
      </tr>
      <tr>
        <td>Title</td>
        <td align="left"><input type="text" name="title" size="35" maxlength="35"></td>
      </tr>
      <tr>
        <td>Author</td>
        <td align="left"><input type="text" name="author" size="35" maxlength="35"></td>
      </tr>
      <tr>
        <td>Description</td>
        <td align="left"><input type="text" name="description" size="35" maxlength="35"></td>
      </tr>
      <tr>
        <td>Type</td>
        <td align="left">
                  <select name="type">
                    <?php
                    // Replace text field with a select pull down menu.
                    try
                    {
                      //open the database
                      $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
                      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                      //display all types in the types table
                      $result = $db->query('SELECT * FROM mlib_types');
                      foreach($result as $row)
                      {
                        print "<option value=".$row['type'].">".$row['type']."</option>";
                      }

                      // close the database connection
                      $db = NULL;
                    }

                    catch(PDOException $e)
                    {
                      echo 'Exception : '.$e->getMessage();
                      echo "<br/>";
                      $db = NULL;
                    }
                  ?>
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
  $title = $_POST['title'];
  $author = $_POST['author'];
  $description = $_POST['description'];
  $type = $_POST['type'];

  //clean up and validate data

  $title = trim($title);
  if ( empty($title) ) {
    try_again("Title field must have a title type.");
  }
  $author = trim($author);
  if ( empty($author) ) {
    try_again("Author field must have a author name.");
  }
  $description = trim($description);
  if ( empty($description) ) {
    try_again("Description field must have a media description.");
  }
  $type = trim($type);
  if ( empty($type) ) {
    try_again("Type field must have a type type.");
  }

  try
  {
    //open the database
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //check for duplicate title name
    $sql = "SELECT COUNT(*) FROM media WHERE title = '$title' AND status = 'active'";
    $result = $db->query($sql)->fetch(); //count the number of entries with the tool name
    if ( $result[0] > 0) {
      try_again($title." is not unique. Title names must be unique.");
    }

    //insert data...
    $db->exec("INSERT INTO media (title, author, description, type, user_id, status) VALUES ('$title', '$author', '$description', '$type', 0,'active');");

    //get the last id value inserted into the table
    $last_id = $db->lastInsertId();

    //now output the data from the insert to a simple html table...
    print "<h2>Media Added</h2>";
    print "<table border=1>";
    print "<tr>";
    print "<td>Id</td><td>Title</td><td>Author</td><td>Description</td><td>Type</td><td>User id</td><td>Status</td>";
    print "</tr>";

    // get inserted record
    $row = $db->query("SELECT * FROM media where id = '$last_id'")->fetch(PDO::FETCH_ASSOC);

    // output inserted record
    print "<tr>";
    print "<td>".$row['id']."</td>";
    print "<td>".$row['title']."</td>";
    print "<td>".$row['author']."</td>";
    print "<td>".$row['description']."</td>";
    print "<td>".$row['type']."</td>";
    print "<td>".$row['user_id']."</td>";
    print "<td>".$row['status']."</td>";
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
require('mlib_footer.php');
?>
