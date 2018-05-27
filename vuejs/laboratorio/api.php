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
  $result = $conn->query( "SELECT * FROM laboratorio" );
  $students = array();

  while ( $row = $result->fetch_assoc() ) {
    array_push( $students, $row );
  }

  $res['students'] = $students;  
}

if ( $action == 'create' ) {
  $direccion = $_POST['direccion'];
  $nombre = $_POST['nombre'];
  $telefono = $_POST['telefono'];

  $result = $conn->query( "INSERT INTO laboratorio (`direccion`, `nombre`, `telefono`) VALUES ('$direccion', '$nombre', '$telefono')" );
  
  if ( $result ) {
    $res['message'] = 'Cliente agregado con éxito.';
  } else {
    $res['error'] = true;
    $res['message'] = "Cliente al tratar de agregar estudiante.";
  }
}

if ( $action == 'update' ) {
  $idlaboratorio = $_POST['idlaboratorio'];
  $direccion = $_POST['direccion'];
  $nombre = $_POST['nombre'];
  $telefono = $_POST['telefono'];
 
  $result = $conn->query( "UPDATE laboratorio SET direccion = '$direccion', nombre = '$nombre', telefono = '$telefono' WHERE idlaboratorio = $idlaboratorio" );
  
  if ( $result ) {
    $res['message'] = 'Estudiante actualizado con éxito.';
  } else {
    $res['error'] = true;
    $res['message'] = "Error al tratar de actualizar estudiante.";
  }
}

if ( $action == 'delete' ) {
  $idlaboratorio = $_POST['idlaboratorio'];

  $result = $conn->query( "DELETE FROM laboratorio WHERE idlaboratorio = $idlaboratorio" );
  
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