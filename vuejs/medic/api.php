<?php
$conn = new mysqli( 'localhost', 'root', '', 'bdfarmacia' );

if ( $conn->connect_error ) {
  die( 'Error al conectarse a la base de datos' );
}

$res = array( 'error' => false );

$action = 'read';

if ( isset( $_GET['action'] ) ) {
  $action = $_GET['action'];
}

if ( $action == 'read' ) {
  $result = $conn->query( "SELECT idmedicamnto, mnombre, descripcion, fechaexp, nombre, medicamento.idlaboratorio FROM medicamento, laboratorio WHERE medicamento.idlaboratorio=laboratorio.idlaboratorio" );
  $students = array();

  while ( $row = $result->fetch_assoc() ) {
    array_push( $students, $row );
  }

  $res['students'] = $students;  
}

if ( $action == 'create' ) {
  $idmedicamnto = $_POST['idmedicamnto'];
  $mnombre = $_POST['mnombre'];
  $descripcion = $_POST['descripcion'];
  $fechaexp = $_POST['fechaexp'];
  $idlaboratorio = $_POST['idlaboratorio'];

  $result = $conn->query( "INSERT INTO `medicamento`(`idmedicamnto`, `mnombre`, `descripcion`, `fechaexp`, `idlaboratorio`) VALUES ('$idmedicamnto', '$mnombre', '$descripcion', '$fechaexp', '$idlaboratorio')" );
  
  if ( $result ) {
    $res['message'] = 'Cliente agregado con éxito.';
  } else {
    $res['error'] = true;
    $res['message'] = "Cliente al tratar de agregar estudiante.";
  }
}

if ( $action == 'update' ) {
  $idmedicamnto = $_POST['idmedicamnto'];
  $idnew = $_POST['idnew'];
  $mnombre = $_POST['mnombre'];
  $descripcion = $_POST['descripcion'];
  $fechaexp = $_POST['fechaexp'];
  $idlaboratorio = $_POST['idlaboratorio'];
 
  $result = $conn->query( "UPDATE `medicamento` SET `idmedicamnto`='$idnew', `mnombre`='$mnombre', `descripcion`='$descripcion', `fechaexp`='$fechaexp', `idlaboratorio`='$idlaboratorio' WHERE `idmedicamnto`='$idmedicamnto'" );
  
  if ( $result ) {
    $res['message'] = 'Estudiante actualizado con éxito.';
  } else {
    $res['error'] = true;
    $res['message'] = "Error al tratar de actualizar estudiante.";
  }
}

if ( $action == 'delete' ) {
  $idmedicamnto = $_POST['idmedicamnto'];

  $result = $conn->query( "DELETE FROM medicamento WHERE idmedicamnto = $idmedicamnto" );
  
  if ( $result ) {
    $res['message'] = 'Estudiante eliminado con éxito.';
  } else{
    $res['error'] = true;
    $res['message'] = "Error al tratar de eliminar estudiante.";
  }
}

$conn->close();

header( 'Content-type: application/json' );
echo json_encode($res);