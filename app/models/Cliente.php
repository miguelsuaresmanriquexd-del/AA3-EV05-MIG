<?php
require_once __DIR__ . '/../../config/database.php';

class Cliente {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->conectar();
    }

    public function getAll() {
        try {
            $sql = "SELECT id, nombre, documento, correo, telefono FROM clientes";
            $consulta = $this->connection->query($sql);
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener la lista completa de clientes: " . $e->getMessage();
        }
    }
}
