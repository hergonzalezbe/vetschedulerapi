<?php

namespace App\Models;

use App\Database\Database;

use PDO;

class Cita
{
    public static function crearCita($mascota_id, $fecha, $descripcion)
    {
        $pdo = Database::getInstance();
        $sql = "INSERT INTO citas (mascota_id, fecha, estado,creado_en,actualizado_en,descripcion) VALUES (?, ?, ?, now(), now(),?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$mascota_id, $fecha, 'pendiente', $descripcion]);
        return $pdo->lastInsertId();
    }

    public static function obtenerCita($id)
    {
        $pdo = Database::getInstance();
        $sql = "SELECT * FROM citas WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para obtener todas las citas
    public static function obtenerTodasLasCitas()
    {
        $pdo = Database::getInstance();
        $sql = "SELECT * FROM citas";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerCitasPorMascota($mascota_id)
    {
        $pdo = Database::getInstance();
        $sql = "SELECT cli.nombre as cliente
,mas.nombre as mascota
,cit.fecha 
,cit.descripcion
,cit.estado
FROM citas cit
inner join mascotas mas 
on cit.mascota_id=mas.id
inner join clientes cli
on mas.cliente_id = cli.id
WHERE mascota_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$mascota_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function actualizarCita($id, $cliente_id, $mascota, $fecha, $hora, $estado)
    {
        $pdo = Database::getInstance();
        $sql = "UPDATE citas SET cliente_id = ?, mascota = ?, fecha = ?, hora = ?, estado = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$cliente_id, $mascota, $fecha, $hora, $estado, $id]);
    }

    public static function eliminarCita($id)
    {
        $pdo = Database::getInstance();
        $sql = "DELETE FROM citas WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public static function resultadoActualizarCita($id, $estado,$descripcion, $fecha)
    {
        $pdo = Database::getInstance();
        $sql = "update citas
set estado=?
,actualizado_en=now()
where id=?";

$sql1="insert historial_citas(cita_id,descripcion,fecha)
values(?,?,?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$estado, $id]);

        $stmt1 = $pdo->prepare($sql1);
        return $stmt1->execute([$id,$descripcion,$fecha]);
    }
}

    
