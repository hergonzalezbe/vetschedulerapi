<?php
use Slim\Factory\AppFactory;
//use DI\Container;
use App\Controllers\ClienteController;
use App\Controllers\MascotaController;
use App\Controllers\CitaController;
use App\Middleware\ApiKeyMiddleware;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// $container = new Container();
// AppFactory::setContainer($container);

$app = AppFactory::create();
$app->setBasePath('/vetschedulerapi/public');
$app->addBodyParsingMiddleware();
$app->add(new ApiKeyMiddleware());
header_remove("X-Powered-By");

// Middleware para manejo de errores
//$app->addErrorMiddleware(true, true, true);

$app->group('/clientes', function ($group) {
    $group->get('', [ClienteController::class, 'obtenerClientes']);
    $group->get('/{id}', [ClienteController::class, 'obtenerClientePorId']);
    $group->post('', [ClienteController::class, 'crearCliente']);
    $group->put('/{id}', [ClienteController::class, 'actualizarCliente']);
    $group->delete('/{id}', [ClienteController::class, 'eliminarCliente']);
});

$app->group('/mascotas', function ($group) {
    $group->get('', [MascotaController::class, 'obtenerMascotas']);
    $group->get('/{clienteId}', [MascotaController::class, 'obtenerMascotasPorCliente']);
    $group->get('/{clienteId}/{mascotaId}', [MascotaController::class, 'obtenerMascota']);
    $group->post('', [MascotaController::class, 'crearMascota']);
    $group->put('/{id}', [MascotaController::class, 'actualizarMascota']);
    $group->delete('/{id}', [MascotaController::class, 'eliminarMascota']);
});

$app->group('/citas', function ($group) {
    $group->get('', [CitaController::class, 'obtenerCitas']);
    $group->get('/{mascotaId}', [CitaController::class, 'obtenerCitasPorMascota']);
    $group->post('', [CitaController::class, 'crearCita']);
    $group->put('/{id}', [CitaController::class, 'actualizarCita']);
    $group->put('/{id}/resultado', [CitaController::class, 'resultadoActualizarCita']);
    $group->delete('/{id}', [CitaController::class, 'eliminarCita']);
});

$app->map(['GET', 'POST', 'PUT', 'DELETE'], '/{routes:.+}', function ($request, $response) {
    $response->getBody()->write(json_encode(['error' => 'Ruta no encontrada']));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
});

$app->run();
