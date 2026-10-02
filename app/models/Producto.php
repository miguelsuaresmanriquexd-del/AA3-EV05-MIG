<?php
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