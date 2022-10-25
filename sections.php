<?php require_once("header.php"); ?>
    <h1>Sections</h1>
<table class="table table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Prefix</th>
      <th>Number</th>
      <th>Section</th>
      <th>Instructor</th>
      <th></th>
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
      
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  switch ($_POST['saveType']) {
    case 'Add':
      $sqlAdd = "insert into section (course_id, instructor_id) values (?,?)";
      $stmtAdd = $conn->prepare($sqlAdd);
      $stmtAdd->bind_param("ii", $_POST['course_id'], $_POST['instructor_id']);
      $stmtAdd->execute();
      echo '<div class="alert alert-success" role="alert">New section added.</div>';
      break;
    case 'Edit':
      $sqlEdit = "update section set course_id=?, instructor_id=? where section_id=?";
      $stmtEdit = $conn->prepare($sqlEdit);
      $stmtEdit->bind_param("iii", $_POST['course_id'], $_POST['instructor_id'], $_POST['section_id']);
      $stmtEdit->execute();
      echo '<div class="alert alert-success" role="alert">Section edited.</div>';
      break;
    case 'Delete':
      $sqlDelete = "delete from course where course_id=?";
      $stmtDelete = $conn->prepare($sqlDelete);
      $stmtDelete->bind_param("i", $_POST['section_id']);
      $stmtDelete->execute();
      echo '<div class="alert alert-success" role="alert">Course deleted.</div>';
      break;
  }
}


$sql = "select section_id, i.instructor_name, c.prefix, c.number from section s join instructor i on i.instructor_id = s.instructor_id join course c on c.course_id = s.course_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
?>
  <tr>
    <td><?=$row["section_id"]?></td>
    <td><?=$row["prefix"]?></td>
    <td><?=$row["number"]?></td>
    <td>00<?=$row["section_id"]?></td>
    <td><?=$row["instructor_name"]?></td>
   <td>
      <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#editSection">
        Edit
      </button>
      </td>
    <td>
      <form class="btn btn-light" method="post" action="">
         <input type="hidden" name="course_id" value="<?=$row["section_id"]?>" />
         <input type="hidden" name="saveType" value="Delete">
         <input type="submit" class="btn" onclick="return confirm('Are you sure?')" value="Delete">
       </form>
    </td>
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
<div class="modal fade" id="editSection" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editSectionLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="editSectionLabel">Edit Section</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <div class="mb-3">
                  <label for="scourse_id" class="form-label">New Course ID</label>
                  <input type="text" class="form-control" id="scourse_id" aria-describedby="scourse_idHelp" name="scourse_id">
                  <div id="scourse_idHelp" class="form-text">Enter the course ID</div>
                </div>
                <input type="hidden" name="saveType" value="Edit">
              </form>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <div class="mb-3">
                  <label for="sinstructor_id" class="form-label">New Instructor ID</label>
                  <input type="text" class="form-control" id="scourse_id" aria-describedby="sinstructor_idHelp" name="sinstructor_id">
                  <div id="sinstructor_idHelp" class="form-text">Enter the instructor ID</div>
                </div>
                <input type="hidden" name="saveType" value="Edit">
              </form>
            </div>
                <input type="hidden" name="saveType" value="Edit">
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
