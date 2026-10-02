<?php
class Cliente
{
    public static function listar(int $uid): array
    {
        $s = Conexion::get()->prepare('SELECT * FROM clientes WHERE usuario_id = ? ORDER BY id DESC');
        $s->execute([$uid]);
        return $s->fetchAll();
    }

    public static function total(int $uid): int
    {
        $s = Conexion::get()->prepare('SELECT COUNT(*) FROM clientes WHERE usuario_id = ?');
        $s->execute([$uid]);
        return (int) $s->fetchColumn();
    }

    public static function existe(int $uid, string $documento): bool
    {
        $s = Conexion::get()->prepare('SELECT 1 FROM clientes WHERE usuario_id = ? AND documento = ?');
        $s->execute([$uid, $documento]);
        return (bool) $s->fetchColumn();
    }

    public static function crear(int $uid, array $d): void
    {
        Conexion::get()->prepare('INSERT INTO clientes (usuario_id, documento, nombre, telefono, direccion, correo) VALUES (?, ?, ?, ?, ?, ?)')
            ->execute([$uid, $d['documento'], $d['nombre'], $d['telefono'], $d['direccion'], $d['correo']]);
    }

    public static function eliminar(int $uid, int $id): void
    {
        Conexion::get()->prepare('DELETE FROM clientes WHERE id = ? AND usuario_id = ?')->execute([$id, $uid]);
    }
}
