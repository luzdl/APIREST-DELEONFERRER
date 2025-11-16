<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'config/database.php';
require_once 'controller/ProductosController.php';

$database = new Database();
$db = $database->connect();
$controller = new ProductosController($db);

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'] ?? '', '/'));
$id = isset($request[0]) && $request[0] !== '' ? (int)$request[0] : null;

// Si el ID no viene en la ruta, intentar desde query string
if (!$id && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
}

try {
    switch($method) {
        case 'GET':
            if($id) {
                echo $controller->getProductoById($id);
            } else {
                echo $controller->getProductos();
            }
            break;
        case 'POST':
            $data = null;
            
            // Método 1: Leer JSON del body
            $input = file_get_contents("php://input");
            if (!empty($input)) {
                $data = json_decode($input, true);
            }
            
            // Método 2: Si no hay JSON, intentar form-data
            if (empty($data) && !empty($_POST)) {
                $data = $_POST;
            }
            
            // Método 3: Si no hay nada, intentar query string (excluyendo 'id')
            if (empty($data) && !empty($_GET)) {
                $data = $_GET;
                unset($data['id']); // Remover el ID si viene en query string
            }
            
            // Si aún no hay datos
            if (empty($data)) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'No se recibieron datos',
                    'instrucciones' => 'Envía los parámetros en el body (JSON o form-data) o en la URL como query string'
                ]);
                break;
            }
            
            echo $controller->createProducto($data);
            break;
        case 'PUT':
            if(!$id) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'ID requerido para actualizar'
                ]);
                break;
            }
            
            $data = null;
            
            // Método 1: Leer JSON del body
            $input = file_get_contents("php://input");
            if (!empty($input)) {
                $data = json_decode($input, true);
            }
            
            // Método 2: Si no hay JSON, intentar form-data
            if (empty($data) && !empty($_POST)) {
                $data = $_POST;
            }
            
            // Método 3: Si no hay nada, intentar query string
            if (empty($data) && !empty($_GET)) {
                $data = $_GET;
                unset($data['id']); // Remover el ID si viene en query string
            }
            
            // Si aún no hay datos
            if (empty($data)) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'No se recibieron datos para actualizar'
                ]);
                break;
            }
            
            echo $controller->updateProducto($id, $data);
            break;
        default:
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
            break;
    }
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>
