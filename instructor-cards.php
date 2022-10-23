<?php require_once("header.php"); ?>
    <h1>Instructors</h1>
<div class="card-group">
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

$sql = "SELECT instructor_id, instructor_name from instructor";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
?>
   <div class="card">
    <div class="card-body">
      <h5 class="card-title"><?=$row["instructor_name"]?></h5>
      <p class="card-text"><ul>
<?php
    $section_sql = "select c.description from section s join instructor i on i.instructor_id = s.instructor_id join course c on c.course_id = s.course_id where i.instructor_id=" . $row["instructor_id"];
    $section_result = $conn->query($section_sql);
    $exp_sql = "select e.* from experience e join instructor i on i.instructor_id = e.instructor_id where i.instructor_id=" . $row["num_years"];
    $exp_result = $conn->query($exp_sql);
    
    while($section_row = $section_result->fetch_assoc()) {
      echo "<li>" . $section_row["description"] . "</li>";
    }
    while($exp_row = $exp_result->fetch_assoc()) {
      echo "<li>" . $exp_row["num_years"] . "</li>";
    }
?>
      </ul></p>
  </div>
    </div>
<?php
  }
} else {
  echo "0 results";
}
$conn->close();
?>
  </card-group>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
