<?php
class ClienteController
{
    public static function guardar(): string
    {
        $uid = $_SESSION['usuario']['id'];
        $d = [
            'documento' => trim($_POST['documento'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'telefono' => trim($_POST['telefono'] ?? ''),
            'direccion' => trim($_POST['direccion'] ?? ''),
            'correo' => trim($_POST['correo'] ?? ''),
        ];
        if ($d['documento'] === '' || $d['nombre'] === '') {
            return 'El documento y el nombre son obligatorios.';
        }
        if ($d['correo'] !== '' && !filter_var($d['correo'], FILTER_VALIDATE_EMAIL)) {
            return 'El correo ingresado no es válido.';
        }
        if (Cliente::existe($uid, $d['documento'])) {
            return 'Ya existe un cliente con ese documento.';
        }
        Cliente::crear($uid, $d);
        header('Location: index.php?page=clientes&ok=1');
        exit;
    }

    public static function eliminar(): void
    {
        Cliente::eliminar($_SESSION['usuario']['id'], (int) ($_POST['id'] ?? 0));
        header('Location: index.php?page=clientes');
        exit;
    }
}