<?php

namespace App\Controllers;

use App\Models\Cita;

class CitaController
{
    public function obtenerCitas()
    {
        // Llamamos al modelo para obtener todas las citas
        $citas = Cita::obtenerTodasLasCitas();
        echo json_encode($citas);
    }

    public function obtenerCita($id)
    {
        $cita = Cita::obtenerCita($id);
        echo json_encode($cita);
    }

    public function crearCita()
    {
        $data = json_decode(file_get_contents("php://input"));
        
        $mascota_id = $data->mascota_id;
        $fecha = $data->fecha;
        $descripcion=$data->descripcion;        

        if (!$mascota_id || !$fecha) {
            echo json_encode(['error' => 'Los campos son requeridos']);
            return;
        }

        $id = Cita::crearCita($mascota_id, $fecha,$descripcion);
        echo json_encode(['success' => 'Cita creada', 'id' => $id]);
    }

    public function obtenerCitasPorMascota($mascota_id)
    {
        $citas = Cita::obtenerCitasPorMascota($mascota_id);
        if ($citas) {
            echo json_encode($citas);
        } else {
            echo json_encode(['error' => 'No se encontraron citas para el cliente con ID: ' . $mascota_id]);
        }
    }

    public function actualizarCita($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['cliente_id'], $data['mascota'], $data['fecha'], $data['hora'], $data['estado'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos incompletos']);
            return;
        }

        $actualizado = Cita::actualizarCita($id, $data['cliente_id'], $data['mascota'], $data['fecha'], $data['hora'], $data['estado']);

        if ($actualizado) {
            echo json_encode(['success' => 'Cita actualizada correctamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'No se pudo actualizar la cita']);
        }
    }

    public function eliminarCita($id)
    {
        $eliminado = Cita::eliminarCita($id);

        if ($eliminado) {
            echo json_encode(['success' => 'Cita eliminada correctamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'No se pudo eliminar la cita']);
        }
    }

    public function resultadoActualizarCita(){
        $data = json_decode(file_get_contents("php://input"));
        
        $id = $data->id;
        $estado=$data->estado;
        $descripcion=$data->descripcion;        
        $fecha = $data->fecha;
        
        if (!$id || !$fecha || !$descripcion ||!$fecha) {
            echo json_encode(['error' => 'Los campos son requeridos']);
            return;
        }

        $id = Cita::resultadoActualizarCita($id, $estado,$descripcion, $fecha);
        echo json_encode(['success' => 'Cita actualizada con un resultado', 'id' => $id]);
    }
}
