<?php require_once("header.php"); ?>
    <h1>Years of Experience</h1>
<table class="table table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Years of Experience</th>
      <th>Institutions Worked At</th>
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
      $sqlAdd = "insert into experience (instructor_id, num_institutions, num_years) values (?,?,?)";
      $stmtAdd = $conn->prepare($sqlAdd);
      $stmtAdd->bind_param("iii", $_POST['instructor_id'], $_POST['num_institutions'], $_POST['num_years']);
      $stmtAdd->execute();
      echo '<div class="alert alert-success" role="alert">New experience added.</div>';
      break;
    case 'Edit':
      $sqlEdit = "update experience set instructor_id=?, num_institutions=?, num_years=? where exp_id=?";
      $stmtEdit = $conn->prepare($sqlEdit);
      $stmtEdit->bind_param("iiii", $_POST['instructor_id'], $_POST['num_institutions'], $_POST['num_years'], $_POST['exp_id']);
      $stmtEdit->execute();
      echo '<div class="alert alert-success" role="alert">Experience edited.</div>';
      break;
    case 'Delete':
      $sqlDelete = "delete from experience where exp_id=?";
      $stmtDelete = $conn->prepare($sqlDelete);
      $stmtDelete->bind_param("i", $_POST['exp_id']);
      $stmtDelete->execute();
      echo '<div class="alert alert-success" role="alert">Experience deleted.</div>';
      break;
  }
}
$sql = "SELECT e.*,i.instructor_id, i.instructor_name from experience e join instructor i on e.instructor_id=i.instructor_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
?>
  <tr>
    <td><?=$row["instructor_id"]?></td>
    <td><?=$row["instructor_name"]?></td>
    <td><?=$row["num_years"]?></td>
    <td><?=$row["num_institutions"]?></td>
    <td>
      <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#editExp<?=$row['exp_id']?>">
        Edit
      </button>
<!--- Edit Modal --->
      <div class="modal fade" id="editCourse<?=$row["exp_id"]?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editExp<?=$row["exp_id"]?>Label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="editExp<?=$row["exp_id"]?>Label">Edit Experience</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <div class="mb-3">
                <label for="editExp<?=$row["exp_id"]?>instructor_id" class="form-label">Instructor ID</label>
                <input type="text" class="form-control" id="editExp<?=$row["exp_id"]?>instructor_id" aria-describedby="editExp<?=$row["exp_id"]?>Help" name="instructor_id" value="<?=$row["instructor_id"]?>">
                <label for="editExp<?=$row["exp_id"]?>num_institutions" class="form-label">Number of institutions worked at:</label>
                <input type="text" class="form-control" id="editExp<?=$row["exp_id"]?>num_institutions" aria-describedby="editExp<?=$row["exp_id"]?>Help" name="num_institutions" value="<?=$row["num_institutions"]?>">
                <label for="editExp<?=$row["exp_id"]?>num_years" class="form-label">Number of total years worked</label>
                <input type="text" class="form-control" id="editExp<?=$row["exp_id"]?>num_years" aria-describedby="editExp<?=$row["exp_id"]?>Help" name="num_years" value="<?=$row["num_years"]?>">
                <input type="hidden" name="exp_id" value="<?=$row["exp_id"]?>">
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
         <input type="hidden" name="experience_id" value="<?=$row["exp_id"]?>" />
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
    <br />
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExp">
        Add New
      </button>

      <!-- Modal -->
      <div class="modal fade" id="addExp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addExpLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="addExpLabel">Add Experience</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <div class="mb-3">
                  <label for="expinstructor_id" class="form-label">Instructor ID</label>
                  <input type="text" class="form-control" id="expinstructor_id" aria-describedby="instructor_idHelp" name="instructor_id">
                  <div id="instructor_idHelp" class="form-text">Enter the Instructor ID:</div>
                </div>
                <input type="hidden" name="saveType" value="Add">
              </form>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <div class="mb-3">
                  <label for="expnum_institutions" class="form-label">Number of institutions worked at</label>
                  <input type="text" class="form-control" id="expnum_institutions" aria-describedby="num_institutionsHelp" name="num_institutions">
                  <div id="num_institutionsHelp" class="form-text">Enter the number of institutions</div>
                </div>
                <input type="hidden" name="saveType" value="Add">
              </form>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <div class="mb-3">
                  <label for="expnum_years" class="form-label">Number of total years worked</label>
                  <input type="text" class="form-control" id="expnum_years" aria-describedby="num_yearsHelp" name="num_years">
                  <div id="num_yearsHelp" class="form-text">Enter the number of years</div>
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
