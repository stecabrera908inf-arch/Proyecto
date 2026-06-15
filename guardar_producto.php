<?php

include 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

$codigo = $data['codigo'];
$nombre = $data['nombre'];
$categoria = $data['categoria'];
$cantidad = $data['cantidad'];
$costo = $data['costo'];
$total = $data['total'];
$proveedor = $data['proveedor'];
$imagen = $data['imagen'];

$sql = "INSERT INTO productos 
(codigo, nombre, categoria, cantidad, costo, total, proveedor, imagen)
VALUES 
('$codigo','$nombre','$categoria','$cantidad','$costo','$total','$proveedor','$imagen')";

if ($conn->query($sql) === TRUE) {

    echo json_encode([
        "success" => true,
        "message" => "Producto guardado correctamente"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "error" => $conn->error
    ]);

}

$conn->close();

?>
