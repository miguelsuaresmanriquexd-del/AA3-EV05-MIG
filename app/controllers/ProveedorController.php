<?php
class ProveedorController
{
    public static function guardar(): string
    {
        $d = [];
        foreach (['razon_social', 'nombre', 'direccion', 'telefono'] as $k) {
            $d[$k] = trim($_POST[$k] ?? '');
        }
        if ($d['razon_social'] === '' || $d['nombre'] === '') {
            return 'La razón social y el nombre son obligatorios.';
        }
        Proveedor::crear($d);
        header('Location: index.php?page=proveedores&ok=1');
        exit;
    }

    public static function eliminar(): void
    {
        Proveedor::eliminar((int) ($_POST['id'] ?? 0));
        header('Location: index.php?page=proveedores');
        exit;
    }
}