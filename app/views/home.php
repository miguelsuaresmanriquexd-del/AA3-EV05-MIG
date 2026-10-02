<<<<<<< HEAD
<?php
$uid = $_SESSION['usuario']['id'];
$r = Inversion::resumen($uid);
$ultimas = array_slice(Inversion::listar($uid), 0, 5);
$tarjetas = [
    ['Capital invertido', dinero($r['invertido'])],
    ['Ganancia estimada', dinero($r['ganancia'])],
    ['Inversiones activas', $r['total']],
    ['Clientes registrados', Cliente::total($uid)],
];
?>
<div class="mb-8">
    <h1 class="text-2xl font-extrabold tracking-tight">Hola, <?= e(explode(' ', $_SESSION['usuario']['nombre'])[0]) ?></h1>
    <p class="text-sm text-zinc-400 mt-1">Este es el estado actual de su portafolio.</p>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <?php foreach ($tarjetas as [$t, $v]): ?>
        <div class="bg-white border border-zinc-200 rounded-2xl p-6">
            <p class="text-xs font-bold tracking-wider text-zinc-400 uppercase"><?= $t ?></p>
            <p class="text-2xl font-extrabold mt-3 tabular-nums"><?= $v ?></p>
        </div>
    <?php endforeach; ?>
</div>

<div class="bg-white border border-zinc-200 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 flex items-center justify-between border-b border-zinc-100">
        <h2 class="text-sm font-bold">Últimas inversiones</h2>
        <a href="index.php?page=inversiones" class="text-xs font-bold text-zinc-400 hover:text-zinc-900 transition-colors">Ver todas</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-zinc-50 text-xs uppercase tracking-wider text-zinc-500">
                <tr>
                    <th class="<?= $th ?>">Plan</th>
                    <th class="<?= $th ?>">Monto</th>
                    <th class="<?= $th ?>">Ganancia est.</th>
                    <th class="<?= $th ?>">Fecha</th>
                    <th class="<?= $th ?>">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                <?php foreach ($ultimas as $i): ?>
                    <tr class="hover:bg-zinc-50/60 transition-colors">
                        <td class="<?= $td ?> font-bold"><?= e($i['plan']) ?></td>
                        <td class="<?= $td ?> tabular-nums"><?= dinero($i['monto']) ?></td>
                        <td class="<?= $td ?> tabular-nums text-zinc-500"><?= dinero($i['ganancia']) ?></td>
                        <td class="<?= $td ?> text-zinc-500"><?= date('d/m/Y', strtotime($i['creado'])) ?></td>
                        <td class="<?= $td ?>"><?= badge($i['estado']) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$ultimas): ?>
                    <tr><td colspan="5" class="px-6 py-12 text-center text-xs text-zinc-400">Aún no tiene inversiones. Cree la primera en la sección Inversiones.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$dist = Inversion::porPlan($uid);
