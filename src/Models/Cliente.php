<?php
namespace App\Models;

use App\Database\Database;
use PDO;
use PDOException;

class Cliente
{
    public static function obtenerClientes()
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT id, nombre, correo, telefono, direccion FROM clientes";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error al obtener clientes: ' . $e->getMessage()];
        }
    }

    public static function obtenerClientePorId($id)
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT id, nombre, correo, telefono, direccion FROM clientes WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            return ['error' => 'Error al obtener cliente: ' . $e->getMessage()];
        }
    }

    public static function crearCliente($nombre, $telefono, $correo, $direccion)
    {
        try {
            $pdo = Database::getInstance();
            $sql = "INSERT INTO clientes (nombre, correo, telefono, direccion) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre, $correo, $telefono, $direccion]);
            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            return ['error' => 'Error al crear cliente: ' . $e->getMessage()];
        }
    }

    public static function actualizarCliente($id, $nombre, $correo, $telefono, $direccion)
    {
        try {
            $pdo = Database::getInstance();
            $sql = "UPDATE clientes SET nombre = ?, correo = ?, telefono = ?, direccion = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre, $correo, $telefono, $direccion, $id]);

            return $stmt->rowCount() > 0; // Devuelve `true` si se actualizó, `false` si no
        } catch (PDOException $e) {
            return ['error' => 'Error al actualizar cliente: ' . $e->getMessage()];
        }
    }

    public static function eliminarCliente($id)
    {
        try {
            $pdo = Database::getInstance();
            $sql = "DELETE FROM clientes WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);

            return $stmt->rowCount() > 0; // Devuelve `true` si eliminó, `false` si no
        } catch (PDOException $e) {
            return ['error' => 'Error al eliminar cliente: ' . $e->getMessage()];
        }
    }
}
