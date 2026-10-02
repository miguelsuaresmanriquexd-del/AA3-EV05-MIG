<?php
class ProductoController
{
    public static function guardar(): string
    {
        $d = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'precio' => (float) ($_POST['precio'] ?? 0),
            'stock' => (int) ($_POST['stock'] ?? 0),
            'proveedor' => (int) ($_POST['proveedor'] ?? 0),
        ];
        if ($d['nombre'] === '' || $d['precio'] <= 0 || $d['stock'] < 0) {
            return 'Indique un nombre, un precio mayor a cero y un stock válido.';
        }
        Producto::crear($d);
        header('Location: index.php?page=productos&ok=1');
        exit;
    }

    public static function eliminar(): void
    {
        Producto::eliminar((int) ($_POST['id'] ?? 0));
        header('Location: index.php?page=productos');
        exit;
    }
}