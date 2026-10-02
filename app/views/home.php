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
