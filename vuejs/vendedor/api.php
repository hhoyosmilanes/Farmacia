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
  $result = $conn->query( "SELECT * FROM vendedor" );
  $students = array();

  while ( $row = $result->fetch_assoc() ) {
    array_push( $students, $row );
  }

  $res['students'] = $students;  
}

if ( $action == 'create' ) {
  $idvendedor = $_POST['idvendedor'];
  $nombre = $_POST['nombre'];
  $telefono = $_POST['telefono'];

  $result = $conn->query( "INSERT INTO vendedor (`idvendedor`, `nombre`, `telefono`) VALUES ('$idvendedor', '$nombre', '$telefono')" );
  
  if ( $result ) {
    $res['message'] = 'vendedor agregado con éxito.';
  } else {
    $res['error'] = true;
    $res['message'] = "vendedor al tratar de agregar estudiante.";
  }
}

if ( $action == 'update' ) {
  $idvendedor = $_POST['idvendedor'];
  $idnew = $_POST['idnew'];
  $nombre = $_POST['nombre'];
  $telefono = $_POST['telefono'];
 
  $result = $conn->query( "UPDATE vendedor SET idvendedor = '$idnew', nombre = '$nombre', telefono = '$telefono' WHERE idvendedor = $idvendedor" );
  
  if ( $result ) {
    $res['message'] = 'Estudiante actualizado con éxito.';
  } else {
    $res['error'] = true;
    $res['message'] = "Error al tratar de actualizar estudiante.";
  }
}

if ( $action == 'delete' ) {
  $idvendedor = $_POST['idvendedor'];

  $result = $conn->query( "DELETE FROM vendedor WHERE idvendedor = $idvendedor" );
  
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