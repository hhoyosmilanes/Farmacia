<?php
session_start();

$conn = new mysqli( 'localhost', 'root', '', 'bdfarmacia' );

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
$out = array('error' => false);

$username = $_POST['username'];
$password = $_POST['password'];

if($username==''){
  $out['error'] = true;
  $out['message'] = "Username is required";
}
else if($password==''){
  $out['error'] = true;
  $out['message'] = "Password is required";
}
else{
  $sql = "SELECT * FROM `vendedor` WHERE `idvendedor`='$password' AND `nombre`='$username'";
  $query = $conn->query($sql);

  if($query->num_rows>0){
    $row=$query->fetch_array();
    $_SESSION['user']=$row['idvendedor'];
    if ($row['idvendedor'] == 123) {
      $out['location'] = "admin.html";
      $_SESSION['location'] = $out['location'];
    } else {
      $out['location'] = "home.html";
      $_SESSION['location'] = $out['location'];
    }
    $out['message'] = "Login Successful";
  }
  else{
    $out['error'] = true;
    $out['message'] = "Login Failed. User not Found";
  }
}

$conn->close();
 
header("Content-type: application/json");
echo json_encode($out);
die();

?>