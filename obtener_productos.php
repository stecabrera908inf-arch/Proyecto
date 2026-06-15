<?php

include 'conexion.php';

$sql = "SELECT * FROM productos ORDER BY id DESC";

$resultado = $conn->query($sql);

$productos = [];

while($fila = $resultado->fetch_assoc()) {

    $productos[] = [
        "id" => $fila["id"],
        "codigo" => $fila["codigo"],
        "nombre" => $fila["nombre"],
        "categoria" => $fila["categoria"],
        "cantidad" => $fila["cantidad"],
        "costo" => $fila["costo"],
        "total" => $fila["total"],
        "proveedor" => $fila["proveedor"],
        "imagen" => $fila["imagen"]
    ];

}

echo json_encode($productos);

$conn->close();

?>
