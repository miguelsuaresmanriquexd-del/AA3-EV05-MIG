<?php
class AuthController
{
    public static function login(): string
    {
        $u = Usuario::buscarPorEmail(trim($_POST['email'] ?? ''));
        if ($u && password_verify($_POST['clave'] ?? '', $u['clave'])) {
            session_regenerate_id(true);
            $_SESSION['usuario'] = ['id' => (int) $u['id'], 'nombre' => $u['nombre']];
            header('Location: index.php?page=home');
            exit;
        }
        return 'Correo o clave incorrectos.';
    }

    public static function registro(): string
    {
        $n = trim($_POST['nombre'] ?? '');
        $e = trim($_POST['email'] ?? '');
        $c = $_POST['clave'] ?? '';
        if ($n === '' || !filter_var($e, FILTER_VALIDATE_EMAIL) || strlen($c) < 6) {
            return 'Complete todos los campos. La clave debe tener mínimo 6 caracteres.';
        }
        if (Usuario::buscarPorEmail($e)) {
            return 'Este correo ya tiene una cuenta.';
        }
        Usuario::crear($n, $e, $c);
        header('Location: index.php?page=login&ok=1');
        exit;
    }

    public static function salir(): void
    {
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
}