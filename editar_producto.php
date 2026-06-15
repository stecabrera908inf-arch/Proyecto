<?php

include 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];

$nombre = $data['nombre'];
$categoria = $data['categoria'];
$cantidad = $data['cantidad'];
$costo = $data['costo'];
$total = $data['total'];
$proveedor = $data['proveedor'];

$sql = "UPDATE productos SET

nombre='$nombre',
categoria='$categoria',
cantidad='$cantidad',
costo='$costo',
total='$total',
proveedor='$proveedor'

WHERE id='$id'";

if ($conn->query($sql) === TRUE) {

    echo json_encode([
        "success" => true
    ]);

} else {

    echo json_encode([
        "success" => false
    ]);

}

$conn->close();

?>