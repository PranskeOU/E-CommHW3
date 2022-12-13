<?php require_once("header.php"); ?>
<table class="table table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Years of Experience</th>
    </tr>
  </thead>
  <tbody>
    <?php
$servername = "localhost:3306";
$username = "pranskeo_homework3";
$password = "iAYlcs$15a!4";
$dbname = "pranskeo_homework3";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT i.instructor_id, i.instructor_name, num_years from instructor i join experience e on i.instructor_id = e.instructor_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
?>
  <tr>
    <td><?=$row["instructor_id"]?></td>
    <td><?=$row["instructor_name"]?></td>
    <td><?=$row["num_years"]?></td>
  </tr>
<?php
  }
} else {
  echo "0 results";
}
$conn->close();
?>
      </tbody>
    </table>
  </body>
</html>
