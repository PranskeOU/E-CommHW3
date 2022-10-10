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
$iName = $_POST['iName'];

$sql = "update instructor set instructor_name=? where instructor_id=?";
//echo $sql;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $iName, $_POST['iid']);
    $stmt->execute();
?>
    
    <h1>Edit Instructor</h1>
<div class="alert alert-success" role="alert">
  Instructor edited.
</div>
    <a href="instructors.php" class="btn btn-primary">Go back</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
