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
  $result = $conn->query( "SELECT * FROM cliente" );
  $students = array();

  while ( $row = $result->fetch_assoc() ) {
    array_push( $students, $row );
  }

  $res['students'] = $students;  
}

if ( $action == 'create' ) {
  $idcliente = $_POST['idcliente'];
  $nombre = $_POST['nombre'];
  $telefono = $_POST['telefono'];

  $result = $conn->query( "INSERT INTO cliente (`idcliente`, `nombre`, `telefono`) VALUES ('$idcliente', '$nombre', '$telefono')" );
  
  if ( $result ) {
    $res['message'] = 'Cliente agregado con éxito.';
  } else {
    $res['error'] = true;
    $res['message'] = "Cliente al tratar de agregar estudiante.";
  }
}

if ( $action == 'update' ) {
  $idcliente = $_POST['idcliente'];
  $idnew = $_POST['idnew'];
  $nombre = $_POST['nombre'];
  $telefono = $_POST['telefono'];
 
  $result = $conn->query( "UPDATE cliente SET idcliente = '$idnew', nombre = '$nombre', telefono = '$telefono' WHERE idcliente = $idcliente" );
  
  if ( $result ) {
    $res['message'] = 'Estudiante actualizado con éxito.';
  } else {
    $res['error'] = true;
    $res['message'] = "Error al tratar de actualizar estudiante.";
  }
}

if ( $action == 'delete' ) {
  $idcliente = $_POST['idcliente'];

  $result = $conn->query( "DELETE FROM cliente WHERE idcliente = $idcliente" );
  
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