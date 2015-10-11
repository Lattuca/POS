<!doctype html>
<?php
require('mlib_functions.php');
html_head("mlib skeleton");
require('mlib_header.php');
require('mlib_sidebar.php');

# Code for your web page follows.
if (!isset($_POST['submit']))
{
?>
  <!-- Display a form to capture information -->
  <h2>Your Title</h2>
  <form action="mlib_skeleton.php" method="post">
    <table border="0">
      <tr bgcolor="#cccccc">
        <td width="100">Field</td>
        <td width="300">Value</td>
      </tr>
      <tr>
        <td>Your Field</td>
        <td align="left"><input type="text" name="yourfield" size="35" maxlength="35"></td>
      </tr>
      <tr>
        <td colspan="2" align="right"><input type="submit" name="submit" value="Submit"></td>
      </tr>
    </table>
  </form>
<?php
} else {
  # Process the information from the form displayed
  $yourfield = $_POST['yourfield'];

  print "<h2>You Entered</h2>";
  print "<table border=1>";
  print "<tr>";
  print "<td>Your Field</td>";
  print "</tr>";
  print "<tr>";
  print "<td>".$yourfield."</td>";
  print "</tr>";
  print "</table>";
}
require('mlib_footer.php');
?>
