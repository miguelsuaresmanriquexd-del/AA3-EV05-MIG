<?php
class Proveedor
{
    public static function listar(): array
    {
        return Conexion::get()->query('SELECT * FROM proveedores ORDER BY id DESC')->fetchAll();
    }

    public static function crear(array $d): void
    {
        Conexion::get()->prepare('INSERT INTO proveedores (razon_social, nombre, direccion, telefono) VALUES (?, ?, ?, ?)')
            ->execute([$d['razon_social'], $d['nombre'], $d['direccion'], $d['telefono']]);
    }

    public static function eliminar(int $id): void
    {
        Conexion::get()->prepare('DELETE FROM proveedores WHERE id = ?')->execute([$id]);
    }
}