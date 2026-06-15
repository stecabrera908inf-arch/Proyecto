<?php

$host = "localhost";
$usuario = "root";
$password = "";
$database = "inventario_db";

$conn = new mysqli($host, $usuario, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>