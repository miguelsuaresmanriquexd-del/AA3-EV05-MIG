<?php
<<<<<<< HEAD
class Producto
{
    public static function listar(): array
    {
        return Conexion::get()->query(
            'SELECT p.*, v.razon_social proveedor FROM productos p
            LEFT JOIN proveedores v ON v.id = p.proveedor_id ORDER BY p.id DESC'
        )->fetchAll();
    }

    public static function obtener(int $id)
    {
        $s = Conexion::get()->prepare('SELECT * FROM productos WHERE id = ?');
        $s->execute([$id]);
        return $s->fetch();
    }

    public static function crear(array $d): void
    {
        Conexion::get()->prepare('INSERT INTO productos (nombre, precio, stock, proveedor_id) VALUES (?, ?, ?, ?)')
            ->execute([$d['nombre'], $d['precio'], $d['stock'], $d['proveedor'] ?: null]);
    }

    public static function eliminar(int $id): void
    {
        Conexion::get()->prepare('DELETE FROM productos WHERE id = ?')->execute([$id]);
    }
}
=======
require_once __DIR__ . '/../../config/database.php';

class Producto {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->conectar();
    }

    public function getAll() {
        try {
            $sql = "SELECT id, nombre, precio FROM producto";
            $consulta = $this->connection->query($sql);
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al consultar el catálogo completo de productos: " . $e->getMessage();
        }
    }
}
>>>>>>> 04e403dd66e2391ced03e1415f39bbe388413d0e
