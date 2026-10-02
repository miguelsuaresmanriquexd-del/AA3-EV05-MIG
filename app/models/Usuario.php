<?php
class Usuario
{
    public static function buscarPorEmail(string $email)
    {
        $s = Conexion::get()->prepare('SELECT * FROM usuarios WHERE email = ?');
        $s->execute([$email]);
        return $s->fetch();
    }

    public static function crear(string $nombre, string $email, string $clave): void
    {
        $pdo = Conexion::get();
        $rol = (int) $pdo->query('SELECT COUNT(*) FROM usuarios')->fetchColumn() === 0 ? 1 : 3;
        $pdo->prepare('INSERT INTO usuarios (nombre, email, clave, rol_id) VALUES (?, ?, ?, ?)')
            ->execute([$nombre, $email, password_hash($clave, PASSWORD_DEFAULT), $rol]);
    }

    public static function permisos(int $uid): array
    {
        $s = Conexion::get()->prepare(
            'SELECT p.nombre FROM usuarios u
            JOIN rol_permiso rp ON rp.rol_id = u.rol_id
            JOIN permisos p ON p.id = rp.permiso_id WHERE u.id = ?'
        );
        $s->execute([$uid]);
        return $s->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function todos(): array
    {
        return Conexion::get()->query(
            'SELECT u.id, u.nombre, u.email, u.creado, u.rol_id, r.nombre rol
            FROM usuarios u JOIN roles r ON r.id = u.rol_id ORDER BY u.id'
        )->fetchAll();
    }

    public static function roles(): array
    {
        return Conexion::get()->query(
            "SELECT r.id, r.nombre, r.descripcion, GROUP_CONCAT(p.nombre ORDER BY p.id SEPARATOR ', ') permisos
            FROM roles r LEFT JOIN rol_permiso rp ON rp.rol_id = r.id
            LEFT JOIN permisos p ON p.id = rp.permiso_id GROUP BY r.id ORDER BY r.id"
        )->fetchAll();
    }

    public static function cambiarRol(int $id, int $rol): void
    {
        Conexion::get()->prepare('UPDATE usuarios SET rol_id = ? WHERE id = ?')->execute([$rol, $id]);
    }
}