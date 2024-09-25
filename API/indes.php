<?php

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'apiProg';

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stm = $pdo->prepare("SELECT * FROM productos");
    $stm->execute();
    $productos = $stm->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($productos);        
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nombre = $data['nombre'];
    $precio = $data['precio'];
    $descripcion = $data['descripcion'];
    $stm = $pdo->prepare("INSERT INTO productos (nombre, precio, descripcion) VALUES (?, ?, ?)");
    

    if($stm->execute([$nombre, $precio, $descripcion])) {
        echo json_encode(['message' => 'Producto creado exitosamente']);
    } else {
        echo json_encode(['message' => 'Error al crear el producto']);
    }
}