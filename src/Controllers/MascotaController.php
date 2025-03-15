<?php

namespace App\Controllers;

use App\Models\Mascota;
use App\Models\Cliente;

class MascotaController
{
    public function crearMascota()
    {
        $data = json_decode(file_get_contents("php://input"));

        $cliente_id = $data->cliente_id;
        $nombre = $data->nombre;
        $especie = $data->especie;
        $raza = $data->raza;
        $edad = $data->edad;

        // Verificar si el cliente existe
        $cliente = Cliente::obtenerClientePorId($cliente_id);
        
        if (!$cliente) {
            // Si no existe el cliente, devolver un error y salir
            echo json_encode(["error" => "Cliente no encontrado"]);
            http_response_code(404);
            return; 
        }

        if (!$cliente_id || !$nombre || !$especie || !$raza || !$edad) {
            echo json_encode(['error' => 'Todos los campos son requeridos']);
            return;
        }

        $id = Mascota::crearMascota($cliente_id, $nombre, $especie, $raza, $edad);
        echo json_encode(['id' => $id, 'success' => 'Mascota creada correctamente']);
    }

    public function obtenerMascotas()
    {
        $mascotas = Mascota::obtenerTodasLasMascotas();
        echo json_encode($mascotas);
    }

    public function obtenerMascotasPorCliente($cliente_id)
    {
        $mascotas = Mascota::obtenerMascotasPorCliente($cliente_id);
        echo json_encode($mascotas);
    }

    public function obtenerMascota($idcliente,$idmascota)
    {
        $mascotas = Mascota::obtenerMascota($idcliente,$idmascota);

        if(!$mascotas){
            echo json_encode(["error" => "Mascota no encontrada"]);
            http_response_code(404);
            return;
        }

        echo json_encode($mascotas);
    }

    public function actualizarMascota($id)
    {
        $data = json_decode(file_get_contents("php://input"));

        $nombre = $data->nombre;
        $especie = $data->especie;
        $raza = $data->raza;
        $edad = $data->edad;

        if (!$nombre || !$especie || !$raza || !$edad) {
            echo json_encode(['error' => 'Todos los campos son requeridos']);
            return;
        }

        Mascota::actualizarMascota($id, $nombre, $especie, $raza, $edad);
        echo json_encode(['success' => true]);
    }

    public function eliminarMascota($id)
    {
        Mascota::eliminarMascota($id);
        echo json_encode(['success' => true]);
    }
}
