<?php


if(isset($_GET['url'])){
    $url = $_GET['url'];

    // Verificar si la vista solicitada comienza con 'api/'
    if (strpos($url, 'api/') === 0) {
        // Si es así, separamos el nombre del recurso y el método
        list($prefix, $resource, $method) = explode('/', $url);

        // Requerimos el controlador correspondiente
        require __DIR__ . '/models/' . ucfirst($resource) . '.php';

        // Creamos una nueva instancia del controlador
        $controllerName = 'Fede\\Backend\\models\\' . ucfirst($resource);
        $controller = new $controllerName();

        // Llamamos al método correspondiente
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if (strpos($method,'show') !== false) {
                    $id = $_GET['id'] ?? null;
                    $controller->$method($id);
                } else {
                    $controller->$method();
                }
                break;
            case 'POST':
                //obtener el valor por json y convertirlo a array
                $data = json_decode(file_get_contents('php://input'), true);
                $controller->$method($data);
                break;
            // Aquí puedes agregar más casos para otros métodos HTTP (PUT, DELETE, etc.)

            case 'PUT':
                //obtener el valor por json y convertirlo a array
                $data = json_decode(file_get_contents('php://input'), true);
                $controller->$method($data);
                break;
            case 'DELETE':
                $delete = $_GET['id'] ?? null;
                $controller->$method($delete);
                break;
        }
    } else {
        // Si no, cargamos la vista correspondiente
        require __DIR__ . '/views/' . $url . '.php';
    }
} else {
    require 'src/views/index.php';
}