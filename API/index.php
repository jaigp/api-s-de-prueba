<?php
require 'ConexionDB.php';
header('content-type: application/json');

class apiProductos 
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function obtenerTodos() 
    {
        $stmt = $this->pdo->prepare("SELECT * FROM productos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregar($nombre, $precio, $descripcion) {
        $stmt = $this->pdo->prepare("INSERT INTO productos (nombre, precio, descripcion) VALUES (?,?,?)"); 
        return $stmt->execute([$nombre, $precio, $descripcion]);
    }

    public function actualizarProducto($id, $nombre, $precio, $descripcion)
    {
        $stmt = $this->pdo->prepare("UPDATE productos SET nombre = ?, precio = ?,
        descripcion = ? WHERE id = ?");
        return  $stmt->execute([$nombre, $precio, $descripcion, $id]);

    }
    public function eliminarProductos($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM productos WHERE id = ?");
        return  $stmt->execute([$id]);

    }
}

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'apiProg';

$ConexionDB = new ConexionDB($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();

$producto = new apiProductos($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $productos = $producto->obtenerTodos();
    echo json_encode($productos);
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = json_decode(file_get_contents('php://input'), true);
    $nombre = $data['nombre'];
    $precio =  $data['precio'];
    $descripcion = $data['descripcion'];

    if($producto->agregar($nombre, $precio, $descripcion)){
        echo json_encode(['message' => 'Producto agregado con exito']);

    } else {
        echo json_encode(['message' => 'Error al agregar el producto']);
    }
}
if($_SERVER['REQUEST_METHOD'] === 'PUT'){
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $nombre = $data['nombre'];
    $precio =  $data['precio'];
    $descripcion = $data['descripcion'];

    if($producto->actualizarProducto($id, $nombre, $precio,  $descripcion)){
        echo json_encode(['message' => 'Producto actualizado con exito']);

    } else {
        echo json_encode(['message' => 'Error al actualizar el producto']);
    }
}
if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];

    if($producto->eliminarProductos($id)){
        echo json_encode(['message' => 'Producto eliminado con exito']);

    } else {
        echo json_encode(['message' => 'Error al eliminar el producto']);
    }
}