<?php
// Enrutador Principal MVC para Futuro Inversión

// 1. Cargar controladores necesarios
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/LoginController.php';

// 2. Leer la acción de la URL
$page = $_GET['page'] ?? 'home';

// 3. Enrutamiento mediante controladores
switch ($page) {
    case 'login':
        $controlador = new LoginController();
        $controlador->index();
        break;

    case 'home':
    default:
        $controlador = new HomeController();
        $controlador->index();
        break;
}
