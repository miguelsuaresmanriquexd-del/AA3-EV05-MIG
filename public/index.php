<?php
session_start();
$base = dirname(__DIR__);

require $base . '/config/conexion.php';
require $base . '/app/models/Usuario.php';
require $base . '/app/models/Inversion.php';
require $base . '/app/models/Cliente.php';
require $base . '/app/controllers/AuthController.php';
require $base . '/app/controllers/InversionController.php';
require $base . '/app/controllers/ClienteController.php';
foreach (['Proveedor', 'Producto', 'Operacion'] as $m) {
    require $base . "/app/models/$m.php";
}
foreach (['Proveedor', 'Producto', 'Operacion', 'Usuario'] as $c) {
    require $base . "/app/controllers/{$c}Controller.php";
}

function e($v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
}

function dinero($v): string
{
    return '$' . number_format((float) $v, 2, ',', '.');
}

function badge(string $s): string
{
    $c = $s === 'Activa' ? 'bg-zinc-900 text-white' : 'bg-zinc-100 text-zinc-400';
    return '<span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider ' . $c . '">' . e($s) . '</span>';
}

if (($_GET['page'] ?? '') === 'salir') {
    AuthController::salir();
}

$publicas = ['login', 'registro'];
$privadas = ['home', 'inversiones', 'clientes', 'proveedores', 'productos', 'ventas', 'compras', 'usuarios', 'caracteristicas'];
$page = $_GET['page'] ?? 'home';
if (!in_array($page, array_merge($publicas, $privadas), true)) {
    $page = 'home';
}

$logueado = isset($_SESSION['usuario']);
if (!$logueado && in_array($page, $privadas, true)) {
    header('Location: index.php?page=login');
    exit;
}
if ($logueado && in_array($page, $publicas, true)) {
    header('Location: index.php?page=home');
    exit;
}

$permisos = $logueado ? Usuario::permisos($_SESSION['usuario']['id']) : [];
$modulos = ['clientes', 'proveedores', 'productos', 'ventas', 'compras', 'usuarios'];
if (in_array($page, $modulos, true) && !in_array($page, $permisos, true)) {
    header('Location: index.php?page=home');
    exit;
}

$acciones = [
    'eliminar_cliente' => ['clientes', fn() => ClienteController::eliminar()],
    'guardar_proveedor' => ['proveedores', fn() => ProveedorController::guardar()],
    'eliminar_proveedor' => ['proveedores', fn() => ProveedorController::eliminar()],
    'guardar_producto' => ['productos', fn() => ProductoController::guardar()],
    'eliminar_producto' => ['productos', fn() => ProductoController::eliminar()],
    'registrar_venta' => ['ventas', fn() => OperacionController::registrar('venta')],
    'registrar_compra' => ['compras', fn() => OperacionController::registrar('compra')],
    'cambiar_rol' => ['usuarios', fn() => UsuarioController::cambiarRol()],
];

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    if ($accion === 'login') {
        $error = AuthController::login();
    } elseif ($accion === 'registro') {
        $error = AuthController::registro();
    } elseif ($logueado && $accion === 'invertir') {
        $error = InversionController::crear();
    } elseif ($logueado && $accion === 'cancelar') {
        InversionController::cancelar();
    } elseif ($logueado && $accion === 'guardar_cliente') {
        $error = ClienteController::guardar();
    } elseif ($logueado && isset($acciones[$accion]) && in_array($acciones[$accion][0], $permisos, true)) {
        try {
            $error = $acciones[$accion][1]();
        } catch (PDOException $ex) {
            $error = 'No se pudo completar la acción. Verifique que el registro no tenga movimientos asociados.';
        }
    }
}

$label = 'block text-xs font-bold tracking-wider text-zinc-500 uppercase mb-2';
$input = 'w-full px-4 py-3 border border-zinc-200 rounded-xl text-sm bg-white focus:outline-none focus:border-zinc-900 transition-colors';
$btn = 'w-full bg-zinc-950 text-white py-3.5 rounded-xl font-bold text-xs tracking-widest uppercase hover:bg-zinc-800 transition-colors';
$th = 'px-6 py-3 text-left font-bold whitespace-nowrap';
$td = 'px-6 py-4 whitespace-nowrap';
$aviso = 'mb-6 text-xs font-medium text-zinc-700 bg-zinc-100 border border-zinc-200 rounded-xl px-4 py-3';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Futuro Inversión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body{font-family:'Inter',sans-serif}</style>
</head>
<body class="bg-[#f8f9fa] text-zinc-900 antialiased min-h-screen">
<?php if ($logueado): ?>
    <header class="bg-white border-b border-zinc-200">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between gap-4">
            <div class="flex items-center gap-8">
                <a href="index.php?page=home" class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-zinc-950 text-white flex items-center justify-center text-sm font-extrabold">F</span>
                    <span class="font-extrabold tracking-tight hidden sm:inline">Futuro Inversión</span>
                </a>
                <nav class="flex gap-5 h-16">
                    <?php
                    $gestion = array_intersect_key(['clientes' => 'Clientes', 'proveedores' => 'Proveedores', 'productos' => 'Productos', 'ventas' => 'Ventas', 'compras' => 'Compras'], array_flip($permisos));
                    $enlace = fn($k, $t) => '<a href="index.php?page=' . $k . '" class="flex items-center text-xs font-bold uppercase tracking-wider border-b-2 ' . ($page === $k ? 'text-zinc-900 border-zinc-900' : 'text-zinc-400 border-transparent hover:text-zinc-900') . '">' . $t . '</a>';
                    echo $enlace('home', 'Inicio'), $enlace('inversiones', 'Inversiones');
                    ?>
                    <?php if ($gestion): ?>
                        <div class="relative group flex">
                            <span tabindex="0" class="flex items-center text-xs font-bold uppercase tracking-wider border-b-2 cursor-default <?= isset($gestion[$page]) ? 'text-zinc-900 border-zinc-900' : 'text-zinc-400 border-transparent group-hover:text-zinc-900' ?>">Gestión</span>
                            <div class="absolute left-0 top-full hidden group-hover:block group-focus-within:block w-44 bg-white border border-zinc-200 rounded-xl shadow-xl shadow-zinc-100/40 py-2 z-20">
                                <?php foreach ($gestion as $k => $t): ?>
                                    <a href="index.php?page=<?= $k ?>" class="block px-4 py-2 text-xs font-bold <?= $page === $k ? 'text-zinc-900 bg-zinc-50' : 'text-zinc-500 hover:text-zinc-900 hover:bg-zinc-50' ?>"><?= $t ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php
                    echo $enlace('caracteristicas', 'Características');
                    if (in_array('usuarios', $permisos, true)) {
                        echo $enlace('usuarios', 'Usuarios');
                    }
                    ?>
                </nav>
            </div>
            <div class="flex items-center gap-4 text-xs">
                <span class="text-zinc-500 font-medium hidden sm:inline"><?= e($_SESSION['usuario']['nombre']) ?></span>
                <a href="index.php?page=salir" class="font-bold text-zinc-900 hover:underline">Salir</a>
            </div>
        </div>
    </header>
    <main class="max-w-6xl mx-auto px-6 py-10">
        <?php include $base . '/app/views/' . $page . '.php'; ?>
    </main>
<?php else: ?>
    <?php include $base . '/app/views/' . $page . '.php'; ?>
<?php endif; ?>
</body>
</html>