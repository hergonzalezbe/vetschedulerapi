<?php
namespace App\Models;

use App\Database\Database;
use PDO;

class Mascota
{
    // Crear una nueva mascota
    public static function crearMascota($cliente_id, $nombre, $especie, $raza, $edad)
    {
        $pdo = Database::getInstance();
        $sql = "INSERT INTO mascotas (cliente_id, nombre, especie, raza, edad) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cliente_id, $nombre, $especie, $raza, $edad]);
        return $pdo->lastInsertId();
    }

    // Obtener una mascota por ID del cliente y ID de la mascota
    public static function obtenerMascota($idcliente,$idmascota)
    {
        $pdo = Database::getInstance();
        $sql = "SELECT id,nombre,especie,raza,edad FROM mascotas WHERE cliente_id= ? and id = ?; ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idcliente,$idmascota]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener todas las mascotas de un cliente
    public static function obtenerMascotasPorCliente($cliente_id)
    {
        $pdo = Database::getInstance();
        $sql = "SELECT id,nombre,especie,raza,edad FROM mascotas WHERE cliente_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cliente_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener todas las mascotas (sin filtrar por cliente)
    public static function obtenerTodasLasMascotas()
    {
        $pdo = Database::getInstance();
        $sql = "SELECT id,nombre,especie,raza,edad FROM mascotas";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar una mascota
    public static function actualizarMascota($id, $nombre, $especie, $raza, $edad)
    {
        $pdo = Database::getInstance();
        $sql = "UPDATE mascotas SET nombre = ?, especie = ?, raza = ?, fecha_nacimiento = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$nombre, $especie, $raza, $edad, $id]);
    }

    // Eliminar una mascota
    public static function eliminarMascota($id)
    {
        $pdo = Database::getInstance();
        $sql = "DELETE FROM mascotas WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
