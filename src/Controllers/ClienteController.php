<?php
namespace App\Controllers;

use App\Models\Cliente;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ClienteController
{
    public function obtenerClientes(Request $request, Response $response): Response
    {
        $clientes = Cliente::obtenerClientes();
        $response->getBody()->write(json_encode($clientes, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function obtenerClientePorId(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'] ?? null;
        $cliente = Cliente::obtenerClientePorId($id);

        if (!$cliente) {
            $response->getBody()->write(json_encode(["error" => "Cliente no encontrado"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        $response->getBody()->write(json_encode($cliente, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function crearCliente(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        if (!isset($data['nombre'], $data['telefono'], $data['correo'], $data['direccion'])) {
            $response->getBody()->write(json_encode(['error' => 'Datos incompletos']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $id = Cliente::crearCliente($data['nombre'], $data['telefono'], $data['correo'], $data['direccion']);

        $response->getBody()->write(json_encode(['id' => $id, 'success' => 'Cliente creado']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function actualizarCliente(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'] ?? null;
        $data = $request->getParsedBody();

        Cliente::actualizarCliente($id, $data['nombre'], $data['correo'], $data['telefono'], $data['direccion']);

        $response->getBody()->write(json_encode(['message' => 'Cliente actualizado']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function eliminarCliente(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write(json_encode(['message' => 'El borrado de datos se encuentra deshabilitado']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
