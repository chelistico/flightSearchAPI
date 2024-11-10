<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controller\JourneyController;

$journeyService = new App\Service\JourneyService();
$journeyController = new JourneyController($journeyService);

// Obtenemos la URL solicitada y la normalizamos quitando parámetros GET
$requestUri = strtok($_SERVER['REQUEST_URI'], '?');

// Definimos las rutas
switch ($requestUri) {
    case '/':
        // Ruta principal, carga el formulario de búsqueda
        require __DIR__ . '/Views/form.php';
        break;

    case '/journeys/search':
        // Ruta de búsqueda de vuelos
        $date = $_GET['date'] ?? null;
        $from = $_GET['from'] ?? null;
        $to = $_GET['to'] ?? null;

        if ($date && $from && $to) {
            $journeyController->searchJourneys($date, $from, $to);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Insufficient parameters"]);
        }
        break;

    default:
        // Ruta no encontrada
        http_response_code(404);
        echo json_encode(["error" => "Route not found"]);
        break;
}
