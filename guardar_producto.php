<?php

// =====================================================
// Archivo: guardar_producto.php
// Descripción:
// Recibe los datos de un producto en formato JSON
// y los almacena en la base de datos.
// =====================================================

// Conexión a la base de datos
include 'conexion.php';

// Obtener los datos enviados desde la aplicación
$data = json_decode(file_get_contents("php://input"), true);

// =====================================================
// Capturar los datos recibidos
// =====================================================

$codigo    = $data['codigo'];
$nombre    = $data['nombre'];
$categoria = $data['categoria'];
$cantidad  = $data['cantidad'];
$costo     = $data['costo'];
$total     = $data['total'];
$proveedor = $data['proveedor'];
$imagen    = $data['imagen'];

// =====================================================
// Consulta SQL para insertar el producto
// =====================================================

$sql = "INSERT INTO productos
        (codigo, nombre, categoria, cantidad, costo, total, proveedor, imagen)
        VALUES
        ('$codigo', '$nombre', '$categoria', '$cantidad', '$costo', '$total', '$proveedor', '$imagen')";

// =====================================================
// Verificar si el registro fue exitoso
// =====================================================

if ($conn->query($sql) === TRUE) {

    // Respuesta de éxito
    echo json_encode([
        "success" => true,
        "message" => "Producto guardado correctamente"
    ]);

} else {

    // Respuesta de error
    echo json_encode([
        "success" => false,
        "error" => $conn->error
    ]);

}

// =====================================================
// Cerrar la conexión con la base de datos
// =====================================================

$conn->close();

?>