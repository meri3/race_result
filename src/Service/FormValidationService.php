<!DOCTYPE HTML>  
<html>
<head>
</head>
<body>  


<?php
// define variables and set to empty values
$name = $date = $csv_file = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["inputRaceName1"]);
  $date = test_input($_POST["inputDate1"]);
  $csv_fike = test_input($_POST["csv_file"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>


<?php
// echo "<h2>Your Input:</h2>";
echo $name;
echo "<br>";
echo $email;
echo "<br>";
echo $website;
echo "<br>";
echo $comment;
echo "<br>";
echo $gender;
?>

</body>
</html>