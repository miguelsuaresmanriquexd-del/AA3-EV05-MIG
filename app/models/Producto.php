<?php
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
