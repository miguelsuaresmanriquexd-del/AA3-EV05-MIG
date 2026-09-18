<?php
class Database {
    private $host = "localhost";
    private $db_name = "futuro_inversion"; // Se actualizó el nombre de la BD
    private $username = "root";
    private $password = "";
    private $connection;

    public function conectar() {
        $this->connection = null;
        try {
            $this->connection = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username,
                $this->password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Error de conexión en la base de datos: " . $e->getMessage();
        }
        return $this->connection;
    }
}
