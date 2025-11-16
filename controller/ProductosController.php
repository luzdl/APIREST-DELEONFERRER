<?php

class ProductosController {
    private $db;
    private $producto;

    public function __construct($db) {
        $this->db = $db;
        require_once __DIR__ . '/../model/Producto.php';
        $this->producto = new Producto($db);
    }

    public function getProductos() {
        $result = $this->producto->getProductos();
        $productos = $result->fetchAll(PDO::FETCH_ASSOC);
        if(count($productos) > 0) {
            http_response_code(200);
            return json_encode([
                'success' => true,
                'total' => count($productos),
                'data' => $productos
            ]);
        } else {
            http_response_code(404);
            return json_encode([
                'success' => false,
                'message' => 'No se encontraron productos'
            ]);
        }
    }

    public function getProductoById($id) {
        $this->producto->id = $id;
        $producto = $this->producto->getProductoById();
        if($producto) {
            http_response_code(200);
            return json_encode([
                'success' => true,
                'data' => $producto
            ]);
        } else {
            http_response_code(404);
            return json_encode([
                'success' => false,
                'message' => 'Producto no encontrado'
            ]);
        }
    }

    public function createProducto($data) {
        if(empty($data['name']) || empty($data['price']) || !isset($data['quantity'])) {
            http_response_code(400);
            return json_encode([
                'success' => false,
                'message' => 'Campos requeridos: name, price, quantity'
            ]);
        }
        $this->producto->name = $data['name'];
        $this->producto->description = $data['description'] ?? '';
        $this->producto->price = $data['price'];
        $this->producto->quantity = $data['quantity'];
        $this->producto->image = $data['image'] ?? null;
        if($this->producto->createProducto()) {
            http_response_code(201);
            return json_encode([
                'success' => true,
                'message' => 'Producto creado exitosamente'
            ]);
        } else {
            http_response_code(503);
            return json_encode([
                'success' => false,
                'message' => 'Error al crear el producto'
            ]);
        }
    }

    public function updateProducto($id, $data) {
        if(empty($data['name']) || empty($data['price']) || !isset($data['quantity'])) {
            http_response_code(400);
            return json_encode([
                'success' => false,
                'message' => 'Campos requeridos: name, price, quantity'
            ]);
        }
        $this->producto->id = $id;
        $this->producto->name = $data['name'];
        $this->producto->description = $data['description'] ?? '';
        $this->producto->price = $data['price'];
        $this->producto->quantity = $data['quantity'];
        $this->producto->image = $data['image'] ?? null;
        if($this->producto->updateProducto()) {
            http_response_code(200);
            return json_encode([
                'success' => true,
                'message' => 'Producto actualizado exitosamente'
            ]);
        } else {
            http_response_code(503);
            return json_encode([
                'success' => false,
                'message' => 'Error al actualizar el producto'
            ]);
        }
    }
}
?>
