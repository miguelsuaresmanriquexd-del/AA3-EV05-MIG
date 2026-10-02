<?php
class UsuarioController
{
    public static function cambiarRol(): string
    {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id === $_SESSION['usuario']['id']) {
            return 'No puede cambiar su propio rol.';
        }
        Usuario::cambiarRol($id, (int) ($_POST['rol_id'] ?? 0));
        header('Location: index.php?page=usuarios&ok=1');
        exit;
    }
}