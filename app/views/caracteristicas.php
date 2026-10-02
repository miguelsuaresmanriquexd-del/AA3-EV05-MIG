<?php
$planes = Inversion::planes();
$items = [
    ['Acceso protegido', 'Claves cifradas y sesiones seguras para cada inversor.'],
    ['Rendimientos claros', 'Cada plan muestra su tasa, plazo y ganancia estimada antes de invertir.'],
    ['Planes por perfil', 'Opciones de riesgo bajo, medio y alto según su tolerancia.'],
    ['Control total', 'Consulte y cancele sus inversiones activas desde un solo panel.'],
];
?>
<div class="mb-8">
    <h1 class="text-2xl font-extrabold tracking-tight">Características</h1>
    <p class="text-sm text-zinc-400 mt-1">Lo que ofrece Futuro Inversión y los planes disponibles.</p>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <?php foreach ($items as [$t, $d]): ?>
        <div class="bg-white border border-zinc-200 rounded-2xl p-6">
            <div class="w-8 h-1 bg-zinc-900 rounded-full mb-5"></div>
            <h3 class="text-sm font-bold"><?= $t ?></h3>
            <p class="text-xs text-zinc-500 leading-relaxed mt-2"><?= $d ?></p>
        </div>
    <?php endforeach; ?>
</div>

<div class="bg-white border border-zinc-200 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-zinc-100">
        <h2 class="text-sm font-bold">Planes disponibles</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-zinc-50 text-xs uppercase tracking-wider text-zinc-500">
                <tr>
                    <th class="<?= $th ?>">Plan</th>
                    <th class="<?= $th ?>">Rendimiento anual</th>
                    <th class="<?= $th ?>">Plazo</th>
                    <th class="<?= $th ?>">Monto mínimo</th>
                    <th class="<?= $th ?>">Riesgo</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                <?php foreach ($planes as $p): ?>
                    <tr class="hover:bg-zinc-50/60 transition-colors">
                        <td class="<?= $td ?> font-bold"><?= e($p['nombre']) ?></td>
                        <td class="<?= $td ?> tabular-nums"><?= $p['rendimiento'] ?>%</td>
                        <td class="<?= $td ?> text-zinc-500"><?= $p['plazo_meses'] ?> meses</td>
                        <td class="<?= $td ?> tabular-nums"><?= dinero($p['minimo']) ?></td>
                        <td class="<?= $td ?> text-zinc-500"><?= e($p['riesgo']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8 grid lg:grid-cols-2 gap-5">
    <div class="bg-white border border-zinc-200 rounded-2xl p-6">
        <h2 class="text-sm font-bold mb-6">Cómo funciona</h2>
        <ol class="space-y-6">
            <?php foreach ([
                ['Elija un plan', 'Compare rendimiento, plazo y riesgo en la tabla de planes.'],
                ['Defina el monto', 'Ingrese cuánto invertir y revise la ganancia estimada al instante.'],
                ['Siga su portafolio', 'Vea sus totales, vencimientos y cancele cuando lo necesite.'],
            ] as $n => [$t, $d]): ?>
                <li class="flex gap-4">
                    <span class="w-7 h-7 shrink-0 rounded-full bg-zinc-950 text-white text-xs font-bold flex items-center justify-center"><?= $n + 1 ?></span>
                    <div>
                        <p class="text-sm font-bold"><?= $t ?></p>
                        <p class="text-xs text-zinc-500 leading-relaxed mt-1"><?= $d ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>

    <div class="bg-white border border-zinc-200 rounded-2xl p-6">
        <h2 class="text-sm font-bold mb-4">Preguntas frecuentes</h2>
        <?php foreach ([
            ['¿Cómo se calcula la ganancia estimada?', 'Monto por rendimiento anual por plazo en meses, dividido entre 12. Es una proyección, no una garantía.'],
            ['¿Puedo cancelar una inversión?', 'Sí. Mientras esté activa, puede cancelarla desde la sección Inversiones.'],
            ['¿Qué es el monto mínimo?', 'Es el valor más bajo con el que se puede abrir una inversión en cada plan.'],
            ['¿Para qué sirve la sección Clientes?', 'Para llevar el registro de las personas que usted asesora, con sus datos de contacto.'],
        ] as [$q, $r]): ?>
            <details class="group border-t border-zinc-100 py-4">
                <summary class="flex justify-between items-center cursor-pointer text-xs font-bold list-none">
                    <?= $q ?>
                    <span class="text-zinc-400 group-open:rotate-45 transition-transform text-base leading-none">+</span>
                </summary>
                <p class="text-xs text-zinc-500 leading-relaxed mt-3"><?= $r ?></p>
            </details>
        <?php endforeach; ?>
    </div>
</div>
