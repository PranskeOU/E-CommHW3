<?php require_once("header.php"); ?>
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
      $sqlAdd = "insert into course (prefix, number, description) values (?,?,?)";
      $stmtAdd = $conn->prepare($sqlAdd);
      $stmtAdd->bind_param("sis", $_POST['Prefix'], $_POST['Number'], $_POST['Description']);
      $stmtAdd->execute();
      echo '<div class="alert alert-success" role="alert">New course added.</div>';
      break;
    case 'Edit':
      $sqlEdit = "update course set prefix=?, number=?, description=? where course_id=?";
      $stmtEdit = $conn->prepare($sqlEdit);
      $stmtEdit->bind_param("sisi", $_POST['Prefix'], $_POST['Number'], $_POST['Description'], $_POST['course_id']);
      $stmtEdit->execute();
      echo '<div class="alert alert-success" role="alert">Course edited.</div>';
      break;
    case 'Delete':
      $sqlDelete = "delete from course where course_id=?";
      $stmtDelete = $conn->prepare($sqlDelete);
      $stmtDelete->bind_param("i", $_POST['course_id']);
      $stmtDelete->execute();
      echo '<div class="alert alert-success" role="alert">Course deleted.</div>';
      break;
  }
}
?>
    <h1>Courses</h1>
<table class="table table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Prefix</th>
      <th>Number</th>
      <th>Description</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
<?php
      
$sql = "SELECT * from course";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
?>
  <tr>
    <td><?=$row["course_id"]?></td>
    <td><?=$row["prefix"]?></td>
    <td><?=$row["number"]?></td>
    <td><?=$row["description"]?></td>
      <td>
      <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#editCourse<?=$row['course_id']?>">
        Edit
      </button>
<!--- Edit Modal --->
      <div class="modal fade" id="editCourse<?=$row["course_id"]?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCourse<?=$row["course_id"]?>Label">" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="editCourse<?=$row["course_id"]?>Label">Edit Course</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <div class="mb-3">
                <label for="editCourse<?=$row["course_id"]?>Prefix" class="form-label">Course Prefix</label>
                <input type="text" class="form-control" id="editCourse<?=$row["course_id"]?>Prefix" aria-describedby="editCourse<?=$row["course_id"]?>Help" name="Prefix" value="<?=$row["prefix"]?>">
                <label for="editCourse<?=$row["course_id"]?>Number" class="form-label">Course Number</label>
                <input type="text" class="form-control" id="editCourse<?=$row["course_id"]?>Number" aria-describedby="editCourse<?=$row["course_id"]?>Help" name="Number" value="<?=$row["number"]?>">
                <label for="editCourse<?=$row["course_id"]?>Description" class="form-label">Course Description</label>
                <input type="text" class="form-control" id="editCourse<?=$row["course_id"]?>Description" aria-describedby="editCourse<?=$row["course_id"]?>Help" name="Description" value="<?=$row["description"]?>">
                <input type="hidden" name="course_id" value="<?=$row["course_id"]?>">
                <input type="hidden" name="saveType" value="Edit">
                <br></br>
                <button type="submit" class="btn btn-primary" value="Submit">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      </td>
      <td>
        <form class="btn btn-light" method="post" action="">
           <input type="hidden" name="course_id" value="<?=$row["course_id"]?>" />
           <input type="hidden" name="saveType" value="Delete">
           <input type="submit" class="btn" onclick="return confirm('Are you sure?')" value="Delete">
         </form>
      </td>
      <td>
      <form method="post" action="course-section.php">
        <input type="hidden" name="id" value="<?=$row["course_id"]?>" />
        <input type="submit" value="Sections" />
      </form>
    </td>
    <?php
  }
} else {
  echo "0 results";
}
$conn->close();
?>
  </tr>
  </tbody>
    </table>
    <br />
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourse">
        Add New
      </button>

      <!-- Modal -->
      <div class="modal fade" id="addCourse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCourseLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="addCourseLabel">Add Course</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <div class="mb-3">
                  <label for="coursePrefix" class="form-label">Course Prefix</label>
                  <input type="text" class="form-control" id="coursePrefix" aria-describedby="prefixHelp" name="Prefix">
                  <div id="prefixHelp" class="form-text">Enter the course prefix:</div>
                </div>
                <input type="hidden" name="saveType" value="Add">
              </form>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <div class="mb-3">
                  <label for="CourseNumber" class="form-label">Course Number</label>
                  <input type="text" class="form-control" id="courseNumber" aria-describedby="numberHelp" name="Number">
                  <div id="numberHelp" class="form-text">Enter the course number:</div>
                </div>
                <input type="hidden" name="saveType" value="Add">
              </form>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <div class="mb-3">
                  <label for="CourseDescription" class="form-label">Course Description</label>
                  <input type="text" class="form-control" id="courseDescription" aria-describedby="descriptionHelp" name="Description">
                  <div id="descriptionHelp" class="form-text">Enter the course description:</div>
                </div>
                <input type="hidden" name="saveType" value="Add">
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>