$suma = array_sum(array_column($dist, 'total'));
$venc = Inversion::vencimientos($uid);
?>
<div class="mt-8 grid lg:grid-cols-2 gap-5">
    <div class="bg-white border border-zinc-200 rounded-2xl p-6">
        <h2 class="text-sm font-bold mb-6">Distribución del capital</h2>
        <?php foreach ($dist as $d): $pct = $suma > 0 ? round($d['total'] / $suma * 100) : 0; ?>
            <div class="mb-5 last:mb-0">
                <div class="flex justify-between text-xs mb-2">
                    <span class="font-bold"><?= e($d['plan']) ?></span>
                    <span class="text-zinc-500 tabular-nums"><?= dinero($d['total']) ?> (<?= $pct ?>%)</span>
                </div>
                <div class="h-2 bg-zinc-100 rounded-full overflow-hidden">
                    <div class="h-full bg-zinc-900 rounded-full" style="width:<?= $pct ?>%"></div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (!$dist): ?>
            <p class="py-8 text-center text-xs text-zinc-400">Todavía no hay capital invertido.</p>
        <?php endif; ?>
    </div>

    <div class="bg-white border border-zinc-200 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-zinc-100">
            <h2 class="text-sm font-bold">Próximos vencimientos</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-zinc-50 text-xs uppercase tracking-wider text-zinc-500">
                    <tr>
                        <th class="<?= $th ?>">Plan</th>
                        <th class="<?= $th ?>">Monto</th>
                        <th class="<?= $th ?>">Vence</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    <?php foreach ($venc as $v): ?>
                        <tr class="hover:bg-zinc-50/60 transition-colors">
                            <td class="<?= $td ?> font-bold"><?= e($v['plan']) ?></td>
                            <td class="<?= $td ?> tabular-nums"><?= dinero($v['monto']) ?></td>
                            <td class="<?= $td ?> text-zinc-500"><?= date('d/m/Y', strtotime($v['vence'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (!$venc): ?>
                        <tr><td colspan="3" class="px-6 py-12 text-center text-xs text-zinc-400">No hay inversiones activas por vencer.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
=======
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Futuro Inversión</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <!-- Header -->
    <header class="encabezado">
        <h1>Futuro Inversión</h1>
        <p>Multiplica tu capital con soluciones financieras estratégicas y seguras</p>
    </header>

    <!-- Menú principal de navegación con Dropdown -->
    <nav class="menu">
        <a href="index.php?page=home">Inicio</a>
        <div class="dropdown">
            <a href="#">Módulos ▼</a>
            <div class="dropdown-content">
                <a href="#">Clientes</a>
                <a href="#">Productos</a>
                <a href="#">Proveedores</a>
            </div>
        </div>
        <a href="index.php?page=login">Iniciar Sesión</a>
    </nav>

    <!-- Contenido Principal -->
    <main class="contenido">
        
        <!-- Sección 1: ¿Qué hace Futuro Inversión? -->
        <section class="caja">
          <h2>¿Qué hace Futuro Inversión?</h2>
          <p>Somos una plataforma integral de **gestión y asesoría financiera** dedicada a conectar a inversionistas con las mejores oportunidades del mercado. Nos encargamos de analizar, estructurar y diversificar portafolios de inversión para minimizar el riesgo y maximizar tus rendimientos a corto, mediano y largo plazo.</p>
          <p>Nuestra misión es hacer que el mundo de las inversiones sea accesible, transparente y altamente rentable para personas y empresas que buscan asegurar su libertad financiera.</p>
        </section>

        <!-- Sección 2: Nuestros Productos Financieros -->
        <section class="caja">
          <h2>Nuestros Productos de Inversión</h2>
          <p>Ofrecemos diferentes soluciones que se adaptan a tu perfil de riesgo y metas financieras:</p>
          <ul>
              <li><strong>Fondo de Renta Fija:</strong> Ideal para perfiles conservadores. Obtén una rentabilidad pactada desde el inicio con total estabilidad.</li>
              <li><strong>Portafolio de Renta Variable:</strong> Diseñado para perfiles moderados y agresivos que buscan altos rendimientos mediante acciones y ETFs de mercados globales.</li>
              <li><strong>Inversiones Inmobiliarias:</strong> Participa en proyectos de propiedad raíz con alta valorización y dividendos por arrendamientos sin necesidad de comprar un inmueble completo.</li>
              <li><strong>Planes de Retiro Programado:</strong> Estructuras de ahorro e inversión a largo plazo con beneficios fiscales para asegurar tu futuro.</li>
          </ul>
        </section>

        <!-- Sección 3: Datos e Información del Proyecto (Requisito SENA) -->
        <section class="caja">
            <h2>Datos del Proyecto</h2>
            <p>Este sistema de información representa la fase de maquetación y diseño Front-End para el proyecto formativo de la competencia de desarrollo de software.</p>
            <ul>
                <li><strong>Programa:</strong> Análisis y Desarrollo de Software (ADSO).</li>
                <li><strong>Ficha de Caracterización:</strong> 228118 / Competencia 220501096.</li>
                <li><strong>Objetivo Tecnológico:</strong> Implementar una arquitectura escalable bajo el patrón MVC, integrando componentes semánticos de HTML5, estilos responsivos en CSS3 y persistencia de datos relacionales en MySQL.</li>
                <li><strong>Estado del Sistema:</strong> Prototipo funcional de la interfaz de usuario listo para la integración del backend en PHP.</li>
            </ul>
        </section>

        <!-- Sección 4: Información de Contacto -->
        <section class="caja">
            <h2>Contacto y Asesoría Personalizada</h2>
            <p>Si tienes dudas sobre nuestros productos financieros o deseas agendar una cita con un asesor, déjanos tus datos a través de los siguientes canales o utiliza nuestro formulario:</p>
            
            <ul>
                <li><strong>Teléfono / WhatsApp:</strong> +57 300 123 4567</li>
                <li><strong>Correo Electrónico:</strong> soporte@futuroinversion.com</li>
                <li><strong>Oficina Central:</strong> Medellín, Colombia</li>
            </ul>

            <!-- Formulario estructurado exactamente con tus clases CSS -->
            <form action="#" method="POST" class="formulario-contacto">
                <div class="campo-form">
                    <label for="nombre_contacto">Nombre Completo:</label>
                    <input type="text" id="nombre_contacto" name="nombre_contacto" placeholder="Tu nombre y apellido" required>
                </div>

                <div class="campo-form">
                    <label for="correo_contacto">Correo Electrónico:</label>
                    <input type="email" id="correo_contacto" name="correo_contacto" placeholder="ejemplo@correo.com" required>
                </div>

                <div class="campo-form">
                    <label for="mensaje_contacto">Mensaje o Consulta:</label>
                    <textarea id="mensaje_contacto" name="mensaje_contacto" rows="4" placeholder="Cuéntanos en qué producto estás interesado..." required></textarea>
                </div>

                <div style="margin-top: 10px;">
                    <button type="submit" class="btn">Enviar Mensaje</button>
                </div>
            </form>
        </section>

    </main>

    <!-- Pie de página -->
    <footer class="pie">
        <p>&copy; 2026 - Futuro Inversión. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
>>>>>>> 04e403dd66e2391ced03e1415f39bbe388413d0e